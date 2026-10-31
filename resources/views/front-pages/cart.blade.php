@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/cart/cart.css') }}" />
@endpush

@section('content')

  @php
    $items = $cart?->items ?? collect();
    $cartSubtotal = (float) $items->sum('total');
    $cartQty = (int) $items->sum('quantity');
  @endphp

  <main>

    @if ($items->isNotEmpty())

      <section class="cart-secA">
        <div class="container">
          <div class="cart-top">
            <ol class="cart-steps" aria-label="Checkout progress">
              <li class="step is-active" aria-current="step">
                <span class="step-icon"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i></span>
                <span class="step-label">Bag</span>
              </li>
              <li class="step">
                <span class="step-icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                <span class="step-label">Address</span>
              </li>
              <li class="step">
                <span class="step-icon"><i class="fa-solid fa-credit-card" aria-hidden="true"></i></span>
                <span class="step-label">Payment</span>
              </li>
            </ol>
            <span class="secure-tag"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> 100%
              Secure Checkout</span>
          </div>

          <div class="cart-head" id="cartHead">
            <span class="eyebrow">Your Selection</span>
            <h1>My Bag</h1>
            <p>{{ $summary['count'] }} {{ Str::plural('item', $summary['count']) }} ·
              <b>₹{{ number_format($summary['total']) }}</b>
            </p>
          </div>

          <div class="cart-layout">
            <div class="cart-main">
              <div id="shipWrap">
                @if ($freeShip)
                  <div class="ship-progress {{ $freeShip['done'] ? 'is-done' : '' }}"
                    style="--p: {{ $freeShip['percent'] }}%">
                    <p>
                      <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
                      @if ($freeShip['done'])
                        Congratulations! You have unlocked <b>FREE shipping</b> on this order.
                      @else
                        Add <b>₹{{ number_format($freeShip['remaining']) }}</b> more to unlock <b>FREE shipping</b>.
                      @endif
                    </p>
                    <div class="ship-bar"><span></span></div>
                  </div>
                @endif
              </div>
              <p class="cart-list-msg" id="cartListMsg" style="display:none"></p>

              <div id="cartList">
                <ul class="cart-list">
                  @foreach ($items as $item)
                    @continue(!$item->product)

                    @php
                      $product = $item->product;
                      $addons = $item->addons;

                      $unit = (float) $item->price;
                      $mrp = (float) (($item->priceVariant->mrp ?? $product->mrp) ?: $unit);
                      $off = $mrp > $unit ? (int) round((($mrp - $unit) / $mrp) * 100) : 0;
                      $dye = (float) $item->dye_charge;

                      // priced extras: "+ ₹499 Fall & Pico · + ₹250 colour customization"
                      $extras = $addons->filter(fn($a) => $a->price > 0)
                        ->map(fn($a) => '+ ₹' . number_format($a->price) . ' ' . $a->detail)
                        ->all();
                      if ($dye > 0) {
                        $extras[] = '+ ₹' . number_format($dye) . ' colour customization';
                      }

                      // custom_colour_code is saved as "#b3203c - note"
                      $dyeHex = null;
                      $dyeNote = null;
                      if ($item->custom_colour_code) {
                        if (preg_match('/^(#[0-9a-fA-F]{6})(?:\s*-\s*(.+))?$/', $item->custom_colour_code, $m)) {
                          $dyeHex = $m[1];
                          $dyeNote = $m[2] ?? null;
                        } else {
                          $dyeNote = $item->custom_colour_code;
                        }
                      }

                      $stock = (int) ($item->stockVariant->stock ?? $product->stock);
                      $minQty = max(1, (int) $product->min_qty);

                      $stockMsg = null;
                      if ($stock <= 0) {
                        $stockMsg = 'Out of stock. Please remove this item.';
                      } elseif ($item->quantity > $stock) {
                        $stockMsg = "Only {$stock} available. Please reduce the quantity.";
                      } elseif ($stock <= 5) {
                        $stockMsg = "Only {$stock} left in stock";
                      }

                      $name = $product->name;
                      $url = route('products.show', $product->slug);
                    @endphp

                    <li class="cart-item" data-id="{{ $item->id }}">
                      <a class="item-img" href="{{ $url }}">
                        <img src="{{ $item->display_image }}" alt="{{ $name }}" width="130" height="173" loading="lazy" />
                      </a>

                      <div class="item-info">
                        <span class="item-cat">{{ $product->subcategory->name ?? ($product->category->name ?? '') }}</span>
                        <h2 class="item-name"><a href="{{ $url }}">{{ $name }}</a></h2>

                        <ul class="item-meta">
                          @foreach ($item->selected_attributes ?? [] as $attr)
                            <li>
                              <span>{{ $attr['attribute'] }}</span>
                              <b>
                                @if (($attr['type'] ?? null) === 'color_swatch' && !empty($attr['hex']))
                                  <i class="dot" style="--c: {{ $attr['hex'] }}"></i>
                                @endif
                                {{ $attr['value'] }}
                              </b>
                            </li>
                          @endforeach

                          @if ($addons->isNotEmpty())
                            <li><span>Add-on</span><b>{{ $addons->pluck('detail')->implode(', ') }}</b></li>
                          @endif

                          @if ($dyeHex || $dyeNote)
                            <li>
                              <span>Dyed to</span>
                              <b>
                                @if ($dyeHex)
                                  <i class="dot" style="--c: {{ $dyeHex }}"></i>
                                @endif
                                {{ $dyeNote ?: $dyeHex }}
                              </b>
                            </li>
                          @endif
                        </ul>

                        <div class="item-price">
                          <strong>₹{{ number_format($unit) }}</strong>
                          @if ($off > 0)
                            <del>₹{{ number_format($mrp) }}</del>
                            <span class="item-off">{{ $off }}% OFF</span>
                          @endif
                        </div>

                        @if ($extras)
                          <p class="item-extra">{{ implode(' · ', $extras) }}</p>
                        @endif

                        @if ($stockMsg)
                          <p class="item-stock">
                            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                            {{ $stockMsg }}
                          </p>
                        @endif

                        @if ($product->delivery_time)
                          <p class="item-delivery">
                            <i class="fa-solid fa-truck" aria-hidden="true"></i>
                            Dispatch in <b>{{ $product->delivery_time }}</b>
                          </p>
                        @endif

                        <div class="item-actions">
                          <div class="cart-qty" role="group" aria-label="Quantity for {{ $name }}">
                            <button type="button" class="qty-minus" aria-label="Decrease quantity" @disabled($item->quantity <= $minQty)>
                              <i class="fa-solid fa-minus" aria-hidden="true"></i>
                            </button>
                            <input type="text" class="qty-input" value="{{ $item->quantity }}" readonly
                              aria-label="Quantity" />
                            <button type="button" class="qty-plus" aria-label="Increase quantity" @disabled($item->quantity >= $stock)>
                              <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            </button>
                          </div>

                          <button type="button" class="item-link is-remove">
                            <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                            Remove
                          </button>
                        </div>
                      </div>

                      <div class="item-total">
                        <span>Item total</span>
                        <strong>₹{{ number_format($item->total) }}</strong>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>

              <div class="cart-note">
                <h5>
                  <i class="fa-solid fa-gift" aria-hidden="true"></i> Gift &amp;
                  Notes
                </h5>
                <label class="gift-check">
                  <input type="checkbox" name="gift" value="1" />
                  <span>This order is a gift. Pack beautifully and hide price
                    details.</span>
                </label>
                <div class="form">
                  <div class="form-group">
                    <textarea id="cartNote" name="note" placeholder=" "></textarea>
                    <label for="cartNote">Gift message or special note (optional)</label>
                  </div>
                </div>
              </div>

              <a href="{{ route('products') }}" class="continue-link">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                Continue Shopping
              </a>
            </div>

            <aside class="cart-summary" aria-label="Order summary">
              <div class="box coupon-box" id="couponBox">
                <h5>
                  <i class="fa-solid fa-ticket" aria-hidden="true"></i> Coupons
                  &amp; Offers
                </h5>

                <form class="form coupon-form" id="couponForm" action="{{ route('cart.apply.coupon') }}" method="post"
                  novalidate>
                  <div class="form-group">
                    <input type="text" id="couponInput" name="coupon_code" placeholder=" " autocomplete="off"
                      maxlength="50" />
                    <label for="couponInput">Enter coupon code</label>
                  </div>
                  <button type="submit" class="btn btn-outline-primary">Apply</button>
                </form>
                <p class="coupon-msg" id="couponMsg" style="display:none"></p>

                @if ($cart && $cart->coupon_code)
                  <div class="coupon-applied">
                    <span class="applied-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                    <div class="applied-text">
                      <strong>{{ $cart->coupon_code }} applied</strong>
                      <span>You saved ₹{{ number_format($cart->discount) }} with this coupon</span>
                    </div>
                    <button type="button" class="applied-remove" aria-label="Remove coupon {{ $cart->coupon_code }}">
                      Remove
                    </button>
                  </div>
                @endif

                @if ($offers->isNotEmpty())
                  <p class="offers-title">Available Offers</p>
                  <ul class="offer-list">
                    @foreach ($offers as $offer)
                      @php
                        $applied = $cart && strcasecmp((string) $cart->coupon_code, $offer->code) === 0;

                        $needAmount = $offer->minimum_order_amount ? max(0, $offer->minimum_order_amount - $cartSubtotal) : 0;
                        $needQty = $offer->minimum_order_quantity ? max(0, $offer->minimum_order_quantity - $cartQty) : 0;

                        $hint = null;
                        if ($needAmount > 0) {
                          $hint = 'Add ₹' . number_format($needAmount) . ' more to unlock';
                        } elseif ($needQty > 0) {
                          $hint = 'Add ' . $needQty . ' more ' . Str::plural('item', $needQty) . ' to unlock';
                        }
                      @endphp

                      <li class="{{ $applied ? 'is-applied' : '' }}">
                        <span class="offer-icon"><i class="fa-solid fa-tag" aria-hidden="true"></i></span>
                        <div class="offer-text">
                          <span class="offer-code">{{ $offer->code }}</span>
                          <p>{{ $offer->offer_text }}</p>
                          @if ($hint && !$applied)
                            <p class="offer-hint">{{ $hint }}</p>
                          @endif
                        </div>

                        @if ($applied)
                          <span class="offer-state">Applied</span>
                        @else
                          <button type="button" class="offer-apply" data-code="{{ $offer->code }}" @disabled($hint)>
                            Apply
                          </button>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>

              <div class="box delivery-box">
                <h5><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Delivery Details</h5>
                <form class="form pin-form" id="pinForm" action="{{ route('pincode.check') }}" method="get" novalidate>
                  <div class="form-group">
                    <input type="text" id="cartPin" name="pincode" inputmode="numeric" maxlength="6" placeholder=" " />
                    <label for="cartPin">Pincode</label>
                  </div>
                  <button type="submit" class="btn btn-outline-primary">Check</button>
                </form>
                <p class="pin-result" id="pinResult" style="display:none"></p>
              </div>

              <div class="box price-box" id="priceBox">
                <h5>Price Details <span>({{ $summary['count'] }} {{ Str::plural('item', $summary['count']) }})</span></h5>
                <dl class="rows">
                  <div class="row">
                    <dt>Total MRP</dt>
                    <dd>₹{{ number_format($summary['total_mrp']) }}</dd>
                  </div>

                  @if ($summary['mrp_discount'] > 0)
                    <div class="row is-green">
                      <dt>Discount on MRP</dt>
                      <dd>−₹{{ number_format($summary['mrp_discount']) }}</dd>
                    </div>
                  @endif

                  @foreach ($summary['addons'] as $label => $amount)
                    <div class="row">
                      <dt>{{ $label }}</dt>
                      <dd>+₹{{ number_format($amount) }}</dd>
                    </div>
                  @endforeach

                  @if ($summary['dye'] > 0)
                    <div class="row">
                      <dt>Colour customization</dt>
                      <dd>+₹{{ number_format($summary['dye']) }}</dd>
                    </div>
                  @endif

                  @if ($summary['coupon'] > 0)
                    <div class="row is-green">
                      <dt>Coupon ({{ $summary['coupon_code'] }})</dt>
                      <dd>−₹{{ number_format($summary['coupon']) }}</dd>
                    </div>
                  @endif

                  @if ($summary['tax'] > 0)
                    <div class="row">
                      <dt>GST</dt>
                      <dd>+₹{{ number_format($summary['tax']) }}</dd>
                    </div>
                  @endif

                  <div class="row">
                    <dt>Shipping Fee</dt>
                    @if ($summary['shipping'] > 0)
                      <dd>+₹{{ number_format($summary['shipping']) }}</dd>
                    @elseif ($summary['shipping_known'])
                      <dd class="is-green">Free</dd>
                    @else
                      <dd>Calculated at checkout</dd>
                    @endif
                  </div>

                  <div class="row row-total">
                    <dt>Total Amount</dt>
                    <dd>₹{{ number_format($summary['total']) }}</dd>
                  </div>
                </dl>
                <p class="gst-note">{{ $summary['tax'] > 0 ? 'GST added as shown above' : 'Inclusive of all taxes' }}</p>

                @if ($summary['saved'] > 0)
                  <p class="save-chip">
                    <i class="fa-solid fa-piggy-bank" aria-hidden="true"></i>
                    You are saving ₹{{ number_format($summary['saved']) }} on this order
                  </p>
                @endif

                <a href="{{ route('checkout') }}" class="btn btn-primary place-btn">Proceed to Address
                  <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                <ul class="pay-methods" aria-label="Accepted payment methods">
                  <li title="Visa">
                    <i class="fa-brands fa-cc-visa" aria-hidden="true"></i><span class="sr-only">Visa</span>
                  </li>
                  <li title="Mastercard">
                    <i class="fa-brands fa-cc-mastercard" aria-hidden="true"></i><span class="sr-only">Mastercard</span>
                  </li>
                  <li title="UPI and Wallets">
                    <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i><span class="sr-only">UPI</span>
                  </li>
                  <li title="Net Banking">
                    <i class="fa-solid fa-building-columns" aria-hidden="true"></i><span class="sr-only">Net Banking</span>
                  </li>
                  <li title="Cash on Delivery">
                    <i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i><span class="sr-only">Cash on
                      Delivery</span>
                  </li>
                </ul>
              </div>

              <ul class="trust-list">
                <li>
                  <i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i>
                  Easy 7-day returns
                </li>
                <li>
                  <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                  Secure payments
                </li>
                <li>
                  <i class="fa-solid fa-gem" aria-hidden="true"></i> Authentic
                  craftsmanship
                </li>
                <li>
                  <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
                  Pan-India delivery
                </li>
              </ul>

              <a href="javascript:void(0)" class="cart-help">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                <span>Need help with your order?
                  <b>Chat with our stylists</b></span>
              </a>
            </aside>
          </div>

          <div class="cart-bar">
            <div class="bar-total" id="cartBarTotal">
              <span>Total</span>
              <strong>₹{{ number_format($summary['total']) }}</strong>
            </div>
            <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Address
              <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
          </div>
        </div>
      </section>

    @else

      <div class="cart-empty">
        <span class="empty-ico"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i></span>
        <h2>Your bag is empty</h2>
        <p>
          Looks like you have not added anything yet. Explore our latest sarees,
          lehengas and bridal wear.
        </p>
        <div class="empty-btns">
          <a href="/all-products" class="btn btn-primary">Shop Sarees</a>
          <a href="javascript:void(0)" class="btn btn-outline-primary">View New Arrivals</a>
        </div>
        <ul class="empty-links">
          <li><a href="javascript:void(0)">Banarasi Sarees</a></li>
          <li><a href="javascript:void(0)">Bridal Wear</a></li>
          <li><a href="javascript:void(0)">Lehengas</a></li>
          <li><a href="javascript:void(0)">Party Wear</a></li>
        </ul>
      </div>

    @endif

  </main>

