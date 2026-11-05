<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\SeoPage;
use App\Models\Setting;
use App\Models\HomeReel;
use App\Models\Category;
use App\Models\PageHero;
use App\Models\HomeStory;
use App\Models\Collection;
use App\Models\HomeSlider;
use App\Models\FaqCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\DynamicPage;
use App\Models\AboutSection;
use App\Models\HomeCampaign;
use Illuminate\Http\Request;
use App\Traits\LogsApiCalls;
use App\Models\ProductReview;
use App\Models\ContactEnquiry;
use Illuminate\Validation\Rule;
use App\Models\GiftingOccasion;
use App\Models\CategoryAttribute;
use Illuminate\Support\Facades\Log;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Services\ProductFilterService;

class FrontController extends Controller
{
    use LogsApiCalls;
    public function home()
    {
        $heroSlides = HomeSlider::active()->ordered()->get();

        $homeCategories = Category::active()
            ->parents()
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $lovedAll = Product::visible()->forCard()
            ->latest('id')
            ->limit(8)
            ->get();

        $lovedTabs = $homeCategories->take(6)
            ->map(function ($cat) {
                return [
                    'category' => $cat,
                    'products' => Product::visible()->forCard()
                        ->where('category_id', $cat->id)
                        ->latest('id')
                        ->limit(8)
                        ->get(),
                ];
            })
            ->filter(fn($t) => $t['products']->isNotEmpty())
            ->values();

        $editCategory = Category::active()->parents()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->first();

        $editSubs = collect();
        $editProducts = collect();

        if ($editCategory) {
            $editSubs = $editCategory->children()
                ->active()
                ->orderBy('sort_order')
                ->get();

            $editProducts = Product::visible()->forCard()
                ->where('category_id', $editCategory->id)
                ->latest('id')
                ->limit(3)
                ->get();
        }

        $occasions = GiftingOccasion::where('status', 1)
            ->whereHas('products', fn($q) => $q->visible())
            ->orderBy('id')
            ->get();

        $spotCategory = Category::active()->parents()
            ->when($editCategory, fn($q) => $q->where('id', '!=', $editCategory->id))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->first();

        $spotSubs = $spotCategory
            ? $spotCategory->children()->active()->orderBy('sort_order')->limit(8)->get()
            : collect();

        $offerProducts = Product::visible()->forCard()
            ->where('mrp', '>', 0)
            ->whereColumn('mrp', '>', 'price')
            ->orderByRaw('((mrp - price) / mrp) desc')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $homeCoupons = Coupon::available()
            ->orderByDesc('discount_value')
            ->limit(3)
            ->get();

        // Two collections, one per section (secY and secL), each with its products
        $homeCollections = Collection::where('status', 1)
            ->whereHas('products', fn($q) => $q->visible())
            ->orderBy('sort_order')
            ->orderBy('id')
            ->take(2)
            ->get()
            ->each(function ($col) {
                $col->setRelation(
                    'homeProducts',
                    Product::visible()->forCard()
                        ->whereHas('collections', fn($q) => $q->where('collections.id', $col->id))
                        ->latest('id')
                        ->limit(8)
                        ->get()
                );
            })
            ->values();

        $collectionY = $homeCollections->get(0);
        $collectionL = $homeCollections->get(1);

        // Customer Love: approved reviews with text, featured first, then best rated
        $homeReviews = ProductReview::approved()
            ->with(['customer:id,name,avatar', 'product:id,name,slug'])
            ->whereNotNull('review')
            ->where('review', '!=', '')
            ->where('rating', '>=', 4)
            ->orderByDesc('featured')
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        // The Archana Edit: top rated products (1st = feature image, rest = slider)
        $topRated = Product::visible()->forCard()
            ->whereHas('approvedReviews')
            ->orderByDesc('avg_rating')
            ->orderByDesc('id')
            ->limit(9)
            ->get();

        $topFeatured = $topRated->first();
        $topSlider = $topRated->slice(1)->values();

        // secE campaign, secM story + founder, secS reels (all editable from admin)
        $campaign = HomeCampaign::current();
        $story = HomeStory::current();
        $reels = HomeReel::active()->ordered()->get();

        // secP "All Collections": 3 parent categories with their sub categories (+ occasions, already loaded)
        $collectGroups = Category::active()->parents()
            ->whereHas('children', fn($q) => $q->active())
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('front-pages.home', compact(
            'heroSlides',
            'homeCategories',
            'lovedAll',
            'lovedTabs',
            'editCategory',
            'editSubs',
            'editProducts',
            'occasions',
            'spotCategory',
            'spotSubs',
            'offerProducts',
            'homeCoupons',
            'collectionY',
            'collectionL',
            'topFeatured',
            'topSlider',
            'homeReviews',
            'campaign',
            'story',
            'reels',
            'collectGroups'
        ));
    }

