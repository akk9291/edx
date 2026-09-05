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
        // 1. Gather potential image candidates in priority order:
        //    a) Product's own resolved image
        //    b) Product raw image
        //    c) Category image
        $candidates = [];

        if (method_exists($product, 'resolveMainImagePath')) {
            $candidates[] = $product->resolveMainImagePath();
        }

        $candidates[] = $product->getRawOriginal('image');

        if (isset($product->category) && ! empty($product->category->image)) {
            $candidates[] = $product->category->image;
        }

        foreach ($candidates as $candidate) {
            if (! is_string($candidate) || trim($candidate) === '') {
                continue;
            }
            $uri = $this->resolveDiskFileUri(trim($candidate));
            if ($uri !== '') {
                return $uri;
            }
        }

        // Final fallback: default image
        $fallback = public_path('assets/images/PhotoshopExtension_Image-1.webp');
        if (is_file($fallback)) {
            return $this->fileUri($fallback);
        }

        return '';
    }

    protected function resolveDiskFileUri(string $path): string
    {
        $path = ltrim(trim($path), '/');
        if ($path === '' || str_contains($path, 'PhotoshopExtension_Image-1.webp')) {
            return '';
        }

        // If ghost export filename that doesn't exist on disk, skip
        if (preg_match('/^edx-[^\/]+\.(jpg|jpeg|png|webp)$/i', $path)) {
            $disk = storage_path('app/public/'.$path);
            if (! is_file($disk)) {
                return '';
            }
        }

        // Strip leading storage/ or media/
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        } elseif (str_starts_with($path, 'media/')) {
            $path = substr($path, 6);
        }

        // 1. Check storage/app/public/
        $storagePath = storage_path('app/public/'.$path);
        if (is_file($storagePath)) {
            return $this->fileUri($storagePath);
        }

        // 2. Check public/storage/
        $pubStoragePath = public_path('storage/'.$path);
        if (is_file($pubStoragePath)) {
            return $this->fileUri($pubStoragePath);
        }

        // 3. Check public_path() (e.g. assets/...)
        if (is_file(public_path($path))) {
            return $this->fileUri(public_path($path));
        }

        // 4. Check Storage disk public exists
        if (Storage::disk('public')->exists($path)) {
            $fullPath = Storage::disk('public')->path($path);
            if (is_file($fullPath)) {
                return $this->fileUri($fullPath);
            }
        }

        return '';
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
