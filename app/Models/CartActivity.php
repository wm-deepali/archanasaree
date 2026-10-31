<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartActivity extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    // rank = funnel mein kitna aage gaya
    public const EVENTS = [
        'add_to_cart' => ['label' => 'Added to Cart', 'icon' => 'fa-shopping-cart', 'rank' => 1],
        'checkout_viewed' => ['label' => 'Opened Checkout', 'icon' => 'fa-credit-card', 'rank' => 2],
        'login_prompt' => ['label' => 'Clicked Place Order (Login/Signup shown)', 'icon' => 'fa-lock', 'rank' => 3],
        'login' => ['label' => 'Logged In', 'icon' => 'fa-sign-in', 'rank' => 4],
        'signup' => ['label' => 'Signed Up', 'icon' => 'fa-user-plus', 'rank' => 4],
        'payment_started' => ['label' => 'Payment Started', 'icon' => 'fa-inr', 'rank' => 5],
        'order_placed' => ['label' => 'Order Placed', 'icon' => 'fa-check-circle', 'rank' => 6],
    ];

    public function getLabelAttribute(): string
    {
        return self::EVENTS[$this->event]['label'] ?? $this->event;
    }

    public function getIconAttribute(): string
    {
        return self::EVENTS[$this->event]['icon'] ?? 'fa-circle';
    }

    public function getLocationLabelAttribute(): ?string
    {
        $parts = array_filter([$this->city, $this->region, $this->country]);

        return $parts ? implode(', ', $parts) : null;
    }
}