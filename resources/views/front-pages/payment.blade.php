@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/payment/payment.css') }}" />
@endpush

@section('content')
    @php
        $states = ['Andhra Pradesh', 'Delhi', 'Gujarat', 'Haryana', 'Karnataka', 'Kerala', 'Maharashtra',
                   'Punjab', 'Rajasthan', 'Tamil Nadu', 'Telangana', 'Uttar Pradesh', 'West Bengal'];

        $miniImgs = [
            ['tab1.png', 'Zari Woven Banarasi Silk Saree'],
            ['tab2.png', 'Organza Embroidered Party Saree'],
            ['tab4.png', 'Georgette Printed Saree'],
        ];
    @endphp

    <section class="payment-secA">
        <div class="container">
            <div class="pay-top">
                <ol class="pay-steps" aria-label="Checkout progress">
                    <li class="step is-done">
                        <a href="{{ route('cart') }}" class="step-link">
                            <span class="step-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                            <span class="step-label">Bag</span>
                        </a>
                    </li>
                    <li class="step is-done">
                        <a href="{{ route('checkout') }}" class="step-link">
                            <span class="step-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                            <span class="step-label">Address</span>
                        </a>
                    </li>
                    <li class="step is-active" aria-current="step">
                        <span class="step-icon"><i class="fa-solid fa-credit-card" aria-hidden="true"></i></span>
                        <span class="step-label">Payment</span>
                    </li>
                </ol>
                <span class="secure-tag"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> 100% Secure Checkout</span>
            </div>

            <div class="pay-head">
                <h1>Payment</h1>
                <a href="{{ route('checkout') }}" class="back-link">
                    <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Back to address
                </a>
            </div>

            @if (session('payment_failed'))
                <div class="pay-alert" role="alert">
                    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                    <p><strong>Payment failed.</strong> Your payment of ₹18,386 could not be completed. Please try again.</p>
                    <a href="#pmTabs" class="alert-link">Try again</a>
                </div>
            @endif

            <form class="pay-layout form" id="payForm" action="#" method="post" novalidate>
                @csrf
                <div class="pay-card">
                    {{-- Deliver to --}}
                    <div class="pay-sec ship-to">
                        <span class="ship-icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                        <p class="ship-text">
                            <strong>Deliver to Aarav Mehta, 110001</strong>
                            <small>12, Park Street, Connaught Place, New Delhi · Delivery by Mon, 2 Nov</small>
                        </p>
                        <a href="{{ route('checkout') }}" class="ship-change">Change</a>
                    </div>

                    {{-- Payment method --}}
                    <div class="pay-sec pm">
                        <h2 class="sec-label">Payment method</h2>

                        <input type="radio" name="payment" id="pmOnline" class="pm-radio" value="online" {{ old('payment', 'online') === 'online' ? 'checked' : '' }} />
                        <input type="radio" name="payment" id="pmCod" class="pm-radio" value="cod" {{ old('payment') === 'cod' ? 'checked' : '' }} />

                        <div class="pm-tabs" id="pmTabs" role="radiogroup" aria-label="Choose a payment method">
                            <label for="pmOnline" class="pm-tab">
                                <span class="pm-icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span>
                                <span class="pm-text">
                                    <strong>Pay Online</strong>
                                    <small>UPI, Cards, Net Banking</small>
                                </span>
                                <span class="radio-dot" aria-hidden="true"></span>
                                <span class="pm-badge">Extra 10% off</span>
                            </label>
                            <label for="pmCod" class="pm-tab">
                                <span class="pm-icon"><i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i></span>
                                <span class="pm-text">
                                    <strong>Cash on Delivery</strong>
                                    <small>Pay when it arrives</small>
                                </span>
                                <span class="radio-dot" aria-hidden="true"></span>
                            </label>
                        </div>

                        <p class="pm-info pm-online">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i>
                            <span>Pay via UPI, Cards or Net Banking on our secure page. We never store your card or bank details.</span>
                        </p>
                        <p class="pm-info pm-cod">
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                            <span>Cash on Delivery is available for PIN 110001. Please keep the exact amount ready.</span>
                        </p>
                    </div>

                    {{-- Billing --}}
                    <div class="pay-sec bill">
                        <label class="check">
                            <input type="checkbox" id="billSame" name="billing_same" checked />
                            <span>Billing address same as delivery address</span>
                        </label>

                        <div class="bill-form">
                            <div class="fields">
                                <div class="form-group s-12">
                                    <input type="text" id="bName" name="bill_name" placeholder=" " autocomplete="billing name" />
                                    <label for="bName">Full name</label>
                                </div>
                                <div class="form-group s-5">
                                    <input type="text" id="bHouse" name="bill_house" placeholder=" " autocomplete="billing address-line1" />
                                    <label for="bHouse">House / Flat no.</label>
                                </div>
                                <div class="form-group s-7">
                                    <input type="text" id="bStreet" name="bill_street" placeholder=" " autocomplete="billing address-line2" />
                                    <label for="bStreet">Street / Area / Locality</label>
                                </div>
                                <div class="form-group s-4">
                                    <input type="text" id="bPin" name="bill_pin" placeholder=" " inputmode="numeric" maxlength="6" autocomplete="billing postal-code" />
                                    <label for="bPin">PIN code</label>
                                </div>
                                <div class="form-group s-4">
                                    <input type="text" id="bCity" name="bill_city" placeholder=" " autocomplete="billing address-level2" />
                                    <label for="bCity">City</label>
                                </div>
                                <div class="form-group s-4">
                                    <input type="text" id="bState" name="bill_state" placeholder=" " list="stateList" autocomplete="billing address-level1" />
                                    <label for="bState">State</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <aside class="pay-summary" aria-label="Order summary">
                    <div class="box">
                        <div class="mini-row">
                            <ul class="mini-imgs">
                                @foreach ($miniImgs as [$img, $alt])
                                    <li><img src="{{ asset('assets/images/home/' . $img) }}" alt="{{ $alt }}" width="44" height="58" loading="lazy" /></li>
                                @endforeach
                            </ul>
                            <p class="mini-text"><strong>Order Summary</strong><small>{{ count($miniImgs) }} items</small></p>
                            <a href="{{ route('cart') }}" class="mini-edit">Edit bag</a>
                        </div>

                        <dl class="rows">
                            <div class="row"><dt>Total MRP</dt><dd>₹27,497</dd></div>
                            <div class="row is-green"><dt>Discount on MRP</dt><dd>−₹7,900</dd></div>
                            <div class="row"><dt>Blouse &amp; Fall/Pico</dt><dd>+₹749</dd></div>
                            <div class="row is-green"><dt>Coupon (ARCHANA10)</dt><dd>−₹1,960</dd></div>
                            <div class="row"><dt>Shipping Fee</dt><dd class="is-green"><del>₹149</del> Free</dd></div>
                            <div class="row row-total"><dt>Amount Payable</dt><dd>₹18,386</dd></div>
                        </dl>
                        <p class="save-chip">
                            <i class="fa-solid fa-piggy-bank" aria-hidden="true"></i>
                            You are saving ₹9,860 · Inclusive of all taxes
                        </p>

                        <button type="submit" class="btn btn-primary place-btn pay-btn">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i> Pay ₹18,386 Securely
                        </button>
                        <button type="submit" class="btn btn-primary place-btn cod-btn">
                            Place Order <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                        </button>
                        <p class="terms-note">
                            By continuing, you agree to our
                            <a href="terms.html">Terms</a> and
                            <a href="privacy'.html">Privacy Policy</a>.
                        </p>
                    </div>

                    <ul class="trust-list">
                        <li><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i> 7-day returns</li>
                        <li><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Secure payments</li>
                        <li><i class="fa-solid fa-truck-fast" aria-hidden="true"></i> Pan-India delivery</li>
                    </ul>
                </aside>

                <datalist id="stateList">
                    @foreach ($states as $state)
                        <option value="{{ $state }}"></option>
                    @endforeach
                </datalist>
            </form>

            <div class="pay-bar">
                <div class="bar-total">
                    <span>Amount Payable</span>
                    <strong>₹18,386</strong>
                </div>
                <button type="submit" form="payForm" class="btn btn-primary bar-pay">
                    <i class="fa-solid fa-lock" aria-hidden="true"></i> Pay Securely
                </button>
                <button type="submit" form="payForm" class="btn btn-primary bar-cod">
                    Place Order <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>
@endsection