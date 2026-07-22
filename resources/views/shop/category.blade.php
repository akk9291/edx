@extends('layouts.app')

@section('title', ($category->name ?? 'Category') . ' - Perch Bottle')

@section('content')
            <div class="list-banner sm:-mt-[75px] relative">
                @php
                    $heroImage = $category->hero_image ?? ($mainCategory->hero_image ?? null);
                    $heroText = $category->hero_text ?? ($mainCategory->hero_text ?? null);
                    $heroButtonText = $category->hero_button_text ?? ($mainCategory->hero_button_text ?? 'Shop Now');
                @endphp
                @if($heroImage)
                    <div class="banner-img w-full">
                        <img src="{{ storage_asset($heroImage) }}" alt="{{ $category->name }}" class="w-full duration-500">
                    </div>
                @else
                    <div class="banner-img w-full">
                        <img src="{{ asset('assets/images/slider/11b-scaled.webp') }}" alt="bg-img" class="w-full duration-500">
                    </div>
                @endif
                <div class="absolute bottom-0 left-0 right-0 flex flex-col items-center justify-end gap-5 pb-8 pt-8 z-10 pointer-events-none">
                    <div class="pointer-events-auto order-1">
                @if($heroText)
                    <div class="heading4 text-center whitespace-normal max-w-2xl px-4">{{ $heroText }}</div>
                @else
                    <div class="heading4 text-center whitespace-nowrap">{{ $category->name }}</div>
                @endif
                    </div>
                    <a href="{{ route('shop') }}" class="pointer-events-auto button-main order-2">{{ $heroButtonText }}</a>
                </div>
            </div>

        {{-- Category products (main listing) --}}
        <!-- <div class="shop-product breadcrumb1 lg:py-20 md:py-14 py-10">
            <div class="container">
                <div class="mb-8">
                    <h2 class="heading3">{{ $category->name }}</h2>
                    <p class="text-secondary mt-1">Showing {{ $products->total() }} product(s)</p>
                </div>
                <div class="list-product hide-product-sold grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 md:gap-[30px] gap-4">
                    @forelse($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-16">
                            <p class="text-secondary body1">No products in this category.</p>
                            <a href="{{ route('shop') }}" class="button-main mt-4 inline-block">Browse Shop</a>
                        </div>
                    @endforelse
                </div>
                @if($products->hasPages())
                    <div class="list-pagination w-full flex items-center justify-center gap-4 mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div> -->

        @php
            $additionalBannerImage = $category->additional_banner_image ?? ($mainCategory->additional_banner_image ?? null);
            $additionalBannerText = $category->additional_banner_text ?? ($mainCategory->additional_banner_text ?? null);
        @endphp
        <div class="banner-block relative">
            <div class="list-banner">
                <a href="{{ route('category', $category->slug) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        @if($additionalBannerImage)
                            <img src="{{ storage_asset($additionalBannerImage) }}" alt="{{ $additionalBannerText ?? $category->name }}" class="w-full duration-500">
                        @else
                            <img src="{{ asset('assets/images/slider/09-1-scaled.webp') }}" alt="bg-img" class="w-full duration-500">
                        @endif
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 flex flex-col items-center gap-4 pb-8 pt-6 z-10">
                        @if($additionalBannerText)
                            <div class="heading4 text-center whitespace-nowrap">{{ $additionalBannerText }}</div>
                        @else
                            <div class="heading4 text-center whitespace-nowrap">{{ $category->name }}</div>
                        @endif
                        <span class="button-main">{{ $heroButtonText }}</span>
                    </div>
                </a>
            </div>
        </div>
        @php
            $subCategoriesList = $subCategories ?? collect();
        @endphp
        <div class="collection-block mt-5">
            <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
                <div class="banner-block md:pt-20 pt-10">
                    <div class="container">
                        @if($subCategoriesList->isNotEmpty())
                            <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                                @foreach($subCategoriesList as $subCat)
                                    @php
                                        $subImage = $subCat->image ? storage_asset($subCat->image) : asset('assets/images/product/Bottle-1.webp');
                                    @endphp
                                    <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                        <div class="banner-img w-full">
                                            <img src="{{ $subImage }}" alt="{{ $subCat->name }}" class="w-full aspect-[4/5] object-cover duration-500">
                                        </div>
                                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $subCat->name }}</div>
                                        <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">{{ $heroButtonText ?? 'Shop Now' }}</a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- No sub-categories: show sibling categories of same main category if any --}}
                            @php
                                $siblingCategories = $mainCategory
                                    ? \App\Models\Category::where('is_active', true)->where('main_category_id', $mainCategory->id)->where('parent_id', $category->parent_id)->where('id', '!=', $category->id)->orderBy('sort_order')->get()
                                    : collect();
                            @endphp
                            @if($siblingCategories->isNotEmpty())
                                <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                                    @foreach($siblingCategories->take(3) as $sibCat)
                                        @php $sibImage = $sibCat->image ? storage_asset($sibCat->image) : asset('assets/images/product/Bottle-1.webp'); @endphp
                                        <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                            <div class="banner-img w-full">
                                                <img src="{{ $sibImage }}" alt="{{ $sibCat->name }}" class="w-full aspect-[4/5] object-cover duration-500">
                                            </div>
                                            <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $sibCat->name }}</div>
                                            <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">{{ $heroButtonText ?? 'Shop Now' }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @php
            $testimonialText = $category->testimonial_text ?? ($mainCategory->testimonial_text ?? null);
            $defaultTestimonial = "I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face.";
        @endphp
        <div class="quote-block bg-linear py-[60px] mt-10">
            <div class="container flex items-center justify-center">
                <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"{{ $testimonialText ?? $defaultTestimonial }}"</div>
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
                        if (slug === 'all' || cat === slug) { w.style.display = ''; } else { w.style.display = 'none'; }
                    });
                });
            });
        })();
        </script>
        @endpush

        <div class="banner-block relative">
            <div class="list-banner">
                <a href="{{ route('category', $category->slug) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        @php
                            $middleBannerImage = $category->additional_banner_image ?? ($mainCategory->additional_banner_image ?? null);
                        @endphp
                        @if($middleBannerImage)
                            <img src="{{ storage_asset($middleBannerImage) }}" alt="{{ $category->name }}" class="w-full duration-500">
                        @else
                            <img src="{{ asset('assets/images/slider/03b-scaled.webp') }}" alt="bg-img" class="w-full duration-500">
                        @endif
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category->name }}</div>
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 button-main">{{ $heroButtonText }}</div>
                </a>
            </div>
        </div>

        @php
            $bottomBannerImage = $category->bottom_banner_image ?? ($mainCategory->bottom_banner_image ?? null);
            $bottomBannerText = $category->bottom_banner_text ?? ($mainCategory->bottom_banner_text ?? null);
        @endphp
        <div class="banner-block style-toys-kids">
            <div class="container">
                <div class="content md:rounded-[28px] rounded-2xl overflow-hidden relative">
                    @if($bottomBannerImage)
                        <img src="{{ storage_asset($bottomBannerImage) }}" alt="{{ $category->name }}" class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
                    @else
                        <img src="{{ asset('assets/images/banner/bg-banner-toys.png') }}" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
                    @endif
                    <div class="text-content xl:w-1/3 w-2/3 xl:pl-[120px] md:pl-20 pl-10 md:py-[85px] py-12">
                        @if($bottomBannerText)
                            <div class="heading2 md:mt-4 mt-2">{{ $bottomBannerText }}</div>
                        @else
                            <div class="text-sub-display">Sale Up To 50% Off Today!</div>
                            <div class="heading2 md:mt-4 mt-2">Created to be loved for a lifetime</div>
                        @endif
                        <a href="{{ route('category', $category->slug) }}" class="button-main md:mt-7 mt-3">{{ $heroButtonText }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner-block pt-5 px-5">
            <div class="container">
                <div class="list-banner grid lg:grid-cols-2 sm:grid-cols-2 gap-[20px]">
                    @php
                        $twoBannerImages = [];
                        $twoBannerTexts = [];
                        if (!empty($bannerImages) && count($bannerImages) >= 2) {
                            $twoBannerImages = [$bannerImages[0], $bannerImages[1]];
                            $twoBannerTexts = [
                                !empty($bannerTexts[0]) ? $bannerTexts[0] : 'Check & Coutour',
                                !empty($bannerTexts[1]) ? $bannerTexts[1] : $category->name
                            ];
                        } else {
                            $twoBannerImages = [
                                asset('assets/images/banner/perch123(2).webp'),
                                asset('assets/images/banner/perch123(2).webp')
                            ];
                            $twoBannerTexts = ['Check & Coutour', $category->name];
                        }
                    @endphp
                    @for($i = 0; $i < 2; $i++)
                        <div class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                            <div class="banner-img w-full">
                                @if(!empty($bannerImages) && count($bannerImages) >= 2 && !empty($bannerImages[$i]))
                                    <img src="{{ storage_asset($bannerImages[$i] ?? null) }}" alt="{{ $twoBannerTexts[$i] }}" class="w-full duration-500">
                                @else
                                    <img src="{{ $twoBannerImages[$i] }}" alt="{{ $twoBannerTexts[$i] }}" class="w-full duration-500">
                                @endif
                            </div>
                            <div class="banner-content absolute left-[30px] bottom-[30px]">
                                <div class="heading4">{{ $twoBannerTexts[$i] }}</div>
                                <a href="{{ route('shop') }}" class="text-button text-black relative inline-block pb-1 border-b-2 border-black duration-500 mt-2">Shop Now</a>
                            </div>
                        </div>
                    @endfor
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
                        <a href="{{ route('shop') }}" class="button-main md:mt-8 mt-3" tabindex="0">Shop Now</a>
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
    
    // Initialize Swiper for brands
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
