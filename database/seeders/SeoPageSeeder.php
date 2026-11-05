<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        $brand = 'Archana Saree Emporium';
        $base  = rtrim(config('app.url'), '/');

        $defaults = [
            'robots'             => 'index, follow',
            'og_type'            => 'website',
            'twitter_card'       => 'summary_large_image',
            'in_sitemap'         => true,
            'sitemap_priority'   => 0.5,
            'sitemap_changefreq' => 'monthly',
            'is_active'          => true,
        ];

        // Pages that must never be indexed
        $private = ['robots' => 'noindex, nofollow', 'in_sitemap' => false];

        $pages = [
            // ---------- Main ----------
            [
                'page_key' => 'home', 'page_name' => 'Home', 'page_group' => 'Main', 'slug' => '/',
                'meta_title' => "$brand | Sarees, Lehengas & Bridal Wear Online",
                'meta_description' => 'Shop designer sarees, lehengas and bridal wear online. Authentic craftsmanship, pan-India delivery and easy returns.',
                'meta_keywords' => 'sarees online, designer lehenga, bridal wear, banarasi saree, party wear saree',
                'sitemap_priority' => 1.0, 'sitemap_changefreq' => 'daily',
                'schema_markup' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        ['@type' => 'Organization', 'name' => $brand, 'url' => $base],
                        [
                            '@type' => 'WebSite', 'name' => $brand, 'url' => $base,
                            'potentialAction' => [
                                '@type' => 'SearchAction',
                                'target' => $base . '/products?q={search_term_string}',
                                'query-input' => 'required name=search_term_string',
                            ],
                        ],
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_key' => 'about', 'page_name' => 'About Us', 'page_group' => 'Main', 'slug' => '/about-us',
                'meta_title' => "About Us | $brand",
                'meta_description' => "Learn about $brand, our story, our craftsmanship and our promise of quality ethnic wear.",
            ],
            [
                'page_key' => 'contact', 'page_name' => 'Contact Us', 'page_group' => 'Main', 'slug' => '/contact',
                'meta_title' => "Contact Us | $brand",
                'meta_description' => "Get in touch with $brand for help with products, orders, returns and more.",
            ],
            [
                'page_key' => 'faqs', 'page_name' => 'FAQs', 'page_group' => 'Main', 'slug' => '/faqs',
                'meta_title' => "FAQs | $brand",
                'meta_description' => 'Answers to common questions about orders, shipping, returns, payments and product care.',
            ],

            // ---------- Shop ----------
            [
                'page_key' => 'products', 'page_name' => 'All Products', 'page_group' => 'Shop', 'slug' => '/products',
                'meta_title' => "Shop All Sarees, Lehengas & More | $brand",
                'meta_description' => 'Browse our full collection of sarees, lehengas and bridal wear. Filter by fabric, colour, price and occasion.',
                'sitemap_priority' => 0.9, 'sitemap_changefreq' => 'daily',
            ],
            [
                'page_key' => 'categories', 'page_name' => 'Categories', 'page_group' => 'Shop', 'slug' => '/categories',
                'meta_title' => "Shop by Category | $brand",
                'meta_description' => 'Explore sarees, lehengas, bridal wear and more, all in one place.',
                'sitemap_priority' => 0.8, 'sitemap_changefreq' => 'weekly',
            ],

            // Fallbacks only: product/category/blog/page detail should override per record
            [
                'page_key' => 'products.show', 'page_name' => 'Product Detail (fallback)', 'page_group' => 'Shop', 'slug' => '/product/{slug}',
                'meta_title' => "Buy Online | $brand",
                'meta_description' => "Shop this product online at $brand. Pan-India delivery and easy returns.",
                'og_type' => 'product', 'in_sitemap' => false,
            ],
            [
                'page_key' => 'category.show', 'page_name' => 'Category Detail (fallback)', 'page_group' => 'Shop', 'slug' => '/category/{slug}',
                'meta_title' => "Shop Online | $brand",
                'meta_description' => "Explore this collection at $brand. Pan-India delivery and easy returns.",
                'in_sitemap' => false,
            ],

            // ---------- Content ----------
            [
                'page_key' => 'blogs', 'page_name' => 'Blog', 'page_group' => 'Content', 'slug' => '/blog',
                'meta_title' => "Blog | Styling Tips & Ethnic Wear Guides | $brand",
                'meta_description' => 'Styling tips, fabric guides and festive fashion ideas from the team at ' . $brand . '.',
                'sitemap_priority' => 0.7, 'sitemap_changefreq' => 'weekly',
            ],
            [
                'page_key' => 'blog.show', 'page_name' => 'Blog Detail (fallback)', 'page_group' => 'Content', 'slug' => '/blog/{slug}',
                'meta_title' => "Blog | $brand",
                'meta_description' => "Read the latest from $brand.",
                'og_type' => 'article', 'in_sitemap' => false,
            ],
            [
                'page_key' => 'page.show', 'page_name' => 'Dynamic Page (fallback)', 'page_group' => 'Content', 'slug' => '/page/{slug}',
                'meta_title' => $brand,
                'meta_description' => "Information from $brand.",
                'in_sitemap' => false,
            ],

            // ---------- Account / Cart / Checkout (noindex) ----------
            ['page_key' => 'cart', 'page_name' => 'Cart', 'page_group' => 'Cart & Checkout', 'slug' => '/cart',
                'meta_title' => "Your Bag | $brand", 'meta_description' => null] + $private,
            ['page_key' => 'checkout', 'page_name' => 'Checkout', 'page_group' => 'Cart & Checkout', 'slug' => '/checkout',
                'meta_title' => "Checkout | $brand", 'meta_description' => null] + $private,
            ['page_key' => 'order.success', 'page_name' => 'Order Success', 'page_group' => 'Cart & Checkout', 'slug' => '/order-success/{order}',
                'meta_title' => "Order Confirmed | $brand", 'meta_description' => null] + $private,
            ['page_key' => 'user.login', 'page_name' => 'Login', 'page_group' => 'Account', 'slug' => '/user/login',
                'meta_title' => "Login | $brand", 'meta_description' => null] + $private,
            ['page_key' => 'user.register', 'page_name' => 'Register', 'page_group' => 'Account', 'slug' => '/user/register',
                'meta_title' => "Create Account | $brand", 'meta_description' => null] + $private,
            ['page_key' => 'user.dashboard.index', 'page_name' => 'My Account', 'page_group' => 'Account', 'slug' => '/user/dashboard',
                'meta_title' => "My Account | $brand", 'meta_description' => null] + $private,
        ];

        foreach ($pages as $page) {
            // firstOrCreate: re-running the seeder won't overwrite what admin already edited
            SeoPage::firstOrCreate(
                ['page_key' => $page['page_key']],
                $page + $defaults
            );
        }
    }
}