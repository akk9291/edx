<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\QuotaRequestAdminMail;
use App\Mail\QuotaRequestCustomerMail;
use App\Models\Product;
use App\Models\QuotaRequest;
use App\Models\QuotaRequestItem;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class QuotaListController extends Controller
{
    private const SESSION_KEY = 'edx_quota_list';

    public function index(Request $request): View
    {
        $lines = $this->sessionLines($request);
        
        $productIds = [];
        $pillowIds = [];
        foreach ($lines as $line) {
            $type = $line['type'] ?? 'product';
            if ($type === 'pillow_block') {
                $pillowIds[] = $line['product_id'];
            } else {
                $productIds[] = $line['product_id'];
            }
        }
        
        $products = collect();
        if (!empty($productIds)) {
            $products = Product::edxBearingsCatalog()
                ->where('is_active', true)
                ->whereIn('id', $productIds)
                ->with('category')
                ->get()
                ->keyBy(fn($p) => 'product_' . $p->id);
        }
        
        $pillowBlocks = collect();
        if (!empty($pillowIds)) {
            $pillowBlocks = \App\Models\PillowBlock::where('is_active', true)
                ->whereIn('id', $pillowIds)
                ->with('category')
                ->get()
                ->keyBy(fn($pb) => 'pillow_block_' . $pb->id);
        }

        $rows = [];
        foreach ($lines as $line) {
            $pid = (int) ($line['product_id'] ?? 0);
            $type = $line['type'] ?? 'product';
            $qty = max(1, (int) ($line['quantity'] ?? 1));
            
            $item = $type === 'pillow_block' 
                ? $pillowBlocks->get('pillow_block_' . $pid)
                : $products->get('product_' . $pid);
                
            $rows[] = [
                'product_id' => $pid,
                'product_type' => $type,
                'quantity' => $qty,
                'product' => $item,
            ];
        }

        $hasValidRows = collect($rows)->contains(fn ($r) => $r['product'] !== null);
        $hasStaleRows = collect($rows)->contains(fn ($r) => $r['product'] === null && $r['product_id'] > 0);
        $hasAnyLines = count($rows) > 0;

        return view('frontend.quota-list', compact('rows', 'hasValidRows', 'hasStaleRows', 'hasAnyLines'));
    }

    public function count(Request $request): JsonResponse
    {
        return response()->json([
            'count' => $this->distinctProductCount($request),
        ]);
    }

    /**
     * JSON payload for header quota modal (SKU, qty, links).
     */
    public function preview(Request $request): JsonResponse
    {
        $lines = $this->sessionLines($request);
        $excludeIds = [];
        $suggestions = $this->suggestionProductsForModal($excludeIds);

        if ($lines === []) {
            return response()->json([
                'empty' => true,
                'count' => 0,
                'items' => [],
                'suggestions' => $suggestions,
            ]);
        }

        $productIds = [];
        $pillowIds = [];
        foreach ($lines as $line) {
            $type = $line['type'] ?? 'product';
            if ($type === 'pillow_block') {
                $pillowIds[] = $line['product_id'];
            } else {
                $productIds[] = $line['product_id'];
            }
        }
        
        $products = collect();
        if (!empty($productIds)) {
            $products = Product::edxBearingsCatalog()
                ->where('is_active', true)
                ->whereIn('id', $productIds)
                ->with('category')
                ->get()
                ->keyBy(fn($p) => 'product_' . $p->id);
        }
        
        $pillowBlocks = collect();
        if (!empty($pillowIds)) {
            $pillowBlocks = \App\Models\PillowBlock::where('is_active', true)
                ->whereIn('id', $pillowIds)
                ->with('category')
                ->get()
                ->keyBy(fn($pb) => 'pillow_block_' . $pb->id);
        }

        $items = [];
        foreach ($lines as $line) {
            $pid = (int) ($line['product_id'] ?? 0);
            $type = $line['type'] ?? 'product';
            $qty = max(1, (int) ($line['quantity'] ?? 1));
            
            $item = $type === 'pillow_block' 
                ? $pillowBlocks->get('pillow_block_' . $pid)
                : $products->get('product_' . $pid);
                
            if (! $item) {
                continue;
            }
            $items[] = [
                'product_id' => $pid,
                'product_type' => $type,
                'quantity' => $qty,
                'sku' => $item->sku,
                'name' => $item->name,
                'slug' => $item->slug,
                'category' => $item->category->name ?? '',
                'image_url' => $item->image_url,
            ];
        }

        return response()->json([
            'empty' => $items === [],
            'count' => $this->distinctProductCount($request),
            'items' => $items,
            'suggestions' => $suggestions,
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|min:1',
            'quantity' => 'nullable|integer|min:1|max:99999',
            'product_type' => 'nullable|string|in:product,pillow_block',
        ]);

        $quantity = max(1, (int) ($validated['quantity'] ?? 1));
        $productId = (int) $validated['product_id'];
        $type = $validated['product_type'] ?? 'product';

        if (! $this->productAllowed($productId, $type)) {
            return response()->json(['ok' => false, 'message' => 'Product not found.'], 422);
        }

        $lines = $this->sessionLines($request);
        $found = false;
        foreach ($lines as &$line) {
            $lineType = $line['type'] ?? 'product';
            if ((int) $line['product_id'] === $productId && $lineType === $type) {
                $line['quantity'] = min(99999, (int) $line['quantity'] + $quantity);
                $found = true;
                break;
            }
        }
        unset($line);

        if (! $found) {
            $lines[] = ['product_id' => $productId, 'type' => $type, 'quantity' => $quantity];
        }

        $request->session()->put(self::SESSION_KEY, $lines);

        return response()->json([
            'ok' => true,
            'count' => $this->distinctProductCount($request),
            'message' => 'Added to your quota list.',
        ]);
    }

    public function updateLine(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|min:1',
            'product_type' => 'nullable|string|in:product,pillow_block',
            'quantity' => 'required|integer|min:1|max:99999',
        ]);

        $type = $validated['product_type'] ?? 'product';
        $lines = $this->sessionLines($request);
        $updated = false;
        foreach ($lines as &$line) {
            $lineType = $line['type'] ?? 'product';
            if ((int) $line['product_id'] === (int) $validated['product_id'] && $lineType === $type) {
                $line['quantity'] = (int) $validated['quantity'];
                $updated = true;
                break;
            }
        }
        unset($line);

        if (! $updated) {
            if ($request->wantsJson()) {
                return response()->json(['ok' => false, 'message' => 'Line not found.'], 404);
            }

            return back()->with('error', 'Line not found.');
        }

        $request->session()->put(self::SESSION_KEY, $lines);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'count' => $this->distinctProductCount($request)]);
        }

        return back()->with('success', 'Quantity updated.');
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|min:1',
            'product_type' => 'nullable|string|in:product,pillow_block',
        ]);

        $type = $validated['product_type'] ?? 'product';
        $lines = array_values(array_filter(
            $this->sessionLines($request),
            function ($line) use ($validated, $type) {
                $lineType = $line['type'] ?? 'product';
                return !((int) ($line['product_id'] ?? 0) === (int) $validated['product_id'] && $lineType === $type);
            }
        ));

        $request->session()->put(self::SESSION_KEY, $lines);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'count' => $this->distinctProductCount($request)]);
        }

        return back()->with('success', 'Removed from quota list.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_KEY);

        return back()->with('success', 'Your quota list was cleared.');
    }

    public function submit(Request $request): RedirectResponse
    {
        $lines = $this->sessionLines($request);
        if ($lines === []) {
            return back()->with('error', 'Your quota list is empty. Add products before submitting.');
        }

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:64',
            'message' => 'nullable|string|max:5000',
        ]);

        $productIds = [];
        $pillowIds = [];
        foreach ($lines as $line) {
            $type = $line['type'] ?? 'product';
            if ($type === 'pillow_block') {
                $pillowIds[] = $line['product_id'];
            } else {
                $productIds[] = $line['product_id'];
            }
        }
        
        $products = collect();
        if (!empty($productIds)) {
            $products = Product::edxBearingsCatalog()
                ->where('is_active', true)
                ->whereIn('id', $productIds)
                ->get()
                ->keyBy(fn($p) => 'product_' . $p->id);
        }
        
        $pillowBlocks = collect();
        if (!empty($pillowIds)) {
            $pillowBlocks = \App\Models\PillowBlock::where('is_active', true)
                ->whereIn('id', $pillowIds)
                ->get()
                ->keyBy(fn($pb) => 'pillow_block_' . $pb->id);
        }

        if ($products->isEmpty() && $pillowBlocks->isEmpty()) {
            return back()->with('error', 'No valid products in your list.');
        }

        $quotaRequest = QuotaRequest::create([
            'reference' => QuotaRequest::generateReference(),
            'company_name' => $validated['company_name'] ?? null,
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        $createdItems = 0;
        foreach ($lines as $line) {
            $pid = (int) ($line['product_id'] ?? 0);
            $type = $line['type'] ?? 'product';
            $qty = max(1, (int) ($line['quantity'] ?? 1));
            
            $item = $type === 'pillow_block' 
                ? $pillowBlocks->get('pillow_block_' . $pid)
                : $products->get('product_' . $pid);
                
            if (! $item) {
                continue;
            }
            QuotaRequestItem::create([
                'quota_request_id' => $quotaRequest->id,
                'product_id' => $type === 'pillow_block' ? null : $item->id,
                'quantity' => $qty,
                'product_sku' => $item->sku,
                'product_name' => $item->name,
            ]);
            $createdItems++;
        }

        if ($createdItems === 0) {
            $quotaRequest->delete();

            return back()->with('error', 'None of the products in your list are available anymore. Please add current products and try again.');
        }

        $quotaRequest->load('items');

        $customerEmail = $validated['email'];
        $adminEmail = Setting::get('contact_email') ?: config('mail.from.address');
        $adminOk = is_string($adminEmail) && filter_var($adminEmail, FILTER_VALIDATE_EMAIL);

        if ($adminOk && strcasecmp($adminEmail, $customerEmail) === 0) {
            try {
                Mail::to($adminEmail)->send(new QuotaRequestAdminMail($quotaRequest));
            } catch (\Throwable $e) {
                Log::warning('Quota request email failed', [
                    'reference' => $quotaRequest->reference,
                    'message' => $e->getMessage(),
                ]);
            }
        } else {
            try {
                Mail::to($customerEmail)->send(new QuotaRequestCustomerMail($quotaRequest));
            } catch (\Throwable $e) {
                Log::warning('Quota request customer email failed', [
                    'reference' => $quotaRequest->reference,
                    'message' => $e->getMessage(),
                ]);
            }
            if ($adminOk) {
                try {
                    Mail::to($adminEmail)->send(new QuotaRequestAdminMail($quotaRequest));
                } catch (\Throwable $e) {
                    Log::warning('Quota request admin email failed', [
                        'reference' => $quotaRequest->reference,
                        'message' => $e->getMessage(),
                    ]);
                }
            }
        }

        $request->session()->forget(self::SESSION_KEY);

        return redirect()
            ->route('frontend.quota-list.index')
            ->with('success', 'Your quota request '.$quotaRequest->reference.' was sent. Our team will contact you shortly.')
            ->with('quota_submitted', true)
            ->with('quota_reference', $quotaRequest->reference);
    }

    /**
     * @param  list<int>  $excludeProductIds
     * @return list<array{slug: string, sku: ?string, name: string, image_url: string}>
     */
    private function suggestionProductsForModal(array $excludeProductIds): array
    {
        $q = Product::edxBearingsCatalog()->where('is_active', true);
        if ($excludeProductIds !== []) {
            $q->whereNotIn('id', $excludeProductIds);
        }

        return $q->inRandomOrder()
            ->limit(6)
            ->get(['id', 'slug', 'sku', 'name'])
            ->map(fn (Product $p) => [
                'slug' => $p->slug,
                'sku' => $p->sku,
                'name' => $p->name,
                'image_url' => $p->image_url,
            ])
            ->values()
            ->all();
    }

    private function sessionLines(Request $request): array
    {
        $raw = $request->session()->get(self::SESSION_KEY, []);

        return is_array($raw) ? $raw : [];
    }

    private function distinctProductCount(Request $request): int
    {
        $ids = collect($this->sessionLines($request))->pluck('product_id')->unique()->filter();

        return $ids->count();
    }

    private function productAllowed(int $productId, string $type): bool
    {
        if ($type === 'pillow_block') {
            return \App\Models\PillowBlock::where('is_active', true)
                ->whereKey($productId)
                ->exists();
        }

        return Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->whereKey($productId)
            ->exists();
    }
}
