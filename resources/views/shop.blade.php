@extends('layouts.app')

@section('title', 'Shop Default List - Perch Bottle')

@section('content')
<style>
    /* Shop sidebar: proper theme colors (no default white) */
    .shop-product .sidebar #shop-apply-price {
        background-color: var(--black) !important;
        color: var(--white) !important;
    }
    .shop-product .sidebar #shop-apply-price:hover {
        background-color: var(--green) !important;
        color: var(--black) !important;
    }
    .shop-product .sidebar .btn-clear-filters {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--black);
        background-color: var(--white);
        border: 2px solid var(--black);
        border-radius: 12px;
        cursor: pointer;
        transition: all ease 0.3s;
        text-decoration: none;
    }
    .shop-product .sidebar .btn-clear-filters:hover {
        background-color: var(--black);
        color: var(--white);
    }
    .shop-product .sidebar .list-size .size-item:not(.active) {
        background-color: #f5f5f5;
        border-color: #e0e0e0;
        color: var(--black);
    }
    .shop-product .sidebar .list-color .color-item:not(.active) {
        background-color: #f5f5f5;
        border-color: #e0e0e0;
    }
</style>
<div id="menu-mobile" class="">
                <div class="menu-container bg-white h-full">
                    <div class="container h-full">
                        <div class="menu-main h-full overflow-hidden">
                            <div class="heading py-2 relative flex items-center justify-center">
                                <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                                    <i class="ph ph-x text-sm"></i>
                                </div>
                                <a href="{{ route('home') }}" class="logo text-3xl font-semibold text-center">Anvogue</a>
                            </div>
                            <div class="form-search relative mt-2">
                                <i class="ph ph-magnifying-glass text-xl absolute left-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                                <input type="text" placeholder="What are you looking for?" class="h-12 rounded-lg border border-line text-sm w-full pl-10 pr-4" />
                            </div>
                            <div class="list-nav mt-6">
                                <ul>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between"
                                            >Demo
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full grid grid-cols-2 pt-2 pb-6">
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion2.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 2 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion3.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 3 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion4.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 4 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion5.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 5 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion6.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 6 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion7.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 7 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion8.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 8 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion9.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 9 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion10.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 10 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion11.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 11 </a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="underwear.html" class="nav-item-mobile link text-secondary duration-300"> Home Underwear </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic1.html" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic2.html" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 2 </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic3.html" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 3 </a>
                                                    </li>
                                                    <li>
                                                        <a href="pet.html" class="nav-item-mobile link text-secondary duration-300"> Home Pet Store </a>
                                                    </li>
                                                    <li>
                                                        <a href="jewelry.html" class="nav-item-mobile link text-secondary duration-300"> Home Jewelry </a>
                                                    </li>
                                                    <li>
                                                        <a href="furniture.html" class="nav-item-mobile link text-secondary duration-300"> Home Furniture </a>
                                                    </li>
                                                    <li>
                                                        <a href="watch.html" class="nav-item-mobile link text-secondary duration-300"> Home Watch </a>
                                                    </li>
                                                    <li>
                                                        <a href="toys.html" class="nav-item-mobile link text-secondary duration-300"> Home Toys Kid </a>
                                                    </li>
                                                    <li>
                                                        <a href="yoga.html" class="nav-item-mobile link text-secondary duration-300"> Home Yoga </a>
                                                    </li>
                                                    <li>
                                                        <a href="organic.html" class="nav-item-mobile link text-secondary duration-300"> Home Organic </a>
                                                    </li>
                                                    <li>
                                                        <a href="marketplace.html" class="nav-item-mobile link text-secondary duration-300"> Home Marketplace </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Features
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <div class="nav-link grid grid-cols-2 gap-5 gap-y-6">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Men</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Starting From 50% Off </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Outerwear | Coats </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Sweaters | Cardigans </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shirt | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Skincare</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Faces Skin </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Eyes Makeup </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Lip Polish </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Hair Care </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Health</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Cented Candle </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Health Drinks </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Yoga Clothes </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Yoga Equipment </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Women</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Starting From 60% Off </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Dresses | Jumpsuits </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> T-shirts | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Accessories | Jewelry </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Kid</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Kids Bed </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Boy's Toy </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Baby Blanket </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Newborn Clothing </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Home</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Furniture | Decor </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Table | Living Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Chair | Work Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Lighting | Bed Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Shop
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <div class="nav-link grid grid-cols-2 gap-5 gap-y-6 justify-between">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Breadcrumb IMG </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Breadcrumb 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Breadcrumb 2 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Collection </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Filter Canvas </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Filter Options </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Filter Dropdown </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 active"> Shop Sidebar List </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Default </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Default Grid </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Default List </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Full Width </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Square </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Pages</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('wishlist') }}" class="link text-secondary duration-300"> Wish List </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('search') }}" class="link text-secondary duration-300"> Search Result </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('cart.index') }}" class="link text-secondary duration-300"> Shopping Cart </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('login') }}" class="link text-secondary duration-300"> Login/Register </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('forgot-password') }}" class="link text-secondary duration-300"> Forgot Password </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('order-tracking') }}" class="link text-secondary duration-300"> Order Tracking </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('my-account') }}" class="link text-secondary duration-300"> My Account </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Product
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <div class="nav-link grid grid-cols-2 gap-5 gap-y-6 justify-between">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Defaults </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Countdown Timer </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Grouped </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Frequently Bought Together </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Out Of Stock </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Variable </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products External </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products On Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products With Discount </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products With Sidebar </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Fixed Price </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Left </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Bottom </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Grid 1 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Grid 2 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Combined 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Combined 2 </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Styles</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 01 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 02 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 03 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 04 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 05 </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Blog
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <ul class="w-full">
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Default </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog List </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Grid </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Detail 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Detail 2 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Pages
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <ul class="w-full">
                                                    <li>
                                                        <a href="{{ route('about') }}" class="link text-secondary duration-300"> About Us </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('contact') }}" class="link text-secondary duration-300"> Contact Us </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Store List </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> 404 </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('faqs') }}" class="link text-secondary duration-300"> FAQs </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Coming Soon </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Customer Feedbacks </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="breadcrumb-block style-img">
            <div class="breadcrumb-main bg-linear overflow-hidden">
                <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                    <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                        <div class="text-content">
                            <div class="heading2 text-center">Shop</div>
                            <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                <a href="{{ route('home') }}">Homepage</a>
                                <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                <div class="text-secondary2 capitalize">Shop</div>
                            </div>
                        </div>
                        <div class="filter-type menu-tab flex flex-wrap items-center justify-center gap-y-5 gap-8 lg:mt-[70px] mt-12 overflow-hidden">
                            @foreach($categories as $cat)
                                @if(($categoryProductCounts[$cat->id] ?? 0) > 0)
                                    @php $queryCat = array_merge(request()->query(), ($category && $category->id === $cat->id ? [] : ['category' => $cat->slug])); @endphp
                                    <a href="{{ route('shop', $queryCat) }}" class="item tab-item text-button-uppercase cursor-pointer has-line-before line-2px {{ ($category && $category->id === $cat->id) ? 'active' : '' }}" data-item="{{ $cat->slug }}">{{ $cat->name }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-product breadcrumb1 lg:py-20 md:py-14 py-10">
            <div class="container">
                <div class="flex max-md:flex-wrap max-md:flex-col-reverse gap-y-8">
                    <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12">
                        @if(request()->hasAny(['category', 'size', 'color', 'min_price', 'max_price', 'search']))
                        <a href="{{ route('shop') }}" class="btn-clear-filters mb-6 shop-filter-link">Clear all filters</a>
                        @endif
                        <div class="filter-type-block pb-8 border-b border-line">
                            <div class="heading6">Category</div>
                            <div class="list-type filter-type menu-tab mt-4">
                                @foreach($categories as $cat)
                                    @if(($categoryProductCounts[$cat->id] ?? 0) > 0)
                                    <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="item tab-item flex items-center justify-between cursor-pointer shop-filter-link {{ ($category && $category->id === $cat->id) ? 'active' : '' }}" data-item="{{ $cat->slug }}">
                                        <div class="type-name text-secondary has-line-before hover:text-black capitalize">{{ $cat->name }}</div>
                                        <div class="text-secondary2 number">{{ $categoryProductCounts[$cat->id] ?? 0 }}</div>
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-size pb-8 border-b border-line mt-8">
                            <div class="heading6">Size</div>
                            <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                                @foreach($filterSizes as $size)
                                    @php $querySize = array_merge(request()->query(), ($filterSize === $size->name ? [] : ['size' => $size->name])); @endphp
                                    <a href="{{ route('shop', $querySize) }}" class="size-item text-button min-w-[44px] h-[44px] px-2 flex items-center justify-center rounded-full border border-line cursor-pointer shop-filter-link {{ ($filterSize === $size->name) ? 'active border-black bg-black text-white' : '' }}" data-item="{{ $size->name }}" title="{{ $size->name }}">{{ $size->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-price pb-8 border-b border-line mt-8">
                            <div class="heading6">Price Range</div>
                            <div class="tow-bar-block mt-5">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input class="range-min" type="range" min="{{ (int)$priceMin }}" max="{{ (int)max($priceMax, $priceMin + 1) }}" value="{{ (int)request()->get('min_price', $priceMin) }}" />
                                <input class="range-max" type="range" min="{{ (int)$priceMin }}" max="{{ (int)max($priceMax, $priceMin + 1) }}" value="{{ (int)request()->get('max_price', $priceMax) }}" />
                            </div>
                            <div class="price-block flex items-center justify-between flex-wrap mt-4">
                                <div class="min flex items-center gap-1">
                                    <div>Min price:</div>
                                    <div class="min-price">₹{{ number_format((int)request()->get('min_price', $priceMin), 0) }}</div>
                                </div>
                                <div class="min flex items-center gap-1">
                                    <div>Max price:</div>
                                    <div class="max-price">₹{{ number_format((int)request()->get('max_price', $priceMax), 0) }}</div>
                                </div>
                            </div>
                            <button type="button" id="shop-apply-price" class="button-main mt-3 w-full text-center">Apply price filter</button>
                        </div>
                        <div class="filter-color pb-8 border-b border-line mt-8">
                            <div class="heading6">Colors</div>
                            <div class="list-color flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                                @php
                                    $colorHex = ['red' => '#ef4444', 'blue' => '#3b82f6', 'green' => '#22c55e', 'yellow' => '#eab308', 'black' => '#1f1f1f', 'white' => '#f6efdd', 'pink' => '#f4c5bf', 'purple' => '#a855f7', 'grey' => '#6b7280', 'gray' => '#6b7280', 'brown' => '#92400e', 'orange' => '#f97316', 'navy' => '#1e3a8a', 'maroon' => '#881337', 'cream' => '#fef3c7', 'gold' => '#eab308', 'silver' => '#9ca3af'];
                                @endphp
                                @foreach($filterColors as $color)
                                    @php $queryColor = array_merge(request()->query(), (($filterColor && strtolower(trim($filterColor)) === strtolower($color->name)) ? [] : ['color' => $color->name])); @endphp
                                    <a href="{{ route('shop', $queryColor) }}" class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line cursor-pointer shop-filter-link {{ ($filterColor && strtolower(trim($filterColor)) === strtolower($color->name)) ? 'active border-black ring-2 ring-black' : '' }}" data-item="{{ $color->name }}">
                                        <div class="color w-5 h-5 rounded-full flex-shrink-0" style="background: {{ $colorHex[strtolower($color->name)] ?? '#d1d5db' }};"></div>
                                        <div class="caption1 capitalize">{{ $color->name }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="list-product-block style-list lg:w-3/4 md:w-2/3 w-full md:pl-3">
                        <div class="filter-heading flex items-center justify-between gap-5 flex-wrap hidden">
                            <div class="left flex has-line items-center flex-wrap gap-5">
                                <div class="choose-layout menu-tab flex items-center gap-2">
                                    <div class="item style-grid tab-item three-col p-2 border border-line rounded flex items-center justify-center cursor-pointer">
                                        <div class="flex items-center gap-0.5">
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        </div>
                                    </div>
                                    <div class="item style-list tab-item row w-8 h-8 border border-line rounded flex items-center justify-center cursor-pointer active">
                                        <div class="flex flex-col items-center gap-0.5">
                                            <span class="w-4 h-[3px] bg-secondary2 rounded-sm"></span>
                                            <span class="w-4 h-[3px] bg-secondary2 rounded-sm"></span>
                                            <span class="w-4 h-[3px] bg-secondary2 rounded-sm"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="check-sale flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="filterSale" id="filter-sale" class="border-line" />
                                    <label for="filter-sale" class="cation1 cursor-pointer">Show only products on sale</label>
                                </div>
                            </div>
                            <div class="sort-product right flex items-center gap-3">
                                <label for="select-filter" class="caption1 capitalize">Sort by</label>
                                <div class="select-block relative">
                                    <select id="select-filter" name="select-filter" class="caption1 py-2 pl-3 md:pr-20 pr-10 rounded-lg border border-line">
                                        <option value="Sorting">Sorting</option>
                                        <option value="soldQuantityHighToLow">Best Selling</option>
                                        <option value="discountHighToLow">Best Discount</option>
                                        <option value="priceHighToLow">Price High To Low</option>
                                        <option value="priceLowToHigh">Price Low To High</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                                </div>
                            </div>
                        </div>

                        <div class="list-filtered flex items-center gap-3 flex-wrap"></div>

                        <div id="shop-products-container" data-shop-url="{{ route('shop') }}">
                        <div class="list-product hide-product-sold grid grid-cols-2 md:grid-cols-3 xl:grid-cols-3 md:gap-[30px] gap-4 mt-7">
                            @forelse($products as $product)
                                @include('partials.product-card', ['product' => $product])
                            @empty
                                <div class="col-span-full text-center py-16">
                                    <p class="text-secondary body1">No products found.</p>
                                    <a href="{{ route('shop') }}" class="button-main mt-4 inline-block shop-filter-link">Browse Shop</a>
                                </div>
                            @endforelse
                        </div>

                        @if($products->hasPages())
                        <div class="list-pagination w-full flex items-center justify-center gap-4 mt-10">
                            {{ $products->links() }}
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var shopBaseUrl = '{{ route("shop") }}';
    var container = document.getElementById('shop-products-container');
    var sidebar = document.querySelector('.shop-product .sidebar');

    function updateSidebarActive(queryString) {
        var params = new URLSearchParams(queryString);
        var cat = params.get('category');
        var size = params.get('size');
        var color = params.get('color');
        if (sidebar) {
            sidebar.querySelectorAll('.filter-type-block .tab-item[data-item]').forEach(function(el) {
                el.classList.toggle('active', el.getAttribute('data-item') === cat);
            });
            sidebar.querySelectorAll('.size-item[data-item]').forEach(function(el) {
                var isActive = el.getAttribute('data-item') === size;
                el.classList.toggle('active', isActive);
                el.classList.toggle('border-black', isActive);
                el.classList.toggle('bg-black', isActive);
                el.classList.toggle('text-white', isActive);
            });
            sidebar.querySelectorAll('.color-item[data-item]').forEach(function(el) {
                var cName = (el.getAttribute('data-item') || '').toLowerCase();
                var isActive = color && cName === color.toLowerCase();
                el.classList.toggle('active', isActive);
                el.classList.toggle('border-black', isActive);
                el.classList.toggle('ring-2', isActive);
                el.classList.toggle('ring-black', isActive);
            });
        }
    }

    function loadShopProducts(url, pushState) {
        if (!container) return;
        container.style.opacity = '0.6';
        container.style.pointerEvents = 'none';
        var fullUrl = url.indexOf(shopBaseUrl) === 0 ? url : shopBaseUrl + (url.indexOf('?') === 0 ? url : '?' + (url || ''));
        fetch(fullUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
        }).then(function(r) { return r.text(); }).then(function(html) {
            container.innerHTML = html;
            if (pushState !== false) {
                var u = new URL(fullUrl, window.location.origin);
                history.pushState({}, '', u.pathname + (u.search || ''));
                updateSidebarActive(u.search || '');
            }
        }).catch(function() {
            window.location.href = fullUrl;
        }).finally(function() {
            container.style.opacity = '';
            container.style.pointerEvents = '';
        });
    }

    document.addEventListener('click', function(e) {
        var link = e.target.closest('a.shop-filter-link');
        if (link && link.href && link.href.indexOf(shopBaseUrl) !== -1) {
            e.preventDefault();
            loadShopProducts(link.href);
            return;
        }
        var paginationLink = e.target.closest('#shop-products-container a[href*="/shop"]');
        if (paginationLink && paginationLink.href) {
            e.preventDefault();
            loadShopProducts(paginationLink.href);
        }
    });

    window.addEventListener('popstate', function() {
        loadShopProducts(shopBaseUrl + window.location.search, false);
    });

    var filterPrice = document.querySelector('.filter-price');
    if (filterPrice) {
        var rangeMin = filterPrice.querySelector('.range-min');
        var rangeMax = filterPrice.querySelector('.range-max');
        var minPriceEl = filterPrice.querySelector('.min-price');
        var maxPriceEl = filterPrice.querySelector('.max-price');
        var applyBtn = document.getElementById('shop-apply-price');

        function formatPrice(v) { return '₹' + parseInt(v, 10).toLocaleString('en-IN'); }
        function updatePriceDisplay() {
            if (rangeMin && minPriceEl) minPriceEl.textContent = formatPrice(rangeMin.value);
            if (rangeMax && maxPriceEl) maxPriceEl.textContent = formatPrice(rangeMax.value);
        }
        if (rangeMin) rangeMin.addEventListener('input', updatePriceDisplay);
        if (rangeMax) rangeMax.addEventListener('input', updatePriceDisplay);

        if (applyBtn && rangeMin && rangeMax) {
            applyBtn.addEventListener('click', function() {
                var minVal = parseInt(rangeMin.value, 10);
                var maxVal = parseInt(rangeMax.value, 10);
                if (minVal > maxVal) { var t = minVal; minVal = maxVal; maxVal = t; }
                var params = new URLSearchParams(window.location.search);
                params.set('min_price', String(minVal));
                params.set('max_price', String(maxVal));
                var sep = shopBaseUrl.indexOf('?') !== -1 ? '&' : '?';
                loadShopProducts(shopBaseUrl + sep + params.toString());
            });
        }
    }
});
</script>
@endpush
@endsection
