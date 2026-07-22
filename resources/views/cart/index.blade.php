@extends('layouts.app')

@section('title', 'Cart - Perch Bottle')

@section('content')
<style>
    /* Cart - compact breadcrumb, reduce gap */
    .cart-page-content .cart-breadcrumb { min-height: unset !important; }
    .cart-page-content .cart-breadcrumb .breadcrumb-main { min-height: unset !important; }
</style>
<div class="page-content cart-page-content">
    <!-- Menu bar (mobile) -->
    <!-- Compact breadcrumb - minimal gap -->
    <div class="breadcrumb-block cart-breadcrumb">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container py-4 relative">
                <div class="main-content w-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">Shopping Cart</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-1">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2 capitalize">Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-block md:py-6 py-4">
            <div class="container">
                <div class="content-main flex justify-between max-xl:flex-col gap-y-8">
                    <div class="xl:w-2/3 xl:pr-3 w-full">
                        <!-- <div class="time countdown-cart bg-green py-3 px-5 flex items-center rounded-lg">
                            <div class="heding5">🔥</div>
                            <div class="caption1 pl-2">
                                Your cart will expire in
                                <span class="min text-red text-button fw-700"><span class="minute">10</span> : <span class="second">00</span></span>
                                <span> minutes! Please checkout now before your items sell out!</span>
                            </div>
                        </div> -->
                        <!-- <div class="heading banner mt-5">
                            <div class="text">
                                Buy
                                <span class="text-button"> ₹<span class="more-price">250</span>.00 </span>
                                <span>more to get </span>
                                <span class="text-button">freeship</span>
                            </div>
                            <div class="tow-bar-block mt-4">
                                <div class="progress-line" style="width: 50%"></div>
                            </div>
                        </div> -->
                        <div class="list-product w-full sm:mt-7 mt-5">
                            <div class="w-full">
                                <div class="heading bg-surface bora-4 pt-4 pb-4">
                                    <div class="flex">
                                        <div class="w-2/5">
                                            <div class="text-button text-center">Products</div>
                                        </div>
                                        <div class="w-1/12">
                                            <div class="text-button text-center">Price</div>
                                        </div>
                                        <div class="w-1/6">
                                            <div class="text-button text-center">Quantity</div>
                                        </div>
                                        <div class="w-1/6">
                                            <div class="text-button text-center">Total Price</div>
                                        </div>
                                        <div class="w-1/12">
                                            <div class="text-button text-center">Action</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-product-main w-full mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-1/3 xl:pl-12 w-full">
                        <div class="checkout-block bg-surface p-6 rounded-2xl">
                            <div class="heading5">Order Summary</div>
                            <div class="total-block py-5 flex justify-between border-b border-line">
                                <div class="text-title">Subtotal</div>
                                <div class="text-title">₹<span class="total-product">136</span><span>.00</span></div>
                            </div>
                            <div class="ship-block py-5 border-b border-line">
                                <div class="text-title mb-3">Shipping</div>
                                <div class="pincode-shipping flex flex-col gap-3">
                                    <div class="flex gap-2">
                                        <input type="text" id="cart-pincode" class="border border-line px-4 py-2.5 rounded-lg w-full max-w-[140px]" placeholder="Enter pincode" maxlength="6" pattern="[0-9]*" inputmode="numeric" />
                                        <button type="button" id="cart-check-shipping" class="button-main px-4 py-2.5 bg-black text-white rounded-lg text-sm font-semibold whitespace-nowrap cursor-pointer">Check</button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="caption1 text-secondary2" id="cart-shipping-label">Enter pincode to calculate</span>
                                        <span class="text-title font-semibold" id="cart-shipping-charge">₹0.00</span>
                                    </div>
                                    <div id="cart-delivery-estimate" class="caption1 text-green-600 hidden"></div>
                                    <div id="cart-shipping-error" class="caption1 text-red-600 hidden"></div>
                                </div>
                            </div>
                            <div class="total-cart-block pt-4 pb-4 flex justify-between">
                                <div class="heading5">Total</div>
                                <div class=""><span class="heading5">₹</span><span class="total-cart heading5">116</span><span class="heading5">.00</span></div>
                            </div>
                            <div class="block-button flex flex-col items-center gap-y-4 mt-5">
                                <form action="{{ route('checkout.index') }}" method="GET" id="checkout-form" style="width: 100%; margin: 0;">
                                    <button type="submit" class="checkout-btn button-main w-full text-center py-3 px-5 bg-black text-white hover:bg-gray-800 rounded-lg transition-colors duration-300 uppercase tracking-wider cursor-pointer" id="checkout-link">Process To Checkout</button>
                                </form>
                                <a id="continue-shopping-link" class="text-button hover-underline block text-center" href="{{ route('shop') }}">Continue shopping </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var link = document.getElementById('continue-shopping-link');
    if (link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = '{{ route("shop") }}';
            return false;
        }, true);
    }
});
</script>
@endpush

@endsection
