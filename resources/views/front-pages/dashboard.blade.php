@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/sass/dashboard/dashboard.css') }}" />
@endpush

@section('content')

  <main>
    <section class="dash-secA">
      <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <a href="index.html">Home</a>
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
          <span class="current">My Account</span>
        </nav>

        <div class="dash-layout">
          <!-- ===== User card ===== -->
@php
  $cardPhoto = $customer->avatar
      ? (str_starts_with($customer->avatar, 'http') ? $customer->avatar : asset('storage/' . $customer->avatar))
      : null;
@endphp
<div class="user-card">
  <span class="avatar">
    @if($cardPhoto)
      <img src="{{ $cardPhoto }}" alt="{{ $customer->name }}" />
    @else
      {{ strtoupper(mb_substr(trim($customer->name), 0, 1)) }}
    @endif
  </span>
  <div class="meta">
    <h4>{{ $customer->name }}</h4>
    <p>{{ $customer->email }}</p>
  </div>
</div>

          <!-- ===== Tab nav ===== -->
          <ul class="tab-nav">
            <li data-tab="1" class="active">
              <i class="fa-solid fa-table-columns" aria-hidden="true"></i>
              Dashboard
            </li>
            <li data-tab="2">
              <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
              Track Order
            </li>
            <li data-tab="3">
              <i class="fa-solid fa-box-open" aria-hidden="true"></i>
              My Orders
              <span class="count">{{ $orders->total() }}</span>
            </li>
            <li data-tab="4">
              <i class="fa-regular fa-heart" aria-hidden="true"></i>
              My Wishlist
              <span class="count">{{ $wishlist->count() }}</span>
            </li>
            <li data-tab="5">
              <i class="fa-regular fa-user" aria-hidden="true"></i>
              My Profile
            </li>
          </ul>

          <!-- ===== Tab content ===== -->
          <div class="tab-nav-content">

           <!-- ========== TAB 1: DASHBOARD ========== -->
<div class="tabs active" data-tab="1">
  <div class="welcome">
    <div class="welcome-text">
      <h2>Welcome back, {{ \Illuminate\Support\Str::before(trim($customer->name), ' ') }}!</h2>
      <p>
        Track your orders, manage your wishlist and keep your
        details up to date.
      </p>
    </div>
    <a href="{{ url('/products') }}" class="btn btn-white">
      Continue Shopping
      <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
    </a>
  </div>

  <div class="stat-grid">
    <div class="stat-card">
      <span class="stat-icon"><i class="fa-solid fa-box-open" aria-hidden="true"></i></span>
      <div><strong>{{ $stats['total'] }}</strong><span>Total Orders</span></div>
    </div>
    <div class="stat-card">
      <span class="stat-icon"><i class="fa-solid fa-truck-fast" aria-hidden="true"></i></span>
      <div><strong>{{ $stats['active'] }}</strong><span>Active Deliveries</span></div>
    </div>
    <div class="stat-card">
      <span class="stat-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>
      <div><strong>{{ $stats['delivered'] }}</strong><span>Delivered</span></div>
    </div>
    <div class="stat-card">
      <span class="stat-icon"><i class="fa-solid fa-rotate-left" aria-hidden="true"></i></span>
      <div><strong>{{ $stats['closed'] }}</strong><span>Cancelled / Returned</span></div>
    </div>
  </div>

  <div class="dash-panel">
    <div class="panel-head">
      <h3>
        <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
        Recent Orders
      </h3>
      @if($stats['total'] > 0)
        <a href="javascript:void(0);" class="panel-link go-tab" data-go="3">
          View all orders
          <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
        </a>
      @endif
    </div>

    @if($recentOrders->isNotEmpty())
      <div class="recent-list">
        @foreach($recentOrders as $ro)
          @php
            [$roLabel, $roClass] = $statusMeta[$ro->status] ?? [ucfirst($ro->status), 'processing'];
            $first  = $ro->items->first();
            $extra  = $ro->items->count() - 1;
            $isLive = in_array($ro->status, ['new', 'pending', 'processing', 'shipped', 'ndr']);
          @endphp
          <div class="recent-item">
            <span class="thumb">
              @if($first && $first->display_image)
                <img src="{{ $first->display_image }}" alt="{{ $first->product_name }}" loading="lazy" />
              @endif
            </span>
            <div class="info">
              <h4>
                {{ $first->product_name ?? 'Order' }}
                @if($extra > 0)+ {{ $extra }} more {{ \Illuminate\Support\Str::plural('item', $extra) }}@endif
              </h4>
              <p>Order #{{ $ro->order_number }} · {{ $ro->created_at->format('d M Y') }}</p>
            </div>
            <strong class="amount">₹{{ number_format($ro->grand_total) }}</strong>
            <span class="status {{ $roClass }}">{{ $roLabel }}</span>
            @if($isLive)
              <a href="{{ url()->current() }}?track={{ $ro->order_number }}#tab-2"
                class="btn btn-outline-primary btn-sm">Track</a>
            @else
              <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm go-tab" data-go="3">View</a>
            @endif
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
        <h4>No orders yet</h4>
        <p>When you place an order it will show up here.</p>
        <a href="{{ url('/all-products') }}" class="btn btn-primary">Start Shopping</a>
      </div>
    @endif
  </div>
