<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use PhpOffice\PhpSpreadsheet\IOFactory;

$path = 'C:\Users\akk92\Downloads\pillow-block-export-2026-07-09-065425 (1).xlsx';
if (!file_exists($path)) {
    echo "File not found at $path\n";
    exit;
}

$spreadsheet = IOFactory::load($path);
$sheet = $spreadsheet->getActiveSheet();
$data = $sheet->toArray(null, true, true, false);

echo "Total rows: " . count($data) . "\n";
echo "Row 0: " . json_encode($data[0] ?? []) . "\n";
echo "Row 1: " . json_encode($data[1] ?? []) . "\n";

foreach ($data as $idx => $row) {
    if ($idx < 2) continue;
    // Check if the bearing number / SKU matches UCPG 208
    // Let's print the row if SKU / Column 0 / Column 3 matches UCPG 208
    $val = $row[0] ?? '';
    if (strpos((string)$val, 'UCPG 208') !== false || strpos((string)($row[3] ?? ''), 'UCPG 208') !== false) {
        echo "Row $idx: " . json_encode($row) . "\n";
    }
}
