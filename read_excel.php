<?php
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$path = __DIR__ . '/pillow-block.xlsx';
try {
    $spreadsheet = IOFactory::load($path);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, false);
    
    if (count($data) < 2) {
        echo "Too few rows\n";
        exit;
    }
    
    $header1 = array_shift($data);
    $header2 = array_shift($data);
    
    $cols = count($header2);
    $summary = [];
    for ($i = 0; $i < $cols; $i++) {
        $summary[$i] = [
            'name' => ($header1[$i] ? $header1[$i] . ' / ' : '') . $header2[$i],
            'non_empty_count' => 0,
            'numeric_count' => 0,
            'samples' => [],
        ];
    }
    
    foreach ($data as $row) {
        for ($i = 0; $i < $cols; $i++) {
            $val = trim($row[$i] ?? '');
            if ($val !== '') {
                $summary[$i]['non_empty_count']++;
                if (is_numeric($val)) {
                    $summary[$i]['numeric_count']++;
                }
                if (count($summary[$i]['samples']) < 5) {
                    $summary[$i]['samples'][] = $val;
                }
            }
        }
    }
    
    foreach ($summary as $i => $info) {
        echo "Col {$i}: {$info['name']}\n";
        echo "  Non-empty: {$info['non_empty_count']} / " . count($data) . "\n";
        echo "  Numeric: {$info['numeric_count']}\n";
        echo "  Samples: " . implode(', ', $info['samples']) . "\n\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
