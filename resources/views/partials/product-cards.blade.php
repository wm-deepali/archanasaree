@forelse ($products as $product)
    @include('partials.product-card', ['product' => $product])
@empty
    <p class="text-center">No products found.</p>
@endforelse