@endsection

@push('scripts')
  <script>
    $(function () {
      var QTY_URL = @json(route('cart.update.quantity')),
        REMOVE_URL = @json(route('cart.remove', ['id' => '__ID__'])),
        APPLY_URL = @json(route('cart.apply.coupon')),
        REMOVE_COUPON_URL = @json(route('cart.remove.coupon')),
        CSRF = @json(csrf_token()),
        SECTIONS = ['#cartList', '#couponBox', '#shipWrap', '#cartHead', '#priceBox', '#cartBarTotal'],
        busy = false;

      function post(url, data) {
        return $.ajax({ url: url, method: 'POST', data: $.extend({ _token: CSRF }, data), dataType: 'json' });
      }

      function showMsg(text) {
        $('#cartListMsg').text(text).show();
      }

      function showCouponMsg(text) {
        $('#couponMsg').text(text).show();
      }

      function failMessage(xhr) {
        var m = 'Could not update your bag right now. Please try again.';
        if (xhr.status === 419) m = 'Your session expired. Please refresh the page.';
        else if (xhr.status === 429) m = 'Too many attempts. Please try again in a minute.';
        else if (xhr.responseJSON && xhr.responseJSON.message) m = xhr.responseJSON.message;
        return m;
      }

      // Re-request this page and swap the dynamic sections with the fresh versions
      function refreshSections() {
        return $.ajax({
          url: window.location.pathname + window.location.search,
          cache: false,
          dataType: 'html'
        }).done(function (html) {
          var $doc = $('<div>').append($.parseHTML(html, document, false)); // scripts stripped
          SECTIONS.forEach(function (sel) {
            var $new = $doc.find(sel);
            if ($new.length) $(sel).html($new.html());
          });
        });
      }

      // After any successful change
      function finish(r) {
        if (Number(r.cart_count) === 0) {
          window.location.reload();
          return $.Deferred().resolve().promise();
        }
        if (r.mini_cart_html) $('#miniCart, [data-mini-cart]').first().html(r.mini_cart_html);
        if (r.cart_count !== undefined) $('.cart-count, [data-cart-count]').text(r.cart_count);
        if (r.coupon_removed && r.coupon_message) showMsg(r.coupon_message);
        $(document).trigger('cart:changed', [r]);
        return refreshSections();
      }

      // One request at a time; $el gets a dimmed state while it runs
      function run($el, req, fail) {
        if (busy) return;
        busy = true;
        $el.addClass('is-updating');
        $('#cartListMsg, #couponMsg').hide();

        function done() {
          busy = false;
          $el.removeClass('is-updating');
        }

        req().done(function (r) {
          // coupon errors come back as 200 with status:false
          if (r.status === false) {
            done();
            return fail(r.message);
          }
          finish(r).always(done);
        }).fail(function (xhr) {
          done();
          fail(failMessage(xhr));
        });
      }

      // ── Cart list ──
      $(document).on('click', '.cart-item .qty-plus, .cart-item .qty-minus', function () {
        var $row = $(this).closest('.cart-item'),
          action = $(this).hasClass('qty-plus') ? 'plus' : 'minus';

        run($row, function () {
          return post(QTY_URL, { item_id: $row.data('id'), action: action });
        }, showMsg);
      });

      $(document).on('click', '.cart-item .is-remove', function () {
        var $row = $(this).closest('.cart-item');

        run($row, function () {
          return post(REMOVE_URL.replace('__ID__', $row.data('id')), { _method: 'DELETE' });
        }, showMsg);
      });

      // ── Coupons ──
      function applyCode(code) {
        code = $.trim(code);
        if (!code) return showCouponMsg('Please enter a coupon code.');

        run($('#couponBox'), function () {
          return post(APPLY_URL, { coupon_code: code });
        }, showCouponMsg);
      }

      $(document).on('submit', '#couponForm', function (e) {
        e.preventDefault();
        applyCode($('#couponInput').val());
      });

      $(document).on('click', '.offer-apply', function () {
        applyCode($(this).data('code'));
      });

      $(document).on('click', '.applied-remove', function () {
        run($('#couponBox'), function () {
          return post(REMOVE_COUPON_URL, {});
        }, showCouponMsg);
      });

      // ── Pincode ──
      var PIN_URL = @json(route('pincode.check')),
        PIN_KEY = 'cartPin',
        $pinInput = $('#cartPin'),
        $pinResult = $('#pinResult');

      function pinMsg(ok, html) {
        $pinResult
          .toggleClass('is-error', !ok)
          .html('<i class="fa-solid ' + (ok ? 'fa-circle-check' : 'fa-circle-xmark') + '" aria-hidden="true"></i> ' + html)
          .show();
      }

      function checkPin(pin) {
        if (!/^\d{6}$/.test(pin)) return pinMsg(false, 'Please enter a valid 6-digit pincode.');

        $pinResult.hide();
        $.getJSON(PIN_URL, { pincode: pin }).done(function (r) {
          if (!r.status) return pinMsg(false, $('<div>').text(r.message).html());

          try { localStorage.setItem(PIN_KEY, pin); } catch (e) { }

          var place = $('<div>').text([r.district, r.state].filter(Boolean).join(', ')).html();
          var eta = r.eta_date ? ' Estimated by <b>' + r.eta_date + '</b>.' : '';
          pinMsg(true, 'Delivery available' + (place ? ' to ' + place : '') + '.' + eta);
        }).fail(function (xhr) {
          pinMsg(false, xhr.status === 429
            ? 'Too many attempts. Please try again in a minute.'
            : 'Could not check this pincode right now. Please try again.');
        });
      }

      $(document).on('submit', '#pinForm', function (e) {
        e.preventDefault();
        checkPin($.trim($pinInput.val()));
      });

      $pinInput.on('input', function () {
        this.value = this.value.replace(/\D/g, '');
      });

      // re-check the last pincode the customer used
      try {
        var saved = localStorage.getItem(PIN_KEY);
        if (saved) { $pinInput.val(saved); checkPin(saved); }
      } catch (e) { }
    });
  </script>
@endpush