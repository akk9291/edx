@php
    $navHomeActive = request()->routeIs('home');
    $navShopActive = request()->routeIs('shop') || request()->routeIs('shop.collection') || request()->routeIs('category') || request()->routeIs('product.show');
    $navCustomizeActive = request()->routeIs('customize') || request()->routeIs('customize.product');
    $navCartActive = request()->routeIs('cart.index');
    $navAccountActive = request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('my-account') || request()->routeIs('account.orders.show');
    $accountUrl = auth()->check() ? route('my-account') : route('login');
@endphp
<nav class="mobile-app-nav lg:hidden" style="padding-bottom: env(safe-area-inset-bottom, 0px); padding-left: env(safe-area-inset-left, 0px); padding-right: env(safe-area-inset-right, 0px);" aria-label="App menu">
    <div class="mobile-app-nav__grid max-w-full mx-auto">
        <a href="{{ route('home') }}" class="mobile-app-nav__link {{ $navHomeActive ? 'text-black' : 'text-secondary2' }}">
            <span class="mobile-app-nav__icon-slot" aria-hidden="true">
                <i class="ph {{ $navHomeActive ? 'ph-fill ph-house' : 'ph ph-house' }}"></i>
            </span>
            <span class="mobile-app-nav__label">Home</span>
        </a>
        <a href="{{ route('shop') }}" class="mobile-app-nav__link {{ $navShopActive ? 'text-black' : 'text-secondary2' }}">
            <span class="mobile-app-nav__icon-slot" aria-hidden="true">
                <i class="ph {{ $navShopActive ? 'ph-fill ph-storefront' : 'ph ph-storefront' }}"></i>
            </span>
            <span class="mobile-app-nav__label">Shop</span>
        </a>
        <button type="button" data-open-search-modal class="mobile-app-nav__link text-secondary2 bg-transparent border-0 cursor-pointer p-0 font-inherit w-full">
            <span class="mobile-app-nav__icon-slot" aria-hidden="true">
                <i class="ph ph-magnifying-glass"></i>
            </span>
            <span class="mobile-app-nav__label">Search</span>
        </button>
        <a href="{{ route('customize') }}" class="mobile-app-nav__link {{ $navCustomizeActive ? 'text-black' : 'text-secondary2' }}">
            <span class="mobile-app-nav__icon-slot" aria-hidden="true">
                <i class="ph {{ $navCustomizeActive ? 'ph-fill ph-paint-brush' : 'ph ph-paint-brush' }}"></i>
            </span>
            <span class="mobile-app-nav__label">Customize</span>
        </a>
        <button type="button" data-open-cart-modal class="mobile-app-nav__link bg-transparent border-0 cursor-pointer p-0 font-inherit w-full {{ $navCartActive ? 'text-black' : 'text-secondary2' }}">
            <span class="mobile-app-nav__icon-slot" aria-hidden="true">
                <i class="ph {{ $navCartActive ? 'ph-fill ph-handbag' : 'ph ph-handbag' }}"></i>
                <span class="cart-quantity mobile-app-nav__badge text-white bg-black">0</span>
            </span>
            <span class="mobile-app-nav__label">Cart</span>
        </button>
        <a href="{{ $accountUrl }}" class="mobile-app-nav__link {{ $navAccountActive ? 'text-black' : 'text-secondary2' }}">
            <span class="mobile-app-nav__icon-slot" aria-hidden="true">
                <i class="ph {{ $navAccountActive ? 'ph-fill ph-user' : 'ph ph-user' }}"></i>
            </span>
            <span class="mobile-app-nav__label">Account</span>
        </a>
    </div>
</nav>