</div>

            <!-- ========== TAB 2: TRACK ORDER ========== -->
            <div class="tabs" data-tab="2">
              <div class="dash-panel">
                <div class="panel-head">
                  <h3>
                    <i class="fa-solid fa-magnifying-glass-location" aria-hidden="true"></i>
                    Track Your Order
                  </h3>
                </div>

                <form class="form track-form" action="{{ url()->current() }}#tab-2" method="get">
                  <div class="form-group">
                    <input type="text" id="tr-id" name="track" value="{{ request('track') }}" placeholder=" " required />
                    <label for="tr-id">Order ID (e.g. ORD-65F2A1B3C4D5E)</label>
                    @if($trackError)
                      <span class="error" style="display:block">{{ $trackError }}</span>
                    @else
                      <span class="error"></span>
                    @endif
                  </div>
                  <div class="form-group">
                    <input type="tel" id="tr-phone" name="phone" value="{{ request('phone') }}" placeholder=" " />
                    <label for="tr-phone">Mobile number (optional)</label>
                    <span class="error"></span>
                  </div>
                  <button type="submit" class="btn btn-primary">Track Order</button>
                </form>
              </div>

              @if($trackOrder)
                @php
                  $t = $trackOrder;
                  [$tLabel, $tClass] = $statusMeta[$t->status] ?? [ucfirst($t->status), 'processing'];
                  $tHistory = $t->statusHistory->sortBy('created_at')->values();

                  // ── horizontal steps ──
                  $steps = [
                    ['title' => 'Order Placed', 'icon' => 'fa-receipt', 'match' => ['new', 'pending']],
                    ['title' => 'Processing', 'icon' => 'fa-circle-check', 'match' => ['processing']],
                    ['title' => 'Shipped', 'icon' => 'fa-truck-fast', 'match' => ['shipped', 'ndr']],
                    ['title' => 'Delivered', 'icon' => 'fa-house', 'match' => ['delivered']],
                  ];

                  // furthest step reached (cancelled / rto don't advance it)
                  $reached = 0;
                  foreach ($steps as $si => $s) {
                    if ($tHistory->contains(fn($h) => in_array($h->status, $s['match']))) {
                      $reached = $si;
                    }
                  }
                  $isDelivered = $t->status === 'delivered';
                  $isStopped = in_array($t->status, ['cancelled', 'rto']);

                  $stepTime = function ($si) use ($steps, $tHistory, $t) {
                    $h = $tHistory->first(fn($x) => in_array($x->status, $steps[$si]['match']));
                    if ($h)
                      return $h->created_at->format('d M, h:i A');
                    return $si === 0 ? $t->created_at->format('d M, h:i A') : null;
                  };

                  $deliveredAt = optional($tHistory->firstWhere('status', 'delivered'))->created_at;
                  $logs = $tHistory->reverse()->values(); // latest first
                @endphp

                <div class="dash-panel shipment">
                  <div class="ship-top">
                    <div>
                      <h4>Order #{{ $t->order_number }}</h4>
                      <p>
                        Placed on {{ $t->created_at->format('d M Y') }}
                        · {{ $t->items->count() }} {{ Str::plural('item', $t->items->count()) }}
                        · ₹{{ number_format($t->grand_total) }}
                      </p>
                    </div>
                    <span class="status {{ $tClass }}">{{ $tLabel }}</span>
                  </div>

                  <div class="ship-meta">
                    @if($deliveredAt)
                      <div><small>Delivered On</small><strong>{{ $deliveredAt->format('d M Y') }}</strong></div>
                    @endif
                    <div>
                      <small>Courier Partner</small>
                      <strong>{{ $t->courier?->name ?? 'To be assigned' }}</strong>
                    </div>
                    <div>
                      <small>Tracking ID (AWB)</small>
                      <strong>{{ $t->tracking_number ?: '—' }}</strong>
                    </div>
                    <div>
                      <small>Payment</small>
                      <strong>
                        {{ ucfirst(str_replace('_', ' ', $t->payment_method ?? '—')) }}
                        ({{ ucfirst($t->payment_status) }})
                      </strong>
                    </div>
                    @if($t->courier?->website_url && $t->tracking_number)
                      <div>
                        <small>Live Tracking</small>
                        <strong><a href="{{ $t->courier->website_url }}" target="_blank" rel="noopener">Open courier
                            site</a></strong>
                      </div>
                    @endif
                  </div>

                  <ul class="track-steps">
                    @foreach($steps as $si => $s)
                      @php
                        if ($isDelivered)
                          $cls = 'done';
                        elseif ($si < $reached)
                          $cls = 'done';
                        elseif ($si === $reached)
                          $cls = $isStopped ? 'done' : 'current';
                        else
                          $cls = '';
                      @endphp
                      <li class="{{ $cls }}">
                        <span class="dot"><i class="fa-solid {{ $s['icon'] }}" aria-hidden="true"></i></span>
                        <h5>{{ $s['title'] }}</h5>
                        <span class="time">{{ $stepTime($si) ?? 'Pending' }}</span>
                      </li>
                    @endforeach

                    @if($isStopped)
                      <li class="cancel">
                        <span class="dot"><i class="fa-solid fa-xmark" aria-hidden="true"></i></span>
                        <h5>{{ $statusMeta[$t->status][0] }}</h5>
                        <span
                          class="time">{{ optional($tHistory->firstWhere('status', $t->status))->created_at?->format('d M, h:i A') }}</span>
                      </li>
                    @endif
                  </ul>

                  <div class="ship-log">
                    <h5 class="od-title">Delivery Updates</h5>
                    <ul class="timeline">
                      @foreach($logs as $i => $h)
                        @php
                          $isCancel = in_array($h->status, ['cancelled', 'ndr', 'rto']);
                          $isCurrent = $i === 0 && !$isDelivered && !$isStopped && !$isCancel;
                          $liClass = $isCancel ? 'cancel' : ($isCurrent ? 'current' : 'done');
                        @endphp
                        <li class="{{ $liClass }}">
                          <span class="dot">
                            @if($isCancel)<i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            @elseif(!$isCurrent)<i class="fa-solid fa-check" aria-hidden="true"></i>@endif
                          </span>
                          <h5>{{ $statusMeta[$h->status][0] ?? ucfirst($h->status) }}</h5>
                          @if($h->remarks)
                          <p>{{ $h->remarks }}</p>@endif
                          <span class="time">{{ $h->created_at->format('d M Y, h:i A') }}</span>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              @elseif(!$trackError)
                <div class="dash-panel">
                  <div class="empty-state">
                    <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
                    <h4>No orders to track</h4>
                    <p>Once you place an order you can follow it here.</p>
                    <a href="{{ url('/categories') }}" class="btn btn-primary">Start Shopping</a>
                  </div>
                </div>
              @endif
            </div>
            

                         <!-- ========== TAB 3: MY ORDERS ========== -->
