@extends('layouts.app')

@section('title', 'Wishlist - Perch Bottle')

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
                                                                <a href="{{ route('wishlist') }}" class="link text-secondary duration-300 active"> Wish List </a>
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

            <div class="breadcrumb-block style-shared">
                <div class="breadcrumb-main bg-linear overflow-hidden">
                    <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                        <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                            <div class="text-content">
                                <div class="heading2 text-center">Wishlist</div>
                                <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                    <a href="{{ route('home') }}">Homepage</a>
                                    <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                    <div class="text-secondary2 capitalize">Wishlist</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wishlist-block lg:py-20 md:py-14 py-10">
            <div class="container">
                <div class="list-product-block">
                    <div class="relative">
                        <div class="filter-heading flex items-center justify-between gap-5 flex-wrap">
                            <div class="left flex has-line items-center flex-wrap gap-5">
                                <div class="choose-layout menu-tab flex items-center gap-2">
                                    <div class="item tab-item three-col p-2 border border-line rounded flex items-center justify-center cursor-pointer">
                                        <div class="flex three-col items-center gap-0.5">
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        </div>
                                    </div>
                                    <div class="item tab-item four-col p-2 border border-line rounded flex items-center justify-center cursor-pointer active">
                                        <div class="flex four-col items-center gap-0.5">
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        </div>
                                    </div>
                                    <div class="item tab-item five-col p-2 border border-line rounded flex items-center justify-center cursor-pointer">
                                        <div class="flex five-col items-center gap-0.5">
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                            <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right flex items-center gap-3">
                                <div class="select-block filter-type relative">
                                    <select class="caption1 py-2 pl-3 md:pr-12 pr-8 rounded-lg border border-line capitalize" name="select-type" id="select-type">
                                        <option value="Type">Type</option>
                                        <option class="item cursor-pointer">t-shirt</option>
                                        <option class="item cursor-pointer">dress</option>
                                        <option class="item cursor-pointer">top</option>
                                        <option class="item cursor-pointer">swimwear</option>
                                        <option class="item cursor-pointer">shirt</option>
                                        <option class="item cursor-pointer">underwear</option>
                                        <option class="item cursor-pointer">sets</option>
                                    </select>
                                    <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                                </div>
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
                    </div>

                    <div class="list-product hide-product-sold grid lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 sm:gap-[30px] gap-[20px] mt-7" id="wishlist-product-list">
                        {{-- Filled by JS from localStorage --}}
                    </div>
                    <div class="wishlist-empty hidden text-center py-16" id="wishlist-empty-state">
                        <p class="text-title text-secondary2 mb-4">Your wishlist is empty.</p>
                        <a href="{{ route('shop') }}" class="button-main inline-block">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
