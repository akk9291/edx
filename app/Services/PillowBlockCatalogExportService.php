<?php

namespace App\Services;

use App\Models\PillowBlock;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PillowBlockCatalogExportService
{
    /**
     * Resolve all unique specifications in the query, starting with known default specs.
     */
    protected function getUniqueSpecs(Builder $query): array
    {
        $dbSpecs = [];
        (clone $query)->orderBy('id')->chunk(200, function ($pbs) use (&$dbSpecs) {
            foreach ($pbs as $pb) {
                if (is_array($pb->specifications)) {
                    foreach ($pb->specifications as $spec) {
                        $t = trim($spec['title'] ?? '');
                        $d = trim($spec['dimension'] ?? '');
                        if ($t !== '' || $d !== '') {
                            $key = strtolower($t) . '|' . strtolower($d);
                            $dbSpecs[$key] = ['title' => $t, 'dimension' => $d];
                        }
                    }
                }
            }
        });

        $knownSpecs = [
            ['title' => 'inner dimension', 'dimension' => 'd ( inch and mm)'],
            ['title' => 'Shaft diameter', 'dimension' => 'd'],
            ['title' => 'Distance mounting base to centerline spheric. seating diam.', 'dimension' => 'h'],
            ['title' => 'Housing length', 'dimension' => 'a'],
            ['title' => 'Mounting holes distance', 'dimension' => 'e'],
            ['title' => 'Housing width', 'dimension' => 'b'],
            ['title' => ' Mounting hole length', 'dimension' => 'S2'],
            ['title' => 'Width of Inner Ring', 'dimension' => 'S1'],
            ['title' => 'Housing foot height', 'dimension' => 'g'],
            ['title' => 'Housing height', 'dimension' => 'w'],
            ['title' => 'Housing top width', 'dimension' => 'Bi'],
            ['title' => 'Distance front side/bearing centre', 'dimension' => 'n'],
            ['title' => 'bearing no.', 'dimension' => ''],
            ['title' => 'Housing No.', 'dimension' => ''],
            ['title' => 'Weight', 'dimension' => ''],
            ['title' => 'speed Tolerances Grades', 'dimension' => 'J7']
        ];

        $uniqueSpecs = $knownSpecs;
        $seen = [];
        foreach ($knownSpecs as $spec) {
            $seen[strtolower($spec['title']) . '|' . strtolower($spec['dimension'])] = true;
        }
        foreach ($dbSpecs as $key => $spec) {
            if (!isset($seen[$key])) {
                $uniqueSpecs[] = $spec;
                $seen[$key] = true;
            }
        }

        return $uniqueSpecs;
    }

    /**
     * Get headers for export based on unique specifications.
     */
    protected function getHeaders(array $uniqueSpecs): array
    {
        $headerRow1 = ['Bearing number'];
        $headerRow2 = [''];

        foreach ($uniqueSpecs as $spec) {
            $headerRow1[] = $spec['title'];
            $headerRow2[] = $spec['dimension'] !== '' ? $spec['dimension'] : '';
        }

        $otherColumns = [
            'equiv_skf' => 'SKF',
            'equiv_fag' => 'FAG',
            'equiv_ntn' => 'NTN',
            'equiv_timken' => 'TIMKEN',
            'brand' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'price' => '',
            'sale_price' => '',
            'name' => '',
            'sku' => '',
            'category_id' => '',
            'short_description' => '',
            'description' => '',
            'image_url' => '',
            'video' => '',
            'pdf_catalogue' => '',
            'is_active' => ''
        ];

        foreach ($otherColumns as $col1 => $col2) {
            $headerRow1[] = $col1;
            $headerRow2[] = $col2;
        }

        return [$headerRow1, $headerRow2];
    }

    /**
     * Get row data for a single PillowBlock.
     */
    public function rowFromPillowBlock(PillowBlock $pb, array $uniqueSpecs): array
    {
        $row = [];
        $row[] = (string)$pb->bearing_number;

        $specsMap = [];
        if (is_array($pb->specifications)) {
            foreach ($pb->specifications as $spec) {
                $t = strtolower(trim($spec['title'] ?? ''));
                $d = strtolower(trim($spec['dimension'] ?? ''));
                $specsMap[$t . '|' . $d] = trim($spec['value'] ?? '');
            }
        }

        foreach ($uniqueSpecs as $spec) {
            $key = strtolower($spec['title']) . '|' . strtolower($spec['dimension']);
            $row[] = $specsMap[$key] ?? '';
        }

        $row[] = (string)$pb->equiv_skf;
        $row[] = (string)$pb->equiv_fag;
        $row[] = (string)$pb->equiv_ntn;
        $row[] = (string)$pb->equiv_timken;
        $row[] = (string)$pb->brand;
        $row[] = (string)$pb->meta_title;
        $row[] = (string)$pb->meta_description;
        $row[] = (string)$pb->meta_keywords;
        $row[] = $pb->price !== null ? (string)$pb->price : '';
        $row[] = $pb->sale_price !== null ? (string)$pb->sale_price : '';
        $row[] = (string)$pb->name;
        $row[] = (string)$pb->sku;
        $row[] = $pb->category_id !== null ? (string)$pb->category_id : '';
        $row[] = (string)$pb->short_description;
        $row[] = (string)$pb->description;
        $row[] = $pb->image !== null ? (string)$pb->image : '';
        $row[] = $pb->video !== null ? (string)$pb->video : '';
        $row[] = $pb->pdf_catalogue !== null ? (string)$pb->pdf_catalogue : '';
        $row[] = $pb->is_active ? '1' : '0';

        return $row;
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
            
            $uniqueSpecs = $this->getUniqueSpecs($query);
            [$headerRow1, $headerRow2] = $this->getHeaders($uniqueSpecs);

            fputcsv($out, $headerRow1);
            fputcsv($out, $headerRow2);

            (clone $query)->orderBy('id')->chunkById(200, function ($pbs) use ($out, $uniqueSpecs): void {
                foreach ($pbs as $pb) {
                    if (! $pb instanceof PillowBlock) {
                        continue;
                    }
                    $line = $this->rowFromPillowBlock($pb, $uniqueSpecs);
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
            
            $uniqueSpecs = $this->getUniqueSpecs($query);
            [$headerRow1, $headerRow2] = $this->getHeaders($uniqueSpecs);

            $sheet->fromArray([$headerRow1], null, 'A1');
            $sheet->fromArray([$headerRow2], null, 'A2');

            $rowIndex = 3;
            (clone $query)->orderBy('id')->chunkById(200, function ($pbs) use ($sheet, &$rowIndex, $uniqueSpecs): void {
                foreach ($pbs as $pb) {
                    if (! $pb instanceof PillowBlock) {
                        continue;
                    }
                    $line = $this->rowFromPillowBlock($pb, $uniqueSpecs);
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
