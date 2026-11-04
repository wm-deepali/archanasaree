<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = [
        'image',
        'eyebrow',
        'title',
        'description',
        'primary_btn_text',
        'primary_btn_link',
        'secondary_btn_text',
        'secondary_btn_link',
        'note',
        'theme',
        'sort_order',
        'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}