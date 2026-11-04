<?php

namespace Database\Seeders;

use App\Models\HomeCampaign;
use App\Models\HomeReel;
use App\Models\HomeSlider;
use App\Models\HomeStory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $this->sliders();
        $this->campaign();
        $this->story();
        $this->reels();

        // Add the next home sections here, one method each
    }

    /* ------------------------------------------------------------------
     | Hero sliders
     | Copies the existing static banners from public/assets/images/home
     | into storage/app/public/home-sliders so asset('storage/...') works.
     | Safe to re-run: a slide is matched by its title and never duplicated.
     ------------------------------------------------------------------ */
    private function sliders(): void
    {
        $slides = [
            [
                'source' => 'banner1.png',
                'eyebrow' => 'The Archana Edit',
                'title' => "Dress the Moment.\nRemember the Look.",
                'description' => 'Discover premium sarees, statement lehengas and exquisite bridal wear, thoughtfully curated for weddings, festivities and every occasion worth dressing up for.',
                'primary_btn_text' => 'Shop the Collection',
                'primary_btn_link' => '/products',
                'secondary_btn_text' => 'Explore Bridal Wear',
                'secondary_btn_link' => '/categories',
                'note' => 'Sarees · Lehengas · Bridal Wear',
                'theme' => 'default',
                'sort_order' => 1,
            ],
            [
                'source' => 'banner2.png',
                'eyebrow' => 'The Lehenga Edit',
                'title' => "Statement Silhouettes.\nMade to Be Remembered.",
                'description' => 'Designer lehengas with fine embroidery and rich fabrics, for sangeet nights, receptions and every celebration in between.',
                'primary_btn_text' => 'Shop Lehengas',
                'primary_btn_link' => '/products',
                'secondary_btn_text' => 'Explore Bridal Wear',
                'secondary_btn_link' => '/categories',
                'note' => 'Sarees · Lehengas · Bridal Wear',
                'theme' => 'white',
                'sort_order' => 2,
            ],
        ];

        foreach ($slides as $s) {
            $image = $this->copyFile('assets/images/home/' . $s['source'], 'home-sliders');

            if (!$image) {
                $this->command?->warn("Slider skipped (image not found): {$s['source']}");
                continue;
            }

            unset($s['source']);

            HomeSlider::firstOrCreate(
                ['title' => $s['title']],
                $s + ['image' => $image, 'status' => true]
            );
        }
    }

    /* ------------------------------------------------------------------
     | Lehenga campaign (home-secE), single row
     | Created only when the table is empty, so re-running never overwrites
     | what the admin has edited.
     ------------------------------------------------------------------ */
    private function campaign(): void
    {
        if (HomeCampaign::exists()) {
            return;
        }

        HomeCampaign::create(HomeCampaign::DEFAULTS + [
            'primary_btn_link' => '/products',
            'secondary_btn_link' => '/categories',
            'bg_image' => $this->copyFile('assets/images/home/banner5.jpg', 'home-campaign'),
            'image' => $this->copyFile('assets/images/home/upper11zon.jpg', 'home-campaign'),
        ]);
    }

    /* ------------------------------------------------------------------
     | Our Story + Meet the Founder (home-secM), single row
     | btn_link is left empty on purpose: set it to your About page in admin,
     | and the button appears.
     ------------------------------------------------------------------ */
    private function story(): void
    {
        if (HomeStory::exists()) {
            return;
        }

        HomeStory::create(HomeStory::DEFAULTS + [
            'main_image' => $this->copyFile('assets/images/home/ower1.jpeg', 'home-story'),
            'small_image' => $this->copyFile('assets/images/home/ower2.jpeg', 'home-story'),
            'founder_photo' => $this->copyFile('assets/images/home/ower1.jpeg', 'home-story', 'seed-founder-ower1.jpeg'),
        ]);
    }

    /* ------------------------------------------------------------------
     | Reels (home-secS)
     | Matched by title, so re-running never duplicates a reel.
     | All six use the one sample video from public/assets/video/reel.mp4.
     ------------------------------------------------------------------ */
    private function reels(): void
    {
        $reels = [
            ['reel1.jpeg', 'New Arrival', 'Fresh drops, just in.'],
            ['reel2.jpeg', 'Bridal Edit', 'Made for the big day.'],
            ['reel3.jpeg', 'Saree Styling', 'Drapes, pleats and more.'],
            ['reel4.jpeg', 'Festive Look', 'Dressed for the season.'],
            ['reel5.jpeg', 'Wedding Inspiration', 'Ideas for every ceremony.'],
            ['reel6.jpeg', 'Behind the Collection', 'Where every piece begins.'],
        ];

        $video = $this->copyFile('assets/video/reel.mp4', 'home-reels/videos');

        foreach ($reels as $i => [$file, $title, $subtitle]) {
            $thumb = $this->copyFile('assets/images/home/' . $file, 'home-reels');

            if (!$thumb) {
                $this->command?->warn("Reel skipped (image not found): {$file}");
                continue;
            }

            HomeReel::firstOrCreate(
                ['title' => $title],
                [
                    'subtitle' => $subtitle,
                    'thumbnail' => $thumb,
                    'video' => $video,
                    'sort_order' => $i + 1,
                    'status' => true,
                ]
            );
        }
    }

    /**
     * Copy a file from /public to the public disk.
     * $from is relative to public/ (e.g. assets/images/home/banner1.png).
     * Returns the storage path, or null if the source file is missing.
     */
    private function copyFile(string $from, string $folder, ?string $as = null): ?string
    {
        $source = public_path($from);

        if (!File::exists($source)) {
            return null;
        }

        $to = trim($folder, '/') . '/' . ($as ?? 'seed-' . basename($from));

        if (!Storage::disk('public')->exists($to)) {
            Storage::disk('public')->put($to, File::get($source));
        }

        return $to;
    }
}