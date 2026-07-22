@extends('layouts.app')

@section('title', 'Product Discount - Perch Bottle')

@section('content')
@php
    $product->loadMissing('inventories');
    $availableColors = $product->inventories->pluck('color')->unique()->filter()->values()->toArray();
    $allSizes = $product->inventories->pluck('size')->unique()->filter()->values()->toArray();
    if (empty($availableColors) && is_array($product->colors ?? null)) { $availableColors = $product->colors ?? []; }
    if (empty($allSizes) && is_array($product->sizes ?? null)) { $allSizes = $product->sizes ?? []; }
    $sizesByColor = [];
    foreach ($product->inventories as $inv) {
        $c = $inv->color ?? '';
        $s = $inv->size ?? '';
        if ($s === '' && $c === '') continue;
        if (!isset($sizesByColor[$c])) $sizesByColor[$c] = [];
        if ($s !== '' && !in_array($s, $sizesByColor[$c], true)) $sizesByColor[$c][] = $s;
    }
    foreach ($sizesByColor as $c => $list) {
        if (empty($list) && $c !== '') $sizesByColor[$c] = array_values(array_unique($allSizes));
        else $sizesByColor[$c] = array_values($list);
    }
    $firstColor = $availableColors[0] ?? null;
    $sizesForFirstColor = isset($sizesByColor[$firstColor]) && !empty($sizesByColor[$firstColor]) ? $sizesByColor[$firstColor] : $allSizes;
    $firstSize = $sizesForFirstColor[0] ?? $allSizes[0] ?? null;
    $availableSizes = $allSizes;
    $colorImageUrls = [];
    foreach ($product->inventories as $inv) {
        if ($inv->color && $inv->image) {
            $colorImageUrls[$inv->color] = storage_asset($inv->image);
        }
    }
    if (empty($colorImageUrls) && isset($product->color_images) && is_array($product->color_images)) {
        foreach ($product->color_images as $cName => $path) {
            if ($path) $colorImageUrls[$cName] = str_starts_with($path, 'http') ? $path : storage_asset($path);
        }
    }
