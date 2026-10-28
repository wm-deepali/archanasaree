<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();

            // ── Identity ──
            $table->string('page_key')->unique();          // route name, e.g. "home", "digital-marketing"
            $table->string('page_name');                   // display name in admin
            $table->string('page_group', 30)->default('general')->index(); // main | service | industry | general
            $table->string('slug')->nullable();            // URL path, e.g. "/digital-marketing"

            // ── Core meta ──
            $table->string('meta_title')->nullable();      // keep <= 60 chars
            $table->text('meta_description')->nullable();  // keep <= 160 chars
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();   // null = use current URL
            $table->string('robots', 60)->default('index, follow'); // e.g. "noindex, nofollow"

            // ── Open Graph ──
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();        // 1200x630 recommended
            $table->string('og_type', 30)->default('website');

            // ── Twitter / X ──
            $table->string('twitter_card', 30)->default('summary_large_image');
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();

            // ── Structured data & scripts ──
            $table->longText('schema_markup')->nullable(); // JSON-LD (without <script> tags)
            $table->longText('scripts')->nullable();       // head scripts (analytics, verification, etc.)
            $table->longText('body_scripts')->nullable();  // after <body> (GTM noscript, etc.)

            // ── Sitemap ──
            $table->boolean('in_sitemap')->default(true);
            $table->decimal('sitemap_priority', 2, 1)->default(0.5); // 0.0 – 1.0
            $table->string('sitemap_changefreq', 10)->default('monthly'); // daily|weekly|monthly|yearly

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};