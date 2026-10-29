@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/css/glightbox.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/sass/detail/detail.css') }}" />
@endpush

@section('content')
    @php
        $img = fn ($f) => asset('assets/images/home/' . $f);

        $gallery = [
            ['tab1.png', 'Zari Woven Banarasi Silk Saree front view'],
            ['tab2.png', 'Banarasi saree drape view'],
            ['tab3.png', 'Banarasi saree border detail'],
            ['tab4.png', 'Banarasi saree pallu'],
            ['offer2.png', 'Banarasi saree styled look'],
        ];

        $colors = [
            'wine' => ['Wine', '#5e1a33'], 'maroon' => ['Maroon', '#6e1423'], 'red' => ['Red', '#b3203c'],
            'pink' => ['Pink', '#e79aa8'], 'green' => ['Green', '#1f6b4f'], 'teal' => ['Teal', '#0f5c5c'],
            'ivory' => ['Ivory', '#f3ecd9'],
        ];

        $blouseSizes = ['s' => 'S', 'm' => 'M', 'l' => 'L', 'xl' => 'XL', 'xxl' => 'XXL'];

        $ratingBars = [[5, 82, 102], [4, 12, 15], [3, 4, 5], [2, 1, 1], [1, 1, 1]];

        $customerPhotos = ['tab1.png', 'tab2.png', 'tab3.png', 'tab4.png', 'offer2.png'];

        $reviews = [
            ['init' => 'PS', 'name' => 'Priya Sharma', 'rating' => 5, 'title' => 'Beautiful saree and even better in person',
             'text' => "The zari detailing is elegant and the fabric drapes beautifully. I wore it to my cousin's wedding and received so many compliments. The packaging was also very neat.",
             'photos' => ['tab1.png', 'tab3.png'], 'date' => 'October 2026', 'helpful' => 12],
            ['init' => 'NK', 'name' => 'Neha Kapoor', 'rating' => 5, 'title' => 'Rich colour, exactly like the photos',
             'text' => 'I was worried the wine shade would look different, but it matches the pictures perfectly. The pallu is heavy and graceful, and the blouse piece is generous enough for a proper fitting.',
             'photos' => ['tab2.png'], 'date' => 'October 2026', 'helpful' => 8],
            ['init' => 'AV', 'name' => 'Ananya Verma', 'rating' => 4, 'title' => 'Lovely weave, delivery was quick',
             'text' => 'The weave is fine and the border looks very rich. It arrived within four days to Lucknow. I added the fall and pico option and it came perfectly finished.',
             'photos' => [], 'date' => 'September 2026', 'helpful' => 5],
            ['init' => 'RM', 'name' => 'Ritu Malhotra', 'rating' => 5, 'title' => 'Perfect for festive evenings',
             'text' => 'Bought this for Diwali and it was the highlight of my look. Soft to touch, not too heavy to carry, and the zari has not lost its shine even after a long evening.',
             'photos' => ['tab4.png', 'offer2.png', 'tab2.png'], 'date' => 'September 2026', 'helpful' => 9],
            ['init' => 'SA', 'name' => 'Simran Arora', 'rating' => 5, 'title' => 'Worth every rupee',
             'text' => 'I have shopped from Archana for years and this saree keeps up the same quality. The team also helped me with styling tips over a call, which was a lovely touch.',
             'photos' => [], 'date' => 'August 2026', 'helpful' => 4],
        ];
        $reviewTabs = [
            1 => ['label' => 'All (124)',        'list' => collect($reviews)],
            2 => ['label' => 'With Photos (38)', 'list' => collect($reviews)->filter(fn ($r) => count($r['photos']))],
            3 => ['label' => '5 Star (102)',     'list' => collect($reviews)->where('rating', 5)],
        ];

        $products = [
            'org'  => ['img' => 'tab2.png', 'name' => 'Organza Embroidered Party Saree', 'cat' => 'Organza Saree', 'rate' => '4.7', 'price' => 6299, 'old' => 8999, 'off' => 30, 'badge' => 'Bestseller'],
            'kanj' => ['img' => 'tab3.png', 'name' => 'Kanjivaram Pure Silk Saree', 'cat' => 'Silk Saree', 'rate' => '4.9', 'price' => 12999, 'old' => 17499, 'off' => 26, 'badge' => 'Bestseller'],
            'emb'  => ['img' => 'tab4.png', 'name' => 'Embroidered Designer Saree', 'cat' => 'Designer Saree', 'rate' => '4.8', 'price' => 9999, 'old' => 13999, 'off' => 29, 'badge' => 'New Arrival'],
            'geo'  => ['img' => 'tab1.png', 'name' => 'Georgette Printed Saree', 'cat' => 'Georgette Saree', 'rate' => '4.6', 'price' => 4799, 'old' => 6499, 'off' => 26, 'badge' => null],
            'red'  => ['img' => 'tab2.png', 'name' => 'Red Bridal Silk Saree', 'cat' => 'Bridal Saree', 'rate' => '4.8', 'price' => 24999, 'old' => 34999, 'off' => 29, 'badge' => 'Bestseller'],
            'kan2' => ['img' => 'tab1.png', 'name' => 'Kanjivaram Pure Silk Saree', 'cat' => 'Silk Saree', 'rate' => '4.9', 'price' => 12999, 'old' => 17499, 'off' => 26, 'badge' => null],
            'org2' => ['img' => 'tab2.png', 'name' => 'Organza Embroidered Party Saree', 'cat' => 'Organza Saree', 'rate' => '4.7', 'price' => 6299, 'old' => 8999, 'off' => 30, 'badge' => null],
            'red2' => ['img' => 'tab3.png', 'name' => 'Red Bridal Silk Saree', 'cat' => 'Bridal Saree', 'rate' => '4.8', 'price' => 24999, 'old' => 34999, 'off' => 29, 'badge' => null],
            'leh'  => ['img' => 'tab4.png', 'name' => 'Embroidered Designer Lehenga Set', 'cat' => 'Designer Lehenga', 'rate' => '4.8', 'price' => 18999, 'old' => 26999, 'off' => 30, 'badge' => null],
            'geo2' => ['img' => 'tab1.png', 'name' => 'Georgette Printed Saree', 'cat' => 'Georgette Saree', 'rate' => '4.6', 'price' => 4799, 'old' => 6499, 'off' => 26, 'badge' => null],
        ];
        $related = ['org', 'kanj', 'emb', 'geo', 'red'];
        $recent  = ['kan2', 'org2', 'red2', 'leh', 'geo2'];

        $accordion = [
            ['title' => 'Product Details', 'type' => 'spec', 'data' => [
                'Fabric' => 'Pure Banarasi Silk', 'Saree Length' => '5.5 Metres', 'Blouse Piece' => 'Included',
                'Weave' => 'Traditional Banarasi Weave', 'Work' => 'Zari / Woven Detail',
                'Occasion' => 'Wedding, Festive, Reception', 'Country of Origin' => 'India']],
            ['title' => 'Fabric & Material', 'type' => 'text', 'data' =>
                'Woven in pure Banarasi silk with a soft lustre and a rich, structured fall. The zari is interlaced into the fabric, giving the border and pallu a refined, long-lasting shine.'],
            ['title' => 'Saree Specifications', 'type' => 'spec', 'data' => [
                'Saree Length' => '5.5 Metres', 'Blouse Length' => '0.8 Metres', 'Border' => 'Woven Zari Border',
                'Pallu' => 'Detailed Zari Pallu', 'Fall & Pico' => 'Optional Add-on']],
            ['title' => 'Care Instructions', 'type' => 'points', 'data' => [
                'Dry clean only to protect the zari and silk.',
                'Store in a soft muslin cloth, away from direct sunlight.',
                'Do not wring or use harsh detergents.',
                'Iron on low heat from the reverse side.']],
            ['title' => 'Shipping & Delivery', 'type' => 'icons', 'data' => [
                ['fa-truck', 'Free shipping above ₹2,999.'],
                ['fa-box', 'Dispatch: 2–4 working days.'],
                ['fa-clock', 'Estimated delivery: 3–7 working days depending on location.'],
                ['fa-hand-holding-dollar', 'Cash on Delivery available on selected pincodes.']]],
            ['title' => 'Returns & Exchange', 'type' => 'returns'],
            ['title' => 'Offers & How to Avail', 'type' => 'points', 'data' => [
                'Add the saree to your bag and proceed to checkout.',
                'Enter the coupon code ARCHANA10 in the coupon box.',
                'Choose a prepaid payment method to see the extra 10% off applied.',
                'Bank offers appear on the payment step for eligible cards.',
                'Offers cannot be combined and may change without notice.']],
        ];
    @endphp

    <div class="product-detail-page">
        {{-- Breadcrumb --}}
        <section class="product-breadcrumb">
            <div class="container">
                <ul class="crumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li><a href="{{ route('categories') }}">Sarees</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li><a href="javascript:void(0)">Banarasi Sarees</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li class="current">Zari Woven Banarasi Silk Saree</li>
                </ul>
            </div>
        </section>

        {{-- Main --}}
        <section class="product-main">
            <div class="container">
                <div class="product-layout">
                    {{-- Gallery --}}
                    <div class="product-gallery">
                        <div class="gallery-main">
                            <span class="gallery-tag">Bestseller</span>
                            <div class="swiper product-gallery-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($gallery as [$file, $alt])
                                        <div class="swiper-slide">
                                            <div class="gallery-img">
                                                <a href="{{ $img($file) }}" class="glightbox" data-gallery="product">
                                                    <img src="{{ $img($file) }}" alt="{{ $alt }}" {!! $loop->first ? 'fetchpriority="high"' : 'loading="lazy"' !!} />
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" class="gallery-zoom" aria-label="Zoom image"><i class="fa-solid fa-expand"></i></button>
                            <button type="button" class="g-prev" aria-label="Previous image"><i class="fa-solid fa-chevron-left"></i></button>
                            <button type="button" class="g-next" aria-label="Next image"><i class="fa-solid fa-chevron-right"></i></button>
                            <div class="gallery-counter"></div>
                        </div>
                        <div class="swiper product-thumb-swiper">
                            <div class="swiper-wrapper">
                                @foreach ($gallery as [$file])
                                    <div class="swiper-slide"><img src="{{ $img($file) }}" alt="Thumbnail {{ $loop->iteration }}" loading="lazy" /></div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="product-info">
                        <div class="info-top">
                            <span class="info-cat">Banarasi Saree</span>
                            <h1>Zari Woven Banarasi Silk Saree</h1>
                            <div class="info-rate">
                                <span class="rate-pill"><i class="fa-solid fa-star"></i> 4.8</span>
                                <a href="#reviews" class="rate-count">124 Reviews</a>
                                <span class="info-sku">SKU: ASE-BNR-0142</span>
                            </div>
                        </div>

                        <div class="price-block">
                            <span class="price-now">₹8,499</span>
                            <del class="price-old">₹11,999</del>
                            <span class="price-off">29% OFF</span>
                            <p class="price-tax">Inclusive of all taxes · You save ₹3,500</p>
                        </div>

                        <p class="info-stock">
                            <i class="fa-solid fa-circle"></i>
                            <b>In Stock</b>
                            <em>Only 3 pieces left in this colour</em>
                        </p>

                        <div class="product-offers">
                            <div class="offers-head">
                                <h5>Offers &amp; Coupons</h5>
                                <a href="javascript:void(0)">How to Avail</a>
                            </div>
                            <div class="offer-row">
                                <span class="offer-ico"><i class="fa-solid fa-tag"></i></span>
                                <div class="offer-text">
                                    <b>Exclusive Offer</b>
                                    <p>Get an additional 10% off on prepaid orders.</p>
                                </div>
                                <button type="button" class="offer-copy" data-code="ARCHANA10">ARCHANA10 <i class="fa-regular fa-copy"></i></button>
                            </div>
                            <div class="offer-row">
                                <span class="offer-ico"><i class="fa-solid fa-building-columns"></i></span>
                                <div class="offer-text">
                                    <b>Bank Offer</b>
                                    <p>Flat ₹500 off on selected bank cards on orders above ₹7,999.</p>
                                </div>
                            </div>
                            <p class="offer-tnc">Offers are applied at checkout. Only one coupon can be used per order. Terms &amp; conditions apply.</p>
                        </div>

                        <p class="info-desc">
                            A timeless Banarasi silk saree crafted for celebrations, featuring intricate zari work,
                            a graceful drape and a richly detailed border. Designed for weddings, festive occasions
                            and elegant evening gatherings.
                        </p>

                        <div class="product-options">
                            <div class="opt-group">
                                <div class="opt-head"><span>Color:</span><b class="opt-value" id="colorName">Wine</b></div>
                                <div class="opt-swatches">
                                    @foreach ($colors as $val => [$name, $hex])
                                        <label class="opt-swatch" title="{{ $name }}">
                                            <input type="radio" name="color" value="{{ $val }}" data-name="{{ $name }}" {{ $loop->first ? 'checked' : '' }} /><span style="--c: {{ $hex }}"></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="opt-group">
                                <div class="opt-head"><span>Size:</span><b class="opt-value">Free Size</b></div>
                                <div class="opt-chips">
                                    <label class="opt-chip"><input type="radio" name="size" value="free" checked /><span>Free Size</span></label>
                                </div>
                                <p class="opt-note">Standard saree length of 5.5 metres with an unstitched blouse piece.</p>
                            </div>

                            <div class="opt-group blouse-group">
                                <div class="opt-head">
                                    <span>Blouse:</span><b class="opt-value">Choose an option</b>
                                    <button type="button" class="size-guide" data-model=".size-pop"><i class="fa-solid fa-ruler"></i> Size Guide</button>
                                </div>
                                <div class="opt-cards">
                                    <label class="opt-card">
                                        <input type="radio" name="blouse" value="unstitched" checked />
                                        <span><b>Unstitched Piece</b><em>Included · Free</em></span>
                                    </label>
                                    <label class="opt-card">
                                        <input type="radio" name="blouse" value="stitched" />
                                        <span><b>Stitched to Size</b><em>+ ₹499 · Ready in 5–7 days</em></span>
                                    </label>
                                </div>
                                <div class="blouse-sizes">
                                    <p class="opt-sub">Select Blouse Size</p>
                                    <div class="opt-chips">
                                        @foreach ($blouseSizes as $val => $label)
                                            <label class="opt-chip"><input type="radio" name="blouse-size" value="{{ $val }}" {{ $val === 'm' ? 'checked' : '' }} /><span>{{ $label }}</span></label>
                                        @endforeach
                                    </div>
                                    <p class="opt-note">Stitched blouses are made to standard size and cannot be returned once stitched.</p>
                                </div>
                            </div>

                            <div class="opt-group">
                                <div class="opt-head"><span>Add-ons:</span><b class="opt-value">Optional</b></div>
                                <div class="opt-addons">
                                    <label class="opt-check">
                                        <input type="checkbox" name="addon" value="fall-pico" />
                                        <span class="oc-text"><b>Fall &amp; Pico</b><em>Stitched and ready to drape</em></span>
                                        <strong>+ ₹250</strong>
                                    </label>
                                    <label class="opt-check">
                                        <input type="checkbox" name="addon" value="petticoat" />
                                        <span class="oc-text"><b>Matching Petticoat</b><em>Cotton, drawstring waist</em></span>
                                        <strong>+ ₹399</strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="product-delivery">
                            <div class="del-head"><i class="fa-solid fa-location-dot"></i><b>Check Delivery</b></div>
                            <form class="pin-form" action="#" method="post">
                                @csrf
                                <input type="text" name="pincode" inputmode="numeric" maxlength="6" placeholder="Enter your pincode" value="110001" aria-label="Pincode" />
                                <button type="submit">Check</button>
                            </form>
                            <p class="pin-result"><i class="fa-solid fa-circle-check"></i> Delivery available. Estimated delivery in 3–5 business days.</p>
                            <ul class="del-steps">
                                <li><i class="fa-solid fa-bag-shopping"></i><b>Order Placed</b><span>Today</span></li>
                                <li><i class="fa-solid fa-box"></i><b>Dispatched</b><span>In 2–4 days</span></li>
                                <li><i class="fa-solid fa-house-circle-check"></i><b>Delivered</b><span>In 3–7 days</span></li>
                            </ul>
                            <ul class="del-points">
                                <li><i class="fa-solid fa-hand-holding-dollar"></i> Cash on Delivery available at your pincode</li>
                                <li><i class="fa-solid fa-arrow-right-arrow-left"></i> Easy 7-day return &amp; exchange</li>
                            </ul>
                        </div>

                        <div class="product-actions">
                            <div class="act-top">
                                <div class="qty-box">
                                    <button type="button" class="qty-minus" aria-label="Decrease quantity"><i class="fa-solid fa-minus"></i></button>
                                    <input type="text" class="qty-input" value="1" readonly aria-label="Quantity" />
                                    <button type="button" class="qty-plus" aria-label="Increase quantity"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <button type="button" class="wish-link"><i class="fa-regular fa-heart"></i> Add to Wishlist</button>
                            </div>
                            <div class="act-btns">
                                <button type="button" data-model=".cart-pop" class="btn btn-outline-primary">Add to Bag</button>
                                <a href="{{ route('cart') }}" class="btn btn-primary">Buy Now</a>
                            </div>
                        </div>

                        <ul class="product-benefits">
                            <li><i class="fa-solid fa-gem"></i><div><b>Authentic Craftsmanship</b><p>Carefully selected sarees with premium detailing.</p></div></li>
                            <li><i class="fa-solid fa-shield-halved"></i><div><b>Secure Payments</b><p>Safe and trusted checkout.</p></div></li>
                            <li><i class="fa-solid fa-arrow-right-arrow-left"></i><div><b>Easy Returns</b><p>Simple return and exchange support.</p></div></li>
                            <li><i class="fa-solid fa-truck-fast"></i><div><b>Pan-India Delivery</b><p>Reliable delivery across India.</p></div></li>
                        </ul>

                        <div class="product-help">
                            <div class="help-text">
                                <b>Need help choosing?</b>
                                <p>Talk to our styling team about colour, drape and occasion.</p>
                            </div>
                            <div class="help-links">
                                <a href="javascript:void(0)" class="help-link"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                                <a href="javascript:void(0)" class="help-link"><i class="fa-solid fa-phone"></i> Call Us</a>
                            </div>
                        </div>

                        <div class="product-details">
                            <div class="accordion-wrapper">
                                @foreach ($accordion as $acc)
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>{{ $acc['title'] }}</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            @switch($acc['type'])
                                                @case('spec')
                                                    <ul class="spec-list">
                                                        @foreach ($acc['data'] as $k => $v)
                                                            <li><span>{{ $k }}</span><b>{{ $v }}</b></li>
                                                        @endforeach
                                                    </ul>
                                                    @break
                                                @case('text')
                                                    <p>{{ $acc['data'] }}</p>
                                                    @break
                                                @case('points')
                                                    <ul class="info-points">
                                                        @foreach ($acc['data'] as $line)
                                                            <li>{{ $line }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @break
                                                @case('icons')
                                                    <ul class="info-points with-icon">
                                                        @foreach ($acc['data'] as [$icon, $line])
                                                            <li><i class="fa-solid {{ $icon }}"></i> {{ $line }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @break
                                                @case('returns')
                                                    <p>
                                                        <b>Easy Returns &amp; Exchange.</b> Eligible products can be returned or exchanged
                                                        within 7 days of delivery, unused and with tags intact. Stitched blouses and
                                                        add-ons are not eligible.
                                                    </p>
                                                    <a href="javascript:void(0)" class="policy-link">View Return Policy <i class="fa-solid fa-arrow-right-long"></i></a>
                                                    @break
                                            @endswitch
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Reviews --}}
        <section class="product-reviews" id="reviews">
            <div class="container">
                <div class="sec-head">
                    <span class="eyebrow">Customer Reviews</span>
                    <div class="heading"><h3>What Our Customers Say</h3></div>
                </div>

                <div class="review-summary">
                    <div class="rs-score">
                        <b>4.8</b><span>/ 5</span>
                        <div class="rs-stars">@for ($s = 1; $s <= 5; $s++)<i class="fa-solid fa-star"></i>@endfor</div>
                        <p>Based on 124 reviews</p>
                    </div>
                    <ul class="rs-bars">
                        @foreach ($ratingBars as [$star, $pct, $count])
                            <li>
                                <span>{{ $star }} <i class="fa-solid fa-star"></i></span>
                                <div class="bar"><i style="width: {{ $pct }}%"></i></div>
                                <em>{{ $count }}</em>
                            </li>
                        @endforeach
                    </ul>
                    <div class="rs-cta">
                        <p>Bought this saree? Share your experience and photos with other customers.</p>
                        <button type="button" class="btn btn-primary write-review" data-model=".review-pop">Write a Review</button>
                    </div>
                </div>

                <div class="review-photos">
                    <h5>Customer Photos <span>(38)</span></h5>
                    <div class="rp-grid">
                        @foreach ($customerPhotos as $file)
                            <a href="{{ $img($file) }}" class="rp-item glightbox" data-gallery="customer-photos">
                                <img src="{{ $img($file) }}" alt="Customer photo {{ $loop->iteration }}" loading="lazy" />
                            </a>
                        @endforeach
                        <a href="{{ $img('tab1.png') }}" class="rp-item more glightbox" data-gallery="customer-photos">
                            <img src="{{ $img('tab1.png') }}" alt="More customer photos" loading="lazy" /><span>+33</span>
                        </a>
                    </div>
                </div>

                <div class="review-sort">
                    <select aria-label="Sort reviews">
                        <option>Most Recent</option>
                        <option>Most Helpful</option>
                        <option>Highest Rating</option>
                        <option>Lowest Rating</option>
                    </select>
                </div>

                <ul class="tab-nav">
                    @foreach ($reviewTabs as $n => $tab)
                        <li data-tab="{{ $n }}" class="{{ $loop->first ? 'active' : '' }}">{{ $tab['label'] }}</li>
                    @endforeach
                </ul>

                <div class="tab-nav-content">
                    @foreach ($reviewTabs as $n => $tab)
                        <div class="tabs {{ $loop->first ? 'active' : '' }}" data-tab="{{ $n }}">
                            <div class="swiper-wrap">
                                <div class="swiper reviewSlider">
                                    <div class="swiper-wrapper">
                                        @foreach ($tab['list'] as $r)
                                            <div class="swiper-slide">
                                                <div class="rv-card">
                                                    <div class="rv-top">
                                                        <span class="rv-avatar">{{ $r['init'] }}</span>
                                                        <div>
                                                            <h5>{{ $r['name'] }}</h5>
                                                            <span class="rv-verified"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                                        </div>
                                                    </div>
                                                    <div class="rv-stars">@for ($s = 1; $s <= 5; $s++)<i class="fa-{{ $s <= $r['rating'] ? 'solid' : 'regular' }} fa-star"></i>@endfor</div>
                                                    <h6>{{ $r['title'] }}</h6>
                                                    <p>{{ $r['text'] }}</p>
                                                    @if (count($r['photos']))
                                                        <div class="rv-photos">
                                                            @foreach ($r['photos'] as $p)
                                                                <a href="{{ $img($p) }}" class="glightbox" data-gallery="rv-{{ $n }}-{{ $r['init'] }}">
                                                                    <img src="{{ $img($p) }}" alt="Review photo" loading="lazy" />
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    <div class="rv-foot">
                                                        <span class="rv-date">{{ $r['date'] }}</span>
                                                        <button type="button" class="rv-helpful"><i class="fa-regular fa-thumbs-up"></i> Helpful ({{ $r['helpful'] }})</button>
                                                    </div>
                                                </div>
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
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Related --}}
        <section class="related-products">
            <div class="container">
                <div class="sec-head">
                    <span class="eyebrow">Complete the Look</span>
                    <div class="heading"><h3>You May Also Love</h3></div>
                    <p>Discover more pieces selected to complement your style.</p>
                </div>
                <div class="swiper-wrap">
                    <div class="swiper relatedProductSlider">
                        <div class="swiper-wrapper">
                            @foreach ($related as $key)
                                <div class="swiper-slide">
                                    @include('partials.product-card', ['p' => $products[$key], 'simple' => true])
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

        {{-- Recently viewed --}}
        <section class="recently-viewed">
            <div class="container">
                <div class="sec-head">
                    <span class="eyebrow">Welcome Back</span>
                    <div class="heading"><h3>Recently Viewed</h3></div>
                    <p>A few styles you may want to revisit.</p>
                </div>
                <div class="swiper-wrap">
                    <div class="swiper recentlyViewedSlider">
                        <div class="swiper-wrapper">
                            @foreach ($recent as $key)
                                <div class="swiper-slide">
                                    @include('partials.product-card', ['p' => $products[$key], 'simple' => true, 'showBadge' => false])
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

        {{-- Sticky bar --}}
        <div class="product-sticky-bar" aria-hidden="true">
            <div class="sb-product">
                <img src="{{ $img('tab1.png') }}" alt="Zari Woven Banarasi Silk Saree" loading="lazy" />
                <div class="sb-text">
                    <b>Zari Woven Banarasi Silk Saree</b>
                    <span><strong>₹8,499</strong> <em>29% OFF</em></span>
                </div>
            </div>
            <div class="sb-actions">
                <div class="qty-box">
                    <button type="button" class="qty-minus" aria-label="Decrease quantity"><i class="fa-solid fa-minus"></i></button>
                    <input type="text" class="qty-input" value="1" readonly aria-label="Quantity" />
                    <button type="button" class="qty-plus" aria-label="Increase quantity"><i class="fa-solid fa-plus"></i></button>
                </div>
                <button type="button" class="btn btn-outline-primary">Add to Bag</button>
                <button type="button" class="btn btn-primary">Buy Now</button>
            </div>
        </div>
    </div>

    {{-- ===== Review + size guide popups ===== --}}
    <div class="model review-pop">
        <button type="button" class="close" aria-label="Close review">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19" /></svg>
        </button>
        <div class="model-body">
            <div class="title">
                <h4>Write a Review</h4>
                <p>Zari Woven Banarasi Silk Saree</p>
            </div>
            <form class="form review-form" action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="rf-rate">
                    <span>Your Rating</span>
                    <div class="rate-input">
                        @foreach ([5, 4, 3, 2, 1] as $n)
                            <input type="radio" name="rating" id="rate{{ $n }}" value="{{ $n }}" />
                            <label for="rate{{ $n }}" aria-label="{{ $n }} star{{ $n > 1 ? 's' : '' }}"><i class="fa-solid fa-star"></i></label>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="rvTitle" name="title" placeholder=" " required />
                    <label for="rvTitle">Review Title</label>
                </div>
                <div class="form-group">
                    <textarea id="rvText" name="review" placeholder=" " required></textarea>
                    <label for="rvText">Your Review</label>
                </div>
                <div class="rf-row">
                    <div class="form-group">
                        <input type="text" id="rvName" name="name" placeholder=" " required />
                        <label for="rvName">Your Name</label>
                    </div>
                    <div class="form-group">
                        <input type="email" id="rvEmail" name="email" placeholder=" " required />
                        <label for="rvEmail">Email Address</label>
                    </div>
                </div>
                <div class="rf-upload">
                    <label class="upload-box" for="rvPhotos">
                        <i class="fa-regular fa-image"></i>
                        <b>Choose Photos <em>(optional)</em></b>
                        <span>Up to 5 photos · JPG or PNG · max 5MB each</span>
                        <input type="file" id="rvPhotos" name="photos[]" accept="image/*" multiple />
                    </label>
                    <div class="upload-preview"></div>
                </div>
                <div class="rf-submit">
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                    <p>Your email will not be published. Reviews appear after approval.</p>
                </div>
            </form>
        </div>
    </div>

    <div class="model size-pop">
        <button type="button" class="close" aria-label="Close size guide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19" /></svg>
        </button>
        <div class="model-body">
            <div class="title">
                <h4>Blouse Size Guide</h4>
                <p>Measurements in inches. Choose the size closest to your body measurements.</p>
            </div>
            <div class="size-table-wrap">
                <table class="size-table">
                    <thead><tr><th>Size</th><th>Bust</th><th>Waist</th><th>Shoulder</th></tr></thead>
                    <tbody>
                        @foreach ([['S', 34, 28, 14], ['M', 36, 30, 14.5], ['L', 38, 32, 15], ['XL', 40, 34, 15.5], ['XXL', 42, 36, 16]] as $row)
                            <tr>@foreach ($row as $cell)<td>{{ $cell }}</td>@endforeach</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="size-tips">
                <li><b>Bust:</b> measure around the fullest part of your chest.</li>
                <li><b>Waist:</b> measure around the narrowest part of your waist.</li>
                <li><b>Shoulder:</b> measure from one shoulder point to the other across the back.</li>
                <li>Between two sizes? Choose the larger size.</li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/js/glightbox.min.js"></script>
    <script>
        $(function () {
            var nav = function (sec) {
                return { nextEl: sec + " .btn-next", prevEl: sec + " .btn-prev", disabledClass: "disabled" };
            };

            var thumbs = new Swiper(".product-thumb-swiper", {
                spaceBetween: 10,
                slidesPerView: 4.2,
                watchSlidesProgress: true,
                breakpoints: { 541: { slidesPerView: 5 } },
            });

            new Swiper(".product-gallery-swiper", {
                navigation: { nextEl: ".g-next", prevEl: ".g-prev", disabledClass: "disabled" },
                pagination: {
                    el: ".gallery-counter",
                    type: "fraction",
                    formatFractionCurrent: function (n) { return ("0" + n).slice(-2); },
                    formatFractionTotal: function (n) { return ("0" + n).slice(-2); },
                },
                thumbs: { swiper: thumbs },
            });

            /* One review slider per tab, each with its own arrows */
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

            ["relatedProductSlider:.related-products", "recentlyViewedSlider:.recently-viewed"].forEach(function (s) {
                var p = s.split(":");
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

            $(".opt-swatch input").on("change", function () {
                $("#colorName").text($(this).data("name"));
            });

            $(document).on("click", ".qty-plus, .qty-minus", function () {
                var $i = $(this).siblings(".qty-input");
                if (!$i.length) return; // ignore the cart popup qty buttons
                var v = parseInt($i.val(), 10) || 1;
                v = $(this).hasClass("qty-plus") ? v + 1 : Math.max(1, v - 1);
                $(".qty-input").val(v);
            });

            var bar = document.querySelector(".product-sticky-bar"),
                target = document.querySelector(".product-actions");
            if (bar && target && "IntersectionObserver" in window) {
                new IntersectionObserver(function (e) {
                    var r = e[0];
                    bar.classList.toggle("show", !r.isIntersecting && r.boundingClientRect.top < 0);
                }).observe(target);
            }

            GLightbox({ selector: ".glightbox", touchNavigation: true, loop: true });

            $(".gallery-zoom").on("click", function () {
                $(".product-gallery-swiper .swiper-slide-active .glightbox").trigger("click");
            });
        });
    </script>
@endpush