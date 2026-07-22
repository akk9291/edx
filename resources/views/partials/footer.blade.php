<div id="footer" class="footer mt-8" style="position: relative; z-index: 10; display: block !important; visibility: visible !important; width: 100%; clear: both;">
    <div class="footer-main bg-surface">
        <div class="container">
            <div class="content-footer md:py-[60px] py-10 flex justify-between flex-wrap gap-y-8">
                <div class="company-infor basis-1/4 max-lg:basis-full pr-7">
                    <a href="{{{ route('home') }}}" class="logo inline-block">
                        @php $footerLogo = \App\Models\Setting::get('site_logo'); @endphp
                        <img src="{{ $footerLogo ? storage_asset($footerLogo) : asset('assets/images/perch-logo.png') }}" alt="{{ \App\Models\Setting::get('site_name', 'Perch') }}" />
                    </a>
                    @php
                        $footerAboutText = \App\Models\Setting::get('contact_page_text');
                        $footerAboutHtml = $footerAboutText ? strip_tags($footerAboutText, '<p><br><strong><b><em><i><u><a><span>') : '';
                        $footerAboutMeaningful = $footerAboutHtml !== '' && strlen(trim(strip_tags($footerAboutHtml))) > 15 && !preg_match('/^(\s*(Hi|hi|test|Test)\s*)+$/i', trim(strip_tags($footerAboutHtml)));
                    @endphp
                    @if($footerAboutMeaningful)
                        <div class="footer-about-text caption1 text-secondary mt-4 max-w-sm prose prose-sm max-w-none">{!! $footerAboutHtml !!}</div>
                    @endif

                    @php
                        $footerEmail = \App\Models\Setting::get('contact_email', 'ecom@perchbottle.in');
                        $footerPhone = \App\Models\Setting::get('contact_phone', '');
                        $footerHelpline = \App\Models\Setting::get('helpline_number', '');
                        $addr = \App\Models\Setting::get('contact_address', '');
                        $city = \App\Models\Setting::get('contact_city', '');
                        $state = \App\Models\Setting::get('contact_state', '');
                        $pincode = \App\Models\Setting::get('contact_pincode', '');
                        $footerAddress = trim(implode(', ', array_filter([$addr, $city, $state, $pincode]))) ?: 'Delhi, India';
                    @endphp
                    <div class="list-social flex items-center gap-6 mt-4">
                            @php $sfb = \App\Models\Setting::get('facebook_url'); @endphp
                            @if($sfb)<a href="{{ $sfb }}" target="_blank"><div class="icon-facebook text-2xl text-black"></div></a>@endif
                            @php $sig = \App\Models\Setting::get('instagram_url'); @endphp
                            @if($sig)<a href="{{ $sig }}" target="_blank"><div class="icon-instagram text-2xl text-black"></div></a>@endif
                            @php $stw = \App\Models\Setting::get('twitter_url'); @endphp
                            @if($stw)<a href="{{ $stw }}" target="_blank"><div class="icon-twitter text-2xl text-black"></div></a>@endif
                            @php $syt = \App\Models\Setting::get('youtube_url'); @endphp
                            @if($syt)<a href="{{ $syt }}" target="_blank"><div class="icon-youtube text-2xl text-black"></div></a>@endif
                            @php $spin = \App\Models\Setting::get('pinterest_url'); @endphp
                            @if($spin)<a href="{{ $spin }}" target="_blank"><div class="icon-pinterest text-2xl text-black"></div></a>@endif
                        </div>
                </div>
                <div class="right-content flex flex-wrap gap-y-8 basis-3/4 max-lg:basis-full">
                    <div class="list-nav flex justify-between basis-2/3 max-md:basis-full gap-4">
                        <div class="item flex flex-col basis-1/3">
                            <div class="text-button-uppercase pb-3">Information</div>
                            <a class="caption1 has-line-before duration-300 w-fit" href="{{ route('about') }}">About Us</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{ route('contact') }}">Contact us</a>
                            <!-- <a class="caption1 has-line-before duration-300 w-fit pt-2" href="#!"> Career </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('my-account') }}}"> My Account</a> -->
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('order-tracking') }}}"> Orders & Returns</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('faqs') }}}">FAQs </a>
                        </div>
                        <div class="item flex flex-col basis-1/3">
                            @php
                                /* Quick Shop: dynamic from main categories only (same as header: Drinkware, Barware, Kitchenware) */
                                $footerQuickShopMainCategories = \App\Models\MainCategory::where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->with(['activeCategories' => function ($q) {
                                        $q->whereNull('parent_id')->orderBy('sort_order');
                                    }])
                                    ->get();
                                $quickShopLinks = [];
                                foreach ($footerQuickShopMainCategories as $mainCat) {
                                    $firstCat = $mainCat->activeCategories->first();
                                    if ($firstCat) {
                                        $quickShopLinks[] = ['name' => $mainCat->name, 'url' => route('category', $firstCat->slug)];
                                    }
                                }
                                if (empty($quickShopLinks)) {
                                    $quickShopLinks[] = ['name' => 'Shop', 'url' => route('shop')];
                                }
                            @endphp
                            <div class="text-button-uppercase pb-3">Quick Shop</div>
                            <div class="flex flex-col">
                                @foreach($quickShopLinks as $i => $link)
                                    <a class="caption1 has-line-before duration-300 w-fit {{ $i > 0 ? 'pt-2' : '' }}" href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="item flex flex-col basis-1/3">
                            <div class="text-button-uppercase pb-3">Policy Pages</div>
                            <!-- <a class="caption1 has-line-before duration-300 w-fit" href="{{{ route('faqs') }}}">FAQs</a>z
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('faqs') }}}">Shipping</a> -->
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('terms-and-conditions') }}}">Terms & Conditions</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('privacy-policy') }}}">Privacy Policy</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('return-and-refund') }}}">Return & Refund</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('cancellation-policy') }}}">Cancellation Policy</a>
                        </div>
                    </div>
                    <div class="newsletter basis-1/3 pl-7 max-md:basis-full max-md:pl-0">
                        <div class="text-button-uppercase">Contact Details</div>
                        <div class="flex gap-3 mt-3">
                        <div class="flex flex-col">
                            <span class="text-button">Mail:</span>
                            <span class="text-button mt-3">Phone:</span>
                            @if($footerHelpline)<span class="text-button mt-3">Helpline:</span>@endif
                            <span class="text-button mt-3">Address:</span>
                        </div>
                        <div class="flex flex-col">
                            <span>{{ $footerEmail }}</span>
                            <span class="mt-[14px]">{{ $footerPhone }}</span>
                            @if($footerHelpline)<span class="mt-[14px]">{{ $footerHelpline }}</span>@endif
                            <span class="mt-3 pt-1">{{ $footerAddress }}</span>
                        </div>
                    </div>
                        <!-- <div class="caption1 mt-3">zSign up for our newsletter and get 10% off your first purchase</div>
                        <div class="input-block w-full h-[52px] mt-4">
                            <form class="w-full h-full relative" method="POST" action="{{{ route('newsletter.subscribe') }}}">
                                @csrf
                                <input type="email" name="email" placeholder="Enter your e-mail" class="caption1 w-full h-full pl-4 pr-14 rounded-xl border border-line" required />
                                <button type="submit" class="w-[44px] h-[44px] bg-black flex items-center justify-center rounded-xl absolute top-1 right-1">
                                    <i class="ph ph-arrow-right text-xl text-white"></i>
                                </button>
                            </form>
                        </div> -->
                      
                    </div>
                </div>
            </div>
            <div class="footer-bottom py-3 flex items-center justify-between gap-5 max-lg:justify-center max-lg:flex-col border-t border-line">
                <div class="left flex items-center gap-8">
                    @php
                        $copyrightRaw = \App\Models\Setting::get('copyright_text', '©' . date('Y') . ' Perch. All Rights Reserved.');
                        $copyrightText = $copyrightRaw ?: ('©' . date('Y') . ' Perch. All Rights Reserved.');
                        $copyrightText = preg_replace('/\b(19|20)\d{2}\b/', date('Y'), $copyrightText);
                    @endphp
                    <div class="copyright caption1 text-secondary">{{ $copyrightText }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top-btn" href="#top-nav"><i class="ph-bold ph-caret-up"></i></a>
