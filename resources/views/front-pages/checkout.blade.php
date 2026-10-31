@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/checkout/checkout.css') }}" />
@endpush

@section('content')

  @php
    $summaryItems = $cart->items->filter(fn($i) => $i->product);
    $cards = $addresses->concat([new \App\Models\CustomerAddress]); // existing addresses + one blank "new" card
    $selectedId = $defaultAddress?->id ?? $addresses->first()?->id;
    $typeLabels = ['home' => 'Home', 'office' => 'Work', 'other' => 'Other'];
  @endphp

  <main>
    <section class="checkout-secA">
      <div class="container">
        <div class="co-top">
          <ol class="co-steps" aria-label="Checkout progress">
            <li class="step is-done">
              <a href="{{ route('cart') }}" class="step-link">
                <span class="step-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                <span class="step-label">Bag</span>
              </a>
            </li>
            <li class="step is-active" aria-current="step">
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

        <div class="co-head">
          <span class="eyebrow">Almost There</span>
          <h1>Delivery Details</h1>
          <a href="{{ route('cart') }}" class="back-link"><i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
            Back to bag</a>
        </div>

        <form class="co-layout form" action="#" novalidate>
          <div class="co-main">

            <section class="co-block">
              <div class="co-row">
                <h2 class="co-title"><span class="num">1</span> Contact</h2>
                @if (!$customer)
                  <p class="co-aside">Have an account? <a href="{{ route('user.login', ['redirect' => url()->current()]) }}">Log in</a></p>
                @endif
              </div>
              <div class="fields">
                <div class="form-group s-12">
                  <input type="email" id="cEmail" name="email" value="{{ $customer->email ?? '' }}" placeholder=" "
                    autocomplete="email" />
                  <label for="cEmail">Email address</label>
                </div>
              </div>
              <label class="check">
                <input type="checkbox" name="email_updates" checked />
                <span>Email me order updates and festive offers</span>
              </label>
            </section>

            <section class="co-block" id="addrBlock">
              <h2 class="co-title"><span class="num">2</span> Delivery address</h2>


              <p class="addr-msg" id="addrMsg" style="display:none"></p>

              @unless ($customer)
                <p class="addr-note">Fill in your details and click Continue to Payment. You will be asked to log in or
                  register, and your order is placed right after.</p>
              @endunless

              <div class="addr-list" role="radiogroup" aria-label="Choose a delivery address">
                @foreach ($cards as $addr)
                  @php
                    $isNew = !$addr->exists;
                    $key = $isNew ? 'new' : $addr->id;
                    $checked = $isNew ? $addresses->isEmpty() : $addr->id === $selectedId;
                    $type = $addr->address_type ?: 'home';
                  @endphp

                  <div class="addr-card {{ $isNew ? 'addr-new' : '' }}" data-id="{{ $isNew ? '' : $addr->id }}">
                    <input type="radio" name="address" id="addr{{ $key }}" class="addr-radio" value="{{ $key }}"
                      @checked($checked) />
                    <label for="addr{{ $key }}" class="addr-body">
                      <span class="radio-dot" aria-hidden="true"></span>
                      <span class="addr-info">
                        @if ($isNew)
                          <span class="addr-top">
                            <strong><i class="fa-solid fa-plus" aria-hidden="true"></i> Add a new address</strong>
                          </span>
                        @else
                          <span class="addr-top">
                            <strong>{{ $addr->name }}</strong>
                            <span class="tag">{{ $typeLabels[$type] ?? 'Home' }}</span>
                            @if ($addr->is_default)
                              <span class="tag tag-default">Default</span>
                            @endif
                          </span>
                          <span
                            class="addr-line">{{ collect([$addr->address_line_1, $addr->address_line_2])->filter()->implode(', ') }}</span>
                          <span class="addr-line">{{ $addr->city?->name }}, {{ $addr->state?->name }} -
                            {{ $addr->pincode }}</span>
                          <span class="addr-phone"><i class="fa-solid fa-phone" aria-hidden="true"></i> +91
                            {{ $addr->phone }}</span>
                        @endif
                      </span>
                    </label>

                    @unless ($isNew)
                      <input type="checkbox" id="edit{{ $key }}" class="edit-toggle" />
                      <label for="edit{{ $key }}" class="addr-edit">
                        <i class="fa-solid fa-pen" aria-hidden="true"></i> Edit
                      </label>
                    @endunless

                    <div class="addr-form">
                      @unless ($isNew)
                        <h3>Edit address</h3>
                      @endunless

                      <div class="fields">
                        <div class="form-group s-6">
                          <input type="text" id="a{{ $key }}Name" data-f="name"
                            value="{{ $isNew ? $customer->name ?? '' : $addr->name }}" placeholder=" "
                            autocomplete="name" />
                          <label for="a{{ $key }}Name">Full name</label>
                        </div>
                        <div class="form-group has-prefix s-6">
                          <span class="prefix">+91</span>
                          <input type="tel" id="a{{ $key }}Phone" data-f="phone" value="{{ $addr->phone }}" placeholder=" "
                            inputmode="numeric" maxlength="10" autocomplete="tel-national" />
                          <label for="a{{ $key }}Phone">Phone number</label>
                        </div>
                        <div class="form-group s-4">
                          <input type="text" id="a{{ $key }}Pin" data-f="pincode" value="{{ $addr->pincode }}"
                            placeholder=" " inputmode="numeric" maxlength="6" autocomplete="postal-code" />
                          <label for="a{{ $key }}Pin">PIN code</label>
                        </div>
                        <div class="form-group s-4">
                          <select id="a{{ $key }}State" data-f="state_id" class="state-select"
                            data-city="{{ $addr->city_id }}">
                            <option value=""></option>
                            @foreach ($states as $st)
                              <option value="{{ $st->id }}" @selected($st->id == $addr->state_id)>{{ $st->name }}</option>
                            @endforeach
                          </select>
                          <label for="a{{ $key }}State">State</label>
                        </div>
                        <div class="form-group s-4">
                          <select id="a{{ $key }}City" data-f="city_id" class="city-select">
                            <option value=""></option>
                          </select>
                          <label for="a{{ $key }}City">City</label>
                        </div>
                        <div class="form-group s-5">
                          <input type="text" id="a{{ $key }}L1" data-f="address_line_1" value="{{ $addr->address_line_1 }}"
                            placeholder=" " autocomplete="address-line1" />
                          <label for="a{{ $key }}L1">House / Flat no.</label>
                        </div>
                        <div class="form-group s-7">
                          <input type="text" id="a{{ $key }}L2" data-f="address_line_2" value="{{ $addr->address_line_2 }}"
                            placeholder=" " autocomplete="address-line2" />
                          <label for="a{{ $key }}L2">Street / Area / Locality</label>
                        </div>
                      </div>

                      <fieldset class="type-group">
                        <legend>Address type</legend>
                        <div class="type-options">
                          @foreach ($typeLabels as $val => $label)
                            <label class="type-chip">
                              <input type="radio" name="type_{{ $key }}" data-f="address_type" value="{{ $val }}"
                                @checked($type === $val) />
                              <span>
                                <i class="fa-solid {{ ['home' => 'fa-house', 'office' => 'fa-briefcase', 'other' => 'fa-location-dot'][$val] }}"
                                  aria-hidden="true"></i> {{ $label }}
                              </span>
                            </label>
                          @endforeach
                        </div>
                      </fieldset>

                      @unless ($isNew)
                        <label class="check">
                          <input type="checkbox" data-f="is_default" @checked($addr->is_default) />
                          <span>Make this my default address</span>
                        </label>
                      @endunless

                      @if ($customer)
                        <div class="form-actions">
                          <button type="button" class="btn btn-primary js-addr-save">
                            {{ $isNew ? 'Save & deliver here' : 'Save address' }}
                          </button>
                          @if (!$isNew)
                            <label for="edit{{ $key }}" class="btn btn-outline-primary">Cancel</label>
                          @elseif ($selectedId)
                            <label for="addr{{ $selectedId }}" class="btn btn-outline-primary">Cancel</label>
                          @endif
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>

            </section>

            <!-- 3. Delivery method -->
            <section class="co-block">
              <h2 class="co-title">
                <span class="num">3</span> Delivery method
              </h2>

              <div class="method-list" role="radiogroup" aria-label="Choose a delivery method">
                <label class="method">
                  <input type="radio" name="delivery" value="standard" checked />
                  <span class="method-body">
                    <span class="radio-dot" aria-hidden="true"></span>
                    <span class="method-text">
                      <strong>Standard Delivery</strong>
                      <small>Delivery by Mon, 2 Nov</small>
                    </span>
                    <span class="method-price is-free">Free</span>
                  </span>
                </label>
              </div>
            </section>


            <section class="co-block pm">
              <h2 class="co-title">
                <span class="num">4</span>Payment method
              </h2>

              <input type="radio" name="payment" id="pmOnline" class="pm-radio" value="online" checked />
              @if ($codEnabled)
                <input type="radio" name="payment" id="pmCod" class="pm-radio" value="cod" />
              @endif

              <div class="pm-tabs" id="pmTabs" role="radiogroup" aria-label="Choose a payment method">
                <label for="pmOnline" class="pm-tab">
                  <span class="pm-icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span>
                  <span class="pm-text">
                    <strong>Pay Online</strong>
                    <small>UPI, Cards, Net Banking</small>
                  </span>
                  <span class="radio-dot" aria-hidden="true"></span>
                </label>
                @if ($codEnabled)
                  <label for="pmCod" class="pm-tab">
                    <span class="pm-icon"><i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i></span>
                    <span class="pm-text">
                      <strong>Cash on Delivery</strong>
                      <small>Pay when it arrives</small>
                    </span>
                    <span class="radio-dot" aria-hidden="true"></span>
                  </label>
                @endif

              </div>

              <p class="pm-info pm-online">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span>Pay via UPI, Cards or Net Banking on our secure page. We
                  never store your card or bank details.</span>
              </p>
              @if ($codEnabled)
                <p class="pm-info pm-cod">
                  <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                  <span>Cash on Delivery is available. Please keep the exact amount ready.</span>
                </p>
              @endif



              <div class="bill">
                <label class="check">
                  <input type="checkbox" id="billSame" name="billing_same" value="1" checked />
                  <span>Billing address same as delivery address</span>
                </label>

                <div class="bill-form">
                  <div class="fields">
                    <div class="form-group s-12">
                      <input type="text" id="bName" name="bill_name" placeholder=" " autocomplete="billing name"
                        disabled />
                      <label for="bName">Full name</label>
                    </div>
                    <div class="form-group s-5">
                      <input type="text" id="bHouse" name="bill_address_line_1" placeholder=" "
                        autocomplete="billing address-line1" disabled />
                      <label for="bHouse">House / Flat no.</label>
                    </div>
                    <div class="form-group s-7">
                      <input type="text" id="bStreet" name="bill_address_line_2" placeholder=" "
                        autocomplete="billing address-line2" disabled />
                      <label for="bStreet">Street / Area / Locality</label>
                    </div>
                    <div class="form-group s-4">
                      <input type="text" id="bPin" name="bill_pincode" placeholder=" " inputmode="numeric" maxlength="6"
                        autocomplete="billing postal-code" disabled />
                      <label for="bPin">PIN code</label>
                    </div>
                    <div class="form-group s-4">
                      <select id="bState" name="bill_state_id" class="state-select" disabled>
                        <option value=""></option>
                        @foreach ($states as $st)
                          <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                      </select>
                      <label for="bState">State</label>
                    </div>
                    <div class="form-group s-4">
                      <select id="bCity" name="bill_city_id" class="city-select" disabled>
                        <option value=""></option>
                      </select>
                      <label for="bCity">City</label>
                    </div>
                  </div>
                </div>
              </div>

            </section>

          </div>

          <!-- Summary -->
          <aside class="co-summary" aria-label="Order summary">
            <div class="box price-box" id="orderSummary">
              <div class="box-head">
                <h5>Order Summary <span>({{ $summary['count'] }} {{ Str::plural('item', $summary['count']) }})</span></h5>
                <a href="{{ route('cart') }}">Edit bag</a>
              </div>

              <ul class="mini-list">
                @foreach ($summaryItems as $item)
                  @php
                    $variant = collect($item->selected_attributes ?? [])->pluck('value')
                      ->merge($item->addons->pluck('detail'))
                      ->filter()->implode(' · ');
                  @endphp
                  <li>
                    <span class="mini-img">
                      <img src="{{ $item->display_image }}" alt="{{ $item->product->name }}" width="56" height="75"
                        loading="lazy" />
                      <b>{{ $item->quantity }}</b>
                    </span>
                    <span class="mini-text">
                      <strong>{{ $item->product->name }}</strong>
                      @if ($variant)
                        <small>{{ $variant }}</small>
                      @endif
                    </span>
                    <span class="mini-price">₹{{ number_format($item->total) }}</span>
                  </li>
                @endforeach
              </ul>

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
                    <dd>Calculated after address</dd>
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

              <button type="button" class="btn btn-primary place-btn js-pay">
                Continue to Payment <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
              </button>

              <p class="terms-note">
                By continuing, you agree to our <a href="/terms">Terms</a> and
                <a href="/privacy">Privacy Policy</a>.
              </p>
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

            <a href="javascript:void(0)" class="co-help">
              <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
              <span>Need help with your order?
                <b>Chat with our stylists</b></span>
            </a>
          </aside>
        </form>

        <div class="co-bar">
          <div class="bar-total" id="coBarTotal">
            <span>Total</span>
            <strong>₹{{ number_format($summary['total']) }}</strong>
          </div>
          <button type="button" class="btn btn-primary js-pay">
            Continue to Payment
            <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </section>
  </main>

  <!-- Checkout-only login / register modal -->
  <button type="button" id="coAuthOpen" data-model=".co-auth-pop" hidden aria-hidden="true" tabindex="-1"></button>

  <div class="model co-auth-pop">
    <button class="close" type="button">
      <p>Close</p>
      <svg width="20" height="20" viewBox="0 0 26 26" fill="none">
        <path d="M0.5 0.5L25.5 25.5M0.5 25.5L25.5 0.5" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>

    <div class="model-body">
      <div class="pop-title">
        <h3>One last step</h3>
        <p>Log in or create an account. Your order will be placed right after, no need to click again.</p>
      </div>

      <ul class="tab-nav">
        <li class="active" data-tab="co-login">Login</li>
        <li data-tab="co-register">Create Account</li>
      </ul>

      <div class="tab-nav-content">
        <!-- LOGIN -->
        <div class="tabs active" data-tab="co-login">
          <form class="form co-auth-form" data-mode="login" novalidate>
            <div class="form-group">
              <input type="text" id="coLoginId" name="login_id" placeholder=" " autocomplete="username" />
              <label for="coLoginId">Email or Mobile Number</label>
            </div>
            <div class="form-group">
              <input type="password" id="coLoginPass" name="password" placeholder=" "
                autocomplete="current-password" />
              <label for="coLoginPass">Password</label>
            </div>
            <button type="submit" class="btn btn-primary pop-submit">Login &amp; Continue</button>
          </form>

          <div class="pop-divider"><span>or</span></div>
          <button type="button" class="pop-google co-google">
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

        <!-- REGISTER -->
        <div class="tabs" data-tab="co-register">
          <form class="form co-auth-form" data-mode="register" novalidate>
            <div class="form-group">
              <input type="text" id="coRegName" name="name" placeholder=" " autocomplete="name" />
              <label for="coRegName">Full Name</label>
            </div>
            <div class="form-group">
              <input type="email" id="coRegEmail" name="email" placeholder=" " autocomplete="email" />
              <label for="coRegEmail">Email Address</label>
            </div>
            <div class="pop-row">
              <div class="form-group">
                <input type="tel" id="coRegMobile" name="mobile" placeholder=" " inputmode="numeric" maxlength="10"
                  autocomplete="tel" />
                <label for="coRegMobile">Mobile Number</label>
              </div>
              <div class="form-group">
                <input type="tel" id="coRegAlt" name="alternate_mobile" placeholder=" " inputmode="numeric"
                  maxlength="10" autocomplete="off" />
                <label for="coRegAlt">Alternate (optional)</label>
              </div>
            </div>
            <div class="form-group">
              <input type="password" id="coRegPass" name="password" placeholder=" " autocomplete="new-password" />
              <label for="coRegPass">Create Password</label>
            </div>
            <div class="form-group">
              <input type="password" id="coRegConfirm" name="password_confirmation" placeholder=" "
                autocomplete="new-password" />
              <label for="coRegConfirm">Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-primary pop-submit">Register &amp; Continue</button>
            <p class="pop-note">
              By continuing, you agree to our
              <a href="/terms">Terms &amp; Conditions</a> and <a href="/privacy">Privacy Policy</a>.
            </p>
          </form>

          <div class="pop-divider"><span>or</span></div>
          <button type="button" class="pop-google co-google">
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

