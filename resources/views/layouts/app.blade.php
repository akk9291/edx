<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'Perch Bottle')</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}" />
    
    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .quantity-block input.quantity[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
        .quantity-block input.quantity[type="number"]::-webkit-outer-spin-button,
        .quantity-block input.quantity[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Cart, Wishlist & Search icons - ensure clickable */
        .header-menu .cart-icon,
        .header-menu .wishlist-icon,
        .header-menu .search-icon {
            position: relative;
            z-index: 10;
            pointer-events: auto;
        }
        /* Header hover states */
        .user-icon .login-popup {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s, visibility 0.3s, transform 0.3s;
            right: 0;
        }
        .user-icon:hover .login-popup {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        /* Proper header order on all pages (Contact/Checkout same): purple bar top, then white nav */
        .site-header {
            display: block !important;
            position: relative !important;
            width: 100%;
            z-index: 100;
        }
        .site-header #top-nav {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
            display: block !important;
            visibility: visible !important;
        }
        .site-header #header {
            display: block !important;
            visibility: visible !important;
        }
        /* Hide Compare Product button site-wide */
        .compare-btn {
            display: none !important;
        }
        /* Mobile bottom tab bar — override global span/body line-height so labels don’t stack/overlap */
        .mobile-app-nav {
            box-sizing: border-box;
            /* Above main/footer; below modals (101) and slide menu (#menu-mobile 102) */
            z-index: 99 !important;
            position: fixed !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            max-width: 100vw !important;
            margin: 0 !important;
            background-color: #fff !important;
            border-top: 1px solid var(--line, #e9e9e9);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.07);
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            isolation: isolate;
            touch-action: manipulation;
        }
        .mobile-app-nav__grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            align-items: stretch;
            min-height: 3.5rem;
            padding-top: 0.35rem;
            padding-bottom: 0.35rem;
            width: 100%;
            max-width: 100%;
        }
        .mobile-app-nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            gap: 0.125rem;
            min-width: 0;
            padding-left: 0.0625rem;
            padding-right: 0.0625rem;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
            line-height: 1 !important;
            font-size: inherit;
            touch-action: manipulation;
        }
        .mobile-app-nav__link i {
            display: block;
            line-height: 1 !important;
            font-size: 1.25rem;
            width: 1.25rem;
            height: 1.25rem;
            text-align: center;
            flex-shrink: 0;
        }
        @media (min-width: 400px) {
            .mobile-app-nav__link i {
                font-size: 1.375rem;
                width: 1.375rem;
                height: 1.375rem;
            }
        }
        .mobile-app-nav__icon-slot {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
            flex-shrink: 0;
        }
        .mobile-app-nav__label {
            display: block;
            width: 100%;
            font-size: 0.5rem;
            line-height: 1.1 !important;
            text-align: center;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0;
            padding: 0;
            font-weight: 600;
            letter-spacing: -0.03em;
        }
        @media (min-width: 360px) {
            .mobile-app-nav__label {
                font-size: 0.5625rem;
            }
        }
        @media (min-width: 400px) {
            .mobile-app-nav__label {
                font-size: 0.625rem;
                letter-spacing: -0.02em;
            }
        }
        .mobile-app-nav .cart-quantity.mobile-app-nav__badge {
            position: absolute;
            top: -2px;
            right: -6px;
            min-width: 15px;
            height: 15px;
            padding: 0 3px;
            font-size: 9px;
            line-height: 15px !important;
            font-weight: 700;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Space above fixed bottom tab bar so grids / prices aren’t covered (matches lg:hidden breakpoint) */
        @media (max-width: 1023.98px) {
            #main-content {
                padding-bottom: calc(7.5rem + env(safe-area-inset-bottom, 0px) + 28px);
            }
            #footer.footer {
                padding-bottom: calc(6.5rem + env(safe-area-inset-bottom, 0px) + 24px);
            }
            /* Keep product text/CTA under the tab bar in compositor order */
            #main-content .product-item .product-infor,
            #main-content .product-item .product-price-block {
                position: relative;
                z-index: 0 !important;
            }
            #main-content .product-item .product-thumb .list-action {
                z-index: 1 !important;
            }
        }
    </style>
    </head>

    
