@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sass/other/other.css') }}" />
@endpush

@section('content')
    @php
        $order = [
            'id' => '#ASE-20481', 'date' => '28 Oct 2026', 'payment' => 'Paid Online', 'delivery' => 'Mon, 2 Nov',
            'subtotal' => '₹11,098', 'coupon' => '−₹1,960', 'total' => '₹9,138',
        ];
        $items = [
            ['img' => 'tab2.png', 'name' => 'Organza Embroidered Party Saree', 'variant' => 'Pink · Qty 1', 'price' => '₹6,299'],
            ['img' => 'tab4.png', 'name' => 'Georgette Printed Saree', 'variant' => 'Green · Qty 1', 'price' => '₹4,799'],
        ];
    @endphp

    <section class="comman-banner order-success">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">
                    <svg viewBox="0 0 52 52" aria-hidden="true">
                        <circle class="ring" cx="26" cy="26" r="24" fill="none" />
                        <path class="tick" fill="none" d="M15 27l7.5 7.5L37 19" />
                    </svg>
                    @for ($i = 1; $i <= 6; $i++)<i class="dot d{{ $i }}"></i>@endfor
                </div>

                <span class="status">Order Confirmed</span>
                <h1>Thank You for Your Order!</h1>
                <p class="msg">Your order is placed successfully. A confirmation has been sent to your email.</p>

                <ul class="order-meta">
                    <li><span>Order ID</span><strong>{{ $order['id'] }}</strong></li>
                    <li><span>Date</span><strong>{{ $order['date'] }}</strong></li>
                    <li><span>Payment</span><strong>{{ $order['payment'] }}</strong></li>
                    <li><span>Delivery by</span><strong>{{ $order['delivery'] }}</strong></li>
                </ul>

                <div class="order-summary">
                    <ul class="order-items">
                        @foreach ($items as $item)
                            <li>
                                <img class="thumb" src="{{ asset('assets/images/home/' . $item['img']) }}" alt="{{ $item['name'] }}" width="52" height="69" loading="lazy" />
                                <div class="info">
                                    <h4>{{ $item['name'] }}</h4>
                                    <p>{{ $item['variant'] }}</p>
                                </div>
                                <span class="price">{{ $item['price'] }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <ul class="order-totals">
                        <li><span>Subtotal</span><strong>{{ $order['subtotal'] }}</strong></li>
                        <li><span>Coupon (ARCHANA10)</span><strong class="is-green">{{ $order['coupon'] }}</strong></li>
                        <li class="grand"><span>Total Paid</span><strong>{{ $order['total'] }}</strong></li>
                    </ul>
                </div>

                <div class="btn-grp">
                    <a href="dashboard.html" id="trackBtn" class="btn btn-primary">
                        <i class="fa-solid fa-box" aria-hidden="true"></i> Track My Order
                    </a>
                    <a href="{{ route('products') }}" id="shopBtn" class="btn btn-outline-primary">
                        <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Shop Again
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection