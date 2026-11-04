<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $author = 'Archana Style Team';

        $posts = [
            [
                'title'    => 'How to Choose the Perfect Bridal Saree for Your Big Day',
                'category' => 'Bridal Edit',
                'date'     => '2026-10-22',
                'image'    => 'offer2.png',
                'tags'     => 'Bridal Wear, Silk Sarees, Buying Guide',
                'featured' => true,
                'short'    => 'From fabric and colour to zari and drape, here is a simple guide to finding a bridal saree that feels like it was made for you.',
                'content'  => <<<'HTML'
<p>A bridal saree is chosen once and remembered for a lifetime. Here is a <strong>simple checklist</strong> to help you pick the right one before you order.</p>

<h2>1. Start with the occasion</h2>
<p>A wedding ceremony, a reception and an engagement each call for a different look. Decide the event first, then the colour and fabric will follow naturally.</p>

<h2>2. Pick a fabric that suits you</h2>
<p>Different fabrics drape and feel different. Think about <em>how long you will wear it</em> and the season of the wedding.</p>
<ul>
  <li><strong>Kanjivaram silk:</strong> rich, structured and long lasting.</li>
  <li><strong>Banarasi:</strong> fine zari work with a regal glow.</li>
  <li><strong>Organza:</strong> light, airy and graceful in warm weather.</li>
</ul>

<h2>3. Check the details that matter</h2>
<p>Small things make a big difference on the day. Look at these points before you decide:</p>
<ol>
  <li>Weave that is even, dense and true to its tradition.</li>
  <li>Zari that glows warmly and is never harsh or heavy.</li>
  <li>Embroidery that is fine, secure and thoughtfully placed.</li>
  <li>A drape that falls well and holds its pleats.</li>
</ol>

<blockquote>The best bridal saree is the one that feels like you the moment you drape it.</blockquote>

<h3>Keep comfort in the picture</h3>
<p>You will wear it for hours, so choose a weight and finish that feel comfortable. Not sure what suits you? Reach us through the contact page and our team will help.</p>
HTML,
            ],
            [
                'title'    => '5 Ways to Style a Banarasi Saree for Festive Evenings',
                'category' => 'Styling',
                'date'     => '2026-10-18',
                'image'    => 'cat1.png',
                'tags'     => 'Banarasi, Styling, Festive',
                'short'    => 'Simple styling ideas to make a classic Banarasi feel fresh, modern and effortless.',
                'content'  => <<<'HTML'
<p>A Banarasi saree already does the heavy lifting. These five ideas keep it elegant without making it feel heavy.</p>
<h2>1. Let the saree lead</h2>
<p>Keep jewellery minimal and let the zari work take centre stage.</p>
<h2>2. Try a contrast blouse</h2>
<p>A solid, contrasting blouse brings a modern edge to a traditional weave.</p>
<h2>3. Play with the drape</h2>
<p>A neat pleated pallu suits formal evenings, while an open pallu feels relaxed and festive.</p>
<h2>4. Choose one statement piece</h2>
<p>Pick either earrings or a necklace, not both, so the look stays balanced.</p>
<h2>5. Finish with a simple clutch</h2>
<p>A metallic or embroidered clutch ties the outfit together without competing with it.</p>
HTML,
            ],
            [
                'title'    => 'How to Care for Your Silk Sarees So They Last for Years',
                'category' => 'Saree Care',
                'date'     => '2026-10-14',
                'image'    => 'tab2.png',
                'tags'     => 'Silk Sarees, Saree Care',
                'short'    => 'Storage, folding and cleaning tips that protect the weave, zari and colour.',
                'content'  => <<<'HTML'
<p>Silk sarees are an investment. A little care after every wear keeps the weave, zari and colour looking new.</p>
<h2>Store them the right way</h2>
<p>Wrap each saree in a soft muslin or cotton cloth. Avoid plastic covers, as silk needs to breathe.</p>
<h2>Refold regularly</h2>
<p>Change the folds every few months so the fabric does not weaken along the same lines.</p>
<h2>Clean with care</h2>
<p>Dry clean heavily worked sarees. Air them in the shade after wearing, and keep perfume and sprays away from the fabric.</p>
HTML,
            ],
            [
                'title'    => 'Designer Lehenga Trends to Watch This Wedding Season',
                'category' => 'Trends',
                'date'     => '2026-10-09',
                'image'    => 'cat2.png',
                'tags'     => 'Lehenga, Wedding, Trends',
                'short'    => "Silhouettes, colours and embroidery that are shaping this season's celebrations.",
                'content'  => <<<'HTML'
<p>This wedding season, lehengas are balancing tradition with a lighter, more wearable feel.</p>
<h2>Softer colour palettes</h2>
<p>Pastels and muted jewel tones are standing alongside classic reds and maroons.</p>
<h2>Lighter embroidery</h2>
<p>Fine thread work and sequins in measured amounts are replacing heavy, all-over embellishment.</p>
<h2>Flowing silhouettes</h2>
<p>Flared skirts with a graceful fall are easier to move in and photograph beautifully.</p>
HTML,
            ],
            [
                'title'    => "A Beginner's Guide to Draping the Perfect Saree Pleats",
                'category' => 'Draping',
                'date'     => '2026-10-04',
                'image'    => 'tab3.png',
                'tags'     => 'Draping, Beginners, Saree Guide',
                'short'    => 'Easy steps to get neat pleats and a graceful fall, even if you are new to sarees.',
                'content'  => <<<'HTML'
<p>Neat pleats are the secret to a graceful drape. Here is a simple way to get them right.</p>
<ol>
  <li>Tuck the plain end of the saree into your petticoat and wrap it once around.</li>
  <li>Make 5 to 7 even pleats, each about a hand's width.</li>
  <li>Hold the pleats together and tuck them in at the navel, facing left.</li>
  <li>Bring the remaining fabric over the shoulder and pin the pallu in place.</li>
</ol>
<p>Practise a few times before the day. Pleats get easier with every attempt.</p>
HTML,
            ],
            [
                'title'    => 'The Story Behind the Kanjivaram: Weaving a Legacy in Silk',
                'category' => 'Heritage',
                'date'     => '2026-09-29',
                'image'    => 'cat4.png',
                'tags'     => 'Kanjivaram, Heritage, Silk Sarees',
                'short'    => 'Why this South Indian classic remains a timeless favourite for every occasion.',
                'content'  => <<<'HTML'
<p>The Kanjivaram is woven in a tradition that has been passed down through generations of weavers.</p>
<h2>A craft of patience</h2>
<p>Each saree is woven on a handloom, with rich silk and zari worked together for strength and shine.</p>
<h2>Why it lasts</h2>
<p>The dense weave gives the saree its body, so it holds its drape and can be worn for many years.</p>
<h2>For every occasion</h2>
<p>From weddings to festivals, a Kanjivaram remains a classic choice.</p>
HTML,
            ],
            [
                'title'    => 'What to Wear to a Wedding: A Saree Guide for Every Role',
                'category' => 'Guides',
                'date'     => '2026-09-24',
                'image'    => 'tab4.png',
                'tags'     => 'Wedding Guest, Occasion Wear, Buying Guide',
                'short'    => "From the bride's family to the guest list, find the right drape for every wedding event.",
                'content'  => <<<'HTML'
<p>Weddings have many events, and every role calls for a slightly different look.</p>
<h2>Family of the bride or groom</h2>
<p>Rich silks and Banarasi sarees in deep, celebratory colours suit the main ceremonies.</p>
<h2>Close friends and relatives</h2>
<p>Choose elegant sarees with tasteful detailing, and avoid outshining the couple.</p>
<h2>Guests at the reception</h2>
<p>Lighter fabrics such as organza or georgette are comfortable for long evenings.</p>
HTML,
            ],
            [
                'title'    => 'Diwali Dressing: Sarees That Sparkle Without Trying Too Hard',
                'category' => 'Festive',
                'date'     => '2026-09-19',
                'image'    => 'cat3.png',
                'tags'     => 'Diwali, Festive, Party Wear',
                'short'    => 'Elegant festive picks in colours and fabrics that glow in candlelight.',
                'content'  => <<<'HTML'
<p>Diwali dressing is about warmth and glow. The right saree does this without effort.</p>
<h2>Colours that glow</h2>
<p>Deep greens, rich golds and warm pinks look beautiful in candlelight.</p>
<h2>Fabrics that move</h2>
<p>Silk blends and soft organza catch the light and drape gracefully.</p>
<h2>Keep it simple</h2>
<p>Let one element shine, whether the zari border, the blouse or the jewellery.</p>
HTML,
            ],
            [
                'title'    => 'Organza, Georgette or Chiffon? Choosing the Right Fabric',
                'category' => 'Fabric Guide',
                'date'     => '2026-09-14',
                'image'    => 'tab1.png',
                'tags'     => 'Fabric Guide, Organza, Georgette, Chiffon',
                'short'    => 'A quick comparison of drape, weight and comfort to help you pick with confidence.',
                'content'  => <<<'HTML'
<p>Light fabrics look similar on a hanger but behave differently when worn.</p>
<ul>
  <li><strong>Organza:</strong> crisp and structured, with a delicate sheen.</li>
  <li><strong>Georgette:</strong> slightly textured, flowy and easy to drape.</li>
  <li><strong>Chiffon:</strong> very light and sheer, with a soft, floating fall.</li>
</ul>
<p>Choose organza for structure, georgette for easy movement, and chiffon for a light, airy feel.</p>
HTML,
            ],
            [
                'title'    => 'Behind the Counter: How We Curate Every Saree We Sell',
                'category' => 'Our Story',
                'date'     => '2026-09-08',
                'image'    => 'ower2.jpeg',
                'tags'     => 'Our Story, Craftsmanship',
                'short'    => 'A look at the details we check before a saree earns its place in our collection.',
                'content'  => <<<'HTML'
<p>Every saree in our collection is checked before it reaches you.</p>
<h2>What we look at</h2>
<p>We check the weave, the finish of the zari and embroidery, the colour consistency and the way the fabric falls.</p>
<h2>Why it matters</h2>
<p>A saree is worn at the moments that matter, so we only choose pieces we would be proud to wear ourselves.</p>
HTML,
            ],
        ];

        foreach ($posts as $p) {
            $slug = Str::slug($p['title']);

            Blog::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'             => $p['title'],
                    'category'          => $p['category'],
                    'author'            => $author,
                    'tags'              => $p['tags'],
                    'published_at'      => $p['date'],
                    'image'             => $this->copyImage($p['image']),
                    'short_description' => $p['short'],
                    'content'           => $p['content'],
                    'meta_title'        => $p['title'],
                    'meta_description'  => $p['short'],
                    'show_home'         => false,
                    'is_featured'       => $p['featured'] ?? false,
                    'status'            => true,
                ]
            );
        }
    }

    /** Copies a theme image into storage/app/public/blogs and returns the stored path */
    private function copyImage(string $file): ?string
    {
        $source = public_path('assets/images/home/' . $file);

        if (! File::exists($source)) {
            return null; // the post will use the default banner image
        }

        $target = 'blogs/seed-' . $file;

        if (! Storage::disk('public')->exists($target)) {
            Storage::disk('public')->put($target, File::get($source));
        }

        return $target;
    }
}