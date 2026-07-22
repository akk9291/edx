@extends('layouts.app')

@section('title', 'Index - Perch Bottle')

@section('content')
<div id="home-content">
<!-- Slider (dynamic from admin Hero Banners) -->
            <div class="slider-block style-two xl:h-[820px] lg:h-[700px] md:h-[580px] sm:h-[500px] h-[350px] max-[420px]:h-[340px] sm:-mt-[75px] w-full">
                <div class="slider-main h-full w-full">
                    <div class="swiper swiper-slider h-full relative">
                        <div class="swiper-wrapper">
                            @forelse($heroBanners as $banner)
                                <div class="swiper-slide">
                                    <div class="slider-item h-full w-full relative overflow-hidden">
                                        <div class=" w-full h-full relative">
                                            
                                            <div class="sub-img absolute inset-0 w-full h-full">
                                                @if($banner->banner_image)
                                                    <img src="{{ storage_asset($banner->banner_image) }}" alt="{{ $banner->name }}" class="w-full h-full object-cover" />
                                                @else
                                                    <img src="{{ asset('assets/images/slider/03b-scaled.webp') }}" alt="{{ $banner->name }}" class="w-full h-full object-cover" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="slider-item h-full w-full relative overflow-hidden">
                                        <div class="container w-full h-full">
                                            <div class="sub-img absolute inset-0 w-full h-full">
                                                <img src="{{ asset('assets/images/slider/03b-scaled.webp') }}" alt="Hero" class="w-full h-full object-cover" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slider -->

