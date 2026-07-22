@extends('layouts.app')

@section('title', 'Login - Perch Bottle')

@section('content')
<div id="menu-mobile" class="">
                <div class="menu-container bg-white h-full">
                    <div class="container h-full">
                        <div class="menu-main h-full overflow-hidden">
                            <div class="heading py-2 relative flex items-center justify-center">
                                <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                                    <i class="ph ph-x text-sm"></i>
                                </div>
                                <a href="{{ route('home') }}" class="logo text-3xl font-semibold text-center">Perch Bottle</a>
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
                                                                <a href="{{ route('login') }}" class="link text-secondary duration-300 active"> Login/Register </a>
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

            <div class="breadcrumb-block style-shared">
                <div class="breadcrumb-main bg-linear overflow-hidden">
                    <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                        <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                            <div class="text-content">
                                <div class="heading2 text-center">Login</div>
                                <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                    <a href="{{ route('home') }}">Homepage</a>
                                    <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                    <div class="text-secondary2 capitalize">Login</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-block md:py-20 py-10">
            <div class="container">
                <div class="content-main flex gap-y-8 max-md:flex-col">
                    <div class="left md:w-1/2 w-full lg:pr-[60px] md:pr-[40px] md:border-r border-line">
                        <div class="heading4">Login</div>
                        
                        <!-- Error Message Container -->
                        <div id="login-error" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                <div class="flex-1">
                                    <div class="font-medium text-red-800 mb-2" id="login-error-title">Login Failed</div>
                                    <div class="text-sm text-red-700" id="login-error-message"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Helper Message -->
                        <div id="login-helper" class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <i class="ph ph-info mr-1"></i>
                                Enter your email address and password to login to your account.
                            </p>
                        </div>

                        <!-- Mobile OTP Login Form (Hidden by default) -->
                        <form id="mobile-login-form" class="md:mt-7 mt-4 hidden">
                            @csrf
                            
                            <!-- Mobile Number Input -->
                            <div class="mobile-input">
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">+91</span>
                                    <input 
                                        class="border-line px-4 pt-3 pb-3 w-full rounded-lg pl-12" 
                                        id="mobile" 
                                        name="mobile" 
                                        type="tel" 
                                        placeholder="Enter 10-digit mobile number *" 
                                        pattern="[6-9][0-9]{9}"
                                        maxlength="10"
                                        required 
                                    />
                                </div>
                            </div>
                            
                            <!-- OTP Section (Initially Hidden) -->
                            <div id="otp-section" class="mt-5 hidden">
                                <div class="otp-input">
                                    <input 
                                        class="border-line px-4 pt-3 pb-3 w-full rounded-lg text-center tracking-widest font-mono text-lg" 
                                        id="otp" 
                                        name="otp" 
                                        type="text" 
                                        placeholder="Enter 6-digit OTP" 
                                        maxlength="6"
                                        pattern="[0-9]{6}"
                                    />
                                </div>
                                
                                <!-- OTP Timer and Resend -->
                                <div class="flex items-center justify-between mt-3">
                                    <div class="text-sm text-gray-600">
                                        <span id="otp-timer"></span>
                                    </div>
                                    <button type="button" id="resend-otp" class="text-sm font-semibold text-blue-600 hover:text-blue-800 disabled:text-gray-400 disabled:cursor-not-allowed" disabled>
                                        Resend OTP
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="block-button md:mt-7 mt-4">
                                <button 
                                    type="submit" 
                                    id="login-submit-btn"
                                    class="button-main text-white border-0 w-full text-center block" 
                                    style="background-color: #B09FE6; transition: background-color 0.3s ease;" 
                                    onmouseover="this.style.backgroundColor='#9B8AD0'" 
                                    onmouseout="this.style.backgroundColor='#B09FE6'"
                                >
                                    Send OTP
                                </button>
                            </div>
                            
                            <!-- Admin Login Link -->
                            <div class="block-button mt-3">
                                <a href="{{ route('admin.login') }}" class="button-main bg-white text-black border border-black w-full text-center block">Admin Login</a>
                            </div>
                            
                            <!-- Toggle Login Method -->
                            <div class="text-center mt-4">
                                <button type="button" id="toggle-login-method" class="text-sm text-gray-600 hover:text-gray-800 underline">
                                    Use Email & Password Login Instead
                                </button>
                            </div>
                        </form>
                        
                        <!-- Email/Password Login Form -->
                        <form id="email-login-form" class="md:mt-7 mt-4" method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ request()->get('redirect', route('my-account')) }}" />
                            
                            <div class="email">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="email" name="email" type="email" placeholder="Email Address *" required />
                            </div>
                            <div class="pass mt-5">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="password" name="password" type="password" placeholder="Password *" required />
                            </div>
                            <div class="flex items-center justify-between mt-5">
                                <div class="flex items-center">
                                    <div class="block-input">
                                        <input type="checkbox" name="remember" id="remember" />
                                        <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                    </div>
                                    <label for="remember" class="pl-2 cursor-pointer">Remember me</label>
                                </div>
                                <a href="{{ route('forgot-password') }}" class="font-semibold hover:underline">Forgot Password?</a>
                            </div>
                            <div class="block-button md:mt-7 mt-4">
                                <button type="submit" class="button-main text-white border-0 w-full text-center block" style="background-color: #B09FE6; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#9B8AD0'" onmouseout="this.style.backgroundColor='#B09FE6'">Login</button>
                            </div>
                            
                            <!-- Toggle to Mobile Login (Optional) -->
                            <div class="text-center mt-4">
                                <button type="button" id="toggle-mobile-login" class="text-sm text-gray-600 hover:text-gray-800 underline">
                                    Use Mobile OTP Login Instead
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="right md:w-1/2 w-full lg:pl-[60px] md:pl-[40px] flex items-center">
                        <div class="text-content">
                            <div class="heading4">New Customer</div>
                            <div class="mt-2 text-secondary">Be part of our growing family of new customers! Join us today and unlock a world of exclusive benefits, offers, and personalized experiences.</div>
                            <div class="block-button md:mt-7 mt-4">
                                <a href="{{ route('register') }}" class="button-main" style="background-color: #B09FE6; border: none; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#9B8AD0'" onmouseout="this.style.backgroundColor='#B09FE6'">Register</a>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
        
        <script>
        // Login form handling
        document.addEventListener('DOMContentLoaded', function() {
            const mobileLoginForm = document.getElementById('mobile-login-form');
            const emailLoginForm = document.getElementById('email-login-form');
            const mobileInput = document.getElementById('mobile');
            const otpSection = document.getElementById('otp-section');
            const otpInput = document.getElementById('otp');
            const submitBtn = document.getElementById('login-submit-btn');
            const resendBtn = document.getElementById('resend-otp');
            const otpTimer = document.getElementById('otp-timer');
            const toggleLoginMethod = document.getElementById('toggle-login-method');
            const toggleMobileLogin = document.getElementById('toggle-mobile-login');
            
            let isOtpSent = false;
            let timerInterval = null;
            let timerSeconds = 0;
            
            // Helper functions for error display
            function showLoginError(message, title = 'Login Failed') {
                const errorContainer = document.getElementById('login-error');
                const errorTitle = document.getElementById('login-error-title');
                const errorMessage = document.getElementById('login-error-message');
                const helperMessage = document.getElementById('login-helper');
                
                if (errorTitle) errorTitle.textContent = title;
                if (errorMessage) errorMessage.textContent = message;
                if (errorContainer) {
                    errorContainer.classList.remove('hidden');
                    errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                if (helperMessage) helperMessage.classList.add('hidden');
            }
            
            function clearLoginError() {
                const errorContainer = document.getElementById('login-error');
                const helperMessage = document.getElementById('login-helper');
                
                if (errorContainer) errorContainer.classList.add('hidden');
                if (helperMessage) helperMessage.classList.remove('hidden');
            }
            
            // Clear errors when user starts typing
            mobileInput.addEventListener('input', function() {
                clearLoginError();
                let value = this.value.replace(/\D/g, '');
                if (value.length > 10) value = value.slice(0, 10);
                this.value = value;
            });
            
            // Clear errors when user types OTP
            otpInput.addEventListener('input', function() {
                clearLoginError();
                let value = this.value.replace(/\D/g, '');
                if (value.length > 6) value = value.slice(0, 6);
                this.value = value;
                
                if (value.length === 6) {
                    setTimeout(() => {
                        mobileLoginForm.dispatchEvent(new Event('submit'));
                    }, 500);
                }
            });
            
            // Start OTP timer
            function startTimer() {
                timerSeconds = 60;
                resendBtn.disabled = true;
                
                timerInterval = setInterval(function() {
                    if (timerSeconds > 0) {
                        const minutes = Math.floor(timerSeconds / 60);
                        const seconds = timerSeconds % 60;
                        otpTimer.textContent = `Resend OTP in ${minutes}:${seconds.toString().padStart(2, '0')}`;
                        timerSeconds--;
                    } else {
                        clearInterval(timerInterval);
                        otpTimer.textContent = '';
                        resendBtn.disabled = false;
                    }
                }, 1000);
            }
            
            // Toggle between login methods
            if (toggleLoginMethod) {
                toggleLoginMethod.addEventListener('click', function() {
                    mobileLoginForm.classList.add('hidden');
                    emailLoginForm.classList.remove('hidden');
                    clearLoginError();
                });
            }
            
            if (toggleMobileLogin) {
                toggleMobileLogin.addEventListener('click', function() {
                    emailLoginForm.classList.add('hidden');
                    mobileLoginForm.classList.remove('hidden');
                    clearLoginError();
                });
            }
            
            // Form submission
            mobileLoginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!isOtpSent) {
                    // Send OTP
                    const mobile = mobileInput.value.trim();
                    
                    if (!mobile || mobile.length !== 10) {
                        alert('Please enter a valid 10-digit mobile number');
                        return;
                    }
                    
                    if (!mobile.match(/^[6-9][0-9]{9}$/)) {
                        alert('Mobile number must start with 6, 7, 8, or 9');
                        return;
                    }
                    
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Sending OTP...';
                    
                    fetch('/api/auth/login/send-otp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ mobile: mobile })
                    })
                    .then(response => {
                        console.log('Send OTP Response status:', response.status);
                        console.log('Send OTP Response ok:', response.ok);
                        
                        // Check if response has the json method
                        if (typeof response.json === 'function') {
                            return response.json();
                        } else if (typeof response.text === 'function') {
                            return response.text().then(text => {
                                console.log('Send OTP Raw response:', text);
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    console.error('Send OTP Failed to parse JSON:', e);
                                    throw new Error('Invalid JSON response: ' + text);
                                }
                            });
                        } else {
                            console.log('Send OTP Direct response:', response);
                            return response;
                        }
                    })
                    .then(data => {
                        console.log('Send OTP data:', data);
                        if (data && data.success) {
                            isOtpSent = true;
                            otpSection.classList.remove('hidden');
                            mobileInput.disabled = true;
                            submitBtn.textContent = 'Verify & Login';
                            startTimer();
                            otpInput.focus();
                        } else {
                            let errorMessage = data.message || 'Failed to send OTP';
                            
                            if (data.errors) {
                                console.log('Login errors:', data.errors);
                            }
                            
                            // Show user-friendly message in UI
                            if (errorMessage.includes('not registered')) {
                                showLoginError('This mobile number is not registered. Please register first.', 'Account Not Found');
                            } else {
                                showLoginError(errorMessage);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Send OTP Error:', error);
                        alert('Failed to send OTP. Please try again.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                    });
                    
                } else {
                    // Verify OTP and login
                    const mobile = mobileInput.value.trim();
                    const otp = otpInput.value.trim();
                    
                    if (!otp || otp.length !== 6) {
                        alert('Please enter a valid 6-digit OTP');
                        return;
                    }
                    
                    if (!otp.match(/^[0-9]{6}$/)) {
                        alert('OTP must be 6 digits');
                        return;
                    }
                    
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Verifying...';
                    
                    fetch('/api/auth/login/verify', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ 
                            mobile: mobile,
                            otp: otp 
                        })
                    })
                    .then(response => {
                        console.log('Verify OTP Response status:', response.status);
                        console.log('Verify OTP Response ok:', response.ok);
                        
                        // Check if response has the json method
                        if (typeof response.json === 'function') {
                            return response.json();
                        } else if (typeof response.text === 'function') {
                            return response.text().then(text => {
                                console.log('Verify OTP Raw response:', text);
                                try {
                                    return JSON.parse(text);
                                } catch (e) {
                                    console.error('Verify OTP Failed to parse JSON:', e);
                                    throw new Error('Invalid JSON response: ' + text);
                                }
                            });
                        } else {
                            console.log('Verify OTP Direct response:', response);
                            return response;
                        }
                    })
                    .then(data => {
                        console.log('Verify OTP data:', data);
                        if (data && data.success) {
                            // Store token if provided
                            if (data.token) {
                                localStorage.setItem('auth_token', data.token);
                                console.log('Token stored:', data.token);
                            }
                            
                            // Store user data if provided
                            if (data.user) {
                                localStorage.setItem('user_data', JSON.stringify(data.user));
                                console.log('User data stored:', data.user);
                            }
                            
                            // Redirect to My Account with welcome message
                            let redirectUrl = data.redirect_url || '{{ route("my-account") }}';
                            if (data.login_success) {
                                redirectUrl += (redirectUrl.includes('?') ? '&' : '?') + 'login_success=' + encodeURIComponent(data.login_success);
                            }
                            window.location.replace(redirectUrl);
                        } else {
                            let errorMessage = data.message || 'Login failed';
                            
                            if (data.errors) {
                                console.log('Verification errors:', data.errors);
                            }
                            
                            // Show error in UI
                            if (errorMessage.includes('expired') || errorMessage.includes('invalid')) {
                                showLoginError('The OTP you entered is invalid or has expired. Please request a new OTP.', 'Invalid OTP');
                            } else {
                                showLoginError(errorMessage);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Verify OTP Error:', error);
                        alert('Failed to verify OTP. Please try again.');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Verify & Login';
                    });
                }
            });
            
            // Resend OTP
            resendBtn.addEventListener('click', function() {
                const mobile = mobileInput.value.trim();
                
                if (!mobile || mobile.length !== 10) {
                    alert('Please enter a valid mobile number');
                    return;
                }
                
                resendBtn.disabled = true;
                const originalText = resendBtn.textContent;
                resendBtn.textContent = 'Sending...';
                
                fetch('/api/auth/login/resend-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ mobile: mobile })
                })
                .then(response => {
                    console.log('Resend OTP Response status:', response.status);
                    console.log('Resend OTP Response ok:', response.ok);
                    
                    // Check if response has the json method
                    if (typeof response.json === 'function') {
                        return response.json();
                    } else if (typeof response.text === 'function') {
                        return response.text().then(text => {
                            console.log('Resend OTP Raw response:', text);
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Resend OTP Failed to parse JSON:', e);
                                throw new Error('Invalid JSON response: ' + text);
                            }
                        });
                    } else {
                        console.log('Resend OTP Direct response:', response);
                        return response;
                    }
                })
                .then(data => {
                    console.log('Resend OTP data:', data);
                    if (data && data.success) {
                        alert('OTP sent successfully!');
                        startTimer();
                        otpInput.value = '';
                        otpInput.focus();
                    } else {
                        alert(data.message || 'Failed to resend OTP. Please try again.');
                        resendBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Resend OTP Error:', error);
                    alert('Failed to resend OTP. Please try again.');
                    resendBtn.disabled = false;
                })
                .finally(() => {
                    resendBtn.textContent = originalText;
                });
            });
            
            // This is now handled in the input validation above
        });
        </script>
@endsection
