<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Order;
use App\Http\Controllers\Admin\AdminSettingController;
use Illuminate\Support\Facades\Schema;

class InvoiceService
{
    public function autoEnabled(): bool
    {
        $setting = InvoiceSetting::first();

        return $setting ? (bool) $setting->auto_generate_invoice : true;
    }

    public function createIfAuto(Order $order): ?Invoice
    {
        return $this->autoEnabled() ? $this->createForOrder($order) : null;
    }

    public function createForOrder(Order $order): Invoice
    {
        if ($existing = Invoice::where('order_id', $order->id)->first()) {
            return $existing;
        }

        $order->loadMissing(['city', 'state']);

        if ($order->billing_address_line_1) {
            $bState = \App\Models\State::find($order->billing_state_id)?->name;
            $bCity = \App\Models\City::find($order->billing_city_id)?->name;

            $billingAddress = collect([
                $order->billing_address_line_1,
                $order->billing_address_line_2,
                $bCity,
                $bState,
                $order->billing_pincode,
            ])->filter()->implode(', ');
        } else { // orders placed before billing existed
            $billingAddress = collect([
                $order->address_line_1,
                $order->address_line_2,
                $order->city?->name,
                $order->state?->name,
                $order->pincode,
            ])->filter()->implode(', ');
        }

        $data = [
            'order_id' => $order->id,
            'invoice_number' => AdminSettingController::generateInvoiceNumber(),
            'invoice_date' => now()->toDateString(),

            'customer_name' => $order->billing_name ?: $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'billing_address' => $billingAddress,

            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'tax_amount' => $order->tax_amount,
            'grand_total' => $order->grand_total,

            'gst_type' => $order->gst_type,
            'cgst_rate' => $order->cgst_rate,
            'sgst_rate' => $order->sgst_rate,
            'igst_rate' => $order->igst_rate,
            'cgst_amount' => $order->cgst_amount,
            'sgst_amount' => $order->sgst_amount,
            'igst_amount' => $order->igst_amount,

            'status' => 'generated',
        ];

        // Shipping sirf un projects me jahan dono tables me column hai
        if (Schema::hasColumn('orders', 'shipping_charge') && Schema::hasColumn('invoices', 'shipping_charge')) {
            $data['shipping_charge'] = $order->shipping_charge;
        }

        return Invoice::create($data);
    }
}