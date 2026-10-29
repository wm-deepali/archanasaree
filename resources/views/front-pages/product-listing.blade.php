@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/product-listing/product-listing.css') }}" />
@endpush

@section('content')

    <main>
        <!-- ========== 1. HERO ========== -->
        <section class="listing-banner">
            <div class="banner-img">
                <img src="assets/images/home/banner2.png" alt="Archana Saree Emporium all collections" />
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

        <!-- ========== 2. LISTING ========== -->
        <section class="listing-main" id="listingMain">
            <div class="container">
                <input type="checkbox" id="filterToggle" class="filter-toggle" hidden />

                <div class="listing-toolbar">
                    <p class="listing-count">
                        Showing <b>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</b>
                        of <b>{{ $products->total() }}</b> products
                    </p>
                    <div class="listing-tools">
                        <label for="filterToggle" class="tool-btn"><i class="fa-solid fa-sliders"></i> Filter</label>
                        <div class="view-switch" aria-label="Grid view">
                            <button type="button" class="view-btn" data-cols="3" aria-label="3 columns"><i
                                    class="fa-solid fa-table-cells-large"></i></button>
                            <button type="button" class="view-btn active" data-cols="4" aria-label="4 columns"><i
                                    class="fa-solid fa-table-cells"></i></button>
                        </div>
                        <div class="listing-sort">
                            <label for="listingSort">Sort By</label>
                            <div class="sort-box">
                                <select id="listingSort" name="sort" form="filterPanel" onchange="this.form.submit()">
                                    @foreach (['recommended' => 'Recommended', 'newest' => 'Newest Arrivals', 'sold' => 'Best Selling', 'low' => 'Price: Low to High', 'high' => 'Price: High to Low'] as $val => $label)
                                        <option value="{{ $val }}" @selected(request('sort', 'recommended') === $val)>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="listing-layout">
                    <label for="filterToggle" class="filter-overlay" aria-hidden="true"></label>

                    <form class="listing-filter" id="filterPanel" action="{{ route('products') }}" method="get"
                        aria-label="Product filters" novalidate>
                        <div class="f-head">
                            <div class="f-ttl">
                                <span class="f-icon"><i class="fa-solid fa-sliders"></i></span>
                                <h4>Filter By</h4>
                            </div>
                            <a href="{{ route('products') }}" class="f-clear">Clear All</a>
                            <label for="filterToggle" class="f-close" aria-label="Close filters"><i
                                    class="fa-solid fa-xmark"></i></label>
                        </div>

                        <div class="f-scroll">
                            {{-- Category --}}
                            @php $selCat = (array) request('category', []); @endphp
                            <details class="f-group" open>
                                <summary>Category</summary>
                                <div class="f-body f-chips">
                                    @foreach ($filterCategories as $c)
                                        <label class="f-chip"><input type="checkbox" name="category[]" value="{{ $c->slug }}"
                                                @checked(in_array($c->slug, $selCat)) /><span>{{ $c->name }}</span></label>
                                    @endforeach
                                </div>
                            </details>

                            {{-- Price --}}
                            @php
                                $pMin = max($priceMin, min((int) request('price_min', $priceMin), $priceMax));
                                $pMax = min($priceMax, max((int) request('price_max', $priceMax), $priceMin));
                            @endphp
                            <details class="f-group" open>
                                <summary>Price</summary>
                                <div class="f-body">
                                    <div class="price-range" data-min="{{ $priceMin }}" data-max="{{ $priceMax }}">
                                        <div class="range-track"><span class="range-fill"></span></div>
                                        <input type="range" class="range-min" min="{{ $priceMin }}" max="{{ $priceMax }}"
                                            step="500" value="{{ $pMin }}" aria-label="Minimum price" />
                                        <input type="range" class="range-max" min="{{ $priceMin }}" max="{{ $priceMax }}"
                                            step="500" value="{{ $pMax }}" aria-label="Maximum price" />
                                    </div>
                                    <div class="price-inputs">
                                        <label><span>Min</span><b>₹</b><input type="number" name="price_min" class="in-min"
                                                value="{{ $pMin }}" min="{{ $priceMin }}" max="{{ $priceMax }}"
                                                step="500" /></label>
                                        <i class="price-dash"></i>
                                        <label><span>Max</span><b>₹</b><input type="number" name="price_max" class="in-max"
                                                value="{{ $pMax }}" min="{{ $priceMin }}" max="{{ $priceMax }}"
                                                step="500" /></label>
                                    </div>
                                </div>
                            </details>

                            {{-- Attributes (Colour, Fabric, Size...) : show_in_filter se --}}
                            @foreach ($filterAttributes as $attr)
                                @php
                                    $sel = (array) request()->input('attr.' . $attr->slug, []);
                                    $hasHex = $attr->values->contains(fn($v) => !empty($v->hex_code));
                                    $isSize = \Illuminate\Support\Str::contains($attr->slug, 'size');
                                @endphp
                                <details class="f-group" @if ($loop->first || $sel) open @endif>
                                    <summary>{{ $attr->name }}</summary>
                                    @if ($hasHex)
                                        <div class="f-body f-swatches">
                                            @foreach ($attr->values as $v)
                                                @php $hex = $v->hex_code ? (str_starts_with($v->hex_code, '#') ? $v->hex_code : '#' . $v->hex_code) : '#cccccc'; @endphp
                                                <label class="f-swatch" title="{{ $v->value }}"><input type="checkbox"
                                                        name="attr[{{ $attr->slug }}][]" value="{{ $v->slug }}"
                                                        @checked(in_array($v->slug, $sel)) /><span
                                                        style="--c: {{ $hex }}"></span></label>
                                            @endforeach
                                        </div>
                                    @elseif ($isSize)
                                        <div class="f-body f-sizes">
                                            @foreach ($attr->values as $v)
                                                <label class="f-size"><input type="checkbox" name="attr[{{ $attr->slug }}][]"
                                                        value="{{ $v->slug }}" @checked(in_array($v->slug, $sel)) /><span>{{ $v->value }}</span></label>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="f-body f-chips">
                                            @foreach ($attr->values as $v)
                                                <label class="f-chip"><input type="checkbox" name="attr[{{ $attr->slug }}][]"
                                                        value="{{ $v->slug }}" @checked(in_array($v->slug, $sel)) /><span>{{ $v->value }}</span></label>
                                            @endforeach
                                        </div>
                                    @endif
                                </details>
                            @endforeach

                            {{-- Sub Category (sirf jab category select ho) --}}
                            @if ($filterSubs->isNotEmpty())
                                @php $selSub = (array) request('sub', []); @endphp
                                <details class="f-group" open>
                                    <summary>Type</summary>
                                    <div class="f-body f-list">
                                        @foreach ($filterSubs as $s)
                                            <label class="f-check"><input type="checkbox" name="sub[]" value="{{ $s->slug }}"
                                                    @checked(in_array($s->slug, $selSub)) /><span class="f-box"></span><span
                                                    class="f-text">{{ $s->name }}</span></label>
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            {{-- Occasion --}}
                            @if ($filterOccasions->isNotEmpty())
                                @php $selOcc = (array) request('occasion', []); @endphp
                                <details class="f-group" @if ($selOcc) open @endif>
                                    <summary>Occasion</summary>
                                    <div class="f-body f-chips">
                                        @foreach ($filterOccasions as $o)
                                            <label class="f-chip"><input type="checkbox" name="occasion[]" value="{{ $o->slug }}"
                                                    @checked(in_array($o->slug, $selOcc)) /><span>{{ $o->title }}</span></label>
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            {{-- Collection --}}
                            @if ($filterCollections->isNotEmpty())
                                @php $selCol = (array) request('collection', []); @endphp
                                <details class="f-group" @if ($selCol) open @endif>
                                    <summary>Collection</summary>
                                    <div class="f-body f-list">
                                        @foreach ($filterCollections as $c)
                                            <label class="f-check"><input type="checkbox" name="collection[]" value="{{ $c->slug }}"
                                                    @checked(in_array($c->slug, $selCol)) /><span class="f-box"></span><span
                                                    class="f-text">{{ $c->name }}</span></label>
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            {{-- Discount --}}
                            <details class="f-group" @if (request('discount')) open @endif>
                                <summary>Discount</summary>
                                <div class="f-body f-list">
                                    @foreach ([10, 20, 30, 40] as $d)
                                        <label class="f-check"><input type="radio" name="discount" value="{{ $d }}"
                                                @checked(request('discount') == $d) /><span class="f-box is-radio"></span><span
                                                class="f-text">{{ $d }}% &amp; Above</span></label>
                                    @endforeach
                                </div>
                            </details>
                        </div>

                        <div class="f-foot">
                            <a href="{{ route('products') }}" class="btn btn-outline-primary">Clear All</a>
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>

                    <div class="listing-content">
                        <div class="listing-grid" id="listingGrid">
                            @include('partials.product-cards', ['products' => $products])
                        </div>

                        {{ $products->links('vendor.pagination.listing') }}
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== 3. RECENTLY VIEWED ========== -->
        @if ($recentlyViewed->isNotEmpty())
            <section class="listing-recent">
                <div class="container">
                    <div class="sec-head">
                        <div class="heading">
                            <h3>Recently Viewed</h3>
                        </div>
                        <p>A few styles you may want to revisit.</p>
                    </div>
                    <div class="swiper-wrap">
                        <div class="swiper fourSlider">
                            <div class="swiper-wrapper">
                                @include('partials.product-slider', ['products' => $recentlyViewed])
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
        @endif

        <!-- ========== 4. YOU MAY ALSO LOVE ========== -->
        @if ($alsoLike->isNotEmpty())
            <section class="listing-like">
                <div class="container">
                    <div class="sec-head">
                        <div class="heading">
                            <h3>You May Also Love</h3>
                        </div>
                        <p>Discover more pieces selected to complement your style.</p>
                    </div>
                    <div class="swiper-wrap">
                        <div class="swiper fourSlider">
                            <div class="swiper-wrapper">
                                @include('partials.product-slider', ['products' => $alsoLike])
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
        @endif

        <!-- ========== 6. JOURNAL ========== -->
        <section class="listing-journal">
            <div class="container">
                <div class="journal-grid">
                    <div class="journal-visual">
                        <div class="journal-photo">
                            <img src="assets/images/home/banner5.jpg" alt="The art of dressing for every occasion"
                                loading="lazy" />
                        </div>
                    </div>
                    <div class="journal-content">
                        <span class="eyebrow">The Archana Journal</span>
                        <div class="heading">
                            <h3>The Art of Dressing for Every Occasion</h3>
                        </div>
                        <p>
                            From heirloom-inspired silks to contemporary festive
                            silhouettes, discover styles that celebrate Indian craftsmanship
                            with a modern point of view.
                        </p>
                        <a href="javascript:void(0)" class="btn btn-primary">Explore the Collection
                            <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== 7. NEWSLETTER ========== -->
        <section class="listing-news">
            <div class="container">
                <div class="news-wrap">
                    <div class="news-photo">
                        <img src="assets/images/home/offer1.jpg" alt="Stay in the know" loading="lazy" />
                    </div>
                    <div class="news-panel">
                        <span class="eyebrow">Stay in the Know</span>
                        <div class="heading">
                            <h3>Be the First to Discover What's New</h3>
                        </div>
                        <p class="news-desc">
                            Sign up for new arrivals, exclusive collections, festive edits
                            and special offers from Archana Saree Emporium.
                        </p>
                        <form class="form news-form" action="#" method="post">
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
    </main>

