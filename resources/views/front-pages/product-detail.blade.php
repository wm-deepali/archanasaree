@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/detail/detail.css') }}" />
@endpush

@section('content')

    <main>
        <div class="product-detail-page">
            <section class="product-breadcrumb">
                <div class="container">
                    <ul class="crumb">
                        <li><a href="index.html">Home</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li><a href="javascript:void(0)">Sarees</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li><a href="javascript:void(0)">Banarasi Sarees</a></li>
                        <li><i class="fa-solid fa-chevron-right"></i></li>
                        <li class="current">Zari Woven Banarasi Silk Saree</li>
                    </ul>
                </div>
            </section>

            <section class="product-main">
                <div class="container">
                    <div class="product-layout">
                        <div class="product-gallery">
                            <div class="gallery-main">
                                <span class="gallery-tag">Bestseller</span>
                                <div class="swiper product-gallery-swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="gallery-img">
                                                <a href="assets/images/home/tab1.png" class="glightbox"
                                                    data-gallery="product">
                                                    <img src="assets/images/home/tab1.png"
                                                        alt="Zari Woven Banarasi Silk Saree front view"
                                                        fetchpriority="high" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="gallery-img">
                                                <a href="assets/images/home/tab2.png" class="glightbox"
                                                    data-gallery="product">
                                                    <img src="assets/images/home/tab2.png" alt="Banarasi saree drape view"
                                                        loading="lazy" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="gallery-img">
                                                <a href="assets/images/home/tab3.png" class="glightbox"
                                                    data-gallery="product">
                                                    <img src="assets/images/home/tab3.png"
                                                        alt="Banarasi saree border detail" loading="lazy" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="gallery-img">
                                                <a href="assets/images/home/tab4.png" class="glightbox"
                                                    data-gallery="product">
                                                    <img src="assets/images/home/tab4.png" alt="Banarasi saree pallu"
                                                        loading="lazy" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="gallery-img">
                                                <a href="assets/images/home/offer2.png" class="glightbox"
                                                    data-gallery="product">
                                                    <img src="assets/images/home/offer2.png"
                                                        alt="Banarasi saree styled look" loading="lazy" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="gallery-zoom" aria-label="Zoom image">
                                    <i class="fa-solid fa-expand"></i>
                                </button>
                                <button type="button" class="g-prev" aria-label="Previous image">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <button type="button" class="g-next" aria-label="Next image">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                                <div class="gallery-counter"></div>
                            </div>
                            <div class="swiper product-thumb-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="assets/images/home/tab1.png" alt="Thumbnail 1" loading="lazy" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/home/tab2.png" alt="Thumbnail 2" loading="lazy" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/home/tab3.png" alt="Thumbnail 3" loading="lazy" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/home/tab4.png" alt="Thumbnail 4" loading="lazy" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/home/offer2.png" alt="Thumbnail 5" loading="lazy" />
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                <p class="price-tax">
                                    Inclusive of all taxes · You save ₹3,500
                                </p>
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
                                    <button type="button" class="offer-copy" data-code="ARCHANA10">
                                        ARCHANA10 <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                                <div class="offer-row">
                                    <span class="offer-ico"><i class="fa-solid fa-building-columns"></i></span>
                                    <div class="offer-text">
                                        <b>Bank Offer</b>
                                        <p>
                                            Flat ₹500 off on selected bank cards on orders above
                                            ₹7,999.
                                        </p>
                                    </div>
                                </div>

                                <p class="offer-tnc">
                                    Offers are applied at checkout. Only one coupon can be used
                                    per order. Terms &amp; conditions apply.
                                </p>
                            </div>

                            <p class="info-desc">
                                A timeless Banarasi silk saree crafted for celebrations,
                                featuring intricate zari work, a graceful drape and a richly
                                detailed border. Designed for weddings, festive occasions and
                                elegant evening gatherings.
                            </p>

                            <div class="product-options">
                                <div class="opt-group">
                                    <div class="opt-head">
                                        <span>Color:</span><b class="opt-value" id="colorName">Wine</b>
                                    </div>
                                    <div class="opt-swatches">
                                        <label class="opt-swatch" title="Wine"><input type="radio" name="color" value="wine"
                                                data-name="Wine" checked /><span style="--c: #5e1a33"></span></label>
                                        <label class="opt-swatch" title="Maroon"><input type="radio" name="color"
                                                value="maroon" data-name="Maroon" /><span
                                                style="--c: #6e1423"></span></label>
                                        <label class="opt-swatch" title="Red"><input type="radio" name="color" value="red"
                                                data-name="Red" /><span style="--c: #b3203c"></span></label>
                                        <label class="opt-swatch" title="Pink"><input type="radio" name="color" value="pink"
                                                data-name="Pink" /><span style="--c: #e79aa8"></span></label>
                                        <label class="opt-swatch" title="Green"><input type="radio" name="color"
                                                value="green" data-name="Green" /><span style="--c: #1f6b4f"></span></label>
                                        <label class="opt-swatch" title="Teal"><input type="radio" name="color" value="teal"
                                                data-name="Teal" /><span style="--c: #0f5c5c"></span></label>
                                        <label class="opt-swatch" title="Ivory"><input type="radio" name="color"
                                                value="ivory" data-name="Ivory" /><span style="--c: #f3ecd9"></span></label>
                                    </div>
                                </div>

                                <div class="opt-group">
                                    <div class="opt-head">
                                        <span>Size:</span><b class="opt-value">Free Size</b>
                                    </div>
                                    <div class="opt-chips">
                                        <label class="opt-chip"><input type="radio" name="size" value="free"
                                                checked /><span>Free Size</span></label>
                                    </div>
                                    <p class="opt-note">
                                        Standard saree length of 5.5 metres with an unstitched
                                        blouse piece.
                                    </p>
                                </div>

                                <div class="opt-group blouse-group">
                                    <div class="opt-head">
                                        <span>Blouse:</span><b class="opt-value">Choose an option</b>
                                        <button type="button" class="size-guide" data-model=".size-pop">
                                            <i class="fa-solid fa-ruler"></i> Size Guide
                                        </button>
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
                                            <label class="opt-chip"><input type="radio" name="blouse-size"
                                                    value="s" /><span>S</span></label>
                                            <label class="opt-chip"><input type="radio" name="blouse-size" value="m"
                                                    checked /><span>M</span></label>
                                            <label class="opt-chip"><input type="radio" name="blouse-size"
                                                    value="l" /><span>L</span></label>
                                            <label class="opt-chip"><input type="radio" name="blouse-size"
                                                    value="xl" /><span>XL</span></label>
                                            <label class="opt-chip"><input type="radio" name="blouse-size"
                                                    value="xxl" /><span>XXL</span></label>
                                        </div>
                                        <p class="opt-note">
                                            Stitched blouses are made to standard size and cannot be
                                            returned once stitched.
                                        </p>
                                    </div>
                                </div>

                                <div class="opt-group">
                                    <div class="opt-head">
                                        <span>Add-ons:</span><b class="opt-value">Optional</b>
                                    </div>
                                    <div class="opt-addons">
                                        <label class="opt-check">
                                            <input type="checkbox" name="addon" value="fall-pico" />
                                            <span class="oc-text"><b>Fall &amp; Pico</b><em>Stitched and ready to
                                                    drape</em></span>
                                            <strong>+ ₹250</strong>
                                        </label>
                                        <label class="opt-check">
                                            <input type="checkbox" name="addon" value="petticoat" />
                                            <span class="oc-text"><b>Matching Petticoat</b><em>Cotton, drawstring
                                                    waist</em></span>
                                            <strong>+ ₹399</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="product-delivery">
                                <div class="del-head">
                                    <i class="fa-solid fa-location-dot"></i><b>Check Delivery</b>
                                </div>
                                <form class="pin-form" action="#" method="post">
                                    <input type="text" name="pincode" inputmode="numeric" maxlength="6"
                                        placeholder="Enter your pincode" value="110001" aria-label="Pincode" />
                                    <button type="submit">Check</button>
                                </form>
                                <p class="pin-result">
                                    <i class="fa-solid fa-circle-check"></i> Delivery available.
                                    Estimated delivery in 3–5 business days.
                                </p>
                                <ul class="del-steps">
                                    <li>
                                        <i class="fa-solid fa-bag-shopping"></i>
                                        <b>Order Placed</b>
                                        <span>Today</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-box"></i>
                                        <b>Dispatched</b>
                                        <span>In 2–4 days</span>
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-house-circle-check"></i>
                                        <b>Delivered</b>
                                        <span>In 3–7 days</span>
                                    </li>
                                </ul>
                                <ul class="del-points">
                                    <li>
                                        <i class="fa-solid fa-hand-holding-dollar"></i> Cash on
                                        Delivery available at your pincode
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i> Easy
                                        7-day return &amp; exchange
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
                                <div class="accordion-wrapper">
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Product Details</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <ul class="spec-list">
                                                <li><span>Fabric</span><b>Pure Banarasi Silk</b></li>
                                                <li><span>Saree Length</span><b>5.5 Metres</b></li>
                                                <li><span>Blouse Piece</span><b>Included</b></li>
                                                <li>
                                                    <span>Weave</span><b>Traditional Banarasi Weave</b>
                                                </li>
                                                <li><span>Work</span><b>Zari / Woven Detail</b></li>
                                                <li>
                                                    <span>Occasion</span><b>Wedding, Festive, Reception</b>
                                                </li>
                                                <li><span>Country of Origin</span><b>India</b></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Fabric &amp; Material</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <p>
                                                Woven in pure Banarasi silk with a soft lustre and a
                                                rich, structured fall. The zari is interlaced into the
                                                fabric, giving the border and pallu a refined,
                                                long-lasting shine.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Saree Specifications</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <ul class="spec-list">
                                                <li><span>Saree Length</span><b>5.5 Metres</b></li>
                                                <li><span>Blouse Length</span><b>0.8 Metres</b></li>
                                                <li><span>Border</span><b>Woven Zari Border</b></li>
                                                <li><span>Pallu</span><b>Detailed Zari Pallu</b></li>
                                                <li>
                                                    <span>Fall &amp; Pico</span><b>Optional Add-on</b>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Care Instructions</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <ul class="info-points">
                                                <li>Dry clean only to protect the zari and silk.</li>
                                                <li>
                                                    Store in a soft muslin cloth, away from direct
                                                    sunlight.
                                                </li>
                                                <li>Do not wring or use harsh detergents.</li>
                                                <li>Iron on low heat from the reverse side.</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Shipping &amp; Delivery</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <ul class="info-points with-icon">
                                                <li>
                                                    <i class="fa-solid fa-truck"></i> Free shipping
                                                    above ₹2,999.
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-box"></i> Dispatch: 2–4
                                                    working days.
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-clock"></i> Estimated
                                                    delivery: 3–7 working days depending on location.
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-hand-holding-dollar"></i> Cash
                                                    on Delivery available on selected pincodes.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Returns &amp; Exchange</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <p>
                                                <b>Easy Returns &amp; Exchange.</b> Eligible products
                                                can be returned or exchanged within 7 days of
                                                delivery, unused and with tags intact. Stitched
                                                blouses and add-ons are not eligible.
                                            </p>
                                            <a href="javascript:void(0)" class="policy-link">View Return Policy
                                                <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <h5>Offers &amp; How to Avail</h5>
                                            <span class="accordion-icon">+</span>
                                        </div>
                                        <div class="accordion-content">
                                            <ul class="info-points">
                                                <li>
                                                    Add the saree to your bag and proceed to checkout.
                                                </li>
                                                <li>
                                                    Enter the coupon code ARCHANA10 in the coupon box.
                                                </li>
                                                <li>
                                                    Choose a prepaid payment method to see the extra 10%
                                                    off applied.
                                                </li>
                                                <li>
                                                    Bank offers appear on the payment step for eligible
                                                    cards.
                                                </li>
                                                <li>
                                                    Offers cannot be combined and may change without
                                                    notice.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="product-reviews" id="reviews">
                <div class="container">
                    <div class="sec-head">
                        <span class="eyebrow">Customer Reviews</span>
                        <div class="heading">
                            <h3>What Our Customers Say</h3>
                        </div>
                    </div>

                    <div class="review-summary">
                        <div class="rs-score">
                            <b>4.8</b><span>/ 5</span>
                            <div class="rs-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p>Based on 124 reviews</p>
                        </div>
                        <ul class="rs-bars">
                            <li>
                                <span>5 <i class="fa-solid fa-star"></i></span>
                                <div class="bar"><i style="width: 82%"></i></div>
                                <em>102</em>
                            </li>
                            <li>
                                <span>4 <i class="fa-solid fa-star"></i></span>
                                <div class="bar"><i style="width: 12%"></i></div>
                                <em>15</em>
                            </li>
                            <li>
                                <span>3 <i class="fa-solid fa-star"></i></span>
                                <div class="bar"><i style="width: 4%"></i></div>
                                <em>5</em>
                            </li>
                            <li>
                                <span>2 <i class="fa-solid fa-star"></i></span>
                                <div class="bar"><i style="width: 1%"></i></div>
                                <em>1</em>
                            </li>
                            <li>
                                <span>1 <i class="fa-solid fa-star"></i></span>
                                <div class="bar"><i style="width: 1%"></i></div>
                                <em>1</em>
                            </li>
                        </ul>
                        <div class="rs-cta">
                            <p>
                                Bought this saree? Share your experience and photos with other
                                customers.
                            </p>
                            <button type="button" class="btn btn-primary write-review" data-model=".review-pop">
                                Write a Review
                            </button>
                        </div>
                    </div>

                    <div class="review-photos">
                        <h5>Customer Photos <span>(38)</span></h5>
                        <div class="rp-grid">
                            <a href="assets/images/home/tab1.png" class="rp-item glightbox"
                                data-gallery="customer-photos"><img src="assets/images/home/tab1.png" alt="Customer photo 1"
                                    loading="lazy" /></a>
                            <a href="assets/images/home/tab2.png" class="rp-item glightbox"
                                data-gallery="customer-photos"><img src="assets/images/home/tab2.png" alt="Customer photo 2"
                                    loading="lazy" /></a>
                            <a href="assets/images/home/tab3.png" class="rp-item glightbox"
                                data-gallery="customer-photos"><img src="assets/images/home/tab3.png" alt="Customer photo 3"
                                    loading="lazy" /></a>
                            <a href="assets/images/home/tab4.png" class="rp-item glightbox"
                                data-gallery="customer-photos"><img src="assets/images/home/tab4.png" alt="Customer photo 4"
                                    loading="lazy" /></a>
                            <a href="assets/images/home/offer2.png" class="rp-item glightbox"
                                data-gallery="customer-photos"><img src="assets/images/home/offer2.png"
                                    alt="Customer photo 5" loading="lazy" /></a>
                            <a href="assets/images/home/tab1.png" class="rp-item more glightbox"
                                data-gallery="customer-photos"><img src="assets/images/home/tab1.png"
                                    alt="More customer photos" loading="lazy" /><span>+33</span></a>
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
                        <li data-tab="1" class="active">All (124)</li>
                        <li data-tab="2">With Photos (38)</li>
                        <li data-tab="3">5 Star (102)</li>
                    </ul>

                    <div class="tab-nav-content">
                        <div class="tabs active" data-tab="1">
                            <div class="swiper-wrap">
                                <div class="swiper reviewSlider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">PS</span>
                                                    <div>
                                                        <h5>Priya Sharma</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Beautiful saree and even better in person</h6>
                                                <p>
                                                    The zari detailing is elegant and the fabric drapes
                                                    beautifully. I wore it to my cousin's wedding and
                                                    received so many compliments. The packaging was also
                                                    very neat.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab1.png" class="glightbox"
                                                        data-gallery="rv-a1"><img src="assets/images/home/tab1.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/tab3.png" class="glightbox"
                                                        data-gallery="rv-a1"><img src="assets/images/home/tab3.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">October 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (12)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">NK</span>
                                                    <div>
                                                        <h5>Neha Kapoor</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Rich colour, exactly like the photos</h6>
                                                <p>
                                                    I was worried the wine shade would look different,
                                                    but it matches the pictures perfectly. The pallu is
                                                    heavy and graceful, and the blouse piece is generous
                                                    enough for a proper fitting.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab2.png" class="glightbox"
                                                        data-gallery="rv-a2"><img src="assets/images/home/tab2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">October 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (8)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">AV</span>
                                                    <div>
                                                        <h5>Ananya Verma</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-regular fa-star"></i>
                                                </div>
                                                <h6>Lovely weave, delivery was quick</h6>
                                                <p>
                                                    The weave is fine and the border looks very rich. It
                                                    arrived within four days to Lucknow. I added the
                                                    fall and pico option and it came perfectly finished.
                                                </p>
                                                <div class="rv-foot">
                                                    <span class="rv-date">September 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (5)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">RM</span>
                                                    <div>
                                                        <h5>Ritu Malhotra</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Perfect for festive evenings</h6>
                                                <p>
                                                    Bought this for Diwali and it was the highlight of
                                                    my look. Soft to touch, not too heavy to carry, and
                                                    the zari has not lost its shine even after a long
                                                    evening.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab4.png" class="glightbox"
                                                        data-gallery="rv-a4"><img src="assets/images/home/tab4.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/offer2.png" class="glightbox"
                                                        data-gallery="rv-a4"><img src="assets/images/home/offer2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/tab2.png" class="glightbox"
                                                        data-gallery="rv-a4"><img src="assets/images/home/tab2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">September 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (9)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">SA</span>
                                                    <div>
                                                        <h5>Simran Arora</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Worth every rupee</h6>
                                                <p>
                                                    I have shopped from Archana for years and this saree
                                                    keeps up the same quality. The team also helped me
                                                    with styling tips over a call, which was a lovely
                                                    touch.
                                                </p>
                                                <div class="rv-foot">
                                                    <span class="rv-date">August 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (4)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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

                        <div class="tabs" data-tab="2">
                            <div class="swiper-wrap">
                                <div class="swiper reviewSlider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">PS</span>
                                                    <div>
                                                        <h5>Priya Sharma</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Beautiful saree and even better in person</h6>
                                                <p>
                                                    The zari detailing is elegant and the fabric drapes
                                                    beautifully. I wore it to my cousin's wedding and
                                                    received so many compliments. The packaging was also
                                                    very neat.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab1.png" class="glightbox"
                                                        data-gallery="rv-b1"><img src="assets/images/home/tab1.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/tab3.png" class="glightbox"
                                                        data-gallery="rv-b1"><img src="assets/images/home/tab3.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">October 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (12)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">NK</span>
                                                    <div>
                                                        <h5>Neha Kapoor</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Rich colour, exactly like the photos</h6>
                                                <p>
                                                    I was worried the wine shade would look different,
                                                    but it matches the pictures perfectly. The pallu is
                                                    heavy and graceful, and the blouse piece is generous
                                                    enough for a proper fitting.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab2.png" class="glightbox"
                                                        data-gallery="rv-b2"><img src="assets/images/home/tab2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">October 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (8)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">RM</span>
                                                    <div>
                                                        <h5>Ritu Malhotra</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Perfect for festive evenings</h6>
                                                <p>
                                                    Bought this for Diwali and it was the highlight of
                                                    my look. Soft to touch, not too heavy to carry, and
                                                    the zari has not lost its shine even after a long
                                                    evening.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab4.png" class="glightbox"
                                                        data-gallery="rv-b3"><img src="assets/images/home/tab4.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/offer2.png" class="glightbox"
                                                        data-gallery="rv-b3"><img src="assets/images/home/offer2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/tab2.png" class="glightbox"
                                                        data-gallery="rv-b3"><img src="assets/images/home/tab2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">September 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (9)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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

                        <div class="tabs" data-tab="3">
                            <div class="swiper-wrap">
                                <div class="swiper reviewSlider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">PS</span>
                                                    <div>
                                                        <h5>Priya Sharma</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Beautiful saree and even better in person</h6>
                                                <p>
                                                    The zari detailing is elegant and the fabric drapes
                                                    beautifully. I wore it to my cousin's wedding and
                                                    received so many compliments. The packaging was also
                                                    very neat.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab1.png" class="glightbox"
                                                        data-gallery="rv-c1"><img src="assets/images/home/tab1.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/tab3.png" class="glightbox"
                                                        data-gallery="rv-c1"><img src="assets/images/home/tab3.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">October 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (12)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">NK</span>
                                                    <div>
                                                        <h5>Neha Kapoor</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Rich colour, exactly like the photos</h6>
                                                <p>
                                                    I was worried the wine shade would look different,
                                                    but it matches the pictures perfectly. The pallu is
                                                    heavy and graceful, and the blouse piece is generous
                                                    enough for a proper fitting.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab2.png" class="glightbox"
                                                        data-gallery="rv-c2"><img src="assets/images/home/tab2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">October 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (8)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">RM</span>
                                                    <div>
                                                        <h5>Ritu Malhotra</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Perfect for festive evenings</h6>
                                                <p>
                                                    Bought this for Diwali and it was the highlight of
                                                    my look. Soft to touch, not too heavy to carry, and
                                                    the zari has not lost its shine even after a long
                                                    evening.
                                                </p>
                                                <div class="rv-photos">
                                                    <a href="assets/images/home/tab4.png" class="glightbox"
                                                        data-gallery="rv-c3"><img src="assets/images/home/tab4.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/offer2.png" class="glightbox"
                                                        data-gallery="rv-c3"><img src="assets/images/home/offer2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                    <a href="assets/images/home/tab2.png" class="glightbox"
                                                        data-gallery="rv-c3"><img src="assets/images/home/tab2.png"
                                                            alt="Review photo" loading="lazy" /></a>
                                                </div>
                                                <div class="rv-foot">
                                                    <span class="rv-date">September 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (9)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="rv-card">
                                                <div class="rv-top">
                                                    <span class="rv-avatar">SA</span>
                                                    <div>
                                                        <h5>Simran Arora</h5>
                                                        <span class="rv-verified"><i class="fa-solid fa-circle-check"></i>
                                                            Verified Purchase</span>
                                                    </div>
                                                </div>
                                                <div class="rv-stars">
                                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                        class="fa-solid fa-star"></i>
                                                </div>
                                                <h6>Worth every rupee</h6>
                                                <p>
                                                    I have shopped from Archana for years and this saree
                                                    keeps up the same quality. The team also helped me
                                                    with styling tips over a call, which was a lovely
                                                    touch.
                                                </p>
                                                <div class="rv-foot">
                                                    <span class="rv-date">August 2026</span>
                                                    <button type="button" class="rv-helpful">
                                                        <i class="fa-regular fa-thumbs-up"></i> Helpful
                                                        (4)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
                    </div>
                </div>
            </section>

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
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab2.png" alt="Organza Embroidered Party Saree"
                                                    loading="lazy" /></a><span class="prod-badge">Bestseller</span>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Organza Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.7</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Organza Embroidered Party Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹6,299</span><del
                                                    class="price-old">₹8,999</del><span class="price-off">30% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab3.png" alt="Kanjivaram Pure Silk Saree"
                                                    loading="lazy" /></a><span class="prod-badge">Bestseller</span>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.9</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Kanjivaram Pure Silk Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹12,999</span><del
                                                    class="price-old">₹17,499</del><span class="price-off">26% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab4.png" alt="Embroidered Designer Saree"
                                                    loading="lazy" /></a><span class="prod-badge">New Arrival</span>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Designer Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.8</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Embroidered Designer Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹9,999</span><del
                                                    class="price-old">₹13,999</del><span class="price-off">29% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab1.png" alt="Georgette Printed Saree"
                                                    loading="lazy" /></a>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Georgette Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.6</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Georgette Printed Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹4,799</span><del
                                                    class="price-old">₹6,499</del><span class="price-off">26% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab2.png" alt="Red Bridal Silk Saree"
                                                    loading="lazy" /></a><span class="prod-badge">Bestseller</span>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Bridal Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.8</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Red Bridal Silk Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹24,999</span><del
                                                    class="price-old">₹34,999</del><span class="price-off">29% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab1.png" alt="Kanjivaram Pure Silk Saree"
                                                    loading="lazy" /></a>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.9</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Kanjivaram Pure Silk Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹12,999</span><del
                                                    class="price-old">₹17,499</del><span class="price-off">26% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab2.png" alt="Organza Embroidered Party Saree"
                                                    loading="lazy" /></a>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Organza Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.7</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Organza Embroidered Party Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹6,299</span><del
                                                    class="price-old">₹8,999</del><span class="price-off">30% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab3.png" alt="Red Bridal Silk Saree"
                                                    loading="lazy" /></a>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Bridal Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.8</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Red Bridal Silk Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹24,999</span><del
                                                    class="price-old">₹34,999</del><span class="price-off">29% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab4.png" alt="Embroidered Designer Lehenga Set"
                                                    loading="lazy" /></a>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Designer Lehenga</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.8</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Embroidered Designer Lehenga Set</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹18,999</span><del
                                                    class="price-old">₹26,999</del><span class="price-off">30% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="prod_cart">
                                        <div class="prod-img">
                                            <a href="javascript:void(0)" class="prod-link"><img
                                                    src="assets/images/home/tab1.png" alt="Georgette Printed Saree"
                                                    loading="lazy" /></a>
                                            <div class="prod-actions">
                                                <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                                                    <i class="fa-regular fa-heart"></i></button><button type="button"
                                                    class="act-btn quick-btn" aria-label="Quick view">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <div class="prod-meta">
                                                <span class="prod-cat">Georgette Saree</span><span class="prod-rate"><i
                                                        class="fa-solid fa-star"></i> 4.6</span>
                                            </div>
                                            <h5 class="prod-name">
                                                <a href="javascript:void(0)">Georgette Printed Saree</a>
                                            </h5>
                                            <div class="prod-price">
                                                <span class="price-now">₹4,799</span><del
                                                    class="price-old">₹6,499</del><span class="price-off">26% OFF</span>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary prod-cta">
                                                Add to Bag
                                            </button>
                                        </div>
                                    </div>
                                </div>
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

            <div class="product-sticky-bar" aria-hidden="true">
                <div class="sb-product">
                    <img src="assets/images/home/tab1.png" alt="Zari Woven Banarasi Silk Saree" loading="lazy" />
                    <div class="sb-text">
                        <b>Zari Woven Banarasi Silk Saree</b>
                        <span><strong>₹8,499</strong> <em>29% OFF</em></span>
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
                <p>Zari Woven Banarasi Silk Saree</p>
            </div>
            <form class="form review-form" action="#" method="post" enctype="multipart/form-data">
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
                    <p>
                        Your email will not be published. Reviews appear after approval.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <div class="model size-pop">
        <button type="button" class="close" aria-label="Close size guide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M5 5l14 14M19 5L5 19" />
            </svg>
        </button>
        <div class="model-body">
            <div class="title">
                <h4>Blouse Size Guide</h4>
                <p>
                    Measurements in inches. Choose the size closest to your body
                    measurements.
                </p>
            </div>
            <div class="size-table-wrap">
                <table class="size-table">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Bust</th>
                            <th>Waist</th>
                            <th>Shoulder</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>S</td>
                            <td>34</td>
                            <td>28</td>
                            <td>14</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>36</td>
                            <td>30</td>
                            <td>14.5</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>38</td>
                            <td>32</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td>XL</td>
                            <td>40</td>
                            <td>34</td>
                            <td>15.5</td>
                        </tr>
                        <tr>
                            <td>XXL</td>
                            <td>42</td>
                            <td>36</td>
                            <td>16</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <ul class="size-tips">
                <li><b>Bust:</b> measure around the fullest part of your chest.</li>
                <li>
                    <b>Waist:</b> measure around the narrowest part of your waist.
                </li>
                <li>
                    <b>Shoulder:</b> measure from one shoulder point to the other across
                    the back.
                </li>
                <li>Between two sizes? Choose the larger size.</li>
            </ul>
        </div>
    </div>

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

            var thumbs = new Swiper(".product-thumb-swiper", {
                spaceBetween: 10,
                slidesPerView: 4.2,
                watchSlidesProgress: true,
                breakpoints: { 541: { slidesPerView: 5 } },
            });

            new Swiper(".product-gallery-swiper", {
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
                thumbs: { swiper: thumbs },
            });

            new Swiper(".reviewSlider", {
                slidesPerView: 1.1,
                spaceBetween: 14,
                navigation: nav(".product-reviews"),
                breakpoints: {
                    541: { slidesPerView: 2, spaceBetween: 18 },
                    1025: { slidesPerView: 3, spaceBetween: 24 },
                },
            });

            [
                "relatedProductSlider:.related-products",
                "recentlyViewedSlider:.recently-viewed",
            ].forEach(function (s) {
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
                var $i = $(this).siblings(".qty-input"),
                    v = parseInt($i.val(), 10) || 1;
                v = $(this).hasClass("qty-plus") ? v + 1 : Math.max(1, v - 1);
                $(".qty-input").val(v);
            });

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

        GLightbox({ selector: ".glightbox", touchNavigation: true, loop: true });

        $(".gallery-zoom").on("click", function () {
            $(".product-gallery-swiper .swiper-slide-active .glightbox").trigger(
                "click",
            );
        });
    </script>
@endpush