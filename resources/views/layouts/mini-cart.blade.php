@php
  $cartItems = ($miniCart?->items ?? collect())->filter(fn($i) => $i->product);
  $cartQty = (int) $cartItems->sum('quantity');
  $cartSub = (float) $cartItems->sum('total');
@endphp

<div class="cp-head">
  <h3>My Bag <span>{{ $cartQty }} {{ Str::plural('item', $cartQty) }}</span></h3>
</div>

<p class="cp-msg" id="miniCartMsg" style="display:none"></p>

@if ($cartItems->isNotEmpty())
  <ul class="cp-list">
    @foreach ($cartItems as $item)
      @php
        $product = $item->product;
        $unit = (float) $item->price;
        $mrp = (float) (($item->priceVariant->mrp ?? $product->mrp) ?: $unit);
        $off = $mrp > $unit ? (int) round((($mrp - $unit) / $mrp) * 100) : 0;
        $stock = (int) ($item->stockVariant->stock ?? $product->stock);
        $minQty = max(1, (int) $product->min_qty);

        $variant = collect($item->selected_attributes ?? [])->pluck('value')
          ->merge($item->addons->pluck('detail'))
          ->filter()->implode(' · ');
        $url = route('products.show', $product->slug);
      @endphp

      <li class="cp-item" data-id="{{ $item->id }}">
        <a class="cp-img" href="{{ $url }}">
          <img src="{{ $item->display_image }}" alt="{{ $product->name }}" width="96" height="128" loading="lazy" />
        </a>
        <div class="cp-info">
          <span class="cp-cat">{{ $product->subcategory->name ?? ($product->category->name ?? '') }}</span>
          <h4 class="cp-name"><a href="{{ $url }}">{{ $product->name }}</a></h4>
          @if ($variant)
            <span class="cp-variant">{{ $variant }}</span>
          @endif
          <div class="cp-price">
            <strong>₹{{ number_format($unit) }}</strong>
            @if ($off > 0)
              <del>₹{{ number_format($mrp) }}</del><span class="cp-off">{{ $off }}% off</span>
            @endif
          </div>
          <div class="cp-actions">
            <div class="qty" role="group" aria-label="Quantity for {{ $product->name }}">
              <button type="button" class="qty-minus" aria-label="Decrease quantity" @disabled($item->quantity <= $minQty)>
                <i class="fa-solid fa-minus" aria-hidden="true"></i>
              </button>
              <input type="text" value="{{ $item->quantity }}" readonly aria-label="Quantity" />
              <button type="button" class="qty-plus" aria-label="Increase quantity" @disabled($item->quantity >= $stock)>
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
              </button>
            </div>
            <button type="button" class="cp-remove">
              <i class="fa-regular fa-trash-can" aria-hidden="true"></i> Remove
            </button>
          </div>
        </div>
      </li>
    @endforeach
  </ul>

  <div class="cp-foot">
    <div class="cp-total">
      <span>Subtotal</span>
      <strong>₹{{ number_format($cartSub) }}</strong>
    </div>
    <p class="cp-note">
      <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
      Shipping, GST and coupons are applied in your bag.
    </p>
    <div class="cp-btns">
      <a href="{{ route('cart') }}" class="btn btn-outline-primary">View Bag</a>
      <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
    </div>
  </div>
@else
  <div class="cp-empty">
    <span class="cp-empty-icon"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i></span>
    <h4>Your bag is empty</h4>
    <p>Explore our latest sarees, lehengas and bridal wear.</p>
    <a href="{{ route('products') }}" class="btn btn-primary">Shop Sarees</a>
  </div>
@endif