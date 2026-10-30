<?php

namespace Database\Seeders;

use App\Models\Attribute;
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

        // [products per sub-category, mrp min, mrp max]
        $config = [
            'sarees'      => [4, 3000, 25000],
            'lehengas'    => [3, 12000, 60000],
            'suits'       => [3, 2500, 12000],
            'accessories' => [3, 500, 5000],
        ];

        $discounts = [0, 10, 20, 25, 30, 35];

        foreach ($config as $catSlug => [$perSub, $lo, $hi]) {
            $category = Category::where('slug', $catSlug)->firstOrFail();
            $n = 0;

            foreach ($category->children as $sub) {
                for ($i = 0; $i < $perSub; $i++) {
                    $n++;
                    $sku = 'ARC-DEMO-' . strtoupper(substr($catSlug, 0, 3)) . '-' . str_pad($n, 3, '0', STR_PAD_LEFT);

                    $fabric = $attrs['fabric']->values->random();
                    $colour = $attrs['colour']->values->random();
                    $name   = "{$colour->value} {$fabric->value} " . Str::singular($sub->name);

                    $mrp   = (int) (round(rand($lo, $hi) / 100) * 100);
                    $pct   = $discounts[array_rand($discounts)];
                    $price = max(100, (int) (round($mrp * (100 - $pct) / 100 / 100) * 100));

                    $product = Product::updateOrCreate(['sku' => $sku], [
                        'category_id'       => $category->id,
                        'subcategory_id'    => $sub->id,
                        'name'              => $name,
                        'slug'              => Str::slug($name) . '-' . strtolower(substr($sku, -7)),
                        'product_code'      => $sku,
                        'short_description' => "Beautiful {$name} for every occasion.",
                        'description'       => "<p>{$name}, thoughtfully curated by Archana Saree Emporium.</p>",
                        'mrp'               => $mrp,
                        'discount_type'     => 'percentage',
                        'discount'          => $pct,
                        'price'             => $price,
                        'stock'             => rand(5, 60),
                        'status'            => 1,
                    ]);

                    // attribute values
                    $rows = [];
                    $add = function (string $slug, $values) use (&$rows, $attrs) {
                        foreach ($values as $v) {
                            $rows[] = ['attribute_id' => $attrs[$slug]->id, 'attribute_value_id' => $v->id];
                        }
                    };
                    $pick = fn (string $slug, int $n = 1) => $attrs[$slug]->values->random($n);

                    $add('fabric', collect([$fabric]));
                    $add('colour', collect([$colour]));

                    if ($catSlug === 'sarees') {
                        $add('work-embellishment', $pick('work-embellishment', rand(1, 3)));
                        $add('pattern', $pick('pattern'));
                        $add('border-type', $pick('border-type'));
                        $add('weaving-technique', $pick('weaving-technique'));
                        $add('blouse-piece', $pick('blouse-piece'));
                        $add('blouse-piece-type', $pick('blouse-piece-type'));
                        $add('saree-length', $pick('saree-length'));
                    } elseif (in_array($catSlug, ['lehengas', 'suits'])) {
                        $add('size', $pick('size', 3));
                        $add('work-embellishment', $pick('work-embellishment', rand(1, 3)));
                        $add('pattern', $pick('pattern'));
                    }

                    $product->attributeValues()->delete();
                    $product->attributeValues()->createMany($rows);

                    // collections: kuch products ka koi badge nahi hoga
                    $product->collections()->sync(
                        rand(1, 5) === 1 ? [] : $collections->random(rand(1, 2))->all()
                    );
                    $product->occasions()->sync($occasions->random(rand(1, 3))->all());
                }
            }
        }
    }
}