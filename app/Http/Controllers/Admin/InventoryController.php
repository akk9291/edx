<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Product inventory list: search and latest first
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($qry) use ($search) {
                $qry->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $products = $query->get();

        return view('admin.inventory.index', compact('products'));
    }

    /**
     * Add new inventory entry for a product
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'color' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
            'initial_quantity' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $color = $request->filled('color') && trim($request->color) !== '' ? trim($request->color) : null;
        $size = $request->filled('size') && trim($request->size) !== '' ? trim($request->size) : null;
        $quantityToAdd = (int) $validated['initial_quantity'];

        $inventory = Inventory::firstOrNew([
            'product_id' => $product->id,
            'color' => $color,
            'size' => $size,
        ]);

        $wasExisting = $inventory->exists;
        if (!$inventory->exists) {
            $inventory->initial_quantity = $quantityToAdd;
            $inventory->sold_quantity = 0;
            $inventory->quantity = $quantityToAdd;
        } else {
            $inventory->initial_quantity = ($inventory->initial_quantity ?? 0) + $quantityToAdd;
            $inventory->quantity = max(0, $inventory->initial_quantity - ($inventory->sold_quantity ?? 0));
        }

        if ($request->filled('price') && is_numeric($request->price)) {
            $inventory->price = $request->price;
        }
        if ($request->filled('sale_price') && is_numeric($request->sale_price)) {
            $inventory->sale_price = $request->sale_price;
        }

        $uploadedPaths = $this->storeInventoryImages($request, null);
        if (!empty($uploadedPaths)) {
            $existing = is_array($inventory->images) ? $inventory->images : ($inventory->image ? [$inventory->image] : []);
            $inventory->images = array_values(array_merge($existing, $uploadedPaths));
            $inventory->image = $inventory->images[0] ?? null;
        }

        $inventory->save();
        $this->syncProductStock($product);

        $message = $wasExisting
            ? "Added {$quantityToAdd} units to existing inventory. Total initial stock is now {$inventory->initial_quantity}."
            : 'Inventory added successfully.';

        return redirect()->route('admin.inventory.product', $product->id)
            ->with('success', $message);
    }

    /**
     * Update an inventory entry
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $product = $inventory->product;

        $validated = $request->validate([
            'color' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $inventory->color = $request->filled('color') ? trim($request->color) : null;
        $inventory->size = $request->filled('size') ? trim($request->size) : null;
        $inventory->quantity = (int) $validated['quantity'];
        $inventory->price = $request->filled('price') ? $request->price : null;
        $inventory->sale_price = $request->filled('sale_price') ? $request->sale_price : null;

        if ($request->filled('remove_image') && $request->remove_image == '1') {
            $this->deleteInventoryImages($inventory);
            $inventory->image = null;
            $inventory->images = null;
        } else {
            $uploadedPaths = $this->storeInventoryImages($request, null);
            if (!empty($uploadedPaths)) {
                $existing = is_array($inventory->images) ? $inventory->images : ($inventory->image ? [$inventory->image] : []);
                $inventory->images = array_values(array_merge($existing, $uploadedPaths));
                $inventory->image = $inventory->images[0] ?? null;
            }
        }

        $inventory->save();
        $this->syncProductStock($product);

        return redirect()->route('admin.inventory.product', $product->id)
            ->with('success', 'Inventory updated successfully.');
    }

    /**
     * Delete an inventory entry
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $productId = $inventory->product_id;
        $this->deleteInventoryImages($inventory);
        $inventory->delete();

        $product = Product::find($productId);
        if ($product) {
            $this->syncProductStock($product);
        }

        return redirect()->route('admin.inventory.product', $productId)
            ->with('success', 'Inventory entry deleted.');
    }

    /**
     * Bulk add inventory entries (Bihari-Ji-Collection style)
     */
    public function bulkStore(Request $request, $productId)
    {
        $request->validate([
            'items' => 'required|array|max:100',
            'items.*.color' => 'nullable|string|max:255',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.quantity' => 'nullable|integer|min:0',
            'items.*.price' => 'nullable|numeric|min:0',
            'items.*.sale_price' => 'nullable|numeric|min:0',
            'items.*.image' => 'nullable|image|max:2048',
            'items.*.images' => 'nullable|array',
            'items.*.images.*' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($productId);
        $successCount = 0;
        $rawItems = $request->input('items', []);

        $items = [];
        foreach ($rawItems as $index => $item) {
            $q = (int) ($item['quantity'] ?? 0);
            if ($q > 0) {
                $items[] = ['index' => $index, 'data' => $item];
            }
        }
        if (empty($items)) {
            return redirect()->route('admin.inventory.product', $productId)
                ->with('error', 'Add at least one row with quantity greater than 0.');
        }

        DB::beginTransaction();
        try {
            foreach ($items as $entry) {
                $index = $entry['index'];
                $item = $entry['data'];
                $color = !empty($item['color']) && trim($item['color']) !== '' ? trim($item['color']) : null;
                $size = !empty($item['size']) && trim($item['size']) !== '' ? trim($item['size']) : null;
                $quantity = (int) ($item['quantity'] ?? 0);

                $inventory = Inventory::firstOrNew([
                    'product_id' => $product->id,
                    'color' => $color,
                    'size' => $size,
                ]);

                if (!$inventory->exists) {
                    $inventory->initial_quantity = $quantity;
                    $inventory->sold_quantity = 0;
                    $inventory->quantity = $quantity;
                } else {
                    $inventory->initial_quantity = ($inventory->initial_quantity ?? 0) + $quantity;
                    $inventory->quantity = max(0, $inventory->initial_quantity - ($inventory->sold_quantity ?? 0));
                }

                if (isset($item['price']) && is_numeric($item['price'])) {
                    $inventory->price = $item['price'];
                }
                if (isset($item['sale_price']) && is_numeric($item['sale_price'])) {
                    $inventory->sale_price = $item['sale_price'];
                }

                $uploadedPaths = $this->storeInventoryImages($request, $index);
                if (!empty($uploadedPaths)) {
                    $existing = is_array($inventory->images) ? $inventory->images : [];
                    $inventory->images = array_values(array_merge($existing, $uploadedPaths));
                    $inventory->image = $inventory->images[0] ?? null;
                }

                $inventory->save();
                $successCount++;
            }

            $this->syncProductStock($product);
            DB::commit();

            return redirect()->route('admin.inventory.product', $product->id)
                ->with('success', "Bulk add completed: {$successCount} inventory entries added/updated.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.inventory.product', $product->id)
                ->with('error', 'Bulk add failed: ' . $e->getMessage());
        }
    }

    /**
     * Store uploaded images from request. Returns array of stored paths.
     * @param Request $request
     * @param int|null $bulkIndex If set, read from items.$bulkIndex.image and items.$bulkIndex.images
     */
    private function storeInventoryImages(Request $request, ?int $bulkIndex = null): array
    {
        $paths = [];
        if ($bulkIndex !== null) {
            $single = $request->file("items.{$bulkIndex}.image");
            if ($single && $single->isValid()) {
                $paths[] = $single->store('products/inventory', 'public');
            }
            $files = $request->file("items.{$bulkIndex}.images");
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $paths[] = $file->store('products/inventory', 'public');
                    }
                }
            }
        } else {
            $single = $request->file('image');
            if ($single && $single->isValid()) {
                $paths[] = $single->store('products/inventory', 'public');
            }
            $files = $request->file('images');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $paths[] = $file->store('products/inventory', 'public');
                    }
                }
            }
        }
        return $paths;
    }

    private function deleteInventoryImages(Inventory $inventory): void
    {
        if ($inventory->image) {
            Storage::disk('public')->delete($inventory->image);
        }
        if (is_array($inventory->images)) {
            foreach ($inventory->images as $path) {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }

    private function syncProductStock(Product $product): void
    {
        $total = $product->inventories()->sum('quantity');
        $product->update([
            'stock_quantity' => $total,
            'in_stock' => $total > 0,
        ]);
        $this->syncProductPriceFromInventories($product);
    }

    /**
     * Sync product price and sale_price from inventory entries (first with price, or min price)
     */
    private function syncProductPriceFromInventories(Product $product): void
    {
        $inventories = $product->inventories()->whereNotNull('price')->where('price', '>', 0)->orderBy('price')->get();
        if ($inventories->isEmpty()) {
            $product->update(['price' => 0, 'sale_price' => null]);
            return;
        }
        $first = $inventories->first();
        $price = (float) $first->price;
        $salePrice = $first->sale_price !== null && $first->sale_price > 0 ? (float) $first->sale_price : null;
        $product->update(['price' => $price, 'sale_price' => $salePrice]);
    }
}
