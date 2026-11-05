<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageHero extends Model
{
    protected $fillable = [
        'page_key', 'eyebrow', 'title', 'description', 'image', 'tag',
        'primary_btn_text', 'primary_btn_link', 'secondary_btn_text', 'secondary_btn_link',
    ];

    private const BASIC = ['eyebrow', 'title', 'description', 'image', 'tag'];

    /** Which fields each page's hero uses (drives the admin form). */
    public const PAGES = [
        'about' => [
            'label' => 'About Us',
            'fields' => ['eyebrow', 'title', 'description', 'image', 'tag',
                'primary_btn_text', 'primary_btn_link', 'secondary_btn_text', 'secondary_btn_link'],
        ],
        'blogs' => ['label' => 'Blog', 'fields' => self::BASIC],
        'contact' => ['label' => 'Contact Us', 'fields' => self::BASIC],
        'faqs' => ['label' => 'FAQs', 'fields' => self::BASIC],
    ];

    /** Shown until the admin saves a row for that page. */
    public const DEFAULTS = [
        'about' => [
            'eyebrow' => 'Archana Saree Emporium',
            'title' => "A Legacy of\nTimeless Indian Elegance",
            'description' => "Celebrating the beauty of Indian drapes through timeless craftsmanship, thoughtful curation and styles made for life's most memorable occasions.",
            'tag' => 'The Archana Edit',
            'primary_btn_text' => 'Explore Our Collection',
            'primary_btn_link' => '/products',
            'secondary_btn_text' => 'Discover Our Story',
            'secondary_btn_link' => '#aboutStory',
        ],
        'blogs' => [
            'eyebrow' => 'The Archana Journal',
            'title' => 'Stories, Styling & Saree Inspiration',
            'description' => 'Draping guides, wedding edits, fabric stories and styling ideas from the world of Indian ethnic wear.',
            'tag' => 'Read & Be Inspired',
        ],
        'contact' => [
            'eyebrow' => 'Get in Touch',
            'title' => "We'd Love to Help You Find Your Perfect Look",
            'description' => "Whether you're looking for a timeless saree, a statement lehenga or bridal wear for your special day, our team is here to help you choose the right piece.",
            'tag' => 'Personal Assistance',
        ],
        'faqs' => [
            'eyebrow' => 'Help & Information',
            'title' => 'Frequently Asked Questions',
            'description' => 'Find answers to common questions about our sarees, lehengas, bridal collections, orders, payments, delivery and shopping experience.',
            'tag' => 'Here to Help',
        ],
    ];

    /** Saved row, or an unsaved one holding the defaults. */
    public static function forPage(string $key): self
    {
        return static::where('page_key', $key)->first()
            ?? new static(['page_key' => $key] + (static::DEFAULTS[$key] ?? ['title' => '']));
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/images/home/banner5.jpg');
    }
}