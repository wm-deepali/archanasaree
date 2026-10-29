@php
    $showBadge = $showBadge ?? true;
    $simple    = $simple ?? false;
@endphp
<div class="prod_cart">
    <div class="prod-img">
        <a href="{{ route('products.show') }}" class="prod-link">
            <img src="{{ asset('assets/images/home/' . $p['img']) }}" alt="{{ $p['name'] }}" loading="lazy" />
        </a>
        @if ($showBadge && !empty($p['badge']))
            <span class="prod-badge">{{ $p['badge'] }}</span>
        @endif
        <div class="prod-actions">
            <button type="button" class="act-btn wish-btn" aria-label="Wishlist"><i class="fa-regular fa-heart"></i></button>
            <button type="button" class="act-btn quick-btn" aria-label="Quick view"><i class="fa-regular fa-eye"></i></button>
        </div>
    </div>
    <div class="prod-info">
        <div class="prod-meta">
            <span class="prod-cat">{{ $p['cat'] }}</span>
            <span class="prod-rate"><i class="fa-solid fa-star"></i> {{ $p['rate'] }}</span>
        </div>
        <h5 class="prod-name"><a href="{{ route('products.show') }}">{{ $p['name'] }}</a></h5>
        <div class="prod-price">
            <span class="price-now">₹{{ number_format($p['price']) }}</span>
            <del class="price-old">₹{{ number_format($p['old']) }}</del>
            <span class="price-off">{{ $p['off'] }}% OFF</span>
        </div>
        @if ($simple)
            <button type="button" class="btn btn-outline-primary prod-cta">Add to Bag</button>
        @else
            <div class="prod-btns">
                <button data-model=".cart-pop" type="button" class="btn btn-outline-primary prod-cta">Add to Cart</button>
                <a href="{{ route('products.show') }}" class="btn btn-primary prod-cta">Buy Now</a>
            </div>
        @endif
    </div>
</div>