@endphp
<style>
.desc-truncated { display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; }
.about-truncated { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.product-description-html p { margin-bottom: 0.5rem; }
.product-description-html h5, .product-description-html h6 { font-weight: 600; margin-top: 1rem; margin-bottom: 0.25rem; }
.product-description-html ul { list-style: disc; padding-left: 1.25rem; margin: 0.5rem 0; }
.product-description-html a { text-decoration: underline; }
</style>
<div class="product-page-content">
            <div class="breadcrumb-product">
                <div class="main bg-linear md:pt-[88px] pt-[70px] pb-[14px]">
                    <div class="container flex items-center justify-between flex-wrap gap-3">
                        <div class="left flex items-center gap-1">
                            <a href="{{ route('home') }}" class="caption1 text-secondary2 hover:underline">Homepage</a>
                            <i class="ph ph-caret-right text-xs text-secondary2"></i>
                            <div class="caption1 text-secondary2">Product</div>
                            <i class="ph ph-caret-right text-xs text-secondary2"></i>
                            <div class="caption1 capitalize">{{ $product->name }}</div>
                        </div>
                        <div class="right flex items-center gap-3">
                            @if($prevProduct)
                                <a href="{{ route('product.show', $prevProduct->slug) }}" class="prev-btn flex items-center cursor-pointer text-secondary hover:text-black pr-3 border-r border-line">
                                    <i class="ph ph-caret-circle-left text-2xl text-black"></i>
                                    <span class="caption1 pl-1">Previous Product</span>
                                </a>
                @endif
                            @if($nextProduct)
                                <a href="{{ route('product.show', $nextProduct->slug) }}" class="next-btn flex items-center cursor-pointer text-secondary hover:text-black">
                                    <span class="caption1 pr-1">Next Product</span>
                                    <i class="ph ph-caret-circle-right text-2xl text-black"></i>
                                </a>
                @endif
                        </div>
                    </div>
                </div>
            </div>

        <div class="product-detail discount style-grouped">
            <div class="featured-product underwear filter-product-img bg-linear pt-7 md:pb-20 pb-10">
                <div class="container flex justify-between gap-y-6 flex-wrap">
                    <div class="list-img md:w-1/2 md:pr-[45px] w-full flex-shrink-0">
                        <div class="sticky">
                            <div class="swiper mySwiper2 rounded-2xl overflow-hidden">
                                <div class="swiper-wrapper">
                                    @php
                    $getImageUrl = function($path) {
                        if (!$path) return asset('assets/images/product/perch-bottal.webp');
                        if (str_starts_with($path, 'http')) return $path;
                        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
                            return asset($path);
                        }
                        return storage_asset($path);
                    };
                    $mainImage = $getImageUrl($product->image ?? null);
                    if ($firstColor && isset($colorImageUrls[$firstColor])) {
                        $mainImage = $colorImageUrls[$firstColor];
                    }
                    $allImages = [$mainImage];
                    if (isset($product->images) && is_array($product->images)) {
                        foreach ($product->images as $img) {
                            $allImages[] = $getImageUrl($img);
                        }
                    }
                    $allImages = array_unique($allImages);
                @endphp
                                    @foreach($allImages as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                </div>
                                    @endforeach
                            </div>
                            </div>
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    @foreach($allImages as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover cursor-pointer" />
                            </div>
                        @endforeach
                    </div>
            </div>
                    </div>
                        <div class="swiper popup-img">
                            <span class="close-popup-btn absolute top-4 right-4 z-[2]">
                                <i class="ph ph-x text-3xl text-white"></i>
                            </span>
                            <div class="swiper-wrapper">
                                @foreach($allImages as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                    <div class="product-infor md:w-1/2 w-full lg:pl-[15px] md:pl-2" data-default-size="{{ $firstSize ?? $availableSizes[0] ?? '' }}">
                        <div class="sticky">
                            <div class="flex justify-between">
                                <div>
                                    <div class="product-category caption2 text-secondary font-semibold uppercase">{{ $product->category->name ?? 'Product' }}</div>
                                    <div class="product-name heading4 mt-1">{{ $product->name }}</div>
                                </div>
                                <div class="add-wishlist-btn w-10 h-10 flex-shrink-0 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white" data-product-id="{{ $product->id }}">
                                    <i class="ph ph-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 mt-3">
                                @php $avg = $reviewStats['avg'] ?? 0; $rc = $reviewStats['count'] ?? 0; @endphp
                                <div class="rate flex">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <i class="ph {{ $s <= round($avg) ? 'ph-fill' : 'ph' }} ph-star text-sm {{ $s <= round($avg) ? 'text-yellow' : 'text-line' }}"></i>
                                    @endfor
                                </div>
                                <span class="caption1 text-secondary">({{ number_format($rc) }} {{ $rc === 1 ? 'review' : 'reviews' }})</span>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                                <div class="product-description text-secondary mt-3 w-full">{{ $product->short_description ?? ($product->description ? \Illuminate\Support\Str::limit($product->description, 150) : 'No description available.') }}</div>
                            </div>
                            <div class="list-action mt-6">
                                <div class="discount-code">
                                    @if($coupons && $coupons->count() > 0)
                                        <div class="text-title">Useable discount codes:</div>
                                        <div class="flex items-center gap-3 mt-3">
                                            @foreach($coupons->take(2) as $coupon)
                                                <div class="item relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="130" height="32" viewBox="0 0 130 32" fill="none">
                                                        <path
                                                            d="M6.67572e-06 31.0335V31.0335C6.67572e-06 31.5651 0.430976 31.9961 0.962603 31.9961H13.5219C14.2048 31.9961 14.8816 31.4936 15.1194 30.795C15.1604 30.6745 15.0581 30.5573 14.9709 30.4646V30.4646C14.9168 30.407 14.887 30.3321 14.8874 30.2545V29.2172C14.8874 29.1347 14.9215 29.0555 14.9822 28.9972C15.043 28.9388 15.1253 28.906 15.2112 28.906C15.2971 28.906 15.3795 28.9388 15.4402 28.9972C15.5009 29.0555 15.535 29.1347 15.535 29.2172V30.2545C15.5354 30.3322 15.5055 30.4073 15.4511 30.4649V30.4649C15.3637 30.5576 15.261 30.6748 15.3021 30.7955C15.5399 31.4938 16.2158 31.9961 16.9005 31.9961L126 31.9961C128.209 31.9961 130 30.2052 130 27.9961V3.99609C130 1.78695 128.209 -0.00390625 126 -0.00390625L16.8962 -0.00390625C16.117 -0.00390625 15.5003 0.496968 15.2882 1.1946C15.2507 1.31784 15.3567 1.43416 15.4456 1.52737V1.52737C15.5006 1.58504 15.531 1.6605 15.5307 1.73873V2.25736C15.5307 2.3399 15.4966 2.41905 15.4359 2.47741C15.3751 2.53576 15.2928 2.56855 15.2069 2.56855C15.121 2.56855 15.0386 2.53576 14.9779 2.47741C14.9172 2.41905 14.8831 2.3399 14.8831 2.25736V1.73873C14.8826 1.6618 14.9118 1.58742 14.965 1.52995V1.52995C15.0504 1.43773 15.149 1.31968 15.1045 1.20212C14.8388 0.500396 14.0963 -0.00494385 13.5176 -0.00494385H0.481824C0.215723 -0.00494385 6.67572e-06 0.210773 6.67572e-06 0.476873V0.476873C6.67572e-06 0.742974 0.220644 0.951525 0.474363 1.03175C0.697986 1.10246 0.903572 1.22287 1.07316 1.38583C1.35777 1.65934 1.51767 2.03031 1.51767 2.41711C1.51767 2.8039 1.35777 3.17485 1.07316 3.44836C0.903447 3.61144 0.697684 3.73191 0.473869 3.8026C0.220396 3.88265 6.67572e-06 4.09098 6.67572e-06 4.3568V4.3568C6.67572e-06 4.62261 0.220397 4.83095 0.473867 4.91101C0.697682 4.98171 0.903447 5.10218 1.07316 5.26526C1.35777 5.53877 1.51767 5.90972 1.51767 6.29651C1.51767 6.68331 1.35777 7.05426 1.07316 7.32776C0.903447 7.49085 0.697683 7.61132 0.473868 7.68201C0.220397 7.76207 6.67572e-06 7.9704 6.67572e-06 8.23622V8.23622C6.67572e-06 8.50203 0.220397 8.71037 0.473868 8.79042C0.697683 8.86112 0.903447 8.98159 1.07316 9.14467C1.35777 9.41818 1.51767 9.78914 1.51767 10.1759C1.51767 10.5627 1.35777 10.9337 1.07316 11.2072C0.903447 11.3703 0.697683 11.4907 0.473868 11.5614C0.220397 11.6415 6.67572e-06 11.8498 6.67572e-06 12.1156V12.1156C6.67572e-06 12.3815 0.220397 12.5898 0.473868 12.6698C0.697683 12.7405 0.903447 12.861 1.07316 13.0241C1.35777 13.2976 1.51767 13.6685 1.51767 14.0553C1.51767 14.4421 1.35777 14.8131 1.07316 15.0866C0.902084 15.251 0.694377 15.3721 0.468473 15.4425C0.217696 15.5208 6.67572e-06 15.7267 6.67572e-06 15.9894V15.9894C6.67572e-06 16.2569 0.225281 16.4649 0.482009 16.54C0.519464 16.5509 0.556524 16.5633 0.5931 16.577C0.781892 16.6479 0.953983 16.7545 1.09922 16.8904C1.24445 17.0263 1.35989 17.1887 1.43871 17.3682C1.51753 17.5477 1.55815 17.7405 1.55815 17.9353C1.55815 18.1301 1.51753 18.3229 1.43871 18.5024C1.35989 18.6818 1.24445 18.8443 1.09922 18.9802C0.953983 19.1161 0.781892 19.2226 0.5931 19.2936C0.556521 19.3073 0.51946 19.3197 0.482002 19.3306C0.225278 19.4056 6.67572e-06 19.6137 6.67572e-06 19.8812V19.8812C6.67572e-06 20.1438 0.21768 20.3498 0.468455 20.428C0.506373 20.4398 0.54385 20.4531 0.580795 20.4678C0.764926 20.5411 0.932229 20.6485 1.07316 20.784C1.21409 20.9194 1.32588 21.0802 1.40215 21.2571C1.47842 21.4341 1.51767 21.6237 1.51767 21.8152C1.51767 22.0067 1.47842 22.1964 1.40215 22.3733C1.32588 22.5503 1.21409 22.711 1.07316 22.8465C0.932229 22.9819 0.764926 23.0893 0.580795 23.1626C0.545606 23.1766 0.509935 23.1893 0.47386 23.2007C0.220386 23.2808 6.67572e-06 23.4891 6.67572e-06 23.7549V23.7549C6.67572e-06 24.0207 0.220397 24.2291 0.473866 24.3091C0.697682 24.3798 0.903447 24.5003 1.07316 24.6634C1.35777 24.9369 1.51767 25.3078 1.51767 25.6946C1.51767 26.0814 1.35777 26.4524 1.07316 26.7259C0.903447 26.889 0.697683 27.0094 0.473867 27.0801C0.220397 27.1602 6.67572e-06 27.3685 6.67572e-06 27.6343V27.6343C6.67572e-06 27.9002 0.220396 28.1085 0.473867 28.1885C0.697683 28.2592 0.903447 28.3797 1.07316 28.5428C1.35777 28.8163 1.51767 29.1873 1.51767 29.5741C1.51767 29.9608 1.35777 30.3318 1.07316 30.6053C0.788785 30.8786 0.403181 31.0322 0.00104617 31.0325C0.000472754 31.0325 6.67572e-06 31.0329 6.67572e-06 31.0335V31.0335ZM14.8874 4.3288C14.8874 4.24627 14.9215 4.16712 14.9822 4.10876C15.043 4.0504 15.1253 4.01762 15.2112 4.01762C15.2971 4.01762 15.3795 4.0504 15.4402 4.10876C15.5009 4.16712 15.535 4.24627 15.535 4.3288V5.36608C15.535 5.44861 15.5009 5.52776 15.4402 5.58612C15.3795 5.64448 15.2971 5.67726 15.2112 5.67726C15.1253 5.67726 15.043 5.64448 14.9822 5.58612C14.9215 5.52776 14.8874 5.44861 14.8874 5.36608V4.3288ZM14.8874 7.44063C14.8874 7.3581 14.9215 7.27895 14.9822 7.22059C15.043 7.16223 15.1253 7.12945 15.2112 7.12945C15.2971 7.12945 15.3795 7.16223 15.4402 7.22059C15.5009 7.27895 15.535 7.3581 15.535 7.44063V8.47791C15.535 8.56044 15.5009 8.63958 15.4402 8.69794C15.3795 8.7563 15.2971 8.78909 15.2112 8.78909C15.1253 8.78909 15.043 8.7563 14.9822 8.69794C14.9215 8.63958 14.8874 8.56044 14.8874 8.47791V7.44063ZM14.8874 10.5525C14.8874 10.4699 14.9215 10.3908 14.9822 10.3324C15.043 10.2741 15.1253 10.2413 15.2112 10.2413C15.2971 10.2413 15.3795 10.2741 15.4402 10.3324C15.5009 10.3908 15.535 10.4699 15.535 10.5525V11.5897C15.535 11.6723 15.5009 11.7514 15.4402 11.8098C15.3795 11.8681 15.2971 11.9009 15.2112 11.9009C15.1253 11.9009 15.043 11.8681 14.9822 11.8098C14.9215 11.7514 14.8874 11.6723 14.8874 11.5897V10.5525ZM14.8874 13.6643C14.8874 13.5818 14.9215 13.5026 14.9822 13.4443C15.043 13.3859 15.1253 13.3531 15.2112 13.3531C15.2971 13.3531 15.3795 13.3859 15.4402 13.4443C15.5009 13.5026 15.535 13.5818 15.535 13.6643V14.7016C15.535 14.7841 15.5009 14.8632 15.4402 14.9216C15.3795 14.98 15.2971 15.0128 15.2112 15.0128C15.1253 15.0128 15.043 14.98 14.9822 14.9216C14.9215 14.8632 14.8874 14.7841 14.8874 14.7016V13.6643ZM14.8874 16.7761C14.8874 16.6936 14.9215 16.6144 14.9822 16.5561C15.043 16.4977 15.1253 16.4649 15.2112 16.4649C15.2971 16.4649 15.3795 16.4977 15.4402 16.5561C15.5009 16.6144 15.535 16.6936 15.535 16.7761V17.8134C15.535 17.8959 15.5009 17.9751 15.4402 18.0334C15.3795 18.0918 15.2971 18.1246 15.2112 18.1246C15.1253 18.1246 15.043 18.0918 14.9822 18.0334C14.9215 17.9751 14.8874 17.8959 14.8874 17.8134V16.7761ZM14.8874 19.888C14.8874 19.8054 14.9215 19.7263 14.9822 19.6679C15.043 19.6096 15.1253 19.5768 15.2112 19.5768C15.2971 19.5768 15.3795 19.6096 15.4402 19.6679C15.5009 19.7263 15.535 19.8054 15.535 19.888V20.9252C15.535 21.0078 15.5009 21.0869 15.4402 21.1453C15.3795 21.2036 15.2971 21.2364 15.2112 21.2364C15.1253 21.2364 15.043 21.2036 14.9822 21.1453C14.9215 21.0869 14.8874 21.0078 14.8874 20.9252V19.888ZM14.8874 22.9998C14.8874 22.9173 14.9215 22.8381 14.9822 22.7797C15.043 22.7214 15.1253 22.6886 15.2112 22.6886C15.2971 22.6886 15.3795 22.7214 15.4402 22.7797C15.5009 22.8381 15.535 22.9173 15.535 22.9998V24.0371C15.535 24.1196 15.5009 24.1987 15.4402 24.2571C15.3795 24.3155 15.2971 24.3483 15.2112 24.3483C15.1253 24.3483 15.043 24.3155 14.9822 24.2571C14.9215 24.1987 14.8874 24.1196 14.8874 24.0371V22.9998ZM14.8874 26.1116C14.8874 26.0291 14.9215 25.9499 14.9822 25.8916C15.043 25.8332 15.1253 25.8004 15.2112 25.8004C15.2971 25.8004 15.3795 25.8332 15.4402 25.8916C15.5009 25.9499 15.535 26.0291 15.535 26.1116V27.1489C15.535 27.2314 15.5009 27.3106 15.4402 27.3689C15.3795 27.4273 15.2971 27.4601 15.2112 27.4601C15.1253 27.4601 15.043 27.4273 14.9822 27.3689C14.9215 27.3106 14.8874 27.2314 14.8874 27.1489V26.1116Z"
                                                            fill="#DB4444"
                                                        />
                                                    </svg>
                                                    <div class="content absolute top-1/2 -translate-y-1/2 md:right-1 right-2 flex items-center gap-2">
                                                        <div class="caption1 text-white">
                                                            @if(isset($coupon->discount_type) && $coupon->discount_type === 'percentage')
                                                                {{ $coupon->discount_value ?? 0 }}% Off
                                                            @else
                                                                ₹{{ number_format($coupon->discount_value ?? 0, 2) }} Off
                                                            @endif
                                                        </div>
                                                        <div class="button bg-white font-semibold text-xs py-1 px-2 rounded-full duration-300 hover:bg-black hover:text-white cursor-pointer apply-coupon-btn" data-coupon-code="{{ $coupon->code }}">Apply</div>
                                                    </div>
                                                </div>
                                            @endforeach
                    </div>
                @endif
                                </div>
                                @if(count($availableColors) > 0)
                                    <div class="choose-color mt-5" data-color-images="{{ json_encode($colorImageUrls) }}">
                                        <div class="text-title">Colors: <span class="text-title color selected-color">{{ $availableColors[0] ?? '' }}</span></div>
                                        <div class="list-color flex items-center gap-2 flex-wrap mt-3">
                                            @foreach($availableColors as $color)
                                                <div class="color-item w-10 h-10 rounded-full border-2 border-transparent hover:border-black cursor-pointer duration-300 {{ $loop->first ? 'active border-black' : '' }}" 
                                                     style="background-color: {{ $color }};"
                                                     data-color="{{ $color }}"
                                                     title="{{ $color }}">
                                                </div>
                                            @endforeach
                                        </div>
                    </div>
                @endif
                                <div class="text-title mt-5">Quantity:</div>
                                <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                                    <div class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0">
                                        <i class="ph-bold ph-minus cursor-pointer body1"></i>
                                        <input type="number" min="1" max="9999" step="1" value="1" inputmode="numeric" aria-label="Quantity" class="quantity body1 font-semibold w-12 min-w-[3rem] text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" />
                                        <i class="ph-bold ph-plus cursor-pointer body1"></i>
                                    </div>
                                    <div class="add-cart-btn button-main whitespace-nowrap w-full text-center bg-white text-black border border-black cursor-pointer" data-product-id="{{ $product->id }}">Add To Cart</div>
                                </div>
                                <!-- Pincode Checker -->
                                <div class="pincode-checker mt-5 p-4 border border-line rounded-lg">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="ph ph-map-pin text-xl"></i>
                                        <div class="text-title">Check Delivery</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               id="pincode-input" 
                                               placeholder="Enter pincode" 
                                               class="flex-1 px-3 py-2 border border-line rounded-lg text-sm"
                                               maxlength="6"
                                               pattern="[0-9]{6}">
                                        <button type="button" 
                                                id="check-pincode-btn" 
                                                class="px-4 py-2 bg-black text-white rounded-lg text-sm hover:bg-gray-800 transition-colors">
                                            Check
                                        </button>
                                    </div>
                                    <div id="delivery-info" class="mt-3 hidden">
                                        <!-- Delivery information will be populated here -->
                                    </div>
                                </div>

                                <div class="button-block mt-5 flex gap-3">
                                    <a href="{{ route('customize') }}" class="button-main flex-1 text-center border-0 cursor-pointer bg-black text-white font-semibold py-3 px-4 uppercase no-underline">Customize</a>
                                    <button type="button" class="buy-it-now-btn button-main flex-1 text-center border-0 cursor-pointer bg-black text-white font-semibold py-3 px-4 uppercase" data-product-id="{{ $product->id }}" data-checkout-url="{{ route('checkout.index') }}">Buy It Now</button>
                                </div>
                            </div>
                            <div class="get-it mt-6">
                                <div class="item flex items-center gap-3 mt-4">
                                    <div class="icon-delivery-truck text-4xl"></div>
                                    <div>
                                        <div class="text-title">Free shipping</div>
                                        <div class="caption1 text-secondary mt-1">Free shipping on orders over ₹75.</div>
                                    </div>
                                </div>
                                <div class="item flex items-center gap-3 mt-4">
                                    <div class="icon-phone-call text-4xl"></div>
                                    <div>
                                        <div class="text-title">Support everyday</div>
                                        <div class="caption1 text-secondary mt-1">Support from 8:30 AM to 10:00 PM everyday</div>
                                    </div>
                                </div>
                                <div class="item flex items-center gap-3 mt-4">
                                    <div class="icon-return text-4xl"></div>
                                    <div>
                                        <div class="text-title">100 Day Returns</div>
                                        <div class="caption1 text-secondary mt-1">Not impressed? Get a refund. You have 100 days to break our hearts.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="desc-tab md:pt-20 pt-10">
                <div class="container">
                    <div class="flex items-center justify-center w-full">
                        <div class="menu-tab flex items-center md:gap-[60px] gap-8">
                            <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer select-none active" data-item="Description" role="button" tabindex="0">Description</div>
                            <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer select-none" data-item="Specifications" role="button" tabindex="0">Specifications</div>
                            <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer select-none" data-item="Review" role="button" tabindex="0">Review</div>
                        </div>
                    </div>
                    <div class="desc-block mt-8">
                        <div class="desc-item description open" data-item="Description">
                            <div class="grid md:grid-cols-2 gap-8 gap-y-5">
                                <div class="left">
                                    <div class="heading6">Detailed Description</div>
                                    @php
                                        $detailedText = $product->description ?: ($product->short_description ?: 'No detailed description has been added for this product.');
                                        $isHtml = $product->description && (str_contains($product->description, '<') && str_contains($product->description, '>'));
                                    @endphp
                                    <div class="desc-detail-wrapper">
                                        <div class="text-secondary mt-2 desc-detail-content {{ !$isHtml && strlen(strip_tags($detailedText)) > 300 ? 'desc-truncated' : '' }} @if($isHtml) product-description-html @endif">
                                            @if($product->description)
                                                @if($isHtml)
                                                    {!! $product->description !!}
                                                @else
                                                    {!! nl2br(e($product->description)) !!}
                                                @endif
                                            @else
                                                <span class="text-secondary2">{{ $product->short_description ?: 'No detailed description has been added for this product.' }}</span>
                                            @endif
                                        </div>
                                        @if(!$isHtml && strlen(strip_tags($detailedText)) > 300)
                                            <button type="button" class="see-more-btn text-button text-black hover:underline mt-2 cursor-pointer font-semibold" data-target=".desc-detail-content">See more</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="heading6">About This Product</div>
                                    <div class="list-feature">
                                        @if($product->short_description)
                                            <div class="item flex gap-1 text-secondary mt-1 about-short-wrap">
                                                <i class="ph ph-dot text-2xl flex-shrink-0"></i>
                                                <div>
                                                    <p class="about-short-content {{ strlen($product->short_description) > 120 ? 'about-truncated' : '' }}">{{ $product->short_description }}</p>
                                                    @if(strlen($product->short_description) > 120)
                                                        <button type="button" class="see-more-btn text-button text-black hover:underline mt-1 cursor-pointer font-semibold text-sm" data-target=".about-short-content">See more</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if($product->category)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Category: {{ $product->category->name }}</p>
                                            </div>
                                        @endif
                                        @if(isset($availableSizes) && count($availableSizes) > 0)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Size: {{ implode(', ', $availableSizes) }}</p>
                                            </div>
                                        @endif
                                        @if(isset($availableColors) && count($availableColors) > 0)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Colors: {{ implode(', ', $availableColors) }}</p>
                                            </div>
                                        @endif
                                        @if($product->specifications && is_array($product->specifications) && count($product->specifications) > 0)
                                            @foreach($product->specifications as $key => $value)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="grid lg:grid-cols-4 grid-cols-2 gap-[30px] md:mt-10 mt-6">
                                @php
                                    $f1Title = \App\Models\Setting::get('product_feature_1_title', 'Shipping Faster');
                                    $f1Text = \App\Models\Setting::get('product_feature_1_text', 'Free shipping on orders over ₹75. Fast delivery across India.');
                                    $f2Title = \App\Models\Setting::get('product_feature_2_title', 'Premium Material');
                                    $f2Text = \App\Models\Setting::get('product_feature_2_text', 'Crafted from high-quality materials for durability and style.');
                                    $f3Title = \App\Models\Setting::get('product_feature_3_title', 'High Quality');
                                    $f3Text = \App\Models\Setting::get('product_feature_3_text', 'Built to last. Every product is designed for everyday excellence.');
                                    $f4Title = \App\Models\Setting::get('product_feature_4_title', 'Highly Compatible');
                                    $f4Text = \App\Models\Setting::get('product_feature_4_text', 'Works beautifully at home, work, travel, and for gifting.');
                                @endphp
                                <div class="item">
                                    <div class="icon-delivery-truck text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f1Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f1Text }}</div>
                                </div>
                                <div class="item">
                                    <div class="icon-cotton text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f2Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f2Text }}</div>
                                </div>
                                <div class="item">
                                    <div class="icon-guarantee text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f3Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f3Text }}</div>
                                </div>
                                <div class="item">
                                    <div class="icon-leaves-compatible text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f4Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f4Text }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="desc-item specifications flex items-center justify-center" data-item="Specifications">
                            <div class="lg:w-1/2 sm:w-3/4 w-full">
                                @if(isset($availableSizes) && count($availableSizes) > 0)
                                <div class="item flex items-center gap-8 py-3 px-10">
                                    <div class="text-title sm:w-1/4 w-1/3">Size</div>
                                    <p>{{ implode(', ', $availableSizes) }}</p>
                                </div>
                                @endif
                                @if(isset($availableColors) && count($availableColors) > 0)
                                <div class="item bg-surface flex items-center gap-8 py-3 px-10">
                                    <div class="text-title sm:w-1/4 w-1/3">Colors</div>
                                    <p>{{ implode(', ', $availableColors) }}</p>
                                </div>
                                @endif
                                @if($product->specifications && is_array($product->specifications) && count($product->specifications) > 0)
                                    @php $specIndex = 0; @endphp
                                    @foreach($product->specifications as $key => $value)
                                    <div class="item {{ $specIndex % 2 == 0 ? '' : 'bg-surface' }} flex items-center gap-8 py-3 px-10">
                                        <div class="text-title sm:w-1/4 w-1/3">{{ $key }}</div>
                                        <p>{{ $value }}</p>
                                    </div>
                                    @php $specIndex++; @endphp
                                    @endforeach
                                @endif
                                @if((isset($availableSizes) && count($availableSizes) > 0) || (isset($availableColors) && count($availableColors) > 0) || ($product->specifications && is_array($product->specifications) && count($product->specifications) > 0))
                                @else
                                <div class="item flex items-center gap-8 py-3 px-10">
                                    <div class="text-secondary">No specifications available for this product.</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="desc-item review" data-item="Review">
                            @include('partials.product-reviews', ['product' => $product, 'reviews' => $reviews, 'reviewStats' => $reviewStats])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($product->video)
            <div class="container py-10">
                <div class="heading3 text-center mb-6">Product Video</div>
                <div class="w-full max-w-[720px] mx-auto rounded-2xl overflow-hidden bg-black shadow-lg" style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <video 
                        controls 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;"
                        preload="metadata"
                    >
                        <source src="{{ storage_asset($product->video) }}#t=0.1" type="video/mp4">
                        <source src="{{ storage_asset($product->video) }}" type="video/mp4">
                        <source src="{{ storage_asset($product->video) }}" type="video/quicktime">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        @endif

        <div class="tab-features-block filter-product-block md:py-20 py-10">
            <div class="container">
                <div class="heading3 text-center">Related Products</div>
                <div class="list-product six-product hide-product-sold relative section-swiper-navigation style-outline style-small-border md:mt-10 mt-6">
                    <div class="swiper-button-prev2 sm:left-10 left-6">
                        <i class="ph-bold ph-caret-left text-xl"></i>
                </div>
                    <div class="swiper swiper-list-product h-full relative">
                        <div class="swiper-wrapper">
                            @forelse($relatedProducts as $relatedProduct)
                                <div class="swiper-slide">
                        @include('partials.product-card', ['product' => $relatedProduct])
                </div>
                            @empty
                                <div class="swiper-slide col-span-full text-center py-10">
                                    <p class="text-secondary">No related products available</p>
            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="swiper-button-next2 sm:right-10 right-6">
                        <i class="ph-bold ph-caret-right text-xl"></i>
                    </div>
                </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/product-detail.js') }}"></script>
<script>
    // Description / Specifications / Review tabs — work without full reload (reliable on server)
    function initDescTabs() {
        var descTab = document.querySelector('.desc-tab');
        if (!descTab) return;
        var tabButtons = descTab.querySelectorAll('.menu-tab .tab-item');
        var panels = descTab.querySelectorAll('.desc-block .desc-item');
        if (!tabButtons.length || !panels.length) return;

        function showPanel(dataItem) {
            if (!dataItem) return;
            panels.forEach(function(panel) {
                if (panel.getAttribute('data-item') === dataItem) {
                    panel.classList.add('open');
                } else {
                    panel.classList.remove('open');
                }
            });
            tabButtons.forEach(function(btn) {
                btn.classList.remove('active');
                if (btn.getAttribute('data-item') === dataItem) btn.classList.add('active');
            });
        }

        // Event delegation: one listener on container so tabs work even if script runs early
        descTab.addEventListener('click', function(e) {
            var btn = e.target.closest('.menu-tab .tab-item');
            if (btn) {
                e.preventDefault();
                var dataItem = btn.getAttribute('data-item');
                if (dataItem) showPanel(dataItem);
            }
        });
        descTab.addEventListener('keydown', function(e) {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            var btn = e.target.closest('.menu-tab .tab-item');
            if (btn) {
                e.preventDefault();
                var dataItem = btn.getAttribute('data-item');
                if (dataItem) showPanel(dataItem);
            }
        });

        if (window.location.hash === '#form-review') showPanel('Review');
        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#form-review') showPanel('Review');
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDescTabs);
    } else {
        initDescTabs();
    }

    // See more / See less for descriptions
    document.querySelectorAll('.see-more-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetSel = this.getAttribute('data-target');
            var target = this.closest('.desc-detail-wrapper, .about-short-wrap')?.querySelector(targetSel);
            if (!target) return;
            var isDesc = target.classList.contains('desc-detail-content');
            var truncatedClass = isDesc ? 'desc-truncated' : 'about-truncated';
            if (target.classList.contains(truncatedClass)) {
                target.classList.remove(truncatedClass);
                this.textContent = 'See less';
            } else {
                target.classList.add(truncatedClass);
                this.textContent = 'See more';
            }
        });
    });

    // Product detail page functionality
    (function() {
        'use strict';
        
        function updateProductVariantPrice() {
            const block = document.querySelector('.product-price-block');
            if (!block) return;
            const variantPricesJson = block.getAttribute('data-variant-prices');
            const productPrice = parseFloat(block.getAttribute('data-product-price') || '0') || 0;
            const productSalePriceRaw = block.getAttribute('data-product-sale-price');
            const productSalePrice = productSalePriceRaw !== '' && productSalePriceRaw !== null ? (parseFloat(productSalePriceRaw) || null) : null;
            let variantPrices = [];
            try {
                if (variantPricesJson) variantPrices = JSON.parse(variantPricesJson);
            } catch (e) { return; }
            const colorEl = document.querySelector('.color-item.active');
            const sizeEl = document.querySelector('.size-item.active');
            const productInfor = document.querySelector('.product-infor');
            const color = colorEl ? (colorEl.getAttribute('data-color') || '') : '';
            const size = sizeEl ? (sizeEl.getAttribute('data-size') || '') : (productInfor?.getAttribute('data-default-size') || '');
            let price = productPrice;
            let salePrice = productSalePrice;
            for (let i = 0; i < variantPrices.length; i++) {
                const v = variantPrices[i];
                const vColor = v.color || '';
                const vSize = v.size || '';
                if (vColor === color && vSize === size) {
                    price = parseFloat(v.price) || price;
                    salePrice = (v.sale_price !== null && v.sale_price !== undefined && v.sale_price !== '') ? (parseFloat(v.sale_price) || null) : null;
                    break;
                }
            }
            const displayPrice = (salePrice !== null && salePrice > 0 && salePrice < price) ? salePrice : price;
            const priceEl = block.querySelector('.product-price');
            const originEl = block.querySelector('.product-origin-price');
            const saleBadge = block.querySelector('.product-sale');
            const separator = block.querySelector('.w-px.h-4');
            if (priceEl) priceEl.textContent = '₹' + displayPrice.toFixed(2);
            const hasSale = salePrice !== null && salePrice > 0 && price > salePrice;
            if (originEl) {
                const del = originEl.querySelector('del');
                if (del) del.textContent = '₹' + price.toFixed(2);
                originEl.classList.toggle('d-none', !hasSale);
            }
            if (separator) separator.classList.toggle('d-none', !hasSale);
            if (saleBadge) {
                if (hasSale) {
                    const pct = Math.round(((price - salePrice) / price) * 100);
                    saleBadge.textContent = '-' + pct + '%';
                    saleBadge.classList.remove('d-none');
                } else {
                    saleBadge.classList.add('d-none');
                }
            }
        }
        window.updateProductVariantPrice = updateProductVariantPrice;
        
        // Color selection + switch main image when color has a dedicated image
        document.addEventListener('click', function(e) {
            const colorItem = e.target.closest('.color-item');
            if (!colorItem || !colorItem.closest('.choose-color')) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            const siblings = colorItem.parentElement.querySelectorAll('.color-item');
            siblings.forEach(sib => sib.classList.remove('active', 'border-black'));
            colorItem.classList.add('active', 'border-black');
            
            const selectedColor = colorItem.getAttribute('data-color');
            const colorText = document.querySelector('.selected-color');
            if (colorText) colorText.textContent = selectedColor;
            
            if (typeof window.updateProductVariantPrice === 'function') {
                window.updateProductVariantPrice();
            }
            var chooseSizeBlock = document.querySelector('.choose-size');
            if (chooseSizeBlock) {
                var sizesByColorJson = chooseSizeBlock.getAttribute('data-sizes-by-color');
                var allSizesJson = chooseSizeBlock.getAttribute('data-all-sizes');
                try {
                    var sizesByColor = sizesByColorJson ? JSON.parse(sizesByColorJson) : {};
                    var allSizes = allSizesJson ? JSON.parse(allSizesJson) : [];
                    var sizesForColor = sizesByColor[selectedColor] || sizesByColor[''] || allSizes;
                    var listSize = chooseSizeBlock.querySelector('.list-size');
                    if (listSize) {
                        var sizeItems = listSize.querySelectorAll('.size-item');
                        var firstAvailable = null;
                        sizeItems.forEach(function(si) {
                            var s = si.getAttribute('data-size');
                            var available = sizesForColor.indexOf(s) !== -1;
                            if (available) {
                                si.classList.remove('size-unavailable', 'opacity-60');
                                si.setAttribute('title', '');
                                if (!firstAvailable) firstAvailable = si;
                            } else {
                                si.classList.add('size-unavailable', 'opacity-60');
                                si.setAttribute('title', 'This size is not available for this color');
                                si.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                                si.classList.add('border-line');
                            }
                        });
                        var activeSize = listSize.querySelector('.size-item.active:not(.size-unavailable)');
                        if (!activeSize && firstAvailable) {
                            sizeItems.forEach(function(sib) {
                                sib.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                                sib.classList.add('border-line');
                            });
                            firstAvailable.classList.add('active', 'border-black', 'bg-black', 'text-white');
                            firstAvailable.classList.remove('border-line');
                            var sizeTextEl = document.querySelector('.selected-size');
                            if (sizeTextEl) sizeTextEl.textContent = firstAvailable.getAttribute('data-size');
                            if (typeof window.updateProductVariantPrice === 'function') window.updateProductVariantPrice();
                        }
                    }
                } catch (err) { /* ignore */ }
            }
            
            // Switch product image to color-based image if available
            const chooseColor = colorItem.closest('.choose-color');
            const colorImagesJson = chooseColor?.getAttribute('data-color-images');
            if (colorImagesJson) {
                try {
                    const colorImages = JSON.parse(colorImagesJson);
                    const colorImageUrl = selectedColor ? (colorImages[selectedColor] || colorImages[selectedColor.trim()]) : '';
                    const mainSwiper = document.querySelector('.product-detail .mySwiper2');
                    const thumbSwiper = document.querySelector('.product-detail .mySwiper');
                    if (colorImageUrl && mainSwiper) {
                        const wrapper = mainSwiper.querySelector('.swiper-wrapper');
                        const firstSlide = wrapper?.querySelector('.swiper-slide');
                        const firstImg = firstSlide?.querySelector('img');
                        if (firstImg) {
                            firstImg.src = colorImageUrl;
                            firstImg.alt = selectedColor + ' - ' + (firstImg.alt || '');
                        }
                        if (thumbSwiper) {
                            const thumbWrapper = thumbSwiper.querySelector('.swiper-wrapper');
                            const thumbFirst = thumbWrapper?.querySelector('.swiper-slide img');
                            if (thumbFirst) thumbFirst.src = colorImageUrl;
                        }
                        const popupImg = document.querySelector('.product-detail .popup-img .swiper-wrapper .swiper-slide img');
                        if (popupImg) popupImg.src = colorImageUrl;
                    }
                } catch (err) { /* ignore */ }
            }
        });
        
        // Size selection
        document.addEventListener('click', function(e) {
            const sizeItem = e.target.closest('.size-item');
            if (!sizeItem || !sizeItem.closest('.choose-size')) return;
            
            var chooseSizeBlock = sizeItem.closest('.choose-size');
            var sizesByColorJson = chooseSizeBlock.getAttribute('data-sizes-by-color');
            var allSizesJson = chooseSizeBlock.getAttribute('data-all-sizes');
            var clickedSize = sizeItem.getAttribute('data-size');
            var colorEl = document.querySelector('.color-item.active');
            var selectedColor = colorEl ? (colorEl.getAttribute('data-color') || '') : '';
            var isAvailable = true;
            try {
                if (sizesByColorJson && allSizesJson) {
                    var sizesByColor = JSON.parse(sizesByColorJson);
                    var allSizes = JSON.parse(allSizesJson);
                    var sizesForColor = sizesByColor[selectedColor] || sizesByColor[''] || allSizes;
                    isAvailable = sizesForColor.indexOf(clickedSize) !== -1;
                }
            } catch (err) { }
            
            if (!isAvailable || sizeItem.classList.contains('size-unavailable')) {
                e.preventDefault();
                e.stopPropagation();
                var existingToast = document.querySelector('.product-size-toast');
                if (existingToast) existingToast.remove();
                var msg = document.createElement('div');
                msg.className = 'product-size-toast fixed top-4 left-1/2 -translate-x-1/2 z-[9999] px-5 py-3 rounded-lg bg-gray-900 text-white text-sm font-medium shadow-xl whitespace-nowrap';
                msg.textContent = 'Is color ke liye ye size available nahi hai';
                msg.style.opacity = '1';
                msg.style.transition = 'opacity 0.2s';
                document.body.appendChild(msg);
                setTimeout(function() {
                    msg.style.opacity = '0';
                    setTimeout(function() { if (msg.parentNode) msg.remove(); }, 300);
                }, 2800);
                return;
            }
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove active class from siblings
            const siblings = sizeItem.parentElement.querySelectorAll('.size-item');
            siblings.forEach(sib => {
                sib.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                sib.classList.add('border-line');
            });
            
            // Add active class to clicked item
            sizeItem.classList.add('active', 'border-black', 'bg-black', 'text-white');
            sizeItem.classList.remove('border-line');
            
            // Update selected size text
            const selectedSize = sizeItem.getAttribute('data-size');
            const sizeText = document.querySelector('.selected-size');
            if (sizeText) {
                sizeText.textContent = selectedSize;
            }
            if (typeof window.updateProductVariantPrice === 'function') {
                window.updateProductVariantPrice();
            }
        });
        
        function readProductQty(el) {
            if (!el) return 1;
            const raw = el.tagName === 'INPUT' ? el.value : el.textContent;
            let n = parseInt(String(raw).trim(), 10);
            if (isNaN(n) || n < 1) n = 1;
            return Math.min(n, 9999);
        }
        function writeProductQty(el, n) {
            if (!el) return;
            n = Math.max(1, Math.min(parseInt(n, 10) || 1, 9999));
            if (el.tagName === 'INPUT') el.value = String(n);
            else el.textContent = String(n);
        }
        // Quantity controls (+/- only; typing handled on blur/change)
        document.addEventListener('click', function(e) {
            const quantityBlock = e.target.closest('.quantity-block');
            if (!quantityBlock) return;
            
            const minusIcon = e.target.closest('.ph-minus');
            const plusIcon = e.target.closest('.ph-plus');
            const quantityElement = quantityBlock.querySelector('.quantity');
            
            if (!quantityElement || quantityElement.readOnly || quantityElement.disabled) return;
            
            if (minusIcon) {
                e.preventDefault();
                e.stopPropagation();
                writeProductQty(quantityElement, readProductQty(quantityElement) - 1);
            }
            
            if (plusIcon) {
                e.preventDefault();
                e.stopPropagation();
                writeProductQty(quantityElement, readProductQty(quantityElement) + 1);
            }
        });
        document.addEventListener('change', function(e) {
            const q = e.target.closest('.product-infor .quantity-block .quantity');
            if (!q || q.tagName !== 'INPUT') return;
            writeProductQty(q, readProductQty(q));
        });
        document.addEventListener('blur', function(e) {
            const q = e.target.closest('.product-infor .quantity-block .quantity');
            if (!q || q.tagName !== 'INPUT') return;
            writeProductQty(q, readProductQty(q));
        }, true);
        
        // Add to cart from product detail page
        let isAddingToCart = false; // Prevent double clicks
        
        document.addEventListener('click', function(e) {
            const addCartBtn = e.target.closest('.add-cart-btn');
            if (!addCartBtn || !addCartBtn.closest('.product-infor')) return;
            
            // Prevent double clicks
            if (isAddingToCart || addCartBtn.disabled) {
                e.preventDefault();
                e.stopPropagation();
                return;
            }
            
            e.preventDefault();
            e.stopPropagation();
            
            const productId = addCartBtn.getAttribute('data-product-id');
            if (!productId) return;
            
            const productInfor = addCartBtn.closest('.product-infor');
            if (!productInfor) return;
            
            // Set flag to prevent double clicks
            isAddingToCart = true;
            
            // Get selected size and color from this product (size card removed, use default when available)
            const selectedSizeItem = productInfor.querySelector('.size-item.active:not(.size-unavailable)');
            const selectedColorItem = productInfor.querySelector('.color-item.active');
            const quantityElement = productInfor.querySelector('.quantity-block .quantity');
            
            const size = selectedSizeItem?.getAttribute('data-size') || productInfor.getAttribute('data-default-size') || null;
            const color = selectedColorItem?.getAttribute('data-color') || null;
            // Get quantity from the quantity element, ensure it's at least 1
            let quantity = 1;
            if (quantityElement) {
                quantity = readProductQty(quantityElement);
            }
            
            // Show loading state
            const originalText = addCartBtn.innerHTML;
            const originalDisabled = addCartBtn.disabled;
            addCartBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Adding...';
            addCartBtn.disabled = true;
            addCartBtn.style.pointerEvents = 'none';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            // Make API call
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: quantity,
                    size: size,
                    color: color
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    if (typeof window.updateCartCount === 'function') {
                        window.updateCartCount();
                    }
                    
                    // Show success message
                    if (typeof window.showNotification === 'function') {
                        window.showNotification('Product added to cart!', 'success');
                    } else {
                        alert('Product added to cart!');
                    }
                    
                    // Open cart modal if exists
                    const cartModal = document.querySelector('.modal-cart-block');
                    if (cartModal) {
                        cartModal.classList.add('open');
                        if (typeof window.loadCartItems === 'function') {
                            window.loadCartItems();
                        }
                    }
                } else {
                    if (typeof window.showNotification === 'function') {
                        window.showNotification(data.message || 'Failed to add product to cart', 'error');
                    } else {
                        alert(data.message || 'Failed to add product to cart');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showNotification === 'function') {
                    window.showNotification('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .finally(() => {
                // Always reset button state
                addCartBtn.innerHTML = originalText;
                addCartBtn.disabled = originalDisabled;
                addCartBtn.style.pointerEvents = '';
                isAddingToCart = false;
            });
        });
        
        // Buy It Now: add product to cart then redirect to checkout
        let isBuyItNow = false;
        document.addEventListener('click', function(e) {
            const buyBtn = e.target.closest('.buy-it-now-btn');
            if (!buyBtn || !buyBtn.closest('.product-infor')) return;
            if (isBuyItNow || buyBtn.disabled) {
                e.preventDefault();
                e.stopPropagation();
                return;
            }
            e.preventDefault();
            e.stopPropagation();
            const productId = buyBtn.getAttribute('data-product-id');
            const checkoutUrl = buyBtn.getAttribute('data-checkout-url') || '/checkout';
            if (!productId) return;
            const productInfor = buyBtn.closest('.product-infor');
            if (!productInfor) return;
            const selectedSizeItem = productInfor.querySelector('.size-item.active:not(.size-unavailable)');
            const selectedColorItem = productInfor.querySelector('.color-item.active');
            const size = selectedSizeItem?.getAttribute('data-size') || productInfor.getAttribute('data-default-size') || null;
            const color = selectedColorItem?.getAttribute('data-color') || null;
            isBuyItNow = true;
            const originalText = buyBtn.innerHTML;
            buyBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Adding...';
            buyBtn.disabled = true;
            buyBtn.style.pointerEvents = 'none';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: (function() {
                        const qEl = productInfor.querySelector('.quantity-block .quantity');
                        return qEl ? readProductQty(qEl) : 1;
                    })(),
                    size: size,
                    color: color
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.updateCartCount === 'function') window.updateCartCount();
                    window.location.href = checkoutUrl;
                } else {
                    if (typeof window.showNotification === 'function') {
                        window.showNotification(data.message || 'Failed to add product', 'error');
                    } else {
                        alert(data.message || 'Failed to add product');
                    }
                    buyBtn.innerHTML = originalText;
                    buyBtn.disabled = false;
                    buyBtn.style.pointerEvents = '';
                    isBuyItNow = false;
                }
            })
            .catch(function(err) {
                console.error('Buy It Now error:', err);
                if (typeof window.showNotification === 'function') {
                    window.showNotification('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
                buyBtn.innerHTML = originalText;
                buyBtn.disabled = false;
                buyBtn.style.pointerEvents = '';
                isBuyItNow = false;
            });
        });
        
        // Show notification
        function showNotification(message, type = 'success') {
            const existing = document.querySelector('.notification');
            if (existing) existing.remove();
            
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.3s';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    })();

    // Product image popup functionality - Direct implementation
    (function() {
        'use strict';
        
        function initImagePopup() {
            const productDetail = document.querySelector(".product-detail");
            if (!productDetail) {
                console.log("[Popup] Product detail not found");
                return;
            }

            const popupImg = productDetail.querySelector(".popup-img");
            if (!popupImg) {
                console.log("[Popup] Popup element not found");
                return;
            }

            const closePopupBtn = popupImg.querySelector(".close-popup-btn");
            
            const mainImages = productDetail.querySelectorAll(".list-img .mySwiper2 .swiper-slide img");
            const thumbImages = productDetail.querySelectorAll(".list-img .mySwiper .swiper-slide img");

            console.log("[Popup] Setup:", {
                popupImg: !!popupImg,
                mainImages: mainImages.length,
                thumbImages: thumbImages.length,
                closePopupBtn: !!closePopupBtn
            });

            if (mainImages.length === 0 && thumbImages.length === 0) {
                console.log("[Popup] No images found");
                return;
            }

            let popupSwiper = null;

            function openPopup(index) {
                console.log("[Popup] Opening at index:", index);
                popupImg.classList.add("open");
                document.body.style.overflow = "hidden";

                if (!popupSwiper) {
                    const nextBtn = popupImg.querySelector(".swiper-button-next");
                    const prevBtn = popupImg.querySelector(".swiper-button-prev");
                    
                    popupSwiper = new Swiper(popupImg, {
                        loop: true,
                        slidesPerView: 1,
                        spaceBetween: 0,
                        centeredSlides: true,
                        navigation: {
                            nextEl: nextBtn,
                            prevEl: prevBtn,
                        },
                        initialSlide: index,
                    });
                    console.log("[Popup] Swiper initialized");
                } else {
                    if (popupSwiper.slideToLoop) {
                        popupSwiper.slideToLoop(index);
                    } else {
                        popupSwiper.slideTo(index);
                    }
                }
            }

            function closePopup() {
                console.log("[Popup] Closing");
                popupImg.classList.remove("open");
                document.body.style.overflow = "";
                if (popupSwiper) {
                    popupSwiper.destroy(true, true);
                    popupSwiper = null;
                }
            }

            // Add click handlers to main images
            mainImages.forEach((img, index) => {
                img.style.cursor = "pointer";
                img.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log("[Popup] Main image clicked:", index);
                    openPopup(index);
                });
            });

            // Thumbnail click: only change center/main image, do NOT open popup
            thumbImages.forEach((img, index) => {
                img.style.cursor = "pointer";
                img.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (typeof swiper2 !== "undefined" && swiper2) {
                        swiper2.slideTo(index);
                    }
                });
            });

            // Close button
            if (closePopupBtn) {
                closePopupBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closePopup();
                });
            }

            // Close on background click (but not on navigation buttons or swiper content)
            popupImg.addEventListener("click", function (e) {
                // Don't close if clicking on:
                // - Navigation buttons
                // - Swiper wrapper/slides
                // - Close button (handled separately)
                if (e.target.closest('.swiper-button-next') || 
                    e.target.closest('.swiper-button-prev') || 
                    e.target.closest('.swiper-wrapper') || 
                    e.target.closest('.swiper-slide') ||
                    e.target.closest('.close-popup-btn')) {
                    return; // Don't close
                }
                // Only close if clicking directly on the popup background
                if (e.target === popupImg) {
                    closePopup();
                }
            });

            // Close on Escape key
            document.addEventListener("keydown", function (e) {
                if (e.key === "Escape" && popupImg.classList.contains("open")) {
                    closePopup();
                }
            });

            console.log("[Popup] Event listeners attached");
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initImagePopup);
        } else {
            initImagePopup();
        }
    })();

    // Pincode Checker Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const pincodeInput = document.getElementById('pincode-input');
        const checkBtn = document.getElementById('check-pincode-btn');
        const deliveryInfo = document.getElementById('delivery-info');
        const deliveryEstimateText = document.getElementById('delivery-estimate-text');

        // Check pincode on button click
        checkBtn.addEventListener('click', checkDelivery);

        // Check pincode on Enter key
        pincodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkDelivery();
            }
        });

        // Auto-check when 6 digits are entered
        pincodeInput.addEventListener('input', function() {
            const pincode = this.value.trim();
            if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
                setTimeout(() => checkDelivery(), 500); // Small delay for better UX
            }
        });

        function checkDelivery() {
            const pincode = pincodeInput.value.trim();
            
            // Validate pincode
            if (!pincode || pincode.length !== 6 || !/^\d{6}$/.test(pincode)) {
                showDeliveryError('Please enter a valid 6-digit pincode');
                return;
            }

            // Show loading state
            checkBtn.textContent = 'Checking...';
            checkBtn.disabled = true;
            deliveryInfo.classList.add('hidden');

            // Make API call
            fetch('/api/shipping/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    pincode: pincode,
                    weight: 1,
                    cod_amount: 0
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    showDeliverySuccess(data.data);
                } else {
                    showDeliveryError(data.message || 'Delivery not available to this pincode');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showDeliveryError('Error checking delivery. Please try again.');
            })
            .finally(() => {
                checkBtn.textContent = 'Check';
                checkBtn.disabled = false;
            });
        }

        function showDeliverySuccess(deliveryData) {
            const shippingCharge = parseFloat(deliveryData.shipping_charge) || 0;
            const estimatedDelivery = deliveryData.estimated_delivery || '3-5 business days';
            const provider = deliveryData.provider || 'Standard';

            deliveryInfo.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ph ph-check-circle text-green-600"></i>
                        <span class="text-green-800 font-semibold text-sm">Delivery Available</span>
                    </div>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping Charge:</span>
                            <span class="font-semibold">${shippingCharge > 0 ? '₹' + shippingCharge.toFixed(2) : 'Free'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estimated Delivery:</span>
                            <span class="font-semibold">${estimatedDelivery}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Service Provider:</span>
                            <span class="font-semibold capitalize">${provider}</span>
                        </div>
                    </div>
                </div>
            `;
            
            // Update the main delivery estimate (element removed from UI)
            if (deliveryEstimateText) deliveryEstimateText.textContent = estimatedDelivery;
            
            deliveryInfo.classList.remove('hidden');
        }

        function showDeliveryError(message) {
            deliveryInfo.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <i class="ph ph-x-circle text-red-600"></i>
                        <span class="text-red-800 text-sm">${message}</span>
                    </div>
                </div>
            `;
            
            // Reset the main delivery estimate (element removed from UI)
            if (deliveryEstimateText) deliveryEstimateText.textContent = 'Enter pincode to check delivery';
            
            deliveryInfo.classList.remove('hidden');
        }
    });
</script>
