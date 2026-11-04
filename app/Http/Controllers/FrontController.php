<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\FaqCategory;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use App\Traits\LogsApiCalls;
use App\Models\ContactEnquiry;
use Illuminate\Validation\Rule;
use App\Models\CategoryAttribute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\ProductFilterService;

class FrontController extends Controller
{
    use LogsApiCalls;

    public function home(Request $request)
    {
        return view('front-pages.home');
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

        return view('front-pages.category-detail', array_merge(
            compact('category', 'subCategories', 'products', 'recentlyViewed', 'alsoLike', 'sortOptions', 'currentSort', 'activeSub'),
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

        return view('front-pages.product-listing', array_merge(
            compact('products', 'recentlyViewed', 'alsoLike', 'sortOptions', 'currentSort'),
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

        Product::trackView($product->id);

        return view('front-pages.product-detail', compact(
            'product',
            'gallery',
            'coupons',
            'specs',
            'related',
            'recentlyViewed',
            'reviews',
            'reviewSort',
            'ratingCounts',
            'photoReviews',
            'fiveStarReviews',
            'customerPhotos',
            'reviewState',
            'optionGroups',
            'optionData'
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

        return view('front-pages.faqs', compact('categories'));
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

        return view('front-pages.blogs', compact('featured', 'blogs'));
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

        return view('front-pages.blog-detail', compact('blog', 'related'));
    }

    public function contact()
    {
        return view('front-pages.contact', ['enquiryTypes' => ContactEnquiry::TYPES]);
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

        return view('front-pages.page', compact('page', 'content'));
    }

}