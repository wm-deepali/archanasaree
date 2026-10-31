@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/other/other.css') }}" />
@endpush

@section('content')

  @php
    // ₹6,299 or ₹6,299.50 (paise only when there are any)
    $money = fn($v) => '₹' . number_format((float) $v, fmod((float) $v, 1) == 0 ? 0 : 2);

    $isCod = $order->payment_method === 'cod';
    $isPaid = $order->payment_status === 'paid';

    $paymentLabel = $isCod
      ? 'Cash on Delivery'
      : ($isPaid ? 'Paid Online' : 'Payment ' . ucfirst($order->payment_status));

    $totalLabel = $isPaid ? 'Total Paid' : 'Total Payable';

    // Only link to the account area if that route exists in this project
    $dashUrl = Route::has('user.dashboard.index') ? route('user.dashboard.index') : null;
  @endphp

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
            Your order is placed successfully.
            @if ($order->customer_email)
              A confirmation has been sent to {{ $order->customer_email }}.
            @endif
          </p>

          <ul class="order-meta">
            <li><span>Order ID</span><strong>#{{ $order->order_number }}</strong></li>
            <li><span>Date</span><strong>{{ $order->created_at->format('d M Y') }}</strong></li>
            <li><span>Payment</span><strong>{{ $paymentLabel }}</strong></li>
          </ul>

          <div class="order-summary">
            <ul class="order-items">
              @foreach ($order->items as $item)
                @php
                  $variant = collect($item->selected_attributes ?? [])
                    ->map(fn($v) => is_array($v) ? ($v['value'] ?? $v['label'] ?? null) : $v)
                    ->values()
                    ->merge($item->addons->pluck('detail'))
                    ->filter()
                    ->push('Qty ' . $item->quantity)
                    ->implode(' · ');
                @endphp
                <li>
                  <img class="thumb" src="{{ $item->display_image }}" alt="{{ $item->product_name }}" width="52" height="69"
                    loading="lazy" />
                  <div class="info">
                    <h4>{{ $item->product_name }}</h4>
                    <p>{{ $variant }}</p>
                  </div>
                  <span class="price">{{ $money($item->total) }}</span>
                </li>
              @endforeach
            </ul>

            <ul class="order-totals">
              <li>
                <span>Subtotal</span>
                <strong>{{ $money($order->subtotal) }}</strong>
              </li>

              @if ($order->discount > 0)
                <li>
                  <span>Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</span>
                  <strong class="is-green">−{{ $money($order->discount) }}</strong>
                </li>
              @endif

              @if ($order->tax_amount > 0)
                <li>
                  <span>GST</span>
                  <strong>{{ $money($order->tax_amount) }}</strong>
                </li>
              @endif

              @if ($order->shipping_charge > 0)
                <li>
                  <span>Shipping</span>
                  <strong>{{ $money($order->shipping_charge) }}</strong>
                </li>
              @endif

              <li class="grand">
                <span>{{ $totalLabel }}</span>
                <strong>{{ $money($order->grand_total) }}</strong>
              </li>
            </ul>
          </div>

          <div class="btn-grp">
            @if ($dashUrl)
              <a href="{{ $dashUrl }}" id="trackBtn" class="btn btn-primary">
                <i class="fa-solid fa-box" aria-hidden="true"></i> Track My Order
              </a>
            @endif
            <a href="{{ route('products') }}" id="shopBtn" class="btn btn-outline-primary">
              <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Shop Again
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection

@if (!empty($purchaseScript))
  @push('scripts')
    {!! $purchaseScript !!}
  @endpush
@endif