<div class="tabs" data-tab="3">
  <div class="dash-panel">
    <div class="panel-head">
      <h3><i class="fa-solid fa-box-open" aria-hidden="true"></i> My Orders</h3>
    </div>

    <form class="form orders-bar" action="#" method="get">
      <div class="form-group has-icon search-icon">
        <input type="text" id="od-search" name="q" placeholder=" " />
        <label for="od-search">Search by order ID or product</label>
      </div>
    </form>

    @forelse($orders as $order)
      @php
        [$statusLabel, $statusClass] = $statusMeta[$order->status] ?? [ucfirst($order->status), 'processing'];
        $history    = $order->statusHistory->sortBy('created_at')->values();
        $lastIdx    = $history->count() - 1;
        $closed     = in_array($order->status, ['delivered', 'cancelled', 'rto']);
        $paidOnline = in_array($order->payment_status, ['paid', 'refunded']);

        // ── price breakdown (same rows as the cart) ──
        $itemsSubtotal = $order->items->sum(fn ($i) => $i->price * $i->quantity);

        $addonRows = $order->items
            ->flatMap(fn ($i) => $i->addons->map(fn ($a) => ['label' => $a->detail, 'amount' => $a->price * $i->quantity]))
            ->groupBy('label')
            ->map(fn ($g) => $g->sum('amount'))
            ->filter(fn ($amt) => $amt > 0);

        $dyeTotal = $order->items->sum(fn ($i) => $i->dye_charge * $i->quantity);

        // billing address is shown only when it differs from shipping
        $billingDiffers = $order->billing_name && (
            $order->billing_address_line_1 !== $order->address_line_1
            || $order->billing_pincode !== $order->pincode
            || $order->billing_name !== $order->customer_name
        );
      @endphp

      <div class="order-card">
        {{-- ── Head ── --}}
        <div class="order-head">
          <div class="oh-id">
            <strong>#{{ $order->order_number }}</strong>
            <span>Placed on {{ $order->created_at->format('d M Y') }}</span>
          </div>
          <div class="oh-total">
            <small>Total</small><b>₹{{ number_format($order->grand_total) }}</b>
          </div>
          <div class="oh-status">
            <span class="status {{ $statusClass }}">{{ $statusLabel }}</span>
          </div>
          <button type="button" class="order-toggle" aria-label="Show order details">
            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
          </button>
        </div>

        <div class="order-detail">
          <div class="od-grid">

            {{-- ── LEFT: items + price ── --}}
            <div>
              <h5 class="od-title">Items in this order</h5>
              <div class="od-items">
                @foreach($order->items as $item)
                  @php
                    $variantLabel = null;
                    if (!empty($item->selected_attributes)) {
                        $variantLabel = collect($item->selected_attributes)->map(function ($value, $key) {
                            if (is_array($value)) {
                                $n = $value['attribute'] ?? $value['name'] ?? $key;
                                $v = $value['value'] ?? $value['label'] ?? reset($value);
                                return $n . ': ' . $v;
                            }
                            return $key . ': ' . $value;
                        })->join(' · ');
                    }

                    $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);
                  @endphp
                  <div class="od-item">
                    <span class="thumb">
                      @if($item->display_image)
                        <img src="{{ $item->display_image }}" alt="{{ $item->product_name }}" loading="lazy" />
                      @endif
                    </span>
                    <div class="od-name">
                      <h4>{{ $item->product_name ?? ($item->product->name ?? 'Product') }}</h4>
                      <p>
                        @if($variantLabel){{ $variantLabel }} · @endif
                        Qty {{ $item->quantity }}
                      </p>
                      @if($sku)<p>SKU: {{ $sku }}</p>@endif
                      @foreach($item->addons as $addon)
                        <p>+ {{ $addon->detail }} (₹{{ number_format($addon->price) }})</p>
                      @endforeach
                      @if($item->custom_colour_code)
                        <p>Dyed to: {{ $item->custom_colour_code }}
                          @if($item->dye_charge > 0)(+₹{{ number_format($item->dye_charge) }}/pc)@endif
                        </p>
                      @endif
                    </div>
                    <strong>₹{{ number_format($item->total) }}</strong>
                  </div>
                @endforeach
              </div>

              <h5 class="od-title">Price details</h5>
              <div class="od-summary">
                <p><span>Items subtotal</span><span>₹{{ number_format($itemsSubtotal, 2) }}</span></p>

                @foreach($addonRows as $label => $amount)
                  <p><span>{{ $label }}</span><span>+ ₹{{ number_format($amount, 2) }}</span></p>
                @endforeach

                @if($dyeTotal > 0)
                  <p><span>Colour customization</span><span>+ ₹{{ number_format($dyeTotal, 2) }}</span></p>
                @endif

                @if($order->discount > 0)
                  <p>
                    <span>Coupon{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</span>
                    <span class="green">− ₹{{ number_format($order->discount, 2) }}</span>
                  </p>
                @endif

                @if($order->tax_amount > 0)
                  @if($order->gst_type === 'igst' && $order->igst_amount > 0)
                    <p><span>IGST ({{ $order->igst_rate }}%)</span><span>+ ₹{{ number_format($order->igst_amount, 2) }}</span></p>
                  @else
                    @if($order->cgst_amount > 0)
                      <p><span>CGST ({{ $order->cgst_rate }}%)</span><span>+ ₹{{ number_format($order->cgst_amount, 2) }}</span></p>
                    @endif
                    @if($order->sgst_amount > 0)
                      <p><span>SGST ({{ $order->sgst_rate }}%)</span><span>+ ₹{{ number_format($order->sgst_amount, 2) }}</span></p>
                    @endif
                  @endif
                @endif

                <p>
                  <span>Shipping</span>
                  @if($order->shipping_charge > 0)
                    <span>+ ₹{{ number_format($order->shipping_charge, 2) }}</span>
                  @else
                    <span class="green">Free</span>
                  @endif
                </p>

                <p class="total">
                  <span>{{ $order->payment_status === 'paid' ? 'Total paid' : 'Total' }}</span>
                  <span>₹{{ number_format($order->grand_total, 2) }}</span>
                </p>

                @if($order->status === 'cancelled' && $paidOnline)
                  <p><span>Refund to</span><span>Original payment method</span></p>
                  <p>
                    <span>Refund status</span>
                    <span class="green">{{ $order->payment_status === 'refunded' ? 'Refunded' : 'Refund initiated' }}</span>
                  </p>
                @endif
              </div>
            </div>

            {{-- ── RIGHT: timeline ── --}}
            <div>
              <h5 class="od-title">Order progress</h5>
              <ul class="timeline">
                @foreach($history as $i => $h)
                  @php
                    $isCancel  = in_array($h->status, ['cancelled', 'ndr', 'rto']);
                    $isCurrent = ($i === $lastIdx) && !$closed && !$isCancel;
                    $liClass   = $isCancel ? 'cancel' : ($isCurrent ? 'current' : 'done');
                  @endphp
                  <li class="{{ $liClass }}">
                    <span class="dot">
                      @if($isCancel)<i class="fa-solid fa-xmark" aria-hidden="true"></i>
                      @elseif(!$isCurrent)<i class="fa-solid fa-check" aria-hidden="true"></i>@endif
                    </span>
                    <h5>{{ $statusMeta[$h->status][0] ?? ucfirst($h->status) }}</h5>
                    @if($h->remarks)<p>{{ $h->remarks }}</p>@endif
                    <span class="time">{{ $h->created_at->format('d M, h:i A') }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          {{-- ── Info boxes ── --}}
          <div class="od-info">
            <div class="od-box">
              <h5 class="od-title">Delivery address</h5>
              <p>
                <b>{{ $order->customer_name }}</b><br />
                {{ $order->address_line_1 }}@if($order->address_line_2), {{ $order->address_line_2 }}@endif<br />
                {{ $order->city?->name }}, {{ $order->state?->name }} - {{ $order->pincode }}
                @if($order->customer_phone)<br />Mobile: {{ $order->customer_phone }}@endif
              </p>
            </div>

            @if($billingDiffers)
              <div class="od-box">
                <h5 class="od-title">Billing address</h5>
                <p>
                  <b>{{ $order->billing_name }}</b><br />
                  {{ $order->billing_address_line_1 }}@if($order->billing_address_line_2), {{ $order->billing_address_line_2 }}@endif<br />
                  {{ $order->billingCity?->name }}, {{ $order->billingState?->name }} - {{ $order->billing_pincode }}
                </p>
              </div>
            @endif

            <div class="od-box">
              <h5 class="od-title">Payment</h5>
              <p>
                <b>{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? '—')) }}</b>
                ({{ ucfirst($order->payment_status) }})
                @if($order->transaction_id)<br />Transaction ID: {{ $order->transaction_id }}@endif
                <br />Amount: ₹{{ number_format($order->grand_total, 2) }}
              </p>
            </div>

            @if($order->courier || $order->tracking_number)
              <div class="od-box">
                <h5 class="od-title">Shipment</h5>
                <p>
                  @if($order->courier)<b>{{ $order->courier->name }}</b><br />@endif
                  @if($order->tracking_number)AWB: {{ $order->tracking_number }}@endif
                </p>
              </div>
            @endif
          </div>

          {{-- ── Actions ── --}}
          <div class="od-actions">
           @if(!in_array($order->status, ['cancelled', 'rto']))
  <a href="{{ url()->current() }}?track={{ $order->order_number }}#tab-2" class="btn btn-primary btn-sm">
    <i class="fa-solid fa-truck-fast" aria-hidden="true"></i> Track Order</a>
