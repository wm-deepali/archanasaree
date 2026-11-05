<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\GoogleSetting;
use App\Models\SeoPage;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Collection;
use App\Models\Announcement;
use App\Models\GiftingOccasion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Built once per request, then reused for every view / partial
            static $shared = null;

            if ($shared === null) {
                $name = Route::currentRouteName();

                $shared = [
                    'seo' => $name ? SeoPage::forKey($name) : null,
                    // new Setting() avoids "property on null" errors if the row doesn't exist yet
                    'general' => Setting::first() ?? new Setting(),
                ];
            }

            $view->with($shared);
        });

        View::composer('layouts.app', function ($view) {
            $cart = auth('customer')->check()
                ? Cart::where('customer_id', auth('customer')->id())->first()
                : Cart::where('session_id', session()->getId())->first();

            $cart?->load([
                'items.product.category',
                'items.product.subcategory',
                'items.imageVariant',
                'items.priceVariant',
                'items.stockVariant',
                'items.addons',
            ]);

            // Mega menu: parent categories + active children
            $navCategories = Category::active()
                ->parents()
                ->where('show_in_navbar', 1)
                ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')->orderBy('id')])
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            // Shop by Collection: attributes marked show_in_navbar (Fabric, Color...)
            $navAttributes = Attribute::where('status', 1)
                ->where('show_in_navbar', 1)
                ->with(['values' => fn($q) => $q->where('status', 1)->orderBy('sort_order')->orderBy('id')])
                ->orderBy('id')
                ->get()
                ->filter(fn($a) => $a->values->isNotEmpty())
                ->values();

            // Mega menu column: saare active collections
            $navCollections = Collection::where('status', 1)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            // Top-level menu links (New Arrivals, Offers...): sirf show_in_navbar wale
            $navBarCollections = $navCollections->where('show_in_navbar', true)->values();

            $navOccasions = GiftingOccasion::where('status', 1)
                ->orderBy('id')
                ->get();

            // Price ranges ka koi model nahi hai, isliye yahin define hain
            $navPriceRanges = [
                ['label' => 'Under ₹2,999', 'min' => null, 'max' => 2999],
                ['label' => '₹3,000 - ₹5,999', 'min' => 3000, 'max' => 5999],
                ['label' => '₹6,000 - ₹9,999', 'min' => 6000, 'max' => 9999],
                ['label' => '₹10,000 - ₹14,999', 'min' => 10000, 'max' => 14999],
                ['label' => '₹15,000 and Above', 'min' => 15000, 'max' => null],
            ];

            static $announcements = null;

            $announcements ??= Announcement::where('status', 1)
                ->latest('id')
                ->get(['id', 'title', 'link']);

            $view->with([
                'miniCart' => $cart,
                'cartCount' => (int) ($cart?->items->sum('quantity') ?? 0),
                'navCategories' => $navCategories,
                'navAttributes' => $navAttributes,
                'navCollections' => $navCollections,
                'navBarCollections' => $navBarCollections,
                'navOccasions' => $navOccasions,
                'navPriceRanges' => $navPriceRanges,
                'announcements' => $announcements,
                'googleSetting' => GoogleSetting::first() ?? new GoogleSetting(),
            ]);
        });
    }
}