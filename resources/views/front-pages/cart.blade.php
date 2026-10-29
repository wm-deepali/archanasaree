@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/cart/cart.css') }}" />
@endpush

@section('content')

    <main>
      <section class="cart-secA">
        <div class="container">
          <div class="cart-top">
            <ol class="cart-steps" aria-label="Checkout progress">
              <li class="step is-active" aria-current="step">
                <span class="step-icon"
                  ><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i
                ></span>
                <span class="step-label">Bag</span>
              </li>
              <li class="step">
                <span class="step-icon"
                  ><i class="fa-solid fa-location-dot" aria-hidden="true"></i
                ></span>
                <span class="step-label">Address</span>
              </li>
              <li class="step">
                <span class="step-icon"
                  ><i class="fa-solid fa-credit-card" aria-hidden="true"></i
                ></span>
                <span class="step-label">Payment</span>
              </li>
            </ol>
            <span class="secure-tag"
              ><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> 100%
              Secure Checkout</span
            >
          </div>

          <div class="cart-head">
            <span class="eyebrow">Your Selection</span>
            <h1>My Bag</h1>
            <p>3 items · <b>₹18,386</b></p>
          </div>

          <div class="cart-layout">
            <div class="cart-main">
              <div class="ship-progress is-done" style="--p: 100%">
                <p>
                  <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
                  Congratulations! You have unlocked <b>FREE shipping</b> on
                  this order.
                </p>
                <div class="ship-bar"><span></span></div>
              </div>

              <ul class="cart-list">
                <li class="cart-item">
                  <a class="item-img" href="javascript:void(0)">
                    <img
                      src="assets/images/home/tab1.png"
                      alt="Zari Woven Banarasi Silk Saree"
                      width="130"
                      height="173"
                      loading="lazy"
                    />
                  </a>
                  <div class="item-info">
                    <span class="item-cat">Banarasi Saree</span>
                    <h2 class="item-name">
                      <a href="javascript:void(0)"
                        >Zari Woven Banarasi Silk Saree</a
                      >
                    </h2>
                    <ul class="item-meta">
                      <li>
                        <span>Colour</span
                        ><b><i class="dot" style="--c: #5e1a33"></i> Wine</b>
                      </li>
                      <li><span>Size</span><b>Free Size</b></li>
                      <li><span>Blouse</span><b>Stitched · M</b></li>
                      <li><span>Add-on</span><b>Fall &amp; Pico</b></li>
                    </ul>
                    <div class="item-price">
                      <strong>₹8,499</strong><del>₹11,999</del
                      ><span class="item-off">29% OFF</span>
                    </div>
                    <p class="item-extra">
                      + ₹499 blouse stitching · + ₹250 fall &amp; pico
                    </p>
                    <p class="item-delivery">
                      <i class="fa-solid fa-truck" aria-hidden="true"></i>
                      Delivery by <b>Mon, 2 Nov</b>
                    </p>
                    <div class="item-actions">
                      <div
                        class="cart-qty"
                        role="group"
                        aria-label="Quantity for Zari Woven Banarasi Silk Saree"
                      >
                        <button
                          type="button"
                          class="qty-minus"
                          aria-label="Decrease quantity"
                        >
                          <i class="fa-solid fa-minus" aria-hidden="true"></i>
                        </button>
                        <input
                          type="text"
                          class="qty-input"
                          value="1"
                          readonly
                          aria-label="Quantity"
                        />
                        <button
                          type="button"
                          class="qty-plus"
                          aria-label="Increase quantity"
                        >
                          <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                      </div>
                      <button type="button" class="item-link">
                        <i class="fa-regular fa-heart" aria-hidden="true"></i>
                        Move to Wishlist
                      </button>
                      <button type="button" class="item-link is-remove">
                        <i
                          class="fa-regular fa-trash-can"
                          aria-hidden="true"
                        ></i>
                        Remove
                      </button>
                    </div>
                  </div>
                  <div class="item-total">
                    <span>Item total</span>
                    <strong>₹9,248</strong>
                  </div>
                </li>

                <li class="cart-item">
                  <a class="item-img" href="javascript:void(0)">
                    <img
                      src="assets/images/home/tab2.png"
                      alt="Organza Embroidered Party Saree"
                      width="130"
                      height="173"
                      loading="lazy"
                    />
                  </a>
                  <div class="item-info">
                    <span class="item-cat">Organza Saree</span>
                    <h2 class="item-name">
                      <a href="javascript:void(0)"
                        >Organza Embroidered Party Saree</a
                      >
                    </h2>
                    <ul class="item-meta">
                      <li>
                        <span>Colour</span
                        ><b><i class="dot" style="--c: #e79aa8"></i> Pink</b>
                      </li>
                      <li><span>Size</span><b>Free Size</b></li>
                      <li><span>Blouse</span><b>Unstitched Piece</b></li>
                    </ul>
                    <div class="item-price">
                      <strong>₹6,299</strong><del>₹8,999</del
                      ><span class="item-off">30% OFF</span>
                    </div>
                    <p class="item-stock">
                      <i
                        class="fa-solid fa-circle-exclamation"
                        aria-hidden="true"
                      ></i>
                      Only 2 left in stock
                    </p>
                    <p class="item-delivery">
                      <i class="fa-solid fa-truck" aria-hidden="true"></i>
                      Delivery by <b>Mon, 2 Nov</b>
                    </p>
                    <div class="item-actions">
                      <div
                        class="cart-qty"
                        role="group"
                        aria-label="Quantity for Organza Embroidered Party Saree"
                      >
                        <button
                          type="button"
                          class="qty-minus"
                          aria-label="Decrease quantity"
                        >
                          <i class="fa-solid fa-minus" aria-hidden="true"></i>
                        </button>
                        <input
                          type="text"
                          class="qty-input"
                          value="1"
                          readonly
                          aria-label="Quantity"
                        />
                        <button
                          type="button"
                          class="qty-plus"
                          aria-label="Increase quantity"
                        >
                          <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                      </div>
                      <button type="button" class="item-link">
                        <i class="fa-regular fa-heart" aria-hidden="true"></i>
                        Move to Wishlist
                      </button>
                      <button type="button" class="item-link is-remove">
                        <i
                          class="fa-regular fa-trash-can"
                          aria-hidden="true"
                        ></i>
                        Remove
                      </button>
                    </div>
                  </div>
                  <div class="item-total">
                    <span>Item total</span>
                    <strong>₹6,299</strong>
                  </div>
                </li>

                <li class="cart-item">
                  <a class="item-img" href="javascript:void(0)">
                    <img
                      src="assets/images/home/tab4.png"
                      alt="Georgette Printed Saree"
                      width="130"
                      height="173"
                      loading="lazy"
                    />
                  </a>
                  <div class="item-info">
                    <span class="item-cat">Georgette Saree</span>
                    <h2 class="item-name">
                      <a href="javascript:void(0)">Georgette Printed Saree</a>
                    </h2>
                    <ul class="item-meta">
                      <li>
                        <span>Colour</span
                        ><b><i class="dot" style="--c: #1f6b4f"></i> Green</b>
                      </li>
                      <li><span>Size</span><b>Free Size</b></li>
                      <li><span>Blouse</span><b>Unstitched Piece</b></li>
                    </ul>
                    <div class="item-price">
                      <strong>₹4,799</strong><del>₹6,499</del
                      ><span class="item-off">26% OFF</span>
                    </div>
                    <p class="item-delivery">
                      <i class="fa-solid fa-truck" aria-hidden="true"></i>
                      Delivery by <b>Mon, 2 Nov</b>
                    </p>
                    <div class="item-actions">
                      <div
                        class="cart-qty"
                        role="group"
                        aria-label="Quantity for Georgette Printed Saree"
                      >
                        <button
                          type="button"
                          class="qty-minus"
                          aria-label="Decrease quantity"
                        >
                          <i class="fa-solid fa-minus" aria-hidden="true"></i>
                        </button>
                        <input
                          type="text"
                          class="qty-input"
                          value="1"
                          readonly
                          aria-label="Quantity"
                        />
                        <button
                          type="button"
                          class="qty-plus"
                          aria-label="Increase quantity"
                        >
                          <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                      </div>
                      <button type="button" class="item-link">
                        <i class="fa-regular fa-heart" aria-hidden="true"></i>
                        Move to Wishlist
                      </button>
                      <button type="button" class="item-link is-remove">
                        <i
                          class="fa-regular fa-trash-can"
                          aria-hidden="true"
                        ></i>
                        Remove
                      </button>
                    </div>
                  </div>
                  <div class="item-total">
                    <span>Item total</span>
                    <strong>₹4,799</strong>
                  </div>
                </li>
              </ul>

              <div class="cart-note">
                <h5>
                  <i class="fa-solid fa-gift" aria-hidden="true"></i> Gift &amp;
                  Notes
                </h5>
                <label class="gift-check">
                  <input type="checkbox" name="gift" value="1" />
                  <span
                    >This order is a gift. Pack beautifully and hide price
                    details.</span
                  >
                </label>
                <div class="form">
                  <div class="form-group">
                    <textarea
                      id="cartNote"
                      name="note"
                      placeholder=" "
                    ></textarea>
                    <label for="cartNote"
                      >Gift message or special note (optional)</label
                    >
                  </div>
                </div>
              </div>

              <a href="{{ route('products') }}" class="continue-link">
                <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
                Continue Shopping
              </a>
            </div>

            <aside class="cart-summary" aria-label="Order summary">
              <div class="box coupon-box">
                <h5>
                  <i class="fa-solid fa-ticket" aria-hidden="true"></i> Coupons
                  &amp; Offers
                </h5>
                <form
                  class="form coupon-form"
                  action="#"
                  method="post"
                  novalidate
                >
                  <div class="form-group">
                    <input
                      type="text"
                      id="couponInput"
                      name="coupon"
                      placeholder=" "
                      autocomplete="off"
                    />
                    <label for="couponInput">Enter coupon code</label>
                  </div>
                  <button type="submit" class="btn btn-outline-primary">
                    Apply
                  </button>
                </form>

                <div class="coupon-applied">
                  <span class="applied-icon"
                    ><i class="fa-solid fa-check" aria-hidden="true"></i
                  ></span>
                  <div class="applied-text">
                    <strong>ARCHANA10 applied</strong>
                    <span>You saved ₹1,960 with this coupon</span>
                  </div>
                  <button
                    type="button"
                    class="applied-remove"
                    aria-label="Remove coupon ARCHANA10"
                  >
                    Remove
                  </button>
                </div>

                <p class="offers-title">Available Offers</p>
                <ul class="offer-list">
                  <li class="is-applied">
                    <span class="offer-icon"
                      ><i class="fa-solid fa-tag" aria-hidden="true"></i
                    ></span>
                    <div class="offer-text">
                      <span class="offer-code">ARCHANA10</span>
                      <p>Extra 10% off on prepaid orders</p>
                    </div>
                    <span class="offer-state">Applied</span>
                  </li>
                  <li>
                    <span class="offer-icon"
                      ><i class="fa-solid fa-gift" aria-hidden="true"></i
                    ></span>
                    <div class="offer-text">
                      <span class="offer-code">FESTIVE25</span>
                      <p>Flat 25% off on selected festive styles</p>
                    </div>
                    <button
                      type="button"
                      class="offer-apply"
                      data-code="FESTIVE25"
                    >
                      Apply
                    </button>
                  </li>
                </ul>
              </div>

              <div class="box delivery-box">
                <h5>
                  <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                  Delivery Details
                </h5>
                <form class="form pin-form" action="#" method="post" novalidate>
                  <div class="form-group">
                    <input
                      type="text"
                      id="cartPin"
                      name="pincode"
                      inputmode="numeric"
                      maxlength="6"
                      placeholder=" "
                      value="110001"
                    />
                    <label for="cartPin">Pincode</label>
                  </div>
                  <button type="submit" class="btn btn-outline-primary">
                    Check
                  </button>
                </form>
                <p class="pin-result">
                  <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                  Delivery available. Estimated by <b>Mon, 2 Nov</b>.
                </p>
                <ul class="del-points">
                  <li>
                    <i class="fa-solid fa-box" aria-hidden="true"></i> Dispatch
                    in 2–4 working days
                  </li>
                  <li>
                    <i
                      class="fa-solid fa-hand-holding-dollar"
                      aria-hidden="true"
                    ></i>
                    Cash on Delivery available at your pincode
                  </li>
                </ul>
              </div>

              <div class="box price-box">
                <h5>Price Details <span>(3 items)</span></h5>
                <dl class="rows">
                  <div class="row">
                    <dt>Total MRP</dt>
                    <dd>₹27,497</dd>
                  </div>
                  <div class="row is-green">
                    <dt>Discount on MRP</dt>
                    <dd>−₹7,900</dd>
                  </div>
                  <div class="row">
                    <dt>Blouse Stitching</dt>
                    <dd>+₹499</dd>
                  </div>
                  <div class="row">
                    <dt>Fall &amp; Pico</dt>
                    <dd>+₹250</dd>
                  </div>
                  <div class="row is-green">
                    <dt>Coupon (ARCHANA10)</dt>
                    <dd>−₹1,960</dd>
                  </div>
                  <div class="row">
                    <dt>Shipping Fee</dt>
                    <dd class="is-green"><del>₹149</del> Free</dd>
                  </div>
                  <div class="row row-total">
                    <dt>Total Amount</dt>
                    <dd>₹18,386</dd>
                  </div>
                </dl>
                <p class="gst-note">Inclusive of all taxes</p>
                <p class="save-chip">
                  <i class="fa-solid fa-piggy-bank" aria-hidden="true"></i> You
                  are saving ₹9,860 on this order
                </p>
                <a href="checkout.html" class="btn btn-primary place-btn"
                  >Proceed to Address
                  <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i
                ></a>
                <ul class="pay-methods" aria-label="Accepted payment methods">
                  <li title="Visa">
                    <i class="fa-brands fa-cc-visa" aria-hidden="true"></i
                    ><span class="sr-only">Visa</span>
                  </li>
                  <li title="Mastercard">
                    <i class="fa-brands fa-cc-mastercard" aria-hidden="true"></i
                    ><span class="sr-only">Mastercard</span>
                  </li>
                  <li title="UPI and Wallets">
                    <i
                      class="fa-solid fa-mobile-screen-button"
                      aria-hidden="true"
                    ></i
                    ><span class="sr-only">UPI</span>
                  </li>
                  <li title="Net Banking">
                    <i
                      class="fa-solid fa-building-columns"
                      aria-hidden="true"
                    ></i
                    ><span class="sr-only">Net Banking</span>
                  </li>
                  <li title="Cash on Delivery">
                    <i
                      class="fa-solid fa-indian-rupee-sign"
                      aria-hidden="true"
                    ></i
                    ><span class="sr-only">Cash on Delivery</span>
                  </li>
                </ul>
              </div>

              <ul class="trust-list">
                <li>
                  <i
                    class="fa-solid fa-arrow-right-arrow-left"
                    aria-hidden="true"
                  ></i>
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
                <span
                  >Need help with your order?
                  <b>Chat with our stylists</b></span
                >
              </a>
            </aside>
          </div>

          <div class="cart-bar">
            <div class="bar-total">
              <span>Total</span>
              <strong>₹18,386</strong>
            </div>
            <a href="checkout.html" class="btn btn-primary"
              >Proceed to Address
              <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i
            ></a>
          </div>
        </div>
      </section>

      <div class="cart-empty">
        <span class="empty-ico"
          ><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i
        ></span>
        <h2>Your bag is empty</h2>
        <p>
          Looks like you have not added anything yet. Explore our latest sarees,
          lehengas and bridal wear.
        </p>
        <div class="empty-btns">
          <a href="/all-products" class="btn btn-primary">Shop Sarees</a>
          <a href="javascript:void(0)" class="btn btn-outline-primary"
            >View New Arrivals</a
          >
        </div>
        <ul class="empty-links">
          <li><a href="javascript:void(0)">Banarasi Sarees</a></li>
          <li><a href="javascript:void(0)">Bridal Wear</a></li>
          <li><a href="javascript:void(0)">Lehengas</a></li>
          <li><a href="javascript:void(0)">Party Wear</a></li>
        </ul>
      </div>
    </main>

@endsection