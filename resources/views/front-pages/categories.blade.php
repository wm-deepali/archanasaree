@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/listing/listing.css') }}" />
@endpush

@section('content')

    <main>
      <section class="product-banner">
        <div class="banner-img">
          <img src="assets/images/home/banner2.png" alt="Sarees" />
        </div>
        <div class="container">
          <ul class="crumb">
            <li><a href="index.html">Home</a></li>
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
            <a href="javascript:void()" class="btn btn-primary">Shop Sarees</a>
          </div>
        </div>
      </section>

      <section class="product-secB">
        <div class="container">
          <ul class="tab-nav">
            <li data-tab="1" class="active">All Sarees</li>
            <li data-tab="2">Banarasi</li>
            <li data-tab="3">Silk Sarees</li>
            <li data-tab="4">Organza</li>
            <li data-tab="5">Georgette</li>
            <li data-tab="6">Party Wear</li>
            <li data-tab="7">Bridal Sarees</li>
            <li data-tab="8">Designer Sarees</li>
          </ul>

          <div class="tab-nav-content">
            <!-- ========== TAB 1 : All Sarees ========== -->
            <div class="tabs active" data-tab="1">
              <div class="prod-head">
                <h3>The Saree Collection</h3>
                <span class="prod-styles">48 styles</span>
              </div>

              <div class="prod-toolbar">
                <p class="prod-count"><b>48</b> Sarees</p>
                <div class="prod-tools">
                  <button
                    type="button"
                    class="tool-btn filter-btn"
                    data-model=".filter-pop"
                  >
                    <i class="fa-solid fa-sliders"></i> Filter
                  </button>
                  <button
                    type="button"
                    class="tool-btn sort-btn"
                    data-model="sort-pop"
                  >
                    <i class="fa-solid fa-arrow-down-wide-short"></i> Sort
                  </button>
                  <div class="prod-sort">
                    <label for="prodSort1">Sort By</label>
                    <div class="sort-box">
                      <select id="prodSort1">
                        <option value="recommended">Recommended</option>
                        <option value="newest">New Arrivals</option>
                        <option value="sold">Best Selling</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="rating">Customer Rating</option>
                      </select>
                      <i class="fa-solid fa-chevron-down"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="prod-grid">
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab1.png"
                        alt="Kanjivaram Pure Silk Saree"
                        loading="lazy"
                    /></a>
                    <span class="prod-badge">Bestseller</span>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Silk Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.9</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Kanjivaram Pure Silk Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹12,999</span
                      ><del class="price-old">₹17,499</del
                      ><span class="price-off">26% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab2.png"
                        alt="Zari Woven Banarasi Silk Saree"
                        loading="lazy"
                    /></a>
                    <span class="prod-badge">Bestseller</span>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Banarasi Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.8</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Zari Woven Banarasi Silk Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹8,499</span
                      ><del class="price-old">₹11,999</del
                      ><span class="price-off">29% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab3.png"
                        alt="Handcrafted Organza Saree"
                        loading="lazy"
                    /></a>
                    <span class="prod-badge">New Arrival</span>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Organza Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.7</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Handcrafted Organza Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹6,799</span
                      ><del class="price-old">₹9,499</del
                      ><span class="price-off">28% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab4.png"
                        alt="Royal Maroon Banarasi Saree"
                        loading="lazy"
                    /></a>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Banarasi Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.8</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Royal Maroon Banarasi Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹9,999</span
                      ><del class="price-old">₹13,999</del
                      ><span class="price-off">29% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab1.png"
                        alt="Emerald Green Designer Silk Saree"
                        loading="lazy"
                    /></a>
                    <span class="prod-badge">Limited Edit</span>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Designer Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.7</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Emerald Green Designer Silk Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹14,499</span
                      ><del class="price-old">₹19,999</del
                      ><span class="price-off">28% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab2.png"
                        alt="Pastel Pink Organza Saree"
                        loading="lazy"
                    /></a>
                    <span class="prod-badge">New Arrival</span>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Organza Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.6</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Pastel Pink Organza Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹5,499</span
                      ><del class="price-old">₹7,499</del
                      ><span class="price-off">27% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab3.png"
                        alt="Wine Embroidered Party Saree"
                        loading="lazy"
                    /></a>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Party Wear Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.6</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Wine Embroidered Party Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹7,299</span
                      ><del class="price-old">₹9,999</del
                      ><span class="price-off">27% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab4.png"
                        alt="Ivory Zari Work Saree"
                        loading="lazy"
                    /></a>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Silk Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.7</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html">Ivory Zari Work Saree</a>
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹11,499</span
                      ><del class="price-old">₹15,999</del
                      ><span class="price-off">28% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="load-more">
                <button type="button" class="btn btn-outline-primary">
                  Load More Sarees
                </button>
                <p>Showing 12 of 48 styles</p>
              </div>
            </div>

            <!-- ========== TAB 2 : Banarasi (same structure as Tab 1) ========== -->
            <div class="tabs" data-tab="2">
              <div class="prod-head">
                <h3>The Saree Collection</h3>
                <span class="prod-styles">2 styles</span>
              </div>

              <div class="prod-toolbar">
                <p class="prod-count"><b>2</b> Sarees</p>
                <div class="prod-tools">
                  <button
                    type="button"
                    class="tool-btn filter-btn"
                    data-model="filter-pop"
                  >
                    <i class="fa-solid fa-sliders"></i> Filter
                  </button>
                  <button
                    type="button"
                    class="tool-btn sort-btn"
                    data-model="sort-pop"
                  >
                    <i class="fa-solid fa-arrow-down-wide-short"></i> Sort
                  </button>
                  <div class="prod-sort">
                    <label for="prodSort2">Sort By</label>
                    <div class="sort-box">
                      <select id="prodSort2">
                        <option value="recommended">Recommended</option>
                        <option value="newest">New Arrivals</option>
                        <option value="sold">Best Selling</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="rating">Customer Rating</option>
                      </select>
                      <i class="fa-solid fa-chevron-down"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="prod-grid">
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab2.png"
                        alt="Zari Woven Banarasi Silk Saree"
                        loading="lazy"
                    /></a>
                    <span class="prod-badge">Bestseller</span>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Banarasi Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.8</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Zari Woven Banarasi Silk Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹8,499</span
                      ><del class="price-old">₹11,999</del
                      ><span class="price-off">29% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
                <div class="prod_cart">
                  <div class="prod-img">
                    <a href="product-detail.html" class="prod-link"
                      ><img
                        src="assets/images/home/tab4.png"
                        alt="Royal Maroon Banarasi Saree"
                        loading="lazy"
                    /></a>
                    <div class="prod-actions">
                      <button
                        type="button"
                        class="act-btn wish-btn"
                        aria-label="Wishlist"
                      >
                        <i class="fa-regular fa-heart"></i>
                      </button>
                      <button
                        type="button"
                        class="act-btn quick-btn"
                        aria-label="Quick view"
                      >
                        <i class="fa-regular fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="prod-info">
                    <div class="prod-meta">
                      <span class="prod-cat">Banarasi Saree</span
                      ><span class="prod-rate"
                        ><i class="fa-solid fa-star"></i> 4.8</span
                      >
                    </div>
                    <h5 class="prod-name">
                      <a href="product-detail.html"
                        >Royal Maroon Banarasi Saree</a
                      >
                    </h5>
                    <div class="prod-price">
                      <span class="price-now">₹9,999</span
                      ><del class="price-old">₹13,999</del
                      ><span class="price-off">29% OFF</span>
                    </div>
                    <div class="prod-btns">
                      <button
                        data-model=".cart-pop"
                        type="button"
                        class="btn btn-outline-primary prod-cta"
                      >
                        Add to Cart
                      </button>
                      <a
                        href="product-detail.html"
                        class="btn btn-primary prod-cta"
                        >Buy Now</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 3 to 8 : same markup as Tab 1 (heading + toolbar + grid + load more) -->
            <div class="tabs" data-tab="3"></div>
            <div class="tabs" data-tab="4"></div>
            <div class="tabs" data-tab="5"></div>
            <div class="tabs" data-tab="6"></div>
            <div class="tabs" data-tab="7"></div>
            <div class="tabs" data-tab="8"></div>
          </div>
        </div>
      </section>

      <section class="product-secC">
        <div class="container">
          <div class="art-grid">
            <div class="art-visual">
              <div class="art-photo">
                <img
                  src="assets/images/home/banner5.jpg"
                  alt="The Art of the Saree"
                  loading="lazy"
                />
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
              <a href="javascript:void()" class="btn btn-primary"
                >Explore the Collection
                <i class="fa-solid fa-arrow-right-long"></i
              ></a>
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
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab1.png"
                          alt="Kanjivaram Pure Silk Saree"
                          loading="lazy"
                      /></a>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.9</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Kanjivaram Pure Silk Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹12,999</span
                        ><del class="price-old">₹17,499</del
                        ><span class="price-off">26% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab2.png"
                          alt="Zari Woven Banarasi Silk Saree"
                          loading="lazy"
                      /></a>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Banarasi Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.8</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Zari Woven Banarasi Silk Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹8,499</span
                        ><del class="price-old">₹11,999</del
                        ><span class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab4.png"
                          alt="Royal Maroon Banarasi Saree"
                          loading="lazy"
                      /></a>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Banarasi Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.8</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Royal Maroon Banarasi Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹9,999</span
                        ><del class="price-old">₹13,999</del
                        ><span class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab2.png"
                          alt="Pastel Pink Organza Saree"
                          loading="lazy"
                      /></a>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Organza Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.6</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Pastel Pink Organza Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹5,499</span
                        ><del class="price-old">₹7,499</del
                        ><span class="price-off">27% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab4.png"
                          alt="Ivory Zari Work Saree"
                          loading="lazy"
                      /></a>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.7</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html">Ivory Zari Work Saree</a>
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹11,499</span
                        ><del class="price-old">₹15,999</del
                        ><span class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-group">
              <button
                type="button"
                class="btn-prev"
                aria-label="Previous slide"
              >
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
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab1.png"
                          alt="Emerald Green Designer Silk Saree"
                          loading="lazy"
                      /></a>
                      <span class="prod-badge">Limited Edit</span>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Designer Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.7</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Emerald Green Designer Silk Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹14,499</span
                        ><del class="price-old">₹19,999</del
                        ><span class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab3.png"
                          alt="Wine Embroidered Party Saree"
                          loading="lazy"
                      /></a>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Party Wear Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.6</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Wine Embroidered Party Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹7,299</span
                        ><del class="price-old">₹9,999</del
                        ><span class="price-off">27% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab4.png"
                          alt="Handcrafted Organza Saree"
                          loading="lazy"
                      /></a>
                      <span class="prod-badge">New Arrival</span>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Organza Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.7</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Handcrafted Organza Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹6,799</span
                        ><del class="price-old">₹9,499</del
                        ><span class="price-off">28% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab1.png"
                          alt="Kanjivaram Pure Silk Saree"
                          loading="lazy"
                      /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Silk Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.9</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Kanjivaram Pure Silk Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹12,999</span
                        ><del class="price-old">₹17,499</del
                        ><span class="price-off">26% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="prod_cart">
                    <div class="prod-img">
                      <a href="product-detail.html" class="prod-link"
                        ><img
                          src="assets/images/home/tab2.png"
                          alt="Zari Woven Banarasi Silk Saree"
                          loading="lazy"
                      /></a>
                      <span class="prod-badge">Bestseller</span>
                      <div class="prod-actions">
                        <button
                          type="button"
                          class="act-btn wish-btn"
                          aria-label="Wishlist"
                        >
                          <i class="fa-regular fa-heart"></i>
                        </button>
                        <button
                          type="button"
                          class="act-btn quick-btn"
                          aria-label="Quick view"
                        >
                          <i class="fa-regular fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="prod-info">
                      <div class="prod-meta">
                        <span class="prod-cat">Banarasi Saree</span
                        ><span class="prod-rate"
                          ><i class="fa-solid fa-star"></i> 4.8</span
                        >
                      </div>
                      <h5 class="prod-name">
                        <a href="product-detail.html"
                          >Zari Woven Banarasi Silk Saree</a
                        >
                      </h5>
                      <div class="prod-price">
                        <span class="price-now">₹8,499</span
                        ><del class="price-old">₹11,999</del
                        ><span class="price-off">29% OFF</span>
                      </div>
                      <div class="prod-btns">
                        <button
                          data-model=".cart-pop"
                          type="button"
                          class="btn btn-outline-primary prod-cta"
                        >
                          Add to Cart
                        </button>
                        <a
                          href="product-detail.html"
                          class="btn btn-primary prod-cta"
                          >Buy Now</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-group">
              <button
                type="button"
                class="btn-prev"
                aria-label="Previous slide"
              >
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
              <img
                src="assets/images/home/offer1.jpg"
                alt="Stay in the Archana Edit"
                loading="lazy"
              />
            </div>
            <div class="news-panel">
              <div class="heading"><h3>Stay in the Archana Edit</h3></div>
              <p class="news-desc">
                Be the first to discover new arrivals, festive edits and
                exclusive collections.
              </p>
              <form class="form news-form" action="#" method="post">
                <div class="form-group">
                  <input
                    type="email"
                    id="catNewsEmail"
                    name="email"
                    placeholder=" "
                    required
                  />
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
    </main>

    
    <div class="model filter-pop">
      <button type="button" class="close" aria-label="Close filter">
        <svg
          width="26"
          height="26"
          viewBox="0 0 26 26"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </button>
      <div class="model-body">
        <div class="title">
          <h4>Filter By</h4>
        </div>

        <div class="f-groups">
          <details class="f-group" open>
            <summary>
              Saree Type <i class="fa-solid fa-chevron-down"></i>
            </summary>
            <ul class="f-list">
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="banarasi" />
                  Banarasi</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="kanjivaram" />
                  Kanjivaram</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="organza" />
                  Organza</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="georgette" />
                  Georgette</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="silk" />
                  Silk</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="chiffon" />
                  Chiffon</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="SareeType" value="net" />
                  Net</label
                >
              </li>
            </ul>
          </details>

          <details class="f-group">
            <summary>Occasion <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              <li>
                <label
                  ><input type="checkbox" name="Occasion" value="wedding" />
                  Wedding</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Occasion" value="bridal" />
                  Bridal</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Occasion" value="festive" />
                  Festive</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Occasion" value="party" />
                  Party</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Occasion" value="reception" />
                  Reception</label
                >
              </li>
            </ul>
          </details>

          <details class="f-group">
            <summary>Colour <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="red" />
                  Red</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="maroon" />
                  Maroon</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="pink" />
                  Pink</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="green" />
                  Green</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="blue" />
                  Blue</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="wine" />
                  Wine</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="gold" />
                  Gold</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="ivory" />
                  Ivory</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Colour" value="beige" />
                  Beige</label
                >
              </li>
            </ul>
          </details>

          <details class="f-group">
            <summary>Price <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              <li>
                <label
                  ><input type="checkbox" name="Price" value="0-5000" /> Under
                  ₹5,000</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Price" value="5000-10000" />
                  ₹5,000 – ₹10,000</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Price" value="10000-15000" />
                  ₹10,000 – ₹15,000</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Price" value="15000-25000" />
                  ₹15,000 – ₹25,000</label
                >
              </li>
              <li>
                <label
                  ><input type="checkbox" name="Price" value="25000+" /> Above
                  ₹25,000</label
                >
              </li>
            </ul>
          </details>
        </div>

        <div class="f-foot">
          <button type="button" class="btn btn-outline-primary">
            Clear All
          </button>
          <button type="button" class="btn btn-primary">Apply Filters</button>
        </div>
      </div>
    </div>

    <div class="model sort-pop">
      <button type="button" class="close" aria-label="Close sort">
        <svg
          width="26"
          height="26"
          viewBox="0 0 26 26"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </button>
      <div class="model-body">
        <div class="title">
          <h4>Sort By</h4>
        </div>
        <ul class="sort-list">
          <li>
            <label
              ><input type="radio" name="SortBy" value="recommended" checked />
              Recommended</label
            >
          </li>
          <li>
            <label
              ><input type="radio" name="SortBy" value="newest" /> New
              Arrivals</label
            >
          </li>
          <li>
            <label
              ><input type="radio" name="SortBy" value="sold" /> Best
              Selling</label
            >
          </li>
          <li>
            <label
              ><input type="radio" name="SortBy" value="low" /> Price: Low to
              High</label
            >
          </li>
          <li>
            <label
              ><input type="radio" name="SortBy" value="high" /> Price: High to
              Low</label
            >
          </li>
          <li>
            <label
              ><input type="radio" name="SortBy" value="rating" /> Customer
              Rating</label
            >
          </li>
        </ul>
      </div>
    </div>

@endsection