    public function about()
    {
        $about = AboutSection::active()
            ->with(['items' => fn($q) => $q->where('status', 1)])
            ->get()
            ->keyBy('key');

        $hero = PageHero::forPage('about');
        return view('front-pages.about', compact('about', 'hero'));
    }

    public function searchSuggest(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if ($q !== '' && mb_strlen($q) < 2) {
            return response()->json(['items' => [], 'query' => $q]);
        }

        $query = Product::visible()->forCard()->with(['images', 'category', 'subcategory']);

        if ($q !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';

            $query->where(function ($w) use ($like) {
                $w->where('name', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', $like))
                    ->orWhereHas('subcategory', fn($c) => $c->where('name', 'like', $like));
            })->orderByRaw('name like ? desc', [addcslashes($q, '%_\\') . '%']);
        } else {
            $query->latest('id');
        }

        $items = $query->limit(6)->get()->map(function ($p) {
            $img = $p->images->firstWhere('is_default', 1) ?? $p->images->first();

            return [
                'name' => $p->name,
                'url' => route('products.show', ['slug' => $p->slug]),
                'image' => $img
                    ? asset('storage/' . ($img->thumb ?? $img->image))
                    : asset('assets/images/home/tab1.png'),
                'category' => $p->subcategory->name ?? $p->category->name ?? '',
                'price' => '₹' . number_format($p->price),
            ];
        })->values();

        return response()->json(['items' => $items, 'query' => $q]);
    }

    public function categories()
    {
        $categories = Category::active()
            ->parents()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('front-pages.categories', compact('categories'));
    }

    public function categoryShow(Request $request, $slug, ProductFilterService $filters)
    {
        $category = Category::active()->parents()->where('slug', $slug)->firstOrFail();
        $subCategories = $category->children()->active()->orderBy('sort_order')->get();

        // AJAX: tab switch / sort / filter / load more
        if ($request->ajax()) {
            $sub = is_string($request->sub) ? $subCategories->firstWhere('slug', $request->sub) : null;
            $products = $this->categoryProducts($request, $filters, $category, $sub);

            return response()->json([
                'html' => view('partials.product-cards', compact('products'))->render(),
                'total' => $products->total(),
                'shown' => $products->lastItem() ?? 0,
                'next_page' => $products->hasMorePages() ? $products->currentPage() + 1 : null,
            ]);
        }

        $activeSub = is_string($request->sub) ? $subCategories->firstWhere('slug', $request->sub) : null;

        $products = $this->categoryProducts($request, $filters, $category, $activeSub);

        $recentlyViewed = $this->recentlyViewed();

        // You may also like: doosri categories ke products, na mile to isi category ke
        $alsoLike = $this->alsoLike($category->id);

        if ($alsoLike->isEmpty()) {
            $alsoLike = Product::visible()->forCard()
                ->where('category_id', $category->id)
                ->inRandomOrder()->limit(8)->get();
        }

        $currentSort = array_key_exists($request->sort, Product::SORT_OPTIONS) ? $request->sort : 'recommended';
        $sortOptions = Product::SORT_OPTIONS;

        // ── SEO: sub category wins, then category, then generated text ──
        $site = $this->siteName();
        $seoSource = $activeSub ?? $category;
        $seoName = $activeSub ? $activeSub->name . ' - ' . $category->name : $category->name;

        $seoOverride = $this->seoOverride([
            'meta_title' => $seoSource->meta_title ?: $seoName . ' | ' . $site,
            'meta_description' => $seoSource->meta_description
                ?: $this->plain($seoSource->sub_title ?: $seoSource->description)
                ?: "Shop {$seoName} online at {$site}. Pan-India delivery and easy returns.",
            'og_image' => $seoSource->image
                ? asset('storage/' . $seoSource->image)
                : ($category->image ? asset('storage/' . $category->image) : null),
            // filters / sort / page stay out of the canonical; only the sub tab is kept
            'canonical_url' => $activeSub
                ? route('category.show', ['slug' => $category->slug, 'sub' => $activeSub->slug])
                : route('category.show', $category->slug),
        ]);

        return view('front-pages.category-detail', array_merge(
            compact('category', 'subCategories', 'products', 'recentlyViewed', 'alsoLike', 'sortOptions', 'currentSort', 'activeSub', 'seoOverride'),
            $filters->sidebar($request, [$category->id])
        ));
    }

    private function categoryProducts(Request $request, ProductFilterService $filters, Category $category, ?Category $sub)
    {
        $query = Product::visible()
            ->forCard()
            ->where('category_id', $category->id);

        if ($sub) {
            $query->where('subcategory_id', $sub->id);
        }

        // occasion / collection / price / attr[...] / discount
        $filters->apply($query, $request);

        return $query->orderForListing($request->sort)->paginate(12);
    }

    public function products(Request $request, ProductFilterService $filters)
    {
        $query = Product::visible()->forCard();
        $filters->apply($query, $request);

        if ($request->filled('q')) {
            $like = '%' . addcslashes(trim($request->q), '%_\\') . '%';
            $query->where(function ($w) use ($like) {
                $w->where('name', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', $like))
                    ->orWhereHas('subcategory', fn($c) => $c->where('name', 'like', $like));
            });
        }

        $products = $query->orderForListing($request->sort)->paginate(24)->withQueryString();

        $recentlyViewed = $this->recentlyViewed();
        $alsoLike = $this->alsoLike(null, $recentlyViewed->pluck('id')->all());

        $sortOptions = Product::SORT_OPTIONS;
        $currentSort = in_array($request->sort, array_keys($sortOptions), true) ? $request->sort : 'recommended';

        // ── SEO ──
        $site = $this->siteName();
        $base = SeoPage::forKey('products'); // row from the seeder / admin
        $page = $products->currentPage();

        $isSearch = $request->filled('q');

        // any query param other than ?page= (sort, price, attr, collection, occasion, q...)
        $isFiltered = collect($request->query())
            ->except('page')
            ->filter(fn($v) => filled($v))
            ->isNotEmpty();

        $title = $isSearch
            ? 'Search results for "' . Str::limit(trim($request->q), 60, '') . '" | ' . $site
            : ($base?->meta_title ?: "Shop All Products | {$site}");

        if (!$isFiltered && $page > 1) {
            $title .= " - Page {$page}";
        }

        $seoOverride = $this->seoOverride([
            'meta_title' => $title,
            'meta_description' => $isSearch
                ? "Browse search results at {$site}."
                : ($base?->meta_description ?: "Shop our full collection online at {$site}."),
            'meta_keywords' => $base?->meta_keywords,
            'og_image' => $base?->og_image,
            // filtered / sorted / search URLs are thin duplicates: keep them out of the index
            // but let crawlers follow the product links
            'robots' => $isFiltered ? 'noindex, follow' : null,
            // filtered -> clean /products ; plain pagination -> its own URL
            'canonical_url' => (!$isFiltered && $page > 1)
                ? route('products', ['page' => $page])
                : route('products'),
        ]);

        return view('front-pages.product-listing', array_merge(
            compact('products', 'recentlyViewed', 'alsoLike', 'sortOptions', 'currentSort', 'seoOverride'),
            $filters->sidebar($request)
        ));
    }

    /** Session ke recently_viewed ids se products (view order maintain) */
    private function recentlyViewed(int $limit = 8)
    {
        $ids = array_slice(session('recently_viewed', []), 0, $limit);

        if (!$ids) {
            return collect();
        }

        return Product::visible()->forCard()
            ->whereIn('id', $ids)->get()
            ->sortBy(fn($p) => array_search($p->id, $ids))
            ->values();
    }

    /** Random visible products; optional category exclude aur ids exclude */
    private function alsoLike(?int $excludeCategoryId = null, array $excludeIds = [], int $limit = 8)
    {
        return Product::visible()->forCard()
            ->when($excludeCategoryId, fn($q) => $q->where('category_id', '!=', $excludeCategoryId))
            ->when($excludeIds, fn($q) => $q->whereNotIn('id', $excludeIds))
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /** Site name for titles (controller runs before the view composer, so read Setting directly) */
    private function siteName(): string
    {
        static $name = null;

        return $name ??= (Setting::first()?->site_name ?: config('app.name'));
    }

    /** HTML -> clean one-line text, trimmed for meta descriptions */
    private function plain($html, int $limit = 155): string
    {
        $text = html_entity_decode(strip_tags((string) $html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/u', ' ', $text));

        return Str::limit($text, $limit, '...');
    }

    /**
     * Unsaved SeoPage for the current record. Empty values are dropped,
     * and robots / og_type / twitter_card fall back to the route-level row.
     */
    private function seoOverride(array $values, ?array $schema = null): SeoPage
    {
        $base = Route::currentRouteName() ? SeoPage::forKey(Route::currentRouteName()) : null;

        $inherit = $base ? Arr::only($base->getAttributes(), ['robots', 'og_type', 'twitter_card']) : [];

        if ($schema) {
            $values['schema_markup'] = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return new SeoPage(array_filter($values + $inherit, fn($v) => filled($v)));
    }

    public function productShow(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'images',
                'category',
                'subcategory',
                'collections:id,name',
                'attributeValues.attribute:id,name,type',
                'attributeValues.value',
                'occasions:id,title',
                'addons',
                'variants.values',
                'variants.images',
            ])
            ->withAvg('approvedReviews as avg_rating', 'rating')
            ->withCount('approvedReviews as reviews_count')
            ->firstOrFail();

        $specs = $product->attributeValues
            ->filter(fn($av) => $av->attribute && $av->value)
            ->groupBy('attribute_id')
            ->map(fn($rows) => [
                'name' => $rows->first()->attribute->name,
                'values' => $rows->pluck('value.value')->implode(', '),
            ])
            ->values();

        $gallery = $product->images
            ->sortBy([['is_default', 'desc'], ['id', 'asc']])
            ->values();

        $coupons = Coupon::available()
            ->orderByDesc('discount_value')
            ->limit(3)
            ->get();

        $recentlyViewed = $this->recentlyViewed()
            ->reject(fn($p) => $p->id === $product->id)
            ->values();

        $related = $this->relatedProducts($product);

        // ── Reviews (sirf approved) ──
        $reviewSort = in_array($request->review_sort, ['highest', 'lowest'], true) ? $request->review_sort : 'recent';

        $reviewQuery = $product->approvedReviews()->with(['customer:id,name', 'images']);

        match ($reviewSort) {
            'highest' => $reviewQuery->orderByDesc('rating')->orderByDesc('id'),
            'lowest' => $reviewQuery->orderBy('rating')->orderByDesc('id'),
            default => $reviewQuery->orderByDesc('id'),
        };

        $reviews = $reviewQuery->limit(30)->get();

        $ratingCounts = $product->approvedReviews()
            ->selectRaw('rating, COUNT(*) as c')
            ->groupBy('rating')
            ->pluck('c', 'rating');

        $photoReviews = $reviews->filter(fn($r) => $r->images->isNotEmpty())->values();
        $fiveStarReviews = $reviews->where('rating', 5)->values();
        $customerPhotos = $reviews->flatMap(fn($r) => $r->images)->values();

        // ── Review form state ──
        $customer = auth('customer')->user();
        $reviewState = 'guest';

        if ($customer) {
            if ($product->reviewableOrderItemFor($customer->id)) {
                $reviewState = 'can_review';
            } elseif ($product->reviews()->where('customer_id', $customer->id)->exists()) {
                $reviewState = 'already_reviewed';
            } else {
                $reviewState = 'not_purchased';
            }
        }

        // ── Product options (selectable attributes + variant map) ──
        [$optionGroups, $optionData] = $this->productOptionData($product, $gallery);

        // Is product ka koi line current cart mein hai? (View Cart / Checkout button ke liye)
        $currentCart = auth('customer')->check()
            ? Cart::where('customer_id', auth('customer')->id())->first()
            : Cart::where('session_id', session()->getId())->first();

        $inCart = $currentCart
            ? $currentCart->items()->where('product_id', $product->id)->exists()
            : false;

        Product::trackView($product->id);

        // ── SEO ──
        $site = $this->siteName();
        $catName = $product->subcategory->name ?? $product->category->name ?? null;
        $seoImg = $gallery->first() ? asset('storage/' . $gallery->first()->image) : null;
        $seoDesc = $product->meta_description
            ?: $this->plain($product->short_description ?: $product->description)
            ?: "Buy {$product->name} online at {$site}. Pan-India delivery and easy returns.";

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $seoDesc,
            'sku' => $product->sku,
            'image' => $gallery->map(fn($g) => asset('storage/' . $g->image))->values()->all() ?: null,
            'category' => $catName,
            'brand' => ['@type' => 'Brand', 'name' => $site],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('products.show', $product->slug),
                'priceCurrency' => 'INR',
                'price' => (float) $product->price,
                'availability' => (int) $product->stock > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
            ],
        ];

        if ($product->reviews_count > 0) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => round((float) $product->avg_rating, 1),
                'reviewCount' => (int) $product->reviews_count,
            ];
        }

        $seoOverride = $this->seoOverride([
            'meta_title' => $product->meta_title ?: $product->name . ($catName ? " - {$catName}" : '') . ' | ' . $site,
            'meta_description' => $seoDesc,
            'og_image' => $seoImg,
            'og_type' => 'product',
            'canonical_url' => route('products.show', $product->slug),
        ], array_filter($schema, fn($v) => filled($v)));

        $viewItemScript = \App\Services\Tracking\PixelTracker::viewItemScript($product);

        return view('front-pages.product-detail', compact(
            'specs',
            'inCart',
            'related',
            'reviews',
            'coupons',
            'gallery',
            'product',
            'optionData',
            'reviewSort',
            'seoOverride',
            'reviewState',
            'optionGroups',
            'ratingCounts',
            'photoReviews',
            'customerPhotos',
            'recentlyViewed',
            'viewItemScript',
            'fiveStarReviews',
        ));
    }

