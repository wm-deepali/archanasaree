<?php

namespace Database\Seeders;

use App\Models\AboutItem;
use App\Models\AboutSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->data() as $key => $row) {
            $section = AboutSection::firstOrNew(['key' => $key]);

            if ($section->exists) {
                continue;
            }

            $images = [];
            foreach ($row['images'] ?? [] as $field => $file) {
                $images[$field] = $this->copyImage($file, "seed-{$key}-{$field}-{$file}");
            }

            $section->fill($row['fields'] + $images + ['status' => true])->save();

            foreach ($row['items'] ?? [] as $group => $items) {
                foreach ($items as $i => $item) {
                    AboutItem::create($item + [
                        'section_key' => $key,
                        'group_key' => $group,
                        'sort_order' => $i + 1,
                        'status' => true,
                    ]);
                }
            }
        }
    }

    private function data(): array
    {
        return [
            'story' => [
                'fields' => [
                    'eyebrow' => 'The Archana Story',
                    'title' => "Rooted in Tradition.\nCurated for Today.",
                    'description' => 'Archana Saree Emporium brings together timeless Indian textiles and a contemporary eye for styling, for women who appreciate quality, craftsmanship and quiet elegance.',
                    'description_2' => 'Every saree is chosen for the way it feels, drapes and photographs in real life, so that what arrives at your door is exactly what you imagined when you first saw it.',
                ],
                'images' => ['image' => 'ower1.jpeg'],
                'items' => ['stats' => [
                    ['value' => '25+', 'title' => 'Years of Experience'],
                    ['value' => '120+', 'title' => 'Curated Collections'],
                    ['value' => '10000+', 'title' => 'Happy Customers'],
                    ['value' => '5000+', 'title' => 'Celebrations Dressed'],
                ]],
            ],

            'who' => [
                'fields' => [
                    'eyebrow' => 'Who We Are',
                    'title' => 'More Than a Saree Store',
                    'description' => 'Archana Saree Emporium is built around one simple idea: helping you find the right saree for the moments that matter. Weddings, festivities, family celebrations and the everyday occasions that deserve a little more grace.',
                    'description_2' => 'We believe a saree is never just a garment. It is a feeling, a tradition passed on and a story you carry from one celebration to the next.',
                    'description_3' => 'Our work is to make that choice feel effortless, personal and beautifully unhurried.',
                    'btn_text' => 'Explore Sarees',
                    'btn_link' => '/products',
                    'tag' => 'Made for Moments',
                ],
                'images' => ['image' => 'ower2.jpeg', 'image_2' => 'ower2.jpeg'],
            ],

            'philosophy' => [
                'fields' => [
                    'eyebrow' => 'Our Philosophy',
                    'title' => 'Elegance Begins With What You Choose.',
                    'description' => 'Four quiet beliefs shape every collection we bring to you.',
                ],
                'items' => ['cards' => [
                    ['title' => 'Timeless Craftsmanship', 'description' => 'Weaves, borders and finishes that reward a closer look and last well beyond a single season.'],
                    ['title' => 'Thoughtful Curation', 'description' => 'Fewer, better pieces, chosen for colour, drape and the occasions they were made for.'],
                    ['title' => 'Authentic Indian Elegance', 'description' => 'Respect for regional textiles, rooted in tradition and styled with a modern point of view.'],
                    ['title' => 'Customer First', 'description' => 'Honest guidance, careful packing and a team that stays with you long after the order.'],
                ]],
            ],

            'art' => [
                'fields' => [
                    'eyebrow' => 'The Art of the Saree',
                    'title' => 'Every Drape Has a Story.',
                    'description' => 'Six yards, countless decisions. Here is what we look at before a saree earns its place in our collection.',
                ],
                'images' => ['image' => 'offer2.png'],
                'items' => [
                    'list' => [
                        ['title' => 'Fabric', 'description' => 'Soft, breathable and kind to the skin.'],
                        ['title' => 'Weave', 'description' => 'Even, dense and true to its tradition.'],
                        ['title' => 'Border', 'description' => 'The frame that gives a drape its character.'],
                        ['title' => 'Embroidery', 'description' => 'Fine, secure and thoughtfully placed.'],
                        ['title' => 'Zari', 'description' => 'A warm glow, never harsh or heavy.'],
                        ['title' => 'Colour', 'description' => 'Rich, balanced and flattering in daylight.'],
                        ['title' => 'Drape', 'description' => 'Falls beautifully and holds its pleats.'],
                        ['title' => 'Occasion', 'description' => 'Chosen for the moment it will be worn in.'],
                    ],
                    'tags' => collect(['Banarasi', 'Kanjivaram', 'Organza', 'Silk', 'Georgette', 'Chiffon', 'Festive', 'Bridal'])
                        ->map(fn($t) => ['title' => $t, 'link' => '/products?q=' . $t])->all(),
                ],
            ],

            'craft' => [
                'fields' => [
                    'eyebrow' => 'Craftsmanship',
                    'title' => "Made to Be Admired.\nChosen to Be Remembered.",
                    'tag' => 'In Detail',
                ],
                'images' => ['image' => 'tab1.png'],
                'items' => ['points' => [
                    ['title' => 'Intricate Details', 'description' => 'Hand-finished borders and delicate embroidery that reveal more the closer you look.'],
                    ['title' => 'Rich Textures', 'description' => 'Fabrics with weight, softness and movement, so every pleat falls the way it should.'],
                    ['title' => 'Timeless Weaves', 'description' => 'Classic patterns and zari work with a quiet, enduring character.'],
                ]],
            ],

            'experience' => [
                'fields' => [
                    'eyebrow' => 'The Archana Experience',
                    'title' => 'An Experience Beyond the Drape',
                    'description' => 'Why shop with us? Because choosing a saree should feel as beautiful as wearing one.',
                    'btn_text' => 'Start Exploring',
                    'btn_link' => '/products',
                ],
                'items' => ['features' => [
                    ['icon' => 'fa-wand-magic-sparkles', 'title' => 'Thoughtfully Curated', 'description' => 'Every piece is selected for beauty, wearability and the way it carries an occasion.'],
                    ['icon' => 'fa-eye', 'title' => 'Quality You Can See', 'description' => 'Honest photography and clear details, so what you see is what you receive.'],
                    ['icon' => 'fa-comments', 'title' => 'Personal Assistance', 'description' => 'Real guidance on colour, fabric and styling, whenever you need it.'],
                    ['icon' => 'fa-calendar-check', 'title' => 'Made for Every Occasion', 'description' => 'From intimate gatherings to grand weddings, there is a drape for every moment.'],
                ]],
            ],

            'how' => [
                'fields' => ['title' => 'How It Works'],
                'items' => ['steps' => [
                    ['title' => 'Thoughtful Curation', 'description' => 'Fewer, better pieces, chosen for colour, drape and the occasions they were made for.'],
                    ['title' => 'Personal Assistance', 'description' => 'Real guidance on colour, fabric and styling, whenever you need it.'],
                    ['title' => 'Reliable Delivery & Support', 'description' => 'Packed with care, delivered on time, help one message away.'],
                ]],
            ],

            'why' => [
                'fields' => [
                    'eyebrow' => 'Why Choose Us',
                    'title' => 'Why Women Choose Archana',
                    'description' => 'Six reasons our customers return, season after season.',
                ],
                'items' => ['reasons' => [
                    ['icon' => 'fa-layer-group', 'title' => 'Curated Saree Collections', 'description' => 'Handpicked styles, never a crowded catalogue.'],
                    ['icon' => 'fa-gem', 'title' => 'Premium Fabrics & Finishes', 'description' => 'Rich textiles with a finish that lasts.'],
                    ['icon' => 'fa-champagne-glasses', 'title' => 'Styles for Every Occasion', 'description' => 'Weddings, festivals, parties and everyday grace.'],
                    ['icon' => 'fa-hand-holding-heart', 'title' => 'Personalised Assistance', 'description' => 'Advice that feels like it comes from a friend.'],
                    ['icon' => 'fa-shield-halved', 'title' => 'Secure Shopping', 'description' => 'Safe payments and careful handling of your details.'],
                    ['icon' => 'fa-truck-fast', 'title' => 'Reliable Delivery & Support', 'description' => 'Packed with care, delivered on time, help one message away.'],
                ]],
            ],

            'quote' => [
                'fields' => [
                    'title' => "Some sarees are worn for an occasion.\nThe unforgettable ones become part of the memory.",
                    'tag' => 'Archana Saree Emporium',
                ],
                'images' => ['image' => 'offer2.png'],
            ],
        ];
    }

    /** Copy public/assets/images/home/{file} into storage/app/public/about under a unique name. */
    private function copyImage(string $file, string $as): ?string
    {
        $from = public_path('assets/images/home/' . $file);

        if (!File::exists($from)) {
            $this->command?->warn("About image not found: {$file}");

            return null;
        }

        $to = 'about/' . $as;

        if (!Storage::disk('public')->exists($to)) {
            Storage::disk('public')->put($to, File::get($from));
        }

        return $to;
    }
}