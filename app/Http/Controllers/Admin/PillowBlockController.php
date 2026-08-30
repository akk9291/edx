<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePillowBlockRequest;
use App\Http\Requests\Admin\UpdatePillowBlockRequest;
use App\Models\Category;
use App\Models\PillowBlock;
use App\Models\PillowBlockImage;
use App\Services\PillowBlockCatalogExportService;
use App\Services\PillowBlockCatalogImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PillowBlockController extends Controller
{
    /**
     * Download the exact Pillow Block sample template matching the client's Excel format.
     */
    public function importSample(): StreamedResponse
    {
        $filename = 'pillow-block-import-sample.xlsx';

        return response()->streamDownload(function () {
            $spreadsheet = new Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();
            
            // Write standard client template headers
            $sheet->fromArray([PillowBlockCatalogExportService::HEADER_ROW_1], null, 'A1');
            $sheet->fromArray([PillowBlockCatalogExportService::HEADER_ROW_2], null, 'A2');

            // Insert sample rows
            $samples = [
                [
                    'Bearing number' => 'UCP201',
                    'd ( inch and mm)' => '12 mm',
                    'd' => '12',
                    'h' => '30.2',
                    'a' => '127',
                    'e' => '95',
                    'b' => '38',
                    'S2' => '16',
                    'S1' => '13',
                    'g' => '14',
                    'w' => '62',
                    'Bi' => '31',
                    'n' => '12.7',
                    'bearing no.' => 'UC 201',
                    'Housing No.' => 'P201',
                    'Weight' => '0.63',
                    'J7' => '6500',
                    'h7' => '5000',
                    'h8' => '3800',
                    'h9' => '1400',
                    // Optional columns
                    'name' => 'Pillow Block UCP201',
                    'sku' => 'UCP201',
                    'category_id' => '',
                    'brand' => 'EDX',
                    'short_description' => 'Premium Pillow Block UCP201 bearing unit.',
                    'description' => '<p>Detailed description for Pillow Block UCP201.</p>',
                    'price' => '850.00',
                    'sale_price' => '799.99',
                    'image_url' => '',
                    'video' => '',
                    'pdf_catalogue' => '',
                    'meta_title' => 'UCP201 Pillow Block Bearing Unit | EDX',
                    'meta_description' => 'Buy premium UCP201 Pillow Block bearing unit online.',
                    'meta_keywords' => 'pillow block,ucp201,bearing,edx',
                    'is_active' => '1'
                ],
                [
                    'Bearing number' => 'UCP201-8',
                    'd ( inch and mm)' => '1/2 inch',
                    'd' => '12',
                    'h' => '30.2',
                    'a' => '127',
                    'e' => '95',
                    'b' => '38',
                    'S2' => '16',
                    'S1' => '13',
                    'g' => '14',
                    'w' => '62',
                    'Bi' => '31',
                    'n' => '12.7',
                    'bearing no.' => 'UC 201-8',
                    'Housing No.' => 'P201',
                    'Weight' => '0.63',
                    'J7' => '6500',
                    'h7' => '5000',
                    'h8' => '3800',
                    'h9' => '1400',
                    // Optional columns
                    'name' => 'Pillow Block UCP201-8',
                    'sku' => 'UCP201-8',
                    'category_id' => '',
                    'brand' => 'EDX',
                    'short_description' => 'Premium Pillow Block UCP201-8 bearing unit.',
                    'description' => '<p>Detailed description for Pillow Block UCP201-8.</p>',
                    'price' => '900.00',
                    'sale_price' => '849.99',
                    'image_url' => '',
                    'video' => '',
                    'pdf_catalogue' => '',
                    'meta_title' => 'UCP201-8 Pillow Block Bearing Unit | EDX',
                    'meta_description' => 'Buy premium UCP201-8 Pillow Block bearing unit online.',
                    'meta_keywords' => 'pillow block,ucp201-8,bearing,edx',
                    'is_active' => '1'
                ]
            ];

            $rowIndex = 3;
            foreach ($samples as $assoc) {
                $line = array_map(static fn (string $col): string => $assoc[$col] ?? '', PillowBlockCatalogExportService::HEADER_ROW_2);
                $sheet->fromArray([$line], null, 'A'.$rowIndex);
                $rowIndex++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Import Pillow Blocks spreadsheet (CSV / XLSX / XLS).
     */
    public function import(Request $request, PillowBlockCatalogImportService $importer)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:20480',
            'duplicate_action' => 'required|in:skip,update',
        ]);

        $result = $importer->import($request->file('import_file'), $request->input('duplicate_action'));
        
        $message = sprintf(
            'Pillow Block import finished: %d created, %d updated, %d rows skipped.',
            $result['created'],
            $result['updated'],
            $result['skipped']
        );

        if ($result['errors'] !== []) {
            return redirect()
                ->route('admin.pillow-block.index')
                ->with('warning', $message)
                ->with('import_errors', $result['errors']);
        }

        return redirect()
            ->route('admin.pillow-block.index')
            ->with('success', $message);
    }

    protected function pillowBlocksIndexQuery(Request $request)
    {
        $query = PillowBlock::query()->with('category');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('bearing_number', 'like', "%{$search}%")
                    ->orWhere('specifications', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        return $query;
    }

    /**
     * Export Pillow Blocks.
     */
    public function export(Request $request, PillowBlockCatalogExportService $exporter)
    {
        $request->validate([
            'format' => 'nullable|in:csv,xlsx',
            'scope' => 'nullable|in:all,active,inactive,featured,selected',
            'selected_ids' => 'nullable|string',
        ]);

        $format = $request->get('format', 'xlsx');
        $scope = $request->get('scope', 'all');

        $query = $this->pillowBlocksIndexQuery($request);

        if ($scope === 'active') {
            $query->where('is_active', true);
        } elseif ($scope === 'inactive') {
            $query->where('is_active', false);
        } elseif ($scope === 'featured') {
            $query->where('is_featured', true);
        } elseif ($scope === 'selected' && $request->filled('selected_ids')) {
            $ids = array_filter(explode(',', $request->input('selected_ids')));
            $query->whereIn('id', $ids);
        }

        return $format === 'xlsx'
            ? $exporter->downloadXlsx($query)
            : $exporter->downloadCsv($query);
    }

    public function index(Request $request)
    {
        $query = $this->pillowBlocksIndexQuery($request);

        $perPage = $request->get('per_page', 15);
        if ($perPage === 'all') {
            $perPage = (clone $query)->count() ?: 15;
        } else {
            $perPage = (int) $perPage;
        }

        $pillowBlocks = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.pillow-block.index', compact('pillowBlocks', 'categories'));
    }

    /**
     * Show form to create new Pillow Block.
     */
    public function create()
    {
        // Get categories, prioritizing the seeded Pillow Block category
        $categories = Category::query()
            ->where('is_active', true)
            ->orderByRaw("slug = 'pillow-block' desc")
            ->orderBy('name')
            ->get();

        return view('admin.pillow-block.create', compact('categories'));
    }

    /**
     * Store new Pillow Block.
     */
    public function store(StorePillowBlockRequest $request)
    {
        $validated = $request->validated();
        
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (PillowBlock::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle uploads
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pillow-blocks', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('pillow-blocks/videos', 'public');
        }

        if ($request->hasFile('pdf_catalogue')) {
            $validated['pdf_catalogue'] = $request->file('pdf_catalogue')->store('pillow-blocks/catalogues', 'public');
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryImages[] = $file->store('pillow-blocks/gallery', 'public');
            }
        }

        DB::transaction(function () use ($validated, $galleryImages) {
            $pb = PillowBlock::create($validated);

            foreach ($galleryImages as $path) {
                PillowBlockImage::create([
                    'pillow_block_id' => $pb->id,
                    'image_path' => $path,
                ]);
            }
        });

        return redirect()->route('admin.pillow-block.index')
            ->with('success', 'Pillow Block created successfully.');
    }

    /**
     * Display a Pillow Block.
     */
    public function show(PillowBlock $pillowBlock)
    {
        $pillowBlock->load(['category', 'galleryImages']);
        return view('admin.pillow-block.show', compact('pillowBlock'));
    }

    /**
     * Show edit form.
     */
    public function edit(PillowBlock $pillowBlock)
    {
        $pillowBlock->load(['category', 'galleryImages']);
        
        $categories = Category::query()
            ->where('is_active', true)
            ->orderByRaw("slug = 'pillow-block' desc")
            ->orderBy('name')
            ->get();

        return view('admin.pillow-block.edit', compact('pillowBlock', 'categories'));
    }

    /**
     * Update Pillow Block.
     */
    public function update(UpdatePillowBlockRequest $request, PillowBlock $pillowBlock)
    {
        $validated = $request->validated();

        if ($validated['name'] !== $pillowBlock->name) {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (PillowBlock::where('slug', $validated['slug'])->where('id', '!=', $pillowBlock->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle featured image removal / upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($pillowBlock->image && Storage::disk('public')->exists($pillowBlock->image)) {
                Storage::disk('public')->delete($pillowBlock->image);
            }
            $validated['image'] = $request->file('image')->store('pillow-blocks', 'public');
        } elseif ($request->filled('remove_image') && $request->remove_image == '1') {
            if ($pillowBlock->image && Storage::disk('public')->exists($pillowBlock->image)) {
                Storage::disk('public')->delete($pillowBlock->image);
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        // Handle video removal / upload
        if ($request->filled('remove_video') && $request->remove_video == '1') {
            if ($pillowBlock->video) {
                Storage::disk('public')->delete($pillowBlock->video);
                $validated['video'] = null;
            }
        } elseif ($request->hasFile('video')) {
            if ($pillowBlock->video) {
                Storage::disk('public')->delete($pillowBlock->video);
            }
            $validated['video'] = $request->file('video')->store('pillow-blocks/videos', 'public');
        }

        // Handle PDF catalogue removal / upload
        if ($request->filled('remove_pdf_catalogue') && $request->remove_pdf_catalogue == '1') {
            if ($pillowBlock->pdf_catalogue) {
                Storage::disk('public')->delete($pillowBlock->pdf_catalogue);
                $validated['pdf_catalogue'] = null;
            }
        } elseif ($request->hasFile('pdf_catalogue')) {
            if ($pillowBlock->pdf_catalogue) {
                Storage::disk('public')->delete($pillowBlock->pdf_catalogue);
            }
            $validated['pdf_catalogue'] = $request->file('pdf_catalogue')->store('pillow-blocks/catalogues', 'public');
        }

        // Handle gallery images removal
        $removeGalleryPaths = $request->input('remove_gallery_images', []);
        if (! is_array($removeGalleryPaths)) {
            $removeGalleryPaths = array_filter([$removeGalleryPaths]);
        }
        foreach ($removeGalleryPaths as $path) {
            $galleryImg = PillowBlockImage::where('pillow_block_id', $pillowBlock->id)
                ->where('image_path', $path)
                ->first();
            if ($galleryImg) {
                Storage::disk('public')->delete($path);
                $galleryImg->delete();
            }
        }

        // Handle new gallery images upload
        $newGalleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $newGalleryPaths[] = $file->store('pillow-blocks/gallery', 'public');
            }
        }

        DB::transaction(function () use ($pillowBlock, $validated, $newGalleryPaths) {
            $pillowBlock->update($validated);

            foreach ($newGalleryPaths as $path) {
                PillowBlockImage::create([
                    'pillow_block_id' => $pillowBlock->id,
                    'image_path' => $path,
                ]);
            }
        });

        return redirect()->route('admin.pillow-block.index')
            ->with('success', 'Pillow Block updated successfully.');
    }

    /**
     * Delete Pillow Block.
     */
    public function destroy(PillowBlock $pillowBlock)
    {
        // Delete media
        if ($pillowBlock->image) {
            Storage::disk('public')->delete($pillowBlock->image);
        }
        if ($pillowBlock->video) {
            Storage::disk('public')->delete($pillowBlock->video);
        }
        if ($pillowBlock->pdf_catalogue) {
            Storage::disk('public')->delete($pillowBlock->pdf_catalogue);
        }

        // Delete gallery images
        foreach ($pillowBlock->galleryImages as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $pillowBlock->delete();

        return redirect()->route('admin.pillow-block.index')
            ->with('success', 'Pillow Block deleted successfully.');
    }

    /**
     * Bulk update from database view mode.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'pillow_blocks' => 'required|array',
            'pillow_blocks.*.id' => 'required|integer|exists:pillow_blocks,id',
            'pillow_blocks.*.name' => 'nullable|string|max:255',
            'pillow_blocks.*.slug' => 'nullable|string|max:255',
            'pillow_blocks.*.sku' => 'nullable|string',
            'pillow_blocks.*.price' => 'nullable|numeric|min:0',
            'pillow_blocks.*.sale_price' => 'nullable|numeric|min:0',
            'pillow_blocks.*.is_active' => 'nullable|boolean',
            'pillow_blocks.*.is_featured' => 'nullable|boolean',
            'pillow_blocks.*.is_new_arrival' => 'nullable|boolean',
            'pillow_blocks.*.category_id' => 'nullable|integer|exists:categories,id',
            'pillow_blocks.*.sort_order' => 'nullable|integer|min:0',
            'pillow_blocks.*.description' => 'nullable|string|max:50000',
            'pillow_blocks.*.short_description' => 'nullable|string|max:500',
            'pillow_blocks.*.meta_title' => 'nullable|string|max:255',
            'pillow_blocks.*.meta_description' => 'nullable|string|max:5000',
            'pillow_blocks.*.meta_keywords' => 'nullable|string|max:1000',
            'pillow_blocks.*.equiv_skf' => 'nullable|string|max:255',
            'pillow_blocks.*.equiv_fag' => 'nullable|string|max:255',
            'pillow_blocks.*.equiv_ntn' => 'nullable|string|max:255',
            'pillow_blocks.*.equiv_timken' => 'nullable|string|max:255',
            
            // Specs
            'pillow_blocks.*.bearing_number' => 'nullable|string|max:255',
            'pillow_blocks.*.specifications' => 'nullable|string',
        ]);

        $blocks = $request->input('pillow_blocks', []);
        $updated = 0;
        $errors = [];

        foreach ($blocks as $blockData) {
            try {
                $pb = PillowBlock::findOrFail($blockData['id']);
                
                $updateData = [];
                $allowedFields = [
                    'name', 'slug', 'sku', 'price', 'sale_price',
                    'is_active', 'is_featured', 'is_new_arrival',
                    'category_id', 'sort_order', 'description', 'short_description',
                    'meta_title', 'meta_description', 'meta_keywords',
                    'equiv_skf', 'equiv_fag', 'equiv_ntn', 'equiv_timken',
                    'bearing_number'
                ];

                foreach ($allowedFields as $field) {
                    if (array_key_exists($field, $blockData)) {
                        $updateData[$field] = $blockData[$field];
                    }
                }

                if (array_key_exists('specifications', $blockData)) {
                    $specsStr = trim((string)$blockData['specifications']);
                    $specifications = [];
                    if (str_starts_with($specsStr, '[') && str_ends_with($specsStr, ']')) {
                        $decoded = json_decode($specsStr, true);
                        if (is_array($decoded)) {
                            $specifications = $decoded;
                        }
                    } elseif ($specsStr !== '') {
                        $rows = explode(';', $specsStr);
                        foreach ($rows as $r) {
                            $parts = explode('|', $r);
                            if (count($parts) >= 2) {
                                $specifications[] = [
                                    'title' => trim($parts[0]),
                                    'dimension' => trim($parts[1]),
                                    'value' => isset($parts[2]) ? trim($parts[2]) : '',
                                ];
                            }
                        }
                    }
                    $updateData['specifications'] = !empty($specifications) ? $specifications : null;
                }

                if (! empty($updateData)) {
                    $pb->update($updateData);
                    $updated++;
                }
            } catch (\Exception $e) {
                $errors[] = "Pillow Block ID {$blockData['id']}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'updated' => $updated,
            'errors' => $errors,
            'message' => "Successfully updated {$updated} Pillow Block(s)." . ($errors ? ' Some errors occurred.' : ''),
        ]);
    }

    /**
     * Bulk delete Pillow Blocks.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:pillow_blocks,id',
        ]);

        $ids = $request->input('ids');
        $deleted = 0;

        foreach ($ids as $id) {
            $pillowBlock = PillowBlock::find($id);
            if ($pillowBlock) {
                // Delete media
                if ($pillowBlock->image) {
                    Storage::disk('public')->delete($pillowBlock->image);
                }
                if ($pillowBlock->video) {
                    Storage::disk('public')->delete($pillowBlock->video);
                }
                if ($pillowBlock->pdf_catalogue) {
                    Storage::disk('public')->delete($pillowBlock->pdf_catalogue);
                }

                // Delete gallery images
                foreach ($pillowBlock->galleryImages as $img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }

                $pillowBlock->delete();
                $deleted++;
            }
        }

        return redirect()->route('admin.pillow-block.index')
            ->with('success', "Successfully deleted {$deleted} Pillow Block(s).");
    }
}
