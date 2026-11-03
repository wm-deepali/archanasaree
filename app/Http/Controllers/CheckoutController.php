<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\State;
use App\Models\Setting;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use App\Models\CustomerAddress;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Services\StockAlertService;
use Illuminate\Support\Facades\Log;
use App\Services\Tracking\CartTracker;

use App\Traits\FinalizesOrderPayment;

class CheckoutController extends Controller
{
    use FinalizesOrderPayment;

    // Inject in constructor
    public function __construct(protected StockAlertService $alertService)
    {
    }

    public function checkout()
    {
        $customer = auth('customer')->user(); // null for guests

        $cartQuery = Cart::query();

        $cart = $customer
            ? $cartQuery->where('customer_id', $customer->id)->first()
            : $cartQuery->where('session_id', session()->getId())->whereNull('customer_id')->first();

        if (!$cart || !$cart->items()->exists()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Totals use the current default address (GST + shipping zone)
        $cart->recalculateTotals();
        $cart->refresh();

        // Load relations AFTER refresh(), because refresh() drops loaded relations
        $cart->load([
            'items.product.images',
            'items.product.category',
            'items.priceVariant',
            'items.stockVariant',
            'items.imageVariant.images',
            'items.addons',
        ]);

        CartTracker::track('checkout_viewed', $cart, [], 30); // no duplicate on refresh

        $addresses = $customer
            ? $customer->addresses()->with(['state', 'city'])->orderByDesc('is_default')->get()
            : collect();

        $defaultAddress = $addresses->firstWhere('is_default', true);

        $states = State::orderBy('name')->get();

        $beginCheckoutScript = \App\Services\Tracking\PixelTracker::beginCheckoutScript($cart);

        $summary = \App\Services\CartSummary::for($cart);

        $codEnabled = (bool) optional(Setting::first())->cod_enabled;

        return view(
            'front-pages.checkout',
            compact('cart', 'customer', 'addresses', 'defaultAddress', 'states', 'beginCheckoutScript', 'summary', 'codEnabled')
        );
    }

    public function cities(State $state)
    {
        return response()->json(
            City::where('state_id', $state->id)->orderBy('name')->get(['id', 'name'])
        );
    }

    private function addressRules(Request $request): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_id' => ['required', Rule::exists('cities', 'id')->where('state_id', $request->state_id)],
            'pincode' => ['required', 'regex:/^\d{6}$/'],
            'address_type' => 'nullable|in:home,office,other',
        ];
    }

    private function addressMessages(): array
    {
        return [
            'email.required' => 'Please enter your email in the Contact section.',
            'email.email' => 'Please enter a valid email in the Contact section.',
            'phone.regex' => 'Enter a valid 10 digit mobile number.',
            'pincode.regex' => 'Enter a valid 6 digit pincode.',
            'state_id.required' => 'Please select a state.',
            'city_id.required' => 'Please select a city.',
            'city_id.exists' => 'Please select a city from the chosen state.',
            'address_line_1.required' => 'Please enter your house / flat number.',
        ];
    }

    public function storeAddress(Request $request)
    {
        $customer = auth('customer')->user();

        $v = $request->validate($this->addressRules($request), $this->addressMessages());

        DB::transaction(function () use ($customer, $v) {
            // a new address becomes the default, because GST and shipping use the default address
            CustomerAddress::where('customer_id', $customer->id)->update(['is_default' => 0]);

            CustomerAddress::create([
                'customer_id' => $customer->id,
                'name' => $v['name'],
                'email' => $v['email'],
                'phone' => $v['phone'],
                'address_line_1' => $v['address_line_1'],
                'address_line_2' => $v['address_line_2'] ?? null,
                'country' => 'India',
                'state_id' => $v['state_id'],
                'city_id' => $v['city_id'],
                'pincode' => $v['pincode'],
                'address_type' => $v['address_type'] ?? 'home',
                'is_default' => 1,
            ]);
        });

        Cart::where('customer_id', $customer->id)->first()?->recalculateTotals();

        return response()->json(['success' => true]);
    }

    public function updateAddress(Request $request, $id)
    {
        $customer = auth('customer')->user();

        $address = CustomerAddress::where('customer_id', $customer->id)->findOrFail($id);

        $v = $request->validate($this->addressRules($request), $this->addressMessages());

        DB::transaction(function () use ($customer, $address, $v, $request) {
            $address->update([
                'name' => $v['name'],
                'email' => $v['email'],
                'phone' => $v['phone'],
                'address_line_1' => $v['address_line_1'],
                'address_line_2' => $v['address_line_2'] ?? null,
                'state_id' => $v['state_id'],
                'city_id' => $v['city_id'],
                'pincode' => $v['pincode'],
                'address_type' => $v['address_type'] ?? 'home',
            ]);

            if ($request->boolean('is_default')) {
                CustomerAddress::where('customer_id', $customer->id)->update(['is_default' => 0]);
                $address->update(['is_default' => 1]);
            }
        });

        Cart::where('customer_id', $customer->id)->first()?->recalculateTotals();

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

        $cart = Cart::where('customer_id', $customer->id)->first();

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

        $billingSame = $request->boolean('billing_same', true);

        if (!$billingSame) {
            $request->validate([
                'bill_name' => 'required|string|max:255',
                'bill_address_line_1' => 'required|string|max:255',
                'bill_address_line_2' => 'nullable|string|max:255',
                'bill_state_id' => 'required|exists:states,id',
                'bill_city_id' => ['required', Rule::exists('cities', 'id')->where('state_id', $request->bill_state_id)],
                'bill_pincode' => ['required', 'regex:/^\d{6}$/'],
            ], [
                'bill_name.required' => 'Please enter the billing name.',
                'bill_address_line_1.required' => 'Please enter the billing house / flat number.',
                'bill_state_id.required' => 'Please select the billing state.',
                'bill_city_id.required' => 'Please select the billing city.',
                'bill_pincode.regex' => 'Enter a valid 6 digit billing pincode.',
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

            $request->validate($this->addressRules($request), $this->addressMessages());

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
                'address_type' => $request->address_type ?? 'home',
                'is_default' => 1,
            ]);
        }

        $billing = $billingSame
            ? [
                'billing_name' => $address->name,
                'billing_address_line_1' => $address->address_line_1,
                'billing_address_line_2' => $address->address_line_2,
                'billing_state_id' => $address->state_id,
                'billing_city_id' => $address->city_id,
                'billing_pincode' => $address->pincode,
            ]
            : [
                'billing_name' => $request->bill_name,
                'billing_address_line_1' => $request->bill_address_line_1,
                'billing_address_line_2' => $request->bill_address_line_2,
                'billing_state_id' => $request->bill_state_id,
                'billing_city_id' => $request->bill_city_id,
                'billing_pincode' => $request->bill_pincode,
            ];

        /* Hamesha latest address ke hisaab se GST recalc */
        $cart = Cart::where('customer_id', $customer->id)->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        $cart = Cart::with([
            'items.product',
            'items.addons',
        ])
            ->where('customer_id', $customer->id)
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

                'shipping_charge' => $cart->shipping_charge,
                ...$billing,

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

        try {
            // Sirf is customer ka order
            $order = Order::where('customer_id', auth('customer')->id())
                ->findOrFail($request->order_id);

            // Payment isi order ka hona chahiye
            if ($order->razorpay_order_id !== $request->razorpay_order_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment details.'
                ], 422);
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

            // Row lock + already-paid check inside (webhook may have won the race)
            $this->finalizeRazorpayPayment(
                $order->id,
                $request->razorpay_payment_id,
                $request->razorpay_signature,
                'Customer Callback',
                $order->customer_id,
                $request
            );

            return response()->json([
                'success' => true,
                'redirect_url' => route('order.success', $order->id),
            ]);

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {

            Log::warning('Razorpay signature failed: ' . $e->getMessage(), [
                'order_id' => $request->order_id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.'
            ], 422);

        } catch (\Exception $e) {

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
        $order = Order::with(['items.product', 'items.imageVariant', 'items.addons', 'state', 'city'])
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


    public function trackStep(Request $request)
    {
        $request->validate(['step' => 'required|in:login_prompt']);

        $customer = auth('customer')->user();

        $cart = $customer
            ? Cart::where('customer_id', $customer->id)->first()
            : Cart::where('session_id', session()->getId())->whereNull('customer_id')->first();

        CartTracker::track($request->step, $cart, [], 30);

        return response()->json(['success' => true]);
    }

}