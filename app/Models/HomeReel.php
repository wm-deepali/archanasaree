<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeReel extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'thumbnail', 'video', 'video_url', 'sort_order', 'status',
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

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('assets/images/home/reel1.jpeg');
    }

    /** Uploaded file first, else the external link; this goes into data-video */
    public function getVideoSrcAttribute(): ?string
    {
        if ($this->video) {
            return asset('storage/' . $this->video);
        }

        return $this->video_url ?: null;
    }
}