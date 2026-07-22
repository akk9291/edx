<?php

namespace App\Services;

use App\Models\Category;
use App\Models\PillowBlock;
use App\Models\PillowBlockImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PillowBlockCatalogImportService
{
    public function import(UploadedFile $file, string $duplicateAction = 'skip'): array
    {
        $path = $file->getRealPath();
        if ($path === false) {
            return $this->result(0, 0, 0, ['Could not read uploaded file.']);
        }

        $ext = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, ['xlsx', 'xls'], true) && ! class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            return $this->result(0, 0, 0, [
                'Excel (.xlsx / .xls) requires PhpSpreadsheet. Please run composer install on the server.',
            ]);
        }

        $rows = match ($ext) {
            'csv', 'txt' => iterator_to_array($this->rowsFromCsv($path)),
            'xlsx', 'xls' => iterator_to_array($this->rowsFromSpreadsheet($path)),
            default => [],
        };

        if ($rows === []) {
            return $this->result(0, 0, 0, ['Unsupported file type. Use .csv, .txt, .xlsx, or .xls.']);
        }

        // Detect double header row (standard in client template)
        $headers = [];
        $dataStartIndex = 0;

        if (count($rows) >= 2) {
            $row0 = $rows[0];
            $row1 = $rows[1];
            
            // If row1 contains 'bearing number' or 'bearing no.' (case-insensitive)
            $isRow1Header = false;
            foreach ($row1 as $cell) {
                if (preg_match('/bearing\s*no/i', (string)$cell) || preg_match('/bearing\s*number/i', (string)$cell)) {
                    $isRow1Header = true;
                    break;
                }
            }

            if ($isRow1Header) {
                // Combine row0 and row1 to make unique headers
                foreach ($row1 as $i => $val) {
                    $prefix = isset($row0[$i]) ? trim((string)$row0[$i]) : '';
                    $suffix = trim((string)$val);
                    $headers[] = ($prefix !== '' && $prefix !== $suffix) ? "{$prefix} {$suffix}" : $suffix;
                }
                $dataStartIndex = 2; // Data starts at index 2
            } else {
                $headers = array_map(fn($h) => trim((string)$h), $row0);
                $dataStartIndex = 1;
            }
        } else {
            $headers = array_map(fn($h) => trim((string)$h), $rows[0] ?? []);
            $dataStartIndex = 1;
        }

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];

        // Find standard category 'pillow-block'
        $pillowBlockCategory = Category::where('slug', 'pillow-block')->first();

        DB::beginTransaction();
        try {
            for ($index = $dataStartIndex; $index < count($rows); $index++) {
                $row = $rows[$index];
                $line = $index + 1; // 1-based index for logging

                // Map row to specs and product details
                $data = $this->mapRow($row, $headers);

                $sku = $data['bearing_number'] ?: ($data['sku'] ?? '');
                if ($sku === '') {
                    $errors[] = "Row {$line}: Missing Bearing Number/SKU.";
                    $skipped++;
                    continue;
                }

                // Check for duplicates
                $exists = PillowBlock::where('sku', $sku)->first();
                if ($exists) {
                    if ($duplicateAction === 'skip') {
                        $skipped++;
                        continue;
                    }
                }

                try {
                    $pb = $exists ?: new PillowBlock();
                    $pb->sku = $sku;
                    
                    // Name defaults to Category + SKU or just SKU
                    $nameVal = $data['name'] ?: ($pillowBlockCategory ? $pillowBlockCategory->name . ' ' . $sku : 'Pillow Block ' . $sku);
                    $pb->name = Str::limit($nameVal, 255, '');
                    
                    if (!$exists) {
                        $pb->slug = $this->makeUniqueSlug(Str::slug($nameVal));
                    }

                    // Assign general details
                    $pb->category_id = $data['category_id'] ?: ($pillowBlockCategory ? $pillowBlockCategory->id : null);
                    $pb->brand = $data['brand'] ?: null;
                    $pb->short_description = $data['short_description'] ?: null;
                    $pb->description = $data['description'] ?: null;
                    $pb->price = $data['price'] !== '' ? (float)$data['price'] : 0.00;
                    $pb->sale_price = $data['sale_price'] !== '' ? (float)$data['sale_price'] : null;
                    $pb->image = $data['image_url'] ?: null;
                    $pb->video = $data['video'] ?: null;
                    $pb->pdf_catalogue = $data['pdf_catalogue'] ?: null;
                    $pb->equiv_skf = $data['equiv_skf'] ?: null;
                    $pb->equiv_fag = $data['equiv_fag'] ?: null;
                    $pb->equiv_ntn = $data['equiv_ntn'] ?: null;
                    $pb->equiv_timken = $data['equiv_timken'] ?: null;
                    $pb->meta_title = $data['meta_title'] ?: null;
                    $pb->meta_description = $data['meta_description'] ?: null;
                    $pb->meta_keywords = $data['meta_keywords'] ?: null;
                    
                    $pb->is_active = $data['is_active'] !== '' ? (bool)$data['is_active'] : true;
                    $pb->in_stock = $data['in_stock'] !== '' ? (bool)$data['in_stock'] : true;
                    $pb->is_featured = $data['is_featured'] !== '' ? (bool)$data['is_featured'] : false;
                    $pb->is_new_arrival = $data['is_new_arrival'] !== '' ? (bool)$data['is_new_arrival'] : false;
                    $pb->sort_order = $data['sort_order'] !== '' ? (int)$data['sort_order'] : 0;

                    // Specifications
                    $pb->bearing_number = $data['bearing_number'] ?: null;
                    
                    $specifications = [];
                    if ($dataStartIndex === 2) {
                        $row0 = $rows[0];
                        $row1 = $rows[1];
                        $generalAliases = [
                            'bearing number', 'bearing no', 'bearing_number', 'bearing_no', 'sku', 'name', 'title', 'product name',
                            'category_id', 'category id', 'category', 'brand', 'short_description', 'short description', 'excerpt',
                            'description', 'content', 'detailed description', 'price', 'regular price', 'mrp', 'sale_price', 'sale price',
                            'image_url', 'featured image', 'image', 'image url', 'video', 'video_url', 'pdf_catalogue', 'pdf', 'pdf catalogue',
                            'equiv_skf', 'equiv skf', 'skf equivalent', 'skf', 'equiv_fag', 'equiv fag', 'fag equivalent', 'fag',
                            'equiv_ntn', 'equiv ntn', 'ntn equivalent', 'ntn', 'equiv_timken', 'equiv timken', 'timken equivalent', 'timken',
                            'meta_title', 'meta title', 'meta_description', 'meta description', 'meta_keywords', 'meta keywords',
                            'is_active', 'status', 'active', 'in_stock', 'stock', 'is_featured', 'featured', 'is_new_arrival', 'new arrival',
                            'sort_order', 'sort order'
                        ];

                        foreach ($row as $i => $val) {
                            $val = trim((string)$val);
                            if ($val === '') {
                                continue;
                            }
                            $title = isset($row0[$i]) ? trim((string)$row0[$i]) : '';
                            $dimension = isset($row1[$i]) ? trim((string)$row1[$i]) : '';
                            
                            $cleanTitle = strtolower(trim($title));
                            $cleanDim = strtolower(trim($dimension));
                            
                            if ($cleanTitle === '' && $cleanDim === '') {
                                continue;
                            }
                            
                            $isGeneral = false;
                            foreach ($generalAliases as $alias) {
                                if (($cleanTitle !== '' && $cleanTitle === $alias) || ($cleanDim !== '' && $cleanDim === $alias)) {
                                    $isGeneral = true;
                                    break;
                                }
                            }
                            
                            if ($isGeneral) {
                                continue;
                            }
                            
                            $specifications[] = [
                                'title' => $title !== '' ? $title : $dimension,
                                'dimension' => $title !== '' ? $dimension : '',
                                'value' => $val
                            ];
                        }
                    } else {
                        $specsStr = trim($data['specifications'] ?? '');
                        if (str_starts_with($specsStr, '[') && str_ends_with($specsStr, ']')) {
                            $decoded = json_decode($specsStr, true);
                            if (is_array($decoded)) {
                                $specifications = $decoded;
                            }
                        } elseif ($specsStr !== '') {
                            $rowsList = explode(';', $specsStr);
                            foreach ($rowsList as $r) {
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
                    }
                    $pb->specifications = !empty($specifications) ? $specifications : null;

                    $pb->save();

                    // Handle gallery images
                    if ($data['gallery_images'] !== '') {
                        // Delete old gallery images if updating
                        if ($exists) {
                            $pb->galleryImages()->delete();
                        }
                        
                        $urls = explode(',', $data['gallery_images']);
                        foreach ($urls as $url) {
                            $url = trim($url);
                            if ($url !== '') {
                                PillowBlockImage::create([
                                    'pillow_block_id' => $pb->id,
                                    'image_path' => $url,
                                ]);
                            }
                        }
                    }

                    if ($exists) {
                        $updated++;
                    } else {
                        $created++;
                    }
                } catch (\Throwable $e) {
                    $errors[] = "Row {$line}: " . $e->getMessage();
                    if (count($errors) >= 50) {
                        $errors[] = 'Further errors omitted.';
                        break;
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->result(0, 0, 0, array_merge($errors, ['Import transaction aborted: ' . $e->getMessage()]));
        }

        return $this->result($created, $updated, $skipped, $errors);
    }

    protected function result(int $created, int $updated, int $skipped, array $errors): array
    {
        return [
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }

    protected function mapRow(array $row, array $headers): array
    {
        // Aliases configuration
        $fields = [
            'bearing_number' => [['Bearing number', 'bearing_no', 'bearing_number'], 0],
            'specifications' => [['Specifications', 'specifications', 'specs'], 1],

            // Optional general details
            'name' => [['name', 'Title', 'Product Name'], null],
            'sku' => [['sku', 'SKU'], null],
            'category_id' => [['category_id', 'Category ID', 'Category'], null],
            'brand' => [['brand', 'Brand'], null],
            'short_description' => [['short_description', 'Short Description', 'Excerpt'], null],
            'description' => [['description', 'Description', 'Content', 'Detailed Description'], null],
            'price' => [['price', 'Regular price', 'mrp', 'MRP'], null],
            'sale_price' => [['sale_price', 'Sale Price'], null],
            'image_url' => [['image_url', 'Featured Image', 'image', 'Image URL'], null],
            'video' => [['video', 'video_url', 'Video'], null],
            'pdf_catalogue' => [['pdf_catalogue', 'pdf', 'PDF Catalogue'], null],
            'equiv_skf' => [['equiv_skf', 'equiv skf', 'SKF Equivalent', 'SKF'], null],
            'equiv_fag' => [['equiv_fag', 'equiv fag', 'FAG Equivalent', 'FAG'], null],
            'equiv_ntn' => [['equiv_ntn', 'equiv ntn', 'NTN Equivalent', 'NTN'], null],
            'equiv_timken' => [['equiv_timken', 'equiv timken', 'Timken Equivalent', 'Timken'], null],
            'meta_title' => [['meta_title', 'Meta Title'], null],
            'meta_description' => [['meta_description', 'Meta Description'], null],
            'meta_keywords' => [['meta_keywords', 'Meta Keywords'], null],
            'is_active' => [['is_active', 'status', 'Status', 'Active'], null],
            'in_stock' => [['in_stock', 'In stock', 'Stock'], null],
            'is_featured' => [['is_featured', 'Featured'], null],
            'is_new_arrival' => [['is_new_arrival', 'New Arrival'], null],
            'sort_order' => [['sort_order', 'Sort Order'], null],
            'gallery_images' => [['gallery_images', 'gallery', 'Gallery Images'], null],
        ];

        $mapped = [];
        foreach ($fields as $key => $config) {
            [$aliases, $defaultIdx] = $config;
            $mapped[$key] = $this->getRowVal($row, $headers, $aliases, $defaultIdx);
        }

        return $mapped;
    }

    protected function getRowVal(array $row, array $headers, array $aliases, ?int $defaultIdx): string
    {
        foreach ($aliases as $alias) {
            foreach ($headers as $idx => $header) {
                if (strcasecmp(trim((string)$header), trim((string)$alias)) === 0) {
                    return isset($row[$idx]) ? trim((string)$row[$idx]) : '';
                }
            }
        }
        if ($defaultIdx !== null && isset($row[$defaultIdx])) {
            return trim((string)$row[$defaultIdx]);
        }
        return '';
    }

    protected function makeUniqueSlug(string $slug): string
    {
        $original = $slug;
        $counter = 1;
        while (PillowBlock::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    /**
     * @return \Generator<int, array<int, mixed>>
     */
    protected function rowsFromCsv(string $path): \Generator
    {
        $h = fopen($path, 'rb');
        if ($h === false) {
            return;
        }
        $bom = fread($h, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($h);
        }
        while (($row = fgetcsv($h, 0, ',', '"', '')) !== false) {
            if ($this->rowIsEmpty($row)) {
                continue;
            }
            yield $row;
        }
        fclose($h);
    }

    /**
     * @return \Generator<int, array<int, mixed>>
     */
    protected function rowsFromSpreadsheet(string $path): \Generator
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, false);
        if ($data === [] || $data === null) {
            return;
        }
        foreach ($data as $row) {
            if (! is_array($row)) {
                continue;
            }
            if ($this->rowIsEmpty($row)) {
                continue;
            }
            yield $row;
        }
    }

    protected function rowIsEmpty(array $row): bool
    {
        foreach ($row as $cell) {
            if ($cell !== null && trim((string) $cell) !== '') {
                return false;
            }
        }
        return true;
    }
}
