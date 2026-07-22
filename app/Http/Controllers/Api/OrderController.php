<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * List user orders
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'coupon'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Create order from cart (supports both authenticated and guest users)
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $validationRules = [
            'payment_method' => 'required|in:razorpay,cod,test',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string|required_if:payment_method,razorpay',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
            'shipping_charge' => 'nullable|numeric|min:0',
            'cod_charge' => 'nullable|numeric|min:0',
        ];

        // Determine if this is a logged-in user request or guest request
        // If shipping_address is provided, treat as logged-in user
        // Otherwise, if user is authenticated, also treat as logged-in user
        // Only require guest_info if neither condition is met
        if ($user || $request->has('shipping_address')) {
            // For logged-in users, accept either shipping_address_id OR shipping_address
            $validationRules['shipping_address_id'] = 'required_without:shipping_address|exists:addresses,id';
            $validationRules['billing_address_id'] = 'nullable|exists:addresses,id';
            $validationRules['shipping_address'] = 'required_without:shipping_address_id|array';
            // If shipping_address is provided, validate its fields
            $validationRules['shipping_address.first_name'] = 'required_with:shipping_address|string|max:255';
            $validationRules['shipping_address.last_name'] = 'required_with:shipping_address|string|max:255';
            $validationRules['shipping_address.email'] = 'required_with:shipping_address|email|max:255';
            $validationRules['shipping_address.phone'] = 'required_with:shipping_address|string|max:20';
            $validationRules['shipping_address.address_line_1'] = 'required_with:shipping_address|string';
            $validationRules['shipping_address.city'] = 'required_with:shipping_address|string|max:255';
            $validationRules['shipping_address.state'] = 'required_with:shipping_address|string|max:255';
            $validationRules['shipping_address.pincode'] = 'required_with:shipping_address|string|max:10';
        } else {
            // For guests, require guest_info
            $validationRules['guest_info'] = 'required|array';
            $validationRules['guest_info.first_name'] = 'required|string|max:255';
            $validationRules['guest_info.last_name'] = 'required|string|max:255';
            $validationRules['guest_info.email'] = 'required|email|max:255';
            $validationRules['guest_info.phone'] = 'required|string|max:20';
            $validationRules['guest_info.address'] = 'required|string';
            $validationRules['guest_info.city'] = 'required|string|max:255';
            $validationRules['guest_info.state'] = 'required|string|max:255';
            $validationRules['guest_info.pincode'] = 'required|string|max:10';
        }

        $request->validate($validationRules);

        $user = $request->user();
        $sessionId = $request->cookie('cart_session_id');

        // Get cart items
        if ($user) {
            $sessionId = $request->cookie('cart_session_id');
            
            // Strategy 1: Get all cart items for this user (regardless of session_id)
            $cartItems = Cart::where('user_id', $user->id)
                ->with('product')
                ->get();
            
            // Strategy 2: If no items found, check for guest cart items in session (cookie)
            if ($cartItems->isEmpty() && $sessionId) {
                $guestCartItems = Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->with('product')
                    ->get();
                foreach ($guestCartItems as $guestItem) {
                    if ($guestItem->product) {
                        $guestItem->user_id = $user->id;
                        $guestItem->session_id = null;
                        $guestItem->save();
                        $cartItems->push($guestItem);
                    }
                }
            }
            
            // Strategy 2b: If still empty, use "best" guest session (same as Cart API / checkout)
            // Cart API uses guest cart when no session auth; checkout display can show those items.
            if ($cartItems->isEmpty()) {
                $bestSession = Cart::whereNull('user_id')
                    ->whereNotNull('session_id')
                    ->selectRaw('session_id, COUNT(*) as item_count, SUM(quantity) as total_quantity, MAX(created_at) as latest_created_at')
                    ->groupBy('session_id')
                    ->orderBy('total_quantity', 'desc')
                    ->orderBy('item_count', 'desc')
                    ->orderBy('latest_created_at', 'desc')
                    ->first();
                if ($bestSession) {
                    $sessionId = $bestSession->session_id;
                    $guestCartItems = Cart::where('session_id', $sessionId)
                        ->whereNull('user_id')
                        ->with('product')
                        ->get();
                    foreach ($guestCartItems as $guestItem) {
                        if ($guestItem->product) {
                            $guestItem->user_id = $user->id;
                            $guestItem->session_id = null;
                            $guestItem->save();
                            $cartItems->push($guestItem);
                        }
                    }
                }
            }
            
            // Strategy 3: If still empty, try to find ANY cart items with this user_id (even with session_id)
            if ($cartItems->isEmpty()) {
                $cartItems = Cart::where('user_id', $user->id)
                    ->with('product')
                    ->get();
            }
            
            // Strategy 4: If still empty and we have session_id, try to find guest items with that session
            if ($cartItems->isEmpty() && $sessionId) {
                $guestCartItems = Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->with('product')
                    ->get();
                foreach ($guestCartItems as $guestItem) {
                    if ($guestItem->product) {
                        $guestItem->user_id = $user->id;
                        $guestItem->session_id = null;
                        $guestItem->save();
                        $cartItems->push($guestItem);
                    }
                }
            }
            
            // Strategy 5: If user has items, merge any remaining guest items
            if (!$cartItems->isEmpty() && $sessionId) {
                $guestCartItems = Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->with('product')
                    ->get();
                
                // Merge guest cart items into user cart
                foreach ($guestCartItems as $guestItem) {
                    if (!$guestItem->product) {
                        continue; // Skip items with null products
                    }
                    
                    // Check if user already has this product with same size/color
                    $existingItem = $cartItems->first(function($item) use ($guestItem) {
                        return $item->product_id === $guestItem->product_id 
                            && $item->size === $guestItem->size 
                            && $item->color === $guestItem->color;
                    });
                    
                    if ($existingItem) {
                        // Update quantity
                        $existingItem->quantity += $guestItem->quantity;
                        $existingItem->save();
                        // Delete guest item
                        $guestItem->delete();
                    } else {
                        // Transfer guest item to user
                        $guestItem->user_id = $user->id;
                        $guestItem->session_id = null;
                        $guestItem->save();
                        $cartItems->push($guestItem);
                    }
                }
            }
            
        } else {
            // Guest cart - use same logic as CheckoutController
            // First, find the best session ID (one with most items)
            $bestSession = Cart::whereNull('user_id')
                ->whereNotNull('session_id')
                ->selectRaw('session_id, COUNT(*) as item_count, SUM(quantity) as total_quantity, MAX(created_at) as latest_created_at')
                ->groupBy('session_id')
                ->orderBy('total_quantity', 'desc')
                ->orderBy('item_count', 'desc')
                ->orderBy('latest_created_at', 'desc')
                ->first();
            
            // Use cookie session ID if available, otherwise use best session
            $cookieSessionId = $request->cookie('cart_session_id');
            
            // Try to find cart items with cookie session ID first
            if ($cookieSessionId) {
                $cartItems = Cart::where('session_id', $cookieSessionId)
                    ->whereNull('user_id')
                    ->with('product')
                    ->get();
            } else {
                $cartItems = collect([]);
            }
            
            // If no items found with cookie session, try best session
            if ($cartItems->isEmpty() && $bestSession) {
                $cartItems = Cart::where('session_id', $bestSession->session_id)
                    ->whereNull('user_id')
                    ->with('product')
                    ->get();
                
                // Update session ID to best session for consistency
                $sessionId = $bestSession->session_id;
            } else {
                $sessionId = $cookieSessionId;
            }
            
            // If still no items, check if there are ANY guest cart items
            if ($cartItems->isEmpty()) {
                $anyGuestItems = Cart::whereNull('user_id')
                    ->whereNotNull('session_id')
                    ->with('product')
                    ->get();
                
                if (!$anyGuestItems->isEmpty()) {
                    // Use the session_id from the first item found
                    $firstItem = $anyGuestItems->first();
                    $cartItems = Cart::where('session_id', $firstItem->session_id)
                        ->whereNull('user_id')
                        ->with('product')
                        ->get();
                    $sessionId = $firstItem->session_id;
                }
            }
            
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty. Please add items to your cart before placing an order. Go to the shop page and add products to your cart first.',
                ], 400);
            }
        }

        // Filter out items where product is null or deleted
        $cartItems = $cartItems->filter(function($item) {
            return $item->product !== null;
        });
        
        if ($cartItems->isEmpty()) {
            // Log for debugging
            \Log::info('Cart is empty - Debug Info', [
                'user_id' => $user?->id,
                'user_email' => $user?->email,
                'session_id' => $sessionId ?? 'no session',
                'user_exists' => $user !== null,
                'total_cart_items_in_db' => Cart::count(),
                'user_cart_items_count' => $user ? Cart::where('user_id', $user->id)->count() : 0,
                'guest_cart_items_count' => isset($sessionId) && $sessionId ? Cart::where('session_id', $sessionId)->whereNull('user_id')->count() : 0,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty. Please add items to your cart before placing an order. Go to the shop page and add products to your cart first.',
            ], 400);
        }

        // Get addresses
        // Determine if guest based on what was validated (not just $user)
        $isGuestAfterValidation = !$user && !$request->has('shipping_address');
        
        if ($isGuestAfterValidation) {
            $guestInfo = $request->guest_info;
            $shippingAddress = [
                'first_name' => $guestInfo['first_name'],
                'last_name' => $guestInfo['last_name'],
                'email' => $guestInfo['email'],
                'phone' => $guestInfo['phone'],
                'address' => $guestInfo['address'],
                'city' => $guestInfo['city'],
                'state' => $guestInfo['state'],
                'pincode' => $guestInfo['pincode'],
            ];
            $billingAddress = $shippingAddress;
        } else {
            if ($request->shipping_address_id) {
                $shippingAddressModel = \App\Models\Address::where('user_id', $user->id)
                    ->findOrFail($request->shipping_address_id);
                $shippingAddress = $shippingAddressModel->toArray();
            } else {
                $shippingAddress = $request->shipping_address;
            }

            $billingAddress = $request->billing_address_id 
                ? \App\Models\Address::where('user_id', $user->id)->findOrFail($request->billing_address_id)->toArray()
                : ($request->billing_address ?? $shippingAddress);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        // Apply coupon if provided
        $coupon = null;
        $couponDiscount = 0;
        
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            $userId = $user ? $user->id : null;
            
            if ($coupon && $coupon->isValid($subtotal, [], $userId)) {
                $couponDiscount = $coupon->calculateDiscount($subtotal);
            }
        }

        // Calculate shipping and COD charges
        $shippingCharge = $request->shipping_charge ?? 0; // Use provided shipping charge or default to 0
        $codCharge = $request->cod_charge ?? 0; // Use provided COD charge or default to 0

        $totalAmount = $subtotal - $couponDiscount + $shippingCharge + $codCharge;

        DB::beginTransaction();
        try {
            // Create order
            $orderData = [
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id' => $user ? $user->id : null,
                'status' => 'pending',
                'status_locked' => false,
                'total_amount' => $totalAmount,
                'subtotal' => $subtotal, // Add subtotal field
                'tax' => 0, // Add tax field (default 0)
                'shipping' => $shippingCharge, // Add shipping field (legacy)
                'total' => $totalAmount, // Add total field (legacy)
                'shipping_charge' => $shippingCharge,
                'cod_charge' => $codCharge,
                'coupon_id' => $coupon?->id,
                'coupon_discount' => $couponDiscount,
                'shipping_address' => is_array($shippingAddress) ? json_encode($shippingAddress) : $shippingAddress,
                'billing_address' => is_array($billingAddress) ? json_encode($billingAddress) : $billingAddress,
                'payment_method' => $request->payment_method === 'test' ? 'test' : $request->payment_method,
                'payment_status' => ($request->payment_method === 'cod' || $request->payment_method === 'test') ? 'paid' : ($request->razorpay_payment_id ? 'paid' : 'pending'),
                'notes' => $request->notes,
            ];

            // Add customer info (for both guest and logged-in users)
            if ($isGuestAfterValidation) {
                // Guest checkout
                $orderData['customer_name'] = $guestInfo['first_name'] . ' ' . $guestInfo['last_name'];
                $orderData['customer_email'] = $guestInfo['email'];
                $orderData['customer_phone'] = $guestInfo['phone'];
            } else {
                // Logged-in user checkout - get customer info from user or shipping address
                if ($user) {
                    $orderData['customer_name'] = $user->name ?? ($shippingAddress['first_name'] ?? '') . ' ' . ($shippingAddress['last_name'] ?? '');
                    $orderData['customer_email'] = $user->email ?? $shippingAddress['email'] ?? '';
                    $orderData['customer_phone'] = $user->phone ?? $shippingAddress['phone'] ?? '';
                } else {
                    // Fallback if somehow user is null but not guest
                    $orderData['customer_name'] = ($shippingAddress['first_name'] ?? '') . ' ' . ($shippingAddress['last_name'] ?? '');
                    $orderData['customer_email'] = $shippingAddress['email'] ?? '';
                    $orderData['customer_phone'] = $shippingAddress['phone'] ?? '';
                }
            }

            // Add Razorpay payment details if provided
            if ($request->payment_method === 'razorpay' && $request->razorpay_payment_id) {
                $orderData['razorpay_order_id'] = $request->razorpay_order_id;
                $orderData['razorpay_payment_id'] = $request->razorpay_payment_id;
                $orderData['razorpay_signature'] = $request->razorpay_signature;
            }

            $order = Order::create($orderData);

            // Create order items and update inventory
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                
                // Check stock again before creating order
                if ($cartItem->customization_json) {
                    $availableStock = $product->stock_quantity ?? $product->stock ?? 0;
                    if ($availableStock < $cartItem->quantity) {
                        throw new \Exception("Insufficient stock for {$product->name}. Available: {$availableStock}, Requested: {$cartItem->quantity}");
                    }
                    if ($product->stock_quantity !== null) {
                        $product->stock_quantity -= $cartItem->quantity;
                    } else {
                        $product->stock -= $cartItem->quantity;
                    }
                    $product->save();
                } elseif ($cartItem->size || $cartItem->color) {
                    $stock = $product->getStockForColorSize($cartItem->color, $cartItem->size);
                    if ($stock < $cartItem->quantity) {
                        throw new \Exception("Insufficient stock for {$product->name}. Available: {$stock}, Requested: {$cartItem->quantity}");
                    }
                    
                    // Update inventory (deduct stock for this variant)
                    $inventory = Inventory::where('product_id', $product->id)
                        ->where('color', $cartItem->color ?? '')
                        ->where('size', $cartItem->size ?? '')
                        ->first();

                    if ($inventory) {
                        $inventory->quantity -= $cartItem->quantity;
                        $inventory->sold_quantity = ($inventory->sold_quantity ?? 0) + $cartItem->quantity;
                        $inventory->save();
                        $product->syncStockFromInventories();
                    } else {
                        // If no inventory record exists, create one with negative quantity (for tracking)
                        // Or throw error if inventory is required
                        throw new \Exception("Inventory record not found for {$product->name} with color: {$cartItem->color}, size: {$cartItem->size}");
                    }
                } else {
                    // Check main product stock
                    $availableStock = $product->stock_quantity ?? $product->stock ?? 0;
                    if ($availableStock < $cartItem->quantity) {
                        throw new \Exception("Insufficient stock for {$product->name}. Available: {$availableStock}, Requested: {$cartItem->quantity}");
                    }

                    // Update product stock
                    if ($product->stock_quantity !== null) {
                        $product->stock_quantity -= $cartItem->quantity;
                    } else {
                        $product->stock -= $cartItem->quantity;
                    }
                    $product->save();
                }

                // Create order item (use cart's unit price so variant price is saved)
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->unit_price,
                    'size' => $cartItem->size,
                    'color' => $cartItem->color,
                    'customization_json' => $cartItem->customization_json,
                    'customization_image' => $cartItem->customization_image,
                    // Legacy fields
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'total' => $cartItem->subtotal,
                ]);
            }

            // Apply coupon usage
            if ($coupon && $user) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_amount' => $couponDiscount,
                    'order_amount' => $subtotal,
                ]);

                $coupon->used_count++;
                $coupon->save();
            }

            // Clear cart
            if ($user) {
                Cart::where('user_id', $user->id)->delete();
            } else {
                Cart::where('session_id', $sessionId)->whereNull('user_id')->delete();
            }

            // Send order confirmation email
            try {
                $email = $user ? $user->email : $order->customer_email;
                $name = $user ? $user->name : $order->customer_name;
                
                if ($email) {
                    Mail::send('emails.order-confirmation', ['order' => $order->load('items.product')], function ($message) use ($email, $name, $order) {
                        $message->to($email, $name)
                            ->subject("Order Confirmation - {$order->order_number}");
                    });
                }
            } catch (\Exception $e) {
                \Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order->load(['items.product', 'coupon']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order details
     */
    public function show(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'coupon'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Get order invoice (PDF)
     */
    public function invoice(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'coupon'])
            ->findOrFail($id);

        // TODO: Generate PDF invoice
        // For now, return JSON data
        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'PDF invoice generation will be implemented',
        ]);
    }
}

