@extends('layouts.app')

@section('title', 'Blog Detail2 - Perch Bottle')

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
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300 active"> Blog Detail 2 </a>
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

        <div class="blog blog-detail detail2 md:mt-[74px] mt-[56px] border-t border-line">
            <div class="container lg:pt-20 md:pt-14 pt-10">
                <div class="blog-content flex justify-between max-lg:flex-col gap-y-10">
                    <div class="main xl:w-3/4 lg:w-2/3 lg:pr-[15px]">
                        <div class="blog-tag bg-green py-1 px-2.5 rounded-full text-button-uppercase inline-block">blogMain.tag</div>
                        <div class="heading3 blog-title mt-3">blogMain.title</div>
                        <div class="author flex items-center gap-4 mt-4">
                            <div class="avatar w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                <img src="{{ asset('assets/images/avatar/1.png" alt="avatar" class="w-full h-full object-cover') " />
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="blog-author caption1 text-secondary">by blogMain.author</div>
                                <div class="line w-5 h-px bg-secondary"></div>
                                <div class="blog-date caption1 text-secondary">blogMain.date</div>
                            </div>
                        </div>
                        <div class="bg-img md:py-10 py-6">
                            <img src="{{ asset('assets/images/blog/1.png" alt="img" class="blog-img w-full object-cover rounded-3xl') " />
                        </div>
                        <div class="content md:mt-8 mt-5">
                            <div class="blog-description body1">blogMain.description</div>
                            <div class="heading4 md:mt-8 mt-5">How did SKIMS start?</div>
                            <div class="body1 mt-4">This is such a hard question! Honestly, every time we drop a new collection I get obsessed with it. The pieces that have been my go-tos though are some of our simplest styles that we launched with. I wear our Fits Everybody Thong every single day – it is the only underwear I have now, it’s so comfortable and stretchy and light enough that you can wear anything over it.</div>
                            <div class="list-img grid sm:grid-cols-2 gap-[30px] md:mt-8 mt-5"></div>
                            <div class="body1 mt-4">For bras, I love our Cotton Jersey Scoop Bralette – it's lined with this amazing power mesh so you get great support and is so comfy I can sleep in it. I also love our Seamless Sculpt Bodysuit – it's the perfect all in one sculpting, shaping and smoothing shapewear piece with different levels of support woven throughout.</div>
                            <div class="heading4 md:mt-8 mt-5">How did SKIMS start?</div>
                            <div class="body1 mt-4">This is such a hard question! Honestly, every time we drop a new collection I get obsessed with it. The pieces that have been my go-tos though are some of our simplest styles that we launched with. I wear our Fits Everybody Thong every single day – it is the only underwear I have now, it's so comfortable and stretchy and light enough that you can wear anything over it.</div>
                            <div class="quote-block md:mt-8 mt-5 py-6 md:px-10 px-6 border border-line md:rounded-[20px] rounded-2xl flex items-center md:gap-10 gap-6">
                                <i class="ph-fill ph-quotes text-green text-3xl rotate-180 flex-shrink-0"></i>
                                <div>
                                    <div class="heading6">"For bras, I love our Cotton Jersey Scoop Bralette – it's lined with this amazing power mesh so you get great support and is so comfy I can sleep in it."</div>
                                    <div class="text-button-uppercase text-secondary mt-4">- Anthony Bourdain</div>
                                </div>
                            </div>
                            <div class="body1 md:mt-8 mt-5">For bras, I love our Cotton Jersey Scoop Bralette – it's lined with this amazing power mesh so you get great support and is so comfy I can sleep in it. I also love our Seamless Sculpt Bodysuit – it's the perfect all in one sculpting, shaping and smoothing shapewear piece with different levels of support woven throughout.</div>
                            <div class="body1 mt-4">For bras, I love our Cotton Jersey Scoop Bralette – it’s lined with this amazing power mesh so you get great support and is so comfy I can sleep in it. I also love our Seamless Sculpt Bodysuit – it’s the perfect all in one sculpting, shaping and smoothing shapewear piece with different levels of support woven throughout.</div>
                        </div>
                        <div class="action flex items-center justify-between flex-wrap gap-5 md:mt-8 mt-5">
                            <div class="left flex items-center gap-3 flex-wrap">
                                <p>Tag:</p>
                                <div class="list flex items-center gap-3 flex-wrap">
                                    <a href="{{ route('home') }}" class="tags bg-surface py-1.5 px-4 rounded-full text-button-uppercase cursor-pointer duration-300 hover:bg-black hover:text-white"> fashion </a>
                                    <a href="{{ route('home') }}" class="tags bg-surface py-1.5 px-4 rounded-full text-button-uppercase cursor-pointer duration-300 hover:bg-black hover:text-white"> yoga </a>
                                    <a href="{{ route('home') }}" class="tags bg-surface py-1.5 px-4 rounded-full text-button-uppercase cursor-pointer duration-300 hover:bg-black hover:text-white"> organic </a>
                                </div>
                            </div>
                            <div class="right flex items-center gap-3 flex-wrap">
                                <p>Share:</p>
                                <div class="list flex items-center gap-3 flex-wrap">
                                    <a href="https://www.facebook.com/" target="_blank" class="bg-surface w-10 h-10 flex items-center justify-center rounded-full duration-300 hover:bg-black hover:text-white">
                                        <div class="icon-facebook duration-100"></div>
                                    </a>
                                    <a href="https://www.instagram.com/" target="_blank" class="bg-surface w-10 h-10 flex items-center justify-center rounded-full duration-300 hover:bg-black hover:text-white">
                                        <div class="icon-instagram duration-100"></div>
                                    </a>
                                    <a href="https://www.twitter.com/" target="_blank" class="bg-surface w-10 h-10 flex items-center justify-center rounded-full duration-300 hover:bg-black hover:text-white">
                                        <div class="icon-twitter duration-100"></div>
                                    </a>
                                    <a href="https://www.youtube.com/" target="_blank" class="bg-surface w-10 h-10 flex items-center justify-center rounded-full duration-300 hover:bg-black hover:text-white">
                                        <div class="icon-youtube duration-100"></div>
                                    </a>
                                    <a href="https://www.pinterest.com/" target="_blank" class="bg-surface w-10 h-10 flex items-center justify-center rounded-full duration-300 hover:bg-black hover:text-white">
                                        <div class="icon-pinterest duration-100"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="next-pre flex items-center justify-between md:mt-8 mt-5 py-6 border-y border-line">
                            <div class="left cursor-pointer">
                                <div class="text-button-uppercase text-secondary2">Previous</div>
                                <div class="text-title prev mt-2">blogData[blogData.length - 1].title</div>
                            </div>
                            <div class="right text-right cursor-pointer">
                                <div class="text-button-uppercase text-secondary2">Next</div>
                                <div class="text-title next mt-2">blogData[0].title</div>
                            </div>
                        </div>
                        <div class="list-comment md:mt-[60px] mt-8">
                            <div class="heading flex items-center justify-between flex-wrap gap-4">
                                <div class="heading4">03 Comments</div>
                                <div class="right flex items-center gap-3">
                                    <label for="select-filter" class="uppercase">Sort by:</label>
                                    <div class="select-block relative">
                                        <select id="select-filter" name="select-filter" class="text-button py-2 pl-3 md:pr-14 pr-10 rounded-lg bg-white border border-line">
                                            <option value="Sorting" disabled>Sorting</option>
                                            <option value="newest">Newest</option>
                                            <option value="5star">5 Star</option>
                                            <option value="4star">4 Star</option>
                                            <option value="3star">3 Star</option>
                                            <option value="2star">2 Star</option>
                                            <option value="1star">1 Star</option>
                                        </select>
                                        <i class="ph ph-caret-down text-xs absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-review mt-6">
                                <div class="item">
                                    <div class="heading flex items-center justify-between">
                                        <div class="user-infor flex gap-4">
                                            <div class="avatar-cmt">
                                                <img src="{{ asset('assets/images/avatar/1.png" alt="img" class="w-[52px] aspect-square rounded-full') " />
                                            </div>
                                            <div class="user">
                                                <div class="flex items-center gap-2">
                                                    <div class="text-title">Tony Nguyen</div>
                                                    <div class="span text-line">-</div>
                                                    <div class="rate flex">
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i><i class="ph-fill ph-star text-xs text-yellow"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <div class="text-secondary2">1 days ago</div>
                                                    <div class="text-secondary2">-</div>
                                                    <div class="text-secondary2"><span>Yellow</span> / <span>XL</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="more-action cursor-pointer">
                                            <i class="ph-bold ph-dots-three text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">I can't get enough of the fashion pieces from this brand. They have a great selection for every occasion and the prices are reasonable. The shipping is fast and the items always arrive in perfect condition.</div>
                                    <div class="action flex justify-between mt-3">
                                        <div class="left flex items-center gap-4">
                                            <div class="like-btn flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-hands-clapping text-lg"></i>
                                                <div class="text-button">20</div>
                                            </div>
                                            <div class="hide-rep-btn flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-chat text-lg"></i>
                                                <div class="text-button">Hide Replies</div>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="reply-btn text-button text-secondary">Reply</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item md:mt-8 mt-5">
                                    <div class="heading flex items-center justify-between">
                                        <div class="user-infor flex gap-4">
                                            <div class="avatar-cmt">
                                                <img src="{{ asset('assets/images/avatar/2.png" alt="img" class="w-[52px] aspect-square rounded-full') " />
                                            </div>
                                            <div class="user">
                                                <div class="flex items-center gap-2">
                                                    <div class="text-title">Guy Hawkins</div>
                                                    <div class="span text-line">-</div>
                                                    <div class="rate flex">
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-secondary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <div class="text-secondary2">1 days ago</div>
                                                    <div class="text-secondary2">-</div>
                                                    <div class="text-secondary2"><span>Yellow</span> / <span>XL</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="more-action cursor-pointer">
                                            <i class="ph-bold ph-dots-three text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">I can't get enough of the fashion pieces from this brand. They have a great selection for every occasion and the prices are reasonable. The shipping is fast and the items always arrive in perfect condition.</div>
                                    <div class="action flex justify-between mt-3">
                                        <div class="left flex items-center gap-4">
                                            <div class="like-btn flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-hands-clapping text-lg"></i>
                                                <div class="text-button">20</div>
                                            </div>
                                            <div class="hide-rep-btn flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-chat text-lg"></i>
                                                <div class="text-button">Hide Replies</div>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="reply-btn text-button text-secondary">Reply</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item md:mt-8 mt-5">
                                    <div class="heading flex items-center justify-between">
                                        <div class="user-infor flex gap-4">
                                            <div class="avatar-cmt">
                                                <img src="{{ asset('assets/images/avatar/3.png" alt="img" class="w-[52px] aspect-square rounded-full') " />
                                            </div>
                                            <div class="user">
                                                <div class="flex items-center gap-2">
                                                    <div class="text-title">John Smith</div>
                                                    <div class="span text-line">-</div>
                                                    <div class="rate flex">
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i>
                                                        <i class="ph-fill ph-star text-xs text-yellow"></i><i class="ph-fill ph-star text-xs text-yellow"></i>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <div class="text-secondary2">1 days ago</div>
                                                    <div class="text-secondary2">-</div>
                                                    <div class="text-secondary2"><span>Yellow</span> / <span>XL</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="more-action cursor-pointer">
                                            <i class="ph-bold ph-dots-three text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">I can't get enough of the fashion pieces from this brand. They have a great selection for every occasion and the prices are reasonable. The shipping is fast and the items always arrive in perfect condition.</div>
                                    <div class="action flex justify-between mt-3">
                                        <div class="left flex items-center gap-4">
                                            <div class="like-btn flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-hands-clapping text-lg"></i>
                                                <div class="text-button">20</div>
                                            </div>
                                            <div class="hide-rep-btn flex items-center gap-1 cursor-pointer">
                                                <i class="ph ph-chat text-lg"></i>
                                                <div class="text-button">Hide Replies</div>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="reply-btn text-button text-secondary">Reply</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-review" class="form-review md:p-10 p-6 bg-surface rounded-xl md:mt-10 mt-6">
                                <div class="heading4">Leave A comment</div>
                                <form class="grid sm:grid-cols-2 gap-4 gap-y-5 md:mt-6 mt-3">
                                    <div class="name">
                                        <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="username" type="text" placeholder="Your Name *" required />
                                    </div>
                                    <div class="mail">
                                        <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="email" type="email" placeholder="Your Email *" required />
                                    </div>
                                    <div class="col-span-full message">
                                        <textarea class="border border-line px-4 py-3 w-full rounded-lg" id="message" name="message" placeholder="Your message *" rows="4" required></textarea>
                                    </div>
                                    <div class="col-span-full flex items-start -mt-2 gap-2">
                                        <input type="checkbox" id="saveAccount" name="saveAccount" class="mt-1.5" />
                                        <label class="" for="saveAccount">Save my name, email, and website in this browser for the next time I comment.</label>
                                    </div>
                                    <div class="col-span-full sm:pt-3">
                                        <button class="button-main bg-white text-black border border-black">Submit Reviews</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="right xl:w-1/4 lg:w-1/3 lg:pl-[45px]">
                        <div class="about-author">
                            <div class="heading flex gap-5">
                                <div class="avatar w-[100px] h-[100px] rounded-full overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('assets/images/avatar/1.png" alt="avatar" class="w-full h-full object-cover') " />
                                </div>
                                <div>
                                    <div class="heading6 blog-author">{blogMain.author}</div>
                                    <div class="caption1 text-secondary mt-1">200 Follower</div>
                                    <div class="button-main bg-white text-black px-5 py-1 border border-line text-button rounded-full capitalize mt-2">Follow</div>
                                </div>
                            </div>
                            <div class="text-secondary mt-5"><span class="blog-author">{blogMain.author}</span> is a writer who draws. He’s the Bestselling author of “Number of The Year”. Donec vitae tortor efficitur, convallis lelobortis elit.</div>
                            <div class="list-social mt-4 flex items-center gap-6 flex-wrap">
                                <a href="https://www.facebook.com/" target="_blank" class="">
                                    <div class="icon-facebook md:text-xl duration-100"></div>
                                </a>
                                <a href="https://www.instagram.com/" target="_blank" class="">
                                    <div class="icon-instagram md:text-xl duration-100"></div>
                                </a>
                                <a href="https://www.twitter.com/" target="_blank" class="">
                                    <div class="icon-twitter md:text-xl duration-100"></div>
                                </a>
                                <a href="https://www.youtube.com/" target="_blank" class="">
                                    <div class="icon-youtube md:text-xl duration-100"></div>
                                </a>
                                <a href="https://www.pinterest.com/" target="_blank" class="">
                                    <div class="icon-pinterest md:text-xl duration-100"></div>
                                </a>
                            </div>
                        </div>
                        <div class="recent md:mt-10 mt-6">
                            <div class="heading6">Recent Posts</div>
                            <div class="list-recent pt-1">
                                <div class="blog-item flex gap-4 mt-5 cursor-pointer" data-item="13">
                                    <img src="{{ asset('assets/images/blog/yoga1.png" alt="img" class="w-20 h-20 object-cover rounded-lg flex-shrink-0') " />
                                    <div>
                                        <div class="blog-tag whitespace-nowrap bg-green py-0.5 px-2 rounded-full text-button-uppercase text-xs inline-block">Jean</div>
                                        <div class="text-title mt-1">Fashion Trends in Summer 2024</div>
                                    </div>
                                </div>
                                <div class="blog-item flex gap-4 mt-5 cursor-pointer" data-item="16">
                                    <img src="{{ asset('assets/images/blog/organic1.png" alt="img" class="w-20 h-20 object-cover rounded-lg flex-shrink-0') " />
                                    <div>
                                        <div class="blog-tag whitespace-nowrap bg-green py-0.5 px-2 rounded-full text-button-uppercase text-xs inline-block">fruits</div>
                                        <div class="text-title mt-1">Organic Good for Health trending in winter 2024</div>
                                    </div>
                                </div>
                                <div class="blog-item flex gap-4 mt-5 cursor-pointer" data-item="15">
                                    <img src="{{ asset('assets/images/blog/yoga3.png" alt="img" class="w-20 h-20 object-cover rounded-lg flex-shrink-0') " />
                                    <div>
                                        <div class="blog-tag whitespace-nowrap bg-green py-0.5 px-2 rounded-full text-button-uppercase text-xs inline-block">Yoga</div>
                                        <div class="text-title mt-1">Trending Excercise in Summer 2024</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="subcribe md:mt-10 mt-6 bg-surface p-6 rounded-[20px]">
                            <div class="text-center heading5">Subscribe For Daily Newsletter</div>
                            <form class="mt-5">
                                <input class="text-center md:h-[50px] h-[44px] w-full px-4 rounded-xl" type="email" placeholder="Your email address" required />
                                <button class="button-main text-center w-full mt-4">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:pb-20 pb-10">
                <div class="news-block md:pt-20 pt-10">
                    <div class="container">
                        <div class="heading3 text-center">News insight</div>
                        <div class="list grid lg:grid-cols-3 sm:grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
                            <div class="blog-item style-one h-full cursor-pointer" data-item="16">
                                <div class="blog-main h-full block">
                                    <div class="blog-thumb rounded-[20px] overflow-hidden">
                                        <img src="{{ asset('assets/images/blog/organic1.png" alt="blog-img" class="w-full duration-500') " />
                                    </div>
                                    <div class="blog-infor mt-7">
                                        <div class="blog-tag bg-green py-1 px-2.5 rounded-full text-button-uppercase inline-block">Jean, glasses</div>
                                        <div class="heading6 blog-title mt-3 duration-300">Fashion Trends to Watch Out for in Summer 2024</div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="blog-author caption1 text-secondary">by Chris Evans</div>
                                            <span class="w-[20px] h-[1px] bg-black"></span>
                                            <div class="blog-date caption1 text-secondary">Dec 20, 2024</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-item style-one h-full cursor-pointer" data-item="8">
                                <div class="blog-main h-full block">
                                    <div class="blog-thumb rounded-[20px] overflow-hidden">
                                        <img src="{{ asset('assets/images/blog/8.png" alt="blog-img" class="w-full duration-500') " />
                                    </div>
                                    <div class="blog-infor mt-7">
                                        <div class="blog-tag bg-green py-1 px-2.5 rounded-full text-button-uppercase inline-block">Jean, shoes</div>
                                        <div class="heading6 blog-title mt-3 duration-300">How to Build a Sustainable and Stylish Wardrobe 2024</div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="blog-author caption1 text-secondary">by Alex Balde</div>
                                            <span class="w-[20px] h-[1px] bg-black"></span>
                                            <div class="blog-date caption1 text-secondary">Dec 12, 2024</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-item style-one h-full cursor-pointer max-lg:hidden max-sm:block" data-item="14">
                                <div class="blog-main h-full block">
                                    <div class="blog-thumb rounded-[20px] overflow-hidden">
                                        <img src="{{ asset('assets/images/blog/yoga2.png" alt="blog-img" class="w-full duration-500') " />
                                    </div>
                                    <div class="blog-infor mt-7">
                                        <div class="blog-tag bg-green py-1 px-2.5 rounded-full text-button-uppercase inline-block">Jean, skirt</div>
                                        <div class="heading6 blog-title mt-3 duration-300">Fashion and Beauty Tips for Busy Professionals 2024</div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="blog-author caption1 text-secondary">by Leona Pablo</div>
                                            <span class="w-[20px] h-[1px] bg-black"></span>
                                            <div class="blog-date caption1 text-secondary">Dec 10, 2024</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
