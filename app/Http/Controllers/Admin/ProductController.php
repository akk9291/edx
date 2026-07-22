<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use App\Services\BearingCatalogExportService;
use App\Services\BearingCatalogImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Sample CSV with header row + dummy data rows matching DGBB / SRB WordPress export shape (CRB uses the same bearing_* columns without the leading ID/Content columns).
     */
    public function bearingImportSample(): StreamedResponse
    {
        $header = 'ID,Title,Content,Excerpt,Post Type,Image URL,Image Title,Image Caption,Image Description,Image Alt Text,Image Featured,Attachment URL,Bearing Category,bearing_no,bore_diameter,outside_diameter,width,basic_dynamic_load_rating,basic_static_load_rating,limiting_speed_grease,limiting_speed_oil,number_of_rows,radial_internal_clearance,tolerance_class_for_dimensions,cage,bore_type,skf,fag,ntn,timken,suffix_name,suffix_desc,suffix,suffix_type,bearing_image,bearing_category,meta_title,meta_description,meta_keywords,mrp,sale_price';

        return response()->streamDownload(function () use ($header) {
            $out = fopen('php://output', 'w');
            if ($out === false) {
                return;
            }
            fwrite($out, "\xEF\xBB\xBF");

            $columns = explode(',', $header);
            fputcsv($out, $columns);

            $samples = [
                [
                    'ID' => '1',
                    'Title' => 'Deep Groove Ball Bearing 6000',
                    'Content' => '<p>Sample import row — replace with real HTML description.</p>',
                    'Excerpt' => 'Sample DGBB 6000 row for testing meta and pricing columns.',
                    'Post Type' => 'post',
                    'Image URL' => '',
                    'Image Title' => '',
                    'Image Caption' => '',
                    'Image Description' => '',
                    'Image Alt Text' => 'Deep Groove Ball Bearing 6000',
                    'Image Featured' => '',
                    'Attachment URL' => '',
                    'Bearing Category' => 'Deep Groove Ball Bearing',
                    'bearing_no' => '6000',
                    'bore_diameter' => '10',
                    'outside_diameter' => '26',
                    'width' => '8',
                    'basic_dynamic_load_rating' => '5.10',
                    'basic_static_load_rating' => '2.39',
                    'limiting_speed_grease' => '26000',
                    'limiting_speed_oil' => '30000',
                    'number_of_rows' => '1',
                    'radial_internal_clearance' => 'CN',
                    'tolerance_class_for_dimensions' => 'P6',
                    'cage' => 'Sheet Steel',
                    'bore_type' => 'Cylindrical',
                    'skf' => '6000',
                    'fag' => '',
                    'ntn' => '',
                    'timken' => '',
                    'suffix_name' => '',
                    'suffix_desc' => '',
                    'suffix' => '',
                    'suffix_type' => '',
                    'bearing_image' => '',
                    'bearing_category' => 'Deep Groove Ball Bearing',
                    'meta_title' => '6000 Deep Groove Ball Bearing | EDX sample',
                    'meta_description' => 'Sample meta description for SKU 6000 — edit before production import.',
                    'meta_keywords' => 'bearing,6000,deep groove,DGBB,EDX',
                    'mrp' => '500.00',
                    'sale_price' => '449.99',
                ],
                [
                    'ID' => '2',
                    'Title' => 'Angular Contact Ball Bearing 7204',
                    'Content' => '<p>Second sample row — Angular contact bearing.</p>',
                    'Excerpt' => 'Sample ACBB for catalog import.',
                    'Post Type' => 'post',
                    'Image URL' => '',
                    'Image Title' => '',
                    'Image Caption' => '',
                    'Image Description' => '',
                    'Image Alt Text' => 'Angular Contact Ball Bearing 7204',
                    'Image Featured' => '',
                    'Attachment URL' => '',
                    'Bearing Category' => 'Angular Contact Ball Bearing',
                    'bearing_no' => '7204-B-TVP',
                    'bore_diameter' => '20',
                    'outside_diameter' => '47',
                    'width' => '14',
                    'basic_dynamic_load_rating' => '14.0',
                    'basic_static_load_rating' => '9.40',
                    'limiting_speed_grease' => '18000',
                    'limiting_speed_oil' => '24000',
                    'number_of_rows' => '1',
                    'radial_internal_clearance' => 'CN',
                    'tolerance_class_for_dimensions' => 'P6',
                    'cage' => 'Sheet Steel',
                    'bore_type' => 'Cylindrical',
                    'skf' => '7204',
                    'fag' => '',
                    'ntn' => '',
                    'timken' => '',
                    'suffix_name' => '',
                    'suffix_desc' => '',
                    'suffix' => '',
                    'suffix_type' => '',
                    'bearing_image' => '',
                    'bearing_category' => 'Angular Contact Ball Bearing',
                    'meta_title' => '7204 Angular Contact Ball Bearing | EDX sample',
                    'meta_description' => 'Sample meta description for angular contact bearing 7204.',
                    'meta_keywords' => 'bearing,7204,angular contact,ACBB,EDX',
                    'mrp' => '1200.00',
                    'sale_price' => '1099.00',
                ],
            ];

            foreach ($samples as $assoc) {
                $line = array_map(static fn (string $col): string => $assoc[$col] ?? '', $columns);
                fputcsv($out, $line);
            }

            fclose($out);
        }, 'bearing-import-sample-dgbb.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function importBearings(Request $request, BearingCatalogImportService $importer)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:20480',
        ]);

        $result = $importer->import($request->file('import_file'));
        $message = sprintf(
            'Bearing import finished: %d created, %d updated, %d rows skipped.',
            $result['created'],
            $result['updated'],
            $result['skipped'],
        );

        if ($result['errors'] !== []) {
            return redirect()
                ->route('admin.products.index')
                ->with('warning', $message)
                ->with('import_errors', $result['errors']);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', $message);
    }

    public function exportBearings(Request $request, BearingCatalogExportService $exporter)
    {
        $request->validate([
            'format' => 'nullable|in:csv,xlsx',
        ]);

        $format = $request->get('format', 'csv');
        $query = $this->productsIndexQuery($request);

        return $format === 'xlsx'
            ? $exporter->downloadXlsx($query)
            : $exporter->downloadCsv($query);
    }

    /**
     * Base query for admin product list / export (search + status filters).
     */
    protected function productsIndexQuery(Request $request)
    {
        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productsIndexQuery($request)
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->forBearingsCatalog()
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categoryIdRules = ['nullable'];
        $bearingsMainId = MainCategory::bearingsCatalogId();
        if ($bearingsMainId) {
            $categoryIdRules[] = Rule::exists('categories', 'id')->where('main_category_id', $bearingsMainId);
        } else {
            $categoryIdRules[] = 'exists:categories,id';
        }

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:50000',
            'short_description' => 'nullable|string|max:500',
            'category_id' => $categoryIdRules,
            'sku' => 'nullable|string|unique:products,sku',
            'in_stock' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:51200',
            'sort_order' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'meta_keywords' => 'nullable|string|max:1000',
            'bearing_specs' => 'nullable|array',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:2000',
        ];
        foreach (Product::bearingStructuredSpecKeys() as $key) {
            $rules['bearing_specs.'.$key] = 'nullable|string|max:2000';
        }
        $rules['bearing_specs.suffix_pairs'] = 'nullable|array|max:50';
        $rules['bearing_specs.suffix_pairs.*.suffix'] = 'nullable|string|max:500';
        $rules['bearing_specs.suffix_pairs.*.description'] = 'nullable|string|max:2000';

        $validated = $request->validate($rules);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sizes'] = [];
        $validated['colors'] = [];
        $validated['stock_quantity'] = 0;
        $validated['in_stock'] = false;
        $validated['price'] = $request->filled('price') ? (float) $request->input('price') : 0;
        $validated['sale_price'] = $request->filled('sale_price') ? (float) $request->input('sale_price') : null;

        unset($validated['specifications'], $validated['bearing_specs']);
        $mergedSpecs = $this->specificationsFromBearingAndExtraForms($request);
        $validated['specifications'] = $mergedSpecs !== [] ? $mergedSpecs : null;

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle gallery images (multiple)
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryPaths[] = $file->store('products/gallery', 'public');
            }
        }
        if (! empty($galleryPaths)) {
            $validated['images'] = $galleryPaths;
        }

        // Handle product video
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('products/videos', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->forBearingsCatalog()
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $categoryIdRules = ['nullable'];
        $bearingsMainId = MainCategory::bearingsCatalogId();
        if ($bearingsMainId) {
            $categoryIdRules[] = Rule::exists('categories', 'id')->where('main_category_id', $bearingsMainId);
        } else {
            $categoryIdRules[] = 'exists:categories,id';
        }

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:50000',
            'short_description' => 'nullable|string|max:500',
            'category_id' => $categoryIdRules,
            'sku' => ['nullable', 'string', Rule::unique('products', 'sku')->ignore($product->id)],
            'in_stock' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:51200',
            'sort_order' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:5000',
            'meta_keywords' => 'nullable|string|max:1000',
            'bearing_specs' => 'nullable|array',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:255',
            'specifications.*.value' => 'nullable|string|max:2000',
        ];
        foreach (Product::bearingStructuredSpecKeys() as $key) {
            $rules['bearing_specs.'.$key] = 'nullable|string|max:2000';
        }
        $rules['bearing_specs.suffix_pairs'] = 'nullable|array|max:50';
        $rules['bearing_specs.suffix_pairs.*.suffix'] = 'nullable|string|max:500';
        $rules['bearing_specs.suffix_pairs.*.description'] = 'nullable|string|max:2000';

        $validated = $request->validate($rules);

        $validated['price'] = $request->filled('price') ? (float) $request->input('price') : 0;
        $validated['sale_price'] = $request->filled('sale_price') ? (float) $request->input('sale_price') : null;

        unset($validated['specifications'], $validated['bearing_specs']);
        $mergedSpecs = $this->specificationsFromBearingAndExtraForms($request);
        if (is_array($mergedSpecs)) {
            $mergedSpecs = $this->preserveImportedSuffixScalars($product, $mergedSpecs);
        }
        $validated['specifications'] = $mergedSpecs !== [] ? $mergedSpecs : null;

        // Update slug if name changed
        if ($validated['name'] != $product->name) {
            $validated['slug'] = Str::slug($validated['name']);

            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                $validated['slug'] = $originalSlug.'-'.$counter;
                $counter++;
            }
        }

        // Handle remove_image
        if ($request->filled('remove_image') && $request->remove_image == '1') {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                $validated['image'] = null;
            }
        } elseif ($request->hasFile('image')) {
            // Delete old image when uploading new one
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle remove_gallery_images
        $removeGalleryPaths = $request->input('remove_gallery_images', []);
        if (! is_array($removeGalleryPaths)) {
            $removeGalleryPaths = array_filter([$removeGalleryPaths]);
        }
        $existingImages = is_array($product->images) ? $product->images : [];
        if (! empty($removeGalleryPaths)) {
            foreach ($removeGalleryPaths as $path) {
                if (in_array($path, $existingImages)) {
                    Storage::disk('public')->delete($path);
                    $existingImages = array_values(array_filter($existingImages, fn ($img) => $img !== $path));
                }
            }
        }

        // Handle gallery images (append to existing list)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $existingImages[] = $file->store('products/gallery', 'public');
            }
        }
        if (isset($existingImages)) {
            $validated['images'] = array_values(array_unique($existingImages));
        }

        // Handle remove_video
        if ($request->filled('remove_video') && $request->remove_video == '1') {
            if ($product->video) {
                Storage::disk('public')->delete($product->video);
                $validated['video'] = null;
            }
        } elseif ($request->hasFile('video')) {
            if ($product->video) {
                Storage::disk('public')->delete($product->video);
            }
            $validated['video'] = $request->file('video')->store('products/videos', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete gallery images if exist
        if (is_array($product->images)) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        // Delete video if exists
        if ($product->video) {
            Storage::disk('public')->delete($product->video);
        }

        // Remove from cart and wishlist (cart is DB; wishlist is localStorage - cleaned on next visit)
        Cart::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Merge `bearing_specs[*]` with optional extra `specifications[n][key|value]` rows (extra keys must not duplicate structured keys).
     *
     * @return array<string, string>
     */
    protected function specificationsFromBearingAndExtraForms(Request $request): array
    {
        $out = [];
        $input = $request->input('bearing_specs', []);
        if (! is_array($input)) {
            $input = [];
        }
        foreach (Product::bearingStructuredSpecKeys() as $key) {
            if (! array_key_exists($key, $input)) {
                continue;
            }
            $v = $input[$key];
            if (is_string($v)) {
                $v = trim($v);
            } elseif (is_numeric($v)) {
                $v = trim((string) $v);
            } else {
                continue;
            }
            if ($v !== '') {
                $out[$key] = $v;
            }
        }

        $suffixPairsIn = $input['suffix_pairs'] ?? [];
        if (is_array($suffixPairsIn)) {
            $clean = [];
            foreach ($suffixPairsIn as $row) {
                if (! is_array($row)) {
                    continue;
                }
                $s = trim((string) ($row['suffix'] ?? ''));
                $d = trim((string) ($row['description'] ?? ''));
                if ($s === '' && $d === '') {
                    continue;
                }
                $clean[] = [
                    'suffix' => $s !== '' ? $s : '—',
                    'description' => $d,
                ];
            }
            if ($clean !== []) {
                $out['suffix_pairs'] = $clean;
            }
        }

        $reserved = array_flip(array_merge(Product::bearingStructuredSpecKeys(), ['suffix_pairs']));
        if ($request->has('specifications') && is_array($request->specifications)) {
            foreach ($request->specifications as $spec) {
                if (! is_array($spec)) {
                    continue;
                }
                $k = isset($spec['key']) ? trim((string) $spec['key']) : '';
                $v = isset($spec['value']) ? trim((string) $spec['value']) : '';
                if ($k === '' || $v === '') {
                    continue;
                }
                if (isset($reserved[$k])) {
                    continue;
                }
                $out[$k] = $v;
            }
        }

        return $out;
    }

    /**
     * Keep CSV-imported single suffix fields when the admin form no longer posts them.
     *
     * @param  array<string, mixed>  $mergedSpecs
     * @return array<string, mixed>
     */
    protected function preserveImportedSuffixScalars(Product $product, array $mergedSpecs): array
    {
        $prev = $product->specifications;
        if (! is_array($prev)) {
            return $mergedSpecs;
        }
        foreach (['suffix', 'suffix_name', 'suffix_desc', 'suffix_type'] as $k) {
            if (! array_key_exists($k, $mergedSpecs) && array_key_exists($k, $prev) && is_scalar($prev[$k])) {
                $mergedSpecs[$k] = $prev[$k];
            }
        }

        return $mergedSpecs;
    }

    /**
     * Bulk update products from database mode.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.name' => 'nullable|string|max:255',
            'products.*.slug' => 'nullable|string|max:255',
            'products.*.sku' => 'nullable|string',
            'products.*.price' => 'nullable|numeric|min:0',
            'products.*.sale_price' => 'nullable|numeric|min:0',
            'products.*.stock_quantity' => 'nullable|integer|min:0',
            'products.*.in_stock' => 'nullable|boolean',
            'products.*.is_active' => 'nullable|boolean',
            'products.*.is_featured' => 'nullable|boolean',
            'products.*.is_new_arrival' => 'nullable|boolean',
            'products.*.category_id' => 'nullable|integer|exists:categories,id',
            'products.*.sort_order' => 'nullable|integer|min:0',
            'products.*.description' => 'nullable|string|max:50000',
            'products.*.short_description' => 'nullable|string|max:500',
            'products.*.meta_title' => 'nullable|string|max:255',
            'products.*.meta_description' => 'nullable|string|max:5000',
            'products.*.meta_keywords' => 'nullable|string|max:1000',
            'products.*.product_type' => 'nullable|string|max:255',
        ]);

        $products = $request->input('products', []);
        $updated = 0;
        $errors = [];

        foreach ($products as $productData) {
            try {
                $product = Product::findOrFail($productData['id']);
                
                // Build update data, only including fields that are present
                $updateData = [];
                $allowedFields = [
                    'name', 'slug', 'sku', 'price', 'sale_price', 'stock_quantity',
                    'in_stock', 'is_active', 'is_featured', 'is_new_arrival',
                    'category_id', 'sort_order', 'description', 'short_description',
                    'meta_title', 'meta_description', 'meta_keywords', 'product_type'
                ];

                foreach ($allowedFields as $field) {
                    if (array_key_exists($field, $productData)) {
                        $updateData[$field] = $productData[$field];
                    }
                }

                if (! empty($updateData)) {
                    $product->update($updateData);
                    $updated++;
                }
            } catch (\Exception $e) {
                $errors[] = "Product ID {$productData['id']}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'updated' => $updated,
            'errors' => $errors,
            'message' => "Successfully updated {$updated} product(s)." . ($errors ? ' Some errors occurred.' : ''),
        ]);
    }
}
