<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\State;
use App\Models\Setting;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use App\Services\StockAlertService;
use Illuminate\Support\Facades\Log;
use App\Services\Tracking\CartTracker;

class CheckoutController extends Controller
{

    // Inject in constructor
    public function __construct(protected StockAlertService $alertService)
    {
    }

    public function checkout()
    {
        $customer = auth('customer')->user(); // guest ke liye null

        $cartQuery = Cart::with([
            'items.product.images',
            'items.product.category',
            'items.priceVariant',
            'items.addons',
        ]);

        $cart = $customer
            ? $cartQuery->where('user_id', $customer->id)->first()
            : $cartQuery->where('session_id', session()->getId())->whereNull('user_id')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $cart->recalculateTotals();
        $cart->refresh();
        CartTracker::track('checkout_viewed', $cart, [], 30); // refresh par duplicate nahi

        $addresses = $customer
            ? $customer->addresses()->with(['state', 'city'])->orderByDesc('is_default')->get()
            : collect();

        $defaultAddress = $addresses->firstWhere('is_default', true);

        $states = State::orderBy('name')->get();

        $beginCheckoutScript = \App\Services\Tracking\PixelTracker::beginCheckoutScript($cart);

        return view(
            'front-pages.checkout',
            compact('cart', 'customer', 'addresses', 'defaultAddress', 'states', 'beginCheckoutScript')
        );
    }

