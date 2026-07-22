{{-- Admin: Instagram Reels. Uses $instagramReels from view composer (or empty). --}}
@php
    $igReels = isset($instagramReels) ? $instagramReels : collect();
    $igReels = $igReels->filter(function ($r) {
        return $r->embed_url;
    });
@endphp
<div class="instagram-block md:pt-20 pt-10">
    <div class="container">
        <div class="heading">
            <div class="heading3 text-center">Perch On Instagram</div>
            <div class="text-center mt-3">#perch.bottle</div>
        </div>
        <div class="list-instagram md:mt-10 mt-6">
            <div class="swiper swiper-list-instagram">
                <div class="swiper-wrapper">
                    @forelse($igReels as $reel)
                        <div class="swiper-slide !h-auto">
                            <div class="item item--embed relative block rounded-[32px] overflow-hidden bg-black shadow-sm mx-auto"
                                 style="aspect-ratio: 9/16; max-height: 520px; max-width: 292px; width: 100%;">
                                <iframe
                                    src="{{ $reel->embed_url }}"
                                    class="absolute inset-0 z-[1] w-full h-full border-0"
                                    style="min-height: 360px;"
                                    loading="lazy"
                                    allowfullscreen
                                    allow="encrypted-media; clipboard-write; autoplay; picture-in-picture"
                                    title="Instagram reel"
                                ></iframe>
                                <a href="{{ $reel->url }}" target="_blank" rel="noopener noreferrer"
                                   class="group absolute top-3 right-3 z-[3] w-11 h-11 bg-white hover:bg-black duration-300 flex items-center justify-center rounded-xl shadow-md pointer-events-auto"
                                   aria-label="Open on Instagram">
                                    <span class="icon-instagram text-xl text-black group-hover:text-white duration-300"></span>
                                </a>
                            </div>
                        </div>
                    @empty
                        @foreach([1,2,3,4,5,1] as $imgNum)
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1('.$imgNum.').webp') }}" alt="" class="h-full w-full duration-500 relative object-cover" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