    /**
     * Selectable attribute groups + variant lookup maps for the detail page.
     * Variant key = sorted attribute_value ids (of that type's dependent attributes) joined by "-".
     */
    private function productOptionData(Product $product, $gallery): array
    {
        $catIds = array_filter([$product->category_id, $product->subcategory_id]);

        // subcategory ki rule category rule par priority, phir attribute-wise unique
        $rules = CategoryAttribute::whereIn('category_id', $catIds)
            ->where('is_selectable', 1)
            ->where('status', 1)
            ->get()
            ->sortBy(fn($ca) => $ca->category_id == $product->subcategory_id ? 0 : 1)
            ->unique('attribute_id')
            ->sortBy('sort_order')
            ->values();

        $byAttr = $product->attributeValues
            ->filter(fn($av) => $av->attribute && $av->value)
            ->groupBy('attribute_id');

        $groups = [];
        foreach ($rules as $ca) {
            $rows = $byAttr->get($ca->attribute_id);
            if (!$rows) {
                continue;
            }

            $values = $rows->pluck('value')
                ->unique('id')
                ->filter(fn($v) => $v->status)
                ->sortBy('sort_order')
                ->values();

            if ($values->isEmpty()) {
                continue;
            }

            $attr = $rows->first()->attribute;

            $groups[] = [
                'ca_id' => $ca->id,
                'attribute_id' => $ca->attribute_id,
                'name' => $attr->name,
                'type' => $attr->type, // button | color_swatch
                'parent' => $ca->parent_category_attribute_id,
                'show_when' => array_map('intval', $ca->show_when_value_ids ?? []),
                'dep' => [
                    'price' => (bool) $ca->price_dependent,
                    'image' => (bool) $ca->image_dependent,
                    'stock' => (bool) $ca->stock_dependent,
                    'sku' => (bool) $ca->sku_dependent,
                ],
                'values' => $values->map(fn($v) => [
                    'id' => $v->id,
                    'name' => $v->value,
                    'hex' => $v->hex_code,
                ])->all(),
            ];
        }

        $variants = ['price' => [], 'image' => [], 'stock' => [], 'sku' => []];

        foreach ($product->variants as $v) {
            if (!isset($variants[$v->type])) {
                continue;
            }

            $key = $v->values->pluck('attribute_value_id')->map(fn($i) => (int) $i)->sort()->implode('-');
            if ($key === '') {
                continue;
            }

            $ok = $v->status && $v->is_available !== false;

            switch ($v->type) {
                case 'price':
                    $row = [
                        'price' => (float) $v->price,
                        'mrp' => (float) ($v->mrp ?: $v->price),
                        'ok' => $ok,
                    ];
                    break;
                case 'stock':
                    $row = ['stock' => (int) $v->stock, 'ok' => $ok && $v->stock > 0];
                    break;
                case 'sku':
                    $row = ['sku' => $v->sku, 'ok' => $ok];
                    break;
                default: // image
                    $imgs = $v->images
                        ->sortBy([['is_default', 'desc'], ['id', 'asc']])
                        ->map(fn($i) => [
                            'full' => asset('storage/' . $i->image),
                            'thumb' => asset('storage/' . ($i->thumb ?? $i->image)),
                        ])->values()->all();

                    if (!$imgs && $v->image) {
                        $imgs = [['full' => asset('storage/' . $v->image), 'thumb' => asset('storage/' . $v->image)]];
                    }
                    $row = ['images' => $imgs, 'ok' => $ok];
            }

            $variants[$v->type][$key] = $row + ['id' => $v->id];
        }

        $baseImages = $gallery->isNotEmpty()
            ? $gallery->map(fn($g) => [
                'full' => asset('storage/' . $g->image),
                'thumb' => asset('storage/' . ($g->thumb ?? $g->image)),
            ])->values()->all()
            : [
                [
                    'full' => asset('assets/images/home/tab1.png'),
                    'thumb' => asset('assets/images/home/tab1.png'),
                ]
            ];

        return [
            $groups,
            [
                'name' => $product->name,
                'id' => $product->id,
                'minQty' => max(1, (int) $product->min_qty),
                'groups' => $groups,
                'variants' => array_map(fn($a) => (object) $a, $variants),
                'base' => [
                    'price' => (float) $product->price,
                    'mrp' => (float) ($product->mrp ?: $product->price),
                    'stock' => (int) $product->stock,
                    'sku' => $product->sku,
                    'images' => $baseImages,
                ],
                'lowStock' => 5,
            ]
        ];
    }

