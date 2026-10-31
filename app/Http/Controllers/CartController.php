<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Str;
use App\Models\ProductAddon;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use App\Models\ShippingSetting;
use App\Services\Tracking\PixelTracker;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{

    /**
     * Per-unit dye charge, calculated ONLY at add-to-cart time and then
     * snapshotted into cart_items.dye_charge. Applies only when the product
     * allows colour customization, a colour code was entered, and dye_price > 0.
     */
    private function dyeUnitCharge(Product $product, ?string $customColourCode): float
    {
        if (!$product->colour_customization) {
            return 0.0;
        }

        if ($customColourCode === null || trim($customColourCode) === '') {
            return 0.0;
        }

        return max(0.0, (float) $product->dye_price);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',

            'price_variant_id' => 'nullable|exists:product_variants,id',
            'image_variant_id' => 'nullable|exists:product_variants,id',
            'stock_variant_id' => 'nullable|exists:product_variants,id',
            'sku_variant_id' => 'nullable|exists:product_variants,id',

            'selected_values' => 'nullable|array',
            'selected_values.*' => 'integer|exists:attribute_values,id',

            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'integer|exists:product_addons,id',

            'custom_colour_code' => 'nullable|string|max:50',

            'quantity' => 'nullable|integer|min:1|max:1000',
        ]);

        $product = Product::with('variants.values')
            ->where('status', 1)
            ->findOrFail($request->product_id);

        $minQty = max(1, (int) $product->min_qty);
        $quantity = (int) ($request->quantity ?? $minQty);

        if ($quantity < $minQty) {
            return response()->json([
                'status' => false,
                'message' => "Minimum order quantity is {$minQty}."
            ], 422);
        }

        // Custom colour code — only when the product allows it
        $customColourCode = null;

        if ($product->colour_customization) {
            $customColourCode = Str::limit(
                trim(strip_tags((string) $request->custom_colour_code)),
                50,
                ''
            );

            if ($customColourCode === '') {
                $customColourCode = null;
            }
        }

        $dyeUnitCharge = $this->dyeUnitCharge($product, $customColourCode);

        // Listing-page add (no variant ids sent): pick a default in-stock combination
        if (!$request->filled('stock_variant_id') && $product->variants->isNotEmpty()) {

            $stockVariants = $product->variants->where('type', 'stock');

            $defaultStockVariant = $stockVariants->firstWhere('stock', '>', 0)
                ?? $stockVariants->first();

            if ($defaultStockVariant) {

                $defaultValueIds = $defaultStockVariant->values
                    ->pluck('attribute_value_id')
                    ->sort()
                    ->values()
                    ->toArray();

                $request->merge([
                    'stock_variant_id' => $defaultStockVariant->id,
                    'selected_values' => $defaultValueIds,
                ]);

                foreach (['price', 'image', 'sku'] as $type) {

                    $match = $product->variants
                        ->where('type', $type)
                        ->first(function ($variant) use ($defaultValueIds) {
                            $ids = $variant->values
                                ->pluck('attribute_value_id')
                                ->sort()
                                ->values()
                                ->toArray();
                            return $ids === $defaultValueIds;
                        });

                    if ($match) {
                        $request->merge([$type . '_variant_id' => $match->id]);
                    }
                }
            }
        }

        // Variants are verified: must belong to THIS product, right type, available,
        // and their values must be part of the customer's selection.
        $selectedValueIds = collect($request->selected_values ?? [])->map(fn($i) => (int) $i)->all();

        $priceVariant = $this->resolveVariant($product, $request->price_variant_id, ProductVariant::TYPE_PRICE, $selectedValueIds);
        $imageVariant = $this->resolveVariant($product, $request->image_variant_id, ProductVariant::TYPE_IMAGE, $selectedValueIds);
        $stockVariant = $this->resolveVariant($product, $request->stock_variant_id, ProductVariant::TYPE_STOCK, $selectedValueIds);
        $skuVariant = $this->resolveVariant($product, $request->sku_variant_id, ProductVariant::TYPE_SKU, $selectedValueIds);

        $price = $priceVariant->price ?? $product->price;
        $stock = $stockVariant->stock ?? $product->stock;

        if ($stock < $minQty) {
            return response()->json([
                'status' => false,
                'message' => 'Product is out of stock.'
            ], 422);
        }

        if ($quantity > $stock) {
            return response()->json([
                'status' => false,
                'message' => "Only {$stock} units available."
            ], 422);
        }

        // Selected attribute values — snapshot for display (Size: L, Color: Red)
        $selectedAttributes = [];

        if ($request->filled('selected_values')) {
            $selectedAttributes = AttributeValue::with('attribute')
                ->whereIn('id', $request->selected_values)
                ->get()
                ->map(fn($av) => [
                    'attribute_id' => $av->attribute_id,
                    'attribute' => $av->attribute->name ?? null,
                    'type' => $av->attribute->type ?? null,
                    'value_id' => $av->id,
                    'value' => $av->value,
                    'hex' => $av->hex_code,
                ])
                ->values()
                ->toArray();
        }

        // Selected addons — snapshot detail + price (per unit)
        $selectedAddons = collect();

        if ($request->filled('addon_ids')) {
            $selectedAddons = ProductAddon::where('product_id', $product->id)
                ->whereIn('id', $request->addon_ids)
                ->get();
        }

        $addonUnitTotal = $selectedAddons->sum('price');

        // Get cart
        if (auth('customer')->check()) {

            $customer = auth('customer')->user();

            $cart = Cart::firstOrCreate(
                ['customer_id' => $customer->id],
                [
                    'session_id' => session()->getId(),
                    'total_amount' => 0,
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax_amount' => 0,
                    'grand_total' => 0,
                ]
            );

        } else {

            $cart = Cart::firstOrCreate(
                ['session_id' => session()->getId()],
                [
                    'total_amount' => 0,
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax_amount' => 0,
                    'grand_total' => 0,
                ]
            );
        }

        // Existing item: lines with addons never merge. Plain lines merge only when
        // variants, colour code AND the selected attribute values are identical.
        $item = null;

        if ($selectedAddons->isEmpty()) {
            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->where('price_variant_id', $priceVariant->id ?? null)
                ->where('image_variant_id', $imageVariant->id ?? null)
                ->where('stock_variant_id', $stockVariant->id ?? null)
                ->where('sku_variant_id', $skuVariant->id ?? null)
                ->when(
                    $customColourCode !== null,
                    fn($q) => $q->where('custom_colour_code', $customColourCode),
                    fn($q) => $q->whereNull('custom_colour_code')
                )
                ->doesntHave('addons')
                ->get()
                ->first(fn($ci) => $this->attrKey($ci->selected_attributes ?? []) === $this->attrKey($selectedAttributes));
        }

        if ($item) {

            $newQty = $item->quantity + $quantity;

            if ($newQty > $stock) {
                return response()->json([
                    'status' => false,
                    'message' => "Only {$stock} units available."
                ], 422);
            }

            // Merged line keeps the dye charge locked in when it was created
            $lineDyeCharge = (float) $item->dye_charge;

            $item->quantity = $newQty;
            $item->total = $item->quantity * ($item->price + $addonUnitTotal + $lineDyeCharge);
            $item->save();

        } else {

            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,

                'price_variant_id' => $priceVariant->id ?? null,
                'image_variant_id' => $imageVariant->id ?? null,
                'stock_variant_id' => $stockVariant->id ?? null,
                'sku_variant_id' => $skuVariant->id ?? null,

                'selected_attributes' => $selectedAttributes,

                'custom_colour_code' => $customColourCode,
                'dye_charge' => $dyeUnitCharge,

                'quantity' => $quantity,
                'price' => $price,
                'total' => $quantity * ($price + $addonUnitTotal + $dyeUnitCharge),
            ]);

            foreach ($selectedAddons as $addon) {
                $item->addons()->create([
                    'addon_id' => $addon->id,
                    'detail' => $addon->detail,
                    'price' => $addon->price,
                ]);
            }
        }

        // Recalculate cart
        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        $trackingEvents = PixelTracker::addToCart($product, $quantity, $price + (float) $item->dye_charge);

        $cart->load($this->miniCartRelations());

        $miniCartHtml = view('layouts.mini-cart', ['miniCart' => $cart])->render();

        \App\Services\Tracking\CartTracker::track('add_to_cart', $cart, [
            'product' => $product->name ?? null,
            'quantity' => $quantity ?? 1,
            'price' => $price ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_total' => $cart->grand_total,
            'cart_subtotal' => number_format($cart->total_amount ?? $cart->items()->sum('total'), 2),
            'mini_cart_html' => $miniCartHtml,
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'discount' => $cart->discount,
            'tracking_events' => $trackingEvents,
        ]);
    }

    /** A variant id from the client is trusted only after these checks pass. */
    private function resolveVariant(Product $product, $id, string $type, array $selectedValueIds): ?ProductVariant
    {
        if (!$id) {
            return null;
        }

        $variant = $product->variants->firstWhere('id', (int) $id);

        $valid = $variant
            && $variant->type === $type
            && $variant->status
            && $variant->is_available !== false;

        if ($valid && $selectedValueIds) {
            $variantValueIds = $variant->values
                ->pluck('attribute_value_id')
                ->map(fn($i) => (int) $i)
                ->all();

            $valid = empty(array_diff($variantValueIds, $selectedValueIds));
        }

        if (!$valid) {
            throw ValidationException::withMessages([
                'variant' => 'The selected option is no longer available. Please refresh and try again.',
            ]);
        }

        return $variant;
    }

    /** Comparable key of selected attribute values (for merge check) */
    private function attrKey(array $attrs): string
    {
        return collect($attrs)
            ->pluck('value_id')
            ->map(fn($i) => (int) $i)
            ->sort()
            ->implode('-');
    }

    public function cart()
    {
        $cart = $this->currentCart();

        if ($cart) {
            $cart->recalculateTotals();
            $cart->refresh();

            // Cart may have been touched from another tab/request since the coupon was applied
            $this->revalidateCoupon($cart);
            $cart->refresh();

            $cart->load($this->cartListRelations());
        }

        $offers = Coupon::available()
            ->orderByDesc('discount_value')
            ->limit(6)
            ->get();

        $freeShip = $this->freeShippingProgress($cart);
        $summary = \App\Services\CartSummary::for($cart);

        return view('front-pages.cart', compact('cart', 'offers', 'freeShip', 'summary'));
    }


    /**
     * Free-delivery progress. Same basis the calculator uses: items total minus
     * coupon discount. Null when free delivery is off or the cart is empty.
     */
    private function freeShippingProgress(?Cart $cart): ?array
    {
        $threshold = (float) (ShippingSetting::first()?->free_delivery_threshold ?? 0);

        if ($threshold <= 0 || !$cart || !$cart->items()->exists()) {
            return null;
        }

        $payable = max(0, (float) $cart->items()->sum('total') - (float) $cart->discount);

        return [
            'threshold' => $threshold,
            'remaining' => (int) ceil(max(0, $threshold - $payable)),
            'percent' => (int) min(100, floor(($payable / $threshold) * 100)),
            'done' => $payable >= $threshold,
        ];
    }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $cart = $this->currentCart();

        if (!$cart || !$cart->items()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Your bag is empty.'
            ]);
        }

        $coupon = Coupon::where('code', trim($request->coupon_code))
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        if ($coupon->start_date && now()->lt($coupon->start_date)) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon not started yet'
            ]);
        }

        if ($coupon->end_date && now()->gt($coupon->end_date)) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon expired'
            ]);
        }

        $subtotal = (float) $cart->items()->sum('total');

        if ($coupon->minimum_order_amount && $subtotal < $coupon->minimum_order_amount) {
            $short = number_format($coupon->minimum_order_amount - $subtotal);

            return response()->json([
                'status' => false,
                'message' => "Add ₹{$short} more to use this coupon (minimum order ₹" . number_format($coupon->minimum_order_amount) . ")."
            ]);
        }

        $totalQuantity = (int) $cart->items()->sum('quantity');

        if ($coupon->minimum_order_quantity && $totalQuantity < $coupon->minimum_order_quantity) {
            $remainingQty = $coupon->minimum_order_quantity - $totalQuantity;

            return response()->json([
                'status' => false,
                'message' => "Add {$remainingQty} more item" . ($remainingQty > 1 ? 's' : '') . " to unlock this coupon (minimum {$coupon->minimum_order_quantity} items required)."
            ]);
        }

        // One coupon per order: applying replaces any existing coupon
        $cart->update([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'discount' => $this->couponDiscount($coupon, $subtotal),
        ]);

        $cart->recalculateTotals();
        $cart->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'discount' => $cart->discount,
            'cart_total' => $cart->grand_total,
        ]);
    }

    public function removeCoupon()
    {
        $cart = $this->currentCart();

        if ($cart) {
            $cart->update([
                'coupon_id' => null,
                'coupon_code' => null,
                'discount' => 0
            ]);

            $cart->recalculateTotals();
            $cart->refresh();
        }

        return response()->json([
            'status' => true,
            'discount' => $cart->discount ?? 0,
            'cart_total' => $cart->grand_total ?? 0,
        ]);
    }

    /**
     * Re-check an applied coupon against the cart's current contents. Removes it
     * if it no longer qualifies, otherwise re-syncs the discount amount, and
     * recalculates totals itself whenever something changed.
     */
    private function revalidateCoupon(Cart $cart): ?array
    {
        if (!$cart->coupon_id) {
            return null;
        }

        $coupon = Coupon::find($cart->coupon_id);

        $drop = function (string $message) use ($cart) {
            $cart->update(['coupon_id' => null, 'coupon_code' => null, 'discount' => 0]);
            $cart->recalculateTotals();
            $cart->refresh();

            return ['removed' => true, 'message' => $message];
        };

        if (
            !$coupon
            || !$coupon->status
            || ($coupon->start_date && now()->lt($coupon->start_date))
            || ($coupon->end_date && now()->gt($coupon->end_date))
        ) {
            return $drop('Your applied coupon is no longer available and has been removed.');
        }

        // Same base as applyCoupon: sum of item totals (not the tax-adjusted display subtotal)
        $subtotal = (float) $cart->items()->sum('total');
        $totalQuantity = (int) $cart->items()->sum('quantity');

        $amountOk = !$coupon->minimum_order_amount || $subtotal >= $coupon->minimum_order_amount;
        $qtyOk = !$coupon->minimum_order_quantity || $totalQuantity >= $coupon->minimum_order_quantity;

        if (!$amountOk || !$qtyOk) {
            return $drop("Coupon \"{$coupon->code}\" was removed — your cart no longer meets its minimum requirement.");
        }

        $discount = $this->couponDiscount($coupon, $subtotal);

        if (abs($discount - (float) $cart->discount) > 0.001) {
            $cart->update(['discount' => $discount]);
            $cart->recalculateTotals();
            $cart->refresh();
        }

        return ['removed' => false];
    }

    private function currentCart(): ?Cart
    {
        return auth('customer')->check()
            ? Cart::where('customer_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();
    }

    private function ownsCart(Cart $cart): bool
    {
        return auth('customer')->check()
            ? $cart->customer_id == auth('customer')->id()
            : $cart->session_id == session()->getId();
    }

    /** Discount for a subtotal: percentage (with max cap) or flat, never above the subtotal */
    private function couponDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->discount_type === 'percentage') {
            $discount = ($subtotal * $coupon->discount_value) / 100;

            if ($coupon->maximum_discount && $discount > $coupon->maximum_discount) {
                $discount = (float) $coupon->maximum_discount;
            }
        } else {
            $discount = (float) $coupon->discount_value;
        }

        return round(min($discount, $subtotal), 2);
    }

    public function remove($id)
    {
        $item = CartItem::findOrFail($id);

        abort_unless($this->ownsCart($item->cart), 403);

        $cart = $item->cart;

        // capture before delete — product/qty/price won't exist on $item after this
        $trackingEvents = PixelTracker::removeFromCart(
            $item->product,
            $item->quantity,
            $item->price + (float) $item->dye_charge
        );

        $item->delete();

        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        $cart->load($this->miniCartRelations());
        $miniCartHtml = view('layouts.mini-cart', ['miniCart' => $cart])->render();

        return response()->json([
            'status' => true,
            'message' => 'Item removed successfully',
            'cart_total' => $cart->grand_total,
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_subtotal' => number_format($cart->total_amount ?? $cart->items()->sum('total'), 2),
            'mini_cart_html' => $miniCartHtml,
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'discount' => $cart->discount,
            'tracking_events' => $trackingEvents,
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'action' => 'required|in:plus,minus',
        ]);

        $item = CartItem::findOrFail($request->item_id);

        abort_unless($this->ownsCart($item->cart), 403);

        // Stock comes from the item's stock-variant (if any), else the base product
        $stock = $item->stockVariant
            ? $item->stockVariant->stock
            : $item->product->stock;

        $minQty = max(1, (int) $item->product->min_qty);

        if ($request->action == 'plus') {

            if ($item->quantity + 1 > $stock) {

                return response()->json([
                    'status' => false,
                    'message' => 'Only ' . $stock . ' units available in stock.'
                ], 422);
            }

            $item->quantity++;

        } elseif ($request->action == 'minus') {

            if ($item->quantity - 1 >= $minQty) {
                $item->quantity--;
            }
        }

        // Addon prices and the dye charge are per-unit, so they scale with
        // quantity too. Dye charge comes from the value saved on this line
        // (cart_items.dye_charge), NOT from the product's current dye_price.
        $addonUnitTotal = $item->addons->sum('price');
        $dyeUnitCharge = (float) $item->dye_charge;

        $item->total = $item->quantity * ($item->price + $addonUnitTotal + $dyeUnitCharge);
        $item->save();

        $cart = $item->cart;

        $cart->recalculateTotals();
        $cart->refresh();

        $couponResult = $this->revalidateCoupon($cart);

        $baseMrp = $item->priceVariant->mrp ?? $item->product->mrp;
        $totalMrp = ($baseMrp + $addonUnitTotal + $dyeUnitCharge) * $item->quantity;

        $cart->load($this->miniCartRelations());
        $miniCartHtml = view('layouts.mini-cart', ['miniCart' => $cart])->render();

        return response()->json([
            'status' => true,
            'quantity' => $item->quantity,
            'item_total' => $item->total,
            'total_mrp' => $totalMrp,
            'cart_total' => $cart->grand_total,
            'cart_count' => $cart->items()->sum('quantity'),
            'cart_subtotal' => number_format($cart->total_amount ?? $cart->items()->sum('total'), 2),
            'mini_cart_html' => $miniCartHtml,
            'coupon_removed' => $couponResult['removed'] ?? false,
            'coupon_message' => $couponResult['message'] ?? null,
            'discount' => $cart->discount,
        ]);
    }

    private function cartListRelations(): array
    {
        return [
            'items.product.images',
            'items.product.category',
            'items.product.subcategory',
            'items.imageVariant.images',
            'items.priceVariant',
            'items.stockVariant',
            'items.addons',
        ];
    }

    private function miniCartRelations(): array
    {
        return [
            'items.product.category',
            'items.product.subcategory',
            'items.imageVariant',
            'items.priceVariant',
            'items.stockVariant',
            'items.addons',
        ];
    }

}