@endif

            @if($order->status === 'delivered')
              <a href="returns-exchange.html" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i> Return / Exchange</a>
            @endif

            @if($order->invoice)
              <a href="{{ route('account.orders.invoice', $order) }}" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-file-invoice" aria-hidden="true"></i> Download Invoice</a>
            @endif

            <a href="contact.html" class="btn btn-outline-primary btn-sm">
              <i class="fa-solid fa-headset" aria-hidden="true"></i> Need Help?</a>
          </div>
        </div>
      </div>
    @empty
      <div class="empty-state">
        <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
        <h4>No orders yet</h4>
        <p>When you place an order it will show up here.</p>
        <a href="{{ url('/categories') }}" class="btn btn-primary">Start Shopping</a>
      </div>
    @endforelse

    @if($orders->hasPages())
      <div class="orders-pager">{{ $orders->fragment('tab-3')->links() }}</div>
    @endif
  </div>
</div>


        <!-- ========== TAB 4: WISHLIST ========== -->
<div class="tabs" data-tab="4">
  <div class="dash-panel">
    <div class="panel-head">
      <h3>
        <i class="fa-regular fa-heart" aria-hidden="true"></i>
        My Wishlist
        <span class="muted wish-count">({{ $wishlist->count() }} {{ \Illuminate\Support\Str::plural('item', $wishlist->count()) }})</span>
      </h3>
    </div>

    <div class="wish-grid" @if($wishlist->isEmpty()) style="display:none" @endif>
      @foreach($wishlist as $w)
        @php
          $p      = $w->product;
          $unit   = (float) $p->price;
          $mrp    = (float) ($p->mrp ?: $unit);
          $off    = $mrp > $unit ? (int) round((($mrp - $unit) / $mrp) * 100) : 0;
          $inStock = (int) $p->stock > 0;
          $url    = route('products.show', $p->slug);
        @endphp

        <article class="wish-card {{ $inStock ? '' : 'out' }}">
          <button type="button" class="wish-remove" data-id="{{ $p->id }}" aria-label="Remove from wishlist">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
          </button>

          <a href="{{ $url }}" class="wish-image">
            <img src="{{ $p->display_image }}" alt="{{ $p->name }}" loading="lazy" />
            @if($off > 0)<span class="badge">-{{ $off }}%</span>@endif
          </a>

          <div class="wish-info">
            <span class="cat">{{ $p->subcategory->name ?? ($p->category->name ?? '') }}</span>
            <h4><a href="{{ $url }}">{{ $p->name }}</a></h4>

            <div class="wish-price">
              <strong>₹{{ number_format($unit) }}</strong>
              @if($off > 0)
                <del>₹{{ number_format($mrp) }}</del>
                <span class="save">Save ₹{{ number_format($mrp - $unit) }}</span>
              @endif
            </div>

            @if($inStock)
              <span class="stock in"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> In Stock</span>
            @else
              <span class="stock"><i class="fa-solid fa-circle-xmark" aria-hidden="true"></i> Out of Stock</span>
            @endif

            <div class="wish-cta">
              @if($inStock)
                <a href="{{ $url }}" class="btn btn-primary btn-sm">
                  <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Choose Options
                </a>
              @else
                <button type="button" class="btn btn-primary btn-sm" disabled>
                  <i class="fa-regular fa-bell" aria-hidden="true"></i> Notify Me
                </button>
              @endif
              <a href="{{ $url }}" class="btn btn-outline-primary btn-sm">View</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <!-- Empty state (shown when the list is empty, or by JS after the last item is removed) -->
    <div class="empty-state wish-empty" @if($wishlist->isEmpty()) style="display:block" @endif>
      <i class="fa-regular fa-heart" aria-hidden="true"></i>
      <h4>Your wishlist is empty</h4>
      <p>Save sarees and lehengas you love and find them here.</p>
      <a href="{{ url('/products') }}" class="btn btn-primary">Explore Collection</a>
    </div>
  </div>
