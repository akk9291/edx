<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\CustomizeConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId(Request $request)
    {
        if ($request->user()) {
            return null; // User is logged in
        }

        $sessionId = $request->cookie('cart_session_id');
        
        // If no cookie, try to get from existing cart items
        // Use the session_id that has the most total quantity
        if (!$sessionId) {
            $sessionCounts = Cart::whereNull('user_id')
                ->whereNotNull('session_id')
                ->selectRaw('session_id, COUNT(*) as item_count, SUM(quantity) as total_quantity, MAX(created_at) as latest_created_at')
                ->groupBy('session_id')
                ->orderBy('total_quantity', 'desc')
                ->orderBy('item_count', 'desc')
                ->orderBy('latest_created_at', 'desc')
                ->first();
            
            if ($sessionCounts) {
                $sessionId = $sessionCounts->session_id;
            } else {
                $sessionId = Str::random(40);
            }
        }

        return $sessionId;
    }

    /**
     * Get cart item count
     */
    public function count(Request $request)
    {
        $sessionCookieValue = null;

        if ($request->user()) {
            $userItems = Cart::with('product')
                ->where('user_id', $request->user()->id)
                ->get();

            $cookieSessionId = $request->cookie('cart_session_id');
            $guestItems = collect();
            if ($cookieSessionId) {
                $this->consolidateGuestCart($cookieSessionId);
                $guestItems = Cart::with('product')
                    ->where('session_id', $cookieSessionId)
                    ->whereNull('user_id')
                    ->get();
            }

            $cartItems = $userItems->concat($guestItems)->unique('id')->values();
            $sessionCookieValue = $cookieSessionId;
        } else {
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
            $sessionId = $cookieSessionId ?: ($bestSession ? $bestSession->session_id : Str::random(40));
            
            // If cookie session is different from best session, consolidate to best session
            if ($bestSession && $bestSession->session_id !== $sessionId) {
                $sessionId = $bestSession->session_id;
            }
            
            // Consolidate all guest cart items to this session
            $this->consolidateGuestCart($sessionId);
            
            $cartItems = Cart::with('product')
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();

            $sessionCookieValue = $sessionId;
        }
        
        // Remove orphan cart items (deleted products) and filter
        $orphanIds = $cartItems->filter(fn($i) => $i->product === null)->pluck('id');
        if ($orphanIds->isNotEmpty()) {
            Cart::whereIn('id', $orphanIds)->delete();
        }
        $cartItems = $cartItems->filter(fn($item) => $item->product !== null);

        $count = $cartItems->sum('quantity');

        $response = response()->json([
            'success' => true,
            'data' => ['count' => $count],
        ]);

        if ($sessionCookieValue) {
            return $response->cookie('cart_session_id', $sessionCookieValue, 60 * 24 * 30);
        }

        return $response;
    }

    /**
     * Get cart items
     */
    public function index(Request $request)
    {
        $sessionCookieValue = null;

        if ($request->user()) {
            $userItems = Cart::with('product.category')
                ->where('user_id', $request->user()->id)
                ->get();

            $cookieSessionId = $request->cookie('cart_session_id');
            $guestItems = collect();
            if ($cookieSessionId) {
                $this->consolidateGuestCart($cookieSessionId);
                $guestItems = Cart::with('product.category')
                    ->where('session_id', $cookieSessionId)
                    ->whereNull('user_id')
                    ->get();
            }

            $cartItems = $userItems->concat($guestItems)->unique('id')->values();
            $sessionCookieValue = $cookieSessionId;
        } else {
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
            $sessionId = $cookieSessionId ?: ($bestSession ? $bestSession->session_id : Str::random(40));
            
            // If cookie session is different from best session, consolidate to best session
            if ($bestSession && $bestSession->session_id !== $sessionId) {
                $sessionId = $bestSession->session_id;
            }
            
            // Consolidate all guest cart items to this session
            $this->consolidateGuestCart($sessionId);
            
            $cartItems = Cart::with('product.category')
                ->where('session_id', $sessionId)
                ->whereNull('user_id')
                ->get();

            $sessionCookieValue = $sessionId;
        }

        // Remove cart items for deleted products (orphans) and filter
        $orphanIds = $cartItems->filter(fn($i) => $i->product === null)->pluck('id');
        if ($orphanIds->isNotEmpty()) {
            Cart::whereIn('id', $orphanIds)->delete();
        }
        $cartItems = $cartItems->filter(fn($item) => $item->product !== null)->values();

        // Calculate total and ensure product data is properly loaded
        $total = 0;
        $items = $cartItems->map(function($item) use (&$total) {
            // Ensure product is loaded
            if (!$item->relationLoaded('product')) {
                $item->load('product');
            }
            
            $product = $item->product;
            $unitPrice = (float) $item->unit_price;
            $subtotal = (float) $item->subtotal;
            $total += $subtotal;
            
            $previewUrl = null;
            if ($item->customization_image) {
                $previewUrl = Storage::disk('public')->url($item->customization_image);
            }

            $decodedCustomization = $item->customization_json
                ? json_decode($item->customization_json, true)
                : null;
            $displayName = (is_array($decodedCustomization) && ! empty($decodedCustomization['product_title']))
                ? $decodedCustomization['product_title']
                : ($product->name ?? '');

            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'color' => $item->color,
                'display_name' => $displayName,
                'customization_image_url' => $previewUrl,
                'customization_label' => $item->customization_json
                    ? $this->customizationSummaryLabel($item->customization_json)
                    : null,
                'subtotal' => $subtotal,
                'unit_price' => $unitPrice,
                'product' => $product ? [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price ?? 0,
                    'sale_price' => $product->sale_price,
                    'current_price' => $product->current_price ?? ($product->sale_price ?? $product->price ?? 0),
                    'image' => $product->image,
                    'sku' => $product->sku,
                ] : null,
            ];
        });

        $response = response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'total' => $total,
            ],
        ]);

        if ($sessionCookieValue) {
            return $response->cookie('cart_session_id', $sessionCookieValue, 60 * 24 * 30);
        }

        return $response;
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'customization' => 'nullable|array',
            'customization.size_idx' => 'nullable|integer|min:0',
            'customization.engraving_text' => 'nullable|string|max:2000',
            'customization.engraving' => 'nullable|array',
            'customization.engraving.category_slug' => 'nullable|string|max:120',
            'customization.engraving.text' => 'nullable|string|max:2000',
            'customization.engraving.image_data' => 'nullable|string|max:1600000',
            'customization.engraving.mode' => 'nullable|string|in:single,double',
            'customization.engraving.top' => 'nullable|array',
            'customization.engraving.top.category_slug' => 'nullable|string|max:120',
            'customization.engraving.top.text' => 'nullable|string|max:2000',
            'customization.engraving.top.image_data' => 'nullable|string|max:1600000',
            'customization.engraving.bottom' => 'nullable|array',
            'customization.engraving.bottom.category_slug' => 'nullable|string|max:120',
            'customization.engraving.bottom.text' => 'nullable|string|max:2000',
            'customization.engraving.bottom.image_data' => 'nullable|string|max:1600000',
            'custom_unit_price' => 'nullable|numeric|min:0',
            'customization_image' => 'nullable|string|max:6500000',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This product is currently unavailable.',
            ], 400);
        }

        $customizationPayload = $request->input('customization');
        $isCustomizerLine = is_array($customizationPayload) && array_key_exists('size_idx', $customizationPayload);

        $customizationJson = null;
        $customizationImagePath = null;
        $customUnitPrice = null;

        if ($isCustomizerLine) {
            $cartProductId = CustomizeConfigService::getCartProductId();
            if (!$cartProductId || (int) $request->product_id !== $cartProductId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product for customizer checkout.',
                ], 422);
            }

            $sizeIdx = (int) $customizationPayload['size_idx'];
            $expectedUnit = CustomizeConfigService::unitPriceForCustomizerSizeIndex($sizeIdx);
            if ($expectedUnit === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid size selection.',
                ], 422);
            }

            $engrResult = CustomizeConfigService::applyCustomizerEngravingToUnit($expectedUnit, $customizationPayload);
            if (! $engrResult['ok']) {
                return response()->json([
                    'success' => false,
                    'message' => $engrResult['message'] ?? 'Invalid engraving options.',
                ], 422);
            }
            $expectedUnit = $engrResult['unit'];

            $claimed = round((float) $request->input('custom_unit_price', -1), 2);
            if (abs($claimed - $expectedUnit) > 0.02) {
                return response()->json([
                    'success' => false,
                    'message' => 'Price mismatch. Please refresh the customizer and try again.',
                ], 422);
            }

            if (isset($customizationPayload['engraving']) && is_array($customizationPayload['engraving'])) {
                // Legacy single upload: engraving.image_data
                $imgData = $customizationPayload['engraving']['image_data'] ?? null;
                if (is_string($imgData) && $imgData !== '') {
                    $stored = $this->storeCustomizationImage($imgData);
                    unset($customizationPayload['engraving']['image_data']);
                    if ($stored) {
                        $customizationPayload['engraving']['engraving_image'] = $stored;
                    }
                }
                // New double-slot upload: engraving.top.image_data / engraving.bottom.image_data
                foreach (['top', 'bottom'] as $slot) {
                    if (! isset($customizationPayload['engraving'][$slot]) || ! is_array($customizationPayload['engraving'][$slot])) {
                        continue;
                    }
                    $slotImg = $customizationPayload['engraving'][$slot]['image_data'] ?? null;
                    if (is_string($slotImg) && $slotImg !== '') {
                        $stored = $this->storeCustomizationImage($slotImg);
                        unset($customizationPayload['engraving'][$slot]['image_data']);
                        if ($stored) {
                            $customizationPayload['engraving'][$slot]['engraving_image'] = $stored;
                        }
                    }
                }
            }

            $customizationJson = json_encode($customizationPayload, JSON_UNESCAPED_UNICODE);
            $customizationImagePath = $this->storeCustomizationImage($request->input('customization_image'));
            $customUnitPrice = $expectedUnit;
        }

        $cartData = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'size' => $isCustomizerLine ? null : $request->size,
            'color' => $isCustomizerLine ? null : $request->color,
            'customization_json' => $customizationJson,
            'customization_image' => $customizationImagePath,
            'custom_unit_price' => $customUnitPrice,
        ];

        // Stock: customizer lines use main product stock only (no variant rows)
        if ($isCustomizerLine) {
            $availableStock = $product->stock_quantity ?? 0;
            if (!$product->in_stock || $availableStock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $availableStock > 0
                        ? "Only {$availableStock} item(s) available in stock."
                        : 'This item is out of stock.',
                ], 400);
            }
        } elseif ($request->size || $request->color) {
            $stock = $product->getStockForColorSize($request->color, $request->size);
            if ($stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $stock > 0
                        ? "Only {$stock} item(s) available in stock."
                        : 'This item is out of stock.',
                ], 400);
            }
        } else {
            $availableStock = $product->stock_quantity ?? 0;
            if (!$product->in_stock || $availableStock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $availableStock > 0
                        ? "Only {$availableStock} item(s) available in stock."
                        : 'This item is out of stock.',
                ], 400);
            }
        }

        if ($request->user()) {
            $cartData['user_id'] = $request->user()->id;
            $cartData['session_id'] = null;

            if ($isCustomizerLine) {
                $existingCart = Cart::where('user_id', $request->user()->id)
                    ->where('product_id', $request->product_id)
                    ->where('customization_json', $customizationJson)
                    ->first();
            } else {
                $existingCart = Cart::where('user_id', $request->user()->id)
                    ->where('product_id', $request->product_id)
                    ->whereNull('customization_json')
                    ->where('size', $request->size)
                    ->where('color', $request->color)
                    ->first();
            }

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $request->quantity;
                if ($isCustomizerLine) {
                    $availableStock = $product->stock_quantity ?? 0;
                    if (!$product->in_stock || $availableStock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $availableStock > 0
                                ? "Only {$availableStock} item(s) available in stock. You already have {$existingCart->quantity} in your cart."
                                : 'This item is out of stock.',
                        ], 400);
                    }
                } elseif ($request->size || $request->color) {
                    $stock = $product->getStockForColorSize($request->color, $request->size);
                    if ($stock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $stock > 0
                                ? "Only {$stock} item(s) available in stock. You already have {$existingCart->quantity} in your cart."
                                : 'This item is out of stock.',
                        ], 400);
                    }
                } else {
                    $availableStock = $product->stock_quantity ?? 0;
                    if (!$product->in_stock || $availableStock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $availableStock > 0
                                ? "Only {$availableStock} item(s) available in stock. You already have {$existingCart->quantity} in your cart."
                                : 'This item is out of stock.',
                        ], 400);
                    }
                }

                $existingCart->quantity = $newQuantity;
                $existingCart->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated in cart',
                    'data' => $existingCart,
                ]);
            }
        } else {
            $sessionId = $this->getSessionId($request);
            $cartData['session_id'] = $sessionId;

            if ($isCustomizerLine) {
                $existingCart = Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->where('product_id', $request->product_id)
                    ->where('customization_json', $customizationJson)
                    ->first();
            } else {
                $existingCart = Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->where('product_id', $request->product_id)
                    ->whereNull('customization_json')
                    ->where('size', $request->size)
                    ->where('color', $request->color)
                    ->first();
            }

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $request->quantity;
                if ($isCustomizerLine) {
                    $availableStock = $product->stock_quantity ?? 0;
                    if (!$product->in_stock || $availableStock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $availableStock > 0
                                ? "Only {$availableStock} item(s) available in stock. You already have {$existingCart->quantity} in your cart."
                                : 'This item is out of stock.',
                        ], 400);
                    }
                } elseif ($request->size || $request->color) {
                    $stock = $product->getStockForColorSize($request->color, $request->size);
                    if ($stock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $stock > 0
                                ? "Only {$stock} item(s) available in stock. You already have {$existingCart->quantity} in your cart."
                                : 'This item is out of stock.',
                        ], 400);
                    }
                } else {
                    $availableStock = $product->stock_quantity ?? 0;
                    if (!$product->in_stock || $availableStock < $newQuantity) {
                        return response()->json([
                            'success' => false,
                            'message' => $availableStock > 0
                                ? "Only {$availableStock} item(s) available in stock. You already have {$existingCart->quantity} in your cart."
                                : 'This item is out of stock.',
                        ], 400);
                    }
                }

                $existingCart->quantity = $newQuantity;
                $existingCart->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated in cart',
                    'data' => $existingCart,
                ])->cookie('cart_session_id', $sessionId, 60 * 24 * 30);
            }
        }

        $cart = Cart::create($cartData);

        $response = response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => $cart->load('product'),
        ], 201);

        if (!$request->user()) {
            $sid = $cartData['session_id'] ?? $this->getSessionId($request);

            return $response->cookie('cart_session_id', $sid, 60 * 24 * 30);
        }

        return $response;
    }

    /**
     * Update cart item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);

        if (!$this->cartItemAccessible($request, $cart)) {
            return response()->json([
                'success' => false,
                'message' => 'This cart item does not belong to you. Please refresh the page.',
            ], 403);
        }

        // Check stock
        $product = $cart->product;
        if ($cart->customization_json) {
            $availableStock = $product->stock_quantity ?? 0;
            if (!$product->in_stock || $availableStock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $availableStock > 0
                        ? "Only {$availableStock} item(s) available in stock."
                        : 'This item is out of stock.',
                ], 400);
            }
        } elseif ($cart->size || $cart->color) {
            $stock = $product->getStockForColorSize($cart->color, $cart->size);
            if ($stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $stock > 0 
                        ? "Only {$stock} item(s) available in stock." 
                        : 'This item is out of stock.',
                ], 400);
            }
        } else {
            $availableStock = $product->stock_quantity ?? 0;
            if (!$product->in_stock || $availableStock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $availableStock > 0 
                        ? "Only {$availableStock} item(s) available in stock." 
                        : 'This item is out of stock.',
                ], 400);
            }
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Cart item updated',
            'data' => $cart->load('product'),
        ]);
    }

    /**
     * Remove cart item
     */
    public function remove(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        if (!$this->cartItemAccessible($request, $cart)) {
            return response()->json([
                'success' => false,
                'message' => 'This cart item does not belong to you. Please refresh the page.',
            ], 403);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }

    /**
     * Check if product exists in cart
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $query = Cart::where('product_id', $request->product_id);

        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
        } else {
            $sessionId = $this->getSessionId($request);
            $query->where('session_id', $sessionId)->whereNull('user_id');
        }

        if ($request->size) {
            $query->where('size', $request->size);
        }

        if ($request->color) {
            $query->where('color', $request->color);
        }

        $exists = $query->exists();

        return response()->json([
            'success' => true,
            'data' => ['exists' => $exists],
        ]);
    }

    /**
     * Consolidate all guest cart items into one session
     */
    private function consolidateGuestCart($targetSessionId)
    {
        // Get all guest cart items with different session IDs
        $otherCarts = Cart::whereNull('user_id')
            ->whereNotNull('session_id')
            ->where('session_id', '!=', $targetSessionId)
            ->with('product')
            ->get();

        if ($otherCarts->isEmpty()) {
            return;
        }

        // Group by product_id, variant, and customization fingerprint
        $grouped = $otherCarts->groupBy(function ($item) {
            return $item->product_id.'|'.($item->size ?? '').'|'.($item->color ?? '').'|'.($item->customization_json ?? '');
        });

        foreach ($grouped as $key => $items) {
            $totalQuantity = $items->sum('quantity');
            $firstItem = $items->first();

            // Skip if product is null
            if (!$firstItem->product) {
                continue;
            }

            // Check if item already exists in target session
            $existingQuery = Cart::where('session_id', $targetSessionId)
                ->where('product_id', $firstItem->product_id)
                ->where('size', $firstItem->size)
                ->where('color', $firstItem->color)
                ->whereNull('user_id');
            if ($firstItem->customization_json === null) {
                $existingQuery->whereNull('customization_json');
            } else {
                $existingQuery->where('customization_json', $firstItem->customization_json);
            }
            $existing = $existingQuery->first();

            if ($existing) {
                // Update quantity
                $existing->quantity += $totalQuantity;
                $existing->save();
            } else {
                // Create new item
                Cart::create([
                    'session_id' => $targetSessionId,
                    'product_id' => $firstItem->product_id,
                    'quantity' => $totalQuantity,
                    'size' => $firstItem->size,
                    'color' => $firstItem->color,
                    'customization_json' => $firstItem->customization_json,
                    'customization_image' => $firstItem->customization_image,
                    'custom_unit_price' => $firstItem->custom_unit_price,
                ]);
            }

            // Delete old items
            foreach ($items as $item) {
                $item->delete();
            }
        }
    }

    /**
     * Row belongs to the requester if: (a) it has their user_id, or (b) it is a guest row for this browser's cart_session_id cookie.
     */
    private function cartItemAccessible(Request $request, Cart $cart): bool
    {
        $user = $request->user();

        if ($cart->user_id !== null) {
            return $user !== null && (int) $cart->user_id === (int) $user->id;
        }

        $cookieSessionId = $request->cookie('cart_session_id');

        return $cookieSessionId !== null
            && $cart->session_id !== null
            && $cart->session_id === $cookieSessionId;
    }

    private function storeCustomizationImage(?string $dataUrl): ?string
    {
        if ($dataUrl === null || $dataUrl === '') {
            return null;
        }
        if (!is_string($dataUrl) || !str_starts_with($dataUrl, 'data:image/')) {
            return null;
        }
        if (!preg_match('#^data:image/(png|jpeg|jpg);base64,(.+)$#i', $dataUrl, $m)) {
            return null;
        }
        $raw = base64_decode($m[2], true);
        if ($raw === false || strlen($raw) > 2_500_000) {
            return null;
        }
        $ext = strtolower($m[1]) === 'jpg' ? 'jpg' : 'png';
        $relative = 'customize/'.Str::uuid().'.'.$ext;
        Storage::disk('public')->put($relative, $raw);

        return $relative;
    }

    private function customizationSummaryLabel(string $json): string
    {
        $d = json_decode($json, true);
        if (!is_array($d)) {
            return 'Customized';
        }
        $parts = [];

        // Size
        if (!empty($d['size_name']) && is_string($d['size_name'])) {
            $parts[] = 'Size: ' . $d['size_name'];
        } elseif (isset($d['size_idx'])) {
            $parts[] = 'Size #'.((int) $d['size_idx'] + 1);
        }

        // Colors - show each part's color name from nested 'colors' object
        $colorParts = [];
        if (!empty($d['colors']) && is_array($d['colors'])) {
            $colorLabels = [
                'body' => 'Body',
                'lid_ring' => 'Cap',
                'straw' => 'Straw',
                'handle' => 'Handle',
                'bottom_base' => 'Base',
            ];
            foreach ($colorLabels as $key => $label) {
                if (!empty($d['colors'][$key]['name']) && is_string($d['colors'][$key]['name'])) {
                    $colorParts[] = $label . ': ' . $d['colors'][$key]['name'];
                }
            }
        }
        if (!empty($colorParts)) {
            $parts[] = implode(', ', $colorParts);
        } else {
            $parts[] = 'Custom colors';
        }

        // Engraving
        if (! empty($d['engraving']) && is_array($d['engraving'])) {
            $eg = $d['engraving'];
            $cn = isset($eg['category_name']) && is_string($eg['category_name']) ? trim($eg['category_name']) : '';
            $slug = isset($eg['category_slug']) && is_string($eg['category_slug']) ? trim($eg['category_slug']) : '';
            $line = $cn !== '' ? $cn : ($slug !== '' ? $slug : 'Engraving');
            if (! empty($eg['text']) && is_string($eg['text']) && trim($eg['text']) !== '') {
                $parts[] = $line.': "'.trim($eg['text']).'"';
            } elseif (! empty($eg['engraving_image']) && is_string($eg['engraving_image'])) {
                $parts[] = $line.' (uploaded image)';
            } elseif (! empty($eg['image_data']) && is_string($eg['image_data']) && str_starts_with(trim($eg['image_data']), 'data:image/')) {
                $parts[] = $line.' (uploaded image)';
            } else {
                $parts[] = $line;
            }
        } elseif (! empty($d['engraving_text']) && is_string($d['engraving_text'])) {
            $et = trim($d['engraving_text']);
            if ($et !== '') {
                $parts[] = 'Engraving: "'.$et.'"';
            }
        }

        return implode(' | ', $parts);
    }
}



