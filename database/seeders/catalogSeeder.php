<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Collection;
use App\Models\GiftingOccasion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    private const T_BUTTON = 'button';        // DB me "Button" capital B se save hota ho to yahan badal do
    private const T_SWATCH = 'color_swatch';

    public function run(): void
    {
        $this->categories();
        $attrs = $this->attributes();
        $this->categoryAttributes($attrs);
        $this->occasions();
        $this->collections();
    }

    private function categories(): void
    {
        $tree = [
            'Sarees' => [
                'Timeless drapes, beautiful craftsmanship.',
                ['Banarasi Sarees', 'Silk Sarees', 'Organza Sarees', 'Georgette Sarees', 'Party Wear Sarees', 'Bridal Sarees', 'Designer Sarees'],
            ],
            'Lehengas' => [
                'Statement silhouettes for every grand occasion.',
                ['Bridal Lehengas', 'Designer Lehengas', 'Party Wear Lehengas', 'Wedding Lehengas', 'Reception Lehengas'],
            ],
            'Suits' => [
                'Graceful suits for everyday elegance and festive moments.',
                ['Anarkali Suits', 'Straight Suits', 'Palazzo Suits', 'Sharara Suits'],
            ],
            'Accessories' => [
                'Finishing touches for every look.',
                ['Dupattas', 'Potli Bags', 'Jewellery'],
            ],
        ];

        $n = 1;
        foreach ($tree as $name => [$subTitle, $children]) {
            $parent = Category::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'parent_id' => null,
                'sub_title' => $subTitle,
                'meta_title' => "$name | Archana Saree Emporium",
                'meta_description' => "Shop $name at Archana Saree Emporium.",
                'sort_order' => $n++,
                'status' => 1,
                'is_popular' => 1,
                'is_featured' => 1,
                'show_in_navbar' => 1,
            ]);

            foreach ($children as $i => $child) {
                Category::updateOrCreate(['slug' => Str::slug($child)], [
                    'name' => $child,
                    'parent_id' => $parent->id,
                    'meta_title' => "$child | Archana Saree Emporium",
                    'meta_description' => "Shop $child at Archana Saree Emporium.",
                    'sort_order' => $i + 1,
                    'status' => 1,
                    'is_popular' => 0,
                    'is_featured' => 0,
                    'show_in_navbar' => 1,
                ]);
            }
        }
    }

    private function attributes(): array
    {
        $colours = [
            ['Red', '#B3203C'],
            ['Maroon', '#6E1423'],
            ['Pink', '#E79AA8'],
            ['Rani Pink', '#E0218A'],
            ['Orange', '#F28C28'],
            ['Yellow', '#F2C94C'],
            ['Green', '#1F6B4F'],
            ['Blue', '#2B3A7A'],
            ['Navy Blue', '#14213D'],
            ['Purple', '#6A2C91'],
            ['Black', '#222222'],
            ['White', '#FFFFFF'],
            ['Cream', '#F3ECD9'],
            ['Beige', '#D9C3A0'],
            ['Gold', '#C9A227'],
            ['Silver', '#C0C0C0'],
            ['Multicolour', '#CCCCCC'],
        ];

        $defs = [
            'fabric' => ['Fabric', self::T_BUTTON, ['Silk', 'Art Silk', 'Cotton', 'Georgette', 'Chiffon', 'Net', 'Organza', 'Crepe', 'Satin', 'Velvet', 'Linen', 'Tissue']],
            'colour' => ['Colour', self::T_SWATCH, $colours],
            'size' => ['Size', self::T_BUTTON, ['Small', 'Large', 'XL', 'XXL', 'Free Size', 'Unstitched', '24', '26', '28', '30', '32']],
            'work-embellishment' => ['Work Embellishment', self::T_BUTTON, ['Zari Work', 'Embroidery', 'Zardozi', 'Sequins', 'Stone Work', 'Mirror Work', 'Resham Work', 'Thread Work', 'Cutwork', 'Printed', 'Plain']],
            'pattern' => ['Pattern', self::T_BUTTON, ['Floral', 'Geometric', 'Striped', 'Checked', 'Paisley', 'Butti', 'Abstract', 'Traditional', 'Plain', 'All-over Print']],
            'border-type' => ['Border Type', self::T_BUTTON, ['Zari Border', 'Contrast Border', 'Embroidered Border', 'Temple Border', 'Plain Border', 'No Border']],
            'weaving-technique' => ['Weaving Technique', self::T_BUTTON, ['Handloom', 'Powerloom', 'Handwoven', 'Machine-made', 'Printed']],
            'blouse-piece' => ['Blouse Piece', self::T_BUTTON, ['Included', 'Not Included']],
            'blouse-size' => ['Blouse Size', self::T_BUTTON, ['S', 'M', 'L', 'XL', 'XXL']],
            'blouse-piece-type' => ['Blouse Piece Type', self::T_BUTTON, ['Unstitched', 'Stitched', 'Not Applicable']],
            'saree-length' => ['Saree Length', self::T_BUTTON, ['5.5 m', '6 m', 'Other']],
        ];

        $models = [];
        $usedSlugs = [];

        foreach ($defs as $slug => [$name, $type, $values]) {
            $attr = Attribute::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'type' => $type,
                'has_values' => !empty($values),
                'status' => 1,
                'show_in_navbar' => in_array($slug, ['fabric', 'colour']),
            ]);
            $models[$slug] = $attr;

            foreach ($values as $i => $v) {
                [$label, $hex] = is_array($v) ? $v : [$v, null];

                // "plain", "printed", "unstitched" jaise naam do attributes me aate hain
                $valueSlug = Str::slug($label);
                if (isset($usedSlugs[$valueSlug]) && $usedSlugs[$valueSlug] !== $slug) {
                    $valueSlug = $slug . '-' . $valueSlug;
                }
                $usedSlugs[$valueSlug] = $slug;

                AttributeValue::updateOrCreate(
                    ['attribute_id' => $attr->id, 'value' => $label],
                    ['slug' => $valueSlug, 'hex_code' => $hex, 'sort_order' => $i + 1, 'status' => 1]
                );
            }
        }

        return $models;
    }

    private function categoryAttributes(array $attrs): void
    {
        // filter = show_in_filter, listing = show_on_listing, variant = used_for_variant,
        // selectable = customer product page par chunta hai, parent = [attribute slug, [parent ki values jab dikhe]]
        $sizeVariant = ['filter' => 1, 'variant' => 1, 'price' => 1, 'stock' => 1];
        $colourVariant = ['filter' => 1, 'variant' => 1, 'image' => 1];

        $map = [
            'sarees' => [
                'fabric' => ['filter' => 1, 'listing' => 1],
                'colour' => $colourVariant,
                'work-embellishment' => ['filter' => 1],
                'pattern' => ['filter' => 1],
                'border-type' => ['filter' => 1],
                'weaving-technique' => ['filter' => 1],
                'blouse-piece' => ['selectable' => 1],
                'blouse-piece-type' => ['selectable' => 1, 'parent' => ['blouse-piece', ['Included']]],
                'blouse-size' => ['selectable' => 1, 'parent' => ['blouse-piece-type', ['Stitched']]],
                'saree-length' => [],
            ],
            'lehengas' => [
                'fabric' => ['filter' => 1, 'listing' => 1],
                'colour' => $colourVariant,
                'size' => $sizeVariant,
                'work-embellishment' => ['filter' => 1],
                'pattern' => ['filter' => 1],
            ],
            'suits' => [
                'fabric' => ['filter' => 1, 'listing' => 1],
                'colour' => $colourVariant,
                'size' => $sizeVariant,
                'work-embellishment' => ['filter' => 1],
                'pattern' => ['filter' => 1],
            ],
            'accessories' => [
                'colour' => ['filter' => 1],
                'fabric' => ['filter' => 1],
            ],
        ];

        foreach ($map as $catSlug => $rows) {
            $category = Category::where('slug', $catSlug)->firstOrFail();
            $order = 1;
            $created = [];

            // pass 1: mappings (parent abhi null, kyunki parent ki id baad me milti hai)
            foreach ($rows as $attrSlug => $f) {
                $created[$attrSlug] = CategoryAttribute::updateOrCreate(
                    ['category_id' => $category->id, 'attribute_id' => $attrs[$attrSlug]->id],
                    [
                        'used_for_variant' => $f['variant'] ?? 0,
                        'is_selectable' => ($f['variant'] ?? 0) || ($f['selectable'] ?? 0),
                        'parent_category_attribute_id' => null,
                        'show_when_value_ids' => null,
                        'price_dependent' => $f['price'] ?? 0,
                        'image_dependent' => $f['image'] ?? 0,
                        'stock_dependent' => $f['stock'] ?? 0,
                        'sku_dependent' => 0,
                        'show_in_filter' => $f['filter'] ?? 0,
                        'show_on_listing' => $f['listing'] ?? 0,
                        'sort_order' => $order++,
                        'status' => 1,
                    ]
                );
            }

            // pass 2: dependency chain
            foreach ($rows as $attrSlug => $f) {
                if (empty($f['parent'])) {
                    continue;
                }

                [$parentSlug, $labels] = $f['parent'];

                $valueIds = AttributeValue::where('attribute_id', $attrs[$parentSlug]->id)
                    ->whereIn('value', $labels)
                    ->pluck('id')
                    ->all();

                $created[$attrSlug]->update([
                    'parent_category_attribute_id' => $created[$parentSlug]->id,
                    'show_when_value_ids' => $valueIds,
                ]);
            }
        }
    }

    private function occasions(): void
    {
        foreach (['Wedding', 'Bridal', 'Reception', 'Engagement', 'Festive', 'Party', 'Cocktail', 'Sangeet & Mehendi'] as $title) {
            GiftingOccasion::updateOrCreate(['slug' => Str::slug($title)], [
                'title' => $title,
                'sub_title' => "$title edit",
                'status' => 1,
            ]);
        }
    }

    private function collections(): void
    {
        $list = ['New Arrival', 'Best Sellers', 'Limited Edition', 'Handcrafted', 'Featured', 'Wedding Collection', 'Festive Collection'];

        foreach ($list as $i => $name) {
            Collection::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'code' => Str::upper(Str::slug($name, '_')),
                'status' => 1,
                'sort_order' => $i + 1,
            ]);
        }
    }
}