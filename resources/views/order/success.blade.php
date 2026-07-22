@extends('layouts.app')

@section('title', 'Order Success - Perch Bottle')

@section('content')
<div class="order-success-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white border border-line rounded-2xl p-8 md:p-12 text-center">
                <div class="success-icon mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <i class="ph ph-check-circle text-5xl text-green-600"></i>
                    </div>
                </div>
                
                <h1 class="heading2 md:heading1 mb-4">Order Placed Successfully!</h1>
                <p class="body1 text-secondary mb-8">
                    Thank you for your order. We've received your order and will begin processing it right away.
                </p>
                
                @php
                    $totalAmount = $order->total_amount ?? $order->total ?? 0;
                    $subtotal = $order->subtotal ?? ($order->items->sum('total') ?: $totalAmount);
                    $shippingCharge = $order->shipping_charge ?? $order->shipping ?? 0;
                    $couponDiscount = $order->coupon_discount ?? 0;
                @endphp
                <div class="order-details bg-gray-50 rounded-xl p-6 mb-8 text-left">
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <div class="caption1 text-secondary mb-1">Order Number</div>
                            <div class="body1 font-semibold">{{ $order->order_number }}</div>
                        </div>
                        <div>
                            <div class="caption1 text-secondary mb-1">Order Date</div>
                            <div class="body1 font-semibold">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="caption1 text-secondary mb-1">Payment Method</div>
                            <div class="body1 font-semibold capitalize">{{ $order->payment_method }}</div>
                        </div>
                        <div>
                            <div class="caption1 text-secondary mb-1">Total Amount</div>
                            <div class="body1 font-semibold">₹{{ number_format((float) $totalAmount, 2) }}</div>
                        </div>
                    </div>
                    <div class="border-t border-line pt-4 mt-4">
                        <div class="caption1 text-secondary mb-2">Amount breakdown</div>
                        <div class="space-y-1 body2">
                            <div class="flex justify-between"><span>Subtotal</span><span>₹{{ number_format((float) $subtotal, 2) }}</span></div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span>{{ $shippingCharge > 0 ? '₹' . number_format((float) $shippingCharge, 2) : 'Free' }}</span>
                            </div>
                            @if(isset($codCharge) && $codCharge > 0)
                                <div class="flex justify-between">
                                    <span>COD Charges</span>
                                    <span>₹{{ number_format((float) $codCharge, 2) }}</span>
                                </div>
                            @endif
                            @if($couponDiscount > 0)
                                <div class="flex justify-between text-green-600"><span>Discount</span><span>-₹{{ number_format((float) $couponDiscount, 2) }}</span></div>
                            @endif
                            <div class="flex justify-between font-semibold pt-2 border-t border-line"><span>Total</span><span>₹{{ number_format((float) $totalAmount, 2) }}</span></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{{ route('home') }}}" class="button-main">
                        Continue Shopping
                    </a>
                    @if(auth()->check())
                        <a href="{{ route('account.orders.show', $order->id) }}" class="button-secondary">
                            View Order Details
                        </a>
                    @else
                        <a href="/order/track?order_number={{ $order->order_number }}&email={{ $order->customer_email }}" class="button-secondary">
                            Track Order
                        </a>
                    @endif
                </div>
                
                <div class="mt-8 pt-8 border-t border-line">
                    <p class="caption1 text-secondary">
                        A confirmation email has been sent to 
                        <span class="font-semibold text-black">{{ $order->customer_email ?? $order->user->email ?? 'your email' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