    public function storeAddress(Request $request)
    {
        $customer = auth('customer')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'pincode' => ['required', 'regex:/^\d{6}$/'],
            'address_type' => 'nullable|in:home,office',
        ], [
            'phone.regex' => 'Enter a valid 10 digit mobile number.',
            'pincode.regex' => 'Enter a valid 6 digit pincode.',
        ]);

        DB::transaction(function () use ($customer, $validated) {

            CustomerAddress::where('customer_id', $customer->id)
                ->update(['is_default' => 0]);

            CustomerAddress::create([
                'customer_id' => $customer->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'country' => 'India',
                'state_id' => $validated['state_id'],
                'city_id' => $validated['city_id'],
                'pincode' => $validated['pincode'],
                'address_type' => $validated['address_type'] ?? 'home',
                'is_default' => 1,
            ]);
        });

        $cart = Cart::where('user_id', $customer->id)->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        return response()->json(['success' => true]);
    }

    public function changeDefaultAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|integer',
        ]);

        $customer = auth('customer')->user();

        // Pehle ownership check, tabhi baaki addresses reset honge
        $address = CustomerAddress::where('customer_id', $customer->id)
            ->findOrFail($request->address_id);

        DB::transaction(function () use ($customer, $address) {
            CustomerAddress::where('customer_id', $customer->id)
                ->update(['is_default' => 0]);

            $address->update(['is_default' => 1]);
        });

        $cart = Cart::where('user_id', $customer->id)->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        return response()->json(['success' => true]);
    }


    public function placeOrder(Request $request)
    {
        $customer = auth('customer')->user();

        $request->validate([
            'payment_method' => 'required|in:cod,razorpay',
        ]);

        // COD sirf tab jab admin ne enable kiya ho (blade check bypass ho sakta hai)
        // NOTE: agar cod_enabled kisi aur model/table mein hai to yahan wahi use karo
        if ($request->payment_method === 'cod' && !optional(Setting::first())->cod_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Cash on Delivery is not available.',
            ]);
        }

        $address = null;

        /* Existing Address */
        if ($request->filled('address_id')) {
            $address = CustomerAddress::where('customer_id', $customer->id)
                ->find($request->address_id);
        }

        /* Create Address If Not Exists */
        if (!$address) {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required',
                'address_line_1' => 'required',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'pincode' => 'required',
            ]);

            CustomerAddress::where('customer_id', $customer->id)
                ->update(['is_default' => 0]);

            $address = CustomerAddress::create([
                'customer_id' => $customer->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'country' => 'India',
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'address_type' => 'home',
                'is_default' => 1,
            ]);
        }

        /* Hamesha latest address ke hisaab se GST recalc */
        $cart = Cart::where('user_id', $customer->id)->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        $cart = Cart::with([
            'items.product',
            'items.addons',
        ])
            ->where('user_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        DB::beginTransaction();

        try {

            $order = Order::create([
                'customer_id' => $customer->id,
                'address_id' => $address->id,

                'order_number' => 'ORD-' . strtoupper(uniqid()),

                'customer_name' => $address->name,
                'customer_email' => $address->email,
                'customer_phone' => $address->phone,

                'address_line_1' => $address->address_line_1,
                'address_line_2' => $address->address_line_2,

                'state_id' => $address->state_id,
                'city_id' => $address->city_id,
                'pincode' => $address->pincode,

                'coupon_code' => $cart->coupon_code,

                'subtotal' => $cart->subtotal,
                'discount' => $cart->discount,
                'tax_amount' => $cart->tax_amount,
                'grand_total' => $cart->grand_total,

                'gst_type' => $cart->gst_type,

                'cgst_rate' => $cart->cgst_rate,
                'sgst_rate' => $cart->sgst_rate,
                'igst_rate' => $cart->igst_rate,

                'cgst_amount' => $cart->cgst_amount,
                'sgst_amount' => $cart->sgst_amount,
                'igst_amount' => $cart->igst_amount,

                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            $order->statusHistory()->create([
                'status' => 'pending',
                'remarks' => 'Order placed successfully',
            ]);

            \App\Models\Notification::create([
                'customer_id' => $customer->id,
                'title' => 'Order Placed',
                'message' => 'Your order ' . $order->order_number . ' has been placed successfully.',
                'icon' => 'fa-cart-shopping',
                'color' => 'order-icon',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => 'pending',
                ],
            ]);

            foreach ($cart->items as $item) {

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,

                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,

                    'selected_attributes' => $item->selected_attributes,

                    'product_name' => $item->product->name ?? 'Product',
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,

                    'custom_colour_code' => $item->custom_colour_code,
                    'dye_charge' => $item->dye_charge ?? 0,
                ]);

                foreach ($item->addons as $addon) {
                    $orderItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }

            /* COD Order */
            if ($request->payment_method == 'cod') {

                app(\App\Services\InvoiceService::class)->createIfAuto($order);

                $cart->items()->delete();
                $cart->delete();

                $this->deductOrderStock($order);

                DB::commit();

                CartTracker::track('order_placed', $cart, [
                    'order_number' => $order->order_number,
                    'method' => 'cod',
                    'amount' => (float) $order->grand_total,
                ]);

                \App\Jobs\SendMetaCapiPurchase::dispatchAfterResponse(
                    $order->id,
                    $request->ip(),
                    $request->userAgent(),
                    $request->cookie('_fbp'),
                    $request->cookie('_fbc'),
                );

                $this->sendOrderEmails($order);

                return response()->json([
                    'success' => true,
                    'type' => 'cod',
                    'message' => 'Order placed successfully.',
                    'redirect_url' => route('order.success', $order->id)
                ]);
            }

            /* Razorpay Order */
            $paymentSetting = PaymentSetting::first();

            $keyId = $paymentSetting->live_mode
                ? $paymentSetting->live_key_id
                : $paymentSetting->test_key_id;

            $keySecret = $paymentSetting->live_mode
                ? $paymentSetting->live_key_secret
                : $paymentSetting->test_key_secret;

            $api = new Api($keyId, $keySecret);

            $razorpayOrder = $api->order->create([
                'receipt' => $order->order_number,
                'amount' => round($order->grand_total * 100),
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            $order->update([
                'razorpay_order_id' => $razorpayOrder['id']
            ]);

            DB::commit();

            CartTracker::track('payment_started', $cart, [
                'order_number' => $order->order_number,
                'method' => 'razorpay',
                'amount' => (float) $order->grand_total,
            ]);

            return response()->json([
                'success' => true,
                'type' => 'razorpay',
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => round($order->grand_total * 100),
                'key' => $keyId,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('placeOrder failed: ' . $e->getMessage(), [
                'customer_id' => $customer->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to place order right now. Please try again.'
            ]);
        }
    }


    public function razorpaySuccess(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        DB::beginTransaction();

        try {

            // Sirf is customer ka order, aur row lock taaki double-submit na ho
            $order = Order::with('items')
                ->where('customer_id', auth('customer')->id())
                ->lockForUpdate()
                ->findOrFail($request->order_id);

            // Payment isi order ka hona chahiye
            if ($order->razorpay_order_id !== $request->razorpay_order_id) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment details.'
                ], 422);
            }

            // Already processed (refresh / double click / webhook)
            if ($order->payment_status === 'paid') {
                DB::rollBack();

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('order.success', $order->id),
                ]);
            }

            /* Verify Signature */
            $paymentSetting = PaymentSetting::first();

            $keyId = $paymentSetting->live_mode
                ? $paymentSetting->live_key_id
                : $paymentSetting->test_key_id;

            $keySecret = $paymentSetting->live_mode
                ? $paymentSetting->live_key_secret
                : $paymentSetting->test_key_secret;

            $api = new Api($keyId, $keySecret);

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            /* Mark Order Paid */
            $order->update([
                'payment_status' => 'paid',
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'transaction_id' => $request->razorpay_payment_id,
                'status' => 'processing',
            ]);

            $order->statusHistory()->create([
                'status' => 'processing',
                'remarks' => 'Payment received successfully via Razorpay',
            ]);

            \App\Models\Notification::create([
                'customer_id' => $order->customer_id,
                'title' => 'Payment Successful',
                'message' => 'Payment received for order ' . $order->order_number . '. Your order is now being processed.',
                'icon' => 'fa-credit-card',
                'color' => 'success-icon',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => 'processing',
                ],
            ]);

            /* Generate Invoice (only if auto-generate is ON) */
            if (!$order->invoice) {
                app(\App\Services\InvoiceService::class)->createIfAuto($order);
            }

            /* Clear Cart */
            $cart = Cart::where('user_id', $order->customer_id)->first();

            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            $this->deductOrderStock($order);

            DB::commit();

            CartTracker::track('order_placed', $cart ?? null, [
                'order_number' => $order->order_number,
                'method' => 'razorpay',
                'amount' => (float) $order->grand_total,
            ]);

            \App\Jobs\SendMetaCapiPurchase::dispatchAfterResponse(
                $order->id,
                $request->ip(),
                $request->userAgent(),
                $request->cookie('_fbp'),
                $request->cookie('_fbc'),
            );

            $this->sendOrderEmails($order);

            return response()->json([
                'success' => true,
                'redirect_url' => route('order.success', $order->id),
            ]);

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {

            DB::rollBack();

            Log::warning('Razorpay signature failed: ' . $e->getMessage(), [
                'order_id' => $request->order_id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.'
            ], 422);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('razorpaySuccess failed: ' . $e->getMessage(), [
                'order_id' => $request->order_id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to confirm payment. If money was deducted, please contact support.'
            ], 422);
        }
    }

    public function orderSuccess($id)
    {
        $order = Order::with(['items', 'state', 'city'])
            ->where('customer_id', auth('customer')->id())
            ->findOrFail($id);

        // Refresh par Purchase event dobara fire na ho
        $purchaseScript = null;
        $sessionKey = 'purchase_tracked_' . $order->id;

        if (!session()->has($sessionKey)) {
            $purchaseScript = \App\Services\Tracking\PixelTracker::purchaseScript($order);
            session()->put($sessionKey, true);
        }

        return view(
            'front-pages.thank-you',
            compact('order', 'purchaseScript')
        );
    }


    protected function sendOrderEmails(Order $order): void
    {
        $order->loadMissing([
            'items.product',
            'state',
            'city',
        ]);

        /*
         |--------------------------------------------------------------------------
         | Order Items HTML
         |--------------------------------------------------------------------------
         */
        $orderItems = '';

        foreach ($order->items as $item) {

            // Thumbnail: image variant > product default image > null (matches admin blade)
            $thumb = null;
            if ($item->imageVariant && $item->imageVariant->image) {
                $thumb = asset('storage/' . $item->imageVariant->image);
            } elseif ($item->product) {
                $thumb = $item->product->display_image;
            }

            $imageHtml = $thumb
                ? "<img src='{$thumb}' alt='{$item->product_name}' style='width:56px;height:56px;object-fit:cover;border-radius:4px;border:1px solid #d0d8d7;display:block;'>"
                : "<span style='display:block;width:56px;height:56px;background:#e8efee;border-radius:4px;border:1px solid #d0d8d7;'></span>";

            // Variant label from selected_attributes snapshot (same logic as admin blade)
            $variantLabel = null;
            if (!empty($item->selected_attributes)) {
                $variantLabel = collect($item->selected_attributes)
                    ->map(function ($value, $key) {
                        if (is_array($value)) {
                            $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                            $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                            return $attrName . ': ' . $attrVal;
                        }
                        return $key . ': ' . $value;
                    })
                    ->join(' · ');
            }

            $variantHtml = $variantLabel
                ? "<div style='font-size:11px;color:#7a9e9c;'>{$variantLabel}</div>"
                : '';

            // SKU: sku variant > snapshot sku > product sku
            $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);
            $skuHtml = $sku
                ? "<div style='font-size:11px;color:#7a9e9c;'>SKU: {$sku}</div>"
                : '';

            // Custom colour code + its per-unit dye charge (snapshot from order item)
            $dyeCharge = (float) $item->dye_charge;

            $colourHtml = '';
            if ($item->custom_colour_code) {
                $colourHtml = "<div style='font-size:11px;color:#7a9e9c;'>Custom Colour Code: " . e($item->custom_colour_code);

                if ($dyeCharge > 0) {
                    $colourHtml .= " (+₹" . number_format($dyeCharge, 2) . "/pc dye charge)";
                }

                $colourHtml .= "</div>";
            }

            // Line total: order_items.total already = qty × (price + addons + dye),
            // so use it directly instead of recomputing (addons/dye are per-unit).
            $lineTotal = $item->total;

            $addonsHtml = '';
            if ($item->addons->isNotEmpty()) {
                foreach ($item->addons as $addon) {
                    $addonsHtml .= "<div style='font-size:11px;color:#7a9e9c;'>+ {$addon->detail} (₹" . number_format($addon->price, 2) . ")</div>";
                }
            }

            $orderItems .= "
    <div style='display:table;width:100%;border-bottom:1px solid #e6eae9;padding:14px 0;'>
        <div style='display:table-cell;width:60px;vertical-align:middle;padding-right:14px;'>
            {$imageHtml}
        </div>
        <div style='display:table-cell;vertical-align:middle;'>
            <div style='font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:3px;'>{$item->product_name}</div>
            {$variantHtml}
            {$skuHtml}
            {$colourHtml}
            <div style='font-size:11px;color:#7a9e9c;'>Qty: {$item->quantity}</div>
            {$addonsHtml}
        </div>
        <div style='display:table-cell;vertical-align:middle;text-align:right;font-size:14px;font-weight:700;color:#1F5552;white-space:nowrap;'>
            ₹ " . number_format($lineTotal, 2) . "
        </div>
    </div>
";
        }
        /*
        |--------------------------------------------------------------------------
        | Order Summary HTML
        |--------------------------------------------------------------------------
        */
        $orderSummary = "
        <div style='margin-top:16px;'>
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:13px;color:#666;'>Subtotal</span>
                <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                    ₹ " . number_format($order->subtotal, 2) . "
                </span>
            </div>
    ";

        if ($order->discount > 0) {
            $discountLabel = 'Discount' . ($order->coupon_code ? " ({$order->coupon_code})" : '');
            $orderSummary .= "
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:13px;color:#2e7d32;font-weight:500;'>{$discountLabel}</span>
                <span style='display:table-cell;text-align:right;font-size:13px;color:#2e7d32;font-weight:500;'>
                    − ₹ " . number_format($order->discount, 2) . "
                </span>
            </div>
        ";
        }

        if ($order->tax_amount > 0) {

            if ($order->gst_type === 'igst' && $order->igst_amount > 0) {

                $orderSummary .= "
                <div style='display:table;width:100%;padding:5px 0;'>
                    <span style='display:table-cell;font-size:13px;color:#666;'>IGST ({$order->igst_rate}%)</span>
                    <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                        ₹ " . number_format($order->igst_amount, 2) . "
                    </span>
                </div>
            ";

            } else {

                if ($order->cgst_amount > 0) {
                    $orderSummary .= "
                    <div style='display:table;width:100%;padding:5px 0;'>
                        <span style='display:table-cell;font-size:13px;color:#666;'>CGST ({$order->cgst_rate}%)</span>
                        <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                            ₹ " . number_format($order->cgst_amount, 2) . "
                        </span>
                    </div>
                ";
                }

                if ($order->sgst_amount > 0) {
                    $orderSummary .= "
                    <div style='display:table;width:100%;padding:5px 0;'>
                        <span style='display:table-cell;font-size:13px;color:#666;'>SGST ({$order->sgst_rate}%)</span>
                        <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                            ₹ " . number_format($order->sgst_amount, 2) . "
                        </span>
                    </div>
                ";
                }
            }
        }

        $orderSummary .= "
            <hr style='border:none;border-top:1px solid #d4dbd9;margin:10px 0;'>
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:15px;font-weight:600;color:#1a1a1a;'>Grand Total</span>
                <span style='display:table-cell;text-align:right;font-size:16px;font-weight:700;color:#1F5552;'>
                    ₹ " . number_format($order->grand_total, 2) . "
                </span>
            </div>
        </div>
    ";
        /*
        |--------------------------------------------------------------------------
        | Shipping Address HTML
        |--------------------------------------------------------------------------
        */
        $shippingAddress = "
        <div>
            <strong>{$order->customer_name}</strong><br>
            {$order->address_line_1}
    ";

        if (!empty($order->address_line_2)) {
            $shippingAddress .= "<br>{$order->address_line_2}";
        }

        $shippingAddress .= "
            <br>{$order->city?->name}, {$order->state?->name} - {$order->pincode}
            <br>📞 {$order->customer_phone}
        </div>
    ";

        /*
        |--------------------------------------------------------------------------
        | Common Variables
        |--------------------------------------------------------------------------
        */
        $variables = [

            '{customer_name}' => $order->customer_name,

            '{order_number}' => $order->order_number,
            '{order_date}' => $order->created_at->format('d M Y'),
            '{grand_total}' => '₹' . number_format($order->grand_total, 2),

            '{payment_method}' => ucfirst($order->payment_method),
            '{payment_status}' => ucfirst($order->payment_status),
            '{transaction_id}' => $order->transaction_id ?? 'N/A',

            '{order_url}' => route('order.success', $order->id),

            '{order_items}' => $orderItems,
            '{order_summary}' => $orderSummary,
            '{shipping_address}' => $shippingAddress,
        ];

        /*
        |--------------------------------------------------------------------------
        | Customer - Order Confirmed
        |--------------------------------------------------------------------------
        */
        \App\Services\Email\EmailDispatcher::send(
            'order-confirmed',
            $order->customer_email,
            $variables,
            $order->customer_name
        );

        /*
        |--------------------------------------------------------------------------
        | Customer - Payment Received
        |--------------------------------------------------------------------------
        */
        if ($order->payment_status === 'paid') {

            \App\Services\Email\EmailDispatcher::send(
                'payment-received',
                $order->customer_email,
                array_merge($variables, [
                    '{payment_amount}' => '₹' . number_format($order->grand_total, 2),
                    '{transaction_id}' => $order->transaction_id ?? $order->razorpay_payment_id ?? 'N/A',
                    '{invoice_url}' => route('order.success', $order->id),
                ]),
                $order->customer_name
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin - New Order Alert
        |--------------------------------------------------------------------------
        */
        $adminEmail = Setting::first()?->admin_email;

        if ($adminEmail) {

            \App\Services\Email\EmailDispatcher::send(
                'new-order-alert',
                $adminEmail,
                array_merge($variables, [
                    '{admin_order_url}' => route('admin.orders.show', $order->id),
                ])
            );
        }
    }


    protected function deductOrderStock(Order $order): void
    {
        /** @var \App\Services\StockService $stockService */
        $stockService = app(\App\Services\StockService::class);

        $order->loadMissing(['items.product', 'items.stockVariant']);

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product)
                continue;

            try {
                $stockService->debit(
                    $product,
                    $item->quantity,
                    'order',
                    $order,               // reference — links history entry to this order
                    null,                 // no admin user, this is a customer action
                    null,                 // no note
                    true,                 // allowNegative: true so an order never fails due to stock race
                    $item->stockVariant   // null if this item has no stock-type variant → falls back to product stock
                );
            } catch (\Exception $e) {
                // Log but don't block the order — stock can be corrected manually
                \Log::warning("Stock debit failed for product {$product->id} on order {$order->id}: " . $e->getMessage());
            }
        }
    }

    public function trackStep(Request $request)
    {
        $request->validate(['step' => 'required|in:login_prompt']);

        $customer = auth('customer')->user();

        $cart = $customer
            ? Cart::where('user_id', $customer->id)->first()
            : Cart::where('session_id', session()->getId())->whereNull('user_id')->first();

        CartTracker::track($request->step, $cart, [], 30);

        return response()->json(['success' => true]);
    }

}