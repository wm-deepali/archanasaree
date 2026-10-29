<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        return view('front-pages.product-listing', array_merge(
            compact('products', 'recentlyViewed', 'alsoLike'),
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
}