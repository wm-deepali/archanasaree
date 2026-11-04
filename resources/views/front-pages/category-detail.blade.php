@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/listing/listing.css') }}" />
@endpush

@section('content')

  @php
    $activeSub = $activeSub ?? null;
    $catImage = $category->image ? asset('storage/' . $category->image) : null;
  @endphp

  <main>

    <section class="product-banner">
      <div class="banner-img">
        <img src="{{ $catImage ?? asset('assets/images/home/banner2.png') }}" alt="{{ $category->name }}" />
      </div>
      <div class="container">
        @include('partials.breadcrumb', [
          'crumbs' => array_values(array_filter([
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Categories', 'url' => route('categories')],
            $activeSub
              ? ['label' => $category->name, 'url' => route('category.show', $category->slug)]
              : ['label' => $category->name],
            $activeSub ? ['label' => $activeSub->name] : null,
          ]))
        ])
        <div class="banner-content">
          <span class="eyebrow">{{ $activeSub->name ?? $category->name }}</span>
          <h1>{{ $category->sub_title ?: $category->name }}</h1>
          @if ($category->meta_description)
            <p class="banner-desc">{{ $category->meta_description }}</p>
          @endif
          <a href="#catProducts" class="btn btn-primary">Shop {{ $category->name }}</a>
        </div>
      </div>
    </section>

    <section class="product-secB" id="catProducts">
      <div class="container">
        @php
          $tabs = collect([null])->merge($subCategories);
          $activeIndex = $activeSub
            ? $tabs->search(fn($t) => $t && $t->id === $activeSub->id)
            : 0;
          if ($activeIndex === false) {
            $activeIndex = 0;
          }
        @endphp

        <ul class="tab-nav">
          @foreach ($tabs as $i => $tab)
            <li data-tab="{{ $i + 1 }}" class="{{ $i === $activeIndex ? 'active' : '' }}">
              {{ $tab ? $tab->name : 'All ' . $category->name }}
            </li>
          @endforeach
        </ul>

        <div class="tab-nav-content">
          @foreach ($tabs as $i => $tab)
            @php $isActive = $i === $activeIndex; @endphp
            <div class="tabs {{ $isActive ? 'active' : '' }}" data-tab="{{ $i + 1 }}" data-sub="{{ $tab->slug ?? '' }}"
              @if ($isActive) data-loaded="1" @endif>

              <div class="prod-head">
                <h3>The {{ $category->name }} Collection</h3>
                <span class="prod-styles">{{ $isActive ? $products->total() . ' styles' : '' }}</span>
              </div>

              <div class="prod-toolbar">
                <p class="prod-count"><b>{{ $isActive ? $products->total() : '' }}</b> {{ $category->name }}</p>
                <div class="prod-tools">
                  <button type="button" class="tool-btn filter-btn" data-model=".filter-pop">
                    <i class="fa-solid fa-sliders"></i> Filter
                  </button>
                  <button type="button" class="tool-btn sort-btn" data-model=".sort-pop">
                    <i class="fa-solid fa-arrow-down-wide-short"></i> Sort
                  </button>
                  <div class="prod-sort">
                    <label for="prodSort{{ $i + 1 }}">Sort By</label>
                    <div class="sort-box">
                      <select id="prodSort{{ $i + 1 }}">
                        @foreach ($sortOptions as $val => $label)
                          <option value="{{ $val }}" @selected($currentSort === $val)>{{ $label }}</option>
                        @endforeach
                      </select>
                      <i class="fa-solid fa-chevron-down"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="prod-grid">
                @if ($isActive)
                  @include('partials.product-cards', ['products' => $products])
                @endif
              </div>

              <div class="load-more" @if (!$isActive || !$products->hasMorePages()) style="display:none" @endif>
                <button type="button" class="btn btn-outline-primary"
                  data-next="{{ $isActive && $products->hasMorePages() ? 2 : '' }}">
                  Load More {{ $category->name }}
                </button>
                <p>Showing {{ $isActive ? ($products->lastItem() ?? 0) : 0 }} of
                  {{ $isActive ? $products->total() : 0 }} styles</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    @if ($category->meta_description)
      <section class="product-secC">
        <div class="container">
          <div class="art-grid">
            <div class="art-visual">
              <div class="art-photo">
                <img src="{{ $catImage ?? asset('assets/images/home/banner5.jpg') }}"
                  alt="The Art of {{ $category->name }}" loading="lazy" />
              </div>
            </div>
            <div class="art-content">
              <div class="heading">
                <h3>The Art of {{ $category->name }}</h3>
              </div>
              <p>{{ $category->meta_description }}</p>
              <a href="#catProducts" class="btn btn-primary">Explore the Collection
                <i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
          </div>
        </div>
      </section>
    @endif

    @if ($recentlyViewed->count())
      <section class="product-secD">
        <div class="container">
          <div class="sec-head">
            <div class="heading">
              <h3>Recently Viewed</h3>
            </div>
            <p>Pieces you've looked at, gathered in one place.</p>
          </div>
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($recentlyViewed as $product)
                  <div class="swiper-slide">
                    @include('partials.product-card', ['product' => $product])
                  </div>
                @endforeach
              </div>
            </div>
            <div class="swiper-group">
              <button type="button" class="btn-prev" aria-label="Previous slide"><i
                  class="fa-solid fa-arrow-right"></i></button>
              <button type="button" class="btn-next" aria-label="Next slide"><i
                  class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
      </section>
    @endif

    @if ($alsoLike->count())
      <section class="product-secE">
        <div class="container">
          <div class="sec-head">
            <div class="heading">
              <h3>You May Also Like</h3>
            </div>
            <p>Discover more pieces selected to complement your style.</p>
          </div>
          <div class="swiper-wrap">
            <div class="swiper fourSlider">
              <div class="swiper-wrapper">
                @foreach ($alsoLike as $product)
                  <div class="swiper-slide">
                    @include('partials.product-card', ['product' => $product])
                  </div>
                @endforeach
              </div>
            </div>
            <div class="swiper-group">
              <button type="button" class="btn-prev" aria-label="Previous slide"><i
                  class="fa-solid fa-arrow-right"></i></button>
              <button type="button" class="btn-next" aria-label="Next slide"><i
                  class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
      </section>
    @endif

    <section class="product-secF">
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

  </main>

  <div class="model filter-pop">
    <button type="button" class="close" aria-label="Close filter">
      <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" />
      </svg>
    </button>
    <div class="model-body">
      <div class="title">
        <h4>Filter By</h4>
      </div>

      <div class="f-groups" id="catFilters">

        {{-- Sub Category --}}
        @if ($filterSubs->isNotEmpty())
          <details class="f-group" open>
            <summary>{{ $category->name }} Type <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              @foreach ($filterSubs as $s)
                <li>
                  <label><input type="checkbox" name="sub[]" value="{{ $s->slug }}" /> {{ $s->name }}</label>
                </li>
              @endforeach
            </ul>
          </details>
        @endif

        {{-- Attributes (Colour, Fabric, Size...): show_in_filter se --}}
        @foreach ($filterAttributes as $attr)
          <details class="f-group" @if ($loop->first) open @endif>
            <summary>{{ $attr->name }} <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              @foreach ($attr->values as $v)
                @php
                  $hex = $v->hex_code ? (str_starts_with($v->hex_code, '#') ? $v->hex_code : '#' . $v->hex_code) : null;
                @endphp
                <li>
                  <label>
                    <input type="checkbox" name="attr[{{ $attr->slug }}][]" value="{{ $v->slug }}" />
                    @if ($hex)
                      <span
                        style="display:inline-block;width:12px;height:12px;border-radius:50%;background:{{ $hex }};border:1px solid #ddd;vertical-align:middle"></span>
                    @endif
                    {{ $v->value }}
                  </label>
                </li>
              @endforeach
            </ul>
          </details>
        @endforeach

        {{-- Occasion --}}
        @if ($filterOccasions->isNotEmpty())
          <details class="f-group">
            <summary>Occasion <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              @foreach ($filterOccasions as $o)
                <li>
                  <label><input type="checkbox" name="occasion[]" value="{{ $o->slug }}" /> {{ $o->title }}</label>
                </li>
              @endforeach
            </ul>
          </details>
        @endif

        {{-- Collection --}}
        @if ($filterCollections->isNotEmpty())
          <details class="f-group">
            <summary>Collection <i class="fa-solid fa-chevron-down"></i></summary>
            <ul class="f-list">
              @foreach ($filterCollections as $c)
                <li>
                  <label><input type="checkbox" name="collection[]" value="{{ $c->slug }}" /> {{ $c->name }}</label>
                </li>
              @endforeach
            </ul>
          </details>
        @endif

        {{-- Price --}}
        <details class="f-group">
          <summary>Price <i class="fa-solid fa-chevron-down"></i></summary>
          <div id="catPrice" data-min="{{ $priceMin }}" data-max="{{ $priceMax }}"
            style="display:flex;align-items:center;gap:10px;padding:8px 0">
            <input type="number" name="price_min" value="{{ $priceMin }}" min="{{ $priceMin }}" max="{{ $priceMax }}"
              step="500" aria-label="Minimum price" style="width:100%;padding:8px 10px" />
            <span>–</span>
            <input type="number" name="price_max" value="{{ $priceMax }}" min="{{ $priceMin }}" max="{{ $priceMax }}"
              step="500" aria-label="Maximum price" style="width:100%;padding:8px 10px" />
          </div>
        </details>
      </div>

      <div class="f-foot">
        <button type="button" id="catFilterClear" class="btn btn-outline-primary">Clear All</button>
        <button type="button" id="catFilterApply" class="btn btn-primary">Apply Filters</button>
      </div>
    </div>
  </div>

  <div class="model sort-pop">
    <button type="button" class="close" aria-label="Close sort">
      <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" />
      </svg>
    </button>
    <div class="model-body">
      <div class="title">
        <h4>Sort By</h4>
      </div>
      <ul class="sort-list">
        @foreach ($sortOptions as $val => $label)
          <li>
            <label><input type="radio" name="SortBy" value="{{ $val }}" @checked($currentSort === $val) />
              {{ $label }}</label>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

