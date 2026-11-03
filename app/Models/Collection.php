<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'code',
        'status',
        'sort_order',
        'show_in_navbar'
    ];

    protected $casts = [
        'show_in_navbar' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'collection_product',
            'collection_id',
            'product_id'
        );
    }
}