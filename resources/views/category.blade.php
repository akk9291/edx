@extends('layouts.app')

@section('title', ($category ? $category->name : 'Category') . ' - Perch Bottle')

@section('content')
<div class="list-banner sm:-mt-[75px]">
    <div class="banner-img w-full">
        <img src="{{ asset('assets/images/slider/11b-scaled.webp') }}" alt="bg-img" class="w-full duration-500" />
    </div>
    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category ? $category->name : 'Category' }}</div>
    <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
</div>

<div class="banner-block relative">
    <div class="list-banner">
        <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block overflow-hidden duration-500">
            <div class="banner-img w-full">
                <img src="{{ asset('assets/images/slider/09-1-scaled.webp') }}" alt="bg-img" class="w-full duration-500" />
            </div>
            <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category ? $category->name : 'Category' }}</div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
        </a>
    </div>
</div>
<div class="collection-block mt-5">
    <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
        <div class="banner-block md:pt-20 pt-10">
            <div class="container">
                <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                    <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset('assets/images/product/Bottle-1.webp') }}" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Drinkware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset('assets/images/product/Bottle-4.webp') }}" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Barware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset('assets/images/product/Bottle-8.webp') }}" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Kichenware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset('assets/images/product/Bottle-1.webp') }}" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Drinkware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset('assets/images/product/Bottle-4.webp') }}" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Barware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset('assets/images/product/Bottle-8.webp') }}" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Kichenware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="quote-block bg-linear py-[60px] mt-10">
    <div class="container flex items-center justify-center">
        <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face."</div>
    </div>
</div>

<div class="banner-block relative">
    <div class="list-banner">
        <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block overflow-hidden duration-500">
            <div class="banner-img w-full">
                <img src="{{ asset('assets/images/slider/03b-scaled.webp') }}" alt="bg-img" class="w-full duration-500" />
            </div>
            <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category ? $category->name : 'Category' }}</div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
        </a>
    </div>
</div>

