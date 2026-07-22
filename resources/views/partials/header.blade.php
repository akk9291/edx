<div id="top-nav" class="top-nav style-two bg-purple md:h-[44px] h-[30px]" style="position: relative !important; top: auto !important; bottom: auto !important; display: block !important; visibility: visible !important;">
            <div class="container mx-auto h-full">
                <div class="top-nav-main flex justify-between max-md:justify-center h-full">
                    <div class="left-content flex items-center gap-5 max-md:hidden"></div>
                    <div class="text-center text-button-uppercase text-white flex items-center">{{ \App\Models\Setting::get('free_shipping_text', 'FREE SHIPPING ON ALL ORDERS OVER ₹75') }}</div>
                    <div class="right-content flex items-center gap-5 max-md:hidden">
                        @php $fb = \App\Models\Setting::get('facebook_url'); @endphp
                        @if($fb)<a href="{{ $fb }}" target="_blank"><i class="icon-facebook text-white"></i></a>@endif
                        @php $ig = \App\Models\Setting::get('instagram_url'); @endphp
                        @if($ig)<a href="{{ $ig }}" target="_blank"><i class="icon-instagram text-white"></i></a>@endif
                        @php $yt = \App\Models\Setting::get('youtube_url'); @endphp
                        @if($yt)<a href="{{ $yt }}" target="_blank"><i class="icon-youtube text-white"></i></a>@endif
                        @php $tw = \App\Models\Setting::get('twitter_url'); @endphp
                        @if($tw)<a href="{{ $tw }}" target="_blank"><i class="icon-twitter text-white"></i></a>@endif
                        @php $pin = \App\Models\Setting::get('pinterest_url'); @endphp
                        @if($pin)<a href="{{ $pin }}" target="_blank"><i class="icon-pinterest text-white"></i></a>@endif
                    </div>
                </div>
            </div>
        </div>

        <div id="header" class="relative w-full">
            <div class="header-menu style-one relative  w-full md:h-[74px] h-[56px]">
                <div class="container mx-auto h-full">
                    <div class="header-main flex justify-between h-full">
                        <div class="menu-mobile-icon flex items-center">
                            <i class="icon-category text-2xl flex-shrink-0 cursor-pointer" aria-hidden="true" title="Menu"></i>
                            <a href="{{{ route('home') }}}" class="flex items-center px-10">
                                @php $logo = \App\Models\Setting::get('site_logo'); @endphp
                                <img src="{{ $logo ? storage_asset($logo) : asset('assets/images/perch-logo.png') }}" alt="{{ \App\Models\Setting::get('site_name', 'Perch') }}" class="h-8 md:h-10 object-contain" />
                            </a>
                        </div>
                        
                        <div class="menu-main h-full max-lg:hidden">
                            @php
                                $headerMainCategories = \App\Models\MainCategory::where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->with(['activeCategories' => function ($q) {
                                        $q->whereNull('parent_id');
                                    }])
                                    ->get();
                            @endphp
                            <ul class="flex items-center gap-8 h-full">
                                @foreach($headerMainCategories as $mainCat)
                                    @php $primaryCat = $mainCat->activeCategories->first(); @endphp
                                    @if($primaryCat)
                                        <li class="h-full">
                                            <a href="{{ route('category', $primaryCat->slug) }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center">{{ $mainCat->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                                <li class="h-full">
                                    <a href="{{ route('about') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center">About Us</a>
                                </li>
                                <li class="h-full">
                                    <a href="{{ route('contact') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center">Contact Us</a>
                                </li>
                                <li class="h-full flex items-center gap-2">
                                    <a href="{{ route('customize') }}" class="text-button-uppercase bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 duration-300">Customize</a>
                                </li>
                            </ul>
                        </div>
                        <div class="right flex gap-12 z-[1]">
                            <div class="max-md:hidden search-icon flex items-center cursor-pointer relative">
                                <i class="ph-bold ph-magnifying-glass text-2xl"></i>
                                <div class="line absolute bg-line w-px h-6 -right-6"></div>
                            </div>
                            <div class="list-action flex items-center gap-4">
                                <div class="user-icon flex items-center justify-center cursor-pointer relative">
                                    <i class="ph-bold ph-user text-2xl"></i>
                                    <div class="login-popup absolute top-[74px] w-[320px] p-7 rounded-xl bg-white box-shadow-sm">
                                        @auth
                                            <div class="text-center mb-4">
                                                <div class="body1 text-black font-medium">{{ Auth::user()->name }}</div>
                                                <div class="caption1 text-secondary">{{ Auth::user()->email }}</div>
                                            </div>
                                            <a href="{{{ route('my-account') }}}" class="button-main w-full text-center">My Account</a>
                                            @if(Auth::user()->role === 'admin')
                                                <a href="{{{ route('admin.dashboard') }}}" class="button-main bg-white text-black border border-black w-full text-center mt-3">Dashboard</a>
                                            @endif
                                            <div class="bottom mt-4 pt-4 border-t border-line"></div>
                                            <form method="POST" action="{{{ route('logout') }}}">
                                                @csrf
                                                <button type="submit" class="body1 hover:underline w-full text-left">Logout</button>
                                            </form>
                                        @else
                                            <a href="{{{ route('login') }}}" class="button-main w-full text-center">Login</a>
                                            <div class="text-secondary text-center mt-3 pb-4">
                                                Don't have an account?
                                                <a href="{{{ route('register') }}}" class="text-black pl-1 hover:underline">Register </a>
                                            </div>
                                            <a href="{{{ route('admin.dashboard') }}}" class="button-main bg-white text-black border border-black w-full text-center">Dashboard</a>
                                            <div class="bottom mt-4 pt-4 border-t border-line"></div>
                                            <a href="#!" class="body1 hover:underline">Support</a>
                                        @endauth
                                    </div>
                                </div>
                                <a href="javascript:void(0)" role="button" class="max-md:hidden wishlist-icon flex items-center relative cursor-pointer no-underline text-inherit" onclick="var m=document.querySelectorAll('.modal-wishlist-block .modal-wishlist-main');var el=m.length?m[m.length-1]:null;if(el){el.classList.add('open');document.body.style.overflow='hidden';if(window.handleItemModalWishlist)window.handleItemModalWishlist();}return false">
                                    <i class="ph-bold ph-heart text-2xl"></i>
                                    <span class="quantity wishlist-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                                </a>
                                <a href="javascript:void(0)" role="button" class="max-md:hidden cart-icon flex items-center relative cursor-pointer no-underline text-inherit" onclick="var m=document.querySelectorAll('.modal-cart-block .modal-cart-main');var el=m.length?m[m.length-1]:null;if(el){el.classList.add('open');document.body.style.overflow='hidden';if(window.loadCartItems)window.loadCartItems();}return false">
                                    <i class="ph-bold ph-handbag text-2xl"></i>
                                    <span class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="menu-mobile" class="">
                <div class="menu-container bg-white h-full">
                    <div class="container h-full">
                <div class="menu-main h-full overflow-x-hidden scroll2">
                            <div class="heading py-2 relative flex items-center justify-center">
                                <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                                    <i class="ph ph-x text-sm"></i>
                                </div>
                        <a href="{{ route('home') }}" class="logo flex justify-center">
                                @php $mobileLogo = \App\Models\Setting::get('site_logo'); @endphp
                                <img src="{{ $mobileLogo ? storage_asset($mobileLogo) : asset('assets/images/perch-logo.png') }}" alt="{{ \App\Models\Setting::get('site_name', 'Perch') }}" class="h-10 object-contain" />
                            </a>
                            </div>
                            <div class="form-search relative mt-2">
                                <form method="GET" action="{{{ route('shop') }}}">
                                    <i class="ph ph-magnifying-glass text-xl absolute left-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                                    <input type="text" 
                                           name="search" 
                                           placeholder="What are you looking for?" 
                                           value="{{ request()->get('search') }}"
                                           class="h-12 rounded-lg border border-line text-sm w-full pl-10 pr-4" />
                                </form>
                            </div>
                    
                            <div class="list-nav mt-6">
                        @php
                            $mobileMainCategories = \App\Models\MainCategory::where('is_active', true)
                                ->orderBy('sort_order')
                                ->with(['activeCategories' => function ($q) {
                                    $q->whereNull('parent_id')->with(['children' => function ($q2) {
                                        $q2->where('is_active', true)->orderBy('sort_order')->with(['children' => function ($q3) {
                                            $q3->where('is_active', true)->orderBy('sort_order');
                                        }]);
                                    }]);
                                }])
                                ->get();
                        @endphp
                        
                        <ul>
                            @foreach($mobileMainCategories as $mainCat)
                                @php $primaryCat = $mainCat->activeCategories->first(); @endphp
                                @if($primaryCat)
                                    <li>
                                        <a href="{{ $primaryCat->children->count() > 0 ? '#!' : route('category', $primaryCat->slug) }}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all justify-between">
                                            {{ $mainCat->name }}
                                            @if($primaryCat->children->count() > 0)
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                            @endif
                                        </a>
                                        @if($primaryCat->children->count() > 0)
                                            <div class="sub-nav-mobile">
                                                <div class="back-btn flex items-center gap-3">
                                                    <i class="ph ph-caret-left text-xl"></i>
                                                    Back
                                                </div>
                                                <div class="list-nav-item w-full grid grid-cols-2 pt-2 pb-6">
                                                    @foreach($primaryCat->children as $subCategory)
                                                        <div class="nav-item">
                                                            <a href="{{ route('category', $subCategory->slug) }}" class="text-title duration-300">{{ $subCategory->name }}</a>
                                                            @if($subCategory->children->count() > 0)
                                                                <ul class="mt-2">
                                                                    @foreach($subCategory->children as $childCategory)
                                                                        <li>
                                                                            <a href="{{ route('category', $childCategory->slug) }}" class="link text-secondary duration-300">{{ $childCategory->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                                                            <li>
                                <a href="{{{ route('shop') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all">Shop</a>
                                                            </li>
                                                            <li>
                                <a href="{{{ route('about') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all">About Us</a>
                                                            </li>
                                                            <li>
                                <a href="{{{ route('contact') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all">Contact Us</a>
                                                            </li>
                                                            <li>
                                <a href="{{{ route('faqs') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all">FAQs</a>
                                                            </li>
                                                            <li class="px-4 mt-2">
                                <a href="{{ route('customize') }}" class="text-lg font-semibold flex items-center justify-center py-3 px-4 rounded-lg transition-all bg-black text-white">Customize</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
