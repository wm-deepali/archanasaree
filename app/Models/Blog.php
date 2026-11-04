<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'author', 'tags', 'published_at', 'image',
        'short_description', 'content', 'meta_title', 'meta_description',
        'show_home', 'is_featured', 'status',
    ];

    protected $casts = [
        'published_at' => 'date',
        'show_home'    => 'boolean',
        'is_featured'  => 'boolean',
        'status'       => 'boolean',
    ];

    /** Active and already published (future dates stay hidden) */
    public function scopePublished($q)
    {
        return $q->where('status', 1)
            ->where(fn ($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()->toDateString()));
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/images/home/banner5.jpg');
    }

    public function getDisplayDateAttribute()
    {
        return $this->published_at ?? $this->created_at;
    }

    public function getReadTimeAttribute(): int
    {
        $words = count(preg_split('/\s+/u', trim(strip_tags((string) $this->content)), -1, PREG_SPLIT_NO_EMPTY));

        return max(1, (int) ceil($words / 200));
    }

    public function getTagsListAttribute(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->tags))));
    }

    /** HTML content is output as-is (admin only); plain text keeps its line breaks */
    public function getBodyHtmlAttribute(): string
    {
        $c = (string) $this->content;

        return $c === strip_tags($c) ? nl2br(e($c)) : $c;
    }
}