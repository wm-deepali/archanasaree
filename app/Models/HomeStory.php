<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeStory extends Model
{
    protected $fillable = [
        'eyebrow', 'title', 'description', 'description_2', 'tag',
        'btn_text', 'btn_link', 'main_image', 'small_image',
        'founder_name', 'founder_role', 'founder_message', 'founder_photo',
        'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public const DEFAULTS = [
        'eyebrow' => 'Our Story',
        'title' => 'Rooted in Tradition. Styled for Today.',
        'description' => 'Archana Saree Emporium brings together the richness of Indian occasion wear with a modern eye for elegance. From timeless sarees and statement lehengas to exquisite bridal ensembles, our collections are curated for celebrations that deserve something truly special.',
        'description_2' => "Inspired by the timeless charm of Delhi's celebrated fashion heritage, Archana Saree Emporium is a destination for those who appreciate beautiful craftsmanship, distinctive styles and the enduring elegance of Indian dressing.",
        'tag' => 'Inspired by Delhi',
        'btn_text' => 'Discover Our Story',
        'founder_name' => 'Owner Name',
        'founder_role' => 'Founder, Archana Saree Emporium',
        'founder_message' => 'A short, personal line from the owner, written in their own voice, welcoming customers to the store they have known for years.',
        'status' => true,
    ];

    public static function current(): ?self
    {
        $row = static::latest('id')->first();

        if (!$row) {
            return new static(static::DEFAULTS);
        }

        return $row->status ? $row : null;
    }

    public function getMainImageUrlAttribute(): string
    {
        return $this->main_image ? asset('storage/' . $this->main_image) : asset('assets/images/home/ower1.jpeg');
    }

    public function getSmallImageUrlAttribute(): string
    {
        return $this->small_image ? asset('storage/' . $this->small_image) : asset('assets/images/home/ower2.jpeg');
    }

    public function getFounderPhotoUrlAttribute(): string
    {
        return $this->founder_photo ? asset('storage/' . $this->founder_photo) : asset('assets/images/home/ower1.jpeg');
    }
}