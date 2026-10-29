@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/other/other.css') }}" />
@endpush

@section('content')

    <main>
      <section class="comman-banner order-success">
        <div class="container">
          <div class="success-card">
            <div class="success-icon">
              <svg viewBox="0 0 52 52" aria-hidden="true">
                <circle class="ring" cx="26" cy="26" r="24" fill="none" />
                <path class="tick" fill="none" d="M15 27l7.5 7.5L37 19" />
              </svg>
              <i class="dot d1"></i><i class="dot d2"></i><i class="dot d3"></i>
              <i class="dot d4"></i><i class="dot d5"></i><i class="dot d6"></i>
            </div>

            <span class="status">Order Confirmed</span>
            <h1>Thank You for Your Order!</h1>
            <p class="msg">
              Your order is placed successfully. A confirmation has been sent to
              your email.
            </p>

            <ul class="order-meta">
              <li><span>Order ID</span><strong>#ASE-20481</strong></li>
              <li><span>Date</span><strong>28 Oct 2026</strong></li>
              <li><span>Payment</span><strong>Paid Online</strong></li>
              <li><span>Delivery by</span><strong>Mon, 2 Nov</strong></li>
            </ul>

            <div class="order-summary">
              <ul class="order-items">
                <li>
                  <img
                    class="thumb"
                    src="assets/images/home/tab2.png"
                    alt="Organza Embroidered Party Saree"
                    width="52"
                    height="69"
                    loading="lazy"
                  />
                  <div class="info">
                    <h4>Organza Embroidered Party Saree</h4>
                    <p>Pink · Qty 1</p>
                  </div>
                  <span class="price">₹6,299</span>
                </li>

                <li>
                  <img
                    class="thumb"
                    src="assets/images/home/tab4.png"
                    alt="Georgette Printed Saree"
                    width="52"
                    height="69"
                    loading="lazy"
                  />
                  <div class="info">
                    <h4>Georgette Printed Saree</h4>
                    <p>Green · Qty 1</p>
                  </div>
                  <span class="price">₹4,799</span>
                </li>
              </ul>

              <ul class="order-totals">
                <li>
                  <span>Subtotal</span>
                  <strong>₹11,098</strong>
                </li>
                <li>
                  <span>Coupon (ARCHANA10)</span>
                  <strong class="is-green">−₹1,960</strong>
                </li>
                <li class="grand">
                  <span>Total Paid</span>
                  <strong>₹9,138</strong>
                </li>
              </ul>
            </div>

            <div class="btn-grp">
              <a href="dashboard.html" id="trackBtn" class="btn btn-primary">
                <i class="fa-solid fa-box" aria-hidden="true"></i> Track My
                Order
              </a>
              <a
                href="product-listing.html"
                id="shopBtn"
                class="btn btn-outline-primary"
              >
                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Shop
                Again
              </a>
            </div>
          </div>
        </div>
      </section>
    </main>
    
@endsection