<div class="what-new-block filter-product-block md:pt-20 pt-10">
    <div class="container">
        <div class="heading flex flex-col items-center text-center">
            <div class="heading3">What's new</div>
            <div class="menu-tab bg-surface rounded-2xl mt-6">
                <div class="menu flex items-center gap-2 p-1">
                    <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                    <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="top">top</div>
                    <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black active" data-item="t-shirt">t-shirt</div>
                    <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="dress">dress</div>
                    <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="sets">sets</div>
                    <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="shirt">shirt</div>
                </div>
            </div>
        </div>
        <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
            <div class="product-item grid-type" data-item="1">
                <div class="product-main cursor-pointer block">
                    <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                        <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
                        <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                            <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                <i class="ph ph-heart text-lg"></i>
                            </div>
                            <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                <i class="ph ph-check-circle text-lg checked-icon"></i>
                            </div>
                        </div>
                        <div class="product-img w-full h-full aspect-[3/4]">
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                        </div>
                        <div class="countdown-time-block py-1.5 flex items-center justify-center">
                            <div class="text-xs font-semibold uppercase text-red">
                                <span class="countdown-day">24</span>
                                <span>D : </span>
                                <span class="countdown-hour">14</span>
                                <span>H : </span>
                                <span class="countdown-minute">36</span>
                                <span>M : </span>
                                <span class="countdown-second">51</span>
                                <span>S</span>
                            </div>
                        </div>
                        <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                            <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                <span class="max-lg:hidden">Quick View</span>
                                <i class="ph ph-eye lg:hidden text-xl"></i>
                            </div>
                            <div class="quick-shop-btn text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white max-lg:hidden">Quick Shop</div>
                            <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white lg:hidden">
                                <span class="max-lg:hidden">Add To Cart</span>
                                <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                            </div>
                            <div class="quick-shop-block absolute left-5 right-5 bg-white p-5 rounded-[20px]">
                                <div class="list-size flex items-center justify-center flex-wrap gap-2">
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">S</div>
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">M</div>
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">L</div>
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">XL</div>
                                </div>
                                <div class="add-cart-btn button-main w-full text-center rounded-full py-3 mt-4">Add To cart</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-infor mt-4 lg:mb-7">
                        <div class="product-sold sm:pb-4 pb-2">
                            <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                            </div>
                            <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                    <span class="max-sm:text-xs">24</span>
                                </div>
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                    <span class="max-sm:text-xs">96</span>
                                </div>
                            </div>
                        </div>
                        <div class="product-name text-title duration-300">Raglan Sleeve T-shirt</div>

                        <div class="list-color list-color-image max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                            <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                            </div>
                            <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                            </div>
                            <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                            </div>
                        </div>

                        <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                            <div class="product-price text-title">₹30.00</div>
                            <div class="product-origin-price caption1 text-secondary2">
                                <del>₹42.00</del>
                            </div>
                            <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-30%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-item grid-type" data-item="3">
                <div class="product-main cursor-pointer block">
                    <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                        <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
                        <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                            <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                <i class="ph ph-heart text-lg"></i>
                            </div>
                            <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                <i class="ph ph-check-circle text-lg checked-icon"></i>
                            </div>
                        </div>
                        <div class="product-img w-full h-full aspect-[3/4]">
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                        </div>
                        <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                            <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                <span class="max-lg:hidden">Quick View</span>
                                <i class="ph ph-eye lg:hidden text-xl"></i>
                            </div>
                            <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                <span class="max-lg:hidden">Add To Cart</span>
                                <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-infor mt-4 lg:mb-7">
                        <div class="product-sold sm:pb-4 pb-2">
                            <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                            </div>
                            <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                    <span class="max-sm:text-xs">12</span>
                                </div>
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                    <span class="max-sm:text-xs">88</span>
                                </div>
                            </div>
                        </div>
                        <div class="product-name text-title duration-300">Off-the-Shoulder Blouse</div>
                        <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                            <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                            </div>
                            <div class="color-item bg-yellow w-8 h-8 rounded-full duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">yellow</div>
                            </div>
                            <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">green</div>
                            </div>
                        </div>

                        <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                            <div class="product-price text-title">₹40.00</div>
                            <div class="product-origin-price caption1 text-secondary2">
                                <del>₹50.00</del>
                            </div>
                            <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-item grid-type" data-item="4">
                <div class="product-main cursor-pointer block">
                    <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                        <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
                        <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                            <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                <i class="ph ph-heart text-lg"></i>
                            </div>
                            <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                <i class="ph ph-check-circle text-lg checked-icon"></i>
                            </div>
                        </div>
                        <div class="product-img w-full h-full aspect-[3/4]">
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                        </div>
                        <div class="countdown-time-block py-1.5 flex items-center justify-center">
                            <div class="text-xs font-semibold uppercase text-red">
                                <span class="countdown-day">24</span>
                                <span>D : </span>
                                <span class="countdown-hour">14</span>
                                <span>H : </span>
                                <span class="countdown-minute">36</span>
                                <span>M : </span>
                                <span class="countdown-second">51</span>
                                <span>S</span>
                            </div>
                        </div>
                        <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                            <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                <span class="max-lg:hidden">Quick View</span>
                                <i class="ph ph-eye lg:hidden text-xl"></i>
                            </div>
                            <div class="quick-shop-btn text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white max-lg:hidden">Quick Shop</div>
                            <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white lg:hidden">
                                <span class="max-lg:hidden">Add To Cart</span>
                                <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                            </div>
                            <div class="quick-shop-block absolute left-5 right-5 bg-white p-5 rounded-[20px]">
                                <div class="list-size flex items-center justify-center flex-wrap gap-2">
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">S</div>
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">M</div>
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">L</div>
                                    <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">XL</div>
                                </div>
                                <div class="add-cart-btn button-main w-full text-center rounded-full py-3 mt-4">Add To cart</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-infor mt-4 lg:mb-7">
                        <div class="product-sold sm:pb-4 pb-2">
                            <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                            </div>
                            <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                    <span class="max-sm:text-xs">24</span>
                                </div>
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                    <span class="max-sm:text-xs">96</span>
                                </div>
                            </div>
                        </div>
                        <div class="product-name text-title duration-300">Raglan Sleeve T-shirt</div>
                        <div class="list-color list-color-image max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                            <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                            </div>
                            <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                            </div>
                            <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                            </div>
                        </div>

                        <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                            <div class="product-price text-title">₹30.00</div>
                            <div class="product-origin-price caption1 text-secondary2">
                                <del>₹42.00</del>
                            </div>
                            <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-30%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-item grid-type" data-item="5">
                <div class="product-main cursor-pointer block">
                    <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                        <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
                        <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                            <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                <i class="ph ph-heart text-lg"></i>
                            </div>
                            <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                <i class="ph ph-check-circle text-lg checked-icon"></i>
                            </div>
                        </div>
                        <div class="product-img w-full h-full aspect-[3/4]">
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                            <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                        </div>
                        <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                            <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                <span class="max-lg:hidden">Quick View</span>
                                <i class="ph ph-eye lg:hidden text-xl"></i>
                            </div>
                            <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                <span class="max-lg:hidden">Add To Cart</span>
                                <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="product-infor mt-4 lg:mb-7">
                        <div class="product-sold sm:pb-4 pb-2">
                            <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                            </div>
                            <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                    <span class="max-sm:text-xs">12</span>
                                </div>
                                <div class="text-button-uppercase">
                                    <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                    <span class="max-sm:text-xs">88</span>
                                </div>
                            </div>
                        </div>
                        <div class="product-name text-title duration-300">Off-the-Shoulder Blouse</div>
                        <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                            <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                            </div>
                            <div class="color-item bg-yellow w-8 h-8 rounded-full duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">yellow</div>
                            </div>
                            <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">green</div>
                            </div>
                        </div>

                        <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                            <div class="product-price text-title">₹40.00</div>
                            <div class="product-origin-price caption1 text-secondary2">
                                <del>₹50.00</del>
                            </div>
                            <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="banner-block style-toys-kids">
    <div class="container">
        <div class="content md:rounded-[28px] rounded-2xl overflow-hidden relative">
            <img src="{{ asset('assets/images/banner/bg-banner-toys.png') }}" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover z-[-1]" />
            <div class="text-content xl:w-1/3 w-2/3 xl:pl-[120px] md:pl-20 pl-10 md:py-[85px] py-12">
                <div class="text-sub-display">Sale Up To 50% Off Today!</div>
                <div class="heading2 md:mt-4 mt-2">Created to be loved for a lifetime</div>
                <a href="{{{ route('shop') }}}" class="button-main md:mt-7 mt-3">Shop Now</a>
            </div>
        </div>
    </div>
