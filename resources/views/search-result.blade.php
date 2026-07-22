@extends('layouts.app')

@section('title', 'Search Result - Perch Bottle')

@section('content')
<div class="page-content search-page-content">
    <!-- Menu bar (mobile) -->
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">Search Result</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <div class="text-secondary2 capitalize">Search Result</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shop-product search-result-block lg:py-20 md:py-14 py-10">
        <div class="container">
            <div class="heading flex flex-col items-center">
                <div class="heading4 text-center">
                    @if($query)
                        Found <span class="result-quantity">{{ $products->total() }}</span> results for "<span class="result">{{ e($query) }}</span>"
                    @else
                        <span class="result-quantity">0</span> results - enter a search term
                    @endif
                </div>
                <div class="input-block lg:w-1/2 sm:w-3/5 w-full md:h-[52px] h-[44px] sm:mt-8 mt-5">
                    <form method="GET" action="{{ route('search') }}" class="form-search w-full h-full relative">
                        <input type="text" name="q" placeholder="Search products..." value="{{ e($query ?? '') }}" class="caption1 w-full h-full pl-4 md:pr-[150px] pr-32 rounded-xl border border-line" />
                        <button type="submit" class="button-main absolute top-1 bottom-1 right-1 flex items-center justify-center px-4">Search</button>
                    </form>
                </div>
            </div>

            <div class="list-product-block relative md:pt-10 pt-6">
                <div class="heading6">
                    @if($query)
                        Product search: <span class="result">{{ e($query) }}</span>
                    @else
                        Search for products
                    @endif
                </div>
                <div class="list-product list-product-result hide-product-sold grid lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 sm:gap-[30px] gap-[20px] mt-5">
                    @forelse($products as $product)
                        <div class="product-item grid-type">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            @if($query)
                                <p class="body1 text-secondary">No products found for "{{ e($query) }}". Try different keywords.</p>
                            @else
                                <p class="body1 text-secondary">Enter a search term above to find products.</p>
                            @endif
                        </div>
                    @endforelse
                </div>
                @if($query && $products->hasPages())
                    <div class="list-pagination w-full flex items-center justify-center gap-4 mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
