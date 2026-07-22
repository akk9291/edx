@extends('layouts.app')

@section('title', 'Product Style5 - Perch Bottle')

@section('content')
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
                                                                <a href="/shop-breadcrumb-img.html" class="link text-secondary duration-300"> Shop Breadcrumb IMG </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-breadcrumb1.html" class="link text-secondary duration-300"> Shop Breadcrumb 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-breadcrumb2.html" class="link text-secondary duration-300"> Shop Breadcrumb 2 </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-collection.html" class="link text-secondary duration-300"> Shop Collection </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="/shop-filter-canvas.html" class="link text-secondary duration-300"> Shop Filter Canvas </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-filter-options.html" class="link text-secondary duration-300"> Shop Filter Options </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-filter-dropdown.html" class="link text-secondary duration-300"> Shop Filter Dropdown </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-sidebar-list.html" class="link text-secondary duration-300"> Shop Sidebar List </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="/shop-default.html" class="link text-secondary duration-300 cursor-pointer"> Shop Default </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-default-grid.html" class="link text-secondary duration-300 cursor-pointer"> Shop Default Grid </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-default-list.html" class="link text-secondary duration-300 cursor-pointer"> Shop Default List </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-fullwidth.html" class="link text-secondary duration-300 cursor-pointer"> Shop Full Width </a>
                                                            </li>
                                                            <li>
                                                                <a href="/shop-square.html" class="link text-secondary duration-300"> Shop Square </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Pages</div>
                                                        <ul>
                                                            <li>
                                                                <a href="/wishlist.html" class="link text-secondary duration-300"> Wish List </a>
                                                            </li>
                                                            <li>
                                                                <a href="/search-result.html" class="link text-secondary duration-300"> Search Result </a>
                                                            </li>
                                                            <li>
                                                                <a href="/cart.html" class="link text-secondary duration-300"> Shopping Cart </a>
                                                            </li>
                                                            <li>
                                                                <a href="/login.html" class="link text-secondary duration-300"> Login/Register </a>
                                                            </li>
                                                            <li>
                                                                <a href="/forgot-password.html" class="link text-secondary duration-300"> Forgot Password </a>
                                                            </li>
                                                            <li>
                                                                <a href="/order-tracking.html" class="link text-secondary duration-300"> Order Tracking </a>
                                                            </li>
                                                            <li>
                                                                <a href="/my-account.html" class="link text-secondary duration-300"> My Account </a>
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
                                                                <a href="/product-default.html" class="link text-secondary duration-300"> Products Defaults </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-sale.html" class="link text-secondary duration-300"> Products Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-countdown-timer.html" class="link text-secondary duration-300"> Products Countdown Timer </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-grouped.html" class="link text-secondary duration-300"> Products Grouped </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-bought-together.html" class="link text-secondary duration-300"> Frequently Bought Together </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-out-of-stock.html" class="link text-secondary duration-300"> Products Out Of Stock </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-variable.html" class="link text-secondary duration-300"> Products Variable </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="/product-external.html" class="link text-secondary duration-300"> Products External </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-on-sale.html" class="link text-secondary duration-300"> Products On Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-discount.html" class="link text-secondary duration-300"> Products With Discount </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-sidebar.html" class="link text-secondary duration-300"> Products With Sidebar </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-fixed-price.html" class="link text-secondary duration-300"> Products Fixed Price </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="/product-thumbnail-left.html" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Left </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-thumbnail-bottom.html" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Bottom </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-one-scrolling.html" class="link text-secondary duration-300 cursor-pointer"> Products Grid 1 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-two-scrolling.html" class="link text-secondary duration-300 cursor-pointer"> Products Grid 2 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-combined-one.html" class="link text-secondary duration-300 cursor-pointer"> Products Combined 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="/product-combined-two.html" class="link text-secondary duration-300 cursor-pointer"> Products Combined 2 </a>
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
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer active"> Products Style 05 </a>
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
                            <div class="heading2 text-center">Product Style</div>
                            <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                <a href="{{ route('home') }}">Homepage</a>
                                <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                <div class="text-secondary2 capitalize">Product Style 05</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-product lg:py-20 md:py-14 py-10">
            <div class="container">
                <div class="list-product hide-product-sold grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2 sm:gap-[30px] gap-5">
                    <div class="product-item grid-type style-5" data-item="1">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
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
                                <div class="list-action flex items-center justify-center gap-3 px-5 absolute w-full bottom-5">
                                    <div class="add-wishlist-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-xl"></i>
                                    </div>
                                    <div class="compare-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-xl compare-icon"></i>
                                        <i class="ph ph-check-circle text-xl checked-icon"></i>
                                    </div>
                                    <div class="quick-view-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Quick View</div>
                                        <i class="ph ph-eye text-xl"></i>
                                    </div>
                                    <div class="quick-shop-block absolute left-5 right-5 bg-white sm:p-5 p-4 rounded-[20px]">
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
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="color" class="rounded-xl w-full h-full object-cover') " />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="color" class="rounded-xl w-full h-full object-cover') " />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="color" class="rounded-xl w-full h-full object-cover') " />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                                    </div>
                                </div>
                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">$30.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$42.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-30%</div>
                                </div>
                                <div class="quick-shop-btn text-button-uppercase py-2.5 text-center mt-2 rounded-full duration-300 bg-white border border-black hover:bg-black hover:text-white">Quick Shop</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item grid-type style-5" data-item="3">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
                                </div>
                                <div class="list-action flex items-center justify-center gap-3 px-5 absolute w-full bottom-5">
                                    <div class="add-wishlist-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-xl"></i>
                                    </div>
                                    <div class="compare-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-xl compare-icon"></i>
                                        <i class="ph ph-check-circle text-xl checked-icon"></i>
                                    </div>
                                    <div class="quick-view-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Quick View</div>
                                        <i class="ph ph-eye text-xl"></i>
                                    </div>
                                    <div class="quick-shop-block absolute left-5 right-5 bg-white sm:p-5 p-4 rounded-[20px]">
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
                                    <div class="product-price text-title">$40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$50.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                                </div>
                                <div class="add-cart-btn w-full text-button-uppercase py-2.5 text-center mt-2 rounded-full duration-300 bg-white border border-black hover:bg-black hover:text-white">Add To Cart</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item grid-type style-5" data-item="4">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
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
                                <div class="list-action flex items-center justify-center gap-3 px-5 absolute w-full bottom-5">
                                    <div class="add-wishlist-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-xl"></i>
                                    </div>
                                    <div class="compare-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-xl compare-icon"></i>
                                        <i class="ph ph-check-circle text-xl checked-icon"></i>
                                    </div>
                                    <div class="quick-view-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Quick View</div>
                                        <i class="ph ph-eye text-xl"></i>
                                    </div>
                                    <div class="quick-shop-block absolute left-5 right-5 bg-white sm:p-5 p-4 rounded-[20px]">
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
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="color" class="rounded-xl w-full h-full object-cover') " />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="color" class="rounded-xl w-full h-full object-cover') " />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="color" class="rounded-xl w-full h-full object-cover') " />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                                    </div>
                                </div>
                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">$30.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$42.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-30%</div>
                                </div>
                                <div class="quick-shop-btn text-button-uppercase py-2.5 text-center mt-2 rounded-full duration-300 bg-white border border-black hover:bg-black hover:text-white">Quick Shop</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item grid-type style-5" data-item="5">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/1000x1000.png" alt="img') " />
                                </div>
                                <div class="list-action flex items-center justify-center gap-3 px-5 absolute w-full bottom-5">
                                    <div class="add-wishlist-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-xl"></i>
                                    </div>
                                    <div class="compare-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-xl compare-icon"></i>
                                        <i class="ph ph-check-circle text-xl checked-icon"></i>
                                    </div>
                                    <div class="quick-view-btn sm:w-9 w-8 sm:h-9 h-8 flex items-center justify-center rounded-full bg-white duration-300 relative flex-shrink-0">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Quick View</div>
                                        <i class="ph ph-eye text-xl"></i>
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
                                    <div class="product-price text-title">$40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$50.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                                </div>
                                <div class="add-cart-btn w-full text-button-uppercase py-2.5 text-center mt-2 rounded-full duration-300 bg-white border border-black hover:bg-black hover:text-white">Add To Cart</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
