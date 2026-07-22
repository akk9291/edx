@forelse($products as $product)
    <div class="product-item grid-type">
        @include('partials.product-card', ['product' => $product])
    </div>
@empty
    <div class="col-span-full text-center py-8">
        <p class="body1 text-secondary">No products found for "{{ e($query ?? '') }}"</p>
    </div>
@endforelse
