@extends('layouts.app')

@section('content')

  <main>

    @if ($heroSlides->isNotEmpty())
      <section class="home-banner">
        <div class="swiper singleSlider">
          <div class="swiper-wrapper">
            @foreach ($heroSlides as $slide)
              <div class="swiper-slide {{ $slide->theme === 'white' ? 'theme-white' : '' }}">
                <div class="slide-img">
                  <img src="{{ $slide->image_url }}" alt="{{ strip_tags($slide->title ?: config('app.name')) }}" @if (!$loop->first) loading="lazy" @endif />
                </div>

                @if ($slide->eyebrow || $slide->title || $slide->description || $slide->primary_btn_text || $slide->secondary_btn_text || $slide->note)
                  <div class="container">
                    <div class="slide-content">
                      @if (filled($slide->eyebrow))
                        <span class="hero-eyebrow">{{ $slide->eyebrow }}</span>
                      @endif

                      @if (filled($slide->title))
                        @if ($loop->first)
                          <h1 class="hero-title">{!! nl2br(e($slide->title)) !!}</h1>
                        @else
                          <h2 class="hero-title">{!! nl2br(e($slide->title)) !!}</h2>
                        @endif
                      @endif

                      @if (filled($slide->description))
                        <p class="hero-desc">{{ $slide->description }}</p>
                      @endif

                      @if (filled($slide->primary_btn_text) || filled($slide->secondary_btn_text))
                        <div class="hero-btns">
                          @if (filled($slide->primary_btn_text) && filled($slide->primary_btn_link))
                            <a href="{{ $slide->primary_btn_link }}" class="btn btn-primary">{{ $slide->primary_btn_text }}</a>
                          @endif

                          @if (filled($slide->secondary_btn_text) && filled($slide->secondary_btn_link))
                            <a href="{{ $slide->secondary_btn_link }}"
                              class="btn btn-outline-primary">{{ $slide->secondary_btn_text }}
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 12h18M15 6l6 6-6 6" />
                              </svg></a>
                          @endif
                        </div>
                      @endif

                      @if (filled($slide->note))
                        <p class="hero-note">{{ $slide->note }}</p>
                      @endif
                    </div>
                  </div>
                @endif
              </div>
            @endforeach
          </div>

          @if ($heroSlides->count() > 1)
            <div class="swiper-pagination"></div>
          @endif
        </div>
      </section>
    @endif

    @if ($homeCategories->isNotEmpty())
      <section class="home-secA">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Explore Our Collections</span>
            <div class="heading">
              <h3>Find Your Signature Look</h3>
            </div>
            <p>Discover something made for every celebration.</p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($homeCategories as $category)
                  <div class="swiper-slide">
                    <a href="{{ route('category.show', $category->slug) }}" class="cat-card">
                      <div class="cat-img">
                        @if ($category->image)
                          <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy" />
                        @else
                          <img src="{{ asset('assets/images/home/cat1.png') }}" alt="{{ $category->name }}" loading="lazy" />
                        @endif
                      </div>
                      <div class="cat-info">
                        <h4>{{ $category->name }}</h4>
                        @if (filled($category->sub_title))
                          <p>{{ \Illuminate\Support\Str::limit(strip_tags($category->sub_title), 80) }}</p>
                        @endif
                        <span class="cat-link">Shop {{ $category->name }}
                          <i class="fa-solid fa-arrow-right-long"></i></span>
                      </div>
                    </a>
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
    @endif

    @if ($lovedAll->isNotEmpty())
      <section class="home-secB">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Most Loved</span>
            <div class="heading">
              <h3>What Everyone's Loving</h3>
            </div>
            <p>Discover the styles our customers are choosing.</p>
          </div>

          <ul class="tab-nav">
            <li data-tab="1" class="active">All</li>
            @foreach ($lovedTabs as $i => $tab)
              <li data-tab="{{ $i + 2 }}">{{ $tab['category']->name }}</li>
            @endforeach
          </ul>

          <div class="tab-nav-content">

            {{-- TAB 1: ALL --}}
            <div class="tabs active" data-tab="1">
              <div class="swiper-wrap">
                <div class="swiper fourSlider">
                  <div class="swiper-wrapper">
                    @foreach ($lovedAll as $product)
                      <div class="swiper-slide">
                        @include('partials.product-card', ['product' => $product])
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

            {{-- CATEGORY TABS --}}
            @foreach ($lovedTabs as $i => $tab)
              <div class="tabs" data-tab="{{ $i + 2 }}">
                <div class="swiper-wrap">
                  <div class="swiper fourSlider">
                    <div class="swiper-wrapper">
                      @foreach ($tab['products'] as $product)
                        <div class="swiper-slide">
                          @include('partials.product-card', ['product' => $product])
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
            @endforeach

          </div>
        </div>
      </section>
    @endif

    @if ($editCategory)
      <section class="home-secC">
        <div class="container">
          <div class="edit-grid">
            <div class="edit-visual">
              <div class="edit-photo">
                <img
                  src="{{ $editCategory->image ? asset('storage/' . $editCategory->image) : asset('assets/images/home/banner5.jpg') }}"
                  alt="{{ $editCategory->name }}" loading="lazy" />
              </div>
              <span class="edit-tag">The Archana Edit</span>
            </div>

            <div class="edit-content">
              <span class="eyebrow">The {{ $editCategory->name }} Edit</span>

              <div class="heading">
                <h3>{{ $editCategory->name }}</h3>
              </div>

              @if (filled($editCategory->sub_title))
                <p class="edit-copy">{{ strip_tags($editCategory->sub_title) }}</p>
              @endif

              @if ($editSubs->isNotEmpty())
                <ul class="edit-links">
                  @foreach ($editSubs->take(6) as $sub)
                    <li>
                      <a
                        href="{{ route('category.show', ['slug' => $editCategory->slug, 'sub' => $sub->slug]) }}">{{ $sub->name }}</a>
                    </li>
                  @endforeach
                </ul>
              @endif

              <a href="{{ route('category.show', $editCategory->slug) }}" class="btn btn-primary edit-cta">
                Explore {{ $editCategory->name }} <i class="fa-solid fa-arrow-right-long"></i>
              </a>

              @if ($editProducts->isNotEmpty())
                <div class="edit-products">
                  @foreach ($editProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                  @endforeach
                </div>
              @endif
            </div>
          </div>

          <div class="edit-statement">
            <span class="line"></span>
            <p>Curated for celebrations, crafted to be remembered.</p>
            <span class="line"></span>
          </div>
        </div>
      </section>
    @endif

    @if ($editCategory && $editSubs->isNotEmpty())
      <section class="home-secD">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Find Your Drape</span>
            <div class="heading">
              <h3>{{ $editCategory->name }} for Every Celebration</h3>
            </div>
            <p>
              Explore distinctive fabrics, textures and styles curated for every
              occasion.
            </p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider" data-mob="1.4">
              <div class="swiper-wrapper">
                @foreach ($editSubs as $sub)
                  <div class="swiper-slide">
                    <a href="{{ route('category.show', ['slug' => $editCategory->slug, 'sub' => $sub->slug]) }}"
                      class="drape-card">
                      <div class="drape-img">
                        <img src="{{ $sub->image ? asset('storage/' . $sub->image) : asset('assets/images/home/tab1.png') }}"
                          alt="{{ $sub->name }}" loading="lazy" />
                      </div>
                      <div class="drape-info">
                        <h4>{{ $sub->name }}</h4>
                        @if (filled($sub->sub_title))
                          <p>{{ \Illuminate\Support\Str::limit(strip_tags($sub->sub_title), 70) }}</p>
                        @endif
                        <span class="drape-link">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                      </div>
                    </a>
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

          <div class="slider-foot">
            <span class="slide-current sliderCurrent">01</span>
            <div class="swiper-pagination sliderProgress"></div>
            <span class="slide-total sliderTotal">{{ str_pad($editSubs->count(), 2, '0', STR_PAD_LEFT) }}</span>
          </div>
        </div>
      </section>
    @endif

    @if ($campaign)
      <section class="home-secE">
        <div class="camp-bg">
          <img src="{{ $campaign->bg_image_url }}" alt="{{ preg_replace('/\s+/', ' ', $campaign->title) }}"
            loading="lazy" />
        </div>
        <div class="container">
          <div class="camp-grid">
            <div class="camp-content">
              @if (filled($campaign->eyebrow))
                <span class="eyebrow">{{ $campaign->eyebrow }}</span>
              @endif

              <div class="heading">
                <h2>{!! nl2br(e($campaign->title)) !!}</h2>
              </div>

              @if (filled($campaign->description))
                <p class="camp-copy">{{ $campaign->description }}</p>
              @endif

              @if (filled($campaign->primary_btn_text) || filled($campaign->secondary_btn_text))
                <div class="camp-btns">
                  @if (filled($campaign->primary_btn_text))
                    <a href="{{ $campaign->primary_btn_link ?: route('products') }}"
                      class="btn btn-white">{{ $campaign->primary_btn_text }}</a>
                  @endif
                  @if (filled($campaign->secondary_btn_text))
                    <a href="{{ $campaign->secondary_btn_link ?: route('products') }}"
                      class="btn btn-outline-white">{{ $campaign->secondary_btn_text }}
                      <i class="fa-solid fa-arrow-right-long"></i></a>
                  @endif
                </div>
              @endif

              @if (count($campaign->highlights_list))
                <ul class="camp-note">
                  @foreach ($campaign->highlights_list as $point)
                    <li>{{ $point }}</li>
                  @endforeach
                </ul>
              @endif
            </div>

            <div class="camp-visual">
              <div class="camp-photo">
                <img src="{{ $campaign->image_url }}" alt="{{ preg_replace('/\s+/', ' ', $campaign->title) }}"
                  loading="lazy" />
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif

    @if ($occasions->isNotEmpty())
      <section class="home-secF">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Shop by Occasion</span>
            <div class="heading">
              <h3>A Look for Every Moment</h3>
            </div>
            <p>
              From the aisle to the after-party, find the style made for
              your celebration.
            </p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($occasions as $occasion)
                  <div class="swiper-slide">
                    <a href="{{ route('products', ['occasion' => $occasion->slug]) }}" class="cat-card">
                      <div class="cat-img">
                        <img
                          src="{{ $occasion->image ? asset('storage/' . $occasion->image) : asset('assets/images/home/cat1.png') }}"
                          alt="{{ $occasion->title }}" loading="lazy" />
                      </div>
                      <div class="cat-info">
                        <h4>{{ $occasion->title }}</h4>
                        @php $desc = $occasion->sub_title ?: $occasion->short_description; @endphp
                        @if (filled($desc))
                          <p>{{ \Illuminate\Support\Str::limit(strip_tags($desc), 80) }}</p>
                        @endif
                        <span class="cat-link">Shop {{ $occasion->title }}
                          <i class="fa-solid fa-arrow-right-long"></i></span>
                      </div>
                    </a>
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
    @endif

    @if ($spotCategory)
      <section class="home-secG">
        <div class="container">
          <div class="bridal-wrap">
            <div class="bridal-img">
              <img
                src="{{ $spotCategory->image ? asset('storage/' . $spotCategory->image) : asset('assets/images/home/offer2.png') }}"
                alt="{{ $spotCategory->name }}" loading="lazy" />
            </div>

            <div class="bridal-content">
              <span class="eyebrow">The {{ $spotCategory->name }} Collection</span>

              <div class="heading">
                <h2>{{ $spotCategory->name }}</h2>
              </div>

              @if (filled($spotCategory->sub_title))
                <p class="bridal-copy">{{ strip_tags($spotCategory->sub_title) }}</p>
              @endif

              <div class="bridal-btns">
                <a href="{{ route('category.show', $spotCategory->slug) }}" class="btn btn-primary">
                  Explore {{ $spotCategory->name }}
                </a>

                @if ($spotSubs->isNotEmpty())
                  <a href="{{ route('category.show', ['slug' => $spotCategory->slug, 'sub' => $spotSubs->first()->slug]) }}"
                    class="btn btn-outline-primary">Shop {{ $spotSubs->first()->name }}</a>
                @endif
              </div>

              @if ($spotSubs->isNotEmpty())
                <ul class="bridal-links">
                  @foreach ($spotSubs->take(4) as $sub)
                    <li>
                      <a
                        href="{{ route('category.show', ['slug' => $spotCategory->slug, 'sub' => $sub->slug]) }}">{{ $sub->name }}</a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

    @if ($spotCategory && $spotSubs->isNotEmpty())
      <section class="home-secH">
        <div class="container">
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($spotSubs as $sub)
                  <div class="swiper-slide">
                    <a href="{{ route('category.show', ['slug' => $spotCategory->slug, 'sub' => $sub->slug]) }}"
                      class="brd-card">
                      <img
                        src="{{ $sub->image ? asset('storage/' . $sub->image) : ($spotCategory->image ? asset('storage/' . $spotCategory->image) : asset('assets/images/home/tab1.png')) }}"
                        alt="{{ $sub->name }}" loading="lazy" />
                      <div class="brd-info">
                        <h4>{{ $sub->name }}</h4>
                        @if (filled($sub->sub_title))
                          <p>{{ \Illuminate\Support\Str::limit(strip_tags($sub->sub_title), 70) }}</p>
                        @endif
                        <span class="brd-link">Shop {{ $sub->name }}
                          <i class="fa-solid fa-arrow-right-long"></i></span>
                      </div>
                    </a>
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
    @endif

    @if ($offerProducts->isNotEmpty() || $homeCoupons->isNotEmpty())
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

          @if ($offerProducts->isNotEmpty())
            <div class="offer-grid">
              @foreach ($offerProducts as $product)
                @php
                  $img = $product->images->firstWhere('is_default', 1) ?? $product->images->first();
                @endphp
                <a href="{{ route('products.show', ['slug' => $product->slug]) }}" class="offer-card">
                  <img
                    src="{{ $img ? asset('storage/' . ($img->image ?? $img->thumb)) : asset('assets/images/home/offer1.jpg') }}"
                    alt="{{ $product->name }}" loading="lazy" />
                  <span class="o-badge"><b>{{ $product->discount_percent }}%</b> Off</span>
                  <div class="o-body">
                    <h4>{{ $product->name }}</h4>
                    <p>
                      <del>₹{{ number_format($product->mrp) }}</del>
                      <strong>₹{{ number_format($product->price) }}</strong>
                    </p>
                    <span class="btn btn-white">Shop Now <i class="fa-solid fa-arrow-right-long"></i></span>
                  </div>
                </a>
              @endforeach
            </div>
          @endif

          @if ($homeCoupons->isNotEmpty())
            @php $couponIcons = ['fa-ticket', 'fa-gift', 'fa-tags']; @endphp
            <div class="coupon-wrap">
              <div class="coupon-head">
                <h5>Coupons &amp; Deals</h5>
              </div>

              <div class="coupon-grid">
                @foreach ($homeCoupons as $coupon)
                  <div class="coupon-card">
                    <div class="c-icon"><i class="fa-solid {{ $couponIcons[$loop->index % 3] }}"></i></div>
                    <div class="c-info">
                      <span class="c-code">{{ $coupon->code }}</span>
                      <p>{{ $coupon->offer_text }}</p>
                    </div>
                    <button type="button" class="coupon-copy" data-code="{{ $coupon->code }}">
                      <span>Copy Code</span>
                    </button>
                  </div>
                @endforeach
              </div>

              <p class="coupon-note">
                *Terms &amp; conditions apply. Offers valid for a limited time.
              </p>
            </div>
          @endif
        </div>
      </section>
    @endif

    @if ($topFeatured && $topSlider->isNotEmpty())
      @php
        $featImg = $topFeatured->images->firstWhere('is_default', 1) ?? $topFeatured->images->first();
      @endphp
      <section class="home-secJ">
        <div class="container">
          <div class="feat-grid">
            <a href="{{ route('products.show', ['slug' => $topFeatured->slug]) }}" class="feat-visual">
              <img
                src="{{ $featImg ? asset('storage/' . ($featImg->image ?? $featImg->thumb)) : asset('assets/images/home/offer2.png') }}"
                alt="{{ $topFeatured->name }}" loading="lazy" />
            </a>

            <div class="feat-content">
              <div class="feat-panel">
                <span class="eyebrow">Customer Favourites</span>
                <div class="heading">
                  <h3>The {{ config('app.name') }} Edit</h3>
                </div>
                <p>
                  Our highest rated styles, loved for their colours, silhouettes
                  and craftsmanship.
                </p>
                <a href="{{ route('products.index', ['sort' => 'rating']) }}" class="btn btn-primary">Explore the Edit
                  <i class="fa-solid fa-arrow-right-long"></i></a>
              </div>

              <div class="swiper-wrap">
                <div class="swiper fourSlider" data-mob="2" data-sm="2" data-lg="2" data-xl="2">
                  <div class="swiper-wrapper">
                    @foreach ($topSlider as $product)
                      <div class="swiper-slide">
                        @include('partials.product-card', ['product' => $product])
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
          </div>
        </div>
      </section>
    @endif

    @if ($collectionY && $collectionY->homeProducts->isNotEmpty())
      <section class="home-secY">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Just In</span>
            <div class="heading">
              <h3>{{ $collectionY->name }}</h3>
            </div>
            <p>
              Explore our {{ $collectionY->name }} collection, freshly curated
              for the season.
            </p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($collectionY->homeProducts as $product)
                  <div class="swiper-slide">
                    @include('partials.product-card', ['product' => $product])
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
    @endif

    @if ($collectionL && $collectionL->homeProducts->isNotEmpty())
      <section class="home-secL">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Our Collection</span>
            <div class="heading">
              <h3>{{ $collectionL->name }}</h3>
            </div>
            <p>
              Discover the {{ $collectionL->name }} styles our customers love.
            </p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($collectionL->homeProducts as $product)
                  <div class="swiper-slide">
                    @include('partials.product-card', ['product' => $product])
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
    @endif

    @if ($story)
      <section class="home-secM">
        <div class="container">
          <div class="story-grid">
            <div class="story-visual">
              <div class="story-main">
                <img src="{{ $story->main_image_url }}" alt="{{ $story->title }}" loading="lazy" />
              </div>
              <div class="story-small">
                <img src="{{ $story->small_image_url }}" alt="{{ $story->title }}" loading="lazy" />
              </div>
              @if (filled($story->tag))
                <span class="story-tag">{{ $story->tag }}</span>
              @endif
            </div>

            <div class="story-content">
              @if (filled($story->eyebrow))
                <span class="eyebrow">{{ $story->eyebrow }}</span>
              @endif
              <div class="heading">
                <h3>{{ $story->title }}</h3>
              </div>
              @if (filled($story->description))
                <p>{{ $story->description }}</p>
              @endif
              @if (filled($story->description_2))
                <p>{{ $story->description_2 }}</p>
              @endif
              @if (filled($story->btn_text) && filled($story->btn_link))
                <a href="{{ $story->btn_link }}" class="btn btn-primary">{{ $story->btn_text }}
                  <i class="fa-solid fa-arrow-right-long"></i></a>
              @endif
            </div>
          </div>

          @if (filled($story->founder_name) || filled($story->founder_message))
            <div class="founder">
              <div class="founder-photo">
                <img src="{{ $story->founder_photo_url }}" alt="{{ $story->founder_name ?: 'Founder' }}" loading="lazy" />
              </div>
              <div class="founder-info">
                <span class="founder-label">Meet the Founder</span>
                @if (filled($story->founder_name))
                  <h4>{{ $story->founder_name }}</h4>
                @endif
                @if (filled($story->founder_role))
                  <span class="founder-role">{{ $story->founder_role }}</span>
                @endif
                @if (filled($story->founder_message))
                  <p>{{ $story->founder_message }}</p>
                @endif
              </div>
            </div>
          @endif
        </div>
      </section>
    @endif

    @if ($reels->isNotEmpty())
      @php $followUrl = optional(view()->shared('general'))->instagram ?? null; @endphp
      <section class="home-secS">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Style in Motion</span>
            <div class="heading">
              <h3>See the Look. Feel the Moment.</h3>
            </div>
            <p>
              Discover styling inspiration, new arrivals and occasion-ready
              looks from {{ config('app.name') }}.
            </p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($reels as $reel)
                  <div class="swiper-slide">
                    <div class="reel-card">
                      <img src="{{ $reel->thumbnail_url }}" alt="{{ $reel->title }} reel" loading="lazy" /><span
                        class="reel-tag"><i class="fa-solid fa-clapperboard"></i></span>
                      <div class="content-wrap">
                        <div class="reel-text">
                          <h4>{{ $reel->title }}</h4>
                          @if (filled($reel->subtitle))
                            <p>{{ $reel->subtitle }}</p>
                          @endif
                        </div>
                        @if ($reel->video_src)
                          <button type="button" class="play-btn" data-video="{{ $reel->video_src }}"
                            aria-label="Play {{ $reel->title }} reel">
                            <i class="fa-solid fa-play"></i>
                          </button>
                        @endif
                      </div>
                    </div>
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

          @if ($followUrl)
            <div class="sec-cta">
              <a href="{{ $followUrl }}" target="_blank" rel="noopener" class="btn btn-primary">Follow Our Journey
                <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
          @endif
        </div>
      </section>
    @endif

    @if ($homeReviews->isNotEmpty())
      <section class="home-secN">
        <div class="container">
          <div class="sec-head">
            <span class="eyebrow">Customer Love</span>
            <div class="heading">
              <h3>Loved by Women Who Celebrate in Style</h3>
            </div>
            <p>
              Beautiful words from customers who found something special at
              {{ config('app.name') }}.
            </p>
          </div>

          <div class="swiper-wrap">
            <div class="swiper fourSlider" data-mob="1.15">
              <div class="swiper-wrapper">
                @foreach ($homeReviews as $review)
                  @php
                    $name = $review->customer->name ?? 'Customer';
                    $avatar = $review->customer->avatar ?? null;
                  @endphp
                  <div class="swiper-slide">
                    <div class="review-card">
                      <div class="review-head">
                        <div class="review-stars">
                          @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                          @endfor
                        </div>
                        <i class="fa-solid fa-quote-right review-quote"></i>
                      </div>

                      <p class="review-text">
                        {{ \Illuminate\Support\Str::limit(strip_tags($review->review), 160) }}
                      </p>

                      <div class="review-by">
                        @if ($avatar)
                          <img src="{{ asset('storage/' . $avatar) }}" alt="{{ $name }}" loading="lazy" />
                        @else
                          <span
                            style="width:48px;height:48px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#eee;font-weight:600;flex-shrink:0;">
                            {{ strtoupper(mb_substr($name, 0, 1)) }}
                          </span>
                        @endif
                        <div>
                          <h5>{{ $name }}</h5>
                          <span>
                            {{ $review->verified_purchase ? 'Verified Customer' : 'Customer' }}
                            @if ($review->product)
                              · <a
                                href="{{ route('products.show', ['slug' => $review->product->slug]) }}">{{ \Illuminate\Support\Str::limit($review->product->name, 28) }}</a>
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>
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
    @endif

    <section class="home-secO">
      <div class="container">
        <div class="news-wrap">
          <div class="news-photo">
            <img src="{{ asset('assets/images/home/offer1.jpg') }}" alt="{{ config('app.name') }} new arrivals"
              loading="lazy" />
          </div>
          <div class="news-panel">
            <span class="eyebrow">Stay in the Know</span>
            <div class="heading">
              <h3>Be the First to Discover What's New</h3>
            </div>
            <p class="news-desc">
              Sign up for new arrivals, curated collections, styling
              inspiration and exclusive offers from {{ config('app.name') }}.
            </p>

            <form class="form news-form" action="{{ route('newsletter.subscribe') }}" method="post" novalidate>
              @csrf
              {{-- honeypot --}}
              <input type="text" name="website" tabindex="-1" autocomplete="off"
                style="position:absolute;left:-9999px;opacity:0;height:0;width:0" aria-hidden="true">

              <div class="form-group">
                <input type="email" id="newsEmail" name="email" placeholder=" " required />
                <label for="newsEmail">Enter your email address</label>
              </div>
              <button type="submit" class="btn btn-black">
                Subscribe <i class="fa-solid fa-arrow-right-long"></i>
              </button>
            </form>

            <p class="news-note" id="newsMsg" hidden></p>
            <p class="news-note">
              By subscribing, you agree to receive updates and offers from
              {{ config('app.name') }}.
            </p>
          </div>
        </div>
      </div>
    </section>

    @if ($collectGroups->isNotEmpty() || $occasions->isNotEmpty())
      @php
        $collectIcons = ['fa-scroll', 'fa-gem', 'fa-ring'];
        $collectCount = $collectGroups->count() + ($occasions->isNotEmpty() ? 1 : 0);
        $collectStyles = $collectGroups->sum(fn($c) => $c->children->count()) + $occasions->count();
        $allUrl = \Illuminate\Support\Facades\Route::has('categories') ? route('categories') : route('products');
      @endphp
      <section class="home-secP">
        <div class="container">
          <div class="collect-wrap">
            <div class="collect-intro">
              <span class="eyebrow">All Collections</span>
              <div class="heading">
                <h3>Explore {{ config('app.name') }}</h3>
              </div>
              <p class="collect-desc">
                Discover our complete range of Indian occasion wear, from
                timeless sarees and designer lehengas to bridal and wedding
                collections.
              </p>
              <ul class="collect-stats">
                <li><b>{{ str_pad($collectCount, 2, '0', STR_PAD_LEFT) }}</b><span>Collections</span></li>
                <li><b>{{ str_pad($collectStyles, 2, '0', STR_PAD_LEFT) }}</b><span>Styles</span></li>
              </ul>
              <a href="{{ $allUrl }}" class="btn btn-primary">Shop All Collections
                <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>

            <div class="collect-grid">
              @foreach ($collectGroups as $cat)
                <div class="collect-group">
                  <div class="collect-head">
                    <div class="collect-title">
                      <span class="collect-ico"><i class="fa-solid {{ $collectIcons[$loop->index % 3] }}"></i></span>
                      <h4>{{ $cat->name }}</h4>
                    </div>
                    <span class="collect-count">{{ str_pad($cat->children->count(), 2, '0', STR_PAD_LEFT) }} Styles</span>
                  </div>
                  <ul class="collect-links">
                    @foreach ($cat->children->take(9) as $sub)
                      <li>
                        <a href="{{ route('category.show', ['slug' => $cat->slug, 'sub' => $sub->slug]) }}">{{ $sub->name }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endforeach

              @if ($occasions->isNotEmpty())
                <div class="collect-group">
                  <div class="collect-head">
                    <div class="collect-title">
                      <span class="collect-ico"><i class="fa-solid fa-champagne-glasses"></i></span>
                      <h4>Occasions</h4>
                    </div>
                    <span class="collect-count">{{ str_pad($occasions->count(), 2, '0', STR_PAD_LEFT) }} Styles</span>
                  </div>
                  <ul class="collect-links">
                    @foreach ($occasions->take(9) as $occasion)
                      <li>
                        <a href="{{ route('products', ['occasion' => $occasion->slug]) }}">{{ $occasion->title }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

  </main>

@endsection

@push('scripts')

  <script>
    document.querySelector('.news-form')?.addEventListener('submit', async function (e) {
      e.preventDefault();
      const form = this;
      const btn = form.querySelector('button[type=submit]');
      const msg = document.getElementById('newsMsg');

      btn.disabled = true;
      try {
        const res = await fetch(form.action, {
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          body: new FormData(form)
        });
        const data = await res.json().catch(() => ({}));
        const text = res.ok
          ? data.message
          : (data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Something went wrong.'));

        msg.textContent = text;
        msg.style.color = res.ok ? '#007a5e' : '#b22222';
        msg.hidden = false;
        if (res.ok) form.reset();
      } catch (err) {
        msg.textContent = 'Something went wrong. Please try again.';
        msg.style.color = '#b22222';
        msg.hidden = false;
      }
      btn.disabled = false;
    });
  </script>

@endpush