@endsection

@push('scripts')
  <script>
    (function () {
      const baseUrl = @json(route('category.show', $category->slug));
      const root = document.querySelector('.product-secB');
      const popup = document.querySelector('.filter-pop');
      const sortPopup = document.querySelector('.sort-pop');
      const sortSelects = root.querySelectorAll('.prod-sort select');
      const sortRadios = document.querySelectorAll('.sort-pop input[name="SortBy"]');
      let filters = new URLSearchParams(); // applied filters, sab tabs/sort/load-more me jaate hain

      function load(pane, page, append) {
        const params = new URLSearchParams({
          sort: pane.querySelector('.prod-sort select').value,
          page: page
        });
        // tab ka apna sub hai to wahi chalega; "All" tab par filter wale sub[] lagenge
        if (pane.dataset.sub) params.append('sub', pane.dataset.sub);
        filters.forEach((v, k) => {
          if (k === 'sub[]' && pane.dataset.sub) return;
          params.append(k, v);
        });

        fetch(baseUrl + '?' + params, {
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
          .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
          .then(d => {
            const grid = pane.querySelector('.prod-grid');
            if (append) grid.insertAdjacentHTML('beforeend', d.html); else grid.innerHTML = d.html;
            pane.dataset.loaded = '1';
            pane.querySelector('.prod-styles').textContent = d.total + ' styles';
            pane.querySelector('.prod-count b').textContent = d.total;
            const more = pane.querySelector('.load-more');
            more.style.display = d.next_page ? '' : 'none';
            more.querySelector('button').dataset.next = d.next_page || '';
            more.querySelector('p').textContent = 'Showing ' + d.shown + ' of ' + d.total + ' styles';
          })
          .catch(err => console.error('Product load failed:', err));

      }

      /* ===== SORT: ek hi value, sab selects + popup radios sync ===== */
      function setSort(val, pane) {
        sortSelects.forEach(s => s.value = val);
        sortRadios.forEach(r => r.checked = (r.value === val));
        // baaki tabs purane sort par the, unhe dobara load hone do
        root.querySelectorAll('.tabs').forEach(p => { if (p !== pane) delete p.dataset.loaded; });
        load(pane, 1, false);
      }

      root.querySelectorAll('.tab-nav li').forEach(li => li.addEventListener('click', () => {
        const pane = root.querySelector('.tabs[data-tab="' + li.dataset.tab + '"]');
        if (pane && !pane.dataset.loaded) load(pane, 1, false);
      }));

      root.querySelectorAll('.tabs').forEach(pane => {
        pane.querySelector('.load-more button').addEventListener('click', e => {
          const next = e.currentTarget.dataset.next;
          if (next) load(pane, next, true);
        });
      });

      // jQuery delegated: native aur jQuery dono tarah ke change events pakadta hai
      $(document).on('change', '.product-secB .prod-sort select', function () {
        setSort(this.value, this.closest('.tabs'));
      });

      $(document).on('change', '.sort-pop input[name="SortBy"]', function () {
        setSort(this.value, root.querySelector('.tabs.active'));
        const closeBtn = sortPopup.querySelector('.close');
        if (closeBtn) closeBtn.click();
      });

      /* ===== FILTER ===== */
      const priceBox = document.getElementById('catPrice');

      function collectFilters() {
        const p = new URLSearchParams();
        popup.querySelectorAll('input[type="checkbox"]:checked').forEach(i => p.append(i.name, i.value));

        if (priceBox) {
          const min = priceBox.querySelector('[name="price_min"]');
          const max = priceBox.querySelector('[name="price_max"]');
          // default bounds par ho to price param bhejo hi mat
          if (min.value !== '' && +min.value > +priceBox.dataset.min) p.append('price_min', min.value);
          if (max.value !== '' && +max.value < +priceBox.dataset.max) p.append('price_max', max.value);
        }
        return p;
      }

      function applyFilters() {
        // baaki tabs ka purana data invalid
        root.querySelectorAll('.tabs').forEach(pane => delete pane.dataset.loaded);

        let target = root.querySelector('.tabs.active');

        // sub filter chuna hai aur kisi specific tab par ho to "All" tab par le aao
        if (filters.has('sub[]')) {
          const firstLi = root.querySelector('.tab-nav li');
          const allPane = root.querySelector('.tabs[data-tab="' + firstLi.dataset.tab + '"]');
          if (target !== allPane) {
            allPane.dataset.loaded = '1'; // click handler double load na kare
            firstLi.click();
            target = allPane;
          }
        }

        if (target) load(target, 1, false);

        const closeBtn = popup.querySelector('.close');
        if (closeBtn) closeBtn.click();
      }

      document.getElementById('catFilterApply').addEventListener('click', () => {
        filters = collectFilters();
        applyFilters();
      });

      document.getElementById('catFilterClear').addEventListener('click', () => {
        popup.querySelectorAll('input[type="checkbox"]').forEach(i => i.checked = false);
        if (priceBox) {
          priceBox.querySelector('[name="price_min"]').value = priceBox.dataset.min;
          priceBox.querySelector('[name="price_max"]').value = priceBox.dataset.max;
        }
        filters = new URLSearchParams();
        applyFilters();
      });
    })();
  </script>
@endpush