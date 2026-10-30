<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\GiftingOccasion;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $attrs       = Attribute::with('values')->get()->keyBy('slug');
        $collections = Collection::pluck('id');
        $occasions   = GiftingOccasion::pluck('id');
        $brands      = Brand::pluck('id');

        // purane demo products hatao (pehle har sub-category me bante the, ab sirf 5-6 per category)
        Product::withTrashed()->where('sku', 'like', 'ARC-DEMO-%')->get()->each(function ($p) {
            $p->attributeValues()->delete();
            $p->addons()->delete();
            $p->collections()->sync([]);
            $p->occasions()->sync([]);
            $p->forceDelete();
        });

        // [min products, max products, mrp min, mrp max]
        $config = [
            'sarees'      => [5, 6, 3000, 25000],
            'lehengas'    => [5, 6, 12000, 60000],
            'suits'       => [5, 6, 2500, 12000],
            'accessories' => [5, 6, 500, 5000],
        ];

        // category-wise addons: [detail, description, price]
        $addonsByCat = [
            'sarees' => [
                ['Fall & Pico', 'Stitched and ready to drape', 250],
                ['Matching Petticoat', 'Cotton, drawstring waist', 399],
                ['Blouse Stitching', 'Stitched to your size, ready in 5–7 days', 499],
            ],
            'lehengas' => [
                ['Can-Can Underskirt', 'Adds volume and flare to the lehenga', 799],
                ['Blouse Alteration', 'Custom fitting to your measurements', 499],
            ],
            'suits' => [
                ['Stitching Service', 'Stitched to your size, ready in 5–7 days', 699],
                ['Dupatta Fall & Pico', 'Finished edges for a clean drape', 150],
            ],
            'accessories' => [
                ['Gift Wrapping', 'Premium gift box with a message card', 99],
            ],
        ];

        $discounts = [0, 10, 20, 25, 30, 35];

        foreach ($config as $catSlug => [$minCount, $maxCount, $lo, $hi]) {
            $category = Category::where('slug', $catSlug)->firstOrFail();
            $subs     = $category->children->values();
            $count    = rand($minCount, $maxCount);

            for ($n = 1; $n <= $count; $n++) {
                // sub-categories me barabar baant do
                $sub = $subs[($n - 1) % $subs->count()];

                $sku = 'ARC-DEMO-' . strtoupper(substr($catSlug, 0, 3)) . '-' . str_pad($n, 3, '0', STR_PAD_LEFT);

                $fabric = $attrs['fabric']->values->random();
                $colour = $attrs['colour']->values->random();
                $name   = "{$colour->value} {$fabric->value} " . Str::singular($sub->name);

                $mrp   = (int) (round(rand($lo, $hi) / 100) * 100);
                $pct   = $discounts[array_rand($discounts)];
                $price = max(100, (int) (round($mrp * (100 - $pct) / 100 / 100) * 100));

                // colour customization: sirf clothing categories me, kuch products par
                $isClothing = $catSlug !== 'accessories';
                $dyeable    = $isClothing && rand(1, 3) === 1;

                $product = Product::updateOrCreate(['sku' => $sku], [
                    'category_id'         => $category->id,
                    'subcategory_id'      => $sub->id,
                    'brand_id'            => $brands->isNotEmpty() ? $brands->random() : null,
                    'name'                => $name,
                    'slug'                => Str::slug($name) . '-' . strtolower(substr($sku, -7)),
                    'short_description'   => "Beautiful {$name} for every occasion.",

                    'fabric_material'     => "<p>{$fabric->value} fabric with a soft, graceful drape, thoughtfully curated by Archana Saree Emporium.</p>",
                    'care_instructions'   => '<ul><li>Dry clean only</li><li>Iron on low heat</li><li>Store in a muslin cloth</li></ul>',
                    // shipping / returns / offers khali: detail page default policy aur coupons dikhayega
                    'shipping_delivery'   => null,
                    'returns_exchange'    => null,
                    'offers_how_to_avail' => null,

                    'mrp'                 => $mrp,
                    'discount_type'       => 'percentage',
                    'discount'            => $pct,
                    'price'               => $price,

                    'stock'               => rand(5, 60),
                    'min_qty'             => 1,
                    'delivery_time'       => '2–4 days',

                    'colour_customization' => $dyeable,
                    'dye_price'            => $dyeable ? collect([300, 500, 750])->random() : null,

                    'meta_title'          => "{$name} | Archana Saree Emporium",
                    'meta_description'    => "Shop {$name} online at Archana Saree Emporium. Authentic craftsmanship with pan-India delivery.",

                    'status'              => 1,
                ]);

                // attribute values
                $rows = [];
                $add = function (string $slug, $values) use (&$rows, $attrs) {
                    foreach ($values as $v) {
                        $rows[] = ['attribute_id' => $attrs[$slug]->id, 'attribute_value_id' => $v->id];
                    }
                };
                $pick = fn (string $slug, int $n = 1) => $attrs[$slug]->values->random($n);
                $val  = fn (string $slug, string $label) => $attrs[$slug]->values->firstWhere('value', $label);

                $add('fabric', collect([$fabric]));
                $add('colour', collect([$colour]));

                if ($catSlug === 'sarees') {
                    $add('work-embellishment', $pick('work-embellishment', rand(1, 3)));
                    $add('pattern', $pick('pattern'));
                    $add('border-type', $pick('border-type'));
                    $add('weaving-technique', $pick('weaving-technique'));
                    $add('saree-length', $pick('saree-length'));

                    // Blouse chain: Piece → Type → Size (admin form ke rules jaisa hi)
                    $included = rand(1, 5) !== 1; // ~80% me blouse piece included
                    $add('blouse-piece', collect([$val('blouse-piece', $included ? 'Included' : 'Not Included')]));

                    if ($included) {
                        $stitched = rand(0, 1) === 1;
                        $add('blouse-piece-type', collect([$val('blouse-piece-type', $stitched ? 'Stitched' : 'Unstitched')]));

                        if ($stitched) {
                            $add('blouse-size', $pick('blouse-size', rand(3, 5)));
                        }
                    }
                } elseif (in_array($catSlug, ['lehengas', 'suits'])) {
                    $add('size', $pick('size', 3));
                    $add('work-embellishment', $pick('work-embellishment', rand(1, 3)));
                    $add('pattern', $pick('pattern'));
                }

                $product->attributeValues()->delete();
                $product->attributeValues()->createMany($rows);

                // addons: har run par reset, taaki seeder dobara chalane par duplicate na bane
                $product->addons()->delete();
                $addonPool = collect($addonsByCat[$catSlug] ?? []);
                if ($addonPool->isNotEmpty() && rand(1, 4) !== 1) { // ~25% products me koi addon nahi
                    $addonPool->random(rand(1, $addonPool->count()))->each(function ($a) use ($product) {
                        $product->addons()->create([
                            'detail'      => $a[0],
                            'description' => $a[1],
                            'price'       => $a[2],
                        ]);
                    });
                }

                // collections: kuch products ka koi badge nahi hoga
                $product->collections()->sync(
                    rand(1, 5) === 1 ? [] : $collections->random(rand(1, 2))->all()
                );
                $product->occasions()->sync($occasions->random(rand(1, 3))->all());
            }
        }
    }
}