@extends('layouts.app')

@section('title', 'My Account - Perch Bottle')

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
                                                                <a href="{{ route('my-account') }}" class="link text-secondary duration-300 active"> My Account </a>
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
                                <div class="heading2 text-center">My Account</div>
                                <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                    <a href="{{ route('home') }}">Homepage</a>
                                    <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                    <div class="text-secondary2 capitalize">My Account</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-account-block md:py-20 py-10">
            <div class="container">
                <div class="content-main lg:px-[60px] md:px-4 flex gap-y-8 max-md:flex-col w-full">
                    <div class="left md:w-1/3 w-full xl:pr-[3.125rem] lg:pr-[28px] md:pr-[16px]">
                        <div class="user-infor bg-surface md:px-8 px-5 md:py-10 py-6 md:rounded-[20px] rounded-xl">
                            <div class="heading flex flex-col items-center justify-center">
                                <div class="avatar">
                                    @php
                                        $avatarPath = $user->avatar ?? 'assets/images/avatar/1.png';
                                        $avatarUrl = str_starts_with($avatarPath, 'assets/') || str_starts_with($avatarPath, '/assets/')
                                            ? asset(ltrim($avatarPath, '/'))
                                            : \Illuminate\Support\Facades\Storage::disk('public')->url(ltrim($avatarPath, '/'));
                                        $avatarFallback = asset('assets/images/avatar/1.png');
                                    @endphp
                                    <img src="{{ $avatarUrl }}" alt="avatar" class="md:w-[140px] w-[120px] md:h-[140px] h-[120px] rounded-full object-cover" onerror="this.onerror=null; this.src='{{ $avatarFallback }}';" />
                                </div>
                                <div class="name heading6 mt-4 text-center">{{ $user->name ?? ($user->first_name . ' ' . $user->last_name) ?? 'User' }}</div>
                                <div class="mail heading6 font-normal normal-case text-secondary text-center mt-1">{{ $user->email }}</div>
                            </div>
                            <div class="menu-tab list-category w-full max-w-none lg:mt-10 mt-6">
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white active" data-item="dashboard">
                                    <span class="ph ph-house-line text-xl"></span>
                                    <strong class="heading6">Dashboard</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="orders">
                                    <span class="ph ph-package text-xl"></span>
                                    <strong class="heading6">History Orders</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="address">
                                    <span class="ph ph-tag text-xl"></span>
                                    <strong class="heading6">My Address</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="setting">
                                    <span class="ph ph-gear-six text-xl"></span>
                                    <strong class="heading6">Setting</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="change-password">
                                    <span class="ph ph-lock text-xl"></span>
                                    <strong class="heading6">Change Password</strong>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5">
                                        <span class="ph ph-sign-out text-xl"></span>
                                        <strong class="heading6">Logout</strong>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="right list-filter md:w-2/3 w-full pl-2.5">
                        <div class="filter-item text-content w-full active" data-item="dashboard">
                            @if(session('welcome_message') || request()->get('welcome_message'))
                                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
                                    <i class="ph ph-check-circle text-green-600 text-2xl flex-shrink-0"></i>
                                    <p class="text-green-800 font-medium">{{ session('welcome_message') ?? request()->get('welcome_message') }}</p>
                                </div>
                            @endif
                            @if(session('login_success') || request()->get('login_success'))
                                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center gap-3">
                                    <i class="ph ph-smiley text-blue-600 text-2xl flex-shrink-0"></i>
                                    <p class="text-blue-800 font-medium">{{ session('login_success') ?? request()->get('login_success') }}</p>
                                </div>
                            @endif
                            <div class="overview grid sm:grid-cols-3 gap-5">
                                <div class="overview-item flex items-center justify-between p-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="counter">
                                        <span class="text-secondary">Awaiting Pickup</span>
                                        <h5 class="heading5 mt-1">{{ $awaitingPickup ?? 0 }}</h5>
                                    </div>
                                    <span class="ph ph-hourglass-medium text-4xl"></span>
                                </div>
                                <div class="overview-item flex items-center justify-between p-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="counter">
                                        <span class="text-secondary">Cancelled Orders</span>
                                        <h5 class="heading5 mt-1">{{ $cancelledOrders ?? 0 }}</h5>
                                    </div>
                                    <span class="ph ph-receipt-x text-4xl"></span>
                                </div>
                                <div class="overview-item flex items-center justify-between p-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="counter">
                                        <span class="text-secondary">Total Number of Orders</span>
                                        <h5 class="heading5 mt-1">{{ $totalOrders ?? 0 }}</h5>
                                    </div>
                                    <span class="ph ph-package text-4xl"></span>
                                </div>
                            </div>
                            <div class="recent_order pt-5 px-5 pb-2 mt-7 border border-line rounded-xl">
                                <h6 class="heading6">Recent Orders</h6>
                                <div class="list overflow-x-auto w-full mt-5">
                                    @if($orders && $orders->count() > 0)
                                        <table class="w-full max-[1400px]:w-[700px] max-md:w-[700px]">
                                            <thead class="border-b border-line">
                                                <tr>
                                                    <th scope="col" class="pb-3 text-left text-sm font-bold uppercase text-secondary whitespace-nowrap">Order</th>
                                                    <th scope="col" class="pb-3 text-left text-sm font-bold uppercase text-secondary whitespace-nowrap">Products</th>
                                                    <th scope="col" class="pb-3 text-left text-sm font-bold uppercase text-secondary whitespace-nowrap">Pricing</th>
                                                    <th scope="col" class="pb-3 text-right text-sm font-bold uppercase text-secondary whitespace-nowrap">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                    @php
                                                        $firstItem = $order->items->first();
                                                        $product = $firstItem->product ?? null;
                                                        
                                                        $getImageUrl = function($path) {
                                                            if (!$path) return asset('assets/images/product/perch-bottal.webp');
                                                            if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
                                                                return asset($path);
                                                            }
                                                            return storage_asset($path);
                                                        };
                                                        
                                                        $productImage = $product ? $getImageUrl($product->image ?? null) : asset('assets/images/product/perch-bottal.webp');
                                                        $productName = $firstItem ? ($firstItem->product_name ?? $product->name ?? 'Product') : 'Product';
                                                        $productSlug = $product ? $product->slug : '#';
                                                        $categoryName = $product && $product->category ? $product->category->name : '';
                                                        
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow text-yellow',
                                                            'processing' => 'bg-purple text-purple',
                                                            'shipped' => 'bg-purple text-purple',
                                                            'delivered' => 'bg-success text-success',
                                                            'completed' => 'bg-success text-success',
                                                            'cancelled' => 'bg-red text-red',
                                                            'canceled' => 'bg-red text-red',
                                                        ];
                                                        $statusColor = $statusColors[strtolower($order->status)] ?? 'bg-secondary text-secondary';
                                                        
                                                        $totalAmount = $order->total_amount ?? $order->total ?? 0;
                                                    @endphp
                                                    <tr class="item duration-300 {{ !$loop->last ? 'border-b border-line' : '' }}">
                                                        <th scope="row" class="py-3 text-left">
                                                            <strong class="text-title">{{ $order->order_number }}</strong>
                                                        </th>
                                                        <td class="py-3">
                                                            <a href="{{ route('product.show', $productSlug) }}" class="product flex items-center gap-3">
                                                                <img src="{{ $productImage }}" alt="{{ $productName }}" class="flex-shrink-0 w-12 h-12 rounded" />
                                                                <div class="info flex flex-col">
                                                                    <strong class="product_name text-button">{{ $productName }}</strong>
                                                                    @if($categoryName)
                                                                        <span class="product_tag caption1 text-secondary">{{ $categoryName }}</span>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="py-3 price">₹{{ number_format($totalAmount, 2) }}</td>
                                                        <td class="py-3 text-right">
                                                            <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 {{ $statusColor }} caption1 font-semibold">{{ ucfirst($order->status) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="text-center py-10 text-secondary">No orders found</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="filter-item tab_order text-content overflow-hidden w-full p-7 border border-line rounded-xl" data-item="orders">
                            <h6 class="heading6">Your Orders</h6>
                            <div class="w-full overflow-x-auto">
                                <div class="menu-tab relative grid grid-cols-5 max-lg:w-[500px] max-md:max-w-max border-b border-line mt-3">
                                    <div class="indicator absolute bottom-0 w-1/5 h-0.5 bg-black duration-500"></div>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black active">all</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">pending</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">delivery</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">completed</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">canceled</button>
                                </div>
                            </div>
                            <div class="list_order">
                                @if($orders && $orders->count() > 0)
                                    @foreach($orders as $order)
                                        @php
                                            $getImageUrl = function($path) {
                                                if (!$path) return asset('assets/images/product/perch-bottal.webp');
                                                if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
                                                    return asset($path);
                                                }
                                                return storage_asset($path);
                                            };
                                            
                                            $statusColors = [
                                                'pending' => 'bg-yellow text-yellow',
                                                'processing' => 'bg-purple text-purple',
                                                'shipped' => 'bg-purple text-purple',
                                                'delivered' => 'bg-purple text-purple',
                                                'completed' => 'bg-success text-success',
                                                'cancelled' => 'bg-red text-red',
                                                'canceled' => 'bg-red text-red',
                                            ];
                                            $statusColor = $statusColors[strtolower($order->status)] ?? 'bg-secondary text-secondary';
                                        @endphp
                                        <div class="order_item mt-5 border border-line rounded-lg box-shadow-xs">
                                            <div class="flex flex-wrap items-center justify-between gap-4 p-5 border-b border-line">
                                                <div class="flex items-center gap-2">
                                                    <strong class="text-title">Order Number:</strong>
                                                    <strong class="order_number text-button uppercase">{{ $order->order_number }}</strong>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <strong class="text-title">Order status:</strong>
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 {{ $statusColor }} caption1 font-semibold">{{ ucfirst($order->status) }}</span>
                                                </div>
                                            </div>
                                            <div class="list_prd px-5">
                                                @foreach($order->items as $item)
                                                    @php
                                                        $product = $item->product;
                                                        $productImage = $product ? $getImageUrl($product->image ?? null) : asset('assets/images/product/perch-bottal.webp');
                                                        $productName = $item->product_name ?? ($product ? $product->name : 'Product');
                                                        $productSlug = $product ? $product->slug : '#';
                                                        $itemPrice = $item->price ?? ($item->total ?? 0);
                                                        $itemTotal = $item->total ?? ($itemPrice * $item->quantity);
                                                    @endphp
                                                    <div class="prd_item flex flex-wrap items-center justify-between gap-3 py-5 {{ !$loop->last ? 'border-b border-line' : '' }}">
                                                        <a href="{{ route('product.show', $productSlug) }}" class="flex items-center gap-5">
                                                            <div class="bg-img flex-shrink-0 md:w-[100px] w-20 aspect-square rounded-lg overflow-hidden">
                                                                <img src="{{ $productImage }}" alt="{{ $productName }}" class="w-full h-full object-cover" />
                                                            </div>
                                                            <div>
                                                                <div class="prd_name text-title">{{ $productName }}</div>
                                                                @if($item->size || $item->color)
                                                                    <div class="caption1 text-secondary mt-2">
                                                                        @if($item->size)
                                                                            <span class="prd_size uppercase">{{ $item->size }}</span>
                                                                        @endif
                                                                        @if($item->size && $item->color)
                                                                            <span>/</span>
                                                                        @endif
                                                                        @if($item->color)
                                                                            <span class="prd_color capitalize">{{ $item->color }}</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </a>
                                                        <div class="text-title">
                                                            <span class="prd_quantity">{{ $item->quantity }}</span>
                                                            <span> X </span>
                                                            <span class="prd_price">₹{{ number_format($itemPrice, 2) }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-wrap gap-4 p-5">
                                                <a href="{{ route('account.orders.show', $order->id) }}" class="button-main btn_order_detail">Order Details</a>
                                                @if($order->status !== 'cancelled' && $order->status !== 'canceled' && $order->status !== 'completed' && $order->status !== 'delivered')
                                                    <button class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white" onclick="cancelOrder({{ $order->id }})">Cancel Order</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-10 text-secondary">No orders found</div>
                                @endif
                            </div>
                        </div>
                        <div class="filter-item tab_address text-content w-full p-7 border border-line rounded-xl" data-item="address">
                            @if(session('success'))
                                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            @if($errors->any())
                                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between mb-5">
                                <h6 class="heading6">My Addresses</h6>
                                <button type="button" class="button-main bg-black" onclick="showAddAddressForm()">Add New Address</button>
                            </div>
                            
                            @if($addresses && $addresses->count() > 0)
                                <div class="address-list space-y-4">
                                    @foreach($addresses as $address)
                                        <div class="address-item border border-line rounded-lg p-5 {{ $address->is_default ? 'bg-surface' : '' }}" data-address-id="{{ $address->id }}" data-address='@json($address)'>
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <strong class="text-title">{{ $address->label ?? 'Address' }}</strong>
                                                        @if($address->is_default)
                                                            <span class="tag px-3 py-1 rounded-full bg-opacity-10 bg-success text-success caption1 font-semibold">Default</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-secondary caption1">
                                                        <p class="font-semibold text-title">{{ $address->full_name }}</p>
                                                        <p>{{ $address->address_line_1 }}</p>
                                                        @if($address->address_line_2)
                                                            <p>{{ $address->address_line_2 }}</p>
                                                        @endif
                                                        <p>{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                                                        <p class="mt-2">Phone: {{ $address->phone }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white text-sm px-4 py-2" onclick="editAddress({{ $address->id }})">Edit</button>
                                                    @if(!$address->is_default)
                                                        <form method="POST" action="/addresses/{{ $address->id }}/set-default" class="inline">
                                                            @csrf
                                                            <button type="submit" class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white text-sm px-4 py-2">Set Default</button>
                                                        </form>
                                                        <form method="POST" action="/addresses/{{ $address->id }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="button-main bg-red border border-red hover:bg-red-600 text-white text-sm px-4 py-2">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10 text-secondary">
                                    <p class="mb-4">No addresses saved yet.</p>
                                    <button type="button" class="button-main bg-black" onclick="showAddAddressForm()">Add Your First Address</button>
                                </div>
                            @endif
                            
                            @php
                                $addressFormEdit = $errors->any() && request('tab') === 'address' && request('edit');
                            @endphp
                            <!-- Add/Edit Address Form (Hidden by default) -->
                            <div id="addressForm" class="{{ ($errors->any() && request('tab') === 'address') ? '' : 'hidden' }} mt-6 border-t border-line pt-6">
                                <h6 class="heading6 mb-4" id="formTitle">{{ $addressFormEdit ? 'Edit Address' : 'Add New Address' }}</h6>
                                <form id="addressFormElement" method="POST" action="/my-account">
                                    @csrf
                                    <input type="hidden" name="address_id" id="addressId" value="{{ $addressFormEdit ? request('edit') : '' }}">
                                    @if($errors->has('error'))
                                        <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 caption1">{{ $errors->first('error') }}</div>
                                    @endif
                                    <div class="grid sm:grid-cols-2 gap-4 gap-y-5">
                                        <div class="label">
                                            <label for="addressLabel" class="caption1 capitalize">Label <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressLabel" name="label" type="text" value="{{ old('label', 'Home') }}" placeholder="Home, Office, etc." required />
                                            @error('label')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="full-name">
                                            <label for="addressFullName" class="caption1 capitalize">Full Name <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressFullName" name="full_name" type="text" value="{{ old('full_name', $user->name ?? '') }}" required />
                                            @error('full_name')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="phone">
                                            <label for="addressPhone" class="caption1 capitalize">Phone <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressPhone" name="phone" type="text" value="{{ old('phone', $user->phone ?? '') }}" required />
                                            @error('phone')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="address-line-1">
                                            <label for="addressLine1" class="caption1 capitalize">Address Line 1 <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressLine1" name="address_line_1" type="text" value="{{ old('address_line_1') }}" required />
                                            @error('address_line_1')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="address-line-2">
                                            <label for="addressLine2" class="caption1 capitalize">Address Line 2 (Optional)</label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressLine2" name="address_line_2" type="text" value="{{ old('address_line_2') }}" />
                                        </div>
                                        <div class="city">
                                            <label for="addressCity" class="caption1 capitalize">City <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressCity" name="city" type="text" value="{{ old('city') }}" required />
                                            @error('city')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="state">
                                            <label for="addressState" class="caption1 capitalize">State <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressState" name="state" type="text" value="{{ old('state') }}" required />
                                            @error('state')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="pincode">
                                            <label for="addressPincode" class="caption1 capitalize">Pincode <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="addressPincode" name="pincode" type="text" maxlength="6" value="{{ old('pincode') }}" required />
                                            @error('pincode')<p class="text-red text-sm mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="is-default col-span-full">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="is_default" id="addressIsDefault" value="1" class="w-4 h-4" {{ old('is_default') ? 'checked' : '' }}>
                                                <span class="caption1">Set as default address</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 mt-6">
                                        <button type="submit" class="button-main bg-black" id="saveAddressBtn">{{ $addressFormEdit ? 'Update Address' : 'Save Address' }}</button>
                                        <button type="button" class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white" onclick="hideAddressForm()">Cancel</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                        <div class="filter-item text-content w-full p-7 border border-line rounded-xl" data-item="setting">
                            @if(session('settings_success'))
                                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                    {{ session('settings_success') }}
                                </div>
                            @endif
                            
                            @if($errors->any() && request('tab') === 'setting')
                                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('my-account.settings.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="heading5 pb-4">Information</div>
                                <div class="upload_image col-span-full">
                                    <label for="uploadImage">Upload Avatar:</label>
                                    <div class="flex flex-wrap items-center gap-5 mt-3">
                                        <div class="bg_img flex-shrink-0 relative w-[7.5rem] h-[7.5rem] rounded-lg overflow-hidden bg-surface">
                                            @php
                                                $avatarPath = $user->avatar ?? 'assets/images/avatar/1.png';
                                                $avatarUrl = str_starts_with($avatarPath, 'assets/') || str_starts_with($avatarPath, '/assets/')
                                                    ? asset(ltrim($avatarPath, '/'))
                                                    : \Illuminate\Support\Facades\Storage::disk('public')->url(ltrim($avatarPath, '/'));
                                                $avatarFallback = asset('assets/images/avatar/1.png');
                                            @endphp
                                            <span class="ph ph-image text-5xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-secondary avatar-placeholder-icon"></span>
                                            <img src="{{ $avatarUrl }}" alt="avatar" class="upload_img relative z-[1] w-full h-full object-cover" id="avatarPreview" onerror="this.onerror=null; this.src='{{ $avatarFallback }}';" />
                                        </div>
                                        <div>
                                            <strong class="text-button">Upload File:</strong>
                                            <p class="caption1 text-secondary mt-1">JPG 120x120px</p>
                                            <div class="upload_file flex items-center gap-3 w-[220px] mt-3 px-3 py-2 border border-line rounded">
                                                <label for="uploadImage" class="caption2 py-1 px-3 rounded bg-line whitespace-nowrap cursor-pointer">Choose File</label>
                                                <input type="file" name="avatar" id="uploadImage" accept="image/*" class="caption2 cursor-pointer" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-4 gap-y-5 mt-5">
                                    <div class="first-name">
                                        <label for="firstName" class="caption1 capitalize">First Name <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="firstName" name="first_name" type="text" value="{{ old('first_name', $user->first_name ?? explode(' ', $user->name ?? '')[0] ?? '') }}" placeholder="First name" required />
                                    </div>
                                    <div class="last-name">
                                        <label for="lastName" class="caption1 capitalize">Last Name <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="lastName" name="last_name" type="text" value="{{ old('last_name', $user->last_name ?? (count(explode(' ', $user->name ?? '')) > 1 ? explode(' ', $user->name)[1] : '')) }}" placeholder="Last name" required />
                                    </div>
                                    <div class="phone-number">
                                        <label for="phoneNumber" class="caption1 capitalize">Phone Number <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="phoneNumber" name="phone" type="text" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Phone number" required />
                                    </div>
                                    <div class="email">
                                        <label for="email" class="caption1 capitalize">Email Address <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="Email address" required />
                                    </div>
                                    <div class="gender">
                                        <label for="gender" class="caption1 capitalize">Gender</label>
                                        <div class="select-block mt-2">
                                            <select class="border border-line px-4 py-3 w-full rounded-lg" id="gender" name="gender">
                                                <option value="">Choose Gender</option>
                                                <option value="Male" {{ old('gender', $user->gender ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $user->gender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender', $user->gender ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <span class="ph ph-caret-down arrow-down text-lg"></span>
                                        </div>
                                    </div>
                                    <div class="birth">
                                        <label for="birth" class="caption1">Day of Birth</label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}" placeholder="Day of Birth" />
                                    </div>
                                </div>
                                <div class="block-button lg:mt-10 mt-6" style="display: block !important;">
                                    <button type="submit" class="button-main w-full sm:w-auto" style="display: inline-block !important; visibility: visible !important; background-color: #1a1a1a !important; color: #fff !important;">Save Change</button>
                                </div>
                            </form>
                        </div>
                        <div class="filter-item text-content w-full p-7 border border-line rounded-xl" data-item="change-password">
                            @if(session('password_success'))
                                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                    {{ session('password_success') }}
                                </div>
                            @endif
                            
                            @if($errors->any() && request('tab') === 'change-password')
                                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('my-account.password.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="heading5 pb-4">Change Password</div>
                                <div class="pass">
                                    <label for="current_password" class="caption1">Current password <span class="text-red">*</span></label>
                                    <div class="relative mt-2">
                                        <input class="border-line px-4 py-3 w-full rounded-lg pr-12" id="current_password" name="current_password" type="password" placeholder="Current Password *" value="{{ old('current_password') }}" required />
                                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-secondary hover:text-black focus:outline-none" aria-label="Toggle password visibility" onclick="togglePasswordVisibility('current_password', this)">
                                            <i class="ph ph-eye text-xl password-eye-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="new-pass mt-5">
                                    <label for="new_password" class="caption1">New password <span class="text-red">*</span></label>
                                    <div class="relative mt-2">
                                        <input class="border-line px-4 py-3 w-full rounded-lg pr-12" id="new_password" name="new_password" type="password" placeholder="New Password *" value="{{ old('new_password') }}" required />
                                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-secondary hover:text-black focus:outline-none" aria-label="Toggle password visibility" onclick="togglePasswordVisibility('new_password', this)">
                                            <i class="ph ph-eye text-xl password-eye-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="confirm-pass mt-5">
                                    <label for="confirm_password" class="caption1">Confirm new password <span class="text-red">*</span></label>
                                    <div class="relative mt-2">
                                        <input class="border-line px-4 py-3 w-full rounded-lg pr-12" id="confirm_password" name="new_password_confirmation" type="password" placeholder="Confirm Password *" value="{{ old('new_password_confirmation') }}" required />
                                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-secondary hover:text-black focus:outline-none" aria-label="Toggle password visibility" onclick="togglePasswordVisibility('confirm_password', this)">
                                            <i class="ph ph-eye text-xl password-eye-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-button lg:mt-10 mt-6">
                                    <button type="submit" class="button-main" style="background-color: #1a1a1a !important; color: #fff !important;">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
// Toggle password visibility (eye icon)
function togglePasswordVisibility(inputId, btn) {
    var input = document.getElementById(inputId);
    var icon = btn.querySelector('i');
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('ph-eye');
        icon.classList.add('ph-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('ph-eye-slash');
        icon.classList.add('ph-eye');
    }
}

// Avatar Preview
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('uploadImage');
    const avatarPreview = document.getElementById('avatarPreview');
    
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.style.display = 'block';
                    avatarPreview.nextElementSibling.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Address Management Functions
function showAddAddressForm() {
    const form = document.getElementById('addressForm');
    const formElement = document.getElementById('addressFormElement');
    
    if (!form || !formElement) {
        console.error('Address form elements not found');
        return;
    }
    
    form.classList.remove('hidden');
    document.getElementById('formTitle').textContent = 'Add New Address';
    formElement.reset();
    document.getElementById('addressId').value = '';
    formElement.action = '/my-account';

    const submitBtn = document.getElementById('saveAddressBtn');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save Address';
    }
    
    form.scrollIntoView({ behavior: 'smooth' });
}

function hideAddressForm() {
    document.getElementById('addressForm').classList.add('hidden');
    document.getElementById('addressFormElement').reset();
}

function editAddress(addressId) {
    // Get address data from the page (we'll need to add data attributes)
    const addressElement = document.querySelector(`[data-address-id="${addressId}"]`);
    if (addressElement) {
        const address = JSON.parse(addressElement.dataset.address);
        document.getElementById('addressId').value = address.id;
        document.getElementById('addressLabel').value = address.label || 'Home';
        document.getElementById('addressFullName').value = address.full_name || '';
        document.getElementById('addressPhone').value = address.phone || '';
        document.getElementById('addressLine1').value = address.address_line_1 || '';
        document.getElementById('addressLine2').value = address.address_line_2 || '';
        document.getElementById('addressCity').value = address.city || '';
        document.getElementById('addressState').value = address.state || '';
        document.getElementById('addressPincode').value = address.pincode || '';
        document.getElementById('addressIsDefault').checked = address.is_default || false;
        
        document.getElementById('formTitle').textContent = 'Edit Address';
        document.getElementById('addressFormElement').action = '/my-account';

        const saveBtn = document.getElementById('saveAddressBtn');
        if (saveBtn) saveBtn.textContent = 'Update Address';

        document.getElementById('addressForm').classList.remove('hidden');
        document.getElementById('addressForm').scrollIntoView({ behavior: 'smooth' });
    } else {
        // Fallback: redirect to edit page or reload
        location.href = `/my-account?edit_address=${addressId}`;
    }
}

// setDefaultAddress and deleteAddress are now handled by form submissions

// Address form submission - traditional POST so browser sends session cookies (fixes 401 Unauthenticated)
document.addEventListener('DOMContentLoaded', function() {
    const addressForm = document.getElementById('addressFormElement');
    const submitBtn = document.getElementById('saveAddressBtn');
    if (addressForm && submitBtn) {
        addressForm.addEventListener('submit', function(e) {
            const t = this.querySelector('input[name="_token"]');
            if (!t || !t.value) {
                e.preventDefault();
                alert('Please refresh the page and try again.');
                return;
            }
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';
        });
    }

    // Switch to tab based on URL parameter (e.g. after save redirect)
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');
    if (tab && ['address', 'setting', 'change-password'].includes(tab)) {
        const cat = document.querySelector(`.category-item[data-item="${tab}"]`);
        const filter = document.querySelector(`.filter-item[data-item="${tab}"]`);
        if (cat && filter) {
            document.querySelectorAll('.category-item').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.filter-item').forEach(el => { el.classList.remove('active'); el.style.display = 'none'; });
            cat.classList.add('active');
            filter.classList.add('active');
            filter.style.display = 'block';
        }
    }
});

// Tab Switching Functionality for My Account
(function() {
    function initTabSwitching() {
        const categoryItems = document.querySelectorAll(".list-category .category-item[data-item]");
        const filterItems = document.querySelectorAll(".list-filter .filter-item[data-item]");
        
        if (categoryItems.length === 0 || filterItems.length === 0) {
            // Retry if elements not found yet
            setTimeout(initTabSwitching, 100);
            return;
        }
        
        // Initially hide all filter items except the active one (dashboard)
        filterItems.forEach((item) => {
            if (!item.classList.contains("active")) {
                item.style.display = "none";
            }
        });
        
        categoryItems.forEach((category) => {
            // Remove any existing click handlers by cloning
            const newCategory = category.cloneNode(true);
            category.parentNode.replaceChild(newCategory, category);
            
            newCategory.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetItem = this.getAttribute("data-item");
                if (!targetItem) return;
                
                // Remove active class from all category items
                document.querySelectorAll(".list-category .category-item").forEach((item) => {
                    item.classList.remove("active");
                });
                
                // Add active class to clicked category
                this.classList.add("active");
                
                // Hide all filter items
                document.querySelectorAll(".list-filter .filter-item").forEach((item) => {
                    item.classList.remove("active");
                    item.style.display = "none";
                });
                
                // Show matching filter item
                const targetFilter = document.querySelector(`.list-filter .filter-item[data-item="${targetItem}"]`);
                if (targetFilter) {
                    targetFilter.classList.add("active");
                    targetFilter.style.display = "block";
                }
            });
        });
    }
    
    // Initialize multiple times to ensure it works
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initTabSwitching();
            setTimeout(initTabSwitching, 100);
            setTimeout(initTabSwitching, 500);
        });
    } else {
        initTabSwitching();
        setTimeout(initTabSwitching, 100);
        setTimeout(initTabSwitching, 500);
    }
})();
</script>
@endsection
