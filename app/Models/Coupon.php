<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'minimum_order_amount',
        'maximum_discount',
        'minimum_order_quantity',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'customer_type',
        'status',
    ];

    /** Active, date window ke andar, aur usage bacha ho */
    public function scopeAvailable($q)
    {
        $today = now()->toDateString();

        return $q->where('status', 1)
            ->where(fn ($w) => $w->whereNull('start_date')->orWhereDate('start_date', '<=', $today))
            ->where(fn ($w) => $w->whereNull('end_date')->orWhereDate('end_date', '>=', $today))
            ->where(fn ($w) => $w->whereNull('usage_limit')
                ->orWhere('usage_limit', 0)
                ->orWhereColumn('used_count', '<', 'usage_limit'));
    }

    public function getIsPercentAttribute(): bool
    {
        return in_array(strtolower((string) $this->discount_type), ['percentage', 'percent'], true);
    }

    /** "Get 10% off (up to ₹500) on orders above ₹2,999. Valid till 31 Dec 2026." */
    public function getOfferTextAttribute(): string
    {
        $value = rtrim(rtrim(number_format((float) $this->discount_value, 2, '.', ''), '0'), '.');

        $text = $this->is_percent
            ? "Get {$value}% off"
            : 'Get flat ₹' . number_format((float) $this->discount_value) . ' off';

        if ($this->is_percent && $this->maximum_discount > 0) {
            $text .= ' (up to ₹' . number_format((float) $this->maximum_discount) . ')';
        }

        $conds = [];
        if ($this->minimum_order_amount > 0) {
            $conds[] = 'orders above ₹' . number_format((float) $this->minimum_order_amount);
        }
        if ($this->minimum_order_quantity > 1) {
            $conds[] = $this->minimum_order_quantity . '+ items';
        }
        if ($conds) {
            $text .= ' on ' . implode(' and ', $conds);
        }

        $text .= '.';

        if ($this->end_date) {
            $text .= ' Valid till ' . Carbon::parse($this->end_date)->format('d M Y') . '.';
        }

        return $text;
    }
}