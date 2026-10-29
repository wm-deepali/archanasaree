@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/checkout/checkout.css') }}" />
@endpush

@section('content')
    @php
        $addresses = [
            [
                'id' => 1, 'checked' => true, 'default' => true, 'type' => 'home', 'tag' => 'Home',
                'name' => 'Aarav Mehta', 'phone' => '9876543210',
                'line1' => '12, Park Street, Near Metro Gate 3, Connaught Place',
                'line2' => 'New Delhi, Delhi - 110001',
                'pin' => '110001', 'city' => 'New Delhi', 'state' => 'Delhi',
                'house' => '12', 'street' => 'Park Street, Connaught Place', 'landmark' => 'Near Metro Gate 3',
            ],
            [
                'id' => 2, 'checked' => false, 'default' => false, 'type' => 'work', 'tag' => 'Work',
                'name' => 'Aarav Mehta', 'phone' => '9876543210',
                'line1' => '4th Floor, Tech Park, MG Road, Opp. City Mall',
                'line2' => 'Bengaluru, Karnataka - 560001',
                'pin' => '560001', 'city' => 'Bengaluru', 'state' => 'Karnataka',
                'house' => '4th Floor, Tech Park', 'street' => 'MG Road', 'landmark' => 'Opp. City Mall',
            ],
        ];

        $types = [
            'home'  => ['Home', 'fa-house'],
            'work'  => ['Work', 'fa-briefcase'],
            'other' => ['Other', 'fa-location-dot'],
        ];

        $states = [
            'Andhra Pradesh', 'Delhi', 'Gujarat', 'Haryana', 'Karnataka', 'Kerala', 'Maharashtra',
            'Punjab', 'Rajasthan', 'Tamil Nadu', 'Telangana', 'Uttar Pradesh', 'West Bengal',
        ];

        $miniItems = [
            ['img' => 'tab1.png', 'name' => 'Zari Woven Banarasi Silk Saree', 'variant' => 'Wine · Stitched Blouse M', 'price' => '₹9,248'],
            ['img' => 'tab2.png', 'name' => 'Organza Embroidered Party Saree', 'variant' => 'Pink · Unstitched Blouse', 'price' => '₹6,299'],
            ['img' => 'tab4.png', 'name' => 'Georgette Printed Saree', 'variant' => 'Green · Unstitched Blouse', 'price' => '₹4,799'],
        ];
    @endphp

    <section class="checkout-secA">
        <div class="container">
            <div class="co-top">
                <ol class="co-steps" aria-label="Checkout progress">
                    <li class="step is-done">
                        <a href="{{ url('/cart') }}" class="step-link">
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
                <span class="secure-tag"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> 100% Secure Checkout</span>
            </div>

            <div class="co-head">
                <span class="eyebrow">Almost There</span>
                <h1>Delivery Details</h1>
                <a href="{{ url('/cart') }}" class="back-link">
                    <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Back to bag
                </a>
            </div>

            <form id="checkoutForm" class="co-layout form" action="{{ url('/checkout/payment') }}" method="post" novalidate>
                @csrf
                <div class="co-main">
                    {{-- 1. Contact --}}
                    <section class="co-block">
                        <div class="co-row">
                            <h2 class="co-title"><span class="num">1</span> Contact</h2>
                            <p class="co-aside">Have an account? <a href="{{ url('/login') }}?next=/checkout">Log in</a></p>
                        </div>
                        <div class="fields">
                            <div class="form-group s-12">
                                <input type="email" id="cEmail" name="email" placeholder=" " autocomplete="email" />
                                <label for="cEmail">Email address</label>
                            </div>
                        </div>
                        <label class="check">
                            <input type="checkbox" name="email_updates" checked />
                            <span>Email me order updates and festive offers</span>
                        </label>
                    </section>

                    {{-- 2. Address --}}
                    <section class="co-block">
                        <h2 class="co-title"><span class="num">2</span> Delivery address</h2>

                        <div class="addr-list" role="radiogroup" aria-label="Choose a delivery address">
                            @foreach ($addresses as $a)
                                @php $id = $a['id']; @endphp
                                <div class="addr-card">
                                    <input type="radio" name="address" id="addr{{ $id }}" class="addr-radio" value="{{ $id }}" {{ $a['checked'] ? 'checked' : '' }} />
                                    <label for="addr{{ $id }}" class="addr-body">
                                        <span class="radio-dot" aria-hidden="true"></span>
                                        <span class="addr-info">
                                            <span class="addr-top">
                                                <strong>{{ $a['name'] }}</strong>
                                                <span class="tag">{{ $a['tag'] }}</span>
                                                @if ($a['default'])
                                                    <span class="tag tag-default">Default</span>
                                                @endif
                                            </span>
                                            <span class="addr-line">{{ $a['line1'] }}</span>
                                            <span class="addr-line">{{ $a['line2'] }}</span>
                                            <span class="addr-phone"><i class="fa-solid fa-phone" aria-hidden="true"></i> +91 {{ chunk_split($a['phone'], 5, ' ') }}</span>
                                        </span>
                                    </label>

                                    <input type="checkbox" id="edit{{ $id }}" class="edit-toggle" />
                                    <label for="edit{{ $id }}" class="addr-edit"><i class="fa-solid fa-pen" aria-hidden="true"></i> Edit</label>

                                    <div class="addr-form">
                                        <h3>Edit address</h3>
                                        <div class="fields">
                                            <div class="form-group s-6">
                                                <input type="text" id="a{{ $id }}Name" name="a{{ $id }}_name" value="{{ $a['name'] }}" placeholder=" " autocomplete="name" />
                                                <label for="a{{ $id }}Name">Full name</label>
                                            </div>
                                            <div class="form-group has-prefix s-6">
                                                <span class="prefix">+91</span>
                                                <input type="tel" id="a{{ $id }}Phone" name="a{{ $id }}_phone" value="{{ $a['phone'] }}" placeholder=" " inputmode="numeric" maxlength="10" autocomplete="tel-national" />
                                                <label for="a{{ $id }}Phone">Phone number</label>
                                            </div>
                                            <div class="form-group s-4">
                                                <input type="text" id="a{{ $id }}Pin" name="a{{ $id }}_pin" value="{{ $a['pin'] }}" placeholder=" " inputmode="numeric" maxlength="6" autocomplete="postal-code" />
                                                <label for="a{{ $id }}Pin">PIN code</label>
                                            </div>
                                            <div class="form-group s-4">
                                                <input type="text" id="a{{ $id }}City" name="a{{ $id }}_city" value="{{ $a['city'] }}" placeholder=" " autocomplete="address-level2" />
                                                <label for="a{{ $id }}City">City</label>
                                            </div>
                                            <div class="form-group s-4">
                                                <input type="text" id="a{{ $id }}State" name="a{{ $id }}_state" value="{{ $a['state'] }}" placeholder=" " list="stateList" autocomplete="address-level1" />
                                                <label for="a{{ $id }}State">State</label>
                                            </div>
                                            <div class="form-group s-5">
                                                <input type="text" id="a{{ $id }}House" name="a{{ $id }}_house" value="{{ $a['house'] }}" placeholder=" " autocomplete="address-line1" />
                                                <label for="a{{ $id }}House">House / Flat no.</label>
                                            </div>
                                            <div class="form-group s-7">
                                                <input type="text" id="a{{ $id }}Street" name="a{{ $id }}_street" value="{{ $a['street'] }}" placeholder=" " autocomplete="address-line2" />
                                                <label for="a{{ $id }}Street">Street / Area / Locality</label>
                                            </div>
                                            <div class="form-group s-12">
                                                <input type="text" id="a{{ $id }}Landmark" name="a{{ $id }}_landmark" value="{{ $a['landmark'] }}" placeholder=" " />
                                                <label for="a{{ $id }}Landmark">Landmark (optional)</label>
                                            </div>
                                        </div>

                                        <fieldset class="type-group">
                                            <legend>Address type</legend>
                                            <div class="type-options">
                                                @foreach ($types as $val => [$label, $icon])
                                                    <label class="type-chip">
                                                        <input type="radio" name="a{{ $id }}_type" value="{{ $val }}" {{ $a['type'] === $val ? 'checked' : '' }} />
                                                        <span><i class="fa-solid {{ $icon }}" aria-hidden="true"></i> {{ $label }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </fieldset>

                                        <label class="check">
                                            <input type="checkbox" name="a{{ $id }}_default" {{ $a['default'] ? 'checked' : '' }} />
                                            <span>Make this my default address</span>
                                        </label>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" formaction="{{ url('/checkout/address/save') }}">Save address</button>
                                            <label for="edit{{ $id }}" class="btn btn-outline-primary">Cancel</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Add new --}}
                            <div class="addr-card addr-new">
                                <input type="radio" name="address" id="addrNew" class="addr-radio" value="new" />
                                <label for="addrNew" class="addr-body">
                                    <span class="radio-dot" aria-hidden="true"></span>
                                    <span class="addr-info">
                                        <span class="addr-top">
                                            <strong><i class="fa-solid fa-plus" aria-hidden="true"></i> Add a new address</strong>
                                        </span>
                                    </span>
                                </label>

                                <div class="addr-form">
                                    <div class="fields">
                                        <div class="form-group s-6">
                                            <input type="text" id="nName" name="new_name" placeholder=" " autocomplete="name" />
                                            <label for="nName">Full name</label>
                                        </div>
                                        <div class="form-group has-prefix s-6">
                                            <span class="prefix">+91</span>
                                            <input type="tel" id="nPhone" name="new_phone" placeholder=" " inputmode="numeric" maxlength="10" autocomplete="tel-national" />
                                            <label for="nPhone">Phone number</label>
                                        </div>
                                        <div class="form-group s-4">
                                            <input type="text" id="nPin" name="new_pin" placeholder=" " inputmode="numeric" maxlength="6" autocomplete="postal-code" />
                                            <label for="nPin">PIN code</label>
                                        </div>
                                        <div class="form-group s-4">
                                            <input type="text" id="nCity" name="new_city" placeholder=" " autocomplete="address-level2" />
                                            <label for="nCity">City</label>
                                        </div>
                                        <div class="form-group s-4">
                                            <input type="text" id="nState" name="new_state" placeholder=" " list="stateList" autocomplete="address-level1" />
                                            <label for="nState">State</label>
                                        </div>
                                        <div class="form-group s-5">
                                            <input type="text" id="nHouse" name="new_house" placeholder=" " autocomplete="address-line1" />
                                            <label for="nHouse">House / Flat no.</label>
                                        </div>
                                        <div class="form-group s-7">
                                            <input type="text" id="nStreet" name="new_street" placeholder=" " autocomplete="address-line2" />
                                            <label for="nStreet">Street / Area / Locality</label>
                                        </div>
                                        <div class="form-group s-12">
                                            <input type="text" id="nLandmark" name="new_landmark" placeholder=" " />
                                            <label for="nLandmark">Landmark (optional)</label>
                                        </div>
                                    </div>

                                    <fieldset class="type-group">
                                        <legend>Address type</legend>
                                        <div class="type-options">
                                            @foreach ($types as $val => [$label, $icon])
                                                <label class="type-chip">
                                                    <input type="radio" name="new_type" value="{{ $val }}" {{ $loop->first ? 'checked' : '' }} />
                                                    <span><i class="fa-solid {{ $icon }}" aria-hidden="true"></i> {{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </fieldset>

                                    <label class="check">
                                        <input type="checkbox" name="new_default" />
                                        <span>Save this address for next time</span>
                                    </label>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" formaction="{{ url('/checkout/address/save') }}">Save &amp; deliver here</button>
                                        <label for="addr1" class="btn btn-outline-primary">Cancel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 3. Delivery method --}}
                    <section class="co-block">
                        <h2 class="co-title"><span class="num">3</span> Delivery method</h2>

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

                            <label class="method">
                                <input type="radio" name="delivery" value="express" />
                                <span class="method-body">
                                    <span class="radio-dot" aria-hidden="true"></span>
                                    <span class="method-text">
                                        <strong>Express Delivery</strong>
                                        <small>Delivery by Sat, 31 Oct</small>
                                    </span>
                                    <span class="method-price">₹99</span>
                                </span>
                            </label>
                        </div>
                    </section>
                </div>

                {{-- Summary --}}
                <aside class="co-summary" aria-label="Order summary">
                    <div class="box price-box">
                        <div class="box-head">
                            <h5>Order Summary <span>({{ count($miniItems) }} items)</span></h5>
                            <a href="{{ url('/cart') }}">Edit bag</a>
                        </div>

                        <ul class="mini-list">
                            @foreach ($miniItems as $m)
                                <li>
                                    <span class="mini-img">
                                        <img src="{{ asset('assets/images/home/' . $m['img']) }}" alt="" width="56" height="75" loading="lazy" />
                                        <b>1</b>
                                    </span>
                                    <span class="mini-text">
                                        <strong>{{ $m['name'] }}</strong>
                                        <small>{{ $m['variant'] }}</small>
                                    </span>
                                    <span class="mini-price">{{ $m['price'] }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <dl class="rows">
                            <div class="row"><dt>Total MRP</dt><dd>₹27,497</dd></div>
                            <div class="row is-green"><dt>Discount on MRP</dt><dd>−₹7,900</dd></div>
                            <div class="row"><dt>Blouse Stitching</dt><dd>+₹499</dd></div>
                            <div class="row"><dt>Fall &amp; Pico</dt><dd>+₹250</dd></div>
                            <div class="row is-green"><dt>Coupon (ARCHANA10)</dt><dd>−₹1,960</dd></div>
                            <div class="row">
                                <dt>Shipping Fee</dt>
                                <dd class="is-green"><del>₹149</del> Free</dd>
                            </div>
                            <div class="row row-total"><dt>Total Amount</dt><dd>₹18,386</dd></div>
                        </dl>
                        <p class="gst-note">Inclusive of all taxes</p>
                        <p class="save-chip">
                            <i class="fa-solid fa-piggy-bank" aria-hidden="true"></i>
                            You are saving ₹9,860 on this order
                        </p>

                        <button type="submit" class="btn btn-primary place-btn">
                            Continue to Payment <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                        </button>
                        <p class="terms-note">
                            By continuing, you agree to our
                            <a href="{{ url('/terms') }}">Terms</a> and
                            <a href="{{ url('/privacy') }}">Privacy Policy</a>.
                        </p>
                    </div>

                    <ul class="trust-list">
                        <li><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i> Easy 7-day returns</li>
                        <li><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Secure payments</li>
                        <li><i class="fa-solid fa-gem" aria-hidden="true"></i> Authentic craftsmanship</li>
                        <li><i class="fa-solid fa-truck-fast" aria-hidden="true"></i> Pan-India delivery</li>
                    </ul>

                    <a href="javascript:void(0)" class="co-help">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        <span>Need help with your order? <b>Chat with our stylists</b></span>
                    </a>
                </aside>

                <datalist id="stateList">
                    @foreach ($states as $state)
                        <option value="{{ $state }}"></option>
                    @endforeach
                </datalist>
            </form>

            <div class="co-bar">
                <div class="bar-total">
                    <span>Total</span>
                    <strong>₹18,386</strong>
                </div>
                <button type="submit" form="checkoutForm" class="btn btn-primary">
                    Continue to Payment <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>
@endsection