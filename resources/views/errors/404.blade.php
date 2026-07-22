@extends('layouts.app')

@section('title', 'Page Not Found - Perch Bottle')

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
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300 active"> 404 </a>
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

        <div class="page-not-found md:py-20 py-10 bg-linear md:mt-[74px] mt-14">
            <div class="container">
                <div class="flex items-center justify-between max-sm:flex-col gap-y-8">
                    <img src="{{ asset('assets/images/other/404-img.png') }}" alt="bg-img" class="sm:w-1/2 w-3/4" />
                    <div class="text-content sm:w-1/2 w-full flex items-center justify-center sm:pl-10">
                        <div class="">
                            <div class="lg:text-[140px] md:text-[80px] text-[42px] lg:leading-[152px] md:leading-[92px] leading-[52px] font-semibold">404</div>
                            <div class="heading2 mt-4">Something is Missing.</div>
                            <div class="body1 text-secondary mt-4 pb-4">The page you are looking for cannot be found. <br class="max-xl:hidden" />Take a break before trying again</div>
                            <a class="flex items-center gap-3" href="{{ route('home') }}">
                                <i class="ph ph-arrow-left"></i>
                                <div class="text-button">Back To Homepage</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
