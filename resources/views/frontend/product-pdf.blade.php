@extends('layouts.frontend')

@section('title', $product->display_name . ' - PDF - EDX Rulmenti Romania')

@section('content')
    <div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
        <div class="breadcrumb-main overflow-hidden">
            <div class="container pt-1 pb-1 relative"></div>
        </div>
    </div>

    <div class="container py-10 md:py-14">
        <h1 class="heading4 mb-2">{{ $product->display_name }}</h1>
        <p class="text-secondary body1 mb-8">Product sheet — preview in the browser or download a PDF that includes EDX header and footer.</p>

        <div class="flex flex-wrap gap-4 justify-center md:justify-start">
            <a href="{{ route('frontend.product.pdf.preview', $product->slug) }}" target="_blank" rel="noopener noreferrer" class="button-main text-center inline-block">Preview PDF</a>
            <a href="{{ route('frontend.product.pdf.download', $product->slug) }}" class="button-main bg-black text-center inline-block">Download PDF</a>
        </div>

        <div class="mt-10 rounded-lg border border-line overflow-hidden bg-surface" style="min-height: 720px;">
            <iframe
                src="{{ route('frontend.product.pdf.preview', $product->slug) }}"
                class="w-full border-0"
                style="height: 75vh; min-height: 640px;"
                title="Product PDF preview"
            ></iframe>
        </div>
    </div>
@endsection