</div>
            <!-- ========== TAB 5: MY PROFILE ========== -->
<div class="tabs" data-tab="5">
 @php
  $initial   = strtoupper(mb_substr(trim($customer->name), 0, 1));
  $photoUrl  = $customer->avatar
      ? (str_starts_with($customer->avatar, 'http') ? $customer->avatar : asset('storage/' . $customer->avatar))
      : null;
  $phoneFmt  = $customer->mobile ? '+91 ' . substr($customer->mobile, 0, 5) . ' ' . substr($customer->mobile, 5) : '—';
  $typeLabels = ['home' => 'Home', 'office' => 'Work', 'other' => 'Other'];
@endphp

  <!-- Personal details -->
  <div class="dash-panel">
    <div class="panel-head">
      <h3><i class="fa-regular fa-user" aria-hidden="true"></i> Personal Details</h3>
      <button type="button" class="btn btn-outline-primary btn-sm edit-toggle">
        <span class="t-edit"><i class="fa-solid fa-pen" aria-hidden="true"></i> Edit</span>
        <span class="t-close"><i class="fa-solid fa-xmark" aria-hidden="true"></i> Close</span>
      </button>
    </div>

    <!-- view mode -->
    <div class="view-box">
      <div class="profile-head">
        <span class="avatar lg">
          @if($photoUrl)<img src="{{ $photoUrl }}" alt="{{ $customer->name }}" />@else{{ $initial }}@endif
        </span>
        <div>
          <h4>{{ $customer->name }}</h4>
          <p>Member since {{ $customer->created_at->format('M Y') }}</p>
        </div>
      </div>
      <div class="detail-list">
        <div><small>Full Name</small><p>{{ $customer->name }}</p></div>
        <div><small>Email</small><p>{{ $customer->email }}</p></div>
        <div><small>Mobile</small><p>{{ $phoneFmt }}</p></div>
        <div><small>Date of Birth</small><p>{{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('d M Y') : '—' }}</p></div>
      </div>
    </div>

    <!-- edit mode -->
    <div class="edit-box">
      <form class="form profile-form" action="{{ route('account.profile.update') }}" method="post"
        enctype="multipart/form-data" novalidate>
        @csrf
        <div class="avatar-upload">
          <span class="avatar lg" id="pfAvatar">
            @if($photoUrl)<img src="{{ $photoUrl }}" alt="" />@else{{ $initial }}@endif
          </span>
          <div>
            <label class="btn btn-outline-primary btn-sm" for="pf-photo">
              <i class="fa-solid fa-camera" aria-hidden="true"></i> Change Photo</label>
            <input type="file" id="pf-photo" name="avatar" accept="image/*" hidden />