</div>

<div class="banner-block pt-5 px-5">
    <div class="container">
        <div class="list-banner grid lg:grid-cols-2 sm:grid-cols-2 gap-[20px]">
                <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ asset('assets/images/banner/perch123(2).webp') }}" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="banner-content absolute left-[30px] bottom-[30px]">
                        <div class="heading4">Check &amp; Coutour</div>
                        <div class="text-button text-black relative inline-block pb-1 border-b-2 border-black duration-500 mt-2">Shop Now</div>
                    </div>
                </a>
                <a href="{{{ route('shop') }}}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ asset('assets/images/banner/perch123(2).webp') }}" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="banner-content absolute left-[30px] bottom-[30px]">
                        <div class="heading4">{{ $category ? $category->name : 'Category' }}</div>
                        <div class="text-button text-black relative inline-block pb-1 border-b-2 border-black duration-500 mt-2">Shop Now</div>
                    </div>
                </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="slider-item slick-slide slick-current slick-active">
        <div class="bg-[#EBFCF5] h-full w-full relative flex max-sm:flex-col-reverse items-center lg:rounded-[40px] rounded-xl overflow-hidden mt-10">
            <img src="{{ asset('assets/images/slider/bg-toys.png') }}" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover" />
            <div class="text-content sm:w-1/3 max-sm:pt-10 max-sm:pb-[40px] flex flex-col items-center justify-center z-[1]">
                <div class="text-sub-display">Sale! Up To 50% Off!</div>
                <div class="heading1 text-center md:mt-4 mt-2">Perch Bottle <br class="max-xl:hidden">on sale</div>
                <a href="{{{ route('shop') }}}" class="button-main md:mt-8 mt-3" tabindex="0">Shop Now</a>
            </div>
            <div class="sub-img sm:w-2/3 w-full h-full sm:pl-10">
                <img src="{{ asset('assets/images/banner/perch123(1).webp') }}" alt="bg-toys1" class="w-full h-full object-cover z-[1] relative" />
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

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching for product types
    const tabItems = document.querySelectorAll('.tab-item[data-item]');
    const indicator = document.querySelector('.indicator');
    
    if (tabItems.length > 0 && indicator) {
        tabItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                const type = this.getAttribute('data-item');
                
                // Update active tab
                tabItems.forEach(tab => tab.classList.remove('active'));
                this.classList.add('active');
                
                // Move indicator
                const itemWidth = 100 / tabItems.length;
                indicator.style.left = (index * itemWidth) + '%';
                indicator.style.width = itemWidth + '%';
                
                // Filter products
                if (typeof window.categorySlug !== 'undefined') {
                    window.location.href = '{{{ route("category", $category->slug ?? "") }}}?type=' + type;
                }
            });
        });
    }
    
    // Brand block now shows single logo (no swiper)
    if (typeof Swiper !== 'undefined') {
        const brandSwiper = document.querySelector('.swiper-list-brand');
        if (brandSwiper) {
            new Swiper('.swiper-list-brand', {
                slidesPerView: 'auto',
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                    1280: {
                        slidesPerView: 6,
                    },
                },
            });
        }
    }
});
</script>
@endsection
