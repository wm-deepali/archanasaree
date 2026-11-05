<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'key', 'eyebrow', 'title', 'description', 'description_2', 'description_3',
        'btn_text', 'btn_link', 'tag', 'image', 'image_2', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    /**
     * Drives the admin form, validation and the list page.
     * fields = which section fields are editable; groups = repeating items.
     */
    public const SECTIONS = [
        'story' => [
            'label' => 'The Archana Story',
            'where' => 'Intro with image and count-up stats',
            'fields' => ['eyebrow', 'title', 'description', 'description_2', 'image'],
            'groups' => [
                'stats' => [
                    'label' => 'Stats (count-up numbers)', 'max' => 4,
                    'fields' => ['value', 'title'],
                    'labels' => ['value' => 'Number (e.g. 25+)', 'title' => 'Label'],
                ],
            ],
        ],
        'who' => [
            'label' => 'Who We Are',
            'where' => 'Text with two images',
            'fields' => ['eyebrow', 'title', 'description', 'description_2', 'description_3', 'btn_text', 'btn_link', 'image', 'image_2', 'tag'],
            'labels' => ['description_3' => 'Closing Note', 'tag' => 'Image Tag'],
        ],
        'philosophy' => [
            'label' => 'Our Philosophy',
            'where' => 'Numbered belief cards',
            'fields' => ['eyebrow', 'title', 'description'],
            'labels' => ['description' => 'Sub Heading'],
            'groups' => [
                'cards' => ['label' => 'Belief Cards', 'max' => 6, 'fields' => ['title', 'description']],
            ],
        ],
        'art' => [
            'label' => 'The Art of the Saree',
            'where' => 'Image, checklist and fabric tags',
            'fields' => ['eyebrow', 'title', 'description', 'image'],
            'groups' => [
                'list' => ['label' => 'Checklist', 'max' => 10, 'fields' => ['title', 'description']],
                'tags' => [
                    'label' => 'Fabric Tags', 'max' => 12,
                    'fields' => ['title', 'link'],
                    'labels' => ['title' => 'Tag Text', 'link' => 'Link (e.g. /products?q=Silk)'],
                ],
            ],
        ],
        'craft' => [
            'label' => 'Craftsmanship',
            'where' => 'Image with numbered points',
            'fields' => ['eyebrow', 'title', 'image', 'tag'],
            'labels' => ['tag' => 'Image Tag'],
            'groups' => [
                'points' => ['label' => 'Points', 'max' => 6, 'fields' => ['title', 'description']],
            ],
        ],
        'experience' => [
            'label' => 'The Archana Experience',
            'where' => 'Intro and icon features',
            'fields' => ['eyebrow', 'title', 'description', 'btn_text', 'btn_link'],
            'groups' => [
                'features' => ['label' => 'Features', 'max' => 6, 'fields' => ['icon', 'title', 'description']],
            ],
        ],
        'how' => [
            'label' => 'How It Works',
            'where' => 'Numbered steps',
            'fields' => ['title'],
            'groups' => [
                'steps' => ['label' => 'Steps', 'max' => 6, 'fields' => ['title', 'description']],
            ],
        ],
        'why' => [
            'label' => 'Why Choose Us',
            'where' => 'Icon reasons grid',
            'fields' => ['eyebrow', 'title', 'description'],
            'labels' => ['description' => 'Sub Heading'],
            'groups' => [
                'reasons' => ['label' => 'Reasons', 'max' => 12, 'fields' => ['icon', 'title', 'description']],
            ],
        ],
        'quote' => [
            'label' => 'Quote Banner',
            'where' => 'Full-width quote on an image',
            'fields' => ['title', 'tag', 'image'],
            'labels' => ['title' => 'Quote', 'tag' => 'Byline'],
        ],
    ];

    public function items()
    {
        return $this->hasMany(AboutItem::class, 'section_key', 'key')
            ->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getImage2UrlAttribute(): ?string
    {
        return $this->image_2 ? asset('storage/' . $this->image_2) : null;
    }
}