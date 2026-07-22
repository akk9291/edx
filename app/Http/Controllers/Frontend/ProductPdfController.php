<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProductPdfController extends Controller
{
    public function preview(string $slug)
    {
        return $this->respondPdf($slug, true);
    }

    public function download(string $slug)
    {
        return $this->respondPdf($slug, false);
    }

    protected function respondPdf(string $slug, bool $inline)
    {
        $product = \App\Models\PillowBlock::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->first();

        if (!$product) {
            $product = Product::edxBearingsCatalog()
                ->where('slug', $slug)
                ->where('is_active', true)
                ->with('category')
                ->firstOrFail();
        }

        $pdfLogoSrc = $this->fileUri(public_path('assets/images/EDX-LOGO-RULMENTI.png'));
        $pdfProductImageSrc = $this->resolveProductImageFileUri($product);

        $pdf = Pdf::loadView('pdf.product-specification', compact('product', 'pdfLogoSrc', 'pdfProductImageSrc'))
            ->setPaper('a4', 'portrait');

        $filename = $this->safeFilename($product).'.pdf';

        return $inline ? $pdf->stream($filename) : $pdf->download($filename);
    }

    protected function resolveProductImageFileUri($product): string
    {
        $path = $product->getRawOriginal('image') ?? '';
        $path = is_string($path) ? ltrim($path, '/') : '';

        if ($path !== '' && str_starts_with($path, 'assets/') && is_file(public_path($path))) {
            return $this->fileUri(public_path($path));
        }

        if ($path !== '' && Storage::disk('public')->exists($path)) {
            return $this->fileUri(storage_path('app/public/'.$path));
        }

        if ($path !== '' && is_file(public_path($path))) {
            return $this->fileUri(public_path($path));
        }

        $fallback = public_path('assets/images/PhotoshopExtension_Image-1.webp');

        return is_file($fallback) ? $this->fileUri($fallback) : '';
    }

    protected function fileUri(string $absolutePath): string
    {
        $resolved = realpath($absolutePath);

        if ($resolved === false) {
            return '';
        }

        return 'file://'.$resolved;
    }

    protected function safeFilename($product): string
    {
        $base = $product->sku ?: $product->slug ?: 'product';
        $base = preg_replace('/[^a-zA-Z0-9_-]+/', '-', $base) ?: 'product';
        $base = strtoupper($base);
        $prefix = 'EDX-';
        if (! str_starts_with($base, $prefix)) {
            $base = $prefix.$base;
        }

        return $base;
    }
}
