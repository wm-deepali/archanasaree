<!doctype html>
@php
  $authCustomer = auth('customer')->user();
  $dashUrl = Route::has('user.dashboard.index') ? route('user.dashboard.index') : null;
  $wishCount = count(\App\Models\Wishlist::currentProductIds());

  $siteName = $general->site_name ?: config('app.name');
  $tagline = $general->tagline;
  $headerLogo = $general->header_logo ? asset('storage/' . $general->header_logo) : null;
  $footerLogo = $general->footer_logo ? asset('storage/' . $general->footer_logo) : $headerLogo;

  // WhatsApp: sirf digits, 10 digit ho to 91 laga do
  $waDigits = preg_replace('/\D/', '', (string) $general->whatsapp);
  if (strlen($waDigits) === 10) {
    $waDigits = '91' . $waDigits;
  }

  // Sirf wahi social links jinki value bhari hai
  $socials = collect([
    ['label' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f', 'url' => $general->facebook],
    ['label' => 'Instagram', 'icon' => 'fa-brands fa-instagram', 'url' => $general->instagram],
    ['label' => 'Twitter', 'icon' => 'fa-brands fa-x-twitter', 'url' => $general->twitter],
    ['label' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in', 'url' => $general->linkedin],
    ['label' => 'Pinterest', 'icon' => 'fa-brands fa-pinterest-p', 'url' => $general->pinterest],
    ['label' => 'YouTube', 'icon' => 'fa-brands fa-youtube', 'url' => $general->youtube],
    ['label' => 'WhatsApp', 'icon' => 'fa-brands fa-whatsapp', 'url' => $waDigits ? 'https://wa.me/' . $waDigits : null],
  ])->filter(fn($s) => filled($s['url']))->values();

  // Policy / info pages from Manage Dynamic Pages (only active ones)
  $policyPages = \App\Models\DynamicPage::active()->get()->keyBy('slug');
  $pageLinks = fn(array $slugs) => collect($slugs)
    ->map(fn($s) => $policyPages->get($s))
    ->filter();

@endphp
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @include('partials.seo')
  @if ($general->favicon_url)
    <link rel="icon" href="{{ $general->favicon_url }}" />
  @endif
  <!-- ================= Google Fonts ================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&amp;display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/css/glightbox.min.css" />

  <!-- ================= Vendor CSS ================= -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <!-- ================= Project CSS ================= -->
  <link rel="stylesheet" href="{{ asset('assets/font/font.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/sass/header/header.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/sass/footer/footer.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/sass/home/home.css')}}" />
  <!-- ================= Animation / Popup CSS ================= -->
  <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/fancybox.css')}}" />

  @stack('styles')
</head>

<body>

  @if (!empty($seo?->body_scripts))
    {!! $seo->body_scripts !!}
  @endif

  <header>
    <div class="top_header">
      <div class="container-fluid">
        <div class="announcement-bar">
          @if ($tagline)
            <p class="ann-left">{{ $tagline }}</p>
          @endif

          <div class="swiper announcement-swiper ann-center">
            <div class="swiper-wrapper">
              @forelse ($announcements as $ann)
                <div class="swiper-slide">
                  <p>
                    @if (filled($ann->link))
                      <a href="{{ $ann->link }}">{{ $ann->title }}</a>
                    @else
                      {{ $ann->title }}
                    @endif
                  </p>
                </div>
              @empty
                {{-- Optional fallback so the bar is never empty --}}
                <div class="swiper-slide">
                  <p>{{ $tagline ?: $siteName }}</p>
                </div>
              @endforelse
            </div>
          </div>
          <!-- ===== NEW: Social media icons (ann-right ki jagah) ===== -->
          @if ($socials->isNotEmpty())
            <ul class="ann-social">
              @foreach ($socials as $s)
                <li>
                  <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['label'] }}"
                    title="{{ $s['label'] }}"><i class="{{ $s['icon'] }}"></i></a>
                </li>
              @endforeach
            </ul>
          @endif
          <!-- ===== /Social media icons ===== -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="header-wrapper">
        <div class="colA">
          <button type="button" class="ham-btn" data-model=".ham-pop" aria-label="Menu">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
              stroke-linecap="round">
              <path d="M3 6h18M3 12h18M3 18h18" />
            </svg>
          </button>
          <a href="{{ route('home') }}" class="logo">
            @if ($headerLogo)
              <img src="{{ $headerLogo }}" alt="{{ $siteName }}" title="{{ $siteName }}" />
            @else
              <span>{{ $siteName }}</span>
            @endif
          </a>
        </div>

        <div class="colB">
          <ul class="menu-list">
            <li class="active"><a href="{{ route('home') }}">Home</a></li>

            @foreach ($navCategories as $navCat)
              @php
                $navUrl = route('category.show', $navCat->slug);
                $navSubs = $navCat->children;
              @endphp

              @if ($navSubs->isEmpty())
                <li><a href="{{ $navUrl }}">{{ $navCat->name }}</a></li>
              @else
                <li class="hasMega">
                  <a href="{{ $navUrl }}">
                    {{ $navCat->name }}
                    <svg class="chev" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M6 9l6 6 6-6" />
                    </svg>
                  </a>
                  <div class="mega-menu">
                    <div class="mega-inner">
                      <div class="mega-links">
                        <h4><a href="{{ $navUrl }}">Shop {{ $navCat->name }}</a></h4>
                        <ul>
                          @foreach ($navSubs as $navSub)
                            <li>
                              <a href="{{ route('category.show', ['slug' => $navCat->slug, 'sub' => $navSub->slug]) }}">
                                {{ $navSub->name }}
                              </a>
                            </li>
                          @endforeach
                        </ul>
                      </div>

                      @if ($navCat->image)
                        <a href="{{ $navUrl }}" class="mega-feature">
                          <img src="{{ asset('storage/' . $navCat->image) }}" alt="{{ $navCat->name }}" loading="lazy" />
                          <span class="feature-text">
                            <span class="feature-label">{{ $navCat->name }}</span>
                            @if ($navCat->sub_title)
                              <span class="feature-desc">{{ $navCat->sub_title }}</span>
                            @endif
                            <span class="feature-link">
                              Explore {{ $navCat->name }}
                              <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12h18M15 6l6 6-6 6" />
                              </svg>
                            </span>
                          </span>
                        </a>
                      @endif
                    </div>
                  </div>
                </li>
              @endif
            @endforeach

            <!-- ===== Shop by Collection (Mega Menu, no image) ===== -->
            @if ($navAttributes->isNotEmpty() || $navCollections->isNotEmpty() || $navOccasions->isNotEmpty() || count($navPriceRanges))
              <li class="hasMega">
                <a href="{{ route('products') }}">
                  Shop by Collection
                  <svg class="chev" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                  </svg>
                </a>
                <div class="mega-menu mega-collection">
                  <div class="mega-collection-inner">

                    {{-- Attributes (Fabric, Color...) : show_in_navbar --}}
                    @foreach ($navAttributes as $navAttr)
                      <div class="mega-col">
                        <h4>Shop by {{ $navAttr->name }}</h4>
                        <ul>
                          @foreach ($navAttr->values->take(10) as $navVal)
                            <li>
                              <a href="{{ route('products', ['attr' => [$navAttr->slug => [$navVal->slug]]]) }}">
                                {{ $navVal->value }}
                              </a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endforeach

                    {{-- Collections --}}
                    @if ($navCollections->isNotEmpty())
                      <div class="mega-col">
                        <h4>Shop by Collections</h4>
                        <ul>
                          @foreach ($navCollections->take(10) as $navCol)
                            <li>
                              <a href="{{ route('products', ['collection' => [$navCol->slug]]) }}">{{ $navCol->name }}</a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    {{-- Price Range --}}
                    @if (count($navPriceRanges))
                      <div class="mega-col">
                        <h4>Price Range</h4>
                        <ul>
                          @foreach ($navPriceRanges as $range)
                                            <li>
                                              <a href="{{ route('products', array_filter([
                              'price_min' => $range['min'],
                              'price_max' => $range['max'],
                            ])) }}">{{ $range['label'] }}</a>
                                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    {{-- Occasions --}}
                    @if ($navOccasions->isNotEmpty())
                      <div class="mega-col">
                        <h4>Shop by Occasions</h4>
                        <ul>
                          @foreach ($navOccasions->take(10) as $navOcc)
                            <li>
                              <a href="{{ route('products', ['occasion' => [$navOcc->slug]]) }}">{{ $navOcc->title }}</a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                  </div>
                </div>
              </li>
            @endif
            {{-- Collections marked show_in_navbar (New Arrivals, Offers...) --}}
            @foreach ($navBarCollections as $navBarCol)
              <li>
                <a href="{{ route('products', ['collection' => [$navBarCol->slug]]) }}">{{ $navBarCol->name }}</a>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="colC">
          <div class="search-box-wrapper">
            <button type="button" class="action-link search-btn" aria-label="Search">
              <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7.5" />
                <path d="M16.5 16.5L21 21" />
              </svg>
            </button>
            <div class="formField">
              <input type="text" class="searchInput"
                placeholder="Search {{ $navCategories->pluck('name')->map(fn($n) => strtolower($n))->implode(', ') ?: 'products' }}..."
                autocomplete="off" data-url="{{ route('search.suggest') }}" data-all="{{ route('products') }}" />

              <div class="search-results">
                <p class="res-title">Suggestions</p>
                <ul class="res-list"></ul>
                <p class="res-empty" style="display:none">
                  No products found. Try a different keyword.
                </p>
                <a href="{{ route('products') }}" class="res-all">
                  View all results
                  <i class="fa-solid fa-arrow-right-long"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="account-wrapper">
            @if ($authCustomer)
              <a href="{{ $dashUrl ?? 'javascript:void(0)' }}" class="action-link account-btn" aria-label="Account">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="8" r="4.2" />
                  <path d="M4 21c0-4.4 3.6-7.5 8-7.5s8 3.1 8 7.5" />
                </svg>
              </a>

              <div class="account-drop">
                <div class="acc-profile">
                  <span class="acc-avatar">{{ mb_strtoupper(mb_substr($authCustomer->name, 0, 1)) }}</span>
                  <div class="acc-info">
                    <h6>{{ $authCustomer->name }}</h6>
                    <p>{{ $authCustomer->email }}</p>
                  </div>
                </div>

                <ul class="acc-list">
                  @if ($dashUrl)
                    <li><a href="{{ $dashUrl }}#tab-2"><i class="fa-solid fa-truck-fast"></i> Track Order</a></li>
                    <li><a href="{{ $dashUrl }}#tab-3"><i class="fa-solid fa-box-open"></i> My Orders</a></li>
                    <li><a href="{{ $dashUrl }}#tab-4"><i class="fa-regular fa-heart"></i> My Wishlist</a></li>
                    <li><a href="{{ $dashUrl }}#tab-5"><i class="fa-regular fa-user"></i> My Profile</a></li>
                  @endif
                  <li class="acc-out">
                    <a href="javascript:void(0)" onclick="document.getElementById('customerLogoutForm').submit()">
                      <i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
                  </li>
                </ul>

                <form id="customerLogoutForm" method="POST" action="{{ route('user.logout') }}" hidden>@csrf</form>
              </div>
            @else
              {{-- Guest: the icon opens the login / register modal --}}
              <button type="button" class="action-link account-btn" data-model=".login-pop"
                aria-label="Login or register">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
                  stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="8" r="4.2" />
                  <path d="M4 21c0-4.4 3.6-7.5 8-7.5s8 3.1 8 7.5" />
                </svg>
              </button>
            @endif
          </div>
          @if ($authCustomer && $dashUrl)
            <a href="{{ $dashUrl }}#tab-4" class="action-link" aria-label="Wishlist">
              <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20.5s-8-4.9-8-11A4.6 4.6 0 0112 6.8a4.6 4.6 0 018 2.7c0 6.1-8 11-8 11z" />
              </svg>
              <span class="count wishlist-count">{{ $wishCount }}</span>
            </a>
          @else
            <button type="button" data-model=".login-pop" class="action-link" aria-label="Wishlist">
              <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20.5s-8-4.9-8-11A4.6 4.6 0 0112 6.8a4.6 4.6 0 018 2.7c0 6.1-8 11-8 11z" />
              </svg>
              <span class="count wishlist-count">{{ $wishCount }}</span>
            </button>
          @endif

          <button data-model=".cart-pop" class="action-link" aria-label="Bag">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 8h14l-1 12.5H6L5 8z" />
              <path d="M8.5 8V6.5a3.5 3.5 0 017 0V8" />
            </svg>
            <span class="count cart-count">{{ $cartCount }}</span>
          </button>
        </div>
      </div>
    </div>
  </header>

  @yield('content')

  <footer>
    <div class="footer-wrapper">
      <ul class="footer-top">
        <li>
          <i class="fa-regular fa-gem"></i>
          <div class="content">
            <p>Authentic Craftsmanship</p>
            <span>Curated fabrics, fine detailing</span>
          </div>
        </li>
        <li>
          <i class="fa-solid fa-truck-fast"></i>
          <div class="content">
            <p>Pan-India Delivery</p>
            <span>Carefully packed, safely shipped</span>
          </div>
        </li>
        <li>
          <i class="fa-solid fa-rotate-left"></i>
          <div class="content">
            <p>Returns &amp; Exchange</p>
            <span>Hassle-free, as per our policy</span>
          </div>
        </li>
        <li>
          <i class="fa-solid fa-shield-halved"></i>
          <div class="content">
            <p>Secure Payments</p>
            <span>Safe and trusted checkout</span>
          </div>
        </li>
      </ul>
    </div>

    <div class="footer-wrapper-bottom">
      <div class="footer-middle">
        <div class="container">
          <div class="colA">
            <a href="{{ route('home') }}" class="logo">
              @if ($footerLogo)
                <img src="{{ $footerLogo }}" alt="{{ $siteName }}" />
              @else
                <span>{{ $siteName }}</span>
              @endif
            </a>
            @if ($tagline)
              <span class="brand-tag">{{ $tagline }}</span>
            @endif
            @if ($general->footer_description)
              <p class="brand-desc">{{ $general->footer_description }}</p>
            @endif
            @if ($socials->isNotEmpty())
              <ul class="social">
                @foreach ($socials as $s)
                  <li>
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['label'] }}"><i
                        class="{{ $s['icon'] }}"></i></a>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>

          <div class="colB">
            <h5>Shop</h5>
            <ul>
              {{-- Categories (show_in_navbar) --}}
              @foreach ($navCategories as $navCat)
                <li><a href="{{ route('category.show', $navCat->slug) }}">{{ $navCat->name }}</a></li>
              @endforeach

              {{-- Collections (show_in_navbar): New Arrivals, Bestsellers, Offers... --}}
              @foreach ($navBarCollections as $navBarCol)
                <li>
                  <a href="{{ route('products', ['collection' => [$navBarCol->slug]]) }}">{{ $navBarCol->name }}</a>
                </li>
              @endforeach

              {{-- Sab products --}}
              <li><a href="{{ route('products') }}">All Products</a></li>
            </ul>
          </div>

          <div class="colC">
            <h5>Customer Care</h5>
            <ul>
              <li><a href="{{ route('contact') }}">Contact Us</a></li>
              @if ($authCustomer && $dashUrl)
                <li><a href="{{ $dashUrl }}#tab-1">My Account</a></li>
                <li><a href="{{ $dashUrl }}#tab-3">My Orders</a></li>
                <li><a href="{{ $dashUrl }}#tab-4">Wishlist</a></li>
              @else
                <li><a href="javascript:void(0)" data-model=".login-pop">My Account</a></li>
                <li><a href="javascript:void(0)" data-model=".login-pop">My Orders</a></li>
                <li><a href="javascript:void(0)" data-model=".login-pop">Wishlist</a></li>
              @endif
              @foreach ($pageLinks(['shipping-policy', 'returns-exchange']) as $pg)
                <li><a href="{{ $pg->url }}">{{ $pg->heading }}</a></li>
              @endforeach
              <li><a href="{{ route('faqs') }}">FAQs</a></li>
            </ul>
          </div>

          <div class="colD">
            <h5>Information</h5>
            <ul>
              <li><a href="{{ route('about') }}">About Us</a></li>
              <li><a href="{{ route('blogs') }}">Blogs</a></li>
              @foreach ($pageLinks(['privacy-policy', 'terms-conditions', 'refund-cancellation-policy']) as $pg)
                <li><a href="{{ $pg->url }}">{{ $pg->heading }}</a></li>
              @endforeach
            </ul>
          </div>

          <div class="colE">
            <h5>Contact</h5>
            <h6 class="help-title">Need Help? We're Here for You.</h6>
            <p class="desc">
              Get in touch with our team for assistance with products, orders and more.
            </p>
            <a href="{{ route('contact') }}" class="btn btn-white">Contact Us <i
                class="fa-solid fa-arrow-right-long"></i></a>
          </div>

        </div>
      </div>

      <div class="footer-bottom">
        <div class="container">
          <p class="copyright">
            {{ $general->footer_copyright ?: '© ' . date('Y') . ' ' . $siteName . '. All Rights Reserved.' }}
          </p>
          <ul class="legal">
            @foreach ($pageLinks(['privacy-policy', 'terms-conditions', 'shipping-policy', 'returns-exchange']) as $pg)
              <li><a href="{{ $pg->url }}">{{ $pg->heading }}</a></li>
            @endforeach
          </ul>
          <p class="credit">
            Design &amp; Developed by
            <a href="javascript:void(0)" target="_blank" rel="noopener">Web Mingo</a>.
          </p>
        </div>
      </div>
    </div>

    <nav class="float-menu" aria-label="Quick navigation">
      <a href="{{ route('home') }}" class="float-link active"><i class="fa-solid fa-house"></i><span>Home</span></a>
      <button type="button" class="float-link" data-model=".ham-pop" aria-label="Menu">
        <i class="fa-solid fa-bars"></i><span>Menu</span>
      </button>
      @if ($authCustomer && $dashUrl)
        <a href="{{ $dashUrl }}#tab-4" class="float-link"><i class="fa-regular fa-heart"></i><span>Wishlist</span><b
            class="f-count wishlist-count">{{ $wishCount }}</b></a>
      @else
        <button type="button" class="float-link" data-model=".login-pop" aria-label="Wishlist"><i
            class="fa-regular fa-heart"></i><span>Wishlist</span><b
            class="f-count wishlist-count">{{ $wishCount }}</b></button>
      @endif
      <a href="{{ route('cart') }}" class="float-link"><i class="fa-solid fa-bag-shopping"></i><span>Bag</span><b
          class="f-count cart-count">{{ $cartCount }}</b></a>
      @if ($authCustomer)
        <a href="{{ $dashUrl ?? 'javascript:void(0)' }}" class="float-link"><i
            class="fa-regular fa-user"></i><span>Account</span></a>
      @else
        <button type="button" class="float-link" data-model=".login-pop" aria-label="Login"><i
            class="fa-regular fa-user"></i><span>Login</span></button>
      @endif
    </nav>
  </footer>

  <!-- start-models -->
  <div class="model cart-pop">
    <button class="close" type="button">
      <p>Close</p>
      <svg width="20" height="20" viewBox="0 0 26 26" fill="none">
        <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>
    <div class="model-body" id="miniCart">
      @include('layouts.mini-cart')
    </div>
  </div>

  <div class="model login-pop">
    <button class="close" type="button">
      <p>Close</p>
      <svg width="20" height="20" viewBox="0 0 26 26" fill="none">
        <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>

    <div class="model-body">
      <a href="{{ route('home') }}" class="pop-logo" aria-label="{{ $siteName }} Home">
        @if ($headerLogo)
          <img src="{{ $headerLogo }}" alt="{{ $siteName }}" />
        @endif
      </a>

      <div class="pop-title">
        <h3>Welcome Back</h3>
        <p>
          Login or create an account to track your orders, save your wishlist
          and check out faster.
        </p>
      </div>

      <!-- tabs: tumhara common tab JS -->
      <ul class="tab-nav">
        <li class="active" data-tab="pop-login">Login</li>
        <li data-tab="pop-register">Create Account</li>
      </ul>

      <div class="tab-nav-content">
        <!-- LOGIN -->
        <div class="tabs active" data-tab="pop-login">
          <form class="form pop-form" novalidate>
            <div class="form-group">
              <input type="text" id="popLoginId" name="login_id" placeholder=" " autocomplete="username" />
              <label for="popLoginId">Email or Mobile Number</label>
            </div>

            <div class="form-group">
              <input type="password" id="popLoginPass" name="password" placeholder=" "
                autocomplete="current-password" />
              <label for="popLoginPass">Password</label>
            </div>

            <div class="pop-meta">
              <a href="javascript:void(0);">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary pop-submit">
              Login
            </button>
          </form>

          <div class="pop-divider"><span>or</span></div>

          <button type="button" class="pop-google">
            <svg width="18" height="18" viewBox="0 0 48 48" aria-hidden="true">
              <path fill="#EA4335"
                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
              <path fill="#4285F4"
                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
              <path fill="#FBBC05"
                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
              <path fill="#34A853"
                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
            </svg>
            Continue with Google
          </button>
        </div>

        <!-- CREATE ACCOUNT -->
        <div class="tabs" data-tab="pop-register">
          <form class="form pop-form" novalidate>
            <div class="form-group">
              <input type="text" id="popRegName" name="name" placeholder=" " autocomplete="name" />
              <label for="popRegName">Full Name</label>
            </div>

            <div class="form-group">
              <input type="email" id="popRegEmail" name="email" placeholder=" " autocomplete="email" />
              <label for="popRegEmail">Email Address</label>
            </div>

            <div class="pop-row">
              <div class="form-group">
                <input type="tel" id="popRegMobile" name="mobile" placeholder=" " inputmode="numeric" maxlength="10"
                  autocomplete="tel" />
                <label for="popRegMobile">Mobile Number</label>
              </div>

              <div class="form-group">
                <input type="tel" id="popRegAlt" name="alternate_mobile" placeholder=" " inputmode="numeric"
                  maxlength="10" autocomplete="off" />
                <label for="popRegAlt">Alternate (optional)</label>
              </div>
            </div>

            <div class="form-group">
              <input type="password" id="popRegPass" name="password" placeholder=" " autocomplete="new-password" />
              <label for="popRegPass">Create Password</label>
            </div>

            <div class="form-group">
              <input type="password" id="popRegConfirm" name="password_confirmation" placeholder=" "
                autocomplete="new-password" />
              <label for="popRegConfirm">Confirm Password</label>
            </div>

            <button type="submit" class="btn btn-primary pop-submit">
              Register Account
            </button>
            
            @php $tc = $policyPages->get('terms-conditions');
            $pp = $policyPages->get('privacy-policy'); @endphp
            @if ($tc || $pp)
              <p class="pop-note">
                By continuing, you agree to our
                @if ($tc)<a href="{{ $tc->url }}" target="_blank">Terms &amp; Conditions</a>@endif
                @if ($tc && $pp) and @endif
                @if ($pp)<a href="{{ $pp->url }}" target="_blank">Privacy Policy</a>@endif.
              </p>
            @endif
          </form>

          <div class="pop-divider"><span>or</span></div>

          <button type="button" class="pop-google">
            <svg width="18" height="18" viewBox="0 0 48 48" aria-hidden="true">
              <path fill="#EA4335"
                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
              <path fill="#4285F4"
                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
              <path fill="#FBBC05"
                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
              <path fill="#34A853"
                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
            </svg>
            Continue with Google
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="model product-view-pop">
    <div class="model-body">
      <button class="close close-btn" type="button" aria-label="Close quick view">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
      </button>

      <div class="pvp-grid">
        <div class="pvp-visual">
          <img id="pvpImg" src="{{ asset('assets/images/home/tab1.png') }}" alt="" />
          <span class="pvp-badge" id="pvpBadge" style="display:none"></span>
        </div>

        <div class="pvp-content">
          <div class="pvp-meta">
            <span class="pvp-cat" id="pvpCat"></span>
            <span class="pvp-rate" id="pvpRate" style="display:none"><i class="fa-solid fa-star"></i> <b></b></span>
          </div>

          <h4 class="pvp-title"><a href="javascript:void(0)" id="pvpTitleLink"></a></h4>

          <div class="pvp-price">
            <span class="price-now" id="pvpNow"></span>
            <del class="price-old" id="pvpOld" style="display:none"></del>
            <span class="price-off" id="pvpOff" style="display:none"></span>
          </div>

          <p class="pvp-desc" id="pvpDesc" style="display:none"></p>
          <p class="pvp-stock" id="pvpStock"></p>

          <div class="pvp-actions">
            <div class="pvp-qty qty">
              <button type="button" class="pvp-minus" aria-label="Decrease quantity">
                <i class="fa-solid fa-minus"></i>
              </button>
              <input type="text" class="pvp-qty-input" id="pvpQty" value="1" readonly aria-label="Quantity" />
              <button type="button" class="pvp-plus" aria-label="Increase quantity">
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <button type="button" class="btn btn-outline-primary pvp-cart" id="pvpAdd">Add to Cart</button>
          </div>

          <p class="pvp-msg" id="pvpMsg" style="display:none"></p>

          <button type="button" class="wish-link pvp-wish" id="pvpWish" data-id="" aria-pressed="false">
            <i class="fa-regular fa-heart"></i> <span>Add to Wishlist</span>
          </button>

          <a href="javascript:void(0)" class="btn btn-primary pvp-buy" id="pvpView">
            View Full Details <i class="fa-solid fa-arrow-right-long"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= jQuery ================= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-visible/1.2.0/jquery.visible.min.js"
    integrity="sha512-771ZvVCYr4EfUGXr63AcX7thw7EKa6QE1fhxi8JG7mPacB/arC0cyvYPXKUkCrX2sYKnnFCZby3ZZik42jOuSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/jquery-ui.min.js"
    integrity="sha512-MlEyuwT6VkRXExjj8CdBKNgd+e2H+aYZOCUaCrt9KRk6MlZDOs91V1yK22rwm8aCIsb5Ec1euL8f0g58RKT/Pg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/js/glightbox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

  <!-- ================= Swiper ================= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>

  <!-- ================= Project JS ================= -->
  <script type="text/javascript" src="{{ asset('assets/js/animate.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/fancybox.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/function.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/main.js')}}"></script>

  <script>
    (function () {
      var el = document.querySelector(".announcement-swiper");
      if (!el) return;

      var slides = el.querySelectorAll(".swiper-slide").length;

      new Swiper(el, {
        direction: "vertical",
        slidesPerView: 1,
        loop: slides > 1,
        speed: 700,
        allowTouchMove: false,
        autoplay: slides > 1 ? {
          delay: 3500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        } : false,
      });
    })();
  </script>

  <script>
    const header = document.querySelector("header");
    const onScroll = () =>
      header.classList.toggle("header-fixed", window.scrollY > 40);
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();

    // Search: tap to open on touch devices, close on outside click
    const sb = document.querySelector(".search-box-wrapper");
    sb.querySelector(".search-btn").addEventListener("click", (e) => {
      e.stopPropagation();
      sb.classList.toggle("open");
      if (sb.classList.contains("open"))
        sb.querySelector(".searchInput").focus();
    });
    document.addEventListener("click", (e) => {
      if (!sb.contains(e.target)) sb.classList.remove("open");
    });
  </script>

  <script>
    (function () {
      var input = document.querySelector('.searchInput');
      if (!input) return;

      var box = input.closest('.formField'),
        list = box.querySelector('.res-list'),
        title = box.querySelector('.res-title'),
        empty = box.querySelector('.res-empty'),
        all = box.querySelector('.res-all'),
        url = input.dataset.url,
        allUrl = input.dataset.all,
        timer = null, ctrl = null, lastQ = null;

      function esc(s) {
        var d = document.createElement('div');
        d.textContent = s == null ? '' : s;
        return d.innerHTML;
      }

      function render(d) {
        var q = d.query || '';
        title.textContent = q ? 'Results' : 'Suggestions';
        all.href = q ? allUrl + '?q=' + encodeURIComponent(q) : allUrl;

        // data-name = typed query, taaki purana main.js filter (agar hai) in items ko hide na kare
        list.innerHTML = d.items.map(function (p) {
          return '<li data-name="' + esc(q.toLowerCase()) + '"><a href="' + esc(p.url) + '">' +
            '<img src="' + esc(p.image) + '" alt="' + esc(p.name) + '" />' +
            '<span class="res-text"><b>' + esc(p.name) + '</b>' +
            (p.category ? '<small>' + esc(p.category) + '</small>' : '') + '</span>' +
            '<span class="res-price">' + esc(p.price) + '</span></a></li>';
        }).join('');

        var none = d.items.length === 0;
        list.style.display = none ? 'none' : '';
        empty.style.display = none && q ? 'block' : 'none';
        title.style.display = none ? 'none' : '';
      }

      function fetchResults() {
        var q = input.value.trim();
        if (q === lastQ) return;
        lastQ = q;

        if (ctrl) ctrl.abort();
        ctrl = new AbortController();

        fetch(url + '?q=' + encodeURIComponent(q), {
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
          signal: ctrl.signal
        })
          .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
          .then(render)
          .catch(function (e) { if (e.name !== 'AbortError') console.error('Search failed:', e); });
      }

      input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(fetchResults, 250);
      });

      input.addEventListener('focus', fetchResults);

      // Enter: poore results page par
      input.addEventListener('keydown', function (e) {
        if (e.key !== 'Enter') return;
        var q = input.value.trim();
        if (q) window.location.href = allUrl + '?q=' + encodeURIComponent(q);
      });
    })();
  </script>

  <script>
    // Lehenga campaign: reveal when the section scrolls into view
    (function () {
      var sec = document.querySelector(".home-secE");
      if (!sec) return;

      sec.classList.add("js-ready");

      if (!("IntersectionObserver" in window)) {
        sec.classList.add("in");
        return;
      }

      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (e) {
            if (e.isIntersecting) {
              sec.classList.add("in");
              io.disconnect();
            }
          });
        },
        { threshold: 0.2 },
      );

      io.observe(sec);
    })();
  </script>

  <script>
    $(function () {
      var QTY_URL = @json(route('cart.update.quantity')),
        REMOVE_URL = @json(route('cart.remove', ['id' => '__ID__'])),
        CSRF = @json(csrf_token()),
        busy = false;

      function miniRun($li, url, data) {
        if (busy) return;
        busy = true;
        $li.addClass('is-updating');
        $('#miniCartMsg').hide();

        $.ajax({ url: url, method: 'POST', data: $.extend({ _token: CSRF }, data), dataType: 'json' })
          .done(function (r) {
            if (r.mini_cart_html) $('#miniCart').html(r.mini_cart_html);
            if (r.cart_count !== undefined) $('.cart-count').text(r.cart_count);
            $(document).trigger('cart:changed', [r]);
            // the cart page itself has to redraw too
            if ($('#cartList').length) window.location.reload();
          })
          .fail(function (xhr) {
            $li.removeClass('is-updating');
            var m = xhr.status === 419 ? 'Your session expired. Please refresh the page.'
              : (xhr.responseJSON && xhr.responseJSON.message) || 'Could not update your bag. Please try again.';
            $('#miniCartMsg').text(m).show();
          })
          .always(function () { busy = false; });
      }

      $(document).on('click', '.cp-item .qty-plus, .cp-item .qty-minus', function () {
        var $li = $(this).closest('.cp-item');
        miniRun($li, QTY_URL, { item_id: $li.data('id'), action: $(this).hasClass('qty-plus') ? 'plus' : 'minus' });
      });

      $(document).on('click', '.cp-item .cp-remove', function () {
        var $li = $(this).closest('.cp-item');
        miniRun($li, REMOVE_URL.replace('__ID__', $li.data('id')), { _method: 'DELETE' });
      });
    });
  </script>

  <script>
    $(function () {
      var LOGIN_URL = @json(route('checkout.ajax-login')),
        REGISTER_URL = @json(route('checkout.ajax-register')),
        GOOGLE_URL = @json(route('user.google.login')),
        CSRF = @json(csrf_token());

      function errText(xhr) {
        var j = xhr.responseJSON || {};
        if (xhr.status === 422 && j.errors) return Object.values(j.errors)[0][0];
        if (j.message) return j.message;
        if (xhr.status === 419) return 'Your session expired. Please refresh the page.';
        if (xhr.status === 429) return 'Too many attempts. Please try again in a minute.';
        return 'Something went wrong. Please try again.';
      }

      $(document).on('submit', '.login-pop .pop-form', function (e) {
        e.preventDefault();

        var $f = $(this),
          $btn = $f.find('.pop-submit'),
          isLogin = $f.closest('.tabs').data('tab') === 'pop-login';

        $f.find('.pop-err').remove();
        $btn.prop('disabled', true);

        $.ajax({
          url: isLogin ? LOGIN_URL : REGISTER_URL,
          method: 'POST',
          data: $f.serialize() + '&_token=' + encodeURIComponent(CSRF),
          dataType: 'json'
        }).done(function () {
          window.location.reload(); // new session and token, and the guest cart is already merged
        }).fail(function (xhr) {
          $btn.prop('disabled', false);
          $('<p class="pop-err">').text(errText(xhr)).insertBefore($btn);
        });
      });

      // Google: come back to the same page
      $(document).on('click', '.login-pop .pop-google', function () {
        window.location.href = GOOGLE_URL + '?redirect=' + encodeURIComponent(window.location.href);
      });
    });
  </script>

  @if (session('open_auth'))
    <script>
      $(function () {
        setTimeout(function () {
          var tab = document.querySelector('.login-pop .tab-nav li[data-tab="pop-{{ session('open_auth') === 'register' ? 'register' : 'login' }}"]'),
            open = document.querySelector('[data-model=".login-pop"]');
          if (tab) tab.click();
          if (open) open.click();
        }, 300);
      });
    </script>
  @endif

  <script>
    $(function () {
      var QV_URL = @json(route('products.quick-view', ['id' => '__ID__'])),
        QV_CART_URL = @json(route('cart.add')),
        QV_CSRF = @json(csrf_token()),
        $pop = $('.product-view-pop'),
        cur = null, req = null, busy = false;

      function msg(text) {
        $('#pvpMsg').text(text).show();
      }

      function failMessage(xhr, fallback) {
        var m = fallback;
        if (xhr.status === 419) m = 'Your session expired. Please refresh the page and try again.';
        else if (xhr.status === 429) m = 'Too many attempts. Please try again in a minute.';
        else if (xhr.responseJSON) {
          m = xhr.responseJSON.message || m;
          if (xhr.responseJSON.errors) m = Object.values(xhr.responseJSON.errors)[0][0];
        }
        return m;
      }

      function paintWish(on) {
        $('#pvpWish').toggleClass('is-active', on).attr('aria-pressed', on ? 'true' : 'false')
          .find('i').toggleClass('fa-solid', on).toggleClass('fa-regular', !on).end()
          .find('span').text(on ? 'Wishlisted' : 'Add to Wishlist');
      }

      function fill(p) {
        cur = p;

        $('#pvpImg').attr({ src: p.image, alt: p.name });
        $('#pvpBadge').text(p.badge || '').toggle(!!p.badge);
        $('#pvpCat').text(p.category);
        $('#pvpRate').toggle(!!p.rating).find('b').text(p.rating);
        $('#pvpTitleLink').text(p.name).attr('href', p.url);

        $('#pvpNow').text(p.price_fmt);
        $('#pvpOld').text(p.mrp_fmt).toggle(p.off > 0);
        $('#pvpOff').text(p.off + '% OFF').toggle(p.off > 0);

        $('#pvpDesc').text(p.description || '').toggle(!!p.description);
        $('#pvpStock').text(p.in_stock ? 'In Stock' : 'Out of Stock').toggleClass('is-out', !p.in_stock);

        $('#pvpQty').val(p.min_qty);
        $('#pvpAdd').toggleClass('disabled', !p.in_stock).attr('aria-disabled', !p.in_stock);
        $('#pvpView').attr('href', p.url);

        // set the attribute AND jQuery's cache: the shared wishlist handler reads .data('id')
        $('#pvpWish').attr('data-id', p.id).data('id', p.id);
        paintWish(p.wished);

        $('#pvpMsg').hide();
        $pop.removeClass('is-loading');
      }

      // ── open: fetch the product the card points at ──
      $(document).on('click', '.quick-btn', function () {
        var id = $(this).data('id');
        if (req) req.abort();

        cur = null;
        $('#pvpMsg').hide();
        $pop.addClass('is-loading');
        $('#pvpAdd').addClass('disabled');

        req = $.getJSON(QV_URL.replace('__ID__', id))
          .done(fill)
          .fail(function (xhr, status) {
            if (status === 'abort') return;
            $pop.removeClass('is-loading');
            msg(failMessage(xhr, 'Could not load this product. Please try again.'));
          });
      });

      // ── quantity ──
      $(document).on('click', '.pvp-plus, .pvp-minus', function () {
        if (!cur) return;
        var v = parseInt($('#pvpQty').val(), 10) || cur.min_qty;

        if ($(this).hasClass('pvp-plus')) {
          if (cur.stock && v + 1 > cur.stock) return msg('Only ' + cur.stock + ' units available.');
          v++;
        } else {
          v = Math.max(cur.min_qty, v - 1);
        }
        $('#pvpMsg').hide();
        $('#pvpQty').val(v);
      });

      // ── add to cart ──
      $(document).on('click', '#pvpAdd', function () {
        var $b = $(this);
        if (!cur || busy || $b.hasClass('disabled')) return;

        busy = true;
        var label = $b.html();
        $b.addClass('is-loading').text('Adding...');
        $('#pvpMsg').hide();

        $.ajax({
          url: QV_CART_URL, method: 'POST', dataType: 'json',
          data: { _token: QV_CSRF, product_id: cur.id, quantity: parseInt($('#pvpQty').val(), 10) || cur.min_qty }
        }).done(function (r) {
          if (r.mini_cart_html) $('#miniCart').html(r.mini_cart_html);
          if (r.cart_count !== undefined) $('.cart-count').text(r.cart_count);
          $(document).trigger('cart:added', [r]);

          // close quick view, then open the mini cart
          $pop.find('.close').first().trigger('click');
          setTimeout(function () {
            $('.action-link[data-model=".cart-pop"]').first().trigger('click');
          }, 350);
        }).fail(function (xhr) {
          // e.g. the server asks for options: the "View Full Details" link is right below
          msg(failMessage(xhr, 'Could not add to bag right now. Please try again.'));
        }).always(function () {
          busy = false;
          $b.removeClass('is-loading').html(label);
        });
      });
    });
  </script>

  @include('partials.card-cart-js')
  @stack('scripts')

</body>

</html>