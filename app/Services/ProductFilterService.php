<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Collection as ProductCollection;
use App\Models\GiftingOccasion;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use Illuminate\Http\Request;

class ProductFilterService
{
    /** ?category[]=slug  ->  parent category ids */
    public function categoryIds(Request $r): array
    {
        $slugs = array_filter((array) $r->input('category', []));
        if (!$slugs) {
            return [];
        }
        $ids = Category::active()->parents()->whereIn('slug', $slugs)->pluck('id')->all();

        return $ids ?: [0]; // galat slug => zero results
    }

    public function apply($q, Request $r)
    {
        if ($ids = $this->categoryIds($r)) {
            $q->whereIn('category_id', $ids);
        }

        if ($subs = array_filter((array) $r->input('sub', []))) {
            $q->whereIn('subcategory_id', Category::active()->subCategories()->whereIn('slug', $subs)->pluck('id'));
        }

        if ($occ = array_filter((array) $r->input('occasion', []))) {
            $q->whereHas('occasions', fn($x) => $x->whereIn('slug', $occ));
        }

        if ($col = array_filter((array) $r->input('collection', []))) {
            $q->whereHas('collections', fn($x) => $x->whereIn('slug', $col));
        }

        if ($r->filled('price_min')) {
            $q->where('price', '>=', (float) $r->price_min);
        }
        if ($r->filled('price_max')) {
            $q->where('price', '<=', (float) $r->price_max);
        }

        if ($r->filled('discount')) {
            $q->whereRaw('mrp > 0 AND ((mrp - price) / mrp * 100) >= ?', [(int) $r->discount]);
        }

        // attr[fabric][]=silk&attr[colour][]=red  (attribute ke andar OR, attributes ke beech AND)
        foreach ((array) $r->input('attr', []) as $attrSlug => $valueSlugs) {
            $valueSlugs = array_filter((array) $valueSlugs);
            if (!$valueSlugs) {
                continue;
            }

            $ids = AttributeValue::whereIn('slug', $valueSlugs)
                ->whereHas('attribute', fn($a) => $a->where('slug', $attrSlug))
                ->pluck('id')->all();

            $q->where(function ($w) use ($ids) {
                if (!$ids) {
                    $w->whereRaw('1 = 0');
                    return;
                }
                $w->whereHas('attributeValues', fn($x) => $x->whereIn('attribute_value_id', $ids))
                    ->orWhereHas('variants', fn($x) => $x->where('status', 1)
                        ->whereHas('values', fn($y) => $y->whereIn('attribute_value_id', $ids)));
            });
        }

        return $q;
    }

    /**
     * Filter panel ka data.
     * $forceCategoryIds: category page par fixed category (request se nahi aata)
     */
    public function sidebar(Request $r, ?array $forceCategoryIds = null): array
    {
        $catIds = $forceCategoryIds ?? $this->categoryIds($r);
        $visible = Product::visible()->when($catIds, fn($q) => $q->whereIn('category_id', $catIds));

        // price slider bounds: listing page par poore catalogue ke, category page par us category ke
        $all = Product::visible()->when($forceCategoryIds, fn($q) => $q->whereIn('category_id', $forceCategoryIds));
        $min = (clone $all)->min('price');
        $max = (clone $all)->max('price');
        $priceMin = (int) (floor(($min ?? 0) / 500) * 500);
        $priceMax = (int) max(ceil(($max ?? 0) / 500) * 500, $priceMin + 1000);

        // jin attribute values ka koi visible product (ya variant) hai
        $productIds = (clone $visible)->select('id');
        $used = ProductAttributeValue::whereIn('product_id', $productIds)->pluck('attribute_value_id')
            ->merge(
                ProductVariantValue::whereIn(
                    'variant_id',
                    ProductVariant::whereIn('product_id', $productIds)->where('status', 1)->select('id')
                )->pluck('attribute_value_id')
            )->unique()->values();

        $filterAttributes = Attribute::where('status', 1)
            ->whereHas('categoryAttributes', fn($q) => $q
                ->where('show_in_filter', 1)->where('status', 1)
                ->when($catIds, fn($q) => $q->whereIn('category_id', $catIds)))
            ->withMin('categoryAttributes as sort_pos', 'sort_order')
            ->orderBy('sort_pos')
            ->with(['values' => fn($q) => $q->where('status', 1)->whereIn('id', $used)->orderBy('sort_order')])
            ->get()
            ->filter(fn($a) => $a->values->isNotEmpty())
            ->values();

        return [
            'filterCategories' => Category::active()->parents()->orderBy('sort_order')->get(['id', 'name', 'slug']),
            'filterSubs' => $catIds
                ? Category::active()->whereIn('parent_id', $catIds)->orderBy('sort_order')->get(['id', 'name', 'slug'])
                : collect(),
            'filterOccasions' => GiftingOccasion::where('status', 1)->orderBy('title')->get(['id', 'title', 'slug']),
            'filterCollections' => ProductCollection::where('status', 1)->orderBy('sort_order')->get(['id', 'name', 'slug']),
            'filterAttributes' => $filterAttributes,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
        ];
    }
}