<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoPage extends Model
{
    protected $fillable = [
        'page_key',
        'page_name',
        'page_group',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'robots',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_markup',
        'scripts',
        'body_scripts',
        'in_sitemap',
        'sitemap_priority',
        'sitemap_changefreq',
        'is_active',
    ];

    protected $casts = [
        'in_sitemap'       => 'boolean',
        'is_active'        => 'boolean',
        'sitemap_priority' => 'float',
    ];

    protected static function booted(): void
    {
        // Admin edits show up on the site immediately
        static::saved(fn (self $m) => Cache::forget(self::cacheKey($m->page_key)));
        static::deleted(fn (self $m) => Cache::forget(self::cacheKey($m->page_key)));
    }

    public static function cacheKey(string $key): string
    {
        return 'seo_page.' . $key;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function forKey(string $key): ?self
    {
        return Cache::remember(
            self::cacheKey($key),
            3600,
            fn () => static::active()->where('page_key', $key)->first()
        );
    }
}