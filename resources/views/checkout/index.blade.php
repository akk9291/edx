@extends('layouts.app')

@section('title', 'Checkout - Perch Bottle')

@section('content')
<style>
    /* Checkout - compact breadcrumb, reduce gap */
    .checkout-page-content .checkout-breadcrumb { min-height: unset !important; }
    .checkout-page-content .checkout-breadcrumb .breadcrumb-main { min-height: unset !important; }
    
    /* Payment Section Styling */
    .payment-card {
        transition: all 0.3s ease;
    }
    
    .payment-card:hover {
        border-color: #000;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .payment-method-card:hover {
        background-color: #f9fafb;
        transform: translateY(-1px);
    }
    
    /* Payment Button Container */
    #payment-button-container {
        transition: all 0.3s ease;
    }
    
    /* Payment Button Styling */
    #place-order-btn {
        position: relative !important;
        z-index: 10 !important;
        transform: none !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    }
    
    #place-order-btn:not(:disabled) {
        background: linear-gradient(135deg, #000 0%, #333 100%) !important;
        cursor: pointer !important;
    }
    
    #place-order-btn:not(:disabled):hover {
        background: linear-gradient(135deg, #333 0%, #000 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important;
    }
    
    #place-order-btn:disabled {
        background-color: #9ca3af !important;
        cursor: not-allowed !important;
    }
    
    /* Button text visibility */
    #place-order-btn span, #place-order-btn i {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        color: white !important;
    }
    
    /* Payment section disabled state */
    #payment-section[style*="opacity: 0.5"] {
        filter: grayscale(0.5);
    }
    
    #payment-section[style*="opacity: 1"] {
        filter: none;
        border-color: #000 !important;
    }
