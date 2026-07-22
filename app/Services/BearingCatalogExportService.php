<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Exports bearing products in the same column shape as {@see BearingCatalogImportService}.
 */
class BearingCatalogExportService
{
    /** @var list<string> */
    public const COLUMNS = [
        'ID',
        'Title',
        'Content',
        'Excerpt',
        'Post Type',
        'Image URL',
        'Image Title',
        'Image Caption',
        'Image Description',
        'Image Alt Text',
        'Image Featured',
        'Attachment URL',
        'Bearing Category',
        'bearing_no',
        'bore_diameter',
        'outside_diameter',
        'width',
        'basic_dynamic_load_rating',
        'basic_static_load_rating',
        'limiting_speed_grease',
        'limiting_speed_oil',
        'number_of_rows',
        'radial_internal_clearance',
        'tolerance_class_for_dimensions',
        'cage',
        'bore_type',
        'skf',
        'fag',
        'ntn',
        'timken',
        'suffix_name',
        'suffix_desc',
        'suffix',
        'suffix_type',
        'bearing_image',
        'bearing_category',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'mrp',
        'sale_price',
    ];

    /**
     * @return list<string>
     */
    public function headers(): array
    {
        return self::COLUMNS;
    }

    /**
     * @return array<string, string>
     */
    public function rowFromProduct(Product $product): array
    {
        $specs = $product->specifications;
        if (is_string($specs)) {
            $specs = json_decode($specs, true);
        }
        $specs = is_array($specs) ? $specs : [];

        $categoryName = $product->category?->name ?? '';
        $imageUrls = $this->collectImageUrls($product, $specs);
        $bearingImage = trim((string) ($specs['bearing_image'] ?? ''));

        $suffixName = trim((string) ($specs['suffix_name'] ?? ''));
        $suffixDesc = trim((string) ($specs['suffix_desc'] ?? ''));
        $suffixCode = trim((string) ($specs['suffix'] ?? ''));
        $suffixType = trim((string) ($specs['suffix_type'] ?? ''));

        if (! empty($specs['suffix_pairs']) && is_array($specs['suffix_pairs'])) {
            $first = $specs['suffix_pairs'][0] ?? null;
            if (is_array($first)) {
                if ($suffixCode === '') {
                    $suffixCode = trim((string) ($first['suffix'] ?? ''));
                }
                if ($suffixDesc === '') {
                    $suffixDesc = trim((string) ($first['description'] ?? ''));
                }
            }
        }

        $shortDesc = trim(strip_tags((string) ($product->short_description ?? '')));

        return [
            'ID' => (string) $product->id,
            'Title' => (string) ($product->name ?? ''),
            'Content' => (string) ($product->description ?? ''),
            'Excerpt' => $shortDesc,
            'Post Type' => 'post',
            'Image URL' => implode('|', $imageUrls),
            'Image Title' => '',
            'Image Caption' => '',
            'Image Description' => '',
            'Image Alt Text' => (string) ($product->name ?? ''),
            'Image Featured' => '',
            'Attachment URL' => '',
            'Bearing Category' => $categoryName,
            'bearing_no' => (string) ($product->sku ?? ''),
            'bore_diameter' => $this->exportSpecValue($specs, 'bore_diameter'),
            'outside_diameter' => $this->exportSpecValue($specs, 'outside_diameter'),
            'width' => $this->exportSpecValue($specs, 'width'),
            'basic_dynamic_load_rating' => $this->exportSpecValue($specs, 'dynamic_load_rating'),
            'basic_static_load_rating' => $this->exportSpecValue($specs, 'static_load_rating'),
            'limiting_speed_grease' => $this->exportSpecValue($specs, 'limiting_speed_grease'),
            'limiting_speed_oil' => $this->exportSpecValue($specs, 'limiting_speed_oil'),
            'number_of_rows' => $this->exportSpecValue($specs, 'number_of_rows'),
            'radial_internal_clearance' => $this->exportSpecValue($specs, 'radial_clearance'),
            'tolerance_class_for_dimensions' => $this->exportSpecValue($specs, 'tolerance_class'),
            'cage' => $this->exportSpecValue($specs, 'cage'),
            'bore_type' => $this->exportSpecValue($specs, 'bore_type'),
            'skf' => $this->exportSpecValue($specs, 'equiv_skf'),
            'fag' => $this->exportSpecValue($specs, 'equiv_fag'),
            'ntn' => $this->exportSpecValue($specs, 'equiv_ntn'),
            'timken' => $this->exportSpecValue($specs, 'equiv_timken'),
            'suffix_name' => $suffixName,
            'suffix_desc' => $suffixDesc,
            'suffix' => $suffixCode,
            'suffix_type' => $suffixType,
            'bearing_image' => $bearingImage,
            'bearing_category' => $categoryName,
            'meta_title' => (string) ($product->meta_title ?? ''),
            'meta_description' => (string) ($product->meta_description ?? ''),
            'meta_keywords' => (string) ($product->meta_keywords ?? ''),
            'mrp' => $product->price !== null ? (string) $product->price : '',
            'sale_price' => $product->sale_price !== null ? (string) $product->sale_price : '',
        ];
    }

