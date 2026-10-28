@extends('layouts.app')

@section('body_class', 'home-page')

@section('content')


  <section class="home-banner">
    <div class="swiper singleSlider">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="slide-img">
            <img src="assets/images/home/banner1.png" alt="Bridal wear editorial" />
          </div>
          <div class="container">
            <div class="slide-content">
              <span class="hero-eyebrow">The Archana Edit</span>
              <h2 class="hero-title">
                Dress the Moment.<br />Remember the Look.
              </h2>
              <p class="hero-desc">
                Discover premium sarees, statement lehengas and exquisite
                bridal wear, thoughtfully curated for weddings, festivities
                and every occasion worth dressing up for.
              </p>
              <div class="hero-btns">
                <a href="javascript:void()" class="btn btn-primary">Shop the Collection</a>
                <a href="javascript:void()" class="btn btn-outline-primary">Explore Bridal Wear
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M3 12h18M15 6l6 6-6 6" />
                  </svg></a>
              </div>
              <p class="hero-note">Sarees · Lehengas · Bridal Wear</p>
            </div>
          </div>
        </div>
        <div class="swiper-slide theme-white">
          <div class="slide-img">
            <img src="assets/images/home/banner2.png" alt="Lehenga editorial" />
          </div>
          <div class="container">
            <div class="slide-content">
              <span class="hero-eyebrow">The Lehenga Edit</span>
              <h2 class="hero-title">
                Statement Silhouettes.<br />Made to Be Remembered.
              </h2>
              <p class="hero-desc">
                Designer lehengas with fine embroidery and rich fabrics, for
                sangeet nights, receptions and every celebration in between.
              </p>
              <div class="hero-btns">
                <a href="javascript:void()" class="btn btn-primary">Shop Lehengas</a>
                <a href="javascript:void()" class="btn btn-outline-primary">Explore Bridal Wear
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M3 12h18M15 6l6 6-6 6" />
                  </svg></a>
              </div>
              <p class="hero-note">Sarees · Lehengas · Bridal Wear</p>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <section class="home-secA">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Explore Our Collections</span>
        <div class="heading">
          <h3>Find Your Signature Look</h3>
        </div>
        <p>
          From graceful sarees to statement lehengas and unforgettable
          bridal ensembles, discover something made for every celebration.
        </p>
      </div>
      <div class="swiper-wrap">
        <div class="swiper fourSlider">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat1.png" alt="Premium Sarees" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Premium Sarees</h4>
                  <p>Timeless drapes, beautiful craftsmanship.</p>
                  <span class="cat-link">Shop Sarees <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat2.png" alt="Designer Lehengas" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Designer Lehengas</h4>
                  <p>Statement silhouettes for every grand occasion.</p>
                  <span class="cat-link">Shop Lehengas
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat3.png" alt="Suits" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Suits</h4>
                  <p>
                    Graceful suits for everyday elegance and festive
                    moments.
                  </p>
                  <span class="cat-link">Shop Suits <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat4.png" alt="Bridal Wear" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Bridal Wear</h4>
                  <p>
                    Extraordinary pieces for your most memorable moments.
                  </p>
                  <span class="cat-link">Explore Bridal
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
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

  <section class="home-secB">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Most Loved</span>
        <div class="heading">
          <h3>What Everyone's Loving</h3>
        </div>
        <p>
          Discover the styles our customers are choosing for celebrations,
          festivities and unforgettable occasions.
        </p>
      </div>
      <ul class="tab-nav">
        <li data-tab="1" class="active">All</li>
        <li data-tab="2">Sarees</li>
        <li data-tab="3">Lehengas</li>
        <li data-tab="4">Bridal Wear</li>
      </ul>
      <div class="tab-nav-content">
        <!-- TAB 1: ALL -->
        <div class="tabs active" data-tab="1">
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                          alt="Zari Woven Banarasi Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Banarasi Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Zari Woven Banarasi Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span
                          class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                          alt="Organza Embroidered Party Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Organza Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.7</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Organza Embroidered Party Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹6,299</span><del class="price-old">₹8,999</del><span
                          class="price-off">30% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                          alt="Kanjivaram Pure Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                          class="price-off">26% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab4.png"
                          alt="Embroidered Designer Lehenga Set" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Designer Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Embroidered Designer Lehenga Set</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹18,999</span><del class="price-old">₹26,999</del><span
                          class="price-off">30% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                          alt="Velvet Sequin Sangeet Lehenga" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Party Wear Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.6</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Velvet Sequin Sangeet Lehenga</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹14,499</span><del class="price-old">₹19,999</del><span
                          class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                          alt="Organza Floral Lehenga Set" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Organza Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.7</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Organza Floral Lehenga Set</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹16,799</span><del class="price-old">₹22,999</del><span
                          class="price-off">27% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                          alt="Heavy Zardozi Bridal Lehenga" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Bridal Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Heavy Zardozi Bridal Lehenga</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹42,999</span><del class="price-old">₹59,999</del><span
                          class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab4.png"
                          alt="Red Bridal Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Bridal Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Red Bridal Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹24,999</span><del class="price-old">₹34,999</del><span
                          class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
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

        <!-- TAB 2: SAREES -->
        <div class="tabs" data-tab="2">
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                          alt="Zari Woven Banarasi Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Banarasi Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Zari Woven Banarasi Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span
                          class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                          alt="Organza Embroidered Party Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Organza Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.7</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Organza Embroidered Party Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹6,299</span><del class="price-old">₹8,999</del><span
                          class="price-off">30% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                          alt="Kanjivaram Pure Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                          class="price-off">26% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
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

        <!-- TAB 3: LEHENGAS -->
        <div class="tabs" data-tab="3">
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                          alt="Embroidered Designer Lehenga Set" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Designer Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Embroidered Designer Lehenga Set</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹18,999</span><del class="price-old">₹26,999</del><span
                          class="price-off">30% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                          alt="Velvet Sequin Sangeet Lehenga" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Party Wear Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.6</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Velvet Sequin Sangeet Lehenga</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹14,499</span><del class="price-old">₹19,999</del><span
                          class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                          alt="Organza Floral Lehenga Set" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Organza Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.7</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Organza Floral Lehenga Set</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹16,799</span><del class="price-old">₹22,999</del><span
                          class="price-off">27% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
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

        <!-- TAB 4: BRIDAL WEAR -->
        <div class="tabs" data-tab="4">
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                          alt="Heavy Zardozi Bridal Lehenga" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Bridal Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Heavy Zardozi Bridal Lehenga</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹42,999</span><del class="price-old">₹59,999</del><span
                          class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                          alt="Red Bridal Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Bridal Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Red Bridal Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹24,999</span><del class="price-old">₹34,999</del><span
                          class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
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

  <section class="home-secC">
    <div class="container">
      <div class="edit-grid">
        <div class="edit-visual">
          <div class="edit-photo">
            <img src="assets/images/home/banner5.jpg" alt="The Saree Edit" loading="lazy" />
          </div>
          <span class="edit-tag">The Archana Edit</span>
        </div>
        <div class="edit-content">
          <span class="eyebrow">The Saree Edit</span>
          <div class="heading">
            <h3>Grace That Never <br />Goes Out of Style</h3>
          </div>
          <p class="edit-copy">
            Explore beautifully draped sarees that bring together timeless
            Indian craftsmanship and contemporary elegance. From festive
            gatherings to wedding celebrations, discover a silhouette made
            for your moment.
          </p>
          <ul class="edit-links">
            <li><a href="javascript:void()">Bridal Saree</a></li>
            <li><a href="javascript:void()">Party Wears</a></li>
            <li><a href="javascript:void()">Cocktail Saree</a></li>
            <li><a href="javascript:void()">Banarsi Saree</a></li>
            <li><a href="javascript:void()">Net Sarees</a></li>
          </ul>
          <a href="javascript:void()" class="btn btn-primary edit-cta">Explore Sarees <i
              class="fa-solid fa-arrow-right-long"></i></a>
          <div class="edit-products">
            <div class="prod_cart">
              <div class="prod-img">
                <a href="javascript:void()" class="prod-link"><img src="assets/images/home/tab1.png"
                    alt="Zari Woven Banarasi Silk Saree" loading="lazy" /></a><span class="prod-badge">Bestseller</span>
                <div class="prod-actions">
                  <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i></button><button type="button" class="act-btn quick-btn"
                    aria-label="Quick view">
                    <i class="fa-regular fa-eye"></i>
                  </button>
                </div>
              </div>
              <div class="prod-info">
                <div class="prod-meta">
                  <span class="prod-cat">Banarasi Saree</span><span class="prod-rate"><i class="fa-solid fa-star"></i>
                    4.8</span>
                </div>
                <h5 class="prod-name">
                  <a href="javascript:void()">Zari Woven Banarasi Silk Saree</a>
                </h5>
                <div class="prod-price">
                  <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span class="price-off">29%
                    OFF</span>
                </div>
                <button type="button" class="btn btn-outline-primary prod-cta">
                  Add to Bag
                </button>
              </div>
            </div>
            <div class="prod_cart">
              <div class="prod-img">
                <a href="javascript:void()" class="prod-link"><img src="assets/images/home/tab2.png"
                    alt="Organza Embroidered Party Saree" loading="lazy" /></a><span class="prod-badge">Bestseller</span>
                <div class="prod-actions">
                  <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i></button><button type="button" class="act-btn quick-btn"
                    aria-label="Quick view">
                    <i class="fa-regular fa-eye"></i>
                  </button>
                </div>
              </div>
              <div class="prod-info">
                <div class="prod-meta">
                  <span class="prod-cat">Organza Saree</span><span class="prod-rate"><i class="fa-solid fa-star"></i>
                    4.7</span>
                </div>
                <h5 class="prod-name">
                  <a href="javascript:void()">Organza Embroidered Party Saree</a>
                </h5>
                <div class="prod-price">
                  <span class="price-now">₹6,299</span><del class="price-old">₹8,999</del><span class="price-off">30%
                    OFF</span>
                </div>
                <button type="button" class="btn btn-outline-primary prod-cta">
                  Add to Bag
                </button>
              </div>
            </div>
            <div class="prod_cart">
              <div class="prod-img">
                <a href="javascript:void()" class="prod-link"><img src="assets/images/home/tab3.png"
                    alt="Kanjivaram Pure Silk Saree" loading="lazy" /></a><span class="prod-badge">Bestseller</span>
                <div class="prod-actions">
                  <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i></button><button type="button" class="act-btn quick-btn"
                    aria-label="Quick view">
                    <i class="fa-regular fa-eye"></i>
                  </button>
                </div>
              </div>
              <div class="prod-info">
                <div class="prod-meta">
                  <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i class="fa-solid fa-star"></i>
                    4.9</span>
                </div>
                <h5 class="prod-name">
                  <a href="javascript:void()">Kanjivaram Pure Silk Saree</a>
                </h5>
                <div class="prod-price">
                  <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span class="price-off">26%
                    OFF</span>
                </div>
                <button type="button" class="btn btn-outline-primary prod-cta">
                  Add to Bag
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-statement">
        <span class="line"></span>
        <p>Curated for celebrations, crafted to be remembered.</p>
        <span class="line"></span>
      </div>
    </div>
  </section>

  <section class="home-secD">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Find Your Drape</span>
        <div class="heading">
          <h3>A Saree for Every Celebration</h3>
        </div>
        <p>
          Explore distinctive fabrics, textures and styles curated for every
          occasion.
        </p>
      </div>
      <div class="swiper-wrap">
        <div class="swiper fourSlider" data-mob="1.4">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <a href="category-listing.html" class="drape-card">
                <div class="drape-img">
                  <img src="assets/images/home/tab1.png" alt="Bridal Saree" loading="lazy" />
                </div>
                <div class="drape-info">
                  <h4>Bridal Saree</h4>
                  <p>Timeless drapes for your most cherished day.</p>
                  <span class="drape-link">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="drape-card">
                <div class="drape-img">
                  <img src="assets/images/home/tab2.png" alt="Party Wears" loading="lazy" />
                </div>
                <div class="drape-info">
                  <h4>Party Wears</h4>
                  <p>Designed to make every entrance memorable.</p>
                  <span class="drape-link">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="drape-card">
                <div class="drape-img">
                  <img src="assets/images/home/tab3.png" alt="Cocktail Saree" loading="lazy" />
                </div>
                <div class="drape-info">
                  <h4>Cocktail Saree</h4>
                  <p>Glamorous styles for evenings that sparkle.</p>
                  <span class="drape-link">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="drape-card">
                <div class="drape-img">
                  <img src="assets/images/home/tab4.png" alt="Banarsi Saree" loading="lazy" />
                </div>
                <div class="drape-info">
                  <h4>Banarsi Saree</h4>
                  <p>Rich weaves for timeless celebrations.</p>
                  <span class="drape-link">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="drape-card">
                <div class="drape-img">
                  <img src="assets/images/home/tab1.png" alt="Net Sarees" loading="lazy" />
                </div>
                <div class="drape-info">
                  <h4>Net Sarees</h4>
                  <p>Light, graceful drapes with a delicate finish.</p>
                  <span class="drape-link">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
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
      <div class="slider-foot">
        <span class="slide-current sliderCurrent">01</span>
        <div class="swiper-pagination sliderProgress"></div>
        <span class="slide-total sliderTotal">02</span>
      </div>
    </div>
  </section>

  <section class="home-secE">
    <div class="camp-bg">
      <img src="assets/images/home/banner5.jpg" alt="Statement lehenga campaign" loading="lazy" />
    </div>
    <div class="container">
      <div class="camp-grid">
        <div class="camp-content">
          <span class="eyebrow">The Lehenga Edit</span>
          <div class="heading">
            <h2>Make an Entrance <br />They'll Remember</h2>
          </div>
          <p class="camp-copy">
            Discover statement lehengas designed for weddings, receptions,
            engagements and celebrations where every detail deserves to
            stand out.
          </p>
          <div class="camp-btns">
            <a href="category-listing.html" class="btn btn-white">Shop Lehengas</a>
            <a href="category-listing.html" class="btn btn-outline-white">Explore Designer Collection
              <i class="fa-solid fa-arrow-right-long"></i></a>
          </div>
          <ul class="camp-note">
            <li>Statement Silhouettes</li>
            <li>Intricate Details</li>
            <li>Celebration-Ready Styles</li>
          </ul>
        </div>
        <div class="camp-visual">
          <div class="camp-photo">
            <img src="assets/images/home/upper11zon.jpg" alt="Designer lehenga" loading="lazy" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="home-secF">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Shop by Occasion</span>
        <div class="heading">
          <h3>A Lehenga for Every Moment</h3>
        </div>
        <p>
          From the aisle to the after-party, find the silhouette made for
          your celebration.
        </p>
      </div>
      <div class="swiper-wrap">
        <div class="swiper fourSlider">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat1.png" alt="Bridal Lehengas" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Bridal Lehengas</h4>
                  <p>
                    Crafted for the most unforgettable walk down the aisle.
                  </p>
                  <span class="cat-link">Shop Bridal <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat2.png" alt="Wedding Lehengas" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Wedding Lehengas</h4>
                  <p>Elegant silhouettes for every wedding celebration.</p>
                  <span class="cat-link">Shop Wedding
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat2.png" alt="Reception Lehengas" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Reception Lehengas</h4>
                  <p>Contemporary glamour for the evening spotlight.</p>
                  <span class="cat-link">Shop Reception
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat3.png" alt="Engagement Lehengas" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Engagement Lehengas</h4>
                  <p>Sophisticated styles for the beginning of forever.</p>
                  <span class="cat-link">Shop Engagement
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="category-listing.html" class="cat-card">
                <div class="cat-img">
                  <img src="assets/images/home/cat4.png" alt="Party Lehengas" loading="lazy" />
                </div>
                <div class="cat-info">
                  <h4>Party Lehengas</h4>
                  <p>Statement dressing for special evenings.</p>
                  <span class="cat-link">Shop Party <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
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

  <section class="home-secG">
    <div class="container">
      <div class="bridal-wrap">
        <div class="bridal-img">
          <img src="assets/images/home/offer2.png" alt="The Bridal Collection" loading="lazy" />
        </div>
        <div class="bridal-content">
          <span class="eyebrow">The Bridal Collection</span>
          <div class="heading">
            <h2>For the Bride Who Deserves Something Extraordinary</h2>
          </div>
          <p class="bridal-copy">
            Step into your celebration with exquisite bridal sarees and
            lehengas chosen for their beauty, detail and timeless appeal.
          </p>
          <div class="bridal-btns">
            <a href="category-listing.html" class="btn btn-primary">Explore Bridal Wear</a>
            <a href="category-listing.html" class="btn btn-outline-primary">Shop Bridal Lehengas</a>
          </div>
          <ul class="bridal-links">
            <li><a href="javascript:void()">Bridal Sarees</a></li>
            <li><a href="javascript:void()">Bridal Lehengas</a></li>
            <li><a href="javascript:void()">Wedding Wear</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="home-secH">
    <div class="container">
      <div class="swiper-wrap">
        <div class="swiper fourSlider">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <a href="product-listing.html" class="brd-card">
                <img src="assets/images/home/tab1.png" alt="Bridal Sarees" loading="lazy" />
                <div class="brd-info">
                  <h4>Bridal Sarees</h4>
                  <p>Timeless drapes for the most cherished moments.</p>
                  <span class="brd-link">Shop Bridal Sarees
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="product-listing.html" class="brd-card">
                <img src="assets/images/home/tab2.png" alt="Bridal Lehengas" loading="lazy" />
                <div class="brd-info">
                  <h4>Bridal Lehengas</h4>
                  <p>Statement craftsmanship for your unforgettable day.</p>
                  <span class="brd-link">Shop Bridal Lehengas
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="product-listing.html" class="brd-card">
                <img src="assets/images/home/tab3.png" alt="Reception Wear" loading="lazy" />
                <div class="brd-info">
                  <h4>Reception Wear</h4>
                  <p>
                    Elegant silhouettes for the celebration after the vows.
                  </p>
                  <span class="brd-link">Shop Reception Wear
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="product-listing.html" class="brd-card">
                <img src="assets/images/home/tab4.png" alt="Bridesmaid Edit" loading="lazy" />
                <div class="brd-info">
                  <h4>Bridesmaid Edit</h4>
                  <p>Beautiful styles for those standing beside you.</p>
                  <span class="brd-link">Explore Bridesmaid Edit
                    <i class="fa-solid fa-arrow-right-long"></i></span>
                </div>
              </a>
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

  <section class="home-secI">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Exclusive Offers</span>
        <div class="heading">
          <h3>A Little More Luxury, Just for You</h3>
        </div>
        <p>
          Discover special offers and selected styles curated to make your
          next occasion even more memorable.
        </p>
      </div>
      <div class="offer-grid">
        <a href="category-listing.html" class="offer-card">
          <img src="assets/images/home/offer1.jpg" alt="Welcome to Archana" loading="lazy" />
          <span class="o-badge"><b>10%</b> Off First Order</span>
          <div class="o-body">
            <h4>Welcome to Archana</h4>
            <p>Enjoy a special welcome benefit on your first order.</p>
            <span class="btn btn-white">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
          </div>
        </a>
        <a href="category-listing.html" class="offer-card">
          <img src="assets/images/home/offer2.png" alt="Festive Favourites" loading="lazy" />
          <span class="o-badge"><b>25%</b> Off Festive</span>
          <div class="o-body">
            <h4>Festive Favourites</h4>
            <p>Discover selected styles for the season of celebrations.</p>
            <span class="btn btn-white">Explore Festive Edit
              <i class="fa-solid fa-arrow-right-long"></i></span>
          </div>
        </a>
        <a href="category-listing.html" class="offer-card">
          <img src="assets/images/home/offer3.avif" alt="Limited-Time Styles" loading="lazy" />
          <span class="o-badge"><b>Limited</b> Time Only</span>
          <div class="o-body">
            <h4>Limited-Time Styles</h4>
            <p>Shop selected pieces before they're gone.</p>
            <span class="btn btn-white">Shop Offers <i class="fa-solid fa-arrow-right-long"></i></span>
          </div>
        </a>
      </div>
      <div class="coupon-wrap">
        <div class="coupon-head">
          <h5>Coupons &amp; Deals</h5>
        </div>
        <div class="coupon-grid">
          <div class="coupon-card">
            <div class="c-icon"><i class="fa-solid fa-ticket"></i></div>
            <div class="c-info">
              <span class="c-code">ARCHANA10</span>
              <p>Extra 10% off on your first order.</p>
            </div>
            <button type="button" class="coupon-copy" data-code="ARCHANA10">
              <span>Copy Code</span>
            </button>
          </div>
          <div class="coupon-card">
            <div class="c-icon"><i class="fa-solid fa-gift"></i></div>
            <div class="c-info">
              <span class="c-code">FESTIVE25</span>
              <p>Flat 25% off on selected festive styles.</p>
            </div>
            <button type="button" class="coupon-copy" data-code="FESTIVE25">
              <span>Copy Code</span>
            </button>
          </div>
          <div class="coupon-card">
            <div class="c-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="c-info">
              <span class="c-code">FREESHIP</span>
              <p>Free shipping on orders above ₹2,999.</p>
            </div>
            <button type="button" class="coupon-copy" data-code="FREESHIP">
              <span>Copy Code</span>
            </button>
          </div>
        </div>
        <p class="coupon-note">
          *Terms &amp; conditions apply. Offers valid for a limited time.
        </p>
      </div>
    </div>
  </section>

  <section class="home-secJ">
    <div class="container">
      <div class="feat-grid">
        <a href="product-listing.html" class="feat-visual">
          <img src="assets/images/home/offer2.png" alt="The Archana Edit" loading="lazy" />
        </a>
        <div class="feat-content">
          <div class="feat-panel">
            <span class="eyebrow">Curated for You</span>
            <div class="heading">
              <h3>The Archana Edit</h3>
            </div>
            <p>
              A handpicked selection of colours, silhouettes and
              craftsmanship that capture the spirit of the season.
            </p>
            <a href="product-listing.html" class="btn btn-primary">Explore the Edit <i
                class="fa-solid fa-arrow-right-long"></i></a>
          </div>
          <div class="swiper-wrap">
            <div class="swiper fourSlider" data-mob="2" data-sm="2" data-lg="2" data-xl="2">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                          alt="Kanjivaram Pure Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                          class="price-off">26% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                          alt="Heavy Zardozi Bridal Lehenga" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Bridal Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Heavy Zardozi Bridal Lehenga</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹42,999</span><del class="price-old">₹59,999</del><span
                          class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                          alt="Embroidered Designer Lehenga Set" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Designer Lehenga</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Embroidered Designer Lehenga Set</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹18,999</span><del class="price-old">₹26,999</del><span
                          class="price-off">30% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab4.png"
                          alt="Kanjivaram Pure Silk Saree" loading="lazy" /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span>
                        <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                          class="price-off">26% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                          Add to Cart
                        </button>
                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                      </div>
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

  <section class="home-secL">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Welcome Back</span>
        <div class="heading">
          <h3>Pick Up Where You Left Off</h3>
        </div>
        <p>
          Still thinking about it? Revisit the styles you've recently
          explored.
        </p>
      </div>
      <div class="swiper-wrap">
        <div class="swiper fourSlider">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="prod_cart">
                <div class="prod-img">
                  <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                      alt="Zari Woven Banarasi Silk Saree" loading="lazy" /></a>
                  <div class="prod-actions">
                    <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="prod-info">
                  <div class="prod-meta">
                    <span class="prod-cat">Banarasi Saree</span>
                    <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                  </div>
                  <h5 class="prod-name">
                    <a href="product-detail.html">Zari Woven Banarasi Silk Saree</a>
                  </h5>
                  <div class="prod-price">
                    <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span class="price-off">29%
                      OFF</span>
                  </div>
                  <div class="prod-btns">
                    <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                      Add to Cart
                    </button>
                    <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="prod_cart">
                <div class="prod-img">
                  <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                      alt="Embroidered Designer Lehenga Set" loading="lazy" /></a>
                  <div class="prod-actions">
                    <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="prod-info">
                  <div class="prod-meta">
                    <span class="prod-cat">Designer Lehenga</span>
                    <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.8</span>
                  </div>
                  <h5 class="prod-name">
                    <a href="product-detail.html">Embroidered Designer Lehenga Set</a>
                  </h5>
                  <div class="prod-price">
                    <span class="price-now">₹18,999</span><del class="price-old">₹26,999</del><span class="price-off">30%
                      OFF</span>
                  </div>
                  <div class="prod-btns">
                    <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                      Add to Cart
                    </button>
                    <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="prod_cart">
                <div class="prod-img">
                  <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                      alt="Heavy Zardozi Bridal Lehenga" loading="lazy" /></a>
                  <div class="prod-actions">
                    <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="prod-info">
                  <div class="prod-meta">
                    <span class="prod-cat">Bridal Lehenga</span>
                    <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                  </div>
                  <h5 class="prod-name">
                    <a href="product-detail.html">Heavy Zardozi Bridal Lehenga</a>
                  </h5>
                  <div class="prod-price">
                    <span class="price-now">₹42,999</span><del class="price-old">₹59,999</del><span class="price-off">28%
                      OFF</span>
                  </div>
                  <div class="prod-btns">
                    <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                      Add to Cart
                    </button>
                    <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="prod_cart">
                <div class="prod-img">
                  <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab4.png"
                      alt="Organza Embroidered Party Saree" loading="lazy" /></a>
                  <div class="prod-actions">
                    <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="prod-info">
                  <div class="prod-meta">
                    <span class="prod-cat">Organza Saree</span>
                    <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.7</span>
                  </div>
                  <h5 class="prod-name">
                    <a href="product-detail.html">Organza Embroidered Party Saree</a>
                  </h5>
                  <div class="prod-price">
                    <span class="price-now">₹6,299</span><del class="price-old">₹8,999</del><span class="price-off">30%
                      OFF</span>
                  </div>
                  <div class="prod-btns">
                    <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                      Add to Cart
                    </button>
                    <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="prod_cart">
                <div class="prod-img">
                  <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                      alt="Kanjivaram Pure Silk Saree" loading="lazy" /></a>
                  <div class="prod-actions">
                    <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="prod-info">
                  <div class="prod-meta">
                    <span class="prod-cat">Silk Saree</span>
                    <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.9</span>
                  </div>
                  <h5 class="prod-name">
                    <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                  </h5>
                  <div class="prod-price">
                    <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span class="price-off">26%
                      OFF</span>
                  </div>
                  <div class="prod-btns">
                    <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                      Add to Cart
                    </button>
                    <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="prod_cart">
                <div class="prod-img">
                  <a href="product-detail.html" class="prod-link"><img
                      src="https://images.unsplash.com/photo-1654764746225-e63f5e90facd?auto=format&fit=crop&w=600&h=800&q=80"
                      alt="Velvet Sequin Sangeet Lehenga" loading="lazy" /></a>
                  <div class="prod-actions">
                    <button type="button" class="act-btn wish-btn" aria-label="Wishlist">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <button type="button" class="act-btn quick-btn" aria-label="Quick view">
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="prod-info">
                  <div class="prod-meta">
                    <span class="prod-cat">Party Wear Lehenga</span>
                    <span class="prod-rate"><i class="fa-solid fa-star"></i> 4.6</span>
                  </div>
                  <h5 class="prod-name">
                    <a href="product-detail.html">Velvet Sequin Sangeet Lehenga</a>
                  </h5>
                  <div class="prod-price">
                    <span class="price-now">₹14,499</span><del class="price-old">₹19,999</del><span class="price-off">28%
                      OFF</span>
                  </div>
                  <div class="prod-btns">
                    <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">
                      Add to Cart
                    </button>
                    <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                  </div>
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

  <section class="home-secM">
    <div class="container">
      <div class="story-grid">
        <div class="story-visual">
          <div class="story-main">
            <img src="assets/images/home/ower1.jpeg" alt="Archana Saree Emporium store" loading="lazy" />
          </div>
          <div class="story-small">
            <img src="assets/images/home/ower2.jpeg" alt="Fabric and craftsmanship" loading="lazy" />
          </div>
          <span class="story-tag">Inspired by Delhi</span>
        </div>
        <div class="story-content">
          <span class="eyebrow">Our Story</span>
          <div class="heading">
            <h3>Rooted in Tradition. Styled for Today.</h3>
          </div>
          <p>
            Archana Saree Emporium brings together the richness of Indian
            occasion wear with a modern eye for elegance. From timeless
            sarees and statement lehengas to exquisite bridal ensembles, our
            collections are curated for celebrations that deserve something
            truly special.
          </p>
          <p>
            Inspired by the timeless charm of Delhi's celebrated fashion
            heritage, Archana Saree Emporium is a destination for those who
            appreciate beautiful craftsmanship, distinctive styles and the
            enduring elegance of Indian dressing.
          </p>
          <a href="about.html" class="btn btn-primary">Discover Our Story <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
      </div>
      <div class="founder">
        <div class="founder-photo">
          <img src="assets/images/home/ower1.jpeg" alt="Owner of Archana Saree Emporium" loading="lazy" />
        </div>
        <div class="founder-info">
          <span class="founder-label">Meet the Founder</span>
          <h4>Owner Name</h4>
          <span class="founder-role">Founder, Archana Saree Emporium</span>
          <p>
            A short, personal line from the owner, written in their own
            voice, welcoming customers to the store they have known for
            years.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="home-secS">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Style in Motion</span>
        <div class="heading">
          <h3>See the Look. Feel the Moment.</h3>
        </div>
        <p>
          Discover styling inspiration, new arrivals and occasion-ready
          looks from Archana Saree Emporium.
        </p>
      </div>
      <div class="swiper-wrap">
        <div class="swiper fourSlider">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="reel-card">
                <img src="assets/images/home/reel1.jpeg" alt="New Arrival reel" loading="lazy" /><span class="reel-tag"><i
                    class="fa-solid fa-clapperboard"></i></span>
                <div class="content-wrap">
                  <div class="reel-text">
                    <h4>New Arrival</h4>
                    <p>Fresh drops, just in.</p>
                  </div>
                  <button type="button" class="play-btn" aria-label="Play New Arrival reel">
                    <i class="fa-solid fa-play"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="reel-card">
                <img src="assets/images/home/reel2.jpeg" alt="Bridal Edit reel" loading="lazy" /><span class="reel-tag"><i
                    class="fa-solid fa-clapperboard"></i></span>
                <div class="content-wrap">
                  <div class="reel-text">
                    <h4>Bridal Edit</h4>
                    <p>Made for the big day.</p>
                  </div>
                  <button type="button" class="play-btn" aria-label="Play Bridal Edit reel">
                    <i class="fa-solid fa-play"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="reel-card">
                <img src="assets/images/home/reel3.jpeg" alt="Saree Styling reel" loading="lazy" /><span
                  class="reel-tag"><i class="fa-solid fa-clapperboard"></i></span>
                <div class="content-wrap">
                  <div class="reel-text">
                    <h4>Saree Styling</h4>
                    <p>Drapes, pleats and more.</p>
                  </div>
                  <button type="button" class="play-btn" aria-label="Play Saree Styling reel">
                    <i class="fa-solid fa-play"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="reel-card">
                <img src="assets/images/home/reel4.jpeg" alt="Festive Look reel" loading="lazy" /><span
                  class="reel-tag"><i class="fa-solid fa-clapperboard"></i></span>
                <div class="content-wrap">
                  <div class="reel-text">
                    <h4>Festive Look</h4>
                    <p>Dressed for the season.</p>
                  </div>
                  <button type="button" class="play-btn" aria-label="Play Festive Look reel">
                    <i class="fa-solid fa-play"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="reel-card">
                <img src="assets/images/home/reel5.jpeg" alt="Wedding Inspiration reel" loading="lazy" /><span
                  class="reel-tag"><i class="fa-solid fa-clapperboard"></i></span>
                <div class="content-wrap">
                  <div class="reel-text">
                    <h4>Wedding Inspiration</h4>
                    <p>Ideas for every ceremony.</p>
                  </div>
                  <button type="button" class="play-btn" aria-label="Play Wedding Inspiration reel">
                    <i class="fa-solid fa-play"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="reel-card">
                <img src="assets/images/home/reel6.jpeg" alt="Behind the Collection reel" loading="lazy" /><span
                  class="reel-tag"><i class="fa-solid fa-clapperboard"></i></span>
                <div class="content-wrap">
                  <div class="reel-text">
                    <h4>Behind the Collection</h4>
                    <p>Where every piece begins.</p>
                  </div>
                  <button type="button" class="play-btn" aria-label="Play Behind the Collection reel">
                    <i class="fa-solid fa-play"></i>
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
      <div class="sec-cta">
        <a href="javascript:void()" class="btn btn-primary">Follow Our Journey <i
            class="fa-solid fa-arrow-right-long"></i></a>
      </div>
    </div>
  </section>

  <section class="home-secN">
    <div class="container">
      <div class="sec-head">
        <span class="eyebrow">Customer Love</span>
        <div class="heading">
          <h3>Loved by Women Who Celebrate in Style</h3>
        </div>
        <p>
          Beautiful words from customers who found something special at
          Archana Saree Emporium.
        </p>
      </div>
      <div class="swiper-wrap">
        <div class="swiper fourSlider" data-mob="1.15">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="review-card">
                <div class="review-head">
                  <div class="review-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                      class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <i class="fa-solid fa-quote-right review-quote"></i>
                </div>
                <p class="review-text">
                  The saree was even more beautiful in person. The
                  detailing, finish and overall look were absolutely lovely.
                </p>
                <div class="review-by">
                  <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Priya Sharma" loading="lazy" />
                  <div>
                    <h5>Priya Sharma</h5>
                    <span>Verified Customer</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="review-card">
                <div class="review-head">
                  <div class="review-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                      class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <i class="fa-solid fa-quote-right review-quote"></i>
                </div>
                <p class="review-text">
                  I ordered my sangeet lehenga here and received compliments
                  all evening. The embroidery is fine and the fit was
                  perfect.
                </p>
                <div class="review-by">
                  <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Neha Kapoor" loading="lazy" />
                  <div>
                    <h5>Neha Kapoor</h5>
                    <span>Verified Customer</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="review-card">
                <div class="review-head">
                  <div class="review-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                      class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <i class="fa-solid fa-quote-right review-quote"></i>
                </div>
                <p class="review-text">
                  My bridal outfit felt truly special. The team helped me
                  choose every detail and it arrived well before the
                  wedding.
                </p>
                <div class="review-by">
                  <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Ananya Verma" loading="lazy" />
                  <div>
                    <h5>Ananya Verma</h5>
                    <span>Verified Customer</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="review-card">
                <div class="review-head">
                  <div class="review-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                      class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <i class="fa-solid fa-quote-right review-quote"></i>
                </div>
                <p class="review-text">
                  The organza saree is light, graceful and exactly like the
                  photos. The packaging was neat and delivery was quick.
                </p>
                <div class="review-by">
                  <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Ritu Malhotra" loading="lazy" />
                  <div>
                    <h5>Ritu Malhotra</h5>
                    <span>Verified Customer</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="review-card">
                <div class="review-head">
                  <div class="review-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                      class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <i class="fa-solid fa-quote-right review-quote"></i>
                </div>
                <p class="review-text">
                  I have shopped here for years and the quality never
                  changes. This time I found a gorgeous silk saree for
                  Diwali.
                </p>
                <div class="review-by">
                  <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Simran Arora" loading="lazy" />
                  <div>
                    <h5>Simran Arora</h5>
                    <span>Verified Customer</span>
                  </div>
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

  <section class="home-secO">
    <div class="container">
      <div class="news-wrap">
        <div class="news-photo">
          <img src="assets/images/home/offer1.jpg" alt="Archana Saree Emporium new arrivals" loading="lazy" />
        </div>
        <div class="news-panel">
          <span class="eyebrow">Stay in the Know</span>
          <div class="heading">
            <h3>Be the First to Discover What's New</h3>
          </div>
          <p class="news-desc">
            Sign up for new arrivals, curated collections, styling
            inspiration and exclusive offers from Archana Saree Emporium.
          </p>
          <form class="form news-form" action="#" method="post">
            <div class="form-group">
              <input type="email" id="newsEmail" name="email" placeholder=" " required />
              <label for="newsEmail">Enter your email address</label>
            </div>
            <button type="submit" class="btn btn-black">
              Subscribe <i class="fa-solid fa-arrow-right-long"></i>
            </button>
          </form>
          <p class="news-note">
            By subscribing, you agree to receive updates and offers from
            Archana Saree Emporium.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="home-secP">
    <div class="container">
      <div class="collect-wrap">
        <div class="collect-intro">
          <span class="eyebrow">All Collections</span>
          <div class="heading">
            <h3>Explore Archana Saree Emporium</h3>
          </div>
          <p class="collect-desc">
            Discover our complete range of Indian occasion wear, from
            timeless sarees and designer lehengas to bridal and wedding
            collections.
          </p>
          <ul class="collect-stats">
            <li><b>04</b><span>Collections</span></li>
            <li><b>28</b><span>Styles</span></li>
          </ul>
          <a href="javascript:void()" class="btn btn-primary">Shop All Collections
            <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
        <div class="collect-grid">
          <div class="collect-group">
            <div class="collect-head">
              <div class="collect-title">
                <span class="collect-ico"><i class="fa-solid fa-scroll"></i></span>
                <h4>Sarees</h4>
              </div>
              <span class="collect-count">09 Styles</span>
            </div>
            <ul class="collect-links">
              <li><a href="javascript:void()">Premium Sarees</a></li>
              <li><a href="javascript:void()">Designer Sarees</a></li>
              <li><a href="javascript:void()">Banarasi Sarees</a></li>
              <li><a href="javascript:void()">Silk Sarees</a></li>
              <li><a href="javascript:void()">Organza Sarees</a></li>
              <li><a href="javascript:void()">Georgette Sarees</a></li>
              <li><a href="javascript:void()">Embroidered Sarees</a></li>
              <li><a href="javascript:void()">Party Wear Sarees</a></li>
              <li><a href="javascript:void()">Festive Sarees</a></li>
            </ul>
          </div>
          <div class="collect-group">
            <div class="collect-head">
              <div class="collect-title">
                <span class="collect-ico"><i class="fa-solid fa-gem"></i></span>
                <h4>Lehengas</h4>
              </div>
              <span class="collect-count">07 Styles</span>
            </div>
            <ul class="collect-links">
              <li><a href="javascript:void()">Bridal Lehengas</a></li>
              <li><a href="javascript:void()">Designer Lehengas</a></li>
              <li><a href="javascript:void()">Wedding Lehengas</a></li>
              <li><a href="javascript:void()">Reception Lehengas</a></li>
              <li><a href="javascript:void()">Engagement Lehengas</a></li>
              <li><a href="javascript:void()">Party Wear Lehengas</a></li>
              <li><a href="javascript:void()">Festive Lehengas</a></li>
            </ul>
          </div>
          <div class="collect-group">
            <div class="collect-head">
              <div class="collect-title">
                <span class="collect-ico"><i class="fa-solid fa-ring"></i></span>
                <h4>Bridal Wear</h4>
              </div>
              <span class="collect-count">06 Styles</span>
            </div>
            <ul class="collect-links">
              <li><a href="javascript:void()">Bridal Sarees</a></li>
              <li><a href="javascript:void()">Bridal Lehengas</a></li>
              <li><a href="javascript:void()">Wedding Wear</a></li>
              <li><a href="javascript:void()">Reception Wear</a></li>
              <li><a href="javascript:void()">Engagement Wear</a></li>
              <li><a href="javascript:void()">Bridesmaid Wear</a></li>
            </ul>
          </div>
          <div class="collect-group">
            <div class="collect-head">
              <div class="collect-title">
                <span class="collect-ico"><i class="fa-solid fa-champagne-glasses"></i></span>
                <h4>Occasions</h4>
              </div>
              <span class="collect-count">06 Styles</span>
            </div>
            <ul class="collect-links">
              <li><a href="javascript:void()">Wedding</a></li>
              <li><a href="javascript:void()">Reception</a></li>
              <li><a href="javascript:void()">Engagement</a></li>
              <li><a href="javascript:void()">Festive</a></li>
              <li><a href="javascript:void()">Party</a></li>
              <li><a href="javascript:void()">Traditional</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>




@endsection