(function() {
    var listEl = document.getElementById('wishlist-product-list');
    var emptyEl = document.getElementById('wishlist-empty-state');
    if (!listEl) return;

    var origin = (typeof window.location !== 'undefined' && window.location.origin) ? window.location.origin.replace(/\/$/, '') : '{{ url("") }}'.replace(/\/$/, '');
    var baseUrl = origin;
    var apiBase = origin + '/api';
    var defaultImg = origin + '/assets/images/product/perch-bottal.webp';

    function toAbsoluteImgUrl(url) {
        if (!url) return defaultImg;
        url = String(url).trim();
        if (url.indexOf('http') === 0) return url;
        if (url.indexOf('//') === 0) return (window.location.protocol || 'http:') + url;
        if (url.indexOf('/') === 0) return origin + url;
        var storagePath = (typeof window !== 'undefined' && window.STORAGE_PATH) ? ('/' + window.STORAGE_PATH) : '/storage';
        return origin + storagePath + '/' + url.replace(/^\/+/, '');
    }

    function normalizeProduct(p) {
        if (!p) return null;
        var id = String(p.id);
        var thumbImage = p.thumbImage;
        if (!Array.isArray(thumbImage) || thumbImage.length === 0) {
            var img = p.image || (p.images && p.images[0]);
            thumbImage = [img ? toAbsoluteImgUrl(img) : defaultImg];
        } else {
            thumbImage = thumbImage.map(function(u) { return toAbsoluteImgUrl(u); });
        }
        return {
            id: id,
            name: p.name || 'Product',
            slug: p.slug || '#',
            price: p.price != null ? String(Number(p.price).toFixed(2)) : '0.00',
            originPrice: p.originPrice != null ? String(Number(p.originPrice).toFixed(2)) : null,
            sale: !!p.sale,
            new: !!p.new,
            thumbImage: thumbImage,
            sold: parseInt(p.sold, 10) || 0,
            quantity: parseInt(p.quantity, 10) || 100,
            sizes: Array.isArray(p.sizes) ? p.sizes : [],
            variation: Array.isArray(p.variation) ? p.variation : [],
            action: p.action || 'quick shop'
        };
    }

    function addRemoveHandler(el) {
        var removeBtn = el.querySelector('.remove-from-wishlist');
        if (!removeBtn) return;
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var id = el.getAttribute('data-item');
            var raw = localStorage.getItem('wishlistStore');
            var arr = raw ? JSON.parse(raw) : [];
            arr = arr.filter(function(item) { return String(item.id) !== String(id); });
            localStorage.setItem('wishlistStore', JSON.stringify(arr));
            renderWishlist();
            if (typeof window.handleItemModalWishlist === 'function') window.handleItemModalWishlist();
            if (typeof window.updateWishlistIcons === 'function') window.updateWishlistIcons();
        });
    }

    function appendProduct(product) {
        var id = product && (product.id != null) ? String(product.id) : null;
        if (!id) return false;
        if (listEl.querySelector('[data-item="' + id.replace(/"/g, '\\"') + '"]')) return false;
        var el = null;
        if (typeof window.createProductItem === 'function') {
            try {
                el = window.createProductItem(product);
            } catch (err) { el = null; }
        }
        if (!el) {
            var imgSrc = (Array.isArray(product.thumbImage) && product.thumbImage[0]) ? toAbsoluteImgUrl(product.thumbImage[0]) : defaultImg;
            var productUrl = (product.slug && product.slug !== '#') ? (baseUrl + '/product/' + product.slug) : '#';
            var priceHtml = product.originPrice ? '<span class="text-title">₹' + product.price + '</span> <del class="text-secondary2">₹' + product.originPrice + '</del>' : '<span class="text-title">₹' + product.price + '</span>';
            el = document.createElement('div');
            el.className = 'product-item grid-type';
            el.setAttribute('data-item', product.id);
            el.setAttribute('data-slug', product.slug || '');
            el.setAttribute('data-wishlist-page', '1');
            el.innerHTML = '<div class="product-main cursor-pointer block"><div class="product-thumb bg-white relative rounded-2xl overflow-hidden">' +
                '<button type="button" class="remove-from-wishlist absolute top-3 left-3 z-10 bg-white border border-line rounded-full w-8 h-8 flex items-center justify-center text-red hover:bg-red hover:text-white caption2">×</button>' +
                '<a href="' + productUrl + '" class="product-img w-full block aspect-[3/4]"><img src="' + imgSrc + '" alt="' + (product.name || '').replace(/"/g, '&quot;') + '" class="w-full h-full object-cover" onerror="this.src=\'' + defaultImg + '\'" /></a></div>' +
                '<div class="product-infor mt-4"><div class="product-name text-title duration-300">' + (product.name || 'Product') + '</div>' +
                '<div class="flex items-center gap-2 mt-2">' + priceHtml + '</div></div></div>';
        } else {
            el.setAttribute('data-wishlist-page', '1');
            el.setAttribute('data-slug', product.slug || '');
            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-from-wishlist absolute top-3 left-3 z-10 bg-white border border-line rounded-full w-8 h-8 flex items-center justify-center text-red hover:bg-red hover:text-white caption2';
            removeBtn.innerHTML = '&times;';
            removeBtn.title = 'Remove from wishlist';
            var thumb = el.querySelector('.product-thumb');
            if (thumb) thumb.appendChild(removeBtn);
        }
        addRemoveHandler(el);
        listEl.appendChild(el);
        return true;
    }

        function finish() {
            if (typeof window.addEventToProductItem === 'function') window.addEventToProductItem();
            if (listEl.children.length === 0) {
                listEl.classList.add('hidden');
                if (emptyEl) emptyEl.classList.remove('hidden');
            }
        }

    function renderWishlist() {
        var raw = localStorage.getItem('wishlistStore');
        var items = raw ? JSON.parse(raw) : [];
        if (!Array.isArray(items)) items = [];

        var seenIds = {};
        var uniqueItems = [];
        items.forEach(function(p) {
            var id = p && (p.id != null) ? String(p.id) : null;
            if (id && !seenIds[id]) {
                seenIds[id] = true;
                uniqueItems.push(p);
            }
        });
        if (uniqueItems.length !== items.length) {
            localStorage.setItem('wishlistStore', JSON.stringify(uniqueItems));
            if (typeof window.handleItemModalWishlist === 'function') window.handleItemModalWishlist();
        }

        listEl.innerHTML = '';
        listEl.classList.remove('hidden');
        if (emptyEl) emptyEl.classList.add('hidden');

        if (uniqueItems.length === 0) {
            listEl.classList.add('hidden');
            if (emptyEl) emptyEl.classList.remove('hidden');
            if (typeof window.handleItemModalWishlist === 'function') window.handleItemModalWishlist();
            return;
        }

        // Fetch all products from API (same source as product list), preserve order, then render each with its own image
        var idsInOrder = uniqueItems.map(function(p) { return p && (p.id != null) ? String(p.id) : null; }).filter(Boolean);
        var fetchPromises = idsInOrder.map(function(id) {
            return fetch(apiBase + '/products/by-id/' + encodeURIComponent(id), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.json(); })
                .then(function(res) { return { id: id, data: (res.success && res.data) ? res.data : null }; })
                .catch(function() { return { id: id, data: null }; });
        });
        Promise.all(fetchPromises).then(function(results) {
            var dataById = {};
            var idsToRemove = [];
            results.forEach(function(r) {
                if (r && r.id) {
                    dataById[r.id] = r.data;
                    if (!r.data) idsToRemove.push(r.id);
                }
            });
            idsInOrder.forEach(function(id) {
                var productData = dataById[id];
                if (productData) {
                    appendProduct(normalizeProduct(productData));
                }
            });
            if (idsToRemove.length > 0) {
                var idsSet = {};
                idsToRemove.forEach(function(id) { idsSet[String(id)] = true; });
                var arr = uniqueItems.filter(function(p) { return !idsSet[String(p.id)]; });
                localStorage.setItem('wishlistStore', JSON.stringify(arr));
                if (typeof window.handleItemModalWishlist === 'function') window.handleItemModalWishlist();
            }
            finish();
        });
    }

    function run() {
        renderWishlist();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
</script>
@endsection
