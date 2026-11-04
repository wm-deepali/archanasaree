<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DynamicPage extends Model
{
    protected $fillable = [
        'slug',
        'heading',
        'short_description',
        'content',
        'meta_title',
        'meta_description',
        'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function getUrlAttribute(): string
    {
        return route('page.show', $this->slug);
    }

    /** Makes a unique slug from the typed slug, or from the page name */
    public static function makeSlug(?string $typed, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($typed ?: $name) ?: 'page';
        $slug = $base;
        $i = 2;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Replaces placeholders in the content with values from Settings,
     * so the email, phone and address stay in sync with the admin.
     */
    public function renderedContent(?Setting $s): string
    {
        $map = [
            '[[site_name]]' => e($s?->site_name ?: config('app.name')),
            '[[email]]' => e($s?->support_email ?: $s?->admin_email),
            '[[phone]]' => e($s?->phone),
            '[[address]]' => e($s?->business_address),
        ];

        return strtr((string) $this->content, $map);
    }
}