<p>JPG or PNG, max 2 MB.</p>
<span class="error" data-for="avatar"></span>
          </div>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <input type="text" id="pf-name" name="name" value="{{ $customer->name }}" placeholder=" " required />
            <label for="pf-name">Full Name</label>
            <span class="error"></span>
          </div>
          <div class="form-group">
            <input type="email" id="pf-email" name="email" value="{{ $customer->email }}" placeholder=" " readonly />
            <label for="pf-email">Email</label>
            <span class="error"></span>
          </div>
         <div class="form-group">
  <input type="tel" id="pf-mobile" name="mobile" value="{{ $customer->mobile }}" placeholder=" " required />
  <label for="pf-mobile">Mobile Number</label>
  <span class="error"></span>
</div>
          <div class="form-group has-icon calender-icon">
            <input type="text" id="pf-dob" name="dob"
              value="{{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('d M Y') : '' }}" placeholder=" " />
            <label for="pf-dob">Date of Birth</label>
            <span class="error"></span>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-outline-primary edit-cancel">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Saved addresses -->
  <div class="dash-panel">
    <div class="panel-head">
      <h3><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Saved Addresses</h3>
      <button type="button" class="btn btn-outline-primary btn-sm addr-add">
        <i class="fa-solid fa-plus" aria-hidden="true"></i> Add New
      </button>
    </div>

    <div class="addr-list">
      @forelse($addresses as $addr)
        <div class="addr-card">
          <span class="addr-type {{ $addr->is_default ? 'default' : '' }}">
            {{ $typeLabels[$addr->address_type] ?? 'Home' }}{{ $addr->is_default ? ' · Default' : '' }}
          </span>
          <h5>{{ $addr->name }}</h5>
          <p>
            {{ $addr->address_line_1 }}@if($addr->address_line_2), {{ $addr->address_line_2 }}@endif<br />
            {{ $addr->city?->name }}, {{ $addr->state?->name }} - {{ $addr->pincode }}<br />
            Mobile: {{ $addr->phone }}
          </p>
          <div class="addr-actions">
            <a href="javascript:void(0);" class="addr-edit"
              data-id="{{ $addr->id }}"
              data-name="{{ $addr->name }}"
              data-phone="{{ $addr->phone }}"
              data-pincode="{{ $addr->pincode }}"
              data-state="{{ $addr->state_id }}"
              data-city="{{ $addr->city_id }}"
              data-line1="{{ $addr->address_line_1 }}"
              data-line2="{{ $addr->address_line_2 }}"
              data-type="{{ $addr->address_type ?? 'home' }}"
              data-default="{{ $addr->is_default ? 1 : 0 }}">
              <i class="fa-solid fa-pen" aria-hidden="true"></i> Edit</a>
            <a href="javascript:void(0);" class="remove addr-remove" data-id="{{ $addr->id }}">
              <i class="fa-regular fa-trash-can" aria-hidden="true"></i> Remove</a>
          </div>
        </div>
      @empty
        <p class="muted">You have not saved any address yet.</p>
      @endforelse
    </div>

    <!-- add / edit address form -->
    <div class="addr-form">
      <h5 class="od-title" id="addrFormTitle">Address details</h5>
      <form class="form address-form" id="addressForm" action="{{ route('account.address.store') }}" method="post" novalidate>
        @csrf
        <input type="hidden" name="address_id" id="ad-id" value="" />
        <div class="form-grid">
          <div class="form-group">
            <input type="text" id="ad-name" name="name" placeholder=" " required />
            <label for="ad-name">Full Name</label>
            <span class="error"></span>
          </div>
          <div class="form-group">
            <input type="tel" id="ad-mobile" name="phone" placeholder=" " required />
            <label for="ad-mobile">Mobile Number</label>
            <span class="error"></span>
          </div>
          <div class="form-group">
            <input type="text" id="ad-pin" name="pincode" inputmode="numeric" maxlength="6" placeholder=" " required />
            <label for="ad-pin">Pincode</label>
            <span class="error"></span>
          </div>
          <div class="form-group">
            <select id="ad-state" name="state_id" required>
              <option value="">Select state</option>
              @foreach($states as $st)
                <option value="{{ $st->id }}">{{ $st->name }}</option>
              @endforeach
            </select>
            <label for="ad-state">State</label>
            <span class="error"></span>
          </div>
          <div class="form-group">
            <select id="ad-city" name="city_id" required>
              <option value="">Select city</option>
            </select>
            <label for="ad-city">City</label>
            <span class="error"></span>
          </div>
          <div class="form-group">
            <input type="text" id="ad-line1" name="address_line_1" placeholder=" " required />
            <label for="ad-line1">House / flat no., building</label>
            <span class="error"></span>
          </div>
          <div class="form-group full">
            <input type="text" id="ad-line2" name="address_line_2" placeholder=" " />
            <label for="ad-line2">Street, area, landmark (optional)</label>
            <span class="error"></span>
          </div>
        </div>

        <div class="addr-extra">
          <div class="type-pills">
            <label class="pill"><input type="radio" name="address_type" value="home" checked /> <span>Home</span></label>
            <label class="pill"><input type="radio" name="address_type" value="office" /> <span>Work</span></label>
            <label class="pill"><input type="radio" name="address_type" value="other" /> <span>Other</span></label>
          </div>
          <label class="check"><input type="checkbox" name="is_default" value="1" id="ad-default" />
            <span>Make this my default address</span></label>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Save Address</button>
          <button type="button" class="btn btn-outline-primary addr-cancel">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

          </div>

          <!-- ===== Sign out ===== -->
         <form method="POST" action="{{ route('user.logout') }}">
  @csrf
  <button type="submit" class="logout-btn" style="width: 100%;">
    <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i> Sign Out
  </button>
