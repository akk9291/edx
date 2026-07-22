{{-- EDX Product Category — Premium Vertical Grid Card Design (Centered Text & Compact) --}}
@php
    $categoryCards = ($categories ?? collect())->take(6);
@endphp
@if($categoryCards->isNotEmpty())
<style>
.edx-cat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.edx-cat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    border-color: #ec2127 !important;
}
.edx-cat-card:hover .bg-stone-50 {
    background-color: #f5f5f4 !important;
}
.edx-cat-card img {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.edx-cat-card:hover img {
    transform: scale(1.06);
}
.edx-cat-btn {
    background-color: #f4f4f5;
    color: #27272a;
    transition: all 0.3s ease;
}
.edx-cat-card:hover .edx-cat-btn {
    background-color: #ec2127;
    color: #ffffff;
}
</style>

<div class="banner-block md:pt-10 pt-6 md:pb-8 pb-5 border-b border-line bg-[#fcfcfc]">
    <div class="container">
        <div class="heading text-center mb-6">
            <h2 class="heading4 text-black font-bold">EDX Product Categories</h2>
            <p class="text-secondary mt-1 text-sm">Explore our premium selection of precision bearing units</p>
        </div>
        <div class="list-banner grid sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-[16px] mt-6">
            @foreach($categoryCards as $category)
                @php
                    $imgUrl = $category->image
                        ? storage_asset($category->image)
                        : asset('assets/images/PhotoshopExtension_Image-1.webp');
                    $desc = trim(strip_tags((string) ($category->description ?? '')));
                    if ($desc === '') {
                        $desc = 'Precision engineered components delivering high speed, silent rotation, and long service life.';
                    } else {
                        $desc = \Illuminate\Support\Str::limit($desc, 120);
                    }
                @endphp
                <a href="{{ route('frontend.range', ['category' => $category->slug]) }}"
                   class="edx-cat-card block bg-white rounded-xl border border-line p-4 no-underline text-inherit flex flex-col justify-between h-full">
                    <div>
                        {{-- Fixed height wrapper for thumbnail to make it compact --}}
                        <div class="h-[180px] w-full bg-stone-50 rounded-lg overflow-hidden flex items-center justify-center p-4 relative transition-colors duration-300">
                            <img src="{{ $imgUrl }}" alt="{{ $category->name }}" class="max-w-full max-h-full object-contain pointer-events-none" loading="lazy" width="200" height="200">
                        </div>
                        <div class="heading6 text-black font-bold mt-3 leading-snug text-center">{{ $category->name }}</div>
                        <div class="body2 mt-1 text-secondary text-xs leading-relaxed line-clamp-3 text-center" style="min-height: 3rem;">{{ $desc }}</div>
                    </div>
                    <div class="mt-4">
                        <span class="edx-cat-btn w-full text-center py-2.5 px-3 rounded-lg inline-flex items-center justify-center gap-2 uppercase text-[0.6875rem] font-bold tracking-[0.06em]">
                            View products <i class="ph ph-arrow-right text-xs" aria-hidden="true"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
