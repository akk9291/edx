@extends('layouts.app')

@section('title', 'Checkout2 - Perch Bottle')

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
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Sidebar List </a>
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

        <div class="checkout-block relative md:pt-[74px] pt-[56px]">
            <div class="content-main flex max-lg:flex-col-reverse justify-between">
                <div class="left flex lg:justify-end w-full">
                    <div class="lg:max-w-[716px] flex-shrink-0 w-full lg:pt-20 pt-12 lg:pr-[70px] pl-[16px] max-lg:pr-[16px]">
                        <form>
                            <div class="login flex justify-between gap-4">
                                <h4 class="heading4">Contact</h4>
                                <a href="{{ route('login') }}" class="text-button underline">Login here</a>
                            </div>
                            <div>
                                <input type="text" class="border-line mt-5 px-4 py-3 w-full rounded-lg" placeholder="Email or mobile phone number" required />
                                <div class="flex items-center mt-5">
                                    <div class="block-input">
                                        <input type="checkbox" name="remember" id="remember" />
                                        <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                    </div>
                                    <label for="remember" class="pl-2 cursor-pointer">Email me with news and offers</label>
                                </div>
                            </div>
                            <div class="information md:mt-10 mt-6">
                                <div class="heading5">Delivery</div>
                                <div class="deli_type mt-5">
                                    <div class="item flex items-center gap-2 relative px-5 border border-line rounded-t-lg">
                                        <input type="radio" name="deli_type" id="ship_type" class="cursor-pointer" checked />
                                        <label for="ship_type" class="w-full py-4 cursor-pointer">Ship</label>
                                        <span class="ph ph-truck text-xl absolute top-1/2 right-5 -translate-y-1/2"></span>
                                    </div>
                                    <div class="item flex items-center gap-2 relative px-5 border border-line rounded-b-lg">
                                        <input type="radio" name="deli_type" id="store_type" class="cursor-pointer" />
                                        <label for="store_type" class="w-full py-4 cursor-pointer">Pickup in store</label>
                                        <span class="ph ph-storefront text-xl absolute top-1/2 right-5 -translate-y-1/2"></span>
                                    </div>
                                </div>
                                <div class="form-checkout mt-5">
                                    <div class="grid sm:grid-cols-2 gap-4 gap-y-5 flex-wrap">
                                        <div class="col-span-full select-block">
                                            <select class="border border-line px-4 py-3 w-full rounded-lg" id="region" name="region">
                                                <option value="default">Choose Country/Region</option>
                                                <option value="United State">United State</option>
                                                <option value="France">France</option>
                                                <option value="Singapore">Singapore</option>
                                            </select>
                                            <i class="ph ph-caret-down arrow-down"></i>
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="firstName" type="text" placeholder="First Name (optional)" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="lastName" type="text" placeholder="Last Name" required />
                                        </div>
                                        <div class="col-span-full relative">
                                            <input class="border-line pl-4 pr-12 py-3 w-full rounded-lg" id="address" type="text" placeholder="Address" required />
                                            <span class="ph ph-magnifying-glass text-xl absolute top-1/2 -translate-y-1/2 right-5"></span>
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="apartment" type="text" placeholder="Apartment, suite,etc.(optional)" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="city" type="text" placeholder="City" required />
                                        </div>
                                        <div class="select-block">
                                            <select class="border border-line px-4 py-3 w-full rounded-lg" id="state" name="state">
                                                <option value="default">State</option>
                                                <option value="Nevada">Nevada</option>
                                                <option value="California">California</option>
                                                <option value="Los Angeles">Los Angeles</option>
                                            </select>
                                            <i class="ph ph-caret-down arrow-down"></i>
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="zipcode" type="text" placeholder="Zip Code" required />
                                        </div>
                                    </div>
                                    <h4 class="heading4 md:mt-10 mt-6">Shipping method</h4>
                                    <div class="body1 text-secondary2 py-6 px-5 border border-line rounded-lg bg-surface mt-5">Enter your shipping address to view available shipping methods</div>
                                    <div class="payment-block md:mt-10 mt-6">
                                        <h4 class="heading4">Payment</h4>
                                        <p class="body1 text-secondary2 mt-3">All transactions are secure and encrypted.</p>
                                        <div class="list-payment mt-5">
                                            <div class="item">
                                                <div class="type flex items-center justify-between bg-linear p-5 border border-black rounded-t-lg">
                                                    <strong class="text-title">Credit Card</strong>
                                                    <span class="ph ph-credit-card text-2xl"></span>
                                                </div>
                                                <div class="form_payment grid grid-cols-2 gap-4 gap-y-5 p-5 rounded-b-lg bg-surface">
                                                    <div class="col-span-full relative">
                                                        <input class="border-line pl-4 pr-12 py-3 w-full rounded-lg" id="cardNumbers" type="text" placeholder="Card Numbers" required />
                                                        <span class="ph ph-lock-simple text-xl text-secondary absolute top-1/2 -translate-y-1/2 right-5"></span>
                                                    </div>
                                                    <div class="relative">
                                                        <input class="border-line px-4 py-3 w-full rounded-lg" id="expirationDate" type="text" placeholder="Expiration date (MM /YY)" required />
                                                    </div>
                                                    <div class="relative">
                                                        <input class="border-line pl-4 pr-12 py-3 w-full rounded-lg" id="securityCode" type="text" placeholder="Security code" required />
                                                        <span class="ph ph-question text-xl text-secondary absolute top-1/2 -translate-y-1/2 right-5"></span>
                                                    </div>
                                                    <div class="col-span-full relative">
                                                        <input class="border-line px-4 py-3 w-full rounded-lg" id="cardName" type="text" placeholder="Name On Card" required />
                                                    </div>
                                                    <div class="col-span-full flex items-center">
                                                        <div class="block-input">
                                                            <input type="checkbox" name="useAddress" id="useAddress" />
                                                            <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                                        </div>
                                                        <label for="useAddress" class="text-title pl-2 cursor-pointer">Use shipping address as billing address</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-button md:mt-10 mt-6">
                                        <button class="button-main w-full tracking-widest">Paynow</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="copyright caption1 md:mt-20 mt-12 py-3 border-t border-line">©{{ date('Y') }} Anvogue. All Rights Reserved.</div>
                    </div>
                </div>
                <div class="right justify-start flex-shrink-0 lg:w-[47%] bg-surface lg:py-20 py-12">
                    <div class="lg:sticky lg:top-24 h-fit lg:max-w-[606px] w-full flex-shrink-0 lg:pl-[80px] pr-[16px] max-lg:pl-[16px]">
                        <div class="list_prd flex flex-col gap-7">
                            <div class="item flex items-center justify-between gap-6">
                                <div class="flex items-center gap-6">
                                    <div class="bg_img relative flex-shrink-0 w-[100px] h-[100px]">
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="product/1000x1000" class="w-full h-full object-cover rounded-lg') " />
                                        <span class="quantity flex items-center justify-center absolute -top-3 -right-3 w-7 h-7 rounded-full bg-black text-white">1</span>
                                    </div>
                                    <div>
                                        <strong class="name text-title">Contrasting sheepskin sweatshirt</strong>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="ph ph-tag text-secondary"></span>
                                            <span class="code text-secondary">AN6810 <span class="discount">(-$14.20)</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <del class="caption1 text-secondary text-end org_price">$99.00</del>
                                    <strong class="text-title price">$60.00</strong>
                                </div>
                            </div>
                            <div class="item flex items-center justify-between gap-6">
                                <div class="flex items-center gap-6">
                                    <div class="bg_img relative flex-shrink-0 w-[100px] h-[100px]">
                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="product/1000x1000" class="w-full h-full object-cover rounded-lg') " />
                                        <span class="quantity flex items-center justify-center absolute -top-3 -right-3 w-7 h-7 rounded-full bg-black text-white">1</span>
                                    </div>
                                    <div>
                                        <strong class="name text-title">Contrasting sheepskin sweatshirt</strong>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="ph ph-tag text-secondary"></span>
                                            <span class="code text-secondary">AN6810 <span class="discount">(-$14.20)</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <del class="caption1 text-secondary text-end org_price">$99.00</del>
                                    <strong class="text-title price">$60.00</strong>
                                </div>
                            </div>
                        </div>
                        <form class="form_discount flex gap-3 mt-8">
                            <input type="text" placeholder="Discount code" class="w-full border border-line rounded-lg px-4" required />
                            <button class="flex-shrink-0 button-main bg-black">applied</button>
                        </form>
                        <div class="subtotal flex items-center justify-between mt-8">
                            <strong class="heading6">Subtotal</strong>
                            <strong class="heading6">$86,99</strong>
                        </div>
                        <div class="ship-block flex items-center justify-between mt-4">
                            <strong class="heading6">Shipping</strong>
                            <span class="body1 text-secondary">Enter shipping address</span>
                        </div>
                        <div class="total-cart-block flex items-center justify-between mt-4">
                            <strong class="heading4">Total</strong>
                            <div class="flex items-end gap-2">
                                <span class="body1 text-secondary">USD</span>
                                <strong class="heading4">$186,99</strong>
                            </div>
                        </div>
                        <div class="total-saving-block flex items-center gap-2 mt-4">
                            <span class="ph-bold ph-tag text-xl"></span>
                            <strong class="heading5">TOTAL SAVINGS</strong>
                            <strong class="heading5">$14.85</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal-cart-block">
            <div class="modal-cart-main flex">
                <div class="left w-1/2 border-r border-line py-6 max-md:hidden">
                    <div class="heading5 px-6 pb-3">You May Also Like</div>
                    <div class="list px-6">
                        <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="1">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg') " />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                        <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="2">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg') " />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                        <div class="product-item item py-5 flex items-center justify-between gap-3 border-b border-line" data-item="3">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg') " />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
                        <div class="product-item item py-5 flex items-center justify-between gap-3" data-item="4">
                            <div class="infor flex items-center gap-5">
                                <div class="bg-img">
                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="img" class="w-[100px] aspect-square flex-shrink-0 rounded-lg') " />
                                </div>
                                <div class="">
                                    <div class="name text-button">Faux-leather trousers</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="product-price text-title">$15.00</div>
                                        <div class="product-origin-price text-title text-secondary2">
                                            <del>$25.00</del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-view-btn button-main py-3 px-5 bg-black hover:bg-green text-white rounded-full whitespace-nowrap">QUICK VIEW</div>
                        </div>
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
                            Buy <span class="text-button"> $<span class="more-price">150</span>.00 </span>
                            <span>more to get </span>
                            <span class="text-button">freeship</span>
                        </div>
                        <div class="tow-bar-block mt-3">
                            <div class="progress-line"></div>
                        </div>
                    </div> -->
                    <div class="list-product px-6"></div>
                    <div class="footer-modal bg-white absolute bottom-0 left-0 w-full">
                        <div class="flex items-center justify-center lg:gap-14 gap-8 px-6 py-4 border-b border-line">
                            <div class="note-btn item flex items-center gap-3 cursor-pointer">
                                <i class="ph ph-note-pencil text-xl"></i>
                                <div class="caption1">Note</div>
                            </div>
                            <div class="shipping-btn item flex items-center gap-3 cursor-pointer">
                                <i class="ph ph-truck text-xl"></i>
                                <div class="caption1">Shipping</div>
                            </div>
                            <div class="coupon-btn item flex items-center gap-3 cursor-pointer">
                                <i class="ph ph-tag text-xl"></i>
                                <div class="caption1">Coupon</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-6 px-6">
                            <div class="heading5">Subtotal</div>
                            <div class="heading5 total-cart">$0.00</div>
                        </div>
                        <div class="block-button text-center p-6">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('cart.index') }}" class="button-main basis-1/2 bg-white border border-black text-black text-center uppercase"> View cart </a>
                                <a href="{{{ route('checkout.index') }}}" class="button-main basis-1/2 text-center uppercase"> Check Out </a>
                            </div>
                            <div class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">Or continue shopping</div>
                        </div>
                        <div class="tab-item note-block">
                            <div class="px-6 py-4 border-b border-line">
                                <div class="item flex items-center gap-3 cursor-pointer">
                                    <i class="ph ph-note-pencil text-xl"></i>
                                    <div class="caption1">Note</div>
                                </div>
                            </div>
                            <div class="form pt-4 px-6">
                                <textarea name="form-note" id="form-note" rows="4" placeholder="Add special instructions for your order..." class="caption1 py-3 px-4 bg-surface border-line rounded-md w-full"></textarea>
                            </div>
                            <div class="block-button text-center pt-4 px-6 pb-6">
                                <div class="button-main w-full text-center">Save</div>
                                <div class="cancel-btn text-button-uppercase mt-4 text-center has-line-before cursor-pointer inline-block">Cancel</div>
                            </div>
                        </div>
                        <div class="tab-item shipping-block">
                            <div class="px-6 py-4 border-b border-line">
                                <div class="item flex items-center gap-3 cursor-pointer">
                                    <i class="ph ph-truck text-xl"></i>
                                    <div class="caption1">Estimate shipping rates</div>
                                </div>
                            </div>
                            <div class="form pt-4 px-6">
                                <div class="">
                                    <label for="select-country" class="caption1 text-secondary">Country/region</label>
                                    <div class="select-block relative mt-2">
                                        <select id="select-country" name="select-country" class="w-full py-3 pl-5 rounded-xl bg-white border border-line">
                                            <option value="Country/region">Country/region</option>
                                            <option value="France">France</option>
                                            <option value="Spain">Spain</option>
                                            <option value="UK">UK</option>
                                            <option value="USA">USA</option>
                                        </select>
                                        <i class="ph ph-caret-down text-xs absolute top-1/2 -translate-y-1/2 md:right-5 right-2"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="select-state" class="caption1 text-secondary">State</label>
                                    <div class="select-block relative mt-2">
                                        <select id="select-state" name="select-state" class="w-full py-3 pl-5 rounded-xl bg-white border border-line">
                                            <option value="State">State</option>
                                            <option value="Paris">Paris</option>
                                            <option value="Madrid">Madrid</option>
                                            <option value="London">London</option>
                                            <option value="New York">New York</option>
                                        </select>
                                        <i class="ph ph-caret-down text-xs absolute top-1/2 -translate-y-1/2 md:right-5 right-2"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="select-code" class="caption1 text-secondary">Postal/Zip Code</label>
                                    <input class="border-line px-5 py-3 w-full rounded-xl mt-3" id="select-code" type="text" placeholder="Postal/Zip Code" />
                                </div>
                            </div>
                            <div class="block-button text-center pt-4 px-6 pb-6">
                                <div class="button-main w-full text-center">Calculator</div>
                                <div class="cancel-btn text-button-uppercase mt-4 text-center has-line-before cursor-pointer inline-block">Cancel</div>
                            </div>
                        </div>
                        <div class="tab-item coupon-block">
                            <div class="px-6 py-4 border-b border-line">
                                <div class="item flex items-center gap-3 cursor-pointer">
                                    <i class="ph ph-tag text-xl"></i>
                                    <div class="caption1">Add A Coupon Code</div>
                                </div>
                            </div>
                            <div class="form pt-4 px-6">
                                <div class="">
                                    <label for="select-discount" class="caption1 text-secondary">Enter Code</label>
                                    <input class="border-line px-5 py-3 w-full rounded-xl mt-3" id="select-discount" type="text" placeholder="Discount code" />
                                </div>
                            </div>
                            <div class="block-button text-center pt-4 px-6 pb-6">
                                <div class="button-main w-full text-center">Apply</div>
                                <div class="cancel-btn text-button-uppercase mt-4 text-center has-line-before cursor-pointer inline-block">Cancel</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/phosphor-icons.js') "></script>
        <script src="{{ asset('assets/js/swiper-bundle.min.js') "></script>
        <script src="{{ asset('assets/js/main.js') "></script>
@endsection
