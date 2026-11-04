<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'ip_address', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }
}