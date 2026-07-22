<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Get product inventory
     */
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $inventories = Inventory::where('product_id', $productId)
            ->orderBy('color')
            ->orderBy('size')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'inventories' => $inventories,
            ],
        ]);
    }

    /**
     * Update product inventory
     */
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'inventories' => 'required|array',
            'inventories.*.color' => 'nullable|string',
            'inventories.*.size' => 'nullable|string',
            'inventories.*.quantity' => 'required|integer|min:0',
            'inventories.*.initial_quantity' => 'nullable|integer|min:0',
        ]);

        // Delete existing inventories
        Inventory::where('product_id', $productId)->delete();

        // Create new inventories
        foreach ($request->inventories as $inventoryData) {
            $initialQuantity = $inventoryData['initial_quantity'] ?? $inventoryData['quantity'];
            
            Inventory::create([
                'product_id' => $productId,
                'color' => $inventoryData['color'] ?? null,
                'size' => $inventoryData['size'] ?? null,
                'quantity' => $inventoryData['quantity'],
                'initial_quantity' => $initialQuantity,
                'sold_quantity' => 0,
            ]);
        }

        // Update product total stock
        $totalStock = Inventory::where('product_id', $productId)->sum('quantity');
        $product->stock = $totalStock;
        $product->save();

        $inventories = Inventory::where('product_id', $productId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Inventory updated successfully',
            'data' => $inventories,
        ]);
    }

    /**
     * Get total stock for product
     */
    public function totalStock($productId)
    {
        $totalStock = Inventory::where('product_id', $productId)->sum('quantity');
        $totalSold = Inventory::where('product_id', $productId)->sum('sold_quantity');
        $totalInitial = Inventory::where('product_id', $productId)->sum('initial_quantity');

        return response()->json([
            'success' => true,
            'data' => [
                'total_stock' => $totalStock,
                'total_sold' => $totalSold,
                'total_initial' => $totalInitial,
                'available' => $totalStock - $totalSold,
            ],
        ]);
    }

    /**
     * Delete inventory entry
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $productId = $inventory->product_id;
        
        $inventory->delete();

        // Update product total stock
        $product = Product::find($productId);
        if ($product) {
            $totalStock = Inventory::where('product_id', $productId)->sum('quantity');
            $product->stock = $totalStock;
            $product->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Inventory entry deleted successfully',
        ]);
    }
}




