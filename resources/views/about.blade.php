@extends('layouts.app')

@section('title', 'About Us - Perch Bottle')

@section('content')
<div class="page-content about-page-content">
    <!-- Menu bar (mobile) -->
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">About Us</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <div class="text-secondary2 capitalize">About Us</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="slider-block style-one bg-linear xl:py-[100px] px-4 md:py-20 py-14 w-full">
        <div class="slider-main h-full w-full flex items-center justify-center gap-10">
            <div class="sub-img w-[440px] max-md:w-1/2 rounded-b-full overflow-hidden max-md:hidden">
                <img src="{{ asset('assets/images/slider/bg-underwear1.png') }}" alt="bg-underwear1" class="w-full">
            </div>
            <div class="text-content w-fit">
                <div class="text-sub-display text-center">Welcome to Perch.</div>
                <div class="heading2 text-center md:mt-4 mt-2">Everyday lifestyle essentials. Thoughtfully designed.</div>
            </div>
            <div class="sub-img w-[440px] max-md:w-1/2 rounded-t-full overflow-hidden">
                <img src="{{ asset('assets/images/slider/bg-underwear2.png') }}" alt="bg-underwear2" class="w-full">
            </div>
        </div>
    </div>

    <div class="about md:pt-20 pt-10">
        <div class="about-us-block">
            <div class="container">
                <div class="text flex items-center justify-center">
                    <div class="content md:w-5/6 w-full">
                        <div class="heading3 text-center">About Perch</div>
                        <div class="heading4 text-center">Modern Lifestyle Brand for Everyday Essentials</div>
                        <div class="body1 text-center md:mt-7 mt-5">
                            @php $aboutContent = \App\Models\Setting::get('about_us'); @endphp
                            @if($aboutContent)
                                {!! nl2br(e($aboutContent)) !!}
                            @else
                                Perch is a modern lifestyle brand creating thoughtfully designed everyday essentials for work, home, travel, and everything in between. What started with premium insulated bottles has evolved into a growing collection across drinkware, barware, kitchenware, tiffin boxes, and utility essentials — with many more categories launching soon.
                                Built for people who value design, functionality, and quality, Perch brings together products that look good, feel premium, and perform effortlessly in everyday life.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="choose-us-block md:pt-20 pt-14">
        <div class="container flex max-lg:flex-col max-lg:gap-y-8 items-center justify-between">
            <div class="bg-img lg:w-7/12 lg:pr-[45px] md:w-1/2 w-5/6">
                <img src="{{ asset('assets/images/banner/bg-choose-us-pet.png') }}" alt="bg-img" class="w-full">
            </div>
            <div class="content lg:w-5/12 lg:pl-[45px]">
                <div class="heading3">Designed for Modern Living</div>
                <div class="heading6 font-normal text-secondary mt-3">At Perch, we believe everyday products should simplify life while elevating it. Every product is designed with a clear purpose - to blend seamlessly into your routine.</div>
                <div class="list-feature lg:mt-10 mt-6">
                    <div class="heading5">Our range is: -</div>
                    <div class="item flex items-center gap-5">
                        <div class="icon bg-[#D1D0F9] rounded-full">
                            <i class="icon-return md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                        </div>
                        <div class="text-content">
                            <div class="heading6">Functional & durable</div>
                            <div class="caption1 text-secondary mt-2">made for daily, long-term use</div>
                        </div>
                    </div>
                    <div class="item flex items-center gap-5 lg:mt-8 mt-4">
                        <div class="icon bg-[#D1D0F9] rounded-full">
                            <i class="icon-category md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                        </div>
                        <div class="text-content">
                            <div class="heading6">Minimal & modern</div>
                            <div class="caption1 text-secondary mt-2">clean designs that never go out of style</div>
                        </div>
                    </div>
                    <div class="item flex items-center gap-5 lg:mt-8 mt-4">
                        <div class="icon bg-[#D1D0F9] rounded-full">
                            <i class="icon-guarantee md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                        </div>
                        <div class="text-content">
                            <div class="heading6">Safe & reliable</div>
                            <div class="caption1 text-secondary mt-2">crafted using high-quality, food-grade materials</div>
                        </div>
                    </div>
                </div>
                <div class="body1 font-normal text-secondary mt-3">From keeping beverages hot or cold, to organising meals, upgrading your bar setup, or improving your kitchen experience - Perch products are made to work beautifully, every day.</div>
            </div>
        </div>
    </div>

    <div class="quote-block bg-linear py-[60px]">
        <div class="container items-center justify-center">
            <div class="heading3 font-medium text-center">A Lifestyle Brand, Not Just Products</div>
            <div class="body1 font-normal text-secondary mt-7 text-center">
                Perch goes beyond utility. We're building a lifestyle brand rooted in conscious choices, modern aesthetics, and everyday practicality. Our focus is on: - Premium materials that are safe, sustainable, and long-lasting - Thoughtful innovation that solves real-life needs - Timeless designs that complement modern homes and lifestyles
            </div>
            <div class="heading6 mt-7 font-medium text-center">We design essentials you'll reach for every day — not trends you'll replace tomorrow.</div>
        </div>
    </div>

    <div class="why-choose-us md:pt-20 pt-10">
        <div class="container">
            <div class="content flex max-lg:flex-col items-center justify-between gap-y-8">
                <div class="left lg:w-1/2 sm:w-2/3 w-full lg:pr-4">
                    <div class="bg-img">
                        <img src="{{ asset('assets/images/banner/bg-benefit-yoga.png') }}" alt="bg" class="w-full rounded-2xl">
                    </div>
                </div>
                <div class="right lg:w-1/2 lg:pl-16">
                    <div class="heading3">Growing With You</div>
                    <div class="text-secondary mt-5">
                        As lifestyles evolve, so do we. Perch is continuously expanding into new categories while staying true to our core values of quality, functionality, and design.
                        Whether it's your morning coffee, office lunch, home bar, kitchen shelf, or travel bag — Perch is designed to be a part of your everyday moments.
                    </div>
                    <div class="heading5 mt-7">Why Choose Perch?</div>
                    <div class="list-feature mt-6 pt-6 border-t border-line">
                        <div class="item flex items-center justify-between pb-3 border-b border-line">
                            <div class="body1">Premium lifestyle brand for everyday essentials</div>
                        </div>
                        <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                            <div class="body1">Designed in India for modern, urban living</div>
                        </div>
                        <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                            <div class="body1">High-quality drinkware, barware, kitchenware & more</div>
                        </div>
                        <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                            <div class="body1">Functional, minimal, and durable products</div>
                        </div>
                        <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                            <div class="body1">Built for work, home, travel, and gifting</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="benefit-block md:pt-20 pt-10">
        <div class="container">
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

    <div class="container">
        <div class="newsletter-block md:py-20 sm:py-14 py-10 sm:px-8 px-6 sm:rounded-[32px] rounded-3xl flex flex-col items-center bg-green md:mt-20 mt-10">
            <div class="heading3 text-white text-center">Sign up and get 10% off</div>
            <div class="text-white text-center mt-3">Sign up for early sale access, new in, promotions and more</div>
            <div class="input-block lg:w-1/2 sm:w-3/5 w-full h-[52px] sm:mt-10 mt-7">
                <form class="w-full h-full relative" method="POST" action="{{ route('newsletter.subscribe') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your e-mail" class="caption1 w-full h-full pl-4 pr-14 rounded-xl border border-line" required />
                    <button type="submit" class="button-main bg-green text-black absolute top-1 bottom-1 right-1 flex items-center justify-center">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
