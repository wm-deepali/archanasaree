<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\InvoiceSetting;

class CartSummary
{
    public static function for(?Cart $cart): array
    {
        $items = ($cart?->items ?? collect())->filter(fn($i) => $i->product);

        $totalMrp = 0.0;
        $sellTotal = 0.0;
        $dyeTotal = 0.0;
        $addonLines = [];

        foreach ($items as $item) {
            $qty  = (int) $item->quantity;
            $unit = (float) $item->price;
            $mrp  = (float) (($item->priceVariant->mrp ?? $item->product->mrp) ?: $unit);

            $totalMrp  += max($mrp, $unit) * $qty;
            $sellTotal += $unit * $qty;
            $dyeTotal  += (float) $item->dye_charge * $qty;

            foreach ($item->addons as $addon) {
                if ($addon->price > 0) {
                    $addonLines[$addon->detail] = ($addonLines[$addon->detail] ?? 0) + ($addon->price * $qty);
                }
            }
        }

        $coupon      = $cart && $cart->coupon_code ? (float) $cart->discount : 0.0;
        $mrpDiscount = max(0, $totalMrp - $sellTotal);

        // GST is its own line only when it is added on top (exclusive)
        $invoice      = InvoiceSetting::first();
        $taxExclusive = $cart
            && $invoice
            && $invoice->business_type === 'registered'
            && $invoice->tax_type === 'exclusive'
            && (float) $cart->tax_amount > 0;

        $shippingCharge = (float) ($cart->shipping_charge ?? 0);
        $shippingKnown  = true;

        if ($cart && $items->isNotEmpty() && $shippingCharge <= 0) {
            $taxable       = max(0, (float) $items->sum('total') - $coupon);
            $shippingKnown = (bool) ShippingCalculator::forCart($cart, $taxable)['known'];
        }

        return [
            'count'          => (int) $items->sum('quantity'),
            'total_mrp'      => $totalMrp,
            'mrp_discount'   => $mrpDiscount,
            'addons'         => $addonLines,
            'dye'            => $dyeTotal,
            'coupon_code'    => $cart?->coupon_code,
            'coupon'         => $coupon,
            'tax'            => $taxExclusive ? (float) $cart->tax_amount : 0.0,
            'shipping'       => $shippingCharge,
            'shipping_known' => $shippingKnown,
            'total'          => (float) ($cart->grand_total ?? 0),
            'saved'          => $mrpDiscount + $coupon,
        ];
    }
}