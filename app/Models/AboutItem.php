<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutItem extends Model
{
    protected $fillable = [
        'section_key', 'group_key', 'title', 'description',
        'icon', 'value', 'link', 'sort_order', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    /** "10,000+" gives 10000 (for the count-up) */
    public function getNumAttribute(): int
    {
        preg_match('/^\s*([\d,]+)/', (string) $this->value, $m);

        return (int) str_replace(',', '', $m[1] ?? 0);
    }

    /** "25+" gives "+" */
    public function getSuffixAttribute(): string
    {
        return trim(preg_replace('/^\s*[\d,]+/', '', (string) $this->value));
    }
}