    /** Same subcategory wale pehle, phir same category ke baaki; current product exclude */
    private function relatedProducts(Product $product, int $limit = 8)
    {
        return Product::visible()->forCard()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->when($product->subcategory_id, function ($q) use ($product) {
                $q->orderByRaw('subcategory_id = ? desc', [$product->subcategory_id]);
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function quickView($id)
    {
        $product = Product::with(['images', 'category', 'subcategory', 'collections'])
            // ->active()   // <- use the SAME visibility scope your listing uses, so hidden/draft products can't be fetched by id
            ->findOrFail($id);

        $img = $product->images->firstWhere('is_default', 1) ?? $product->images->first();
        $off = $product->mrp > $product->price
            ? (int) round((($product->mrp - $product->price) / $product->mrp) * 100)
            : 0;

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'url' => route('products.show', ['slug' => $product->slug]),
            'category' => $product->subcategory->name ?? $product->category->name ?? '',
            'badge' => $product->collections->first()?->name,
            'rating' => $product->avg_rating ? round($product->avg_rating, 1) : null,
            'image' => $img
                ? asset('storage/' . ($img->image ?? $img->thumb))
                : asset('assets/images/home/tab1.png'),
            'price_fmt' => '₹' . number_format($product->price),
            'mrp_fmt' => '₹' . number_format($product->mrp),
            'off' => $off,
            'description' => $product->short_description,
            'in_stock' => (int) $product->stock > 0,
            'stock' => (int) $product->stock,
            'min_qty' => max(1, (int) $product->min_qty),
            'wished' => in_array($product->id, \App\Models\Wishlist::currentProductIds()),
        ]);
    }


    public function faqs()
    {
        $categories = FaqCategory::where('status', 1)
            ->orderBy('sort_order')
            ->with(['faqs' => fn($q) => $q->where('status', 1)->orderBy('sort_order')->orderBy('id')])
            ->get()
            ->filter(fn($c) => $c->faqs->isNotEmpty())
            ->values();

        // FAQs without a category go into a "General" tab at the end
        $general = Faq::whereNull('faq_category_id')
            ->where('status', 1)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        if ($general->isNotEmpty()) {
            $categories->push((object) [
                'name' => 'General',
                'icon' => 'fa-solid fa-circle-question',
                'faqs' => $general,
            ]);
        }

        $hero = PageHero::forPage('faqs');
        return view('front-pages.faqs', compact('categories', 'hero'));
    }

    public function blogs()
    {
        $featured = Blog::published()->where('is_featured', 1)->latest('published_at')->latest('id')->first()
            ?? Blog::published()->latest('published_at')->latest('id')->first();

        $blogs = Blog::published()
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->orderByDesc('published_at')->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $hero = PageHero::forPage('blogs');
        return view('front-pages.blogs', compact('featured', 'blogs', 'hero'));
    }

    public function blogDetail($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->firstOrFail();

        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->orderByRaw('(category = ?) desc', [$blog->category])
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $site = $this->siteName();
        $seoDesc = $blog->meta_description
            ?: $this->plain($blog->excerpt ?? $blog->content ?? '')
            ?: "Read {$blog->title} on the {$site} blog.";
        $seoImg = $blog->image ? asset('storage/' . $blog->image) : null;

        $seoOverride = $this->seoOverride([
            'meta_title' => $blog->meta_title ?: $blog->title . ' | ' . $site,
            'meta_description' => $seoDesc,
            'og_image' => $seoImg,
            'og_type' => 'article',
            'canonical_url' => route('blog.show', $blog->slug),
        ], array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => Str::limit($blog->title, 110, ''),
                'description' => $seoDesc,
                'image' => $seoImg,
                'datePublished' => optional($blog->published_at)->toIso8601String(),
                'dateModified' => optional($blog->updated_at)->toIso8601String(),
                'mainEntityOfPage' => route('blog.show', $blog->slug),
                'publisher' => ['@type' => 'Organization', 'name' => $site],
            ], fn($v) => filled($v)));