@endsection

@push('scripts')
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    $(function () {
      var CSRF = @json(csrf_token()),
        STORE_URL = @json(route('address.store')),
        UPDATE_URL = @json(route('address.update', ['id' => '__ID__'])),
        DEFAULT_URL = @json(route('checkout.change-default-address')),
        CITIES_URL = @json(route('state.cities', ['state' => '__ID__'])),
        PLACE_URL = @json(route('checkout.place-order')),
        RZP_OK_URL = @json(route('checkout.razorpay.success')),
        LOGIN_URL = @json(route('checkout.ajax-login')),
        REGISTER_URL = @json(route('checkout.ajax-register')),
        GOOGLE_URL = @json(route('user.google.login')),
        DEFAULT_ID = @json($selectedId),
        GUEST_SUBTOTAL = @json((float) $summaryItems->sum('total')),
        IS_GUEST = @json(!$customer),
        PENDING_KEY = 'coPending',
        pendingOrder = null,
        busy = false;

      // ───────── Helpers ─────────
      function post(url, data) {
        return $.ajax({ url: url, method: 'POST', data: $.extend({ _token: CSRF }, data), dataType: 'json' });
      }

      function showMsg(text, ok) {
        $('#addrMsg').toggleClass('is-ok', !!ok).text(text).show()[0].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      }

      function failText(xhr) {
        var j = xhr.responseJSON || {};
        if (xhr.status === 422 && j.errors) return Object.values(j.errors)[0][0];
        if (j.message) return j.message;
        if (xhr.status === 419) return 'Your session expired. Please refresh the page.';
        if (xhr.status === 401) return 'Please log in to continue.';
        if (xhr.status === 429) return 'Too many attempts. Please try again in a minute.';
        return 'Something went wrong. Please try again.';
      }

      function unbusy() {
        busy = false;
        $('.js-pay').prop('disabled', false);
      }

      // ───────── Billing toggle ─────────
      // Selects are drawn by the custom-select plugin, so any change to options,
      // value or disabled state has to be pushed back into that UI
      function refreshSelect($sel) {
        $sel.toggleClass('valid', !!$sel.val());
        if ($.fn.niceSelect) $sel.niceSelect('update');
      }

      function toggleBilling() {
        var same = $('#billSame').is(':checked');
        $('.bill-form').find('input, select').prop('disabled', same);
        $('.bill-form select').each(function () { refreshSelect($(this)); });
      }
      $('#billSame').on('change', toggleBilling);
      toggleBilling();

      $(document).on('input', '#bPin', function () {
        this.value = this.value.replace(/\D/g, '');
      });

      // ───────── Cities by state ─────────
      function loadCities($state, selected) {
        var $city = $state.closest('.fields').find('.city-select'),
          req = ($city.data('req') || 0) + 1;

        $city.data('req', req).html('<option value=""></option>');
        refreshSelect($city);
        if (!$state.val()) return;

        $.getJSON(CITIES_URL.replace('__ID__', $state.val())).done(function (list) {
          if ($city.data('req') !== req) return; // a newer state was picked meanwhile

          var html = '<option value=""></option>';
          list.forEach(function (c) {
            html += '<option value="' + c.id + '"' + (String(c.id) === String(selected) ? ' selected' : '') + '>' +
              $('<div>').text(c.name).html() + '</option>';
          });
          $city.html(html);
          refreshSelect($city);
        });
      }

      $(document).on('change', '.state-select', function () { loadCities($(this), null); });
      $('.state-select').each(function () { if (this.value) loadCities($(this), $(this).data('city')); });

      // Digits only
      $(document).on('input', '.addr-form [data-f="phone"], .addr-form [data-f="pincode"], .co-auth-pop [name="mobile"], .co-auth-pop [name="alternate_mobile"]', function () {
        this.value = this.value.replace(/\D/g, '');
      });

      // ───────── Saved address: choose / save / update ─────────
      $(document).on('change', '.addr-radio', function () {
        var id = $(this).val();
        if (id === 'new' || String(id) === String(DEFAULT_ID) || busy) return;

        busy = true;
        $('#addrBlock').addClass('is-updating');
        post(DEFAULT_URL, { address_id: id })
          .done(function () { window.location.reload(); })
          .fail(function (xhr) {
            busy = false;
            $('#addrBlock').removeClass('is-updating');
            showMsg(failText(xhr));
          });
      });

      function collect($card) {
        var d = {};
        $card.find('.addr-form [data-f]').each(function () {
          var $i = $(this);
          if ($i.is(':radio') && !$i.is(':checked')) return;
          d[$i.data('f')] = $i.is(':checkbox') ? ($i.is(':checked') ? 1 : 0) : $.trim($i.val());
        });
        d.email = $.trim($('#cEmail').val());
        return d;
      }

      $(document).on('click', '.js-addr-save', function () {
        if (busy) return;

        var $btn = $(this),
          $card = $btn.closest('.addr-card'),
          id = $card.data('id'),
          data = collect($card);

        if (id) data._method = 'PUT';

        busy = true;
        $btn.prop('disabled', true);
        $('#addrMsg').hide();

        post(id ? UPDATE_URL.replace('__ID__', id) : STORE_URL, data)
          .done(function () { window.location.reload(); })
          .fail(function (xhr) {
            busy = false;
            $btn.prop('disabled', false);
            showMsg(failText(xhr));
          });
      });

      // ───────── Build + validate the order payload ─────────
      function billingData() {
        var d = { billing_same: $('#billSame').is(':checked') ? 1 : 0 };
        $('.bill-form').find('input, select').each(function () {
          if (this.name && !this.disabled) d[this.name] = $.trim($(this).val());
        });
        return d;
      }

      // Returns { error } or { data }
      function buildOrder() {
        var $card = $('.addr-radio:checked').closest('.addr-card'),
          payment = $('input[name="payment"]:checked').val(),
          bill = billingData(),
          data = $.extend({ payment_method: payment === 'cod' ? 'cod' : 'razorpay' }, bill);

        if (!$card.length) return { error: 'Please choose a delivery address.' };

        if (!$card.data('id')) {
          var addr = collect($card),
            missing = ['name', 'phone', 'pincode', 'state_id', 'city_id', 'address_line_1', 'email']
              .some(function (k) { return !addr[k]; });

          if (missing) return { error: 'Please fill in your contact email and delivery address.' };
          if (!/^\S+@\S+\.\S+$/.test(addr.email)) return { error: 'Please enter a valid email address.' };
          if (!/^\d{10}$/.test(addr.phone)) return { error: 'Please enter a valid 10-digit phone number.' };
          if (!/^\d{6}$/.test(addr.pincode)) return { error: 'Please enter a valid 6-digit PIN code.' };

          $.extend(data, addr);
        } else {
          data.address_id = $card.data('id');
        }

        if (!bill.billing_same) {
          var billMissing = ['bill_name', 'bill_address_line_1', 'bill_pincode', 'bill_state_id', 'bill_city_id']
            .some(function (k) { return !bill[k]; });
          if (billMissing) return { error: 'Please fill in the billing address.' };
        }

        return { data: data };
      }

      // ───────── Place order (COD redirect / Razorpay popup) ─────────
      function placeOrder(data) {
        busy = true;
        $('.js-pay').prop('disabled', true);
        $('#addrMsg').hide();

        post(PLACE_URL, data).done(function (r) {
          if (!r.success) { unbusy(); return showMsg(r.message || 'Unable to place your order.'); }
          if (r.type === 'cod') { window.location.href = r.redirect_url; return; }

          new Razorpay({
            key: r.key,
            amount: r.amount,
            currency: 'INR',
            order_id: r.razorpay_order_id,
            name: @json(config('app.name')),
            prefill: { name: r.customer_name, email: r.customer_email, contact: r.customer_phone },
            handler: function (resp) {
              post(RZP_OK_URL, {
                order_id: r.order_id,
                razorpay_payment_id: resp.razorpay_payment_id,
                razorpay_order_id: resp.razorpay_order_id,
                razorpay_signature: resp.razorpay_signature
              }).done(function (x) { window.location.href = x.redirect_url; })
                .fail(function (xhr) { unbusy(); showMsg(failText(xhr)); });
            },
            modal: { ondismiss: unbusy }
          }).open();
        }).fail(function (xhr) {
          unbusy();
          showMsg(failText(xhr));
        });
      }

      // ───────── Continue to Payment ─────────
      $(document).on('click', '.js-pay', function () {
        if (busy) return;

        var order = buildOrder();
        if (order.error) return showMsg(order.error);

        // Guest: details are valid, so ask for login/register, then place the order automatically
        if (IS_GUEST) {
          pendingOrder = order.data;
          $('#addrMsg').hide();
          openAuthModal();
          return;
        }

        placeOrder(order.data);
      });

      // ───────── Checkout auth modal ─────────
      var $auth = $('.co-auth-pop');

      function openAuthModal() {
        var a = collect($('.addr-new'));

        // prefill register form from what the guest already typed
        if (!$('#coRegEmail').val()) $('#coRegEmail').val(a.email || '');
        if (!$('#coRegName').val()) $('#coRegName').val(a.name || '');
        if (!$('#coRegMobile').val()) $('#coRegMobile').val(a.phone || '');
        $auth.find('.pop-err').remove();

        // If the cart turns out different after login, the page reloads and the form is restored for review
        try {
          sessionStorage.setItem(PENDING_KEY, JSON.stringify({
            addr: a, payment: $('input[name="payment"]:checked').val(), bill: billingData(), review: true
          }));
        } catch (e) { }

        $('#coAuthOpen')[0].click();
      }

      // Tabs (own handler, scoped to this modal)
      $auth.on('click', '.tab-nav li', function () {
        var t = $(this).data('tab');
        $auth.find('.tab-nav li').removeClass('active').filter(this).addClass('active');
        $auth.find('.tabs').removeClass('active').filter('[data-tab="' + t + '"]').addClass('active');
      });

      // Closed without logging in: allow clicking Continue again
      $auth.on('click', '.close', function () {
        if (IS_GUEST) {
          pendingOrder = null;
          try { sessionStorage.removeItem(PENDING_KEY); } catch (e) { }
          unbusy();
        }
      });

      // Login / Register, then straight to place order
      $auth.on('submit', '.co-auth-form', function (e) {
        e.preventDefault();

        var $f = $(this),
          $btn = $f.find('.pop-submit'),
          isLogin = $f.data('mode') === 'login';

        if (busy || !pendingOrder) return;

        $f.find('.pop-err').remove();
        $btn.prop('disabled', true);
        busy = true;

        $.ajax({
          url: isLogin ? LOGIN_URL : REGISTER_URL,
          method: 'POST',
          data: $f.serialize() + '&_token=' + encodeURIComponent(CSRF),
          dataType: 'json'
        }).done(function (r) {
          // fresh token comes straight from the controller response
          if (r.csrf_token) CSRF = r.csrf_token;
          $('meta[name="csrf-token"]').attr('content', CSRF);

          // fire the tracking events the controller returns
          (r.tracking_events || []).forEach(function (t) {
            if (t.type === 'gtag' && window.gtag) window.gtag('event', t.name, t.params || {});
          });

          IS_GUEST = false;
          busy = false;
          $btn.prop('disabled', false);

          var data = pendingOrder;
          pendingOrder = null;
          $auth.find('.close').trigger('click');

          // Saved bag merged with items the guest never saw: let them review first
          if (Math.abs((r.cart_subtotal || 0) - GUEST_SUBTOTAL) > 0.5) {
            window.location.reload();
            return;
          }

          if (r.cart_count !== undefined) $('.cart-count').text(r.cart_count);

          try { sessionStorage.removeItem(PENDING_KEY); } catch (e) { }
          placeOrder(data); // no second click needed
        }).fail(function (xhr) {
          busy = false;
          $btn.prop('disabled', false);
          $('<p class="pop-err">').text(failText(xhr)).insertBefore($btn);
        });
      });

      // Google login redirects away, so keep the form and finish on return
      $auth.on('click', '.co-google', function () {
        if (!pendingOrder) return;
        try {
          sessionStorage.setItem(PENDING_KEY, JSON.stringify({
            addr: collect($('.addr-new')),
            payment: $('input[name="payment"]:checked').val(),
            bill: billingData()
          }));
        } catch (e) { }
        window.location.href = GOOGLE_URL + '?redirect=' + encodeURIComponent(window.location.href);
      });

      // ───────── Back from login/Google: restore the form ─────────
      if (!IS_GUEST) {
        try {
          var p = JSON.parse(sessionStorage.getItem(PENDING_KEY) || 'null');
          if (p) {
            sessionStorage.removeItem(PENDING_KEY);

            var filled = p.addr && (p.addr.address_line_1 || p.addr.pincode);

            if (filled) {
              var $new = $('.addr-new');
              $.each(p.addr, function (k, v) {
                if (k === 'email') { if (!$('#cEmail').val()) $('#cEmail').val(v); return; }
                var $i = $new.find('[data-f="' + k + '"]');
                if ($i.is(':radio')) $i.filter('[value="' + v + '"]').prop('checked', true);
                else if ($i.length) $i.val(v);
              });
              refreshSelect($new.find('.state-select'));
              loadCities($new.find('.state-select'), p.addr.city_id);
              $('#addrnew').prop('checked', true);
            }

            if (p.bill) {
              $('#billSame').prop('checked', !!Number(p.bill.billing_same));
              toggleBilling();
              $.each(p.bill, function (k, v) {
                if (k !== 'billing_same') $('.bill-form [name="' + k + '"]').val(v);
              });
              refreshSelect($('#bState'));
              loadCities($('#bState'), p.bill.bill_city_id);
            }

            $(p.payment === 'cod' && $('#pmCod').length ? '#pmCod' : '#pmOnline').prop('checked', true);

            if (p.review) {
              showMsg('Your saved bag items were added. Please review the total and click Continue to Payment.', true);
            } else {
              // wait for cities to load, then continue to payment on its own
              setTimeout(function () { $('.js-pay').first().trigger('click'); }, 900);
            }
          }
        } catch (e) { }
      }

      // The outer form never submits. Payment is a separate step
      $('.co-layout').on('submit', function (e) { e.preventDefault(); });
    });
  </script>
@endpush