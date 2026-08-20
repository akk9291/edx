@extends('layouts.frontend')

@section('title', 'Product Range - EDX Rulmenti Romania')

@section('content')
<style>
    .edx-red {
        --tw-bg-opacity: 1;
        background-color: rgb(236 33 39);
        color: #fff !important;
    }
    .filter-toggle-container {
        display: block;
    }
    @media (min-width: 768px) {
        .filter-toggle-container {
            display: none !important;
        }
    }
    @media (max-width: 575px) {
        .product-item.edxpro .product-main {
            flex-direction: row !important;
            align-items: flex-start !important;
            gap: 1rem !important;
            padding: 0.75rem !important;
            flex-wrap: wrap !important;
        }
        .product-item.edxpro .product-main > a {
            flex-direction: row !important;
            align-items: flex-start !important;
            width: 100% !important;
            flex: 1 1 100% !important;
            gap: 1rem !important;
            max-width: 100% !important;
        }
        .product-item.edxpro .product-thumb {
            width: 80px !important;
            height: 80px !important;
            flex-shrink: 0 !important;
            border-radius: 0.75rem !important;
            border: 1px solid #e9e9e9 !important;
            padding: 4px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: #fff !important;
            max-width: 80px !important;
        }
        .product-item.edxpro .product-thumb .product-img {
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .product-item.edxpro .product-thumb img {
            width: auto !important;
            height: auto !important;
            max-width: 100% !important;
            max-height: 100% !important;
            object-fit: contain !important;
        }
        .product-item.edxpro .product-infor {
            width: auto !important;
            flex: 1 !important;
            min-width: 0 !important;
            margin-top: 0 !important;
        }
        .product-item.edxpro .product-name {
            font-size: 1rem !important;
            font-weight: 700 !important;
        }
        .product-item.edxpro .product-price-block {
            margin-top: 0.25rem !important;
        }
        .product-item.edxpro .product-price {
            font-size: 0.75rem !important;
            padding: 2px 10px !important;
        }
        .product-item.edxpro .min {
            font-size: 0.75rem !important;
            margin-top: 0.25rem !important;
        }
        .product-item.edxpro .action {
            width: 100% !important;
            margin-top: 0.5rem !important;
            flex: 1 1 100% !important;
        }
        .product-item.edxpro .edx-btn-add-quote {
            width: 100% !important;
        }
    }
</style>
<!-- Breadcrumb (red) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container max-w-5xl mx-auto pt-3 pb-4 md:pt-4 md:pb-5 relative">
            <div class="main-content w-full flex flex-col items-center text-center relative z-[1]">
                <div class="text-content w-full" style="color: aliceblue;">
                    @if(!empty($rangeCategory))
                        <div class="heading6 font-semibold text-white/95 leading-snug max-w-3xl mx-auto">{{ $rangeCategory->name }}</div>
                    @endif
                    <div class="link flex justify-center gap-1 caption1 flex-wrap {{ !empty($rangeCategory) ? 'mt-2' : 'mt-3' }}">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm" aria-hidden="true"></i>
                        <div class="capitalize">{{ $rangeCategory?->name ?? 'Bearing' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Search: red ke niche, centered --}}
<div class="w-full border-b border-line" style="background: #f8f8f8;">
    <div class="container max-w-6xl mx-auto px-4 py-5 md:py-8">
        @include('frontend.partials.catalog-search-bar', ['centered' => true])
    </div>
</div>

<div class="shop-product breadcrumb1 lg:py-20 md:py-14 py-10">
    <div class="container">
        {{-- Mobile only: filter toggle button --}}
        <div class="filter-toggle-container mb-4">
            <button type="button" id="mobileFilterToggle" class="w-full py-3 px-4 flex items-center justify-center gap-2 rounded-xl bg-black text-white font-semibold text-sm transition-colors hover:bg-stone-800">
                <i class="ph ph-sliders text-lg" aria-hidden="true"></i> Filter Products
            </button>
        </div>

        {{-- Mobile only: natural column order (filters then list). Desktop unchanged from default flex row. --}}
        <div class="flex max-md:flex-wrap max-md:flex-col gap-y-8">
            <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12 max-md:hidden" id="catalogSidebar">
                @include('frontend.partials.catalog-sidebar', ['categories' => $categories ?? collect(), 'facets' => $facets ?? ['rows' => []]])
            </div>
            <div class="list-product-block style-list lg:w-3/4 md:w-2/3 w-full md:pl-3">
                <div class="filter-heading flex items-center justify-between gap-5 flex-wrap">
                    <div class="left flex has-line items-center flex-wrap gap-5">
                        <div class="min flex items-center gap-1">
                            <div>Products:</div>
                            <div class="min-price">{{ $products->total() }}</div>
                        </div>
                        @if(request()->filled('search'))
                            <a href="{{ route('frontend.range', request()->except(['search', 'page'])) }}" class="caption1 inline-flex items-center gap-1 rounded-full border border-line px-3 py-1 text-secondary hover:text-black">
                                Search: {{ request('search') }}
                                <span aria-hidden="true">&times;</span>
                            </a>
                        @endif
                    </div>
                    <div class="sort-product right flex items-center gap-3">
                        <label for="select-filter" class="caption1 capitalize">Sort by</label>
                        <div class="select-block relative">
                            <select id="select-filter" name="select-filter" class="caption1 py-2 pl-3 md:pr-20 pr-10 rounded-lg border border-line" onchange="window.location.href=this.value">
                                <option value="{{ route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="{{ route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            </select>
                            <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                        </div>
                    </div>
                </div>

                <div class="list-product flex flex-col gap-8 mt-7">
                    @forelse($products as $product)
                    <div class="product-item list-type edxpro" data-product-id="{{ $product->id }}">
                        <div class="product-main cursor-pointer flex lg:items-center sm:justify-between gap-7 max-lg:gap-5 p-4">
                            <a href="{{ route('frontend.product', $product->slug) }}" class="flex sm:items-center gap-7 max-lg:gap-4 max-lg:flex-wrap lg:w-2/3 lg:flex-shrink-0 max-lg:w-full max-sm:flex-col max-sm:w-1/2 flex-1 min-w-0 no-underline text-inherit">
                                <div class="product-thumb bg-white relative overflow-hidden rounded-2xl block max-sm:w-1/2">
                                    <div class="product-img w-full rounded-2xl overflow-hidden">
                                        <img class="w-full duration-700" src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 200px;">
                                    </div>
                                </div>
                                <div class="product-infor max-sm:w-full">
                                    <div class="product-name heading6 inline-block duration-300">{{ $product->sku }}</div>
                                    <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                        <div class="product-price text-title edx-red px-3 py-0.5 inline-block rounded-full">{{ $product->category->name ?? 'Bearing' }}</div>
                                    </div>
                                     @if($product instanceof \App\Models\PillowBlock)
                                         @php
                                             $specs = $product->specifications ?? [];
                                             $displaySpecs = array_slice($specs, 0, 3);
                                         @endphp
                                         @forelse($displaySpecs as $idx => $spec)
                                             <div class="min flex items-center gap-1 {{ $idx === 0 ? 'mt-3' : '' }}">
                                                 <div>{{ $spec['title'] ?? 'Spec' }}{{ !empty($spec['dimension']) ? ' ('.$spec['dimension'].')' : '' }}:</div>
                                                 <div class="min-price">{{ $spec['value'] ?? 'N/A' }}</div>
                                             </div>
                                         @empty
                                             <div class="min flex items-center gap-1 mt-3">
                                                 <div>Bearing number:</div>
                                                 <div class="min-price">{{ $product->bearing_number ?? 'N/A' }}</div>
                                             </div>
                                         @endforelse
                                    @elseif($product->specifications)
                                    @php $specs = is_array($product->specifications) ? $product->specifications : json_decode($product->specifications, true); @endphp
                                    @if($specs)
                                    <div class="min flex items-center gap-1 mt-3">
                                        <div>Bore diameter:</div>
                                        <div class="min-price">{{ $specs['bore_diameter'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Outside diameter:</div>
                                        <div class="min-price">{{ $specs['outside_diameter'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Width:</div>
                                        <div class="min-price">{{ $specs['width'] ?? 'N/A' }}</div>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </a>
                            <div class="action w-fit flex flex-col items-center justify-center flex-shrink-0">
                                <button type="button" class="edx-btn-add-quote edx-btn-add-quote--compact w-full min-w-0 sm:min-w-[12rem] edx-add-quota-btn whitespace-nowrap" data-product-id="{{ $product->id }}">
                                    <span class="edx-quota-btn-label">Add to quote</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-lg text-gray-500">No products found.</p>
                        @if(request()->filled('search') && request()->filled('category'))
                            <p class="text-secondary mt-2">No matches for &ldquo;{{ request('search') }}&rdquo; in {{ $rangeCategory?->name ?? 'this category' }}.</p>
                        @endif
                        @if(!empty($searchWithoutCategoryCount) && $searchWithoutCategoryCount > 0)
                            <p class="text-secondary mt-2">
                                {{ $searchWithoutCategoryCount }} matching {{ $searchWithoutCategoryCount === 1 ? 'product' : 'products' }} for &ldquo;{{ request('search') }}&rdquo; in other bearing types.
                            </p>
                            <a href="{{ route('frontend.range', request()->except(['category', 'page'])) }}" class="mt-3 inline-block button-main py-2 px-6 rounded-full">View all matching products</a>
                        @elseif(request()->filled('category'))
                            <a href="{{ route('frontend.range', ['category' => request('category')]) }}" class="mt-4 inline-block button-main py-2 px-6 rounded-full">View all in {{ $rangeCategory?->name ?? 'category' }}</a>
                        @else
                            <a href="{{ route('frontend.range') }}" class="mt-4 inline-block button-main py-2 px-6 rounded-full">View All Products</a>
                        @endif
                    </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                <div class="list-pagination w-full flex items-center gap-4 mt-10">
                    @if($products->onFirstPage())
                    <button class="opacity-50 cursor-not-allowed">&lt;&lt;</button>
                    @else
                    <a href="{{ $products->url(1) }}">&lt;&lt;</a>
                    <a href="{{ $products->previousPageUrl() }}">&lt;</a>
                    @endif

                    @foreach($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" class="{{ $page == $products->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">&gt;</a>
                    <a href="{{ $products->url($products->lastPage()) }}">&gt;&gt;</a>
                    @else
                    <button class="opacity-50 cursor-not-allowed">&gt;&gt;</button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('mobileFilterToggle');
    const sidebar = document.getElementById('catalogSidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('max-md:hidden');
            const isHidden = sidebar.classList.contains('max-md:hidden');
            toggleBtn.innerHTML = isHidden 
                ? '<i class="ph ph-sliders text-lg" aria-hidden="true"></i> Filter Products'
                : '<i class="ph ph-x text-lg" aria-hidden="true"></i> Close Filters';
        });
    }
});
</script>
@endsection