        return view('front-pages.blog-detail', compact('blog', 'related', 'seoOverride'));
    }

    public function contact()
    {
        return view('front-pages.contact', [
            'enquiryTypes' => ContactEnquiry::TYPES,
            'hero' => PageHero::forPage('contact'),
        ]);
    }

    public function contactSubmit(Request $request)
    {
        // honeypot: bots fill this hidden field, so pretend success and save nothing
        if ($request->filled('website')) {
            return response()->json(['message' => 'Thank you! We will get back to you soon.']);
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'email' => 'required|email|max:150',
            'type' => ['nullable', Rule::in(ContactEnquiry::TYPES)],
            'message' => 'required|string|max:2000',
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        $enquiry = ContactEnquiry::create($data + ['ip_address' => $request->ip()]);

        // email the store; a mail failure must not lose the enquiry
        $to = view()->shared('general')->support_email ?? null;
        if ($to) {
            try {
                Mail::raw(
                    "New enquiry #{$enquiry->id}\n\nName: {$enquiry->name}\nPhone: {$enquiry->phone}\n"
                    . "Email: {$enquiry->email}\nType: " . ($enquiry->type ?: '-') . "\n\n{$enquiry->message}",
                    fn($m) => $m->to($to)->replyTo($enquiry->email)->subject('New website enquiry: ' . $enquiry->name)
                );
            } catch (\Throwable $e) {
                Log::warning('Contact mail failed: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Thank you! Your enquiry has been sent. Our team will contact you soon.']);
    }

    public function pageDetail(string $slug)
    {
        $page = DynamicPage::active()->where('slug', $slug)->firstOrFail();

        $content = $page->renderedContent(Setting::first());

        $site = $this->siteName();

        $seoOverride = $this->seoOverride([
            'meta_title' => $page->meta_title ?: $page->heading . ' | ' . $site,
            'meta_description' => $page->meta_description
                ?: $this->plain($content)
                ?: "{$page->heading} - {$site}.",
            'canonical_url' => route('page.show', $page->slug),
        ]);

        return view('front-pages.page', compact('page', 'content', 'seoOverride'));
    }

    public function newsletterSubscribe(Request $request)
    {
        // honeypot: bots fill this hidden field, so pretend success and save nothing
        if ($request->filled('website')) {
            return response()->json(['message' => 'Thank you for subscribing!']);
        }

        $data = $request->validate([
            'email' => 'required|email:rfc|max:150',
        ]);

        $sub = NewsletterSubscriber::firstOrCreate(
            ['email' => strtolower(trim($data['email']))],
            ['ip_address' => $request->ip()]
        );

        if (!$sub->wasRecentlyCreated) {
            // signed up before; switch back on if admin had unsubscribed them
            if (!$sub->status) {
                $sub->update(['status' => true]);
            }

            return response()->json(['message' => "You're already on our list. Thank you!"]);
        }

        return response()->json(['message' => 'Thank you for subscribing! Watch your inbox for new arrivals and offers.']);
    }

}