<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\LogsApiCalls;
use App\Services\ProductFilterService;

class FrontController extends Controller
{
    use LogsApiCalls;

    public function home(Request $request)
    {
        return view('front-pages.home');
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

        $products = $this->categoryProducts($request, $filters, $category, null);

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
            compact('category', 'subCategories', 'products', 'recentlyViewed', 'alsoLike', 'sortOptions', 'currentSort'),
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
                'attributeValues.attribute:id,name',
                'attributeValues.value:id,value',
                'occasions:id,title',
                'addons',
            ])
            ->withAvg('approvedReviews as avg_rating', 'rating')
            ->withCount('approvedReviews as reviews_count')
            ->firstOrFail();

        // Product Details: attribute-wise rows (multi-select values comma se)
        $specs = $product->attributeValues
            ->filter(fn($av) => $av->attribute && $av->value)
            ->groupBy('attribute_id')
            ->map(fn($rows) => [
                'name' => $rows->first()->attribute->name,
                'values' => $rows->pluck('value.value')->implode(', '),
            ])
            ->values();

        // default image pehle, phir upload order
        $gallery = $product->images
            ->sortBy([['is_default', 'desc'], ['id', 'asc']])
            ->values();

        $coupons = Coupon::available()
            ->orderByDesc('discount_value')
            ->limit(3)
            ->get();

        // Recently viewed: trackView se PEHLE lo, aur current product hata do
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

        // star-wise counts: [5 => n, 4 => n, ...]
        $ratingCounts = $product->approvedReviews()
            ->selectRaw('rating, COUNT(*) as c')
            ->groupBy('rating')
            ->pluck('c', 'rating');

        $photoReviews = $reviews->filter(fn($r) => $r->images->isNotEmpty())->values();
        $fiveStarReviews = $reviews->where('rating', 5)->values();
        $customerPhotos = $reviews->flatMap(fn($r) => $r->images)->values();

        // ── Review form state ──
        // guest | can_review | already_reviewed | not_purchased
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
            'reviewState'
        ));
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
}