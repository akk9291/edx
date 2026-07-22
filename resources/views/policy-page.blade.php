@extends('layouts.app')

@section('title', $page->title . ' - Perch Bottle')

@section('content')
<div class="page-content policy-page-content">
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">{{ $page->title }}</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2">{{ $page->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="policy-page-block md:py-20">
        <div class="container">
            <div class="content max-w-4xl mx-auto">
                <div class="body1 text-secondary policy-page-body">
                    @if(!empty(trim((string)$page->content)))
                        @php
                            $allowed = '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><div><span><img><table><thead><tbody><tr><td><th><hr><blockquote><pre><code><section><article><header><footer><figure><figcaption>';
                            $html = strip_tags($page->content, $allowed);
                        @endphp
                        {!! $html !!}
                    @else
                        <p>Content for this page is being updated. Please check back later or <a href="{{ route('contact') }}" class="text-button hover:underline">contact us</a> for more information.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.policy-page-body { line-height: 1.7; }
.policy-page-body p { margin-bottom: 1.5rem; color: inherit; }
.policy-page-body p:first-child { margin-top: 0; }
.policy-page-body h1, .policy-page-body h2, .policy-page-body h3, .policy-page-body h4 { font-weight: 600; color: #000 !important; margin-top: 2.5rem; margin-bottom: 1rem; display: block; }
.policy-page-body h1 { font-size: 1.75rem; }
.policy-page-body h2 { font-size: 1.5rem; }
.policy-page-body h3 { font-size: 1.25rem; }
.policy-page-body h4 { font-size: 1.125rem; }
.policy-page-body h5,
.policy-page-body .heading5 { font-weight: 600; color: #000 !important; margin-top: 2.5rem; margin-bottom: 1rem; font-size: 1.125rem; display: block; }
.policy-page-body h6,
.policy-page-body .heading6 { font-weight: 600; color: #000 !important; margin-top: 2rem; margin-bottom: 1rem; font-size: 1rem; display: block; }
.policy-page-body a,
.policy-page-body .text-button { color: var(--color-button, #667eea); text-decoration: none; }
.policy-page-body a:hover,
.policy-page-body .text-button:hover { text-decoration: underline; }
.policy-page-body ul { list-style: disc; padding-left: 1.5rem; margin: 1.5rem 0; }
.policy-page-body ol { list-style: decimal; padding-left: 1.5rem; margin: 1.5rem 0; }
.policy-page-body li { margin-bottom: 0.75rem; }
.policy-page-body img { max-width: 100%; height: auto; display: block; margin: 1.5rem 0; border-radius: 0.5rem; }
.policy-page-body table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; }
.policy-page-body th, .policy-page-body td { border: 1px solid #e2e8f0; padding: 0.75rem 1rem; text-align: left; }
.policy-page-body th { font-weight: 600; background: #f7fafc; }
.policy-page-body hr { border: none; border-top: 1px solid #e2e8f0; margin: 2rem 0; }
.policy-page-body blockquote { border-left: 4px solid #cbd5e0; padding-left: 1.5rem; margin: 1.5rem 0; color: #4a5568; }
.policy-page-body .mt-8 { margin-top: 2rem; }
.policy-page-body .mt-6 { margin-top: 1.5rem; }
.policy-page-body div, .policy-page-body section, .policy-page-body article { margin-bottom: 1rem; }

/* Mobile spacing improvements */
@media (max-width: 767.98px) {
    .policy-page-body { line-height: 1.6; }
    .policy-page-body p { margin-bottom: 1.25rem; }
    .policy-page-body h1, .policy-page-body h2, .policy-page-body h3, .policy-page-body h4 { margin-top: 2rem; margin-bottom: 0.75rem; }
    .policy-page-body h5, .policy-page-body .heading5 { margin-top: 2rem; margin-bottom: 0.75rem; }
    .policy-page-body h6, .policy-page-body .heading6 { margin-top: 1.75rem; margin-bottom: 0.75rem; }
    .policy-page-body ul, .policy-page-body ol { margin: 1.25rem 0; }
    .policy-page-body li { margin-bottom: 0.5rem; }
    .policy-page-body img { margin: 1.25rem 0; }
    .policy-page-body table { margin: 1.25rem 0; }
    .policy-page-body th, .policy-page-body td { padding: 0.5rem 0.75rem; }
    .policy-page-body hr { margin: 1.5rem 0; }
    .policy-page-body blockquote { margin: 1.25rem 0; padding-left: 1rem; }
    .policy-page-body div, .policy-page-body section, .policy-page-body article { margin-bottom: 0.75rem; }
    
    /* Remove extra space on mobile - aggressive approach */
    .policy-page-block { 
        padding: 0 !important; 
        margin: 0 !important;
        padding-top: 2.5rem !important; /* Keep some top spacing */
    }
    .policy-page-block .container {
        padding: 0 !important;
        margin: 0 !important;
    }
    .policy-page-block .content {
        padding: 0 !important;
        margin: 0 !important;
    }
    .policy-page-body {
        padding: 0 !important;
        margin: 0 !important;
    }
    .policy-page-body p:last-child {
        margin-bottom: 0 !important;
    }
    
    /* Target footer to remove top spacing */
    .footer {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    .footer-main {
        padding-top: 1rem !important; /* Minimal top padding */
    }
}
</style>
@endsection