    public function downloadCsv(Builder $query): StreamedResponse
    {
        $filename = 'bearing-export-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($query): void {
            $out = fopen('php://output', 'w');
            if ($out === false) {
                return;
            }
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $this->headers());

            (clone $query)->with('category')->orderBy('id')->chunkById(200, function ($products) use ($out): void {
                foreach ($products as $product) {
                    if (! $product instanceof Product) {
                        continue;
                    }
                    $assoc = $this->rowFromProduct($product);
                    $line = array_map(static fn (string $col): string => $assoc[$col] ?? '', $this->headers());
                    fputcsv($out, $line);
                }
            });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function downloadXlsx(Builder $query): StreamedResponse
    {
        $filename = 'bearing-export-'.now()->format('Y-m-d-His').'.xlsx';

        return response()->streamDownload(function () use ($query): void {
            $spreadsheet = new Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray([$this->headers()], null, 'A1');

            $rowIndex = 2;
            (clone $query)->with('category')->orderBy('id')->chunkById(200, function ($products) use ($sheet, &$rowIndex): void {
                foreach ($products as $product) {
                    if (! $product instanceof Product) {
                        continue;
                    }
                    $assoc = $this->rowFromProduct($product);
                    $line = array_map(static fn (string $col): string => $assoc[$col] ?? '', $this->headers());
                    $sheet->fromArray([$line], null, 'A'.$rowIndex);
                    $rowIndex++;
                }
            });

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * @param  array<string, mixed>  $specs
     * @return list<string>
     */
    protected function collectImageUrls(Product $product, array $specs): array
    {
        $urls = [];

        $push = function (?string $candidate) use (&$urls): void {
            $candidate = trim((string) $candidate);
            if ($candidate === '') {
                return;
            }
            if (str_starts_with($candidate, 'http://') || str_starts_with($candidate, 'https://') || str_starts_with($candidate, '//')) {
                $urls[] = $candidate;

                return;
            }
            if (Product::isAcceptableImageSource($candidate)) {
                $urls[] = Product::publicUrlForPath($candidate);
            }
        };

        $push($product->getRawOriginal('image') ?: null);

        $gallery = $product->images;
        if (is_array($gallery)) {
            foreach ($gallery as $item) {
                $push(is_string($item) ? $item : null);
            }
        }

        $bearingImage = trim((string) ($specs['bearing_image'] ?? ''));
        if ($bearingImage !== '' && (str_starts_with($bearingImage, 'http') || str_starts_with($bearingImage, '//'))) {
            $push($bearingImage);
        }

        return array_values(array_unique($urls));
    }

    /**
     * @param  array<string, mixed>  $specs
     */
    protected function exportSpecValue(array $specs, string $key): string
    {
        $value = trim((string) ($specs[$key] ?? ''));
        if ($value === '') {
            return '';
        }

        if ($key === 'weight') {
            return preg_replace('/\s*kg\s*$/i', '', $value) ?? $value;
        }

        return preg_replace('/\s*(mm|kn|r\/min|rpm)\s*$/i', '', $value) ?? $value;
    }
}
