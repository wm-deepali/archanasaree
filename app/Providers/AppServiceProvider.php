<?php

namespace App\Providers;
use App\Models\Cart;
use App\Models\SeoPage;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
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

            $view->with([
                'miniCart' => $cart,
                'cartCount' => (int) ($cart?->items->sum('quantity') ?? 0),
            ]);
        });
    }
}