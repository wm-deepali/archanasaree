<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'customer_id',
        'address_id',

        'order_number',

        'customer_name',
        'customer_email',
        'customer_phone',

        'address_line_1',
        'address_line_2',

        'state_id',
        'city_id',
        'pincode',

        'billing_name',
        'billing_address_line_1',
        'billing_address_line_2',
        'billing_state_id',
        'billing_city_id',
        'billing_pincode',

        'coupon_code',

        'subtotal',
        'discount',
        'tax_amount',
        'grand_total',

        'gst_type',

        'cgst_rate',
        'sgst_rate',
        'igst_rate',

        'cgst_amount',
        'sgst_amount',
        'igst_amount',

        'payment_method',
        'payment_status',

        'transaction_id',

        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',

        'status',
        'tracking_number',
        'courier_id'
    ];

    public function billingState()
    {
        return $this->belongsTo(\App\Models\State::class, 'billing_state_id');
    }

    public function billingCity()
    {
        return $this->belongsTo(\App\Models\City::class, 'billing_city_id');
    }

    public function customer()
    {
        return $this->belongsTo(
            Customer::class
        );
    }

    public function address()
    {
        return $this->belongsTo(
            CustomerAddress::class,
            'address_id'
        );
    }

    public function items()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }

    public function invoice()
    {
        return $this->hasOne(
            Invoice::class
        );
    }

    public function state()
    {
        return $this->belongsTo(
            State::class
        );
    }

    public function city()
    {
        return $this->belongsTo(
            City::class
        );
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class)
            ->latest();
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function returns()
    {
        return $this->hasMany(
            OrderReturn::class
        );
    }

    public function ndrs()
    {
        return $this->hasMany(Ndr::class)->latest();
    }

    public function latestNdr()
    {
        return $this->hasOne(Ndr::class)->latestOfMany();
    }

}