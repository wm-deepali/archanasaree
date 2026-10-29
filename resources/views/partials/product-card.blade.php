@php
    $img    = $product->images->firstWhere('is_default', 1) ?? $product->images->first();
    $imgSrc = $img ? asset('storage/' . ($img->thumb ?? $img->image)) : asset('assets/images/home/tab1.png');
    $off    = $product->mrp > $product->price
                ? round((($product->mrp - $product->price) / $product->mrp) * 100) : 0;
    $badge  = $product->collections->first()?->name;
    $url    = route('products.show', ['slug' => $product->slug]);
@endphp
<div class="prod_cart">
    <div class="prod-img">
        <a href="{{ $url }}" class="prod-link">
            <img src="{{ $imgSrc }}" alt="{{ $product->name }}" loading="lazy" />
        </a>
        @if ($badge)
            <span class="prod-badge">{{ $badge }}</span>
        @endif
        <div class="prod-actions">
            <button type="button" class="act-btn wish-btn" data-id="{{ $product->id }}" aria-label="Wishlist">
                <i class="fa-regular fa-heart"></i>
            </button>
            <button type="button" class="act-btn quick-btn" data-id="{{ $product->id }}" aria-label="Quick view">
                <i class="fa-regular fa-eye"></i>
            </button>
        </div>
    </div>
    <div class="prod-info">
        <div class="prod-meta">
            <span class="prod-cat">{{ $product->subcategory->name ?? $product->category->name }}</span>
            @if ($product->avg_rating)
                <span class="prod-rate"><i class="fa-solid fa-star"></i> {{ number_format($product->avg_rating, 1) }}</span>
            @endif
        </div>
        <h5 class="prod-name"><a href="{{ $url }}">{{ $product->name }}</a></h5>
        <div class="prod-price">
            <span class="price-now">₹{{ number_format($product->price) }}</span>
            @if ($off > 0)
                <del class="price-old">₹{{ number_format($product->mrp) }}</del>
                <span class="price-off">{{ $off }}% OFF</span>
            @endif
        </div>
        <div class="prod-btns">
            <button data-model=".cart-pop" data-id="{{ $product->id }}" type="button"
                class="btn btn-outline-primary prod-cta">Add to Cart</button>
            <a href="{{ $url }}" class="btn btn-primary prod-cta">Buy Now</a>
        </div>
    </div>
</div>