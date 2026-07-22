<div class="list-product hide-product-sold grid grid-cols-2 md:grid-cols-3 xl:grid-cols-3 md:gap-[30px] gap-4 mt-7">
    @forelse($products as $product)
        @include('partials.product-card', ['product' => $product])
    @empty
        <div class="col-span-full text-center py-16">
            <p class="text-secondary body1">No products found.</p>
            <a href="{{ route('shop') }}" class="button-main mt-4 inline-block shop-filter-link">Browse Shop</a>
        </div>
    @endforelse
</div>

@if($products->hasPages())
<div class="list-pagination w-full flex items-center justify-center gap-4 mt-10">
    {{ $products->links() }}
</div>
@endif
