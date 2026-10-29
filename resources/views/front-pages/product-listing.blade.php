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
                    <li><a href="index.html">Home</a></li>
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

        <!-- ========== 3. LISTING ========== -->
        <section class="listing-main" id="listingMain">
            <div class="container">
                <input type="checkbox" id="filterToggle" class="filter-toggle" hidden />

                <!-- Toolbar -->
                <div class="listing-toolbar">
                    <p class="listing-count">
                        Showing <b>1–24</b> of <b>128</b> products
                    </p>
                    <div class="listing-tools">
                        <label for="filterToggle" class="tool-btn"><i class="fa-solid fa-sliders"></i> Filter</label>
                        <div class="view-switch" aria-label="Grid view">
                            <button type="button" class="view-btn" data-cols="3" aria-label="3 columns">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </button>
                            <button type="button" class="view-btn active" data-cols="4" aria-label="4 columns">
                                <i class="fa-solid fa-table-cells"></i>
                            </button>
                        </div>
                        <div class="listing-sort">
                            <label for="listingSort">Sort By</label>
                            <div class="sort-box">
                                <select id="listingSort" name="sort">
                                    <option value="recommended">Recommended</option>
                                    <option value="newest">Newest Arrivals</option>
                                    <option value="sold">Best Selling</option>
                                    <option value="low">Price: Low to High</option>
                                    <option value="high">Price: High to Low</option>
                                </select>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="listing-layout">
                    <label for="filterToggle" class="filter-overlay" aria-hidden="true"></label>

                    <!-- ===== FILTER ===== -->
                    <form class="listing-filter" id="filterPanel" action="#" method="get" aria-label="Product filters">
                        <div class="f-head">
                            <div class="f-ttl">
                                <span class="f-icon"><i class="fa-solid fa-sliders"></i></span>
                                <h4>Filter By</h4>
                            </div>
                            <button type="reset" class="f-clear">Clear All</button>
                            <label for="filterToggle" class="f-close" aria-label="Close filters"><i
                                    class="fa-solid fa-xmark"></i></label>
                        </div>

                        <div class="f-scroll">
                            <details class="f-group" open>
                                <summary>Category</summary>
                                <div class="f-body f-chips">
                                    <label class="f-chip"><input type="checkbox" name="category"
                                            value="sarees" /><span>Sarees</span></label>
                                    <label class="f-chip"><input type="checkbox" name="category"
                                            value="lehengas" /><span>Lehengas</span></label>
                                    <label class="f-chip"><input type="checkbox" name="category"
                                            value="bridal-wear" /><span>Bridal Wear</span></label>
                                    <label class="f-chip"><input type="checkbox" name="category"
                                            value="party-wear" /><span>Party Wear</span></label>
                                    <label class="f-chip"><input type="checkbox" name="category"
                                            value="festive-wear" /><span>Festive Wear</span></label>
                                </div>
                            </details>

                            <details class="f-group" open>
                                <summary>Price</summary>
                                <div class="f-body">
                                    <div class="price-range" data-min="1000" data-max="50000">
                                        <div class="range-track">
                                            <span class="range-fill"></span>
                                        </div>
                                        <input type="range" class="range-min" min="1000" max="50000" step="500" value="1000"
                                            aria-label="Minimum price" />
                                        <input type="range" class="range-max" min="1000" max="50000" step="500"
                                            value="50000" aria-label="Maximum price" />
                                    </div>
                                    <div class="price-inputs">
                                        <label><span>Min</span><b>₹</b><input type="number" name="price_min" class="in-min"
                                                value="1000" min="1000" max="50000" step="500" /></label>
                                        <i class="price-dash"></i>
                                        <label><span>Max</span><b>₹</b><input type="number" name="price_max" class="in-max"
                                                value="50000" min="1000" max="50000" step="500" /></label>
                                    </div>
                                </div>
                            </details>

                            <details class="f-group" open>
                                <summary>Color</summary>
                                <div class="f-body f-swatches">
                                    <label class="f-swatch" title="Red"><input type="checkbox" name="color"
                                            value="red" /><span style="--c: #b3203c"></span></label>
                                    <label class="f-swatch" title="Wine"><input type="checkbox" name="color"
                                            value="wine" /><span style="--c: #5e1a33"></span></label>
                                    <label class="f-swatch" title="Pink"><input type="checkbox" name="color"
                                            value="pink" /><span style="--c: #e79aa8"></span></label>
                                    <label class="f-swatch" title="Blush"><input type="checkbox" name="color"
                                            value="blush" /><span style="--c: #f4d6d6"></span></label>
                                    <label class="f-swatch" title="Maroon"><input type="checkbox" name="color"
                                            value="maroon" /><span style="--c: #6e1423"></span></label>
                                    <label class="f-swatch" title="Green"><input type="checkbox" name="color"
                                            value="green" /><span style="--c: #1f6b4f"></span></label>
                                    <label class="f-swatch" title="Blue"><input type="checkbox" name="color"
                                            value="blue" /><span style="--c: #2b3a7a"></span></label>
                                    <label class="f-swatch" title="Black"><input type="checkbox" name="color"
                                            value="black" /><span style="--c: #222"></span></label>
                                    <label class="f-swatch" title="Beige"><input type="checkbox" name="color"
                                            value="beige" /><span style="--c: #d9c3a0"></span></label>
                                    <label class="f-swatch" title="Ivory"><input type="checkbox" name="color"
                                            value="ivory" /><span style="--c: #f3ecd9"></span></label>
                                </div>
                            </details>

                            <details class="f-group" open>
                                <summary>Saree Type</summary>
                                <div class="f-body f-list">
                                    <label class="f-check"><input type="checkbox" name="type" value="banarasi" /><span
                                            class="f-box"></span><span class="f-text">Banarasi Silk</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="kanjivaram" /><span
                                            class="f-box"></span><span class="f-text">Kanjivaram Silk</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="organza" /><span
                                            class="f-box"></span><span class="f-text">Organza</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="chiffon" /><span
                                            class="f-box"></span><span class="f-text">Chiffon</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="georgette" /><span
                                            class="f-box"></span><span class="f-text">Georgette</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="chanderi" /><span
                                            class="f-box"></span><span class="f-text">Chanderi</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="net" /><span
                                            class="f-box"></span><span class="f-text">Net Sarees</span></label>
                                    <label class="f-check"><input type="checkbox" name="type" value="cotton" /><span
                                            class="f-box"></span><span class="f-text">Cotton Sarees</span></label>
                                </div>
                            </details>

                            <details class="f-group">
                                <summary>Occasion</summary>
                                <div class="f-body f-chips">
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="wedding" /><span>Wedding</span></label>
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="bridal" /><span>Bridal</span></label>
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="reception" /><span>Reception</span></label>
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="festive" /><span>Festive</span></label>
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="party" /><span>Party</span></label>
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="cocktail" /><span>Cocktail</span></label>
                                    <label class="f-chip"><input type="checkbox" name="occasion"
                                            value="engagement" /><span>Engagement</span></label>
                                </div>
                            </details>

                            <details class="f-group">
                                <summary>Collection</summary>
                                <div class="f-body f-list">
                                    <label class="f-check"><input type="checkbox" name="collection" value="new" /><span
                                            class="f-box"></span><span class="f-text">New Arrivals</span></label>
                                    <label class="f-check"><input type="checkbox" name="collection" value="best" /><span
                                            class="f-box"></span><span class="f-text">Best Sellers</span></label>
                                    <label class="f-check"><input type="checkbox" name="collection" value="featured" /><span
                                            class="f-box"></span><span class="f-text">Featured</span></label>
                                    <label class="f-check"><input type="checkbox" name="collection" value="wedding" /><span
                                            class="f-box"></span><span class="f-text">Wedding
                                            Collection</span></label>
                                    <label class="f-check"><input type="checkbox" name="collection" value="festive" /><span
                                            class="f-box"></span><span class="f-text">Festive
                                            Collection</span></label>
                                </div>
                            </details>

                            <details class="f-group">
                                <summary>Fabric</summary>
                                <div class="f-body f-chips">
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="silk" /><span>Silk</span></label>
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="organza" /><span>Organza</span></label>
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="georgette" /><span>Georgette</span></label>
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="chiffon" /><span>Chiffon</span></label>
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="net" /><span>Net</span></label>
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="cotton" /><span>Cotton</span></label>
                                    <label class="f-chip"><input type="checkbox" name="fabric"
                                            value="chanderi" /><span>Chanderi</span></label>
                                </div>
                            </details>

                            <details class="f-group">
                                <summary>Size</summary>
                                <div class="f-body f-sizes">
                                    <label class="f-size"><input type="checkbox" name="size"
                                            value="xs" /><span>XS</span></label>
                                    <label class="f-size"><input type="checkbox" name="size"
                                            value="s" /><span>S</span></label>
                                    <label class="f-size"><input type="checkbox" name="size"
                                            value="m" /><span>M</span></label>
                                    <label class="f-size"><input type="checkbox" name="size"
                                            value="l" /><span>L</span></label>
                                    <label class="f-size"><input type="checkbox" name="size"
                                            value="xl" /><span>XL</span></label>
                                    <label class="f-size"><input type="checkbox" name="size"
                                            value="xxl" /><span>XXL</span></label>
                                </div>
                            </details>

                            <details class="f-group">
                                <summary>Discount</summary>
                                <div class="f-body f-list">
                                    <label class="f-check"><input type="radio" name="discount" value="10" /><span
                                            class="f-box is-radio"></span><span class="f-text">10% &amp;
                                            Above</span></label>
                                    <label class="f-check"><input type="radio" name="discount" value="20" /><span
                                            class="f-box is-radio"></span><span class="f-text">20% &amp;
                                            Above</span></label>
                                    <label class="f-check"><input type="radio" name="discount" value="30" /><span
                                            class="f-box is-radio"></span><span class="f-text">30% &amp;
                                            Above</span></label>
                                    <label class="f-check"><input type="radio" name="discount" value="40" /><span
                                            class="f-box is-radio"></span><span class="f-text">40% &amp;
                                            Above</span></label>
                                </div>
                            </details>
                        </div>

                        <div class="f-foot">
                            <button type="reset" class="btn btn-outline-primary">
                                Clear All
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Apply Filters
                            </button>
                        </div>
                    </form>

                    <!-- ===== PRODUCTS ===== -->
                    <div class="listing-content">
                        <div class="listing-grid" id="listingGrid">
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
                                        <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.9</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                                            class="price-off">26% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                                            alt="Banarasi Zari Woven Silk Saree" loading="lazy" /></a>
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
                                        <span class="prod-cat">Banarasi Saree</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.8</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Banarasi Zari Woven Silk Saree</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span
                                            class="price-off">29% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                                            alt="Organza Floral Embroidered Saree" loading="lazy" /></a>
                                    <span class="prod-badge">New Arrival</span>
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
                                        <span class="prod-cat">Organza Saree</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.7</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Organza Floral Embroidered Saree</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹6,799</span><del class="price-old">₹9,499</del><span
                                            class="price-off">28% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab4.png"
                                            alt="Handloom Chanderi Silk Saree" loading="lazy" /></a>
                                    <span class="prod-badge">Handcrafted</span>
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
                                        <span class="prod-cat">Chanderi Saree</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.8</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Handloom Chanderi Silk Saree</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹9,999</span><del class="price-old">₹13,999</del><span
                                            class="price-off">29% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab1.png"
                                            alt="Embroidered Designer Lehenga Set" loading="lazy" /></a>
                                    <span class="prod-badge">Limited Edition</span>
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
                                        <span class="prod-cat">Designer Lehenga</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.7</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Embroidered Designer Lehenga Set</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹24,999</span><del class="price-old">₹34,999</del><span
                                            class="price-off">29% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab2.png"
                                            alt="Velvet Bridal Lehenga" loading="lazy" /></a>
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
                                        <span class="prod-cat">Bridal Lehenga</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.9</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Velvet Bridal Lehenga</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹38,999</span><del class="price-old">₹52,999</del><span
                                            class="price-off">26% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab3.png"
                                            alt="Sequined Reception Lehenga" loading="lazy" /></a>
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
                                        <span class="prod-cat">Party Lehenga</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.6</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Sequined Reception Lehenga</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹18,499</span><del class="price-old">₹25,999</del><span
                                            class="price-off">29% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="prod_cart">
                                <div class="prod-img">
                                    <a href="product-detail.html" class="prod-link"><img src="assets/images/home/tab4.png"
                                            alt="Pastel Organza Lehenga" loading="lazy" /></a>
                                    <span class="prod-badge">New Arrival</span>
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
                                        <span class="prod-cat">Organza Lehenga</span><span class="prod-rate"><i
                                                class="fa-solid fa-star"></i> 4.7</span>
                                    </div>
                                    <h5 class="prod-name">
                                        <a href="product-detail.html">Pastel Organza Lehenga</a>
                                    </h5>
                                    <div class="prod-price">
                                        <span class="price-now">₹21,299</span><del class="price-old">₹29,999</del><span
                                            class="price-off">29% OFF</span>
                                    </div>
                                    <div class="prod-btns">
                                        <button data-model=".cart-pop" type="button"
                                            class="btn btn-outline-primary prod-cta">
                                            Add to Cart
                                        </button>
                                        <a href="product-detail.html" class="btn btn-primary prod-cta">Buy Now</a>
                                    </div>
                                </div>
                            </div>

                            <!-- same card copy karke 24 tak / backend loop -->
                        </div>

                        <nav class="listing-pagination" aria-label="Product pages">
                            <a href="javascript:void(0)" class="pg-nav is-disabled" aria-disabled="true"><i
                                    class="fa-solid fa-arrow-left-long"></i> Previous</a>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" class="active" aria-current="page">01</a>
                                </li>
                                <li><a href="javascript:void(0)">02</a></li>
                                <li><a href="javascript:void(0)">03</a></li>
                                <li><a href="javascript:void(0)">04</a></li>
                                <li class="dots">…</li>
                                <li><a href="javascript:void(0)">08</a></li>
                            </ul>
                            <a href="javascript:void(0)" class="pg-nav">Next <i
                                    class="fa-solid fa-arrow-right-long"></i></a>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== 4. RECENTLY VIEWED ========== -->
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
                            <div class="swiper-slide">
                                <div class="prod_cart">
                                    <div class="prod-img">
                                        <a href="product-detail.html" class="prod-link"><img
                                                src="assets/images/home/tab1.png" alt="Kanjivaram Pure Silk Saree"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.9</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                                                class="price-off">26% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab2.png" alt="Banarasi Zari Woven Silk Saree"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Banarasi Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.8</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Banarasi Zari Woven Silk Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span
                                                class="price-off">29% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab4.png" alt="Velvet Bridal Lehenga"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Bridal Lehenga</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.9</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Velvet Bridal Lehenga</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹38,999</span><del class="price-old">₹52,999</del><span
                                                class="price-off">26% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab2.png" alt="Soft Georgette Festive Saree"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Georgette Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.6</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Soft Georgette Festive Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹5,499</span><del class="price-old">₹7,499</del><span
                                                class="price-off">27% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab4.png" alt="Ivory Zari Work Saree"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.7</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Ivory Zari Work Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹11,499</span><del class="price-old">₹15,999</del><span
                                                class="price-off">28% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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

        <!-- ========== 5. YOU MAY ALSO LOVE ========== -->
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
                            <div class="swiper-slide">
                                <div class="prod_cart">
                                    <div class="prod-img">
                                        <a href="product-detail.html" class="prod-link"><img
                                                src="assets/images/home/tab1.png" alt="Emerald Green Designer Silk Saree"
                                                loading="lazy" /></a>
                                        <span class="prod-badge">Limited Edition</span>
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
                                            <span class="prod-cat">Designer Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.7</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Emerald Green Designer Silk Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹14,499</span><del class="price-old">₹19,999</del><span
                                                class="price-off">28% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab3.png" alt="Sequined Reception Lehenga"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Party Lehenga</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.6</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Sequined Reception Lehenga</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹18,499</span><del class="price-old">₹25,999</del><span
                                                class="price-off">29% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab4.png" alt="Pastel Organza Lehenga"
                                                loading="lazy" /></a>
                                        <span class="prod-badge">New Arrival</span>
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
                                            <span class="prod-cat">Organza Lehenga</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.7</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Pastel Organza Lehenga</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹21,299</span><del class="price-old">₹29,999</del><span
                                                class="price-off">29% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab1.png" alt="Kanjivaram Pure Silk Saree"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Silk Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.9</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Kanjivaram Pure Silk Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹12,999</span><del class="price-old">₹17,499</del><span
                                                class="price-off">26% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
                                                src="assets/images/home/tab2.png" alt="Banarasi Zari Woven Silk Saree"
                                                loading="lazy" /></a>
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
                                            <span class="prod-cat">Banarasi Saree</span><span class="prod-rate"><i
                                                    class="fa-solid fa-star"></i> 4.8</span>
                                        </div>
                                        <h5 class="prod-name">
                                            <a href="product-detail.html">Banarasi Zari Woven Silk Saree</a>
                                        </h5>
                                        <div class="prod-price">
                                            <span class="price-now">₹8,499</span><del class="price-old">₹11,999</del><span
                                                class="price-off">29% OFF</span>
                                        </div>
                                        <div class="prod-btns">
                                            <button data-model=".cart-pop" type="button"
                                                class="btn btn-outline-primary prod-cta">
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
            /* Price range */
            const box = document.querySelector(".price-range");
            if (box) {
                const form = box.closest("form");
                const MIN = +box.dataset.min,
                    MAX = +box.dataset.max,
                    GAP = 500;
                const rMin = box.querySelector(".range-min"),
                    rMax = box.querySelector(".range-max");
                const fill = box.querySelector(".range-fill");
                const nMin = form.querySelector(".in-min"),
                    nMax = form.querySelector(".in-max");

                const paint = (src) => {
                    let a = +rMin.value,
                        b = +rMax.value;
                    if (b - a < GAP) {
                        src === "min" ? (a = b - GAP) : (b = a + GAP);
                    }
                    rMin.value = nMin.value = a;
                    rMax.value = nMax.value = b;
                    fill.style.left = ((a - MIN) / (MAX - MIN)) * 100 + "%";
                    fill.style.right = 100 - ((b - MIN) / (MAX - MIN)) * 100 + "%";
                };

                rMin.oninput = () => paint("min");
                rMax.oninput = () => paint("max");
                nMin.onchange = () => {
                    rMin.value = nMin.value;
                    paint("min");
                };
                nMax.onchange = () => {
                    rMax.value = nMax.value;
                    paint("max");
                };
                form.addEventListener("reset", () => setTimeout(paint)); // Clear All
                paint();
            }

            /* Grid view switch */
            const grid = document.getElementById("listingGrid");
            document.querySelectorAll(".view-btn").forEach((btn) => {
                btn.onclick = () => {
                    document
                        .querySelectorAll(".view-btn")
                        .forEach((b) => b.classList.remove("active"));
                    btn.classList.add("active");
                    grid.classList.toggle("is-3", btn.dataset.cols === "3");
                };
            });
        })();
    </script>
@endpush