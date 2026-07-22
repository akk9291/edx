<div class="product-item grid-type group relative" data-item="{{ $product->id ?? '' }}">
    <div class="product-main cursor-pointer block relative">
        <div class="product-thumb bg-white relative rounded-2xl overflow-hidden">
            @if(isset($product->is_new_arrival) && $product->is_new_arrival)
                <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
            @endif
            
            <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative cursor-pointer" data-product-id="{{ $product->id ?? '' }}">
                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                    <i class="ph ph-heart text-lg"></i>
                </div>
                <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2 cursor-pointer" data-product-id="{{ $product->id ?? '' }}">
                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                    <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                    <i class="ph ph-check-circle text-lg checked-icon hidden"></i>
                </div>
            </div>
            
            <a href="{{{ route('product.show', $product->slug ?? '#') }}}" class="product-img w-full h-full aspect-[3/4] relative block overflow-hidden">
                @php
                    $getImageUrl = function($path) {
                        if (!$path || !is_string($path)) return asset('assets/images/product/perch-bottal.webp');
                        if (str_starts_with($path, 'http') || str_starts_with($path, '//')) return $path;
                        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) return asset($path);
                        return storage_asset($path);
                    };
                    $placeholderImg = asset('assets/images/product/perch-bottal.webp');
                    $mainImage = $getImageUrl($product->image ?? null);
                    if ($mainImage === $placeholderImg && isset($product->images) && is_array($product->images) && count($product->images) > 0 && is_string($product->images[0])) {
                        $mainImage = $getImageUrl($product->images[0]);
                    }
                    $hoverImage = (isset($product->images) && is_array($product->images) && count($product->images) > 0) ? $getImageUrl($product->images[0]) : $mainImage;
                @endphp
                <img class="w-full h-full object-cover duration-700 absolute inset-0" src="{{ $mainImage }}" alt="{{ $product->name ?? 'Product' }}" onerror="this.onerror=null; this.src='{{ $placeholderImg }}';" />
                <img class="w-full h-full object-cover duration-700 absolute inset-0 opacity-0 hover:opacity-100" src="{{ $hoverImage }}" alt="{{ $product->name ?? 'Product' }}" onerror="this.onerror=null; this.src='{{ $placeholderImg }}';" />
            </a>
            
            <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 opacity-0 group-hover:opacity-100 max-md:opacity-100 max-md:group-hover:opacity-100 transition-opacity duration-300 z-10 pointer-events-auto">
                <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white cursor-pointer select-none flex items-center justify-center" data-product-id="{{ $product->id ?? '' }}" data-product-slug="{{ $product->slug ?? '' }}">
                    <span class="max-lg:hidden">Quick View</span>
                    <i class="ph ph-eye lg:hidden text-xl"></i>
                </div>
                <div class="quick-shop-btn w-full text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white cursor-pointer select-none flex items-center justify-center" title="Quick Shop" data-product-id="{{ $product->id ?? '' }}" data-product-slug="{{ $product->slug ?? '' }}" role="button" tabindex="0" onclick="event.preventDefault();event.stopPropagation();var s=this.getAttribute('data-product-slug');if(s&&window.openQuickView){window.openQuickView(s)}"><span class="max-lg:hidden">Quick Shop</span><i class="ph ph-storefront lg:hidden text-xl" aria-hidden="true"></i></div>
                <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white lg:hidden cursor-pointer flex items-center justify-center" data-product-id="{{ $product->id ?? '' }}">
                    <span class="max-lg:hidden">Add To Cart</span>
                    <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                </div>
                <div class="quick-shop-block absolute left-2 right-2 bottom-full mb-2 bg-white p-5 rounded-[20px] hidden z-30 shadow-xl border border-line">
                    @if(isset($product->sizes) && is_array($product->sizes) && count($product->sizes) > 0)
                        <div class="list-size flex items-center justify-center flex-wrap gap-2">
                            @foreach($product->sizes as $size)
                                <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black cursor-pointer" data-size="{{ $size }}">{{ $size }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="add-cart-btn button-main w-full text-center rounded-full py-3 mt-4 cursor-pointer" data-product-id="{{ $product->id ?? '' }}">Add To cart</div>
                </div>
            </div>
        </div>
        
        <div class="product-infor mt-4 lg:mb-7">
            <a href="{{{ route('product.show', $product->slug ?? '#') }}}" class="product-name text-title duration-300 hover:text-secondary block">{{ $product->name ?? 'Product Name' }}</a>

            @if(isset($product->colors) && (is_array($product->colors) || is_object($product->colors)) && count($product->colors) > 0)
                <div class="list-color {{ isset($product->images) && is_array($product->images) && count($product->images) > 0 ? 'list-color-image' : '' }} max-md:hidden flex items-center gap-3 flex-wrap duration-500 py-2">
                    @foreach(is_array($product->colors) ? array_slice($product->colors, 0, 3) : $product->colors->take(3) as $index => $color)
                        @php
                            $colorImage = null;
                            if (isset($product->images) && is_array($product->images) && isset($product->images[$index])) {
                                $colorImage = $getImageUrl($product->images[$index]);
                            }
                        @endphp
                        <div class="color-item {{ $colorImage ? 'w-12 h-12 rounded-xl' : 'w-8 h-8 rounded-full' }} duration-300 relative cursor-pointer" 
                             style="{{ !$colorImage ? 'background-color: ' . $color . ';' : '' }}"
                             data-color="{{ $color }}">
                            @if($colorImage)
                                <img src="{{ $colorImage }}" alt="{{ $color }}" class="rounded-xl w-full h-full object-cover" />
                            @endif
                            <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm opacity-0 hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $color }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
