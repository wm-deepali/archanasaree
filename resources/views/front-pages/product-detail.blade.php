@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/detail/detail.css') }}" />
@endpush

@section('content')

    @php
        $hasText = fn($html) => trim(str_replace('&nbsp;', ' ', strip_tags((string) $html))) !== ''
            || preg_match('/<(table|img)\b/i', (string) $html);

        $sizeChart = $hasText($product->subcategory?->size_chart)
            ? $product->subcategory->size_chart
            : ($hasText($product->category->size_chart) ? $product->category->size_chart : null);
    @endphp

    <main>
        <div class="product-detail-page">
            <section class="product-breadcrumb">
                <div class="container">
                    @php
                        $crumbs = [
                            ['label' => 'Home', 'url' => route('home')],
                            ['label' => $product->category->name, 'url' => route('category.show', $product->category->slug)],
                        ];
                        if ($product->subcategory) {
                            $crumbs[] = [
                                'label' => $product->subcategory->name,
                                'url' => route('products', ['category' => [$product->category->slug], 'sub' => [$product->subcategory->slug]]),
                            ];
                        }
                        $crumbs[] = ['label' => $product->name];
                    @endphp
                    @include('partials.breadcrumb', compact('crumbs'))
                </div>
            </section>

            <section class="product-main">
                <div class="container">
                    <div class="product-layout">
                        <div class="product-gallery">
                            @php
                                $badge = $product->collections->first()?->name;
                                $imgs = $gallery->isNotEmpty()
                                    ? $gallery->map(fn($g) => [
                                        'full' => asset('storage/' . $g->image),
                                        'thumb' => asset('storage/' . ($g->thumb ?? $g->image)),
                                    ])
                                    : collect([['full' => asset('assets/images/home/tab1.png'), 'thumb' => asset('assets/images/home/tab1.png')]]);
                            @endphp

                            <div class="gallery-main">
                                @if ($badge)
                                    <span class="gallery-tag">{{ $badge }}</span>
                                @endif
                                <div class="swiper product-gallery-swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($imgs as $i => $img)
                                            <div class="swiper-slide">
                                                <div class="gallery-img">
                                                    <a href="{{ $img['full'] }}" class="glightbox" data-gallery="product">
                                                        <img src="{{ $img['full'] }}"
                                                            alt="{{ $product->name }} - image {{ $i + 1 }}" @if ($i === 0)
                                                            fetchpriority="high" @else loading="lazy" @endif />
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="gallery-zoom" aria-label="Zoom image"><i
                                        class="fa-solid fa-expand"></i></button>
                                <button type="button" class="g-prev" aria-label="Previous image"><i
                                        class="fa-solid fa-chevron-left"></i></button>
                                <button type="button" class="g-next" aria-label="Next image"><i
                                        class="fa-solid fa-chevron-right"></i></button>
                                <div class="gallery-counter"></div>
                            </div>

                            <div class="swiper product-thumb-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($imgs as $i => $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img['thumb'] }}" alt="{{ $product->name }} thumbnail {{ $i + 1 }}"
                                                loading="lazy" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="product-info">
                            <div class="info-top">
                                <span class="info-cat">{{ $product->subcategory->name ?? $product->category->name }}</span>
                                <h1>{{ $product->name }}</h1>
                                <div class="info-rate">
                                    @if ($product->reviews_count)
                                        <span class="rate-pill"><i class="fa-solid fa-star"></i>
                                            {{ number_format($product->avg_rating, 1) }}</span>
                                        <a href="#reviews" class="rate-count">{{ $product->reviews_count }}
                                            {{ Str::plural('Review', $product->reviews_count) }}</a>
                                    @else
                                        <a href="#reviews" class="rate-count">No reviews yet</a>
                                    @endif
                                    @if ($product->sku)
                                        <span class="info-sku" id="infoSku" @if (!$product->sku) style="display:none"
                                        @endif>SKU: {{ $product->sku }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="price-block">
                                <span class="price-now" id="priceNow">₹{{ number_format($product->price) }}</span>
                                <del class="price-old" id="priceOld" @if ($product->discount_percent <= 0)
                                style="display:none" @endif>₹{{ number_format($product->mrp) }}</del>
                                <span class="price-off" id="priceOff" @if ($product->discount_percent <= 0)
                                style="display:none" @endif>{{ $product->discount_percent }}% OFF</span>
                                <p class="price-tax">
                                    Inclusive of all taxes
                                    <span id="priceSave">@if ($product->discount_percent > 0) · You save
                                    ₹{{ number_format($product->mrp - $product->price) }} @endif</span>
                                </p>
                            </div>

                            <p class="info-stock" id="stockLine">
                                <i class="fa-solid fa-circle"></i>
                                <b>{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</b>
                                <em style="display:none"></em>
                            </p>

                            @if ($coupons->isNotEmpty())
                                <div class="product-offers">
                                    <div class="offers-head">
                                        <h5>Offers &amp; Coupons</h5>
                                        <a href="javascript:void(0)">How to Avail</a>
                                    </div>

                                    @foreach ($coupons as $coupon)
                                        <div class="offer-row">
                                            <span class="offer-ico"><i class="fa-solid fa-tag"></i></span>
                                            <div class="offer-text">
                                                <b>Coupon Offer</b>
                                                <p>{{ $coupon->offer_text }}</p>
                                            </div>
                                            <button type="button" class="offer-copy" data-code="{{ $coupon->code }}">
                                                {{ $coupon->code }} <i class="fa-regular fa-copy"></i>
                                            </button>
                                        </div>
                                    @endforeach

                                    <p class="offer-tnc">
                                        Offers are applied at checkout. Only one coupon can be used
                                        per order. Terms &amp; conditions apply.
                                    </p>
                                </div>
                            @endif

                            @if (!empty($product->short_description))
                                <p class="info-desc">{{ $product->short_description }}</p>
                            @endif

                            @include('partials.product-options')

                            <div class="product-delivery">
                                <div class="del-head">
                                    <i class="fa-solid fa-location-dot"></i><b>Check Delivery</b>
                                </div>
                                <form class="pin-form" id="pinForm" action="{{ route('pincode.check') }}" method="get">
                                    <input type="text" name="pincode" inputmode="numeric" maxlength="6"
                                        placeholder="Enter your pincode" aria-label="Pincode" />
                                    <button type="submit">Check</button>
                                </form>
                                <p class="pin-result" id="pinResult" style="display:none"></p>

                                <ul class="del-steps">
                                    <li>
                                        <i class="fa-solid fa-bag-shopping"></i>
                                        <b>Order Placed</b>
                                        <span>Today</span>
                                    </li>
                                    @if ($product->delivery_time)
                                        <li>
                                            <i class="fa-solid fa-box"></i>
                                            <b>Dispatched</b>
                                            <span>In {{ $product->delivery_time }}</span>
                                        </li>
                                    @endif
                                    <li id="stepDelivered" style="display:none">
                                        <i class="fa-solid fa-house-circle-check"></i>
                                        <b>Delivered</b>
                                        <span id="stepDeliveredText"></span>
                                    </li>
                                </ul>
                                <ul class="del-points">
                                    <li>
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                        Multiple Payment Options Available
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                        Easy No Return &amp; exchange
                                    </li>
                                </ul>
                            </div>

                            <div class="product-actions">
                                <div class="act-top">
                                    <div class="qty-box">
                                        <button type="button" class="qty-minus" aria-label="Decrease quantity">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="text" class="qty-input" value="1" readonly aria-label="Quantity" />
                                        <button type="button" class="qty-plus" aria-label="Increase quantity">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="wish-link">
                                        <i class="fa-regular fa-heart"></i> Add to Wishlist
                                    </button>
                                </div>
                                <div class="act-btns">
                                    <button type="button" data-model=".cart-pop" class="btn btn-outline-primary">
                                        Add to Bag
                                    </button>
                                    <a href="cart.html" type="button" class="btn btn-primary">
                                        Buy Now
                                    </a>
                                </div>
                            </div>

                            <ul class="product-benefits">
                                <li>
                                    <i class="fa-solid fa-gem"></i>
                                    <div>
                                        <b>Authentic Craftsmanship</b>
                                        <p>Carefully selected sarees with premium detailing.</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <div>
                                        <b>Secure Payments</b>
                                        <p>Safe and trusted checkout.</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                    <div>
                                        <b>Easy Returns</b>
                                        <p>Simple return and exchange support.</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa-solid fa-truck-fast"></i>
                                    <div>
                                        <b>Pan-India Delivery</b>
                                        <p>Reliable delivery across India.</p>
                                    </div>
                                </li>
                            </ul>

                            <div class="product-help">
                                <div class="help-text">
                                    <b>Need help choosing?</b>
                                    <p>
                                        Talk to our styling team about colour, drape and occasion.
                                    </p>
                                </div>
                                <div class="help-links">
                                    <a href="javascript:void(0)" class="help-link"><i class="fa-brands fa-whatsapp"></i>
                                        WhatsApp</a>
                                    <a href="javascript:void(0)" class="help-link"><i class="fa-solid fa-phone"></i> Call
                                        Us</a>
                                </div>
                            </div>

                            <div class="product-details">
                                @php
                                    $filled = fn($html) => trim(str_replace('&nbsp;', ' ', strip_tags((string) $html))) !== '';

                                    // product me khali ho to Settings ki default policy
                                    $shipping = $filled($product->shipping_delivery) ? $product->shipping_delivery : ($general->default_shipping_policy ?? null);
                                    $returns = $filled($product->returns_exchange) ? $product->returns_exchange : ($general->default_exchange_policy ?? null);

                                    $occasionNames = $product->occasions->pluck('title')->implode(', ');
                                @endphp

                                <div class="accordion-wrapper">

                                    {{-- Product Details: attributes se auto --}}
                                    @if ($specs->isNotEmpty() || $occasionNames)
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <h5>Product Details</h5>
                                                <span class="accordion-icon">+</span>
                                            </div>
                                            <div class="accordion-content">
                                                <ul class="spec-list">
                                                    @foreach ($specs as $spec)
                                                        <li><span>{{ $spec['name'] }}</span><b>{{ $spec['values'] }}</b></li>
                                                    @endforeach
                                                    @if ($occasionNames)
                                                        <li><span>Occasion</span><b>{{ $occasionNames }}</b></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($filled($product->fabric_material))
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <h5>Fabric &amp; Material</h5>
                                                <span class="accordion-icon">+</span>
                                            </div>
                                            <div class="accordion-content">
                                                <div class="rich-text">{!! $product->fabric_material !!}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($filled($product->care_instructions))
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <h5>Care Instructions</h5>
                                                <span class="accordion-icon">+</span>
                                            </div>
                                            <div class="accordion-content">
                                                <div class="rich-text">{!! $product->care_instructions !!}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($filled($shipping) || $product->delivery_time)
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <h5>Shipping &amp; Delivery</h5>
                                                <span class="accordion-icon">+</span>
                                            </div>
                                            <div class="accordion-content">
                                                @if ($product->delivery_time)
                                                    <p><b>Dispatch:</b> {{ $product->delivery_time }}</p>
                                                @endif
                                                @if ($filled($shipping))
                                                    <div class="rich-text">{!! $shipping !!}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if ($filled($returns))
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <h5>Returns &amp; Exchange</h5>
                                                <span class="accordion-icon">+</span>
                                            </div>
                                            <div class="accordion-content">
                                                <div class="rich-text">{!! $returns !!}</div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Offers: product ka apna text, nahi to coupons se auto steps --}}
                                    @if ($filled($product->offers_how_to_avail) || $coupons->isNotEmpty())
                                        <div class="accordion-item" id="offers-accordion">
                                            <div class="accordion-header">
                                                <h5>Offers &amp; How to Avail</h5>
                                                <span class="accordion-icon">+</span>
                                            </div>
                                            <div class="accordion-content">
                                                @if ($filled($product->offers_how_to_avail))
                                                    <div class="rich-text">{!! $product->offers_how_to_avail !!}</div>
                                                @else
                                                    <ul class="info-points">
                                                        <li>Add the product to your bag and proceed to checkout.</li>
                                                        @foreach ($coupons as $coupon)
                                                            <li>Enter the coupon code <b>{{ $coupon->code }}</b> in the coupon box.
                                                                {{ $coupon->offer_text }}
                                                            </li>
                                                        @endforeach
                                                        <li>Offers cannot be combined and may change without notice.</li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @php
                $reviewTotal = (int) $product->reviews_count;
                $tabs = collect([
                    ['label' => 'All', 'count' => $reviewTotal, 'items' => $reviews, 'gid' => 'rv-all'],
                    ['label' => 'With Photos', 'count' => $photoReviews->count(), 'items' => $photoReviews, 'gid' => 'rv-photo'],
                    ['label' => '5 Star', 'count' => (int) ($ratingCounts[5] ?? 0), 'items' => $fiveStarReviews, 'gid' => 'rv-five'],
                ])->filter(fn($t) => $t['items']->isNotEmpty())->values();
            @endphp

            <section class="product-reviews" id="reviews">
                <div class="container">
                    <div class="sec-head">
                        <span class="eyebrow">Customer Reviews</span>
                        <div class="heading">
                            <h3>What Our Customers Say</h3>
                        </div>
                    </div>

                    <div class="review-summary">
                        @if ($reviewTotal > 0)
                            <div class="rs-score">
                                <b>{{ number_format($product->avg_rating, 1) }}</b><span>/ 5</span>
                                <div class="rs-stars">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <i class="{{ $s <= round($product->avg_rating) ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                    @endfor
                                </div>
                                <p>Based on {{ $reviewTotal }} {{ Str::plural('review', $reviewTotal) }}</p>
                            </div>
                            <ul class="rs-bars">
                                @for ($star = 5; $star >= 1; $star--)
                                    @php $c = (int) ($ratingCounts[$star] ?? 0); @endphp
                                    <li>
                                        <span>{{ $star }} <i class="fa-solid fa-star"></i></span>
                                        <div class="bar"><i style="width: {{ round(($c / $reviewTotal) * 100) }}%"></i></div>
                                        <em>{{ $c }}</em>
                                    </li>
                                @endfor
                            </ul>
                        @endif
                        <div class="rs-cta">
                            <p>
                                {{ $reviewTotal > 0
        ? 'Bought this product? Share your experience and photos with other customers.'
        : 'Be the first to review this product and help other customers.' }}
                            </p>
                            <button type="button" class="btn btn-primary write-review" data-model=".review-pop">
                                Write a Review
                            </button>
                        </div>
                    </div>

                    @if ($customerPhotos->isNotEmpty())
                        <div class="review-photos">
                            <h5>Customer Photos <span>({{ $customerPhotos->count() }})</span></h5>
                            <div class="rp-grid">
                                @foreach ($customerPhotos->take(6) as $i => $ph)
                                    @php $more = $customerPhotos->count() - 6; @endphp
                                    <a href="{{ asset('storage/' . $ph->image) }}"
                                        class="rp-item glightbox {{ ($i === 5 && $more > 0) ? 'more' : '' }}"
                                        data-gallery="customer-photos">
                                        <img src="{{ asset('storage/' . $ph->image) }}" alt="Customer photo {{ $i + 1 }}"
                                            loading="lazy" />
                                        @if ($i === 5 && $more > 0)
                                            <span>+{{ $more }}</span>
                                        @endif
                                    </a>
                                @endforeach
                                {{-- 6 se zyada photos: baaki lightbox me hidden links --}}
                                @foreach ($customerPhotos->slice(6) as $ph)
                                    <a href="{{ asset('storage/' . $ph->image) }}" class="glightbox" data-gallery="customer-photos"
                                        hidden></a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($tabs->isNotEmpty())
                        <div class="review-sort">
                            <select aria-label="Sort reviews"
                                onchange="window.location = '?review_sort=' + this.value + '#reviews'">
                                <option value="recent" {{ $reviewSort === 'recent' ? 'selected' : '' }}>Most Recent</option>
                                <option value="highest" {{ $reviewSort === 'highest' ? 'selected' : '' }}>Highest Rating
                                </option>
                                <option value="lowest" {{ $reviewSort === 'lowest' ? 'selected' : '' }}>Lowest Rating</option>
                            </select>
                        </div>

                        <ul class="tab-nav">
                            @foreach ($tabs as $i => $t)
                                <li data-tab="{{ $i + 1 }}" class="{{ $i === 0 ? 'active' : '' }}">
                                    {{ $t['label'] }} ({{ $t['count'] }})
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-nav-content">
                            @foreach ($tabs as $i => $t)
                                <div class="tabs {{ $i === 0 ? 'active' : '' }}" data-tab="{{ $i + 1 }}">
                                    <div class="swiper-wrap">
                                        <div class="swiper reviewSlider">
                                            <div class="swiper-wrapper">
                                                @include('partials.review-slides', ['items' => $t['items'], 'gid' => $t['gid']])
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
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            @if ($related->isNotEmpty())
                <section class="related-products">
                    <div class="container">
                        <div class="sec-head">
                            <span class="eyebrow">Complete the Look</span>
                            <div class="heading">
                                <h3>You May Also Love</h3>
                            </div>
                            <p>Discover more pieces selected to complement your style.</p>
                        </div>
                        <div class="swiper-wrap">
                            <div class="swiper relatedProductSlider">
                                <div class="swiper-wrapper">
                                    @include('partials.product-slider', ['products' => $related])
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

            @if ($recentlyViewed->isNotEmpty())
                <section class="recently-viewed">
                    <div class="container">
                        <div class="sec-head">
                            <span class="eyebrow">Welcome Back</span>
                            <div class="heading">
                                <h3>Recently Viewed</h3>
                            </div>
                            <p>A few styles you may want to revisit.</p>
                        </div>
                        <div class="swiper-wrap">
                            <div class="swiper recentlyViewedSlider">
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

            <div class="product-sticky-bar" aria-hidden="true">
                <div class="sb-product">
                    <img src="{{ $imgs->first()['thumb'] }}" alt="{{ $product->name }}" loading="lazy" />
                    <div class="sb-text">
                        <b>{{ $product->name }}</b>
                        <span>
                            <strong>₹{{ number_format($product->price) }}</strong>
                            @if ($product->discount_percent > 0)
                                <em>{{ $product->discount_percent }}% OFF</em>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="sb-actions">
                    <div class="qty-box">
                        <button type="button" class="qty-minus" aria-label="Decrease quantity">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="text" class="qty-input" value="1" readonly aria-label="Quantity" />
                        <button type="button" class="qty-plus" aria-label="Increase quantity">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-outline-primary">
                        Add to Bag
                    </button>
                    <button type="button" class="btn btn-primary">Buy Now</button>
                </div>
            </div>
        </div>
    </main>


    <div class="model review-pop">
        <button type="button" class="close" aria-label="Close review">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M5 5l14 14M19 5L5 19" />
            </svg>
        </button>
        <div class="model-body">
            <div class="title">
                <h4>Write a Review</h4>
                <p>{{ $product->name }}</p>
            </div>

            @if ($reviewState === 'can_review')
                <form class="form review-form" id="reviewForm" action="{{ route('product.review.store', $product->id) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="rf-rate">
                        <span>Your Rating</span>
                        <div class="rate-input">
                            <input type="radio" name="rating" id="rate5" value="5" />
                            <label for="rate5" aria-label="5 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" name="rating" id="rate4" value="4" />
                            <label for="rate4" aria-label="4 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" name="rating" id="rate3" value="3" />
                            <label for="rate3" aria-label="3 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" name="rating" id="rate2" value="2" />
                            <label for="rate2" aria-label="2 stars"><i class="fa-solid fa-star"></i></label>
                            <input type="radio" name="rating" id="rate1" value="1" />
                            <label for="rate1" aria-label="1 star"><i class="fa-solid fa-star"></i></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="rvTitle" name="title" placeholder=" " maxlength="150" required />
                        <label for="rvTitle">Review Title</label>
                    </div>
                    <div class="form-group">
                        <textarea id="rvText" name="review" placeholder=" " minlength="10" maxlength="2000" required></textarea>
                        <label for="rvText">Your Review</label>
                    </div>
                    <div class="rf-upload">
                        <label class="upload-box" for="rvPhotos">
                            <i class="fa-regular fa-image"></i>
                            <b>Choose Photos <em>(optional)</em></b>
                            <span>Up to 5 photos · JPG, PNG or WEBP · max 5MB each</span>
                            <input type="file" id="rvPhotos" name="photos[]" accept="image/*" multiple />
                        </label>
                        <div class="upload-preview"></div>
                    </div>
                    <p class="rf-msg" id="rvMsg" style="display:none;margin:0 0 12px"></p>
                    <div class="rf-submit">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                        <p>Reviews appear after approval.</p>
                    </div>
                </form>
            @elseif ($reviewState === 'guest')
                <p>Please log in to write a review. Only customers who purchased this product can review it.</p>
                <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
            @elseif ($reviewState === 'already_reviewed')
                <p>You have already reviewed this product. Thank you for your feedback!</p>
            @else
                <p>Only customers who have purchased and received this product can write a review.</p>
            @endif
        </div>
    </div>

    @if ($sizeChart)
        <div class="model size-pop">
            <button type="button" class="close" aria-label="Close size chart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M5 5l14 14M19 5L5 19" />
                </svg>
            </button>
            <div class="model-body">
                <div class="title">
                    <h4>Size Chart</h4>
                    <p>{{ $product->subcategory->name ?? $product->category->name }}</p>
                </div>
                <div class="rich-text sizechart-content">{!! $sizeChart !!}</div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        $(function () {
            var nav = function (sec) {
                return {
                    nextEl: sec + " .btn-next",
                    prevEl: sec + " .btn-prev",
                    disabledClass: "disabled",
                };
            };

            // ── Gallery (handles exposed for variant image swap) ──
            window.productThumbs = new Swiper(".product-thumb-swiper", {
                spaceBetween: 10,
                slidesPerView: 4.2,
                watchSlidesProgress: true,
                breakpoints: { 541: { slidesPerView: 5 } },
            });

            window.productGallery = new Swiper(".product-gallery-swiper", {
                navigation: {
                    nextEl: ".g-next",
                    prevEl: ".g-prev",
                    disabledClass: "disabled",
                },
                pagination: {
                    el: ".gallery-counter",
                    type: "fraction",
                    formatFractionCurrent: function (n) {
                        return ("0" + n).slice(-2);
                    },
                    formatFractionTotal: function (n) {
                        return ("0" + n).slice(-2);
                    },
                },
                thumbs: { swiper: window.productThumbs },
            });

            // ── Related / Recently viewed sliders ──
            [
                "relatedProductSlider:.related-products",
                "recentlyViewedSlider:.recently-viewed",
            ].forEach(function (s) {
                var p = s.split(":");
                if (!document.querySelector("." + p[0])) return;
                new Swiper("." + p[0], {
                    slidesPerView: 2,
                    spaceBetween: 12,
                    navigation: nav(p[1]),
                    breakpoints: {
                        769: { slidesPerView: 3, spaceBetween: 16 },
                        1025: { slidesPerView: 4, spaceBetween: 24 },
                    },
                });
            });

            // ── Quantity (main + sticky bar stay in sync) ──
            $(document).on("click", ".qty-plus, .qty-minus", function () {
                var $i = $(this).siblings(".qty-input"),
                    v = parseInt($i.val(), 10) || 1;
                v = $(this).hasClass("qty-plus") ? v + 1 : Math.max(1, v - 1);
                $(".qty-input").val(v);
            });

            // ── Sticky bar ──
            var bar = document.querySelector(".product-sticky-bar"),
                target = document.querySelector(".product-actions");
            if (bar && target && "IntersectionObserver" in window) {
                new IntersectionObserver(function (e) {
                    var r = e[0];
                    bar.classList.toggle(
                        "show",
                        !r.isIntersecting && r.boundingClientRect.top < 0,
                    );
                }).observe(target);
            }
        });

        // ── Review sliders (one per tab, own arrows) ──
        $(".reviewSlider").each(function () {
            var $wrap = $(this).closest(".swiper-wrap");
            new Swiper(this, {
                slidesPerView: 1.1,
                spaceBetween: 14,
                navigation: {
                    nextEl: $wrap.find(".btn-next")[0],
                    prevEl: $wrap.find(".btn-prev")[0],
                    disabledClass: "disabled",
                },
                breakpoints: {
                    541: { slidesPerView: 2, spaceBetween: 18 },
                    1025: { slidesPerView: 3, spaceBetween: 24 },
                },
            });
        });

        // ── Pincode check ──
        $('#pinForm').on('submit', function (e) {
            e.preventDefault();

            var $form = $(this),
                $res = $('#pinResult'),
                $btn = $form.find('button'),
                pin = $.trim($form.find('input[name="pincode"]').val());

            function show(ok, html) {
                $res.html('<i class="fa-solid ' + (ok ? 'fa-circle-check' : 'fa-circle-xmark') + '"></i> ' + html)
                    .css('color', ok ? '' : '#b22222').show();
            }

            if (!/^\d{6}$/.test(pin)) {
                $('#stepDelivered').hide();
                return show(false, 'Please enter a valid 6-digit pincode.');
            }

            $btn.prop('disabled', true).text('Checking...');

            $.getJSON($form.attr('action'), { pincode: pin })
                .done(function (r) {
                    if (r.status) {
                        var place = [r.district, r.state].filter(Boolean).join(', ');
                        show(true, 'Delivery available' + (place ? ' to ' + $('<span>').text(place).html() : '') + '.');
                        if (r.eta) {
                            $('#stepDeliveredText').text('In ' + r.eta);
                            $('#stepDelivered').show();
                        } else {
                            $('#stepDelivered').hide();
                        }
                    } else {
                        $('#stepDelivered').hide();
                        show(false, $('<span>').text(r.message).html());
                    }
                })
                .fail(function (xhr) {
                    $('#stepDelivered').hide();
                    show(false, xhr.status === 429
                        ? 'Too many attempts. Please try again in a minute.'
                        : 'Could not check right now. Please try again.');
                })
                .always(function () {
                    $btn.prop('disabled', false).text('Check');
                });
        });

        // ── Review photo preview ──
        $('#rvPhotos').on('change', function () {
            var files = Array.from(this.files), $p = $(this).closest('.rf-upload').find('.upload-preview');
            $p.empty();
            if (files.length > 5) {
                this.value = '';
                return $('#rvMsg').text('You can upload up to 5 photos.').css('color', '#b22222').show();
            }
            files.forEach(function (f) {
                $p.append($('<img>', { src: URL.createObjectURL(f), alt: 'Preview', width: 56, height: 56, css: { objectFit: 'cover', borderRadius: 6, marginRight: 6 } }));
            });
        });

        // ── Review submit ──
        $('#reviewForm').on('submit', function (e) {
            e.preventDefault();

            var $f = $(this), $btn = $f.find('button[type=submit]'), $msg = $('#rvMsg');

            if (!$f.find('input[name="rating"]:checked').length) {
                return $msg.text('Please select a rating.').css('color', '#b22222').show();
            }

            $btn.prop('disabled', true).text('Submitting...');
            $msg.hide();

            $.ajax({
                url: $f.attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json'
            }).done(function (r) {
                $f.find('.rf-rate, .form-group, .rf-upload, .rf-submit').hide();
                $msg.text(r.message).css('color', '').show();
                $('.write-review').prop('disabled', true).text('Review Submitted');
            }).fail(function (xhr) {
                var m = 'Could not submit right now. Please try again.';
                if (xhr.status === 401) m = 'Please log in to write a review.';
                else if (xhr.status === 429) m = 'Too many attempts. Please try again in a minute.';
                else if (xhr.responseJSON) {
                    m = xhr.responseJSON.message || m;
                    if (xhr.responseJSON.errors) m = Object.values(xhr.responseJSON.errors)[0][0];
                }
                $msg.text(m).css('color', '#b22222').show();
                $btn.prop('disabled', false).text('Submit Review');
            });
        });

        // ── Coupon copy ──
        $(document).on('click', '.offer-copy', function () {
            var $b = $(this), html = $b.html();
            navigator.clipboard.writeText($b.data('code')).then(function () {
                $b.text('Copied!');
                setTimeout(function () { $b.html(html); }, 1500);
            });
        });

        // ── "How to Avail" scrolls to + opens the offers accordion ──
        $(document).on('click', '.offers-head a', function (e) {
            e.preventDefault();
            var $item = $('#offers-accordion');
            if (!$item.length) return;
            $('html, body').animate({ scrollTop: $item.offset().top - 120 }, 300);
            if ($item.find('.accordion-content').outerHeight() < 5) {
                $item.find('.accordion-header').trigger('click');
            }
        });

        // ── Lightbox (handle exposed so variant image swap can reload it) ──
        window.productLightbox = GLightbox({ selector: ".glightbox", touchNavigation: true, loop: true });

        $(".gallery-zoom").on("click", function () {
            $(".product-gallery-swiper .swiper-slide-active .glightbox").trigger("click");
        });
    </script>

    @include('partials.product-options-js')
@endpush