</style>
<div class="page-content checkout-page-content">
    <!-- Menu bar (mobile) -->
    <!-- Compact breadcrumb - minimal gap -->
    <div class="breadcrumb-block checkout-breadcrumb">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container py-4 relative">
                <div class="main-content w-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">Checkout</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-1">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2 capitalize">Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-block md:py-6 py-4">
            <div class="container">
                <div class="content-main flex max-lg:flex-col-reverse gap-y-10 justify-between">
                    <div class="left lg:w-1/2">
                        <div class="login bg-surface py-3 px-4 flex justify-between rounded-lg">
                            @auth
                                <div class="left flex items-center"><span class="text-on-surface-variant1">You're already logged in with {{ auth()->user()->email }}</span></div>
                            @else
                                <div class="left flex items-center"><span class="text-on-surface-variant1 pr-4">Already have an account? </span><a href="{{ route('login') }}?redirect={{ urlencode(route('checkout.index')) }}" class="text-button text-on-surface hover:underline cursor-pointer">Login</a></div>
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout.index')) }}" class="right flex items-center"><i class="ph ph-caret-right fs-20 cursor-pointer"></i></a>
                            @endauth
                        </div>
                        <div class="form-login-block mt-3">
                            <form class="p-5 border border-line rounded-lg">
                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div class="email">
                                        <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="username" type="email" placeholder="Username or email" required />
                                    </div>
                                    <div class="pass">
                                        <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="password" type="password" placeholder="Password" required />
                                    </div>
                                </div>
                                <div class="block-button mt-3">
                                    <button class="button-main button-blue-hover">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="information mt-5">
                            <div class="heading5">Information</div>
                            @if(auth()->check() && $addresses && $addresses->count() > 0)
                                <div class="mt-4 mb-4">
                                    <label class="caption1 capitalize mb-2 block">Select Saved Address:</label>
                                    <div class="select-block">
                                        <select class="border border-line px-4 py-3 w-full rounded-lg" id="savedAddressSelect" onchange="fillAddressFromSaved(this.value)">
                                            <option value="">Use New Address</option>
                                            @foreach($addresses as $address)
                                                <option value="{{ $address->id }}" data-address='@json($address)' {{ $address->is_default ? 'selected' : '' }}>
                                                    {{ $address->label ?? 'Address' }} - {{ $address->address_line_1 }}, {{ $address->city }}
                                                    @if($address->is_default) (Default) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="ph ph-caret-down arrow-down"></i>
                                    </div>
                                    <input type="hidden" id="selectedAddressId" name="shipping_address_id" value="{{ $defaultAddress->id ?? '' }}">
                                </div>
                            @endif
                            <div class="form-checkout mt-5">
                                <form onsubmit="return false;" id="checkout-form-element">
                                    <div class="grid sm:grid-cols-2 gap-4 gap-y-5 flex-wrap">
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="firstName" type="text" placeholder="First Name *" value="{{ $userFirstName ?? ($defaultAddress ? explode(' ', $defaultAddress->full_name)[0] : '') }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="lastName" type="text" placeholder="Last Name *" value="{{ $userLastName ?? ($defaultAddress ? (explode(' ', $defaultAddress->full_name)[1] ?? '') : '') }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="email" type="email" placeholder="Email Address *" value="{{ $user->email ?? '' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="phoneNumber" type="tel" placeholder="Phone Number *" value="{{ $user->phone ?? ($defaultAddress->phone ?? '') }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="region" name="region" type="text" placeholder="Country *" value="{{ $defaultAddress->country ?? 'India' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="city" type="text" placeholder="Town/City *" value="{{ $defaultAddress->city ?? '' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="apartment" type="text" placeholder="Street *" value="{{ $defaultAddress->address_line_1 ?? '' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="country" name="country" type="text" placeholder="State *" value="{{ $defaultAddress->state ?? '' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="postal" type="text" placeholder="Postal Code *" value="{{ $defaultAddress->pincode ?? '' }}" required />
                                        </div>
                                        <div class="col-span-full">
                                            <textarea class="border border-line px-4 py-3 w-full rounded-lg" id="note" name="note" placeholder="Write note..."></textarea>
                                        </div>
                                    </div>
                                    <div class="payment-block md:mt-10 mt-6">
                                        <div class="heading5 mb-6">Payment Method</div>
                                        <div class="list-payment">
                                            <!-- Razorpay Online Payment - Theme Based Design -->
                                            <div class="payment-card bg-white border-2 border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300" id="payment-section" style="opacity: 0.5; pointer-events: none;">
                                                <input type="hidden" name="payment" value="razorpay" />
                                                
                                                <!-- Header -->
                                                <div class="p-6 border-b border-gray-100">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-4">
                                                            <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                                                                <i class="ph ph-credit-card text-white text-xl"></i>
                                                            </div>
                                                            <div>
                                                                <h3 class="font-bold text-lg text-gray-900">Pay Online</h3>
                                                                <p class="text-sm text-gray-500">Secure & Instant Payment</p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center gap-2 bg-green-50 px-3 py-1 rounded-full">
                                                            <i class="ph ph-shield-check text-green-600"></i>
                                                            <span class="text-xs font-semibold text-green-700">SECURED</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Content -->
                                                <div class="p-6">
                                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                                        Pay securely using Credit Card, Debit Card, Net Banking, UPI (GPay/PhonePe/Paytm), or Digital Wallets.
                                                    </p>
                                                    
                                                    <!-- Payment Methods Grid -->
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                                        <div class="payment-method-card p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors text-center">
                                                            <i class="ph ph-credit-card text-2xl text-gray-700 mb-2 block"></i>
                                                            <span class="text-xs font-medium text-gray-700">Cards</span>
                                                        </div>
                                                        <div class="payment-method-card p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors text-center">
                                                            <i class="ph ph-bank text-2xl text-gray-700 mb-2 block"></i>
                                                            <span class="text-xs font-medium text-gray-700">Net Banking</span>
                                                        </div>
                                                        <div class="payment-method-card p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors text-center">
                                                            <i class="ph ph-device-mobile text-2xl text-gray-700 mb-2 block"></i>
                                                            <span class="text-xs font-medium text-gray-700">UPI</span>
                                                        </div>
                                                        <div class="payment-method-card p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-black transition-colors text-center">
                                                            <i class="ph ph-wallet text-2xl text-gray-700 mb-2 block"></i>
                                                            <span class="text-xs font-medium text-gray-700">Wallets</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Razorpay Branding -->
                                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border">
                                                        <div class="flex items-center gap-3">
                                                            <img src="https://cdn.razorpay.com/static/assets/logo/payment.svg" alt="Razorpay" class="h-8">
                                                            <span class="text-sm font-medium text-gray-600">Powered by Razorpay</span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <i class="ph ph-lock text-gray-500"></i>
                                                            <span class="text-xs text-gray-500">SSL Encrypted</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Footer -->
                                                <div class="px-6 pb-6">
                                                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
                                                        <i class="ph ph-truck text-blue-600"></i>
                                                        <span>Delivery charges calculated based on your pincode</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Payment Availability Message -->
                                            <div id="payment-message" class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                                                <div class="flex items-start gap-3">
                                                    <i class="ph ph-info text-amber-600 text-lg mt-0.5"></i>
                                                    <div class="flex-1">
                                                        <h4 class="font-medium text-amber-800 mb-2">Complete Your Address</h4>
                                                        <p class="text-sm text-amber-700 mb-3">Please fill your complete address and enter pincode to calculate delivery charges before payment.</p>
                                                        
                                                        <!-- Progress Steps -->
                                                        <div class="space-y-2">
                                                            <div class="flex items-center gap-2 text-sm" id="step-address">
                                                                <i class="ph ph-circle text-amber-600"></i>
                                                                <span class="text-amber-700">Fill complete address details</span>
                                                            </div>
                                                            <div class="flex items-center gap-2 text-sm" id="step-pincode">
                                                                <i class="ph ph-circle text-amber-600"></i>
                                                                <span class="text-amber-700">Enter 6-digit pincode</span>
                                                            </div>
                                                            <div class="flex items-center gap-2 text-sm" id="step-delivery">
                                                                <i class="ph ph-circle text-amber-600"></i>
                                                                <span class="text-amber-700">Calculate delivery charges</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-button md:mt-10 mt-6" id="payment-button-container" style="display: none;">
                                        <button type="button" class="payment-button w-full py-4 px-6 bg-gray-400 text-white rounded-xl font-bold text-lg cursor-not-allowed border-none outline-none transition-all duration-300" id="place-order-btn" disabled onclick="console.log('Button clicked via inline'); if(typeof window.handleOrderSubmission === 'function'){window.handleOrderSubmission(event);}else{console.error('handleOrderSubmission not available');} return false;">
                                            <div class="flex items-center justify-center gap-4">
                                                <i class="ph ph-credit-card text-xl" id="btn-icon"></i>
                                                <div class="flex flex-col items-center">
                                                    <span id="btn-text" class="font-bold text-base">Pay Securely</span>
                                                    <span id="btn-amount" class="font-bold text-sm opacity-90 mt-1">₹0.00</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="right lg:w-5/12">
                        <div class="checkout-block">
                            <div class="heading5 pb-3">Your Order</div>
                            <div class="list-product-checkout"></div>
                            <div class="ship-block py-5 flex justify-between border-b border-line">
                                <div class="text-title">Shipping</div>
                                <div class="text-title shipping-charge">₹0.00</div>
                            </div>
                            <div class="delivery-estimate py-3 flex justify-between border-b border-line" style="display: none;">
                                <div class="text-secondary">Estimated Delivery</div>
                                <div class="text-secondary estimated-delivery">-</div>
                            </div>
                            <div class="total-cart-block pt-5 flex justify-between">
                                <div class="heading5">Total</div>
                                <div class="heading5 total-cart">₹0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- OTP Verification Modal -->
<div id="otp-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6 relative">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ph ph-device-mobile text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Verify Your Mobile Number</h3>
            <p class="text-gray-600">We've sent a 6-digit OTP to</p>
            <p class="font-semibold text-gray-900" id="otp-mobile-display">+91 XXXXXXXXXX</p>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Enter OTP</label>
            <input type="text" id="otp-input" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center text-lg font-mono tracking-widest" placeholder="000000" maxlength="6">
            <div id="otp-error" class="text-red-600 text-sm mt-2 hidden"></div>
        </div>
        
        <div class="flex gap-3 mb-4">
            <button type="button" id="verify-otp-btn" class="flex-1 bg-black text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                Verify OTP
            </button>
            <button type="button" id="resend-otp-btn" class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors disabled:opacity-50" disabled>
                Resend
            </button>
        </div>
        
        <div class="text-center">
            <button type="button" id="close-otp-modal" class="text-gray-500 hover:text-gray-700">
                Cancel
            </button>
        </div>
        
        <div id="otp-timer" class="text-center text-sm text-gray-500 mt-4">
            Resend OTP in <span id="timer-count">60</span> seconds
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
// Define functions IMMEDIATELY - NO IIFE, execute directly
// Function to validate form
function validateForm() {
        const errors = [];
        
        const firstName = document.getElementById('firstName')?.value.trim();
        const lastName = document.getElementById('lastName')?.value.trim();
        const email = document.getElementById('email')?.value.trim();
        const phone = document.getElementById('phoneNumber')?.value.trim();
        const city = document.getElementById('city')?.value.trim();
        const address = document.getElementById('apartment')?.value.trim();
        const state = document.getElementById('country')?.value;
        const pincode = document.getElementById('postal')?.value.trim();
        
        if (!firstName) errors.push('First Name is required');
        if (!lastName) errors.push('Last Name is required');
        if (!email) {
            errors.push('Email is required');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.push('Please enter a valid email address');
        }
        if (!phone) errors.push('Phone Number is required');
        if (!city) errors.push('City is required');
        if (!address) errors.push('Address is required');
        if (!state || state === 'default') errors.push('Please select a State');
        if (!pincode) errors.push('Postal Code is required');
        
        return errors;
    }
    
    // Function to show error popup
    function showErrorPopup(errors) {
        const errorMessage = errors.join('\n');
        alert('Please fix the following errors:\n\n' + errorMessage);
    }
    
    // Function to handle order submission
    function handleOrderSubmission(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    }
    
    console.log('handleOrderSubmission called');
    console.log('Current variables:', {
        cartSubtotal: window.cartSubtotal || cartSubtotal,
        currentShippingCharge: window.currentShippingCharge || currentShippingCharge
    });

    const submitBtn = document.getElementById('place-order-btn');
    if (!submitBtn) {
        console.error('Place Order button not found');
        alert('Place Order button not found. Please refresh the page.');
        return false;
    }
    
    // Validate form
    const validationErrors = validateForm();
    if (validationErrors.length > 0) {
        showErrorPopup(validationErrors);
        return false;
    }
    
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Placing Order...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = {
        first_name: document.getElementById('firstName').value.trim(),
        last_name: document.getElementById('lastName').value.trim(),
        email: document.getElementById('email').value.trim(),
        phone: document.getElementById('phoneNumber').value.trim(),
        region: document.getElementById('region').value,
        city: document.getElementById('city').value.trim(),
        address: document.getElementById('apartment').value.trim(),
        state: document.getElementById('country').value,
        pincode: document.getElementById('postal').value.trim(),
        notes: document.getElementById('note')?.value.trim() || '',
        payment_method: 'razorpay'
    };
    
    // Get shipping cost from the calculated shipping charge
    let shipping = currentShippingCharge || 0;
    
    // No COD charges - only online payment
    let codCharge = 0;
    
    // Discount removed from UI - use 0
    const discount = 0;
    
    // Check if user is logged in
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    
    // Get selected address ID if available
    const selectedAddressId = document.getElementById('selectedAddressId')?.value;
    
    // Prepare order data based on login status
    let orderData;
    if (isLoggedIn) {
        // For logged in users, use address_id if selected, otherwise send shipping_address
        if (selectedAddressId) {
            orderData = {
                shipping_address_id: selectedAddressId,
                payment_method: formData.payment_method,
                notes: formData.notes,
                shipping_charge: shipping,
                cod_charge: codCharge
            };
        } else {
            orderData = {
                shipping_address: {
                    first_name: formData.first_name,
                    last_name: formData.last_name,
                    email: formData.email,
                    phone: formData.phone,
                    address_line_1: formData.address,
                    city: formData.city,
                    state: formData.state,
                    pincode: formData.pincode
                },
                payment_method: formData.payment_method,
                notes: formData.notes,
                shipping_charge: shipping,
                cod_charge: codCharge
            };
        }
    } else {
        // For guests, send guest_info - ensure all fields are present
        orderData = {
            guest_info: {
                first_name: formData.first_name || '',
                last_name: formData.last_name || '',
                email: formData.email || '',
                phone: formData.phone || '',
                address: formData.address || '',
                city: formData.city || '',
                state: formData.state || '',
                pincode: formData.pincode || ''
            },
            payment_method: formData.payment_method || 'test',
            notes: formData.notes || '',
            shipping_charge: shipping || 0,
            cod_charge: codCharge
        };
        
        console.log('Guest order data:', orderData);
    }
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Log the data being sent
    console.log('Order data being sent:', orderData);
    console.log('Form data collected:', formData);
    
    // Handle Razorpay payment
    if (formData.payment_method === 'razorpay') {
        handleRazorpayPayment(orderData);
        return;
    }
    
    // Submit order (web route uses session auth so logged-in user is recognized)
    fetch('/place-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify(orderData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => {
                console.error('API Error:', err);
                // Show validation errors in a better format
                let errorMessage = err.message || 'Failed to place order';
                if (err.errors) {
                    const errorList = Object.values(err.errors).flat().join('\n');
                    errorMessage = errorMessage + '\n\n' + errorList;
                }
                throw new Error(errorMessage);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Order response:', data);
        
        if (data.success && data.data && data.data.id) {
            // Redirect to order success page
            console.log('Redirecting to order success page:', `/order-success/${data.data.id}`);
            window.location.href = `/order-success/${data.data.id}`;
        } else {
            throw new Error(data.message || 'Failed to place order. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error placing order:', error);
        alert(error.message || 'An error occurred. Please try again.');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Make functions globally available IMMEDIATELY
window.handleOrderSubmission = handleOrderSubmission;
window.validateForm = validateForm;
window.showErrorPopup = showErrorPopup;

console.log('Functions defined and made global:', {
    handleOrderSubmission: typeof window.handleOrderSubmission,
    validateForm: typeof window.validateForm,
    showErrorPopup: typeof window.showErrorPopup
});

// Test if button exists immediately
console.log('Testing button existence...');
const testBtn = document.getElementById('place-order-btn');
console.log('Button found:', testBtn);
if (testBtn) {
    console.log('Button exists, setting up immediate handler');
    testBtn.onclick = function(e) {
        console.log('Button clicked via immediate handler!');
        e.preventDefault();
        e.stopPropagation();
        if (window.handleOrderSubmission) {
            window.handleOrderSubmission(e);
        } else {
            console.error('handleOrderSubmission not available');
        }
        return false;
    };
}

// IIFE for initialization
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    function initCheckout() {
        console.log('Initializing checkout form...');
        
        // Style Place Order button but keep it hidden initially
        const placeOrderBtn = document.getElementById('place-order-btn');
        const paymentButtonContainer = document.getElementById('payment-button-container');
        
        if (placeOrderBtn) {
            placeOrderBtn.style.background = 'linear-gradient(135deg, #000 0%, #333 100%)';
            placeOrderBtn.style.color = 'white';
            placeOrderBtn.style.border = 'none';
            placeOrderBtn.style.outline = 'none';
            placeOrderBtn.style.borderRadius = '12px';
            placeOrderBtn.style.boxShadow = '0 4px 14px rgba(0,0,0,0.1)';
            console.log('Place Order button found and styled');
        } else {
            console.error('Place Order button not found!');
        }
        
        // Keep payment button hidden initially
        if (paymentButtonContainer) {
            paymentButtonContainer.style.display = 'none';
            console.log('Payment button container hidden initially');
        }
        
        // Handle checkout form submission
        const checkoutForm = document.querySelector('.form-checkout form');
        const submitBtn = document.getElementById('place-order-btn');
        
        console.log('Checkout form:', checkoutForm);
        console.log('Submit button:', submitBtn);
        
        // Handle button click - use direct onclick to ensure it works
        if (submitBtn) {
            console.log('Setting up button click handler for:', submitBtn);
            console.log('handleOrderSubmission available:', typeof window.handleOrderSubmission);
            
            // Remove any existing onclick
            submitBtn.onclick = null;
            
            // Set up new click handler using direct onclick
            submitBtn.onclick = function(e) {
                console.log('Button clicked! Event:', e);
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }
                
                if (window.handleOrderSubmission) {
                    console.log('Calling handleOrderSubmission');
                    window.handleOrderSubmission(e);
                } else {
                    console.error('handleOrderSubmission not available');
                    alert('Please wait for page to load completely');
                }
                return false;
            };
            
            // Also add event listener as backup
            submitBtn.addEventListener('click', function(e) {
                console.log('Button clicked via addEventListener!');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                if (window.handleOrderSubmission) {
                    window.handleOrderSubmission(e);
                }
                return false;
            }, true);
            
            console.log('Button click handler set up successfully');
        } else {
            console.error('Place Order button not found in initCheckout!');
        }
        
        // Handle form submit
        if (checkoutForm && window.handleOrderSubmission) {
            console.log('Setting up form submit handler');
            checkoutForm.addEventListener('submit', function(e) {
                console.log('Form submit triggered!');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                window.handleOrderSubmission(e);
                return false;
            }, true);
        }
    }
    
    // Initialize immediately and multiple times to ensure it works
    console.log('Initializing checkout handlers...');
    console.log('Document ready state:', document.readyState);
    console.log('handleOrderSubmission available:', typeof window.handleOrderSubmission);
    
    // Try immediately
    initCheckout();
    
    // Also try when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded fired');
            initCheckout();
        });
    }
    
    // Try after short delays
    // Function to fill address form from saved address
    window.fillAddressFromSaved = function(addressId) {
        const selectElement = document.getElementById('savedAddressSelect');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
        if (!addressId || !selectedOption || !selectedOption.dataset.address) {
            // Clear address ID if "Use New Address" is selected
            document.getElementById('selectedAddressId').value = '';
            return;
        }
        
        try {
            const address = JSON.parse(selectedOption.dataset.address);
            
            // Set the address ID
            document.getElementById('selectedAddressId').value = addressId;
            
            // Split full name into first and last name
            const nameParts = (address.full_name || '').split(' ', 2);
            const firstName = nameParts[0] || '';
            const lastName = nameParts[1] || '';
            
            // Fill form fields
            if (document.getElementById('firstName')) {
                document.getElementById('firstName').value = firstName;
            }
            if (document.getElementById('lastName')) {
                document.getElementById('lastName').value = lastName;
            }
            if (document.getElementById('phoneNumber')) {
                document.getElementById('phoneNumber').value = address.phone || '';
            }
            if (document.getElementById('city')) {
                document.getElementById('city').value = address.city || '';
            }
            if (document.getElementById('apartment')) {
                document.getElementById('apartment').value = address.address_line_1 || '';
            }
            if (document.getElementById('postal')) {
                document.getElementById('postal').value = address.pincode || '';
            }
            
            // Set state/country dropdowns
            const stateValue = address.state || '';
            const countrySelect = document.getElementById('country');
            const regionSelect = document.getElementById('region');
            
            if (countrySelect && stateValue) {
                for (let option of countrySelect.options) {
                    if (option.value === stateValue || option.text.includes(stateValue)) {
                        countrySelect.value = option.value;
                        break;
                    }
                }
            }
            
            if (regionSelect && stateValue) {
                for (let option of regionSelect.options) {
                    if (option.value === stateValue || option.text.includes(stateValue)) {
                        regionSelect.value = option.value;
                        break;
                    }
                }
            }
        } catch (error) {
            console.error('Error parsing address data:', error);
        }
    };
    
    // On load: fill form from pre-selected saved address (ensures phone is fetched)
    function tryFillSavedAddressOnLoad() {
        var sel = document.getElementById('savedAddressSelect');
        if (sel && sel.value && window.fillAddressFromSaved) {
            window.fillAddressFromSaved(sel.value);
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', tryFillSavedAddressOnLoad);
    } else {
        tryFillSavedAddressOnLoad();
    }
    setTimeout(tryFillSavedAddressOnLoad, 150);
    
    setTimeout(function() {
        console.log('Timeout 100ms - initializing');
        initCheckout();
    }, 100);
    
    setTimeout(function() {
        console.log('Timeout 500ms - initializing');
        initCheckout();
    }, 500);
    
    setTimeout(function() {
        console.log('Timeout 1000ms - initializing');
        initCheckout();
    }, 1000);
    
    // Also try on window load
    window.addEventListener('load', function() {
        console.log('Window load fired');
        setTimeout(function() {
            initCheckout();
        }, 100);
    });

    // Global variables to track cart and shipping
    let cartSubtotal = 0;
    let currentShippingCharge = 0;
    let isAddressComplete = false;
    let isDeliveryCalculated = false;
    let isMobileVerified = false;
    let currentMobile = '';
    
    // Ensure variables are globally accessible
    window.cartSubtotal = cartSubtotal;
    window.currentShippingCharge = currentShippingCharge;

    // Initialize cart subtotal from loaded cart items
    function initializeCartSubtotal() {
        // Get cart subtotal from API or calculate from loaded items
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const items = data.data.items || data.data || [];
                cartSubtotal = 0;
                items.forEach(item => {
                    const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
                    cartSubtotal += price * item.quantity;
                });
                
                // Update global variables
                window.cartSubtotal = cartSubtotal;
                window.currentShippingCharge = currentShippingCharge;
                
                updateTotalDisplay();
                if (typeof window.loadCheckoutCartItems === 'function') {
                    window.loadCheckoutCartItems();
                }
                
                // Initialize payment button for Razorpay
                setTimeout(() => {
                    const finalTotal = (window.cartSubtotal || cartSubtotal || 0) + (window.currentShippingCharge || currentShippingCharge || 0);
                    updatePaymentButton('razorpay', finalTotal);
                    
                    // Ensure button elements are visible
                    const btnText = document.getElementById('btn-text');
                    const btnAmount = document.getElementById('btn-amount');
                    const btnIcon = document.getElementById('btn-icon');
                    
                    if (btnText) {
                        btnText.style.display = 'inline-block';
                        btnText.style.visibility = 'visible';
                        btnText.style.opacity = '1';
                        btnText.textContent = 'Pay Securely';
                    }
                    
                    if (btnAmount) {
                        btnAmount.style.display = 'inline-block';
                        btnAmount.style.visibility = 'visible';
                        btnAmount.style.opacity = '1';
                        btnAmount.textContent = '₹' + finalTotal.toFixed(2);
                    }
                    
                    if (btnIcon) {
                        btnIcon.style.display = 'inline-block';
                        btnIcon.style.visibility = 'visible';
                        btnIcon.style.opacity = '1';
                    }
                    
                    console.log('Button initialized with total:', finalTotal);
                }, 100);
            }
        })
        .catch(error => {
            console.error('Error loading cart:', error);
        });
    }

    // Update total display
    function updateTotalDisplay() {
        const totalElement = document.querySelector('.total-cart');
        const finalTotal = (window.cartSubtotal || cartSubtotal || 0) + (window.currentShippingCharge || currentShippingCharge || 0); // No COD charges
        
        if (totalElement) {
            totalElement.textContent = '₹' + finalTotal.toFixed(2);
        }
        
        // Update button text and amount for Razorpay only
        updatePaymentButton('razorpay', finalTotal);
        
        console.log('Total display updated:', finalTotal);
    }

    // Check if address is complete
    function checkAddressCompletion() {
        const firstName = document.getElementById('firstName')?.value?.trim();
        const lastName = document.getElementById('lastName')?.value?.trim();
        const email = document.getElementById('email')?.value?.trim();
        const phone = document.getElementById('phoneNumber')?.value?.trim();
        const address = document.getElementById('apartment')?.value?.trim();
        const city = document.getElementById('city')?.value?.trim();
        const state = document.getElementById('country')?.value?.trim();
        const pincode = document.getElementById('postal')?.value?.trim();
        
        const isBasicComplete = firstName && lastName && email && phone && address && city && state;
        const isPincodeValid = pincode && pincode.length === 6;
        const isComplete = isBasicComplete && isPincodeValid;
        
        // Check if mobile number changed and needs verification
        if (phone && phone !== currentMobile && phone.length === 10) {
            isMobileVerified = false;
            currentMobile = phone;
        }
        
        // Update progress indicators
        updateProgressSteps(isBasicComplete, isPincodeValid);
        
        if (isComplete !== isAddressComplete) {
            isAddressComplete = isComplete;
            updatePaymentAvailability();
        }
        
        return isComplete;
    }

    // Update progress step indicators
    function updateProgressSteps(isBasicComplete, isPincodeValid) {
        const stepAddress = document.getElementById('step-address');
        const stepPincode = document.getElementById('step-pincode');
        const stepDelivery = document.getElementById('step-delivery');
        const stepMobile = document.getElementById('step-mobile');
        const verifyMobileBtn = document.getElementById('verify-mobile-btn');
        
        // Step 1: Address completion
        if (stepAddress) {
            const icon = stepAddress.querySelector('i');
            const text = stepAddress.querySelector('span');
            if (isBasicComplete) {
                icon.className = 'ph ph-check-circle text-green-600';
                text.className = 'text-green-700 line-through';
            } else {
                icon.className = 'ph ph-circle text-amber-600';
                text.className = 'text-amber-700';
            }
        }
        
        // Step 2: Pincode validation
        if (stepPincode) {
            const icon = stepPincode.querySelector('i');
            const text = stepPincode.querySelector('span');
            if (isPincodeValid) {
                icon.className = 'ph ph-check-circle text-green-600';
                text.className = 'text-green-700 line-through';
            } else {
                icon.className = 'ph ph-circle text-amber-600';
                text.className = 'text-amber-700';
            }
        }
        
        // Step 3: Delivery calculation
        if (stepDelivery) {
            const icon = stepDelivery.querySelector('i');
            const text = stepDelivery.querySelector('span');
            if (isDeliveryCalculated) {
                icon.className = 'ph ph-check-circle text-green-600';
                text.className = 'text-green-700 line-through';
            } else {
                icon.className = 'ph ph-circle text-amber-600';
                text.className = 'text-amber-700';
            }
        }
        
        // Step 4: Mobile verification
        if (stepMobile) {
            const icon = stepMobile.querySelector('i');
            const text = stepMobile.querySelector('span');
            
            if (isMobileVerified) {
                icon.className = 'ph ph-check-circle text-green-600';
                text.className = 'text-green-700 line-through';
                verifyMobileBtn.classList.add('hidden');
            } else if (isBasicComplete && currentMobile && currentMobile.length === 10) {
                icon.className = 'ph ph-circle text-blue-600';
                text.className = 'text-blue-700';
                verifyMobileBtn.classList.remove('hidden');
            } else {
                icon.className = 'ph ph-circle text-amber-600';
                text.className = 'text-amber-700';
                verifyMobileBtn.classList.add('hidden');
            }
        }
    }

    // Update payment availability based on address and delivery calculation
    function updatePaymentAvailability() {
        const paymentSection = document.getElementById('payment-section');
        const paymentMessage = document.getElementById('payment-message');
        const paymentButtonContainer = document.getElementById('payment-button-container');
        const placeOrderBtn = document.getElementById('place-order-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        
        if (isAddressComplete && isDeliveryCalculated) {
            // Enable payment
            if (paymentSection) {
                paymentSection.style.opacity = '1';
                paymentSection.style.pointerEvents = 'auto';
                paymentSection.style.borderColor = '#000';
            }
            
            if (paymentMessage) {
                paymentMessage.style.display = 'none';
            }
            
            // Show payment button
            if (paymentButtonContainer) {
                paymentButtonContainer.style.display = 'block';
            }
            
            if (placeOrderBtn) {
                placeOrderBtn.disabled = false;
                placeOrderBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                placeOrderBtn.classList.add('cursor-pointer');
                placeOrderBtn.style.background = 'linear-gradient(135deg, #000 0%, #333 100%)';
            }
            
            if (btnText) btnText.textContent = 'Pay Securely';
            if (btnIcon) btnIcon.className = 'ph ph-credit-card text-xl';
            
            updateTotalDisplay();
        } else {
            // Disable payment
            if (paymentSection) {
                paymentSection.style.opacity = '0.5';
                paymentSection.style.pointerEvents = 'none';
                paymentSection.style.borderColor = '#d1d5db';
            }
            
            if (paymentMessage) {
                paymentMessage.style.display = 'block';
                const messageText = paymentMessage.querySelector('p');
                if (messageText) {
                    if (!isAddressComplete) {
                        messageText.textContent = 'Please fill your complete address and enter pincode to calculate delivery charges before payment.';
                    } else if (!isDeliveryCalculated) {
                        messageText.textContent = 'Calculating delivery charges... Please wait.';
                    }
                }
            }
            
            // Hide payment button
            if (paymentButtonContainer) {
                paymentButtonContainer.style.display = 'none';
            }
        }
    }

    // Update payment button for Razorpay only
    function updatePaymentButton(paymentMethod, totalAmount) {
        const btnText = document.getElementById('btn-text');
        const btnAmount = document.getElementById('btn-amount');
        const btnIcon = document.getElementById('btn-icon');
        
        if (!btnText || !btnAmount || !btnIcon) return;
        
        // Always Razorpay payment
        btnText.textContent = 'Pay Securely';
        btnAmount.textContent = '₹' + totalAmount.toFixed(2);
        btnIcon.className = 'ph ph-credit-card text-xl';
        
        // Ensure all elements are visible
        [btnText, btnAmount, btnIcon].forEach(el => {
            if (el) {
                el.style.display = 'inline-block';
                el.style.visibility = 'visible';
                el.style.opacity = '1';
                el.style.color = 'white';
            }
        });
        
        // Special styling for amount
        if (btnAmount) {
            btnAmount.style.backgroundColor = 'rgba(255,255,255,0.3)';
            btnAmount.style.color = '#1e40af';
            btnAmount.style.fontWeight = 'bold';
        }
    }

    // Shipping calculation
    function calculateShipping() {
        const postalCode = document.getElementById('postal')?.value?.trim();
        if (!postalCode || postalCode.length !== 6) {
            // Reset shipping if postal code is invalid
            currentShippingCharge = 0;
            window.currentShippingCharge = currentShippingCharge;
            isDeliveryCalculated = false;
            
            const shippingElement = document.querySelector('.shipping-charge');
            if (shippingElement) {
                shippingElement.textContent = '₹0.00';
            }

            // Hide delivery estimate
            const deliveryBlock = document.querySelector('.delivery-estimate');
            if (deliveryBlock) {
                deliveryBlock.style.display = 'none';
            }

            updatePaymentAvailability();
            updateTotalDisplay();
            return;
        }

        // Show loading state
        const shippingElement = document.querySelector('.shipping-charge');
        if (shippingElement) {
            shippingElement.textContent = 'Calculating...';
        }

        fetch('/api/shipping/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                pincode: postalCode,
                weight: 1,
                cod_amount: 0
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                currentShippingCharge = parseFloat(data.data.shipping_charge) || 0;
                window.currentShippingCharge = currentShippingCharge;
                const shippingElement = document.querySelector('.shipping-charge');
                if (shippingElement) {
                    shippingElement.textContent = currentShippingCharge > 0 ? '₹' + currentShippingCharge.toFixed(2) : 'Free';
                }
                
                // Show delivery estimate
                const deliveryBlock = document.querySelector('.delivery-estimate');
                const deliveryElement = document.querySelector('.estimated-delivery');
                if (data.data.estimated_delivery && deliveryElement && deliveryBlock) {
                    deliveryElement.textContent = data.data.estimated_delivery;
                    deliveryBlock.style.display = 'flex';
                } else if (deliveryBlock) {
                    deliveryBlock.style.display = 'none';
                }
                
                // Mark delivery as calculated
                isDeliveryCalculated = true;
                updatePaymentAvailability();
                updateTotalDisplay();
            } else {
                // Handle error - set to fallback shipping
                currentShippingCharge = 50; // Fallback shipping charge
                window.currentShippingCharge = currentShippingCharge;
                const shippingElement = document.querySelector('.shipping-charge');
                if (shippingElement) {
                    shippingElement.textContent = '₹' + currentShippingCharge.toFixed(2);
                }
                
                // Show fallback delivery estimate
                const deliveryBlock = document.querySelector('.delivery-estimate');
                const deliveryElement = document.querySelector('.estimated-delivery');
                if (deliveryElement && deliveryBlock) {
                    deliveryElement.textContent = '3-5 business days';
                    deliveryBlock.style.display = 'flex';
                }
                
                updateTotalDisplay();
            }
        })
        .catch(error => {
            console.error('Shipping calculation error:', error);
            // Fallback to default shipping
            currentShippingCharge = 50;
            window.currentShippingCharge = currentShippingCharge;
            const shippingElement = document.querySelector('.shipping-charge');
            if (shippingElement) {
                shippingElement.textContent = '₹' + currentShippingCharge.toFixed(2);
            }
            
            // Show fallback delivery estimate
            const deliveryBlock = document.querySelector('.delivery-estimate');
            const deliveryElement = document.querySelector('.estimated-delivery');
            if (deliveryElement && deliveryBlock) {
                deliveryElement.textContent = '3-5 business days';
                deliveryBlock.style.display = 'flex';
            }
            
            updateTotalDisplay();
        });
    }

    // Add event listener for postal code changes
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize cart subtotal
        initializeCartSubtotal();
        
        // Initialize payment button after a short delay to ensure cart is loaded
        setTimeout(() => {
            checkAddressCompletion();
            updatePaymentAvailability();
            updateTotalDisplay();
        }, 1000);
        
        const postalInput = document.getElementById('postal');
        if (postalInput) {
            postalInput.addEventListener('blur', calculateShipping);
            postalInput.addEventListener('input', function() {
                checkAddressCompletion();
                if (this.value.length === 6) {
                    calculateShipping();
                } else {
                    isDeliveryCalculated = false;
                    updatePaymentAvailability();
                }
            });
        }

        // Add listeners to all address fields
        const addressFields = ['firstName', 'lastName', 'email', 'phoneNumber', 'apartment', 'city', 'country', 'region'];
        addressFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', checkAddressCompletion);
                field.addEventListener('blur', checkAddressCompletion);
                field.addEventListener('change', function() {
                    checkAddressCompletion();
                    // Recalculate shipping if postal code is already entered
                    const postalCode = document.getElementById('postal')?.value?.trim();
                    if (postalCode && postalCode.length === 6) {
                        calculateShipping();
                    }
                });
            }
        });

        // No payment method change handling needed - only Razorpay available
    });

    // OTP Verification Functions
    function showOTPModal(mobile) {
        currentMobile = mobile;
        document.getElementById('otp-mobile-display').textContent = `+91 ${mobile}`;
        document.getElementById('otp-modal').classList.remove('hidden');
        document.getElementById('otp-input').focus();
        startOTPTimer();
    }

    function hideOTPModal() {
        document.getElementById('otp-modal').classList.add('hidden');
        document.getElementById('otp-input').value = '';
        document.getElementById('otp-error').classList.add('hidden');
    }

    function sendOTP(mobile) {
        return fetch('/api/otp/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({ mobile: mobile })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('OTP sent successfully:', data);
                showOTPModal(mobile);
            } else {
                alert('Failed to send OTP: ' + data.message);
            }
            return data;
        })
        .catch(error => {
            console.error('Error sending OTP:', error);
            alert('Failed to send OTP. Please try again.');
        });
    }

    function verifyOTP(mobile, otp) {
        return fetch('/api/otp/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({ 
                mobile: mobile,
                otp: otp 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                isMobileVerified = true;
                hideOTPModal();
                updatePaymentAvailability();
                alert('Mobile number verified successfully!');
            } else {
                document.getElementById('otp-error').textContent = data.message;
                document.getElementById('otp-error').classList.remove('hidden');
            }
            return data;
        })
        .catch(error => {
            console.error('Error verifying OTP:', error);
            document.getElementById('otp-error').textContent = 'Verification failed. Please try again.';
            document.getElementById('otp-error').classList.remove('hidden');
        });
    }

    function resendOTP(mobile) {
        return fetch('/api/otp/resend', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({ mobile: mobile })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                startOTPTimer();
                alert('OTP resent successfully!');
            } else {
                alert('Failed to resend OTP: ' + data.message);
            }
            return data;
        })
        .catch(error => {
            console.error('Error resending OTP:', error);
            alert('Failed to resend OTP. Please try again.');
        });
    }

    function startOTPTimer() {
        let timeLeft = 60;
        const timerElement = document.getElementById('timer-count');
        const resendBtn = document.getElementById('resend-otp-btn');
        
        resendBtn.disabled = true;
        
        const timer = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                document.getElementById('otp-timer').innerHTML = 'You can now resend OTP';
            }
        }, 1000);
    }

    // OTP Modal Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Close modal
        document.getElementById('close-otp-modal').addEventListener('click', hideOTPModal);
        
        // Verify OTP button
        document.getElementById('verify-otp-btn').addEventListener('click', function() {
            const otp = document.getElementById('otp-input').value.trim();
            if (otp.length === 6) {
                verifyOTP(currentMobile, otp);
            } else {
                document.getElementById('otp-error').textContent = 'Please enter a valid 6-digit OTP';
                document.getElementById('otp-error').classList.remove('hidden');
            }
        });
        
        // Resend OTP button
        document.getElementById('resend-otp-btn').addEventListener('click', function() {
            if (!this.disabled) {
                resendOTP(currentMobile);
            }
        });
        
        // OTP input auto-verify on 6 digits
        document.getElementById('otp-input').addEventListener('input', function() {
            const otp = this.value.trim();
            if (otp.length === 6) {
                verifyOTP(currentMobile, otp);
            }
            // Clear error on input
            document.getElementById('otp-error').classList.add('hidden');
        });
        
        // Close modal on outside click
        document.getElementById('otp-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideOTPModal();
            }
        });
        
        // Verify mobile button (removed - mobile verification no longer required at checkout)
        const verifyMobileBtn = document.getElementById('verify-mobile-btn');
        if (verifyMobileBtn) verifyMobileBtn.addEventListener('click', function() {
            const mobile = document.getElementById('phoneNumber')?.value?.trim();
            if (mobile && mobile.length === 10) {
                sendOTP(mobile);
            } else {
                alert('Please enter a valid 10-digit mobile number');
            }
        });
    });

    // Razorpay Payment Handler - Make it global
    window.handleRazorpayPayment = function(orderData) {
        let codCharge = 0; // No COD charges for online payment only
        
        // Use global variables with fallbacks
        const currentCartSubtotal = window.cartSubtotal || cartSubtotal || 0;
        const currentShipping = window.currentShippingCharge || currentShippingCharge || 0;
        const totalAmount = currentCartSubtotal + currentShipping;
        
        console.log('Payment calculation:', {
            cartSubtotal: currentCartSubtotal,
            shipping: currentShipping,
            total: totalAmount
        });

        // Test Razorpay configuration first
        fetch('/api/payments/test-config', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(configData => {
            console.log('Razorpay config test:', configData);
        })
        .catch(error => {
            console.error('Config test failed:', error);
        });

        // First create Razorpay order
        fetch('/api/payments/create-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                amount: totalAmount, // Amount in rupees - backend will convert to paise
                currency: 'INR'
            })
        })
        .then(response => {
            console.log('Payment API response status:', response.status);
            return response.text().then(function(text) {
                try {
                    var data = JSON.parse(text);
                    if (!response.ok) {
                        throw new Error(data.message || data.error || 'HTTP ' + response.status);
                    }
                    return data;
                } catch (e) {
                    if (!response.ok) throw new Error('Server error: ' + response.status + (text ? ' - ' + text.substring(0, 100) : ''));
                    throw e;
                }
            });
        })
        .then(data => {
            console.log('Payment API response data:', data);
            if (data.success && data.data) {
                // Initialize Razorpay checkout
                const options = {
                    key: data.data.key || '{{ config("services.razorpay.key") }}',
                    amount: data.data.amount, // Amount in paise
                    currency: data.data.currency,
                    name: 'Perch Bottle',
                    description: 'Order Payment',
                    order_id: data.data.id,
                    handler: function(response) {
                        // Payment successful, now place the order
                        orderData.razorpay_order_id = data.data.id;
                        orderData.razorpay_payment_id = response.razorpay_payment_id;
                        orderData.razorpay_signature = response.razorpay_signature;
                        
                        // Place order with payment details
                        placeOrderAfterPayment(orderData);
                    },
                    prefill: {
                        name: (orderData.shipping_address?.first_name || '') + ' ' + (orderData.shipping_address?.last_name || ''),
                        email: orderData.shipping_address?.email || '',
                        contact: orderData.shipping_address?.phone || ''
                    },
                    theme: {
                        color: '#000000'
                    },
                    modal: {
                        ondismiss: function() {
                            console.log('Razorpay payment cancelled');
                            // Re-enable the submit button
                            const submitBtn = document.querySelector('.place-order-btn');
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Place Order';
                            }
                        }
                    }
                };
                
                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                alert('Failed to initialize payment: ' + (data.message || 'Unknown error'));
                resetSubmitButton();
            }
        })
        .catch(error => {
            console.error('Error creating Razorpay order:', error);
            var msg = error && error.message ? error.message : 'Please try again.';
            if (msg.includes('Failed to fetch') || msg.includes('NetworkError')) {
                msg = 'Network error. Check your connection and ensure the site is on HTTPS.';
            }
            alert('Error initializing payment. ' + msg);
            resetSubmitButton();
        });
    }

    function placeOrderAfterPayment(orderData) {
        fetch('/place-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data && data.data.id) {
                console.log('Order placed successfully after payment');
                window.location.href = `/order-success/${data.data.id}`;
            } else {
                alert('Payment successful but order creation failed. Please contact support.');
                console.error('Order creation failed:', data);
            }
        })
        .catch(error => {
            console.error('Error placing order after payment:', error);
            alert('Payment successful but order creation failed. Please contact support.');
        });
    }

    function resetSubmitButton() {
        const submitBtn = document.querySelector('.place-order-btn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Place Order';
        }
    }

})();
</script>
