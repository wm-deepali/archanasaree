<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCampaign extends Model
{
    protected $fillable = [
        'eyebrow', 'title', 'description',
        'primary_btn_text', 'primary_btn_link',
        'secondary_btn_text', 'secondary_btn_link',
        'highlights', 'bg_image', 'image', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    /** Shown until the admin saves the first row */
    public const DEFAULTS = [
        'eyebrow' => 'The Lehenga Edit',
        'title' => "Make an Entrance\nThey'll Remember",
        'description' => 'Discover statement lehengas designed for weddings, receptions, engagements and celebrations where every detail deserves to stand out.',
        'primary_btn_text' => 'Shop Lehengas',
        'secondary_btn_text' => 'Explore Designer Collection',
        'highlights' => "Statement Silhouettes\nIntricate Details\nCelebration-Ready Styles",
        'status' => true,
    ];

    /** The row to show: saved row, defaults if none saved, null if switched off */
    public static function current(): ?self
    {
        $row = static::latest('id')->first();

        if (!$row) {
            return new static(static::DEFAULTS);
        }

        return $row->status ? $row : null;
    }

    public function getBgImageUrlAttribute(): string
    {
        return $this->bg_image
            ? asset('storage/' . $this->bg_image)
            : asset('assets/images/home/banner5.jpg');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/images/home/upper11zon.jpg');
    }

    /** Bullet lines as an array */
    public function getHighlightsListAttribute(): array
    {
        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->highlights))
        ));
    }
}