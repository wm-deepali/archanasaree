{{-- Swiper slides: har product ek .swiper-slide me, card partial same use hota hai --}}
@foreach ($products as $p)
    <div class="swiper-slide">
        @include('partials.product-cards', ['products' => collect([$p])])
    </div>
@endforeach