@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById("filterPanel");
            if (!form) return;

            /* Price range */
            const box = document.querySelector(".price-range");
            if (box) {
                const MIN = +box.dataset.min, MAX = +box.dataset.max;
                const rMin = box.querySelector(".range-min"), rMax = box.querySelector(".range-max");
                const fill = box.querySelector(".range-fill");
                const nMin = form.querySelector(".in-min"), nMax = form.querySelector(".in-max");
                const STEP = +rMin.step || 500;
                const GAP = Math.min(STEP, Math.max(0, MAX - MIN)); // range chhoti ho to bhi lock na ho

                const clamp = (v) => Math.min(MAX, Math.max(MIN, isNaN(v) ? MIN : v));

                const paint = (src) => {
                    let a = clamp(+rMin.value), b = clamp(+rMax.value);
                    if (b - a < GAP) { src === "min" ? (a = b - GAP) : (b = a + GAP); }
                    a = clamp(a); b = clamp(b);
                    rMin.value = nMin.value = a;
                    rMax.value = nMax.value = b;
                    const span = (MAX - MIN) || 1;
                    fill.style.left = ((a - MIN) / span) * 100 + "%";
                    fill.style.right = 100 - ((b - MIN) / span) * 100 + "%";
                };

                rMin.addEventListener("input", () => paint("min"));
                rMax.addEventListener("input", () => paint("max"));
                nMin.addEventListener("input", () => { rMin.value = nMin.value; paint("min"); });
                nMax.addEventListener("input", () => { rMax.value = nMax.value; paint("max"); });
                paint();

                // default bounds par ho to price params bhejo hi mat
                form.addEventListener("submit", () => {
                    if (+nMin.value <= MIN) nMin.disabled = true;
                    if (+nMax.value >= MAX) nMax.disabled = true;
                });

                // back button par disabled inputs wapas enable
                window.addEventListener("pageshow", () => { nMin.disabled = false; nMax.disabled = false; paint(); });
            }

            /* Desktop par filter chunte hi apply (mobile par Apply button hi rahega) */
            const desktop = window.matchMedia("(min-width: 992px)");
            let timer;
            form.addEventListener("change", () => {
                if (!desktop.matches) return;
                clearTimeout(timer);
                timer = setTimeout(() => form.requestSubmit(), 400);
            });

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