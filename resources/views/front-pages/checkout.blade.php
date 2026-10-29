@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/checkout/checkout.css') }}" />
@endpush

@section('content')

    <main>
      <section class="checkout-secA">
        <div class="container">
          <div class="co-top">
            <ol class="co-steps" aria-label="Checkout progress">
              <li class="step is-done">
                <a href="cart.html" class="step-link">
                  <span class="step-icon"
                    ><i class="fa-solid fa-check" aria-hidden="true"></i
                  ></span>
                  <span class="step-label">Bag</span>
                </a>
              </li>
              <li class="step is-active" aria-current="step">
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

          <div class="co-head">
            <span class="eyebrow">Almost There</span>
            <h1>Delivery Details</h1>
            <a href="cart.html" class="back-link"
              ><i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
              Back to bag</a
            >
          </div>

          <form
            class="co-layout form"
            action="/checkout/payment"
            method="post"
            novalidate
          >
            <div class="co-main">
              <!-- 1. Contact -->
              <section class="co-block">
                <div class="co-row">
                  <h2 class="co-title"><span class="num">1</span> Contact</h2>
                  <p class="co-aside">
                    Have an account? <a href="/login?next=/checkout">Log in</a>
                  </p>
                </div>
                <div class="fields">
                  <div class="form-group s-12">
                    <input
                      type="email"
                      id="cEmail"
                      name="email"
                      placeholder=" "
                      autocomplete="email"
                    />
                    <label for="cEmail">Email address</label>
                  </div>
                </div>
                <label class="check">
                  <input type="checkbox" name="email_updates" checked />
                  <span>Email me order updates and festive offers</span>
                </label>
              </section>

              <!-- 2. Address -->
              <section class="co-block">
                <h2 class="co-title">
                  <span class="num">2</span> Delivery address
                </h2>

                <div
                  class="addr-list"
                  role="radiogroup"
                  aria-label="Choose a delivery address"
                >
                  <!-- Address 1 -->
                  <div class="addr-card">
                    <input
                      type="radio"
                      name="address"
                      id="addr1"
                      class="addr-radio"
                      value="1"
                      checked
                    />
                    <label for="addr1" class="addr-body">
                      <span class="radio-dot" aria-hidden="true"></span>
                      <span class="addr-info">
                        <span class="addr-top">
                          <strong>Aarav Mehta</strong>
                          <span class="tag">Home</span>
                          <span class="tag tag-default">Default</span>
                        </span>
                        <span class="addr-line"
                          >12, Park Street, Near Metro Gate 3, Connaught
                          Place</span
                        >
                        <span class="addr-line">New Delhi, Delhi - 110001</span>
                        <span class="addr-phone"
                          ><i class="fa-solid fa-phone" aria-hidden="true"></i>
                          +91 98765 43210</span
                        >
                      </span>
                    </label>

                    <input type="checkbox" id="edit1" class="edit-toggle" />
                    <label for="edit1" class="addr-edit"
                      ><i class="fa-solid fa-pen" aria-hidden="true"></i>
                      Edit</label
                    >

                    <div class="addr-form">
                      <h3>Edit address</h3>
                      <div class="fields">
                        <div class="form-group s-6">
                          <input
                            type="text"
                            id="a1Name"
                            name="a1_name"
                            value="Aarav Mehta"
                            placeholder=" "
                            autocomplete="name"
                          />
                          <label for="a1Name">Full name</label>
                        </div>
                        <div class="form-group has-prefix s-6">
                          <span class="prefix">+91</span>
                          <input
                            type="tel"
                            id="a1Phone"
                            name="a1_phone"
                            value="9876543210"
                            placeholder=" "
                            inputmode="numeric"
                            maxlength="10"
                            autocomplete="tel-national"
                          />
                          <label for="a1Phone">Phone number</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="a1Pin"
                            name="a1_pin"
                            value="110001"
                            placeholder=" "
                            inputmode="numeric"
                            maxlength="6"
                            autocomplete="postal-code"
                          />
                          <label for="a1Pin">PIN code</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="a1City"
                            name="a1_city"
                            value="New Delhi"
                            placeholder=" "
                            autocomplete="address-level2"
                          />
                          <label for="a1City">City</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="a1State"
                            name="a1_state"
                            value="Delhi"
                            placeholder=" "
                            list="stateList"
                            autocomplete="address-level1"
                          />
                          <label for="a1State">State</label>
                        </div>
                        <div class="form-group s-5">
                          <input
                            type="text"
                            id="a1House"
                            name="a1_house"
                            value="12"
                            placeholder=" "
                            autocomplete="address-line1"
                          />
                          <label for="a1House">House / Flat no.</label>
                        </div>
                        <div class="form-group s-7">
                          <input
                            type="text"
                            id="a1Street"
                            name="a1_street"
                            value="Park Street, Connaught Place"
                            placeholder=" "
                            autocomplete="address-line2"
                          />
                          <label for="a1Street">Street / Area / Locality</label>
                        </div>
                        <div class="form-group s-12">
                          <input
                            type="text"
                            id="a1Landmark"
                            name="a1_landmark"
                            value="Near Metro Gate 3"
                            placeholder=" "
                          />
                          <label for="a1Landmark">Landmark (optional)</label>
                        </div>
                      </div>

                      <fieldset class="type-group">
                        <legend>Address type</legend>
                        <div class="type-options">
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="a1_type"
                              value="home"
                              checked
                            /><span
                              ><i
                                class="fa-solid fa-house"
                                aria-hidden="true"
                              ></i>
                              Home</span
                            ></label
                          >
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="a1_type"
                              value="work"
                            /><span
                              ><i
                                class="fa-solid fa-briefcase"
                                aria-hidden="true"
                              ></i>
                              Work</span
                            ></label
                          >
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="a1_type"
                              value="other"
                            /><span
                              ><i
                                class="fa-solid fa-location-dot"
                                aria-hidden="true"
                              ></i>
                              Other</span
                            ></label
                          >
                        </div>
                      </fieldset>

                      <label class="check">
                        <input type="checkbox" name="a1_default" checked />
                        <span>Make this my default address</span>
                      </label>

                      <div class="form-actions">
                        <button
                          type="submit"
                          class="btn btn-primary"
                          formaction="/checkout/address/save"
                        >
                          Save address
                        </button>
                        <label for="edit1" class="btn btn-outline-primary"
                          >Cancel</label
                        >
                      </div>
                    </div>
                  </div>

                  <!-- Address 2 -->
                  <div class="addr-card">
                    <input
                      type="radio"
                      name="address"
                      id="addr2"
                      class="addr-radio"
                      value="2"
                    />
                    <label for="addr2" class="addr-body">
                      <span class="radio-dot" aria-hidden="true"></span>
                      <span class="addr-info">
                        <span class="addr-top">
                          <strong>Aarav Mehta</strong>
                          <span class="tag">Work</span>
                        </span>
                        <span class="addr-line"
                          >4th Floor, Tech Park, MG Road, Opp. City Mall</span
                        >
                        <span class="addr-line"
                          >Bengaluru, Karnataka - 560001</span
                        >
                        <span class="addr-phone"
                          ><i class="fa-solid fa-phone" aria-hidden="true"></i>
                          +91 98765 43210</span
                        >
                      </span>
                    </label>

                    <input type="checkbox" id="edit2" class="edit-toggle" />
                    <label for="edit2" class="addr-edit"
                      ><i class="fa-solid fa-pen" aria-hidden="true"></i>
                      Edit</label
                    >

                    <div class="addr-form">
                      <h3>Edit address</h3>
                      <div class="fields">
                        <div class="form-group s-6">
                          <input
                            type="text"
                            id="a2Name"
                            name="a2_name"
                            value="Aarav Mehta"
                            placeholder=" "
                            autocomplete="name"
                          />
                          <label for="a2Name">Full name</label>
                        </div>
                        <div class="form-group has-prefix s-6">
                          <span class="prefix">+91</span>
                          <input
                            type="tel"
                            id="a2Phone"
                            name="a2_phone"
                            value="9876543210"
                            placeholder=" "
                            inputmode="numeric"
                            maxlength="10"
                            autocomplete="tel-national"
                          />
                          <label for="a2Phone">Phone number</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="a2Pin"
                            name="a2_pin"
                            value="560001"
                            placeholder=" "
                            inputmode="numeric"
                            maxlength="6"
                            autocomplete="postal-code"
                          />
                          <label for="a2Pin">PIN code</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="a2City"
                            name="a2_city"
                            value="Bengaluru"
                            placeholder=" "
                            autocomplete="address-level2"
                          />
                          <label for="a2City">City</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="a2State"
                            name="a2_state"
                            value="Karnataka"
                            placeholder=" "
                            list="stateList"
                            autocomplete="address-level1"
                          />
                          <label for="a2State">State</label>
                        </div>
                        <div class="form-group s-5">
                          <input
                            type="text"
                            id="a2House"
                            name="a2_house"
                            value="4th Floor, Tech Park"
                            placeholder=" "
                            autocomplete="address-line1"
                          />
                          <label for="a2House">House / Flat no.</label>
                        </div>
                        <div class="form-group s-7">
                          <input
                            type="text"
                            id="a2Street"
                            name="a2_street"
                            value="MG Road"
                            placeholder=" "
                            autocomplete="address-line2"
                          />
                          <label for="a2Street">Street / Area / Locality</label>
                        </div>
                        <div class="form-group s-12">
                          <input
                            type="text"
                            id="a2Landmark"
                            name="a2_landmark"
                            value="Opp. City Mall"
                            placeholder=" "
                          />
                          <label for="a2Landmark">Landmark (optional)</label>
                        </div>
                      </div>

                      <fieldset class="type-group">
                        <legend>Address type</legend>
                        <div class="type-options">
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="a2_type"
                              value="home"
                            /><span
                              ><i
                                class="fa-solid fa-house"
                                aria-hidden="true"
                              ></i>
                              Home</span
                            ></label
                          >
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="a2_type"
                              value="work"
                              checked
                            /><span
                              ><i
                                class="fa-solid fa-briefcase"
                                aria-hidden="true"
                              ></i>
                              Work</span
                            ></label
                          >
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="a2_type"
                              value="other"
                            /><span
                              ><i
                                class="fa-solid fa-location-dot"
                                aria-hidden="true"
                              ></i>
                              Other</span
                            ></label
                          >
                        </div>
                      </fieldset>

                      <label class="check">
                        <input type="checkbox" name="a2_default" />
                        <span>Make this my default address</span>
                      </label>

                      <div class="form-actions">
                        <button
                          type="submit"
                          class="btn btn-primary"
                          formaction="/checkout/address/save"
                        >
                          Save address
                        </button>
                        <label for="edit2" class="btn btn-outline-primary"
                          >Cancel</label
                        >
                      </div>
                    </div>
                  </div>

                  <!-- Add new -->
                  <div class="addr-card addr-new">
                    <input
                      type="radio"
                      name="address"
                      id="addrNew"
                      class="addr-radio"
                      value="new"
                    />
                    <label for="addrNew" class="addr-body">
                      <span class="radio-dot" aria-hidden="true"></span>
                      <span class="addr-info">
                        <span class="addr-top">
                          <strong
                            ><i class="fa-solid fa-plus" aria-hidden="true"></i>
                            Add a new address</strong
                          >
                        </span>
                      </span>
                    </label>

                    <div class="addr-form">
                      <div class="fields">
                        <div class="form-group s-6">
                          <input
                            type="text"
                            id="nName"
                            name="new_name"
                            placeholder=" "
                            autocomplete="name"
                          />
                          <label for="nName">Full name</label>
                        </div>
                        <div class="form-group has-prefix s-6">
                          <span class="prefix">+91</span>
                          <input
                            type="tel"
                            id="nPhone"
                            name="new_phone"
                            placeholder=" "
                            inputmode="numeric"
                            maxlength="10"
                            autocomplete="tel-national"
                          />
                          <label for="nPhone">Phone number</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="nPin"
                            name="new_pin"
                            placeholder=" "
                            inputmode="numeric"
                            maxlength="6"
                            autocomplete="postal-code"
                          />
                          <label for="nPin">PIN code</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="nCity"
                            name="new_city"
                            placeholder=" "
                            autocomplete="address-level2"
                          />
                          <label for="nCity">City</label>
                        </div>
                        <div class="form-group s-4">
                          <input
                            type="text"
                            id="nState"
                            name="new_state"
                            placeholder=" "
                            list="stateList"
                            autocomplete="address-level1"
                          />
                          <label for="nState">State</label>
                        </div>
                        <div class="form-group s-5">
                          <input
                            type="text"
                            id="nHouse"
                            name="new_house"
                            placeholder=" "
                            autocomplete="address-line1"
                          />
                          <label for="nHouse">House / Flat no.</label>
                        </div>
                        <div class="form-group s-7">
                          <input
                            type="text"
                            id="nStreet"
                            name="new_street"
                            placeholder=" "
                            autocomplete="address-line2"
                          />
                          <label for="nStreet">Street / Area / Locality</label>
                        </div>
                        <div class="form-group s-12">
                          <input
                            type="text"
                            id="nLandmark"
                            name="new_landmark"
                            placeholder=" "
                          />
                          <label for="nLandmark">Landmark (optional)</label>
                        </div>
                      </div>

                      <fieldset class="type-group">
                        <legend>Address type</legend>
                        <div class="type-options">
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="new_type"
                              value="home"
                              checked
                            /><span
                              ><i
                                class="fa-solid fa-house"
                                aria-hidden="true"
                              ></i>
                              Home</span
                            ></label
                          >
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="new_type"
                              value="work"
                            /><span
                              ><i
                                class="fa-solid fa-briefcase"
                                aria-hidden="true"
                              ></i>
                              Work</span
                            ></label
                          >
                          <label class="type-chip"
                            ><input
                              type="radio"
                              name="new_type"
                              value="other"
                            /><span
                              ><i
                                class="fa-solid fa-location-dot"
                                aria-hidden="true"
                              ></i>
                              Other</span
                            ></label
                          >
                        </div>
                      </fieldset>

                      <label class="check">
                        <input type="checkbox" name="new_default" />
                        <span>Save this address for next time</span>
                      </label>

                      <div class="form-actions">
                        <button
                          type="submit"
                          class="btn btn-primary"
                          formaction="/checkout/address/save"
                        >
                          Save &amp; deliver here
                        </button>
                        <label for="addr1" class="btn btn-outline-primary"
                          >Cancel</label
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <!-- 3. Delivery method -->
              <section class="co-block">
                <h2 class="co-title">
                  <span class="num">3</span> Delivery method
                </h2>

                <div
                  class="method-list"
                  role="radiogroup"
                  aria-label="Choose a delivery method"
                >
                  <label class="method">
                    <input
                      type="radio"
                      name="delivery"
                      value="standard"
                      checked
                    />
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

            <!-- Summary -->
            <aside class="co-summary" aria-label="Order summary">
              <div class="box price-box">
                <div class="box-head">
                  <h5>Order Summary <span>(3 items)</span></h5>
                  <a href="cart.html">Edit bag</a>
                </div>

                <ul class="mini-list">
                  <li>
                    <span class="mini-img">
                      <img
                        src="assets/images/home/tab1.png"
                        alt=""
                        width="56"
                        height="75"
                        loading="lazy"
                      />
                      <b>1</b>
                    </span>
                    <span class="mini-text">
                      <strong>Zari Woven Banarasi Silk Saree</strong>
                      <small>Wine · Stitched Blouse M</small>
                    </span>
                    <span class="mini-price">₹9,248</span>
                  </li>
                  <li>
                    <span class="mini-img">
                      <img
                        src="assets/images/home/tab2.png"
                        alt=""
                        width="56"
                        height="75"
                        loading="lazy"
                      />
                      <b>1</b>
                    </span>
                    <span class="mini-text">
                      <strong>Organza Embroidered Party Saree</strong>
                      <small>Pink · Unstitched Blouse</small>
                    </span>
                    <span class="mini-price">₹6,299</span>
                  </li>
                  <li>
                    <span class="mini-img">
                      <img
                        src="assets/images/home/tab4.png"
                        alt=""
                        width="56"
                        height="75"
                        loading="lazy"
                      />
                      <b>1</b>
                    </span>
                    <span class="mini-text">
                      <strong>Georgette Printed Saree</strong>
                      <small>Green · Unstitched Blouse</small>
                    </span>
                    <span class="mini-price">₹4,799</span>
                  </li>
                </ul>

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

                <a href="payment.html" class="btn btn-primary place-btn">
                  Continue to Payment
                  <i
                    class="fa-solid fa-arrow-right-long"
                    aria-hidden="true"
                  ></i>
                </a>
                <p class="terms-note">
                  By continuing, you agree to our <a href="/terms">Terms</a> and
                  <a href="/privacy">Privacy Policy</a>.
                </p>
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

              <a href="javascript:void(0)" class="co-help">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                <span
                  >Need help with your order?
                  <b>Chat with our stylists</b></span
                >
              </a>
            </aside>

            <datalist id="stateList">
              <option value="Andhra Pradesh"></option>
              <option value="Delhi"></option>
              <option value="Gujarat"></option>
              <option value="Haryana"></option>
              <option value="Karnataka"></option>
              <option value="Kerala"></option>
              <option value="Maharashtra"></option>
              <option value="Punjab"></option>
              <option value="Rajasthan"></option>
              <option value="Tamil Nadu"></option>
              <option value="Telangana"></option>
              <option value="Uttar Pradesh"></option>
              <option value="West Bengal"></option>
            </datalist>
          </form>

          <div class="co-bar">
            <div class="bar-total">
              <span>Total</span>
              <strong>₹18,386</strong>
            </div>
            <a href="payment.html" class="btn btn-primary">
              Continue to Payment
              <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </section>
    </main>

@endsection