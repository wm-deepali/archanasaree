@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/listing/listing.css') }}" />
@endpush

@section('content')
    @php
        $products = [
            ['img' => 'tab1.png', 'name' => 'Kanjivaram Pure Silk Saree', 'cat' => 'Silk Saree', 'rate' => '4.9', 'price' => 12999, 'old' => 17499, 'off' => 26, 'badge' => 'Bestseller'],
            ['img' => 'tab2.png', 'name' => 'Zari Woven Banarasi Silk Saree', 'cat' => 'Banarasi Saree', 'rate' => '4.8', 'price' => 8499, 'old' => 11999, 'off' => 29, 'badge' => 'Bestseller'],
            ['img' => 'tab3.png', 'name' => 'Handcrafted Organza Saree', 'cat' => 'Organza Saree', 'rate' => '4.7', 'price' => 6799, 'old' => 9499, 'off' => 28, 'badge' => 'New Arrival'],
            ['img' => 'tab4.png', 'name' => 'Royal Maroon Banarasi Saree', 'cat' => 'Banarasi Saree', 'rate' => '4.8', 'price' => 9999, 'old' => 13999, 'off' => 29, 'badge' => null],
            ['img' => 'tab1.png', 'name' => 'Emerald Green Designer Silk Saree', 'cat' => 'Designer Saree', 'rate' => '4.7', 'price' => 14499, 'old' => 19999, 'off' => 28, 'badge' => 'Limited Edit'],
            ['img' => 'tab2.png', 'name' => 'Pastel Pink Organza Saree', 'cat' => 'Organza Saree', 'rate' => '4.6', 'price' => 5499, 'old' => 7499, 'off' => 27, 'badge' => 'New Arrival'],
            ['img' => 'tab3.png', 'name' => 'Wine Embroidered Party Saree', 'cat' => 'Party Wear Saree', 'rate' => '4.6', 'price' => 7299, 'old' => 9999, 'off' => 27, 'badge' => null],
            ['img' => 'tab4.png', 'name' => 'Ivory Zari Work Saree', 'cat' => 'Silk Saree', 'rate' => '4.7', 'price' => 11499, 'old' => 15999, 'off' => 28, 'badge' => null],
        ];

        $tabs = [
            1 => ['label' => 'All Sarees',       'total' => 48, 'items' => array_keys($products)],
            2 => ['label' => 'Banarasi',         'total' => 2,  'items' => [1, 3]],
            3 => ['label' => 'Silk Sarees',      'total' => 0,  'items' => []],
            4 => ['label' => 'Organza',          'total' => 0,  'items' => []],
            5 => ['label' => 'Georgette',        'total' => 0,  'items' => []],
            6 => ['label' => 'Party Wear',       'total' => 0,  'items' => []],
            7 => ['label' => 'Bridal Sarees',    'total' => 0,  'items' => []],
            8 => ['label' => 'Designer Sarees',  'total' => 0,  'items' => []],
        ];

        $sortOptions = [
            'recommended' => 'Recommended',
            'newest'      => 'New Arrivals',
            'sold'        => 'Best Selling',
            'low'         => 'Price: Low to High',
            'high'        => 'Price: High to Low',
            'rating'      => 'Customer Rating',
        ];

        $filters = [
            'SareeType' => ['title' => 'Saree Type', 'open' => true, 'options' => [
                'banarasi' => 'Banarasi', 'kanjivaram' => 'Kanjivaram', 'organza' => 'Organza',
                'georgette' => 'Georgette', 'silk' => 'Silk', 'chiffon' => 'Chiffon', 'net' => 'Net',
            ]],
            'Occasion' => ['title' => 'Occasion', 'open' => false, 'options' => [
                'wedding' => 'Wedding', 'bridal' => 'Bridal', 'festive' => 'Festive',
                'party' => 'Party', 'reception' => 'Reception',
            ]],
            'Colour' => ['title' => 'Colour', 'open' => false, 'options' => [
                'red' => 'Red', 'maroon' => 'Maroon', 'pink' => 'Pink', 'green' => 'Green', 'blue' => 'Blue',
                'wine' => 'Wine', 'gold' => 'Gold', 'ivory' => 'Ivory', 'beige' => 'Beige',
            ]],
            'Price' => ['title' => 'Price', 'open' => false, 'options' => [
                '0-5000' => 'Under ₹5,000', '5000-10000' => '₹5,000 – ₹10,000',
                '10000-15000' => '₹10,000 – ₹15,000', '15000-25000' => '₹15,000 – ₹25,000',
                '25000+' => 'Above ₹25,000',
            ]],
        ];
    @endphp

    <section class="product-banner">
        <div class="banner-img">
            <img src="{{ asset('assets/images/home/banner2.png') }}" alt="Sarees" />
        </div>
        <div class="container">
            <ul class="crumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><i class="fa-solid fa-chevron-right"></i></li>
                <li class="current">Sarees</li>
            </ul>
            <div class="banner-content">
                <span class="eyebrow">Sarees</span>
                <h1>Draped in Timeless Elegance</h1>
                <p class="banner-desc">
                    Discover beautifully crafted sarees selected for celebrations,
                    weddings and every occasion worth remembering.
                </p>
                <a href="javascript:void(0)" class="btn btn-primary">Shop Sarees</a>
            </div>
        </div>
    </section>

    <section class="product-secB">
        <div class="container">
            <ul class="tab-nav">
                @foreach ($tabs as $n => $tab)
                    <li data-tab="{{ $n }}" class="{{ $loop->first ? 'active' : '' }}">{{ $tab['label'] }}</li>
                @endforeach
            </ul>

            <div class="tab-nav-content">
                @foreach ($tabs as $n => $tab)
                    <div class="tabs {{ $loop->first ? 'active' : '' }}" data-tab="{{ $n }}">
                        @if (count($tab['items']))
                            <div class="prod-head">
                                <h3>The Saree Collection</h3>
                                <span class="prod-styles">{{ $tab['total'] }} styles</span>
                            </div>

                            <div class="prod-toolbar">
                                <p class="prod-count"><b>{{ $tab['total'] }}</b> Sarees</p>
                                <div class="prod-tools">
                                    <button type="button" class="tool-btn filter-btn" data-model=".filter-pop">
                                        <i class="fa-solid fa-sliders"></i> Filter
                                    </button>
                                    <button type="button" class="tool-btn sort-btn" data-model="sort-pop">
                                        <i class="fa-solid fa-arrow-down-wide-short"></i> Sort
                                    </button>
                                    <div class="prod-sort">
                                        <label for="prodSort{{ $n }}">Sort By</label>
                                        <div class="sort-box">
                                            <select id="prodSort{{ $n }}">
                                                @foreach ($sortOptions as $val => $label)
                                                    <option value="{{ $val }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="prod-grid">
                                @foreach ($tab['items'] as $i)
                                    @include('partials.product-card', ['p' => $products[$i]])
                                @endforeach
                            </div>

                            @if ($n === 1)
                                <div class="load-more">
                                    <button type="button" class="btn btn-outline-primary">Load More Sarees</button>
                                    <p>Showing 12 of 48 styles</p>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="product-secC">
        <div class="container">
            <div class="art-grid">
                <div class="art-visual">
                    <div class="art-photo">
                        <img src="{{ asset('assets/images/home/banner5.jpg') }}" alt="The Art of the Saree" loading="lazy" />
                    </div>
                </div>
                <div class="art-content">
                    <div class="heading"><h3>The Art of the Saree</h3></div>
                    <p>
                        A saree is more than a silhouette. It is craftsmanship, colour,
                        tradition and a story carried from one celebration to another.
                    </p>
                    <p>
                        Explore timeless Indian drapes thoughtfully selected for modern
                        wardrobes and unforgettable occasions.
                    </p>
                    <a href="javascript:void(0)" class="btn btn-primary">
                        Explore the Collection <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="product-secD">
        <div class="container">
            <div class="sec-head">
                <div class="heading"><h3>Recently Viewed</h3></div>
                <p>Pieces you've looked at, gathered in one place.</p>
            </div>
            <div class="swiper-wrap">
                <div class="swiper fourSlider">
                    <div class="swiper-wrapper">
                        @foreach ([0, 1, 3, 5, 7] as $i)
                            <div class="swiper-slide">
                                @include('partials.product-card', ['p' => $products[$i], 'showBadge' => false])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-group">
                    <button type="button" class="btn-prev" aria-label="Previous slide">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button type="button" class="btn-next" aria-label="Next slide">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="product-secE">
        <div class="container">
            <div class="sec-head">
                <div class="heading"><h3>You May Also Like</h3></div>
                <p>Discover more pieces selected to complement your style.</p>
            </div>
            <div class="swiper-wrap">
                <div class="swiper fourSlider">
                    <div class="swiper-wrapper">
                        @foreach ([4, 6, 2, 0, 1] as $i)
                            <div class="swiper-slide">
                                @include('partials.product-card', ['p' => $products[$i]])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-group">
                    <button type="button" class="btn-prev" aria-label="Previous slide">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button type="button" class="btn-next" aria-label="Next slide">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="product-secF">
        <div class="container">
            <div class="news-wrap">
                <div class="news-photo">
                    <img src="{{ asset('assets/images/home/offer1.jpg') }}" alt="Stay in the Archana Edit" loading="lazy" />
                </div>
                <div class="news-panel">
                    <div class="heading"><h3>Stay in the Archana Edit</h3></div>
                    <p class="news-desc">
                        Be the first to discover new arrivals, festive edits and exclusive collections.
                    </p>
                    <form class="form news-form" action="#" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="email" id="catNewsEmail" name="email" placeholder=" " required />
                            <label for="catNewsEmail">Enter your email address</label>
                        </div>
                        <button type="submit" class="btn btn-black">
                            Subscribe <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Filter / Sort popups ===== --}}
    <div class="model filter-pop">
        <button type="button" class="close" aria-label="Close filter">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <div class="model-body">
            <div class="title"><h4>Filter By</h4></div>

            <div class="f-groups">
                @foreach ($filters as $name => $group)
                    <details class="f-group" {{ $group['open'] ? 'open' : '' }}>
                        <summary>{{ $group['title'] }} <i class="fa-solid fa-chevron-down"></i></summary>
                        <ul class="f-list">
                            @foreach ($group['options'] as $val => $label)
                                <li>
                                    <label><input type="checkbox" name="{{ $name }}" value="{{ $val }}" /> {{ $label }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                @endforeach
            </div>

            <div class="f-foot">
                <button type="button" class="btn btn-outline-primary">Clear All</button>
                <button type="button" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>

    <div class="model sort-pop">
        <button type="button" class="close" aria-label="Close sort">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <div class="model-body">
            <div class="title"><h4>Sort By</h4></div>
            <ul class="sort-list">
                @foreach ($sortOptions as $val => $label)
                    <li>
                        <label>
                            <input type="radio" name="SortBy" value="{{ $val }}" {{ $loop->first ? 'checked' : '' }} />
                            {{ $label }}
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection