@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/cart/cart.css') }}" />
@endpush

@section('content')
    @php
        $items = [
            [
                'img' => 'tab1.png', 'cat' => 'Banarasi Saree', 'name' => 'Zari Woven Banarasi Silk Saree',
                'color' => 'Wine', 'hex' => '#5e1a33', 'blouse' => 'Stitched · M', 'addon' => 'Fall & Pico',
                'price' => '₹8,499', 'old' => '₹11,999', 'off' => '29% OFF',
                'extra' => '+ ₹499 blouse stitching · + ₹250 fall & pico', 'stock' => null, 'total' => '₹9,248',
            ],
            [
                'img' => 'tab2.png', 'cat' => 'Organza Saree', 'name' => 'Organza Embroidered Party Saree',
                'color' => 'Pink', 'hex' => '#e79aa8', 'blouse' => 'Unstitched Piece', 'addon' => null,
                'price' => '₹6,299', 'old' => '₹8,999', 'off' => '30% OFF',
                'extra' => null, 'stock' => 'Only 2 left in stock', 'total' => '₹6,299',
            ],
            [
                'img' => 'tab4.png', 'cat' => 'Georgette Saree', 'name' => 'Georgette Printed Saree',
                'color' => 'Green', 'hex' => '#1f6b4f', 'blouse' => 'Unstitched Piece', 'addon' => null,
                'price' => '₹4,799', 'old' => '₹6,499', 'off' => '26% OFF',
                'extra' => null, 'stock' => null, 'total' => '₹4,799',
            ],
        ];

        $payMethods = [
            ['Visa', 'fa-brands fa-cc-visa'],
            ['Mastercard', 'fa-brands fa-cc-mastercard'],
            ['UPI', 'fa-solid fa-mobile-screen-button'],
            ['Net Banking', 'fa-solid fa-building-columns'],
            ['Cash on Delivery', 'fa-solid fa-indian-rupee-sign'],
        ];
    @endphp

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
                <span class="secure-tag"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> 100% Secure Checkout</span>
            </div>

            <div class="cart-head">
                <span class="eyebrow">Your Selection</span>
                <h1>My Bag</h1>
                <p>{{ count($items) }} items · <b>₹18,386</b></p>
            </div>

            <div class="cart-layout">
                <div class="cart-main">
                    <div class="ship-progress is-done" style="--p: 100%">
                        <p>
                            <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
                            Congratulations! You have unlocked <b>FREE shipping</b> on this order.
                        </p>
                        <div class="ship-bar"><span></span></div>
                    </div>

                    <ul class="cart-list">
                        @foreach ($items as $item)
                            <li class="cart-item">
                                <a class="item-img" href="javascript:void(0)">
                                    <img src="{{ asset('assets/images/home/' . $item['img']) }}" alt="{{ $item['name'] }}" width="130" height="173" loading="lazy" />
                                </a>
                                <div class="item-info">
                                    <span class="item-cat">{{ $item['cat'] }}</span>
                                    <h2 class="item-name">
                                        <a href="javascript:void(0)">{{ $item['name'] }}</a>
                                    </h2>
                                    <ul class="item-meta">
                                        <li>
                                            <span>Colour</span>
                                            <b><i class="dot" style="--c: {{ $item['hex'] }}"></i> {{ $item['color'] }}</b>
                                        </li>
                                        <li><span>Size</span><b>Free Size</b></li>
                                        <li><span>Blouse</span><b>{{ $item['blouse'] }}</b></li>
                                        @if ($item['addon'])
                                            <li><span>Add-on</span><b>{{ $item['addon'] }}</b></li>
                                        @endif
                                    </ul>
                                    <div class="item-price">
                                        <strong>{{ $item['price'] }}</strong><del>{{ $item['old'] }}</del>
                                        <span class="item-off">{{ $item['off'] }}</span>
                                    </div>
                                    @if ($item['extra'])
                                        <p class="item-extra">{{ $item['extra'] }}</p>
                                    @endif
                                    @if ($item['stock'])
                                        <p class="item-stock">
                                            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                                            {{ $item['stock'] }}
                                        </p>
                                    @endif
                                    <p class="item-delivery">
                                        <i class="fa-solid fa-truck" aria-hidden="true"></i>
                                        Delivery by <b>Mon, 2 Nov</b>
                                    </p>
                                    <div class="item-actions">
                                        <div class="cart-qty" role="group" aria-label="Quantity for {{ $item['name'] }}">
                                            <button type="button" class="qty-minus" aria-label="Decrease quantity">
                                                <i class="fa-solid fa-minus" aria-hidden="true"></i>
                                            </button>
                                            <input type="text" class="qty-input" value="1" readonly aria-label="Quantity" />
                                            <button type="button" class="qty-plus" aria-label="Increase quantity">
                                                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="item-link">
                                            <i class="fa-regular fa-heart" aria-hidden="true"></i> Move to Wishlist
                                        </button>
                                        <button type="button" class="item-link is-remove">
                                            <i class="fa-regular fa-trash-can" aria-hidden="true"></i> Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="item-total">
                                    <span>Item total</span>
                                    <strong>{{ $item['total'] }}</strong>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="cart-note">
                        <h5><i class="fa-solid fa-gift" aria-hidden="true"></i> Gift &amp; Notes</h5>
                        <label class="gift-check">
                            <input type="checkbox" name="gift" value="1" />
                            <span>This order is a gift. Pack beautifully and hide price details.</span>
                        </label>
                        <div class="form">
                            <div class="form-group">
                                <textarea id="cartNote" name="note" placeholder=" "></textarea>
                                <label for="cartNote">Gift message or special note (optional)</label>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/all-products') }}" class="continue-link">
                        <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Continue Shopping
                    </a>
                </div>

                <aside class="cart-summary" aria-label="Order summary">
                    <div class="box coupon-box">
                        <h5><i class="fa-solid fa-ticket" aria-hidden="true"></i> Coupons &amp; Offers</h5>
                        <form class="form coupon-form" action="#" method="post" novalidate>
                            @csrf
                            <div class="form-group">
                                <input type="text" id="couponInput" name="coupon" placeholder=" " autocomplete="off" />
                                <label for="couponInput">Enter coupon code</label>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Apply</button>
                        </form>

                        <div class="coupon-applied">
                            <span class="applied-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                            <div class="applied-text">
                                <strong>ARCHANA10 applied</strong>
                                <span>You saved ₹1,960 with this coupon</span>
                            </div>
                            <button type="button" class="applied-remove" aria-label="Remove coupon ARCHANA10">Remove</button>
                        </div>

                        <p class="offers-title">Available Offers</p>
                        <ul class="offer-list">
                            <li class="is-applied">
                                <span class="offer-icon"><i class="fa-solid fa-tag" aria-hidden="true"></i></span>
                                <div class="offer-text">
                                    <span class="offer-code">ARCHANA10</span>
                                    <p>Extra 10% off on prepaid orders</p>
                                </div>
                                <span class="offer-state">Applied</span>
                            </li>
                            <li>
                                <span class="offer-icon"><i class="fa-solid fa-gift" aria-hidden="true"></i></span>
                                <div class="offer-text">
                                    <span class="offer-code">FESTIVE25</span>
                                    <p>Flat 25% off on selected festive styles</p>
                                </div>
                                <button type="button" class="offer-apply" data-code="FESTIVE25">Apply</button>
                            </li>
                        </ul>
                    </div>

                    <div class="box delivery-box">
                        <h5><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Delivery Details</h5>
                        <form class="form pin-form" action="#" method="post" novalidate>
                            @csrf
                            <div class="form-group">
                                <input type="text" id="cartPin" name="pincode" inputmode="numeric" maxlength="6" placeholder=" " value="110001" />
                                <label for="cartPin">Pincode</label>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Check</button>
                        </form>
                        <p class="pin-result">
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                            Delivery available. Estimated by <b>Mon, 2 Nov</b>.
                        </p>
                        <ul class="del-points">
                            <li><i class="fa-solid fa-box" aria-hidden="true"></i> Dispatch in 2–4 working days</li>
                            <li>
                                <i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i>
                                Cash on Delivery available at your pincode
                            </li>
                        </ul>
                    </div>

                    <div class="box price-box">
                        <h5>Price Details <span>({{ count($items) }} items)</span></h5>
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
                        <a href="{{ url('/checkout') }}" class="btn btn-primary place-btn">
                            Proceed to Address <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                        </a>
                        <ul class="pay-methods" aria-label="Accepted payment methods">
                            @foreach ($payMethods as [$title, $icon])
                                <li title="{{ $title }}">
                                    <i class="{{ $icon }}" aria-hidden="true"></i><span class="sr-only">{{ $title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <ul class="trust-list">
                        <li><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i> Easy 7-day returns</li>
                        <li><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Secure payments</li>
                        <li><i class="fa-solid fa-gem" aria-hidden="true"></i> Authentic craftsmanship</li>
                        <li><i class="fa-solid fa-truck-fast" aria-hidden="true"></i> Pan-India delivery</li>
                    </ul>

                    <a href="javascript:void(0)" class="cart-help">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        <span>Need help with your order? <b>Chat with our stylists</b></span>
                    </a>
                </aside>
            </div>

            <div class="cart-bar">
                <div class="bar-total">
                    <span>Total</span>
                    <strong>₹18,386</strong>
                </div>
                <a href="{{ url('/checkout') }}" class="btn btn-primary">
                    Proceed to Address <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    <div class="cart-empty">
        <span class="empty-ico"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i></span>
        <h2>Your bag is empty</h2>
        <p>
            Looks like you have not added anything yet. Explore our latest sarees,
            lehengas and bridal wear.
        </p>
        <div class="empty-btns">
            <a href="{{ url('/all-products') }}" class="btn btn-primary">Shop Sarees</a>
            <a href="javascript:void(0)" class="btn btn-outline-primary">View New Arrivals</a>
        </div>
        <ul class="empty-links">
            <li><a href="javascript:void(0)">Banarasi Sarees</a></li>
            <li><a href="javascript:void(0)">Bridal Wear</a></li>
            <li><a href="javascript:void(0)">Lehengas</a></li>
            <li><a href="javascript:void(0)">Party Wear</a></li>
        </ul>
    </div>
@endsection