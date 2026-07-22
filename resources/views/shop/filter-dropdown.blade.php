@extends('layouts.app')

@section('title', 'Shop Filter Dropdown - Perch Bottle')

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
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 active"> Shop Filter Dropdown </a>
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
                            <div class="item tab-item text-button-uppercase cursor-pointer has-line-before line-2px" data-item="t-shirt">t-shirt</div>
                            <div class="item tab-item text-button-uppercase cursor-pointer has-line-before line-2px" data-item="dress">dress</div>
                            <div class="item tab-item text-button-uppercase cursor-pointer has-line-before line-2px" data-item="top">top</div>
                            <div class="item tab-item text-button-uppercase cursor-pointer has-line-before line-2px" data-item="swimwear">swimwear</div>
                            <div class="item tab-item text-button-uppercase cursor-pointer has-line-before line-2px" data-item="shirt">shirt</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-product lg:py-20 md:py-14 py-10">
            <div class="container">
                <div class="list-product-block style-grid relative">
                    <div class="filter-heading flex items-center justify-between gap-5 flex-wrap">
                        <div class="left flex has-line items-center flex-wrap gap-5">
                            <div class="filter-sidebar-btn flex items-center gap-2 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 21V14" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4 10V3" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 21V12" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 8V3" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M20 21V16" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M20 12V3" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M1 14H7" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 8H15" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M17 16H23" stroke="#1F1F1F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Filters</span>
                            </div>
                            <div class="choose-layout menu-tab flex items-center gap-2">
                                <div class="item tab-item three-col p-2 border border-line rounded flex items-center justify-center cursor-pointer">
                                    <div class="flex items-center gap-0.5">
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                    </div>
                                </div>
                                <div class="item tab-item four-col p-2 border border-line rounded flex items-center justify-center cursor-pointer active">
                                    <div class="flex items-center gap-0.5">
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                    </div>
                                </div>
                                <div class="item tab-item five-col p-2 border border-line rounded flex items-center justify-center cursor-pointer">
                                    <div class="flex items-center gap-0.5">
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
                                        <span class="w-[3px] h-4 bg-secondary2 rounded-sm"></span>
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

                    <div class="sidebar style-dropdown bg-white grid md:grid-cols-4 grid-cols-2 md:gap-[30px] gap-6">
                        <div class="filter-type-block">
                            <div class="heading6">Products Type</div>
                            <div class="list-type filter-type menu-tab mt-4">
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="t-shirt">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">t-shirt</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="dress">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">dress</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="top">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">top</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="swimwear">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">swimwear</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="shirt">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">shirt</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="underwear">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">underwear</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="sets">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">sets</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                                <div class="item tab-item flex items-center justify-between cursor-pointer" data-item="accessories">
                                    <div class="type-name text-secondary has-line-before hover:text-black capitalize">accessories</div>
                                    <div class="text-secondary2 number">6</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="filter-size">
                                <div class="heading6">Size</div>
                                <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                                    <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line" data-item="XS">XS</div>
                                    <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line" data-item="S">S</div>
                                    <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line" data-item="M">M</div>
                                    <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line" data-item="L">L</div>
                                    <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line" data-item="XL">XL</div>
                                    <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line" data-item="2XL">2XL</div>
                                    <div class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line" data-item="freesize">Freesize</div>
                                </div>
                            </div>
                            <div class="filter-price mt-8">
                                <div class="heading6">Price Range</div>
                                <div class="tow-bar-block mt-5">
                                    <div class="progress"></div>
                                </div>
                                <div class="range-input">
                                    <input class="range-min" type="range" min="0" max="300" value="0" />
                                    <input class="range-max" type="range" min="0" max="300" value="300" />
                                </div>
                                <div class="price-block flex items-center justify-between flex-wrap mt-4">
                                    <div class="min flex items-center gap-1">
                                        <div>Min price:</div>
                                        <div class="min-price">$0</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Max price:</div>
                                        <div class="max-price">$300</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-color">
                            <div class="heading6">colors</div>
                            <div class="list-color flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="pink">
                                    <div class="color bg-[#F4C5BF] w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">pink</div>
                                </div>
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="red">
                                    <div class="color bg-red w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">red</div>
                                </div>
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="green">
                                    <div class="color bg-green w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">green</div>
                                </div>
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="yellow">
                                    <div class="color bg-yellow w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">yellow</div>
                                </div>
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="purple">
                                    <div class="color bg-purple w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">purple</div>
                                </div>
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="black">
                                    <div class="color bg-black w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">black</div>
                                </div>
                                <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line" data-item="white">
                                    <div class="color bg-[#F6EFDD] w-5 h-5 rounded-full"></div>
                                    <div class="caption1 capitalize">white</div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-brand">
                            <div class="heading6">Brands</div>
                            <div class="list-brand mt-4">
                                <div class="brand-item flex items-center justify-between" data-item="adidas">
                                    <div class="left flex items-center cursor-pointer">
                                        <div class="block-input">
                                            <input type="checkbox" name="adidas" id="adidas" />
                                            <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                        </div>
                                        <label for="adidas" class="brand-name capitalize pl-2 cursor-pointer">adidas</label>
                                    </div>
                                    <div class="text-secondary2 number">12</div>
                                </div>
                                <div class="brand-item flex items-center justify-between" data-item="hermes">
                                    <div class="left flex items-center cursor-pointer">
                                        <div class="block-input">
                                            <input type="checkbox" name="hermes" id="hermes" />
                                            <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                        </div>
                                        <label for="hermes" class="brand-name capitalize pl-2 cursor-pointer">hermes</label>
                                    </div>
                                    <div class="text-secondary2 number">12</div>
                                </div>
                                <div class="brand-item flex items-center justify-between" data-item="zara">
                                    <div class="left flex items-center cursor-pointer">
                                        <div class="block-input">
                                            <input type="checkbox" name="zara" id="zara" />
                                            <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                        </div>
                                        <label for="zara" class="brand-name capitalize pl-2 cursor-pointer">zara</label>
                                    </div>
                                    <div class="text-secondary2 number">12</div>
                                </div>
                                <div class="brand-item flex items-center justify-between" data-item="nike">
                                    <div class="left flex items-center cursor-pointer">
                                        <div class="block-input">
                                            <input type="checkbox" name="nike" id="nike" />
                                            <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                        </div>
                                        <label for="nike" class="brand-name capitalize pl-2 cursor-pointer">nike</label>
                                    </div>
                                    <div class="text-secondary2 number">12</div>
                                </div>
                                <div class="brand-item flex items-center justify-between" data-item="gucci">
                                    <div class="left flex items-center cursor-pointer">
                                        <div class="block-input">
                                            <input type="checkbox" name="gucci" id="gucci" />
                                            <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                        </div>
                                        <label for="gucci" class="brand-name capitalize pl-2 cursor-pointer">gucci</label>
                                    </div>
                                    <div class="text-secondary2 number">12</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="list-filtered flex items-center gap-3 flex-wrap"></div>

                    <div class="list-product hide-product-sold grid sm:grid-cols-3 grid-cols-2 sm:gap-[30px] gap-[20px] mt-7" data-item="12"></div>

                    <div class="list-pagination w-full flex items-center justify-center gap-4 mt-10"></div>
                </div>
            </div>
        </div>
@endsection
