@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/product-listing/product-listing.css') }}" />
@endpush

@section('content')
    @php
        $products = [
            0  => ['img' => 'tab1.png', 'name' => 'Kanjivaram Pure Silk Saree', 'cat' => 'Silk Saree', 'rate' => '4.9', 'price' => 12999, 'old' => 17499, 'off' => 26, 'badge' => 'Bestseller'],
            1  => ['img' => 'tab2.png', 'name' => 'Banarasi Zari Woven Silk Saree', 'cat' => 'Banarasi Saree', 'rate' => '4.8', 'price' => 8499, 'old' => 11999, 'off' => 29, 'badge' => 'Bestseller'],
            2  => ['img' => 'tab3.png', 'name' => 'Organza Floral Embroidered Saree', 'cat' => 'Organza Saree', 'rate' => '4.7', 'price' => 6799, 'old' => 9499, 'off' => 28, 'badge' => 'New Arrival'],
            3  => ['img' => 'tab4.png', 'name' => 'Handloom Chanderi Silk Saree', 'cat' => 'Chanderi Saree', 'rate' => '4.8', 'price' => 9999, 'old' => 13999, 'off' => 29, 'badge' => 'Handcrafted'],
            4  => ['img' => 'tab1.png', 'name' => 'Embroidered Designer Lehenga Set', 'cat' => 'Designer Lehenga', 'rate' => '4.7', 'price' => 24999, 'old' => 34999, 'off' => 29, 'badge' => 'Limited Edition'],
            5  => ['img' => 'tab2.png', 'name' => 'Velvet Bridal Lehenga', 'cat' => 'Bridal Lehenga', 'rate' => '4.9', 'price' => 38999, 'old' => 52999, 'off' => 26, 'badge' => 'Bestseller'],
            6  => ['img' => 'tab3.png', 'name' => 'Sequined Reception Lehenga', 'cat' => 'Party Lehenga', 'rate' => '4.6', 'price' => 18499, 'old' => 25999, 'off' => 29, 'badge' => null],
            7  => ['img' => 'tab4.png', 'name' => 'Pastel Organza Lehenga', 'cat' => 'Organza Lehenga', 'rate' => '4.7', 'price' => 21299, 'old' => 29999, 'off' => 29, 'badge' => 'New Arrival'],
            8  => ['img' => 'tab2.png', 'name' => 'Soft Georgette Festive Saree', 'cat' => 'Georgette Saree', 'rate' => '4.6', 'price' => 5499, 'old' => 7499, 'off' => 27, 'badge' => null],
            9  => ['img' => 'tab4.png', 'name' => 'Ivory Zari Work Saree', 'cat' => 'Silk Saree', 'rate' => '4.7', 'price' => 11499, 'old' => 15999, 'off' => 28, 'badge' => null],
            10 => ['img' => 'tab1.png', 'name' => 'Emerald Green Designer Silk Saree', 'cat' => 'Designer Saree', 'rate' => '4.7', 'price' => 14499, 'old' => 19999, 'off' => 28, 'badge' => 'Limited Edition'],
        ];

        $sortOptions = [
            'recommended' => 'Recommended', 'newest' => 'Newest Arrivals', 'sold' => 'Best Selling',
            'low' => 'Price: Low to High', 'high' => 'Price: High to Low',
        ];

        // style: chips | swatch | list | sizes | radio
        $filters = [
            ['title' => 'Category', 'name' => 'category', 'style' => 'chips', 'open' => true, 'options' => [
                'sarees' => 'Sarees', 'lehengas' => 'Lehengas', 'bridal-wear' => 'Bridal Wear',
                'party-wear' => 'Party Wear', 'festive-wear' => 'Festive Wear']],
            ['title' => 'Price', 'name' => 'price', 'style' => 'price', 'open' => true],
            ['title' => 'Color', 'name' => 'color', 'style' => 'swatch', 'open' => true, 'options' => [
                'red' => ['Red', '#b3203c'], 'wine' => ['Wine', '#5e1a33'], 'pink' => ['Pink', '#e79aa8'],
                'blush' => ['Blush', '#f4d6d6'], 'maroon' => ['Maroon', '#6e1423'], 'green' => ['Green', '#1f6b4f'],
                'blue' => ['Blue', '#2b3a7a'], 'black' => ['Black', '#222'], 'beige' => ['Beige', '#d9c3a0'],
                'ivory' => ['Ivory', '#f3ecd9']]],
            ['title' => 'Saree Type', 'name' => 'type', 'style' => 'list', 'open' => true, 'options' => [
                'banarasi' => 'Banarasi Silk', 'kanjivaram' => 'Kanjivaram Silk', 'organza' => 'Organza',
                'chiffon' => 'Chiffon', 'georgette' => 'Georgette', 'chanderi' => 'Chanderi',
                'net' => 'Net Sarees', 'cotton' => 'Cotton Sarees']],
            ['title' => 'Occasion', 'name' => 'occasion', 'style' => 'chips', 'open' => false, 'options' => [
                'wedding' => 'Wedding', 'bridal' => 'Bridal', 'reception' => 'Reception', 'festive' => 'Festive',
                'party' => 'Party', 'cocktail' => 'Cocktail', 'engagement' => 'Engagement']],
            ['title' => 'Collection', 'name' => 'collection', 'style' => 'list', 'open' => false, 'options' => [
                'new' => 'New Arrivals', 'best' => 'Best Sellers', 'featured' => 'Featured',
                'wedding' => 'Wedding Collection', 'festive' => 'Festive Collection']],
            ['title' => 'Fabric', 'name' => 'fabric', 'style' => 'chips', 'open' => false, 'options' => [
                'silk' => 'Silk', 'organza' => 'Organza', 'georgette' => 'Georgette', 'chiffon' => 'Chiffon',
                'net' => 'Net', 'cotton' => 'Cotton', 'chanderi' => 'Chanderi']],
            ['title' => 'Size', 'name' => 'size', 'style' => 'sizes', 'open' => false, 'options' => [
                'xs' => 'XS', 's' => 'S', 'm' => 'M', 'l' => 'L', 'xl' => 'XL', 'xxl' => 'XXL']],
            ['title' => 'Discount', 'name' => 'discount', 'style' => 'radio', 'open' => false, 'options' => [
                '10' => '10% & Above', '20' => '20% & Above', '30' => '30% & Above', '40' => '40% & Above']],
        ];
    @endphp

    {{-- Hero --}}
    <section class="listing-banner">
        <div class="banner-img">
            <img src="{{ asset('assets/images/home/banner2.png') }}" alt="Archana Saree Emporium all collections" />
        </div>
        <div class="container">
            <ul class="crumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li><a href="javascript:void(0)">All Collections</a></li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li class="current">All Products</li>
            </ul>
            <div class="banner-content">
                <span class="eyebrow">All Collections</span>
                <h1>A Curated World of Indian Elegance</h1>
                <p class="banner-desc">
                    Discover timeless sarees, statement lehengas and celebration-ready
                    ensembles, thoughtfully curated for every occasion.
                </p>
                <a href="#listingMain" class="btn btn-primary">Shop the Collection</a>
            </div>
        </div>
    </section>

    {{-- Listing --}}
    <section class="listing-main" id="listingMain">
        <div class="container">
            <input type="checkbox" id="filterToggle" class="filter-toggle" hidden />

            <div class="listing-toolbar">
                <p class="listing-count">Showing <b>1–24</b> of <b>128</b> products</p>
                <div class="listing-tools">
                    <label for="filterToggle" class="tool-btn"><i class="fa-solid fa-sliders"></i> Filter</label>
                    <div class="view-switch" aria-label="Grid view">
                        <button type="button" class="view-btn" data-cols="3" aria-label="3 columns"><i class="fa-solid fa-table-cells-large"></i></button>
                        <button type="button" class="view-btn active" data-cols="4" aria-label="4 columns"><i class="fa-solid fa-table-cells"></i></button>
                    </div>
                    <div class="listing-sort">
                        <label for="listingSort">Sort By</label>
                        <div class="sort-box">
                            <select id="listingSort" name="sort">
                                @foreach ($sortOptions as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="listing-layout">
                <label for="filterToggle" class="filter-overlay" aria-hidden="true"></label>

                {{-- Filter --}}
                <form class="listing-filter" id="filterPanel" action="{{ route('products') }}" method="get" aria-label="Product filters">
                    <div class="f-head">
                        <div class="f-ttl">
                            <span class="f-icon"><i class="fa-solid fa-sliders"></i></span>
                            <h4>Filter By</h4>
                        </div>
                        <button type="reset" class="f-clear">Clear All</button>
                        <label for="filterToggle" class="f-close" aria-label="Close filters"><i class="fa-solid fa-xmark"></i></label>
                    </div>

                    <div class="f-scroll">
                        @foreach ($filters as $f)
                            <details class="f-group" {{ $f['open'] ? 'open' : '' }}>
                                <summary>{{ $f['title'] }}</summary>

                                @switch($f['style'])
                                    @case('price')
                                        <div class="f-body">
                                            <div class="price-range" data-min="1000" data-max="50000">
                                                <div class="range-track"><span class="range-fill"></span></div>
                                                <input type="range" class="range-min" min="1000" max="50000" step="500" value="{{ request('price_min', 1000) }}" aria-label="Minimum price" />
                                                <input type="range" class="range-max" min="1000" max="50000" step="500" value="{{ request('price_max', 50000) }}" aria-label="Maximum price" />
                                            </div>
                                            <div class="price-inputs">
                                                <label><span>Min</span><b>₹</b><input type="number" name="price_min" class="in-min" value="{{ request('price_min', 1000) }}" min="1000" max="50000" step="500" /></label>
                                                <i class="price-dash"></i>
                                                <label><span>Max</span><b>₹</b><input type="number" name="price_max" class="in-max" value="{{ request('price_max', 50000) }}" min="1000" max="50000" step="500" /></label>
                                            </div>
                                        </div>
                                        @break

                                    @case('chips')
                                        <div class="f-body f-chips">
                                            @foreach ($f['options'] as $val => $label)
                                                <label class="f-chip"><input type="checkbox" name="{{ $f['name'] }}[]" value="{{ $val }}" {{ in_array($val, (array) request($f['name'], [])) ? 'checked' : '' }} /><span>{{ $label }}</span></label>
                                            @endforeach
                                        </div>
                                        @break

                                    @case('swatch')
                                        <div class="f-body f-swatches">
                                            @foreach ($f['options'] as $val => [$label, $hex])
                                                <label class="f-swatch" title="{{ $label }}"><input type="checkbox" name="{{ $f['name'] }}[]" value="{{ $val }}" {{ in_array($val, (array) request($f['name'], [])) ? 'checked' : '' }} /><span style="--c: {{ $hex }}"></span></label>
                                            @endforeach
                                        </div>
                                        @break

                                    @case('sizes')
                                        <div class="f-body f-sizes">
                                            @foreach ($f['options'] as $val => $label)
                                                <label class="f-size"><input type="checkbox" name="{{ $f['name'] }}[]" value="{{ $val }}" {{ in_array($val, (array) request($f['name'], [])) ? 'checked' : '' }} /><span>{{ $label }}</span></label>
                                            @endforeach
                                        </div>
                                        @break

                                    @case('radio')
                                        <div class="f-body f-list">
                                            @foreach ($f['options'] as $val => $label)
                                                <label class="f-check"><input type="radio" name="{{ $f['name'] }}" value="{{ $val }}" {{ request($f['name']) == $val ? 'checked' : '' }} /><span class="f-box is-radio"></span><span class="f-text">{{ $label }}</span></label>
                                            @endforeach
                                        </div>
                                        @break

                                    @default
                                        <div class="f-body f-list">
                                            @foreach ($f['options'] as $val => $label)
                                                <label class="f-check"><input type="checkbox" name="{{ $f['name'] }}[]" value="{{ $val }}" {{ in_array($val, (array) request($f['name'], [])) ? 'checked' : '' }} /><span class="f-box"></span><span class="f-text">{{ $label }}</span></label>
                                            @endforeach
                                        </div>
                                @endswitch
                            </details>
                        @endforeach
                    </div>

                    <div class="f-foot">
                        <button type="reset" class="btn btn-outline-primary">Clear All</button>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>

                {{-- Products --}}
                <div class="listing-content">
                    <div class="listing-grid" id="listingGrid">
                        @foreach (range(0, 7) as $i)
                            @include('partials.product-card', ['p' => $products[$i]])
                        @endforeach
                    </div>

                    <nav class="listing-pagination" aria-label="Product pages">
                        <a href="javascript:void(0)" class="pg-nav is-disabled" aria-disabled="true"><i class="fa-solid fa-arrow-left-long"></i> Previous</a>
                        <ul>
                            <li><a href="javascript:void(0)" class="active" aria-current="page">01</a></li>
                            <li><a href="javascript:void(0)">02</a></li>
                            <li><a href="javascript:void(0)">03</a></li>
                            <li><a href="javascript:void(0)">04</a></li>
                            <li class="dots">…</li>
                            <li><a href="javascript:void(0)">08</a></li>
                        </ul>
                        <a href="javascript:void(0)" class="pg-nav">Next <i class="fa-solid fa-arrow-right-long"></i></a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    {{-- Recently viewed --}}
    <section class="listing-recent">
        <div class="container">
            <div class="sec-head">
                <div class="heading"><h3>Recently Viewed</h3></div>
                <p>A few styles you may want to revisit.</p>
            </div>
            <div class="swiper-wrap">
                <div class="swiper fourSlider">
                    <div class="swiper-wrapper">
                        @foreach ([0, 1, 5, 8, 9] as $i)
                            <div class="swiper-slide">
                                @include('partials.product-card', ['p' => $products[$i], 'showBadge' => false])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-group">
                    <button type="button" class="btn-prev" aria-label="Previous slide"><i class="fa-solid fa-arrow-right"></i></button>
                    <button type="button" class="btn-next" aria-label="Next slide"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    {{-- You may also love --}}
    <section class="listing-like">
        <div class="container">
            <div class="sec-head">
                <div class="heading"><h3>You May Also Love</h3></div>
                <p>Discover more pieces selected to complement your style.</p>
            </div>
            <div class="swiper-wrap">
                <div class="swiper fourSlider">
                    <div class="swiper-wrapper">
                        @foreach ([10, 6, 7, 0, 1] as $i)
                            <div class="swiper-slide">
                                @include('partials.product-card', ['p' => $products[$i]])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-group">
                    <button type="button" class="btn-prev" aria-label="Previous slide"><i class="fa-solid fa-arrow-right"></i></button>
                    <button type="button" class="btn-next" aria-label="Next slide"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    {{-- Journal --}}
    <section class="listing-journal">
        <div class="container">
            <div class="journal-grid">
                <div class="journal-visual">
                    <div class="journal-photo">
                        <img src="{{ asset('assets/images/home/banner5.jpg') }}" alt="The art of dressing for every occasion" loading="lazy" />
                    </div>
                </div>
                <div class="journal-content">
                    <span class="eyebrow">The Archana Journal</span>
                    <div class="heading"><h3>The Art of Dressing for Every Occasion</h3></div>
                    <p>
                        From heirloom-inspired silks to contemporary festive silhouettes,
                        discover styles that celebrate Indian craftsmanship with a modern point of view.
                    </p>
                    <a href="javascript:void(0)" class="btn btn-primary">
                        Explore the Collection <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Newsletter --}}
    <section class="listing-news">
        <div class="container">
            <div class="news-wrap">
                <div class="news-photo">
                    <img src="{{ asset('assets/images/home/offer1.jpg') }}" alt="Stay in the know" loading="lazy" />
                </div>
                <div class="news-panel">
                    <span class="eyebrow">Stay in the Know</span>
                    <div class="heading"><h3>Be the First to Discover What's New</h3></div>
                    <p class="news-desc">
                        Sign up for new arrivals, exclusive collections, festive edits and special offers from Archana Saree Emporium.
                    </p>
                    <form class="form news-form" action="#" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="email" id="listNewsEmail" name="email" placeholder=" " required />
                            <label for="listNewsEmail">Enter your email address</label>
                        </div>
                        <button type="submit" class="btn btn-black">
                            Subscribe <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            /* Price range */
            const box = document.querySelector(".price-range");
            if (box) {
                const form = box.closest("form");
                const MIN = +box.dataset.min, MAX = +box.dataset.max, GAP = 500;
                const rMin = box.querySelector(".range-min"), rMax = box.querySelector(".range-max");
                const fill = box.querySelector(".range-fill");
                const nMin = form.querySelector(".in-min"), nMax = form.querySelector(".in-max");

                const paint = (src) => {
                    let a = +rMin.value, b = +rMax.value;
                    if (b - a < GAP) { src === "min" ? (a = b - GAP) : (b = a + GAP); }
                    rMin.value = nMin.value = a;
                    rMax.value = nMax.value = b;
                    fill.style.left = ((a - MIN) / (MAX - MIN)) * 100 + "%";
                    fill.style.right = 100 - ((b - MIN) / (MAX - MIN)) * 100 + "%";
                };

                rMin.oninput = () => paint("min");
                rMax.oninput = () => paint("max");
                nMin.onchange = () => { rMin.value = nMin.value; paint("min"); };
                nMax.onchange = () => { rMax.value = nMax.value; paint("max"); };
                form.addEventListener("reset", () => setTimeout(paint));
                paint();
            }

            /* Grid view switch */
            const grid = document.getElementById("listingGrid");
            document.querySelectorAll(".view-btn").forEach((btn) => {
                btn.onclick = () => {
                    document.querySelectorAll(".view-btn").forEach((b) => b.classList.remove("active"));
                    btn.classList.add("active");
                    grid.classList.toggle("is-3", btn.dataset.cols === "3");
                };
            });
        })();
    </script>
@endpush