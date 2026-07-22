<?php

namespace App\Services;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Imports bearing rows from WordPress-style exports (CSV / XLSX):
 * DGBB (bearings), SRB (srb_bearings), CRB (crb_bearings) — same column families as the reference files.
 *
 * Optional extra columns (see sample header): meta_title, meta_description, meta_keywords, mrp (→ price),
 * sale_price. Empty cells do not overwrite existing product values on re-import.
 */
class BearingCatalogImportService
{
    public function import(UploadedFile $file): array
    {
        $path = $file->getRealPath();
        if ($path === false) {
            return $this->result(0, 0, 0, ['Could not read uploaded file.']);
        }

        $ext = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, ['xlsx', 'xls'], true) && ! class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            return $this->result(0, 0, 0, [
                'Excel (.xlsx / .xls) needs the phpoffice/phpspreadsheet package. On the server, from the project folder run: composer install --no-dev',
                'Until then, export your sheet as CSV and upload a .csv file instead.',
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

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $line = $index + 2;
                try {
                    $sku = $this->pick($row, ['bearing_no']);
                    if ($sku === '') {
                        $skipped++;

                        continue;
                    }

                    $categoryId = $this->resolveCategoryId($row);
                    if ($categoryId === null) {
                        $errors[] = "Row {$line}: could not resolve category for SKU {$sku}.";
                        $skipped++;

                        continue;
                    }

                    $title = $this->pick($row, ['Title']);
                    $category = Category::query()->find($categoryId);
                    $name = $title !== '' ? Str::limit($title, 255, '') : Str::limit(($category?->name ?? 'Bearing').' '.$sku, 255, '');

                    $description = $this->pick($row, ['bearing_description', 'Content', 'Excerpt']);

                    $imageCandidates = $this->catalogImageUrlCandidates($row);
                    $imageUrls = array_values(array_filter($imageCandidates, fn ($u) => Product::isAcceptableImageSource($u)));
                    $mainImage = $imageUrls[0] ?? null;
                    $imagesJson = count($imageUrls) > 0 ? $imageUrls : null;

                    $specs = $this->buildSpecifications($row);

                    $product = Product::query()->where('sku', $sku)->first();
                    $wasExisting = $product !== null;
                    if (! $product) {
                        $product = new Product(['sku' => $sku]);
                        $product->slug = $this->makeUniqueSlug(Str::slug($sku.'-'.($category?->slug ?? 'bearing')));
                    }

                    $product->name = $name;
                    $product->description = $description !== '' ? $description : null;
                    $product->category_id = $categoryId;
                    $product->image = $mainImage;
                    $product->images = $imagesJson;
                    $product->specifications = count($specs) > 0 ? $specs : null;
                    $product->is_active = true;

                    $this->applyOptionalMetaAndPricing($product, $row);

                    if ($product->price === null) {
                        $product->price = 0;
                    }
                    if ($product->stock_quantity === null) {
                        $product->stock_quantity = 0;
                    }
                    $product->in_stock = (bool) ($product->in_stock ?? false);
                    if ($product->sort_order === null) {
                        $product->sort_order = 0;
                    }
                    $product->save();

                    if ($wasExisting) {
                        $updated++;
                    } else {
                        $created++;
                    }
                } catch (\Throwable $e) {
                    $errors[] = "Row {$line}: ".$e->getMessage();
                    if (count($errors) >= 40) {
                        $errors[] = 'Further row errors omitted.';
                        break;
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->result(0, 0, 0, array_merge($errors, ['Import aborted: '.$e->getMessage()]));
        }

        return $this->result($created, $updated, $skipped, $errors);
    }

    /**
     * @return array{created:int,updated:int,skipped:int,errors:array<int,string>}
     */
    protected function result(int $created, int $updated, int $skipped, array $errors): array
    {
        return [
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }

    /**
     * @return \Generator<int, array<string, string>>
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
        $headers = fgetcsv($h, 0, ',', '"', '');
        if (! is_array($headers)) {
            fclose($h);

            return;
        }
        $headers = array_map(fn ($x) => trim((string) $x), $headers);
        while (($row = fgetcsv($h, 0, ',', '"', '')) !== false) {
            if ($this->rowIsEmpty($row)) {
                continue;
            }
            yield $this->combineRow($headers, $row);
        }
        fclose($h);
    }

    /**
     * @return \Generator<int, array<string, string>>
     */
    protected function rowsFromSpreadsheet(string $path): \Generator
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, false);
        if ($data === [] || $data === null) {
            return;
        }
        $headers = array_shift($data);
        if (! is_array($headers)) {
            return;
        }
        $headers = array_map(fn ($x) => trim((string) $x), $headers);
        foreach ($data as $row) {
            if (! is_array($row)) {
                continue;
            }
            if ($this->rowIsEmpty($row)) {
                continue;
            }
            yield $this->combineRow($headers, $row);
        }
    }

    /**
     * @param  array<int, string>  $headers
     * @param  array<int, mixed>  $row
     * @return array<string, string>
     */
    protected function combineRow(array $headers, array $row): array
    {
        $assoc = [];
        foreach ($headers as $i => $key) {
            if ($key === '') {
                continue;
            }
            $val = $row[$i] ?? '';
            if ($val instanceof \DateTimeInterface) {
                $assoc[$key] = $val->format('Y-m-d H:i:s');
            } else {
                $assoc[$key] = is_scalar($val) ? trim((string) $val) : '';
            }
        }

        return $assoc;
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

    /**
     * @param  array<string, string>  $row
     */
    protected function pick(array $row, array $keys): string
    {
        foreach ($keys as $k) {
            if (array_key_exists($k, $row) && $row[$k] !== '') {
                return $row[$k];
            }
        }
        foreach ($row as $rk => $rv) {
            foreach ($keys as $k) {
                if (strcasecmp($rk, $k) === 0 && $rv !== '') {
                    return $rv;
                }
            }
        }

        return '';
    }

    /**
     * Optional SEO and pricing columns (append to export). Empty cells leave existing values unchanged.
     */
    protected function applyOptionalMetaAndPricing(Product $product, array $row): void
    {
        $metaTitle = $this->pick($row, ['meta_title', 'Meta Title']);
        if ($metaTitle !== '') {
            $product->meta_title = Str::limit($metaTitle, 255, '');
        }

        $metaDesc = $this->pick($row, ['meta_description', 'Meta Description']);
        if ($metaDesc !== '') {
            $product->meta_description = Str::limit($metaDesc, 5000, '');
        }

        $metaKw = $this->pick($row, ['meta_keywords', 'Meta Keywords']);
        if ($metaKw !== '') {
            $product->meta_keywords = Str::limit($metaKw, 1024, '');
        }

        $mrpRaw = $this->pick($row, ['mrp', 'MRP', 'regular_price', 'Regular price']);
        if ($mrpRaw !== '') {
            $mrp = $this->parseDecimalOrNull($mrpRaw);
            if ($mrp !== null) {
                $product->price = $mrp;
            }
        }

        $saleRaw = $this->pick($row, ['sale_price', 'Sale Price', 'Sale price']);
        if ($saleRaw !== '') {
            $sale = $this->parseDecimalOrNull($saleRaw);
            $product->sale_price = ($sale !== null && $sale > 0) ? $sale : null;
        }
    }

    protected function parseDecimalOrNull(string $raw): ?float
    {
        $raw = trim($raw);
        if ($raw === '') {
            return null;
        }
        $s = str_replace(["\xc2\xa0", ' '], '', $raw);
        $s = str_replace(',', '.', $s);
        if (! is_numeric($s)) {
            return null;
        }
        $f = (float) $s;
        if ($f < 0) {
            return null;
        }

        return round($f, 2);
    }

    /**
     * @param  array<string, string>  $row
     */
    protected function resolveCategoryId(array $row): ?int
    {
        $name = $this->pick($row, ['Bearing Category', 'bearing_category']);
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        $slug = $this->mapExportCategoryNameToSlug($name) ?? Str::slug($name);
        if ($slug === '') {
            return null;
        }

        $catalogQuery = Category::query()->forBearingsCatalog()->where('is_active', true);

        $id = (clone $catalogQuery)->where('slug', $slug)->value('id');
        if ($id !== null) {
            return (int) $id;
        }

        $normalizedName = strtolower(preg_replace('/\s+/u', ' ', $name));
        $id = (clone $catalogQuery)
            ->whereRaw('LOWER(TRIM(name)) = ?', [$normalizedName])
            ->value('id');
        if ($id !== null) {
            return (int) $id;
        }

        return $this->createCategoryForImport($name, $slug);
    }

    /**
     * Map known export labels to catalogue slugs; unknown names fall back to Str::slug() in resolveCategoryId().
     */
    protected function mapExportCategoryNameToSlug(string $name): ?string
    {
        $n = strtolower(preg_replace('/\s+/u', ' ', trim($name)));
        if ($n === '') {
            return null;
        }

        $map = [
            'deep groove ball bearing' => 'deep-groove-ball-bearing',
            'deep groove ball bearings' => 'deep-groove-ball-bearing',
            'spherical roller bearing' => 'spherical-roller-bearing',
            'spherical roller bearings' => 'spherical-roller-bearing',
            'cylindrical roller bearing' => 'cylindrical-roller-bearing',
            'cylindrical roller bearings' => 'cylindrical-roller-bearing',
            'taper roller bearing' => 'taper-roller-bearing',
            'taper roller bearings' => 'taper-roller-bearing',
            'pillow block' => 'pillow-block',
            'angular contact ball bearing' => 'angular-contact-ball-bearing',
            'thrust ball bearing' => 'thrust-ball-bearing',
            'needle roller bearing' => 'needle-roller-bearing',
            'spindle bearing' => 'spindle-bearing',
            'spindle bearings' => 'spindle-bearing',
        ];

        if (isset($map[$n])) {
            return $map[$n];
        }
        foreach ($map as $needle => $slug) {
            if (str_contains($n, $needle)) {
                return $slug;
            }
        }

        return null;
    }

    /**
     * Create a bearing-catalog category when the sheet references a name not yet in the database.
     */
    protected function createCategoryForImport(string $name, string $slug): ?int
    {
        $mainCategoryId = MainCategory::bearingsCatalogId();
        if ($mainCategoryId === null) {
            return null;
        }

        $existing = Category::query()
            ->where('slug', $slug)
            ->first();

        if ($existing !== null) {
            if ((int) $existing->main_category_id === (int) $mainCategoryId && $existing->is_active) {
                return (int) $existing->id;
            }

            return null;
        }

        $category = Category::query()->create([
            'name' => $name,
            'slug' => $slug,
            'main_category_id' => $mainCategoryId,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return (int) $category->id;
    }

    /**
     * @return list<string>
     */
    protected function splitUrls(string $raw): array
    {
        if ($raw === '') {
            return [];
        }
        $parts = preg_split('/\|+/u', $raw) ?: [];
        $out = [];
        foreach ($parts as $p) {
            $p = trim($p);
            if ($p !== '' && (str_starts_with($p, 'http://') || str_starts_with($p, 'https://') || str_starts_with($p, '//'))) {
                $out[] = $p;
            }
        }

        return array_values(array_unique($out));
    }

    /**
     * Ordered remote image URL candidates from export columns (filtered later with Product::isAcceptableImageSource).
     *
     * @return list<string>
     */
    protected function catalogImageUrlCandidates(array $row): array
    {
        $out = [];
        foreach (['Image URL', 'Attachment URL'] as $col) {
            foreach ($this->splitUrls($this->pick($row, [$col])) as $u) {
                $out[] = $u;
            }
        }
        $bearingImg = trim($this->pick($row, ['bearing_image']));
        if ($bearingImg !== '' && (str_starts_with($bearingImg, 'http://') || str_starts_with($bearingImg, 'https://') || str_starts_with($bearingImg, '//'))) {
            $out[] = $bearingImg;
        }

        return array_values(array_unique($out));
    }

    /**
     * @param  array<string, string>  $row
     * @return array<string, string>
     */
    protected function buildSpecifications(array $row): array
    {
        $specs = [];

        $set = function (string $key, ?string $val) use (&$specs): void {
            if ($val !== null && trim($val) !== '') {
                $specs[$key] = trim($val);
            }
        };

        $set('bore_diameter', $this->formatDim($this->pick($row, ['bore_diameter'])));
        $set('outside_diameter', $this->formatDim($this->pick($row, ['outside_diameter'])));
        $set('width', $this->formatDim($this->pick($row, ['width'])));
        $set('dynamic_load_rating', $this->formatLoad($this->pick($row, ['basic_dynamic_load_rating'])));
        $set('static_load_rating', $this->formatLoad($this->pick($row, ['basic_static_load_rating'])));

        $grease = $this->pick($row, ['limiting_speed_grease']);
        $oil = $this->pick($row, ['limiting_speed_oil']);
        $single = $this->pick($row, ['limiting_speed']);
        if ($grease === '' && $oil === '' && $single !== '') {
            $fmt = $this->formatSpeed($single);
            $set('limiting_speed_grease', $fmt);
            $set('limiting_speed_oil', $fmt);
        } else {
            $set('limiting_speed_grease', $this->formatSpeed($grease));
            $set('limiting_speed_oil', $this->formatSpeed($oil));
        }

        $set('number_of_rows', $this->pick($row, ['number_of_rows']));
        $set('radial_clearance', $this->pick($row, ['radial_internal_clearance']));
        $set('tolerance_class', $this->pick($row, ['tolerance_class_for_dimensions']));
        $set('cage', $this->pick($row, ['cage']));
        $set('bore_type', $this->pick($row, ['bore_type']));

        $weight = $this->pick($row, ['product_net_weight']);
        if ($weight !== '' && is_numeric(str_replace(',', '.', $weight))) {
            $set('weight', $weight.' kg');
        } elseif ($weight !== '') {
            $set('weight', $weight);
        }

        foreach (['skf' => 'equiv_skf', 'fag' => 'equiv_fag', 'ntn' => 'equiv_ntn', 'timken' => 'equiv_timken'] as $col => $key) {
            $v = $this->pick($row, [$col]);
            if ($v !== '') {
                $specs[$key] = $v;
            }
        }

        $bearingImage = trim($this->pick($row, ['bearing_image']));
        if ($bearingImage !== '') {
            $set('bearing_image', $bearingImage);
        }

        foreach ($row as $k => $v) {
            if ($v === '' || ! str_starts_with(strtolower((string) $k), 'suffix_')) {
                continue;
            }
            $specs[(string) $k] = $v;
        }

        return $specs;
    }

    protected function formatDim(string $v): ?string
    {
        $v = trim($v);
        if ($v === '') {
            return null;
        }
        if (stripos($v, 'mm') !== false) {
            return $v;
        }
        if (preg_match('/^[0-9\.\,\s]+$/', $v)) {
            return $v.' mm';
        }

        return $v;
    }

    protected function formatLoad(string $v): ?string
    {
        $v = trim($v);
        if ($v === '') {
            return null;
        }
        if (preg_match('/kn/i', $v)) {
            return $v;
        }
        $n = str_replace([' ', ','], ['', '.'], $v);
        if (is_numeric($n)) {
            return $v.' KN';
        }

        return $v;
    }

    protected function formatSpeed(string $v): ?string
    {
        $v = trim($v);
        if ($v === '') {
            return null;
        }
        if (stripos($v, 'r/min') !== false || stripos($v, 'rpm') !== false) {
            return $v;
        }
        if (preg_match('/^[0-9\.\,\s]+$/', $v)) {
            return $v.' r/min';
        }

        return $v;
    }

    protected function makeUniqueSlug(string $base): string
    {
        $slug = Str::slug($base) ?: 'bearing';
        $original = $slug;
        $i = 1;
        while (Product::query()->where('slug', $slug)->exists()) {
            $slug = $original.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
