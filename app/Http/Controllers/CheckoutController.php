<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
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

    /**
     * Show checkout page
     */
    public function index(Request $request)
    {
        $query = Cart::with('product.category');

        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
            $addresses = Address::where('user_id', $request->user()->id)
                ->orderBy('is_default', 'desc')
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
            
            $query->where('session_id', $sessionId);
            $addresses = collect([]);
        }

        $cartItems = $query->get();
        
        // Filter out items where product is null or deleted
        $cartItems = $cartItems->filter(function($item) {
            return $item->product !== null;
        })->values(); // Re-index the collection
        
        // Don't redirect if cart is empty - let the page show empty state
        // This allows navigation to work properly
        // if ($cartItems->isEmpty()) {
        //     return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        // }

        $subtotal = $cartItems->sum(function($item) {
            return $item->subtotal;
        });

        $shipping = 0; // Can be calculated dynamically
        $total = $subtotal + $shipping;

        $sessionId = $this->getSessionId($request);
        
        // Get user data and default address for auto-fill
        $user = $request->user();
        $defaultAddress = null;
        $userFirstName = null;
        $userLastName = null;
        
        if ($user) {
            // Get first_name and last_name from user
            // If first_name is null, try to split from name field
            if ($user->first_name) {
                $userFirstName = $user->first_name;
            } elseif ($user->name) {
                $nameParts = explode(' ', $user->name, 2);
                $userFirstName = $nameParts[0] ?? '';
                $userLastName = $nameParts[1] ?? '';
            }
            
            if ($user->last_name) {
                $userLastName = $user->last_name;
            }
            
            // Get default address
            $defaultAddress = Address::where('user_id', $user->id)
                ->where('is_default', true)
                ->first();
            
            // If no default address, get the first address
            if (!$defaultAddress) {
                $defaultAddress = Address::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }
        }
        
        return response()
            ->view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'addresses', 'user', 'defaultAddress', 'userFirstName', 'userLastName'))
            ->cookie('cart_session_id', $sessionId, 60 * 24 * 30);
    }
}

