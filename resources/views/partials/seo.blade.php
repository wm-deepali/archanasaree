{{--
    resources/views/partials/seo.blade.php

    Included inside <head> of layouts.app.
    $seo = SeoPage row for the current route (or null), shared by a View composer.

    Priority:
      1. Pages that define @section('title') / @section('meta')
         (blog-detail, career-detail) keep full control of their own tags.
      2. Everything else uses the seo_pages row for the current route name.
      3. No row / inactive row => safe defaults.
--}}
@php
    $seo       = $seo ?? null;
    $site      = config('app.name', 'Web Mingo');
    $hasTitle  = $__env->hasSection('title');
    $hasMeta   = $__env->hasSection('meta');

    // make "/images/x.jpg" absolute
    $abs = function ($path) {
        if (!$path) return null;
        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']) ? $path : url($path);
    };

    $title     = $seo->meta_title ?? $site;
    $desc      = $seo->meta_description ?? null;
    $canonical = $seo->canonical_url ?? url()->current();   // current() drops ?query / ?page=
    $robots    = $seo->robots ?? 'index, follow';

    $ogTitle   = $seo->og_title ?? $title;
    $ogDesc    = $seo->og_description ?? $desc;
    $ogImage   = $abs($seo->og_image ?? null);

    $twTitle   = $seo->twitter_title ?? $ogTitle;
    $twDesc    = $seo->twitter_description ?? $ogDesc;
    $twImage   = $abs($seo->twitter_image ?? null) ?: $ogImage;
@endphp

@if ($hasTitle)
    <title>@yield('title')</title>
@else
    <title>{{ $title }}</title>
@endif

@if ($hasMeta)
    @yield('meta')
@else
    @if ($desc)
        <meta name="description" content="{{ $desc }}" />
    @endif
    @if (!empty($seo?->meta_keywords))
        <meta name="keywords" content="{{ $seo->meta_keywords }}" />
    @endif
    <meta name="robots" content="{{ $robots }}" />
    <link rel="canonical" href="{{ $canonical }}" />

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ $site }}" />
    <meta property="og:locale" content="en_IN" />
    <meta property="og:type" content="{{ $seo->og_type ?? 'website' }}" />
    <meta property="og:title" content="{{ $ogTitle }}" />
    @if ($ogDesc)
        <meta property="og:description" content="{{ $ogDesc }}" />
    @endif
    <meta property="og:url" content="{{ $canonical }}" />
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}" />
    @endif

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="{{ $seo->twitter_card ?? 'summary_large_image' }}" />
    <meta name="twitter:title" content="{{ $twTitle }}" />
    @if ($twDesc)
        <meta name="twitter:description" content="{{ $twDesc }}" />
    @endif
    @if ($twImage)
        <meta name="twitter:image" content="{{ $twImage }}" />
    @endif

    {{-- Structured data (re-encoded so a stray </script> in the JSON can't break the page) --}}
    @if (!empty($seo?->schema_markup))
        @php $schema = json_decode($seo->schema_markup, true); @endphp
        @if ($schema)
            <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
        @endif
    @endif
@endif

{{-- Custom head scripts (analytics, verification, pixels) --}}
@if (!empty($seo?->scripts))
    {!! $seo->scripts !!}
@endif