</form>
        </div>
      </div>
    </section>
  </main>



@endsection

@push('scripts')
  <script>
    $(function () {
      var $dash = $(".dash-secA");
      var $nav = $dash.find(".tab-nav");
      var $content = $dash.find(".tab-nav-content");

      // ===== Tab activate (common JS par depend nahi) =====
      function activateTab(n) {
        var $li = $nav.children('li[data-tab="' + n + '"]');
        var $target = $content.children('.tabs[data-tab="' + n + '"]');
        if (!$li.length || !$target.length) return false;

        $li.addClass("active").siblings().removeClass("active");
        $target.addClass("active").siblings(".tabs").removeClass("active");

        // tab-nav mobile par scroll hota hai, active tab dikhao
        var el = $li.get(0);
        if (el && el.scrollIntoView && $nav.css("overflow-x") === "auto") {
          $nav.scrollLeft(el.offsetLeft - 20);
        }
        return true;
      }

      function scrollToDash() {
        $("html, body").animate({ scrollTop: $dash.offset().top - 150 }, 300);
      }

      // ===== Hash se tab kholna (dashboard.html#tab-1 ... #tab-5) =====
      function openTabFromHash(scroll) {
        var h = window.location.hash.match(/^#tab-(\d+)$/);
        if (!h) return;
        if (activateTab(h[1]) && scroll) scrollToDash();
      }

      // page load pe (alag-alag timing ke liye 3 baar, safe hai)
      openTabFromHash(false);
      $(window).on("load", function () {
        openTabFromHash(true);
      });
      setTimeout(function () {
        openTabFromHash(false);
      }, 300);

      // hash badle (dashboard par hi header/footer link click ho)
      $(window).on("hashchange", function () {
        openTabFromHash(true);
      });

      // same hash par dobara click karne par bhi kaam kare
      $(document).on("click", 'a[href*="dashboard.html#tab-"]', function () {
        var m = this.getAttribute("href").match(/#tab-(\d+)$/);
        var onDash = /dashboard\.html$/.test(
          window.location.pathname.split("/").pop(),
        );
        if (m && onDash) {
          activateTab(m[1]);
          scrollToDash();
        }
      });

      // tab click par URL hash update (refresh par wahi tab khule)
      $nav.children("li").on("click", function () {
        try {
          history.replaceState(null, "", "#tab-" + $(this).data("tab"));
        } catch (e) { }
      });

      // ===== "View all / Track" links =====
      $(".go-tab").on("click", function () {
        var n = $(this).data("go");
        $nav.children('li[data-tab="' + n + '"]').trigger("click");
        activateTab(n);
        scrollToDash();
      });

      // ===== Order detail: slide up / down (ek time pe ek open) =====
      $(".order-head").on("click", function () {
        var $card = $(this).closest(".order-card");
        $card
          .siblings(".order-card.open")
          .removeClass("open")
          .find(".order-detail")
          .slideUp(300);
        $card.toggleClass("open").find(".order-detail").slideToggle(300);
      });

      // ===== Orders search =====
      $(".orders-bar").on("submit", function (e) {
        e.preventDefault();
      });
      $("#od-search").on("input", function () {
        var q = $.trim($(this).val()).toLowerCase();
        $dash.find(".order-card").each(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
        });
      });

      // ===== Wishlist: remove =====
var WISH_REMOVE_URL = @json(route('account.wishlist.remove', ['id' => '__ID__'])),
  WISH_CSRF = @json(csrf_token());

$(document).on("click", ".wish-remove", function () {
  var $btn = $(this),
    $card = $btn.closest(".wish-card"),
    fd = new FormData();

  fd.append("_method", "DELETE");
  $btn.prop("disabled", true);

  fetch(WISH_REMOVE_URL.replace("__ID__", $btn.data("id")), {
    method: "POST",
    headers: { "X-Requested-With": "XMLHttpRequest", "Accept": "application/json", "X-CSRF-TOKEN": WISH_CSRF },
    body: fd
  })
    .then(function (r) { return r.json(); })
    .then(function (res) {
      if (!res.success) { $btn.prop("disabled", false); return; }

      $card.fadeOut(250, function () {
        $card.remove();
        var n = res.count;
        $(".wish-count").text("(" + n + " " + (n === 1 ? "item" : "items") + ")");
        $nav.children('li[data-tab="4"]').find(".count").text(n);
        if (!n) {
          $(".wish-grid").hide();
          $(".wish-empty").show();
        }
      });
    })
    .catch(function () { $btn.prop("disabled", false); });
});

      // ===== Profile: view <-> edit =====
      $(".edit-toggle").on("click", function () {
        var $p = $(this).closest(".dash-panel");
        $(this).toggleClass("is-open");
        $p.find(".view-box").slideToggle(250);
        $p.find(".edit-box").slideToggle(250);
      });
      $(".edit-cancel").on("click", function () {
        $(this).closest(".dash-panel").find(".edit-toggle").trigger("click");
      });

     

      // ===== Profile + addresses =====
var UPDATE_URL = @json(route('account.address.update', ['address' => '__ID__'])),
  DELETE_URL = @json(route('account.address.delete', ['address' => '__ID__'])),
  STORE_URL = @json(route('account.address.store')),
  CITIES_URL = @json(route('state.cities', ['state' => '__ID__'])), // use your existing cities route name
  PF_CSRF = @json(csrf_token());

function send(url, fd, method) {
  if (method && method !== 'POST') fd.append('_method', method);
  return fetch(url, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': PF_CSRF },
    body: fd
  }).then(function (r) {
    return r.json().catch(function () { return {}; }).then(function (j) { return { ok: r.ok, status: r.status, body: j }; });
  });
}

function clearErrors(form) {
  $(form).find('.error').text('').hide();
}

function showErrors(form, res) {
  clearErrors(form);
  var errs = (res.body && res.body.errors) || {};
  var any = false;
  $.each(errs, function (field, msgs) {
    var $f = $(form).find('[name="' + field + '"]');
    var $err = $f.closest('.form-group').find('.error');
    if (!$err.length) $err = $(form).find('.error[data-for="' + field + '"]');
    $err.text(msgs[0]).css('display', 'block');
    any = true;
  });
  if (!any) {
    var msg = res.status === 419 ? 'Your session expired. Please refresh the page.'
      : (res.body && res.body.message) || 'Something went wrong. Please try again.';
    $(form).find('.form-actions').before('<span class="error" style="display:block">' + $('<div>').text(msg).html() + '</span>');
  }
}

function busy(form, on) {
  $(form).find('[type="submit"]').prop('disabled', on);
}

// ---- profile form ----
$('#pf-photo').on('change', function () {
  var f = this.files && this.files[0];
  if (!f) return;
  var rd = new FileReader();
  rd.onload = function (e) { $('#pfAvatar').html('<img src="' + e.target.result + '" alt="" />'); };
  rd.readAsDataURL(f);
});

$('.profile-form').on('submit', function (e) {
  e.preventDefault();
  var form = this;
  clearErrors(form);
  $(form).find('.form-actions').prev('.error').remove();
  busy(form, true);
  send(form.action, new FormData(form)).then(function (res) {
    busy(form, false);
    if (res.ok && res.body.success) return window.location.reload();
    showErrors(form, res);
  }).catch(function () {
    busy(form, false);
    showErrors(form, { status: 0, body: {} });
  });
});

// ---- address form ----
var $addrForm = $('.addr-form'), addrForm = document.getElementById('addressForm');

function loadCities(stateId, selected) {
  var $city = $('#ad-city').html('<option value="">Select city</option>');
  if (!stateId) return;
  fetch(CITIES_URL.replace('__ID__', stateId), { headers: { 'Accept': 'application/json' } })
    .then(function (r) { return r.json(); })
    .then(function (list) {
      list.forEach(function (c) {
        $city.append($('<option>').val(c.id).text(c.name));
      });
      if (selected) $city.val(selected);
    });
}

function resetAddressForm() {
  addrForm.reset();
  $('#ad-id').val('');
  $('#ad-city').html('<option value="">Select city</option>');
  clearErrors(addrForm);
  $(addrForm).find('.form-actions').prev('.error').remove();
}

$('#ad-state').on('change', function () { loadCities(this.value); });
$('#ad-pin').on('input', function () { this.value = this.value.replace(/\D/g, ''); });

$('.addr-add').on('click', function () {
  resetAddressForm();
  $('#addrFormTitle').text('Add new address');
  $addrForm.slideDown(250);
});

$(document).on('click', '.addr-edit', function () {
  var d = $(this).data();
  resetAddressForm();
  $('#addrFormTitle').text('Edit address');
  $('#ad-id').val(d.id);
  $('#ad-name').val(d.name);
  $('#ad-mobile').val(d.phone);
  $('#ad-pin').val(d.pincode);
  $('#ad-line1').val(d.line1);
  $('#ad-line2').val(d.line2);
  $('#ad-state').val(d.state);
  loadCities(d.state, d.city);
  $(addrForm).find('[name="address_type"][value="' + d.type + '"]').prop('checked', true);
  $('#ad-default').prop('checked', !!d.default);
  $addrForm.slideDown(250);
});

$('.addr-cancel').on('click', function () {
  $addrForm.slideUp(250);
});

$(addrForm).on('submit', function (e) {
  e.preventDefault();
  var form = this, id = $('#ad-id').val();
  clearErrors(form);
  $(form).find('.form-actions').prev('.error').remove();
  busy(form, true);

  var url = id ? UPDATE_URL.replace('__ID__', id) : STORE_URL;
  send(url, new FormData(form), id ? 'PUT' : 'POST').then(function (res) {
    busy(form, false);
    if (res.ok && res.body.success) return window.location.reload();
    showErrors(form, res);
  }).catch(function () {
    busy(form, false);
    showErrors(form, { status: 0, body: {} });
  });
});

$(document).on('click', '.addr-remove', function () {
  var id = $(this).data('id');
  function doDelete() {
    send(DELETE_URL.replace('__ID__', id), new FormData(), 'DELETE').then(function (res) {
      if (res.ok && res.body.success) window.location.reload();
    });
  }
  if (window.Swal) {
    Swal.fire({ title: 'Remove this address?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Remove' })
      .then(function (r) { if (r.isConfirmed) doDelete(); });
  } else if (confirm('Remove this address?')) {
    doDelete();
  }
});

    });
  </script>
@endpush