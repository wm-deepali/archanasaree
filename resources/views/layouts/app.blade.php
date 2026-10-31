<!doctype html>
@php
  $authCustomer = auth('customer')->user();
  $dashUrl = Route::has('user.dashboard.index') ? route('user.dashboard.index') : null;
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
          <p class="ann-left">
            Premium Sarees · Designer Lehengas · Bridal Wear
          </p>

          <div class="swiper announcement-swiper ann-center">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <p>Celebrate Every Occasion in Timeless Elegance</p>
              </div>
              <div class="swiper-slide">
                <p>
                  Free Express Delivery Across India on Orders Above ₹4,999
                  <a href="javascript:void(0)">Shop Now</a>
                </p>
              </div>
              <div class="swiper-slide">
                <p>
                  Wedding Season Edit — Bridal Lehengas &amp; Banarasi Sarees
                  <a href="javascript:void(0)">Explore</a>
                </p>
              </div>
              <div class="swiper-slide">
                <p>
                  Visit Our Chandni Chowk Store — Trusted Since Generations
                </p>
              </div>
            </div>
          </div>

          <!-- ===== NEW: Social media icons (ann-right ki jagah) ===== -->
          <ul class="ann-social">
            <li>
              <a href="javascript:void(0)" aria-label="Facebook" title="Facebook"><i
                  class="fa-brands fa-facebook-f"></i></a>
            </li>
            <li>
              <a href="javascript:void(0)" aria-label="Instagram" title="Instagram"><i
                  class="fa-brands fa-instagram"></i></a>
            </li>
            <li>
              <a href="javascript:void(0)" aria-label="Pinterest" title="Pinterest"><i
                  class="fa-brands fa-pinterest-p"></i></a>
            </li>
            <li>
              <a href="javascript:void(0)" aria-label="YouTube" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </li>
            <li>
              <a href="javascript:void(0)" aria-label="WhatsApp" title="WhatsApp"><i
                  class="fa-brands fa-whatsapp"></i></a>
            </li>
          </ul>
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
            <img src="{{ asset('assets/images/logo.png')}}" alt="Archana Saree Emporium"
              title="Archana Saree Emporium" />
          </a>
        </div>

        <div class="colB">
          <ul class="menu-list">
            <li class="active"><a href="{{ route('home') }}">Home</a></li>

            <li class="hasMega">
              <a href="category-listing.html">
                Saree
                <svg class="chev" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 9l6 6 6-6" />
                </svg>
              </a>
              <div class="mega-menu">
                <div class="mega-inner">
                  <div class="mega-links">
                    <h4><a href="category-listing.html">Shop Sarees</a></h4>
                    <ul>
                      <li><a href="product-listing.html">Bridal Saree</a></li>
                      <li><a href="product-listing.html">Party Wears</a></li>
                      <li>
                        <a href="product-listing.html">Cocktail Saree</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Banarsi Saree</a>
                      </li>
                      <li><a href="product-listing.html">Net Sarees</a></li>
                    </ul>
                  </div>
                  <a href="category-listing.html" class="mega-feature">
                    <img src="{{ asset('assets/images/home/cat1.png')}}" alt="The Saree Edit" loading="lazy" />
                    <span class="feature-text">
                      <span class="feature-label">The Saree Edit</span>
                      <span class="feature-desc">Timeless drapes for every celebration.</span>
                      <span class="feature-link">
                        Explore Sarees
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M3 12h18M15 6l6 6-6 6" />
                        </svg>
                      </span>
                    </span>
                  </a>
                </div>
              </div>
            </li>

            <li class="hasMega">
              <a href="category-listing.html">
                Lehenga
                <svg class="chev" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 9l6 6 6-6" />
                </svg>
              </a>
              <div class="mega-menu">
                <div class="mega-inner">
                  <div class="mega-links">
                    <h4><a href="product-listing.html">Shop Lehengas</a></h4>
                    <ul>
                      <li>
                        <a href="product-listing.html">Designer Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Bridal Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Party Wear Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Wedding Guest Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Sangeet &amp; Mehendi</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Embroidered Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Velvet Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Organza Lehengas</a>
                      </li>
                    </ul>
                  </div>
                  <a href="category-listing.html" class="mega-feature">
                    <img src="{{ asset('assets/images/home/cat2.png')}}" alt="The Lehenga Edit" loading="lazy" />
                    <span class="feature-text">
                      <span class="feature-label">The Lehenga Edit</span>
                      <span class="feature-desc">Statement silhouettes for every celebration.</span>
                      <span class="feature-link">
                        Explore Lehengas
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M3 12h18M15 6l6 6-6 6" />
                        </svg>
                      </span>
                    </span>
                  </a>
                </div>
              </div>
            </li>

            <li class="hasMega">
              <a href="category-listing.html">
                Bridal Wear
                <svg class="chev" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 9l6 6 6-6" />
                </svg>
              </a>
              <div class="mega-menu">
                <div class="mega-inner">
                  <div class="mega-links">
                    <h4>
                      <a href="product-listing.html">Shop Bridal Wear</a>
                    </h4>
                    <ul>
                      <li>
                        <a href="product-listing.html">Bridal Lehengas</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Bridal Sarees</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Reception Wear</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Engagement Wear</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Haldi &amp; Mehendi</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Sangeet Outfits</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Bridal Dupattas</a>
                      </li>
                      <li>
                        <a href="javascript:void(0)">Heirloom Collection</a>
                      </li>
                    </ul>
                  </div>
                  <a href="category-listing.html" class="mega-feature">
                    <img src="{{ asset('assets/images/home/cat3.png')}}" alt="The Bridal Edit" loading="lazy" />
                    <span class="feature-text">
                      <span class="feature-label">The Bridal Edit</span>
                      <span class="feature-desc">Heirloom pieces for your most special day.</span>
                      <span class="feature-link">
                        Explore Bridal Wear
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M3 12h18M15 6l6 6-6 6" />
                        </svg>
                      </span>
                    </span>
                  </a>
                </div>
              </div>
            </li>

            <!-- ===== Shop by Collection (Mega Menu, no image) ===== -->
            <li class="hasMega">
              <a href="category-listing.html">
                Shop by Collection
                <svg class="chev" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 9l6 6 6-6" />
                </svg>
              </a>
              <div class="mega-menu mega-collection">
                <div class="mega-collection-inner">
                  <div class="mega-col">
                    <h4>Shop by Fabrics</h4>
                    <ul>
                      <li><a href="product-listing.html">Mul Chanderi</a></li>
                      <li>
                        <a href="product-listing.html">Viscose Georgette</a>
                      </li>
                      <li><a href="product-listing.html">Cotton</a></li>
                      <li><a href="product-listing.html">Pure Organza</a></li>
                      <li><a href="product-listing.html">Linen</a></li>
                      <li><a href="product-listing.html">Kota</a></li>
                      <li>
                        <a href="product-listing.html">Pure Georgette</a>
                      </li>
                      <li><a href="product-listing.html">Silk</a></li>
                      <li><a href="product-listing.html">Tissue</a></li>
                      <li><a href="product-listing.html">Chanderi</a></li>
                    </ul>
                  </div>

                  <div class="mega-col">
                    <h4>Shop by Color</h4>
                    <ul>
                      <li><a href="product-listing.html">Red</a></li>
                      <li><a href="product-listing.html">Blue</a></li>
                      <li><a href="product-listing.html">Green</a></li>
                      <li><a href="product-listing.html">Yellow</a></li>
                      <li><a href="product-listing.html">Black</a></li>
                      <li><a href="product-listing.html">White</a></li>
                      <li><a href="product-listing.html">Pink</a></li>
                      <li><a href="product-listing.html">Brown</a></li>
                      <li><a href="product-listing.html">Orange</a></li>
                      <li><a href="product-listing.html">Purple</a></li>
                    </ul>
                  </div>

                  <div class="mega-col">
                    <h4>Shop by Collections</h4>
                    <ul>
                      <li><a href="product-listing.html">New Arrival</a></li>
                      <li><a href="product-listing.html">Best Sellers</a></li>
                      <li><a href="product-listing.html">Premium Wear</a></li>
                      <li>
                        <a href="product-listing.html">Exclusive Collection</a>
                      </li>
                      <li><a href="product-listing.html">Festive Sale</a></li>
                    </ul>
                  </div>

                  <div class="mega-col">
                    <h4>Price Range</h4>
                    <ul>
                      <li><a href="product-listing.html">Under ₹2,999</a></li>
                      <li>
                        <a href="product-listing.html">₹3,000 - ₹5,999</a>
                      </li>
                      <li>
                        <a href="product-listing.html">₹6,000 - ₹9,999</a>
                      </li>
                      <li>
                        <a href="product-listing.html">₹10,000 - ₹14,999</a>
                      </li>
                      <li>
                        <a href="product-listing.html">₹15,000 and Above</a>
                      </li>
                    </ul>
                  </div>

                  <div class="mega-col">
                    <h4>Shop by Occasions</h4>
                    <ul>
                      <li>
                        <a href="product-listing.html">Elegant Ethnic Wear</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Office/Everyday Wear</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Indo-Western Collection</a>
                      </li>
                      <li>
                        <a href="product-listing.html">Festive/Occasion Wear</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <!-- ===== /Shop by Collection ===== -->

            <li><a href="category-listing.html">New Arrivals</a></li>
            <li><a href="category-listing.html">Offers</a></li>
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
              <input type="text" class="searchInput" placeholder="Search sarees, lehengas, bridal wear..."
                autocomplete="off" />

              <div class="search-results">
                <p class="res-title">Suggestions</p>
                <ul class="res-list">
                  <li data-name="kanjivaram pure silk saree silk">
                    <a href="product-detail.html">
                      <img src="{{ asset('assets/images/home/tab1.png')}}" alt="Kanjivaram Pure Silk Saree" />
                      <span class="res-text">
                        <b>Kanjivaram Pure Silk Saree</b>
                        <small>Silk Saree</small>
                      </span>
                      <span class="res-price">₹12,999</span>
                    </a>
                  </li>
                  <li data-name="banarasi zari woven silk saree banarsi">
                    <a href="product-detail.html">
                      <img src="{{ asset('assets/images/home/tab2.png')}}" alt="Banarasi Zari Woven Silk Saree" />
                      <span class="res-text">
                        <b>Banarasi Zari Woven Silk Saree</b>
                        <small>Banarasi Saree</small>
                      </span>
                      <span class="res-price">₹8,499</span>
                    </a>
                  </li>
                  <li data-name="organza floral embroidered saree">
                    <a href="product-detail.html">
                      <img src="{{ asset('assets/images/home/tab3.png')}}" alt="Organza Floral Embroidered Saree" />
                      <span class="res-text">
                        <b>Organza Floral Embroidered Saree</b>
                        <small>Organza Saree</small>
                      </span>
                      <span class="res-price">₹6,799</span>
                    </a>
                  </li>
                  <li data-name="velvet bridal lehenga">
                    <a href="product-detail.html">
                      <img src="{{ asset('assets/images/home/tab2.png')}}" alt="Velvet Bridal Lehenga" />
                      <span class="res-text">
                        <b>Velvet Bridal Lehenga</b>
                        <small>Bridal Lehenga</small>
                      </span>
                      <span class="res-price">₹38,999</span>
                    </a>
                  </li>
                  <li data-name="sequined reception lehenga party">
                    <a href="product-detail.html">
                      <img src="{{ asset('assets/images/home/tab3.png')}}" alt="Sequined Reception Lehenga" />
                      <span class="res-text">
                        <b>Sequined Reception Lehenga</b>
                        <small>Party Lehenga</small>
                      </span>
                      <span class="res-price">₹18,499</span>
                    </a>
                  </li>
                  <li data-name="pastel organza lehenga">
                    <a href="product-detail.html">
                      <img src="{{ asset('assets/images/home/tab4.png')}}" alt="Pastel Organza Lehenga" />
                      <span class="res-text">
                        <b>Pastel Organza Lehenga</b>
                        <small>Organza Lehenga</small>
                      </span>
                      <span class="res-price">₹21,299</span>
                    </a>
                  </li>
                </ul>
                <p class="res-empty">
                  No products found. Try a different keyword.
                </p>
                <a href="product-listing.html" class="res-all">
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
                    <li><a href="{{ $dashUrl }}"><i class="fa-solid fa-truck-fast"></i> Track Order</a></li>
                    <li><a href="{{ $dashUrl }}"><i class="fa-solid fa-box-open"></i> My Orders</a></li>
                  @endif
                  @if (Route::has('wishlist'))
                    <li><a href="{{ route('wishlist') }}"><i class="fa-regular fa-heart"></i> My Wishlist</a></li>
                  @endif
                  @if ($dashUrl)
                    <li><a href="{{ $dashUrl }}"><i class="fa-regular fa-user"></i> My Profile</a></li>
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
          <button data-model=".login-pop" class="action-link" aria-label="Wishlist">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20.5s-8-4.9-8-11A4.6 4.6 0 0112 6.8a4.6 4.6 0 018 2.7c0 6.1-8 11-8 11z" />
            </svg>
            <span class="count">0</span>
          </button>

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
            <a href="{{ route('home') }}" class="logo"><img src="{{ asset('assets/images/logo.png')}}"
                alt="Archana Saree Emporium" /></a>
            <span class="brand-tag">Premium Sarees · Designer Lehengas · Bridal Wear</span>
            <p class="brand-desc">
              Timeless Indian elegance, thoughtfully curated for every
              celebration.
            </p>
            <ul class="social">
              <li>
                <a href="#" target="_blank" rel="noopener" aria-label="Instagram"><i
                    class="fa-brands fa-instagram"></i></a>
              </li>
              <li>
                <a href="#" target="_blank" rel="noopener" aria-label="Facebook"><i
                    class="fa-brands fa-facebook-f"></i></a>
              </li>
              <li>
                <a href="#" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
              </li>
              <li>
                <a href="#" target="_blank" rel="noopener" aria-label="WhatsApp"><i
                    class="fa-brands fa-whatsapp"></i></a>
              </li>
            </ul>
          </div>

          <div class="colB">
            <h5>Shop</h5>
            <ul>
              <li><a href="category-listing.html">Sarees</a></li>
              <li><a href="category-listing.html">Lehengas</a></li>
              <li><a href="category-listing.html">Bridal Wear</a></li>
              <li><a href="category-listing.html">New Arrivals</a></li>
              <li><a href="product-listing.html">Bestsellers</a></li>
              <li><a href="category-listing.html">Collections</a></li>
              <li><a href="category-listing.html">Offers</a></li>
            </ul>
          </div>

          <div class="colC">
            <h5>Customer Care</h5>
            <ul>
              <li><a href="contact.html">Contact Us</a></li>
              <li><a href="javascript:void(0)">My Account</a></li>
              <li><a href="javascript:void(0)">My Orders</a></li>
              <li><a href="javascript:void(0)">Wishlist</a></li>
              <li><a href="shipping-policy.html">Shipping Information</a></li>
              <li>
                <a href="returns-exchange.html">Returns &amp; Exchange</a>
              </li>
              <li><a href="faqs.html">FAQs</a></li>
            </ul>
          </div>

          <div class="colD">
            <h5>Information</h5>
            <ul>
              <li><a href="about.html">About Us</a></li>
              <li><a href="blogs.html">Blogs</a></li>
              <li><a href="privacy-policy.html">Privacy Policy</a></li>
              <li>
                <a href="terms-conditions.html">Terms &amp; Conditions</a>
              </li>
              <li><a href="shipping-policy.html">Shipping Policy</a></li>
              <li>
                <a href="refund-cancellation-policy.html">Refund &amp; Cancellation Policy</a>
              </li>
            </ul>
          </div>

          <div class="colE">
            <h5>Contact</h5>
            <h6 class="help-title">Need Help? We're Here for You.</h6>
            <p class="desc">
              Get in touch with our team for assistance with products, orders
              and more.
            </p>
            <a href="contact.html" class="btn btn-white">Contact Us <i class="fa-solid fa-arrow-right-long"></i></a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div class="container">
          <p class="copyright">
            &copy; 2026 Archana Saree Emporium. All Rights Reserved.
          </p>
          <ul class="legal">
            <li><a href="privacy-policy.html">Privacy Policy</a></li>
            <li>
              <a href="terms-conditions.html">Terms &amp; Conditions</a>
            </li>
            <li><a href="shipping-policy.html">Shipping Policy</a></li>
            <li>
              <a href="returns-exchange.html">Returns &amp; Exchange</a>
            </li>
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
      <a href="wishlist.html" class="float-link"><i class="fa-regular fa-heart"></i><span>Wishlist</span><b
          class="f-count">0</b></a>
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
      <a href="javascript:void(0);" class="pop-logo" aria-label="Archana Saree Emporium Home">
        <img src="{{ asset('assets/images/logo.png')}}" alt="" />
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

            <p class="pop-note">
              By continuing, you agree to our
              <a href="javascript:void(0);">Terms &amp; Conditions</a> and
              <a href="javascript:void(0);">Privacy Policy</a>.
            </p>
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
    new Swiper(".announce-swiper", {
      direction: "vertical",
      slidesPerView: 1,
      loop: true,
      speed: 700,
      allowTouchMove: false,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
    });

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

  @stack('scripts')

</body>

</html>