<body>
    {{-- Storage path for JS (respects STORAGE_PUBLIC_PATH=media) --}}
    <script>window.STORAGE_PATH = '{{ ltrim(parse_url(config("filesystems.disks.public.url"), PHP_URL_PATH) ?? "/storage", "/") }}';</script>
    {{-- Cart, Wishlist & Search - load first, before any other script --}}
    <script>
    (function(){
        function openCart() {
            var all = document.querySelectorAll('.modal-cart-block .modal-cart-main');
            var m = all.length ? all[all.length - 1] : null;
            if (m) { m.classList.add('open'); document.body.style.overflow='hidden'; if(window.loadCartItems) window.loadCartItems(); }
            else location.href='{{ route("cart.index") }}';
        }
        function openWishlist() {
            var all = document.querySelectorAll('.modal-wishlist-block .modal-wishlist-main');
            var m = all.length ? all[all.length - 1] : null;
            if (m) { m.classList.add('open'); document.body.style.overflow='hidden'; if(window.handleItemModalWishlist) window.handleItemModalWishlist(); }
            else location.href='{{ route("wishlist") }}';
        }
        function openSearch() {
            var main = document.querySelector('.modal-search-block .modal-search-main');
            if (main) { main.classList.add('open'); document.body.style.overflow='hidden'; }
        }
        function openMobileMenuFromBottom() {
            var mm = document.getElementById('menu-mobile');
            if (mm) { mm.classList.add('open'); document.body.style.overflow='hidden'; }
        }
        document.addEventListener('click', function(e) {
            if (e.target.closest('.cart-icon')) { e.preventDefault(); e.stopPropagation(); openCart(); }
            else if (e.target.closest('[data-open-cart-modal]')) { e.preventDefault(); e.stopPropagation(); openCart(); }
            else if (e.target.closest('.wishlist-icon')) { e.preventDefault(); e.stopPropagation(); openWishlist(); }
            else if (e.target.closest('.search-icon')) { e.preventDefault(); e.stopPropagation(); openSearch(); }
            else if (e.target.closest('[data-open-search-modal]')) { e.preventDefault(); e.stopPropagation(); openSearch(); }
            else if (e.target.closest('[data-open-mobile-menu]')) { e.preventDefault(); e.stopPropagation(); openMobileMenuFromBottom(); }
        }, true);
    })();
    </script>
    {{-- Ensure purple top bar is always first (fix for checkout/contact same header) --}}
    <script>
    (function(){
        function moveTopNavFirst() {
            var topNav = document.getElementById('top-nav');
            if (topNav && topNav.parentNode && document.body.firstChild) {
                document.body.insertBefore(topNav, document.body.firstChild);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', moveTopNavFirst);
        } else {
            moveTopNavFirst();
        }
    })();
    </script>
    <div class="site-header">
        @include('partials.header')
    </div>
    
    {{-- Session Messages --}}
    @if(session('success'))
        <div class="bg-green-500 text-white py-3 px-4 text-center relative z-50" id="session-message">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">✓ {{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('session-message').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white py-3 px-4 text-center relative z-50" id="session-error">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">✕ {{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('session-error').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-500 text-black py-3 px-4 text-center relative z-50" id="session-warning">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">⚠️ {{ session('warning') }}</span>
                    @if(session('email_sent') === false)
                        <form method="POST" action="{{{ route('email.resend') }}}" class="inline-block ml-4">
                            @csrf
                            <button type="submit" class="bg-black text-white px-4 py-1 rounded hover:bg-gray-800 text-sm">
                                Resend Verification Email
                            </button>
                        </form>
                    @endif
                </div>
                <button onclick="document.getElementById('session-warning').style.display='none'" class="ml-4 text-black hover:text-gray-700 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-500 text-white py-3 px-4 text-center relative z-50" id="session-info">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">ℹ️ {{ session('info') }}</span>
                </div>
                <button onclick="document.getElementById('session-info').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif
    
    {{-- Email Verification Notice - Disabled --}}

    <main id="main-content" class="min-h-[50vh]">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.mobile-bottom-nav')
    
    <!-- Search Modal - Dynamic live search -->
    <div class="modal-search-block">
        <div class="modal-search-main md:p-10 p-6 rounded-[32px] relative">
            <div class="close-btn absolute top-6 right-6 w-10 h-10 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white z-10" onclick="document.querySelector('.modal-search-block .modal-search-main')?.classList.remove('open');document.body.style.overflow=''">
                <i class="ph ph-x text-xl"></i>
            </div>
            <div class="form-search relative w-full">
                <form method="GET" action="{{{ route('search') }}}" id="searchModalForm">
                    <input type="text" name="q" id="searchModalInput" placeholder="What are you looking for?" class="text-button-lg h-14 rounded-2xl border border-line w-full pl-6 pr-14" autocomplete="off" />
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 hover:bg-black/5 rounded-full">
                        <i class="ph ph-magnifying-glass heading5"></i>
                    </button>
                </form>
            </div>
            <div class="keyword mt-8">
                <div class="heading5">Popular searches</div>
                <div class="list-keyword flex items-center flex-wrap gap-3 mt-4">
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{{ route('search', ['q' => 'Dress']) }}}'">Dress</button>
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{{ route('search', ['q' => 'T-shirt']) }}}'">T-shirt</button>
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{{ route('search', ['q' => 'Bottle']) }}}'">Bottle</button>
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{{ route('search', ['q' => 'Top']) }}}'">Top</button>
                </div>
            </div>
            <div class="search-results-dynamic mt-8" id="searchModalResults">
                <div class="heading6" id="searchResultsTitle">Latest products</div>
                <div class="list-product pb-5 hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 mt-4" id="searchModalProductList">
                    @php
                        $recentProducts = \App\Models\Product::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(4)
                            ->get();
                    @endphp
                    @forelse($recentProducts as $product)
                        <div class="product-item grid-type search-default-product">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="body1 text-secondary">No products yet. Start typing to search.</p>
                        </div>
                    @endforelse
                </div>
                <div class="search-loading hidden text-center py-6" id="searchModalLoading">
                    <span class="body1 text-secondary">Searching...</span>
                </div>
                <a href="{{{ route('search') }}}" class="button-main w-full text-center mt-4 hidden" id="searchModalViewAll">View all results</a>
            </div>
        </div>
    </div>
    
    <!-- Wishlist Modal -->
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
                <a href="{{ route('wishlist') }}" class="button-main w-full text-center uppercase block"> View All Wish List</a>
                <a href="{{ route('shop') }}" class="text-button-uppercase continue mt-2 text-center has-line-before cursor-pointer inline-block block">Continue shopping</a>
            </div>
        </div>
    </div>
    
    <!-- Quick View Modal -->
    <div class="modal-quickview-block">
        <div class="modal-quickview-main py-6">
            <div class="flex h-full max-md:flex-col-reverse gap-y-6">
                <div class="left lg:w-[388px] md:w-[300px] flex-shrink-0 px-6">
                    <div class="list-img max-md:flex items-center gap-4 flex flex-col">
                        <div class="qv-main-img bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                        </div>
                        <div class="qv-thumbs flex gap-2 mt-2 flex-wrap" style="display:none;"></div>
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
                                <div class="category caption2 text-secondary font-semibold uppercase"></div>
                                <div class="name heading4 mt-1"></div>
                            </div>
                            <div class="add-wishlist-btn w-10 h-10 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white" data-product-id="">
                                <i class="ph ph-heart text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap mt-5 pb-4 border-b border-line">
                            <div class="product-price heading5"></div>
                            <div class="product-origin-price font-normal text-secondary2" style="display:none"><del></del></div>
                            <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full" style="display:none"></div>
                            <div class="qv-stock caption2 text-secondary mt-1" style="display:none"></div>
                        </div>
                        <div class="qv-description-block mt-4 pb-4 border-b border-line" style="display:none">
                            <div class="text-button-uppercase text-secondary2 mb-1.5">Description</div>
                            <div class="qv-description text-secondary body2 line-clamp-4 max-h-24 overflow-y-auto"></div>
                        </div>
                        <div class="qv-specs-block mt-4 pb-4 border-b border-line" style="display:none">
                            <div class="text-button-uppercase text-secondary2 mb-1.5">Specifications</div>
                            <div class="qv-specs body2 text-secondary"></div>
                        </div>
                        <div class="list-action mt-6">
                            <div class="qv-size-block mt-3" style="display:none">
                                <div class="text-button-uppercase text-secondary2 mb-1.5">Size</div>
                                <div class="list-size flex items-center gap-2 flex-wrap"></div>
                            </div>
                            <div class="qv-color-block mt-3" style="display:none">
                                <div class="text-button-uppercase text-secondary2 mb-1.5">Color</div>
                                <div class="list-color flex items-center gap-2 flex-wrap"></div>
                            </div>
                            <div class="choose-quantity flex items-center gap-5 mt-3">
                                <div class="quantity-block md:p-3 flex items-center justify-between rounded-lg border border-line sm:w-[180px] w-[120px] flex-shrink-0">
                                    <i class="ph-bold ph-minus cursor-pointer body1 quantity-decrease-qv"></i>
                                    <input type="number" min="1" max="9999" step="1" value="1" inputmode="numeric" aria-label="Quantity" class="quantity body1 font-semibold w-12 min-w-[3rem] text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" />
                                    <i class="ph-bold ph-plus cursor-pointer body1 quantity-increase-qv"></i>
                                </div>
                                <div class="add-cart-btn button-main w-full text-center bg-white text-black border border-black cursor-pointer" data-product-id="">Add To Cart</div>
                            </div>
                            <a href="#" class="button-main w-full text-center mt-5 block view-product-link">View Full Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cart Modal -->
    <div class="modal-cart-block">
        <div class="modal-cart-main flex">
            <div class="left w-1/2 border-r border-line py-6 max-md:hidden">
                <div class="heading5 px-6 pb-3">You May Also Like</div>
                <div class="list px-6">
                    <!-- Products will be loaded dynamically -->
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
                        Buy <span class="text-button"> ₹<span class="more-price">150</span>.00 </span>
                        <span>more to get </span>
                        <span class="text-button">freeship</span>
                    </div>
                    <div class="tow-bar-block mt-3">
                        <div class="progress-line"></div>
                    </div>
                </div> -->
                <div class="list-cart px-6 overflow-y-auto max-h-[400px]">
                    <!-- Cart items will be loaded dynamically -->
                </div>
                <div class="footer-cart p-6 border-t border-line bg-white absolute bottom-0 left-0 w-full">
                    <div class="total flex items-center justify-between mb-4">
                        <div class="text-button-uppercase">Total:</div>
                        <div class="text-title">₹<span class="total-price">0.00</span></div>
                    </div>
                    <a href="{{{ route('checkout.index') }}}" class="button-main w-full text-center uppercase">Checkout</a>
                    <a href="{{{ route('cart.index') }}}" class="button-main w-full text-center uppercase mt-3 bg-white border border-black text-black hover:bg-black hover:text-white">View Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.scripts')
    @yield('scripts')
    @stack('scripts')
    
    <script>
        // Header interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu: .open class handled in assets/js/main.js (avoid duplicate .active handlers)

            // Close search modal (backdrop click + ESC)
            const searchModal = document.querySelector('.modal-search-block');
            const searchModalMain = document.querySelector('.modal-search-block .modal-search-main');
            if (searchModal && searchModalMain) {
                searchModal.addEventListener('click', function(e) {
                    if (e.target === searchModal) {
                        searchModalMain.classList.remove('open');
                        document.body.style.overflow = '';
                    }
                });
                searchModalMain.addEventListener('click', function(e) { e.stopPropagation(); });
            }
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const sm = document.querySelector('.modal-search-block .modal-search-main');
                    if (sm && sm.classList.contains('open')) {
                        sm.classList.remove('open');
                        document.body.style.overflow = '';
                    }
                    if (menuMobile && menuMobile.classList.contains('active')) {
                        menuMobile.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            });

            // Dynamic live search in modal
            const searchInput = document.getElementById('searchModalInput');
            const searchList = document.getElementById('searchModalProductList');
            const searchTitle = document.getElementById('searchResultsTitle');
            const searchLoading = document.getElementById('searchModalLoading');
            const searchViewAll = document.getElementById('searchModalViewAll');
            const defaultProducts = searchList ? searchList.innerHTML : '';
            let searchTimeout = null;
            if (searchInput && searchList) {
                searchInput.addEventListener('input', function() {
                    const q = (this.value || '').trim();
                    clearTimeout(searchTimeout);
                    if (q.length >= 2) {
                        searchLoading.classList.remove('hidden');
                        searchList.classList.add('hidden');
                        searchViewAll.classList.add('hidden');
                        searchTimeout = setTimeout(function() {
                            fetch('{{ url("/search/ajax") }}?q=' + encodeURIComponent(q))
                                .then(r => r.text())
                                .then(html => {
                                    searchList.innerHTML = html || '<div class="col-span-full text-center py-8"><p class="body1 text-secondary">No products found</p></div>';
                                    searchList.classList.remove('hidden');
                                    searchTitle.textContent = 'Search results for "' + q + '"';
                                    searchViewAll.href = '{{ url("/search") }}?q=' + encodeURIComponent(q);
                                    searchViewAll.classList.remove('hidden');
                                })
                                .catch(function() {
                                    searchList.innerHTML = '<div class="col-span-full text-center py-8"><p class="body1 text-secondary">Search failed. Try again.</p></div>';
                                    searchList.classList.remove('hidden');
                                })
                                .finally(function() {
                                    searchLoading.classList.add('hidden');
                                    if (window.handleItemModalWishlist) window.handleItemModalWishlist();
                                    if (window.initQuickView) window.initQuickView?.();
                                });
                        }, 300);
                    } else {
                        searchList.innerHTML = defaultProducts;
                        searchList.classList.remove('hidden');
                        searchTitle.textContent = q.length ? 'Type at least 2 characters...' : 'Latest products';
                        searchViewAll.classList.add('hidden');
                        searchLoading.classList.add('hidden');
                    }
                });
                searchInput.addEventListener('focus', function() {
                    const q = (this.value || '').trim();
                    if (q.length >= 2) {
                        searchTitle.textContent = 'Search results for "' + q + '"';
                        searchViewAll.href = '{{ url("/search") }}?q=' + encodeURIComponent(q);
                        searchViewAll.classList.remove('hidden');
                    }
                });
            }
            
        });
    </script>
</body>
</html>
