<?php

namespace App\Services;

use App\Models\PillowBlock;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PillowBlockCatalogExportService
{
    public const HEADER_ROW_1 = [
        '',
        '',
        // Optional fields headers
        '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
    ];

    public const HEADER_ROW_2 = [
        'Bearing number',
        'Specifications',
        // Optional fields
        'name',
        'sku',
        'category_id',
        'brand',
        'short_description',
        'description',
        'price',
        'sale_price',
        'image_url',
        'video',
        'pdf_catalogue',
        'equiv_skf',
        'equiv_fag',
        'equiv_ntn',
        'equiv_timken',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active'
    ];

    public function rowFromPillowBlock(PillowBlock $pb): array
    {
        $gallery = $pb->images;
        $galleryStr = count($gallery) > 0 ? implode(',', $gallery) : '';

        $specs = $pb->specifications;
        $formatted = [];
        if (is_array($specs)) {
            foreach ($specs as $spec) {
                $t = trim($spec['title'] ?? '');
                $d = trim($spec['dimension'] ?? '');
                $v = trim($spec['value'] ?? '');
                if ($t !== '' || $d !== '' || $v !== '') {
                    $formatted[] = "{$t}|{$d}|{$v}";
                }
            }
        }
        $specificationsStr = implode(';', $formatted);

        return [
            'Bearing number' => (string)$pb->bearing_number,
            'Specifications' => $specificationsStr,
            
            // Optional
            'name' => (string)$pb->name,
            'sku' => (string)$pb->sku,
            'category_id' => $pb->category_id !== null ? (string)$pb->category_id : '',
            'brand' => (string)$pb->brand,
            'short_description' => (string)$pb->short_description,
            'description' => (string)$pb->description,
            'price' => $pb->price !== null ? (string)$pb->price : '',
            'sale_price' => $pb->sale_price !== null ? (string)$pb->sale_price : '',
            'image_url' => $pb->image !== null ? (string)$pb->image : '',
            'video' => $pb->video !== null ? (string)$pb->video : '',
            'pdf_catalogue' => $pb->pdf_catalogue !== null ? (string)$pb->pdf_catalogue : '',
            'equiv_skf' => (string)$pb->equiv_skf,
            'equiv_fag' => (string)$pb->equiv_fag,
            'equiv_ntn' => (string)$pb->equiv_ntn,
            'equiv_timken' => (string)$pb->equiv_timken,
            'meta_title' => (string)$pb->meta_title,
            'meta_description' => (string)$pb->meta_description,
            'meta_keywords' => (string)$pb->meta_keywords,
            'is_active' => $pb->is_active ? '1' : '0'
        ];
    }

    public function downloadCsv(Builder $query): StreamedResponse
    {
        $filename = 'pillow-block-export-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($query): void {
            $out = fopen('php://output', 'w');
            if ($out === false) {
                return;
            }
            fwrite($out, "\xEF\xBB\xBF");
            
            // Write both header rows
            fputcsv($out, self::HEADER_ROW_1);
            fputcsv($out, self::HEADER_ROW_2);

            (clone $query)->orderBy('id')->chunkById(200, function ($pbs) use ($out): void {
                foreach ($pbs as $pb) {
                    if (! $pb instanceof PillowBlock) {
                        continue;
                    }
                    $assoc = $this->rowFromPillowBlock($pb);
                    $line = array_map(static fn (string $col): string => $assoc[$col] ?? '', self::HEADER_ROW_2);
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
        $filename = 'pillow-block-export-'.now()->format('Y-m-d-His').'.xlsx';

        return response()->streamDownload(function () use ($query): void {
            $spreadsheet = new Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();
            
            // Write both header rows
            $sheet->fromArray([self::HEADER_ROW_1], null, 'A1');
            $sheet->fromArray([self::HEADER_ROW_2], null, 'A2');

            $rowIndex = 3;
            (clone $query)->orderBy('id')->chunkById(200, function ($pbs) use ($sheet, &$rowIndex): void {
                foreach ($pbs as $pb) {
                    if (! $pb instanceof PillowBlock) {
                        continue;
                    }
                    $assoc = $this->rowFromPillowBlock($pb);
                    $line = array_map(static fn (string $col): string => $assoc[$col] ?? '', self::HEADER_ROW_2);
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
}
