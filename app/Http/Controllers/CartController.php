<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId(Request $request)
    {
        if ($request->user()) {
            return null;
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
     * Show cart page
     */
    public function index(Request $request)
    {
        if ($request->user()) {
            $cartItems = Cart::with('product.category')
                ->where('user_id', $request->user()->id)
                ->get();
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
        }

        // Filter out items where product is null or deleted
        $cartItems = $cartItems->filter(function($item) {
            return $item->product !== null;
        })->values(); // Re-index the collection
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        // Calculate shipping (can be dynamic later)
        $shipping = 0; // Free shipping for now
        $total = $subtotal + $shipping;

        // Set cookie for guest users
        if (!$request->user() && $sessionId) {
            return response()
                ->view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'))
                ->cookie('cart_session_id', $sessionId, 60 * 24 * 30);
        }
        
        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
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

        // Group by product_id, size, and color to merge duplicates
        $grouped = $otherCarts->groupBy(function($item) {
            return $item->product_id . '|' . ($item->size ?? '') . '|' . ($item->color ?? '');
        });

        foreach ($grouped as $key => $items) {
            $totalQuantity = $items->sum('quantity');
            $firstItem = $items->first();

            // Skip if product is null
            if (!$firstItem->product) {
                // Delete items with null products
                foreach ($items as $item) {
                    $item->delete();
                }
                continue;
            }

            // Check if item already exists in target session
            $existing = Cart::where('session_id', $targetSessionId)
                ->where('product_id', $firstItem->product_id)
                ->where('size', $firstItem->size)
                ->where('color', $firstItem->color)
                ->whereNull('user_id')
                ->first();

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
                ]);
            }

            // Delete old items
            foreach ($items as $item) {
                $item->delete();
            }
        }
    }
}