<div class="collection-block mt-5">
            <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
                <div class="banner-block md:pt-20 pt-10">
            <div class="container">
                <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                    @php
                        $defaultImages = [
                            asset('assets/images/product/Bottle-1.webp'),
                            asset('assets/images/product/Bottle-4.webp'),
                            asset('assets/images/product/Bottle-8.webp')
                        ];
                    @endphp
                    @forelse($homeCategories as $index => $category)
                        <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                            <div class="banner-img w-full">
                                @if($category->image)
                                    <img src="{{ storage_asset($category->image) }}" alt="{{ $category->name }}" class="w-full duration-500" />
                                @else
                                    <img src="{{ $defaultImages[$index] ?? $defaultImages[0] }}" alt="{{ $category->name }}" class="w-full duration-500" />
                                @endif
                            </div>
                            <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category->name }}</div>
                            <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
                        </div>
                    @empty
                        {{-- Fallback if no categories --}}
                        <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                            <div class="banner-img w-full">
                                <img src="{{ asset('assets/images/product/Bottle-1.webp') }}" alt="bg-img" class="w-full duration-500" />
                            </div>
                            <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Drinkware</div>
                            <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
                        </div>
                        <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                            <div class="banner-img w-full">
                                <img src="{{ asset('assets/images/product/Bottle-4.webp') }}" alt="bg-img" class="w-full duration-500" />
                            </div>
                            <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Barware</div>
                            <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
                        </div>
                        <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                            <div class="banner-img w-full">
                                <img src="{{ asset('assets/images/product/Bottle-8.webp') }}" alt="bg-img" class="w-full duration-500" />
                            </div>
                            <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Kitchenware</div>
                            <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
            </div>
        </div>

        <div class="what-new-block filter-product-block md:pt-20 pt-10" data-filter-type="main-category">
            <div class="container">
                <div class="heading flex flex-col items-center text-center">
                    <div class="heading3">What's new</div>
                    <div class="menu-tab bg-surface rounded-2xl mt-6">
                        <div class="menu flex items-center gap-2 p-1 relative">
                            <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black active" data-item="all">All</div>
                            @foreach($mainCategories ?? [] as $mainCat)
                                <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="{{ $mainCat->slug }}">{{ $mainCat->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
                    @forelse($featuredProducts as $product)
                        <div class="what-new-product-wrap" data-main-category="{{ $product->category->mainCategory->slug ?? 'all' }}">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-secondary">No products available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
        (function() {
            var block = document.querySelector('.what-new-block[data-filter-type="main-category"]');
            if (!block) return;
            var tabs = block.querySelectorAll('.menu-tab .tab-item[data-item]');
            var wraps = block.querySelectorAll('.what-new-product-wrap');
            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    var slug = this.getAttribute('data-item');
                    block.querySelectorAll('.menu-tab .tab-item').forEach(function(t){ t.classList.remove('active'); });
                    this.classList.add('active');
                    wraps.forEach(function(w) {
                        var cat = w.getAttribute('data-main-category');
                        if (slug === 'all' || cat === slug) {
                            w.style.display = '';
                        } else {
                            w.style.display = 'none';
                        }
                    });
                });
            });
        })();
        </script>
        @endpush

        <div class="look-book-block md:mt-20 mt-10 lg:py-20 md:py-14 py-10 bg-linear">
            <div class="container">
                <div class="main-content relative flex max-lg:flex-wrap gap-y-5 items-center lg:justify-end justify-center">
                    <div class="heading bg-white xl:py-20 py-10 xl:px-10 px-8 rounded-2xl lg:w-[30%] lg:absolute lg:top-1/2 lg:-translate-y-1/2 lg:left-0 z-[1] max-lg:text-center">
                        <div class="heading3">Discover the latest collection</div>
                        <a href="{{{ route('shop.collection') }}}" class="button-main bg-green lg:w-full text-center lg:mt-8 mt-5 text-black hover:bg-black hover:text-white">Shop Collection </a>
                    </div>
                    <div class="list popular-product w-3/4 grid sm:grid-cols-2 gap-4 max-lg:w-full">
                        <div class="item relative rounded-xl overflow-hidden">
                            <img src="{{ asset('assets/images/banner/perch123(1).webp') }}" alt="/images/banner/perch123(1).webp" class="w-full h-full object-cover" />
                            <!--<div class="dots absolute top-[22%] left-[55%] cursor-pointer">
                                <div class="top-dot w-8 h-8 rounded-full bg-outline flex items-center justify-center">
                                    <span class="bg-white w-3 h-3 rounded-full duration-300"></span>
                                </div>
                                <a href="{{{ route('shop') }}}" class="product-infor bg-white rounded-2xl p-4 cursor-pointer">
                                    <div class="text-title name">gold necklace</div>
                                    <div class="price text-center">₹60.00</div>
                                    <div class="text-center underline mt-1 text-button-uppercase duration-300 text-secondary2 hover:text-black">View</div>
                                </a>
                            </div>
                            <div class="dots absolute top-[42%] left-[32%] cursor-pointer">
                                <div class="top-dot w-8 h-8 rounded-full bg-outline flex items-center justify-center">
                                    <span class="bg-white w-3 h-3 rounded-full duration-300"></span>
                                </div>
                                <a href="{{{ route('shop') }}}" class="product-infor bg-white rounded-2xl p-4 cursor-pointer">
                                    <div class="text-title name">golden ring</div>
                                    <div class="price text-center">₹50.00</div>
                                    <div class="text-center underline mt-1 text-button-uppercase duration-300 text-secondary2 hover:text-black">View</div>
                                </a>
                            </div>
                            <div class="dots bottom-dot absolute bottom-[20%] left-[58%] cursor-pointer">
                                <div class="bottom-dot w-8 h-8 rounded-full bg-outline flex items-center justify-center">
                                    <span class="bg-white w-3 h-3 rounded-full duration-300"></span>
                                </div>
                                <a href="{{{ route('shop') }}}" class="product-infor bg-white rounded-2xl p-4 cursor-pointer">
                                    <div class="text-title name">Ruby Ring</div>
                                    <div class="price text-center">₹40.00</div>
                                    <div class="text-center underline mt-1 text-button-uppercase duration-300 text-secondary2 hover:text-black">View</div>
                                </a>
                            </div>-->
                        </div>
                        <div class="item relative rounded-xl overflow-hidden">
                            <img src="{{ asset('assets/images/banner/perch123(2).webp') }}" alt="/images/banner/perch123(2).webp" class="w-full h-full object-cover" />
                           <!-- <div class="dots absolute top-[26%] left-[54%] cursor-pointer">
                                <div class="top-dot w-8 h-8 rounded-full bg-outline flex items-center justify-center">
                                    <span class="bg-white w-3 h-3 rounded-full duration-300"></span>
                        </div>
                                <a href="{{{ route('shop') }}}" class="product-infor bg-white rounded-2xl p-4 cursor-pointer">
                                    <div class="text-title name">Snake Ring</div>
                                    <div class="price text-center">₹45.00</div>
                                    <div class="text-center underline mt-1 text-button-uppercase duration-300 text-secondary2 hover:text-black">View</div>
                                </a>
                    </div>
                            <div class="dots absolute top-[29%] left-[30%] cursor-pointer">
                                <div class="top-dot w-8 h-8 rounded-full bg-outline flex items-center justify-center">
                                    <span class="bg-white w-3 h-3 rounded-full duration-300"></span>
                                </div>
                                <a href="{{{ route('shop') }}}" class="product-infor bg-white rounded-2xl p-4 cursor-pointer">
                                    <div class="text-title name">Golden Ring</div>
                                    <div class="price text-center">$48.00</div>
                                    <div class="text-center underline mt-1 text-button-uppercase duration-300 text-secondary2 hover:text-black">View</div>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner-block style-one grid sm:grid-cols-1 ">
            <a href="{{{ route('shop') }}}" class="banner-item relative block overflow-hidden duration-500">
                <div class="banner-img">
                    <img src="{{ asset('assets/images/banner/Blog-3.webp') }}"  alt="img" />
                </div>
                <div class="banner-content absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center">
                    <div class="heading2 text-white">Best Sellers</div>
                    <div class="text-button text-white relative inline-block pb-1 border-b-2 border-white duration-500 mt-2">Shop Now</div>
                </div>
            </a>
            
        </div>

        <div class="tab-features-block filter-prodduct-block md:pt-20 pt-10" id="home-best-sellers-section">
            <div class="container">
                <div class="heading flex flex-col items-center text-center">
                    <div class="menu-tab bg-surface rounded-2xl">
                        <div class="menu flex items-center gap-2 p-1">
                            <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                            <div class="tab-item relative text-secondary heading5 py-2 px-5 cursor-pointer duration-500 hover:text-black active" data-item="best sellers">best sellers</div>
                            <div class="tab-item relative text-secondary heading5 py-2 px-5 cursor-pointer duration-500 hover:text-black" data-item="on sale">on sale</div>
                            <div class="tab-item relative text-secondary heading5 py-2 px-5 cursor-pointer duration-500 hover:text-black" data-item="new arrivals">new arrivals</div>
                        </div>
                    </div>
                </div>
                {{-- Dynamic from DB: use home-tab-products so main.js does not replace with Product.json --}}
                <div class="list-product home-tab-products hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 relative section-swiper-navigation style-outline style-small-border md:mt-10 mt-6" data-tab="best sellers">
                    @forelse($bestSellers->take(8) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-secondary">No products available</p>
                        </div>
                    @endforelse
                </div>
                <div class="list-product home-tab-products hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 relative section-swiper-navigation style-outline style-small-border md:mt-10 mt-6 hidden" data-tab="on sale">
                    @forelse($onSaleProducts->take(8) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-secondary">No products on sale</p>
                        </div>
                    @endforelse
                </div>
                <div class="list-product home-tab-products hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 relative section-swiper-navigation style-outline style-small-border md:mt-10 mt-6 hidden" data-tab="new arrivals">
                    @forelse($newArrivals->take(8) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-secondary">No new arrivals</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
        (function() {
            var section = document.getElementById('home-best-sellers-section');
            if (!section) return;
            var tabItems = section.querySelectorAll('.tab-item');
            var grids = section.querySelectorAll('.list-product.home-tab-products[data-tab]');
            function showTab(dataItem) {
                grids.forEach(function(g) {
                    g.classList.toggle('hidden', g.getAttribute('data-tab') !== dataItem);
                });
                tabItems.forEach(function(t) {
                    t.classList.toggle('active', t.getAttribute('data-item') === dataItem);
                });
            }
            tabItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    showTab(this.getAttribute('data-item'));
                });
            });
        })();
        </script>
        @endpush
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="benefit-block md:mt-20 mt-10 py-10 px-2.5 bg-surface rounded-3xl">
                <div class="list-benefit grid items-start lg:grid-cols-4 grid-cols-2 gap-[30px]">
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-phone-call lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">24/7 Customer Service</div>
                        <div class="caption1 text-secondary text-center mt-3">We're here to help you with any questions or concerns you have, 24/7.</div>
                    </div>
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-return lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">14-Day Money Back</div>
                        <div class="caption1 text-secondary text-center mt-3">If you're not satisfied with your purchase, simply return it within 14 days for a refund.</div>
                    </div>
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-guarantee lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">Our Guarantee</div>
                        <div class="caption1 text-secondary text-center mt-3">We stand behind our products and services and guarantee your satisfaction.</div>
                    </div>
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-delivery-truck lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">Shipping worldwide</div>
                        <div class="caption1 text-secondary text-center mt-3">We ship our products worldwide, making them accessible to customers everywhere.</div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.instagram-feed-slider')

        <!-- Modal Newsletter - hidden to prevent click/interference issues -->
        <div class="modal-newsletter" style="display: none !important; pointer-events: none !important;">
            <div class="container h-full flex items-center justify-center w-full">
                <div class="modal-newsletter-main">
                    <div class="main-content flex rounded-[20px] overflow-hidden w-full">
                        <div class="left lg:w-1/2 sm:w-2/5 max-sm:hidden bg-green flex flex-col items-center justify-center gap-5 py-14">
                            <div class="text-xs font-semibold uppercase text-center">Special Offer</div>
                            <div class="lg:text-[70px] text-4xl lg:leading-[78px] leading-[42px] font-bold uppercase text-center">Black<br />Fridays</div>
                            <div class="text-button-uppercase text-center">New customers save <span class="text-red">30%</span> with the code</div>
                            <div class="text-button-uppercase text-red bg-white py-2 px-4 rounded-lg">GET20off</div>
                            <div class="button-main w-fit bg-black text-white hover:bg-white uppercase">Copy coupon code</div>
                                </div>
                        <div class="right lg:w-1/2 sm:w-3/5 w-full bg-white sm:pt-10 sm:pl-10 max-sm:p-6 relative">
                            <div class="close-newsletter-btn w-10 h-10 flex items-center justify-center border border-line rounded-full absolute right-5 top-5 cursor-pointer">
                                <i class="ph-bold ph-x text-xl"></i>
                                </div>
                            <div class="heading5 pb-5">You May Also Like</div>
                            <div class="list overflow-x-auto sm:pr-6">
                                <div class="product-item item pb-5 flex items-center justify-between gap-3 border-b border-line" data-item="1">
                                    <div class="infor flex items-center gap-5">
                                        <div class="bg-img">
                                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                            </div>
                                        <div class="">
                                            <div class="name text-button">Faux-leather trousers</div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="product-price text-title">$15.00</div>
                                                <div class="product-origin-price text-title text-secondary2">
                                                    <del>$25.00</del>
                        </div>
                                </div>
                                </div>
                                </div>
                                    <div class="quick-view-btn button-main sm:py-3 py-2 sm:px-5 px-4 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                            </div>
                                <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="2">
                                    <div class="infor flex items-center gap-5">
                                        <div class="bg-img">
                                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                                </div>
                                        <div class="">
                                            <div class="name text-button">Faux-leather trousers</div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="product-price text-title">$15.00</div>
                                                <div class="product-origin-price text-title text-secondary2">
                                                    <del>$25.00</del>
                                </div>
                            </div>
                        </div>
                    </div>
                                    <div class="quick-view-btn button-main sm:py-3 py-2 sm:px-5 px-4 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                                </div>
                                <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="3">
                                    <div class="infor flex items-center gap-5">
                                        <div class="bg-img">
                                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                                </div>
                                        <div class="">
                                            <div class="name text-button">Faux-leather trousers</div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="product-price text-title">$15.00</div>
                                                <div class="product-origin-price text-title text-secondary2">
                                                    <del>$25.00</del>
                            </div>
                        </div>
                            </div>
                            </div>
                                    <div class="quick-view-btn button-main sm:py-3 py-2 sm:px-5 px-4 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                            </div>
                                <div class="product-item item py-5 flex items-center justify-between gap-3" data-item="4">
                                    <div class="infor flex items-center gap-5">
                                        <div class="bg-img">
                                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                            </div>
                                        <div class="">
                                            <div class="name text-button">Faux-leather trousers</div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="product-price text-title">$15.00</div>
                                                <div class="product-origin-price text-title text-secondary2">
                                                    <del>$25.00</del>
                            </div>
                            </div>
                        </div>
                    </div>
                                    <div class="quick-view-btn button-main sm:py-3 py-2 sm:px-5 px-4 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                </div>
            </div>
        </div>
        </div>

        {{-- Search modal is in layouts/app.blade.php --}}

        <div class="modal-wishlist-block">
            <div class="modal-wishlist-main py-6">
                <div class="heading px-6 pb-3 flex items-center justify-between relative">
                    <div class="heading5">Wishlist</div>
                    <div class="close-btn absolute right-6 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                        <i class="ph ph-x text-sm"></i>
                    </div>
                </div>
                <div class="list-product px-6"></div>
                <div class="footer-modal p-6 border-t bg-white border-line absolute bottom-0 left-0 w-full text-center">
                    <a href="{{{ route('shop') }}}" class="button-main w-full text-center uppercase"> View All Wish List</a>
                    <div class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">Or continue shopping</div>
                </div>
            </div>
        </div>

        <div class="modal-cart-block">
            <div class="modal-cart-main flex">
                <div class="left w-1/2 border-r border-line py-6 max-md:hidden">
                    <div class="heading5 px-6 pb-3">You May Also Like</div>
                    <div class="list px-6">
                        <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="1">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                        <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="2">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                        <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="3">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                        <div class="product-item item py-5 flex items-center justify-between gap-3" data-item="4">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg" />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                    </div>
                </div>
                <div class="right cart-block md:w-1/2 w-full py-6 relative overflow-hidden">
                    <div class="heading px-6 pb-3 flex items-center justify-between relative">
                        <div class="heading5">Shopping Cart</div>
                        <div class="close-btn absolute right-6 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                            <i class="ph ph-x text-sm"></i>
                        </div>
                    </div>
                    <!-- <div class="time countdown-cart px-6">
                        <div class="flex items-center gap-3 px-5 py-3 bg-green rounded-lg">
                            <p class="text-3xl">🔥</p>
                            <div class="caption1">
                                Your cart will expire in <span class="text-red caption1 font-semibold"><span class="minute">04</span>:<span class="second">59</span></span> minutes!<br />
                                Please checkout now before your items sell out!
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="heading banner mt-3 px-6">
                        <div class="text">
                            Buy <span class="text-button"> $<span class="more-price">150</span>.00 </span>
                            <span>more to get </span>
                            <span class="text-button">freeship</span>
                        </div>
                        <div class="tow-bar-block mt-3">
                            <div class="progress-line"></div>
                        </div>
                    </div> -->
                    <div class="list-product px-6"></div>
                    <div class="footer-modal bg-white absolute bottom-0 left-0 w-full">
                        <div class="flex items-center justify-center lg:gap-14 gap-8 px-6 py-4 border-b border-line">
                            <div class="note-btn item flex items-center gap-3 cursor-pointer">
                                <i class="ph ph-note-pencil text-xl"></i>
                                <div class="caption1">Note</div>
                            </div>
                            <div class="shipping-btn item flex items-center gap-3 cursor-pointer">
                                <i class="ph ph-truck text-xl"></i>
                                <div class="caption1">Shipping</div>
                            </div>
                            <div class="coupon-btn item flex items-center gap-3 cursor-pointer">
                                <i class="ph ph-tag text-xl"></i>
                                <div class="caption1">Coupon</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-6 px-6">
                            <div class="heading5">Subtotal</div>
                            <div class="heading5 total-cart">$0.00</div>
                        </div>
                        <div class="block-button text-center p-6">
                            <div class="flex items-center gap-4">
                                <a href="{{{ route('shop') }}}" class="button-main basis-1/2 bg-white border border-black text-black text-center uppercase"> View cart </a>
                                <a href="{{{ route('shop') }}}" class="button-main basis-1/2 text-center uppercase"> Check Out </a>
                            </div>
                            <div class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">Or continue shopping</div>
                        </div>
                        <div class="tab-item note-block">
                            <div class="px-6 py-4 border-b border-line">
                                <div class="item flex items-center gap-3 cursor-pointer">
                                    <i class="ph ph-note-pencil text-xl"></i>
                                    <div class="caption1">Note</div>
                                </div>
                            </div>
                            <div class="form pt-4 px-6">
                                <textarea name="form-note" id="form-note" rows="4" placeholder="Add special instructions for your order..." class="caption1 py-3 px-4 bg-surface border-line rounded-md w-full"></textarea>
                            </div>
                            <div class="block-button text-center pt-4 px-6 pb-6">
                                <div class="button-main w-full text-center">Save</div>
                                <div class="cancel-btn text-button-uppercase mt-4 text-center has-line-before cursor-pointer inline-block">Cancel</div>
                            </div>
                        </div>
                        <div class="tab-item shipping-block">
                            <div class="px-6 py-4 border-b border-line">
                                <div class="item flex items-center gap-3 cursor-pointer">
                                    <i class="ph ph-truck text-xl"></i>
                                    <div class="caption1">Estimate shipping rates</div>
                                </div>
                            </div>
                            <div class="form pt-4 px-6">
                                <div class="">
                                    <label for="select-country" class="caption1 text-secondary">Country/region</label>
                                    <div class="select-block relative mt-2">
                                        <select id="select-country" name="select-country" class="w-full py-3 pl-5 rounded-xl bg-white border border-line">
                                            <option value="Country/region">Country/region</option>
                                            <option value="France">France</option>
                                            <option value="Spain">Spain</option>
                                            <option value="UK">UK</option>
                                            <option value="USA">USA</option>
                                        </select>
                                        <i class="ph ph-caret-down text-xs absolute top-1/2 -translate-y-1/2 md:right-5 right-2"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="select-state" class="caption1 text-secondary">State</label>
                                    <div class="select-block relative mt-2">
                                        <select id="select-state" name="select-state" class="w-full py-3 pl-5 rounded-xl bg-white border border-line">
                                            <option value="State">State</option>
                                            <option value="Paris">Paris</option>
                                            <option value="Madrid">Madrid</option>
                                            <option value="London">London</option>
                                            <option value="New York">New York</option>
                                        </select>
                                        <i class="ph ph-caret-down text-xs absolute top-1/2 -translate-y-1/2 md:right-5 right-2"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="select-code" class="caption1 text-secondary">Postal/Zip Code</label>
                                    <input class="border-line px-5 py-3 w-full rounded-xl mt-3" id="select-code" type="text" placeholder="Postal/Zip Code" />
                                </div>
                            </div>
                            <div class="block-button text-center pt-4 px-6 pb-6">
                                <div class="button-main w-full text-center">Calculator</div>
                                <div class="cancel-btn text-button-uppercase mt-4 text-center has-line-before cursor-pointer inline-block">Cancel</div>
                            </div>
                        </div>
                        <div class="tab-item coupon-block">
                            <div class="px-6 py-4 border-b border-line">
                                <div class="item flex items-center gap-3 cursor-pointer">
                                    <i class="ph ph-tag text-xl"></i>
                                    <div class="caption1">Add A Coupon Code</div>
                                </div>
                            </div>
                            <div class="form pt-4 px-6">
                                <div class="">
                                    <label for="select-discount" class="caption1 text-secondary">Enter Code</label>
                                    <input class="border-line px-5 py-3 w-full rounded-xl mt-3" id="select-discount" type="text" placeholder="Discount code" />
                                </div>
                            </div>
                            <div class="block-button text-center pt-4 px-6 pb-6">
                                <div class="button-main w-full text-center">Apply</div>
                                <div class="cancel-btn text-button-uppercase mt-4 text-center has-line-before cursor-pointer inline-block">Cancel</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-sizeguide-block">
            <div class="modal-sizeguide-main md:p-10 p-6 rounded-[32px]">
                <div class="close-btn absolute right-5 top-5 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                    <i class="ph ph-x text-sm"></i>
                </div>
                <div class="heading3">Size guide</div>
                <div class="md:mt-8 mt-6 progress">
                    <div class="flex md:items-center gap-10 justify-between max-md:flex-col gap-y-5 max-md:pr-3">
                        <div class="flex items-center flex-shrink-0 gap-8">
                            <span class="flex-shrink-0 md:w-14">Height</span>
                            <div class="flex items-center justify-center w-20 gap-1 py-2 border border-line rounded-lg flex-shrink-0">
                                <span class="height">200</span>
                                <span class="caption1 text-secondary">Cm</span>
                            </div>
                        </div>
                        <div class="filter-price filter-height w-full">
                            <div class="tow-bar-block">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input class="range-max" type="range" min="0" max="200" value="200" />
                            </div>
                        </div>
                    </div>
                    <div class="flex md:items-center gap-10 justify-between max-md:flex-col gap-y-5 max-md:pr-3 mt-5">
                        <div class="flex items-center gap-8 flex-shrink-0">
                            <span class="flex-shrink-0 md:w-14">Weight</span>
                            <div class="flex items-center justify-center w-20 gap-1 py-2 border border-line rounded-lg flex-shrink-0">
                                <span class="weight">90</span>
                                <span class="caption1 text-secondary">Kg</span>
                            </div>
                        </div>
                        <div class="filter-price filter-weight w-full">
                            <div class="tow-bar-block">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input class="range-max" type="range" min="0" max="90" value="90" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="heading6 mt-8">suggests for you:</div>
                <div class="list-size-block flex items-center gap-2 flex-wrap mt-3">
                    <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">XS</div>
                    <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">S</div>
                    <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">M</div>
                    <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">L</div>
                    <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">XL</div>
                    <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">2XL</div>
                </div>
                <table>
                    <tr>
                        <th>Size</th>
                        <th>Bust</th>
                        <th>Waist</th>
                        <th>Low Hip</th>
                    </tr>
                    <tr>
                        <td>XS</td>
                        <td>32</td>
                        <td>24-25</td>
                        <td>33-34</td>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>34-35</td>
                        <td>26-27</td>
                        <td>35-36</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>36-37</td>
                        <td>28-29</td>
                        <td>38-40</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>38-39</td>
                        <td>30-31</td>
                        <td>42-44</td>
                    </tr>
                    <tr>
                        <td>XL</td>
                        <td>40-41</td>
                        <td>32-33</td>
                        <td>45-47</td>
                    </tr>
                    <tr>
                        <td>2XL</td>
                        <td>42-43</td>
                        <td>34-35</td>
                        <td>48-50</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="modal-compare-block">
            <div class="modal-compare-main py-6">
                <div class="close-btn absolute 2xl:right-6 right-4 2xl:top-6 md:-top-4 top-3 lg:w-10 w-6 lg:h-10 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                    <i class="ph ph-x body1"></i>
                </div>
                <div class="container h-full flex items-center w-full">
                    <div class="content-main flex items-center justify-between xl:gap-10 gap-6 w-full max-md:flex-wrap">
                        <div class="heading5 flex-shrink-0 max-md:w-full">Compare <br class="max-md:hidden" />Products</div>
                        <div class="list-product flex items-center w-full gap-4"></div>
                        <div class="block-button flex flex-col gap-4 flex-shrink-0">
                            <a href="{{{ route('shop') }}}" class="button-main whitespace-nowrap"> Compare Products</a>
                            <div class="button-main clear whitespace-nowrap border border-black bg-white text-black">Clear All Products</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-quickview-block">
            <div class="modal-quickview-main py-6">
                <div class="flex h-full max-md:flex-col-reverse gap-y-6">
                    <div class="left lg:w-[388px] md:w-[300px] flex-shrink-0 px-6">
                        <div class="list-img max-md:flex items-center gap-4">
                            <div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                            </div>
                            <div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                            </div>
                            <div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                            </div>
                            <div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>
                    <div class="right w-full px-6">
                        <div class="heading pb-6 flex items-center justify-between relative">
                            <div class="heading5">Quick View</div>
                            <div class="close-btn absolute right-0 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                                <i class="ph ph-x text-sm"></i>
                            </div>
                        </div>
                        <div class="product-infor">
                            <div class="flex justify-between">
                                <div>
                                    <div class="category caption2 text-secondary font-semibold uppercase">fashion</div>
                                    <div class="name heading4 mt-1">Off-the-Shoulder Blouse</div>
                                </div>
                                <div class="add-wishlist-btn w-10 h-10 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white">
                                    <i class="ph ph-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 mt-3">
                                <div class="rate flex">
                                    <i class="ph-fill ph-star text-sm text-yellow"></i>
                                    <i class="ph-fill ph-star text-sm text-yellow"></i>
                                    <i class="ph-fill ph-star text-sm text-yellow"></i>
                                    <i class="ph-fill ph-star text-sm text-yellow"></i><i class="ph-fill ph-star text-sm text-yellow"></i>
                                </div>
                                <span class="caption1 text-secondary">(1.234 reviews)</span>
                            </div>
                            <div class="flex items-center gap-1 gap-y-3 flex-wrap mt-3">
                                <div class="text-xs font-semibold bg-black text-white uppercase py-1 px-3 rounded-full">best seller</div>
                                <div class="flex items-center gap-1">
                                    <i class="ph-fill ph-lightning text-red text-xl"></i>
                                    <div class="caption1 text-secondary">Selling fast! 22 people have this in their carts.</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                                <div class="product-price heading5">$20.00</div>
                                <div class="w-px h-4 bg-line"></div>
                                <div class="product-origin-price font-normal text-secondary2">
                                    <del>$32.00</del>
                                </div>
                                <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full">-19%</div>
                                <div class="desc text-secondary mt-3">Keep your clothes organized, yet elegant with storage cabinets by Onita Patio Furniture. Traditionally designed, they are perfect to be used in the any place where you need to store.</div>
                            </div>
                            <div class="list-action mt-6">
                                <div class="choose-color">
                                    <div class="text-title">Colors: <span class="text-title color"></span></div>
                                    <div class="list-color flex items-center gap-2 flex-wrap mt-3">
                                        <div class="color-item w-12 h-12 rounded-xl duration-300 relative active">
                                            <img src="{{ asset('assets/images/product/color/48x48.png') }}" alt="color" class="rounded-xl" />
                                            <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">blue</div>
                                        </div>
                                        <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                            <img src="{{ asset('assets/images/product/color/48x48.png') }}" alt="color" class="rounded-xl" />
                                            <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">red</div>
                                        </div>
                                        <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                            <img src="{{ asset('assets/images/product/color/48x48.png') }}" alt="color" class="rounded-xl" />
                                            <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">black</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="choose-size mt-5">
                                    <div class="heading flex items-center justify-between">
                                        <div class="text-title">Size: <span class="text-title size"></span></div>
                                        <div class="caption1 size-guide text-red underline">Size Guide</div>
                                    </div>
                                    <div class="list-size flex items-center gap-2 flex-wrap mt-3">
                                        <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">S</div>
                                        <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line active">M</div>
                                        <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">L</div>
                                        <div class="size-item w-12 h-12 flex items-center justify-center text-button rounded-full bg-white border border-line">XL</div>
                                    </div>
                                </div>
                                <div class="text-title mt-5">Quantity:</div>
                                <div class="choose-quantity flex items-center flex-wrap lg:justify-between gap-5 mt-3">
                                    <div class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[180px] w-[120px] flex-shrink-0">
                                        <i class="ph-bold ph-minus cursor-pointer body1"></i>
                                        <input type="number" min="1" max="9999" step="1" value="1" inputmode="numeric" aria-label="Quantity" class="quantity body1 font-semibold w-12 min-w-[3rem] text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" />
                                        <i class="ph-bold ph-plus cursor-pointer body1"></i>
                                    </div>
                                    <div class="add-cart-btn button-main w-full text-center bg-white text-black border border-black">Add To Cart</div>
                                </div>
                                <div class="button-block mt-5">
                                    <a href="{{{ route('shop') }}}" class="button-main w-full text-center">Buy It Now</a>
                                </div>
                            </div>
                            <div class="flex items-center flex-wrap lg:gap-20 gap-8 gap-y-4 mt-5">
                                <div class="compare flex items-center gap-3 cursor-pointer">
                                    <div class="compare-btn md:w-12 md:h-12 w-10 h-10 flex items-center justify-center border border-line cursor-pointer rounded-xl duration-300 hover:bg-black hover:text-white">
                                        <i class="ph-fill ph-arrows-counter-clockwise cursor-pointer heading6"></i>
                                    </div>
                                    <span>Compare</span>
                                </div>
                                <div class="share flex items-center gap-3 cursor-pointer">
                                    <div class="share-btn md:w-12 md:h-12 w-10 h-10 flex items-center justify-center border border-line cursor-pointer rounded-xl duration-300 hover:bg-black hover:text-white">
                                        <i class="ph-fill ph-share-network cursor-pointer heading6"></i>
                                    </div>
                                    <span>Share Products</span>
                                </div>
                            </div>
                            <div class="more-infor mt-6">
                                <div class="flex items-center gap-4 flex-wrap">
                                    <div class="flex items-center gap-1">
                                        <i class="ph ph-arrow-clockwise cursor-pointer body1"></i>
                                        <div class="text-title">Delivery & Return</div>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="ph ph-question cursor-pointer body1"></i>
                                        <div class="text-title">Ask A Question</div>
                                    </div>
                                </div>
                                <div class="flex items-center flex-wrap gap-1 mt-3">
                                    <i class="ph ph-timer cursor-pointer body1"></i>
                                    <span class="text-title">Estimated Delivery:</span>
                                    <span class="text-secondary">14 January - 18 January</span>
                                </div>
                                <div class="flex items-center flex-wrap gap-1 mt-3">
                                    <i class="ph ph-eye cursor-pointer body1"></i>
                                    <span class="text-title">38</span>
                                    <span class="text-secondary">people viewing this product right now!</span>
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <div class="text-title">SKU:</div>
                                    <div class="text-secondary">53453412</div>
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <div class="text-title">Categories:</div>
                                    <div class="list-category text-secondary">fashion, women</div>
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <div class="text-title">Tag:</div>
                                    <div class="list-tag text-secondary">dress</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>{{-- /#home-content --}}
@endsection
