@php
    $reviewStats = $reviewStats ?? ['avg' => 0, 'count' => 0, 'distribution' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]];
    $reviews = $reviews ?? collect();
    $distribution = $reviewStats['distribution'] ?? [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    $total = $reviewStats['count'] ?? 0;
@endphp
<div class="top-overview flex max-sm:flex-col items-center justify-between gap-12 gap-y-4">
    <div class="left flex max-sm:flex-col gap-y-4 items-center justify-between lg:w-1/2 sm:w-2/3 w-full sm:pr-5">
        <div class="rating flex flex-col items-center">
            <div class="text-display">{{ $total > 0 ? number_format($reviewStats['avg'], 1) : '0' }}</div>
            <div class="flex flex-col items-center">
                <div class="rate flex">
                    @for ($s = 1; $s <= 5; $s++)
                        <i class="ph {{ $s <= round($reviewStats['avg']) ? 'ph-fill' : 'ph' }} ph-star text-lg {{ $s <= round($reviewStats['avg']) ? 'text-yellow' : 'text-line' }}"></i>
                    @endfor
                </div>
                <div class="text-secondary text-center mt-1">({{ number_format($total) }} {{ $total === 1 ? 'Rating' : 'Ratings' }})</div>
            </div>
        </div>
        @if($total > 0)
        <div class="list-rating w-2/3">
            @foreach ([5, 4, 3, 2, 1] as $star)
                @php $pct = $total > 0 ? round(($distribution[$star] ?? 0) / $total * 100) : 0; @endphp
                <div class="item flex items-center justify-between gap-1.5 {{ $loop->first ? '' : 'mt-1' }}">
                    <div class="flex items-center gap-1">
                        <div class="caption1">{{ $star }}</div>
                        <i class="ph-fill ph-star text-sm"></i>
                    </div>
                    <div class="progress bg-line relative w-3/4 h-2">
                        <div class="progress-percent absolute bg-yellow h-full left-0 top-0" style="width: {{ $pct }}%;"></div>
                    </div>
                    <div class="caption1">{{ $pct }}%</div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="right">
        <a href="#form-review" class="button-main bg-white text-black border border-black whitespace-nowrap">Write Reviews</a>
    </div>
</div>
<div class="list-review mt-8">
    <div class="heading flex items-center justify-between flex-wrap gap-4">
        <div class="heading4">{{ $reviews->count() }} {{ $reviews->count() === 1 ? 'Comment' : 'Comments' }}</div>
    </div>
    @forelse($reviews as $review)
    <div class="item mt-6 pb-6 border-b border-line review-item" data-review-id="{{ $review->id }}">
        <div class="heading flex items-center justify-between">
            <div class="user-infor flex gap-4">
                <div class="avatar">
                    <div class="w-[52px] h-[52px] rounded-full bg-line flex items-center justify-center text-title">{{ strtoupper(substr($review->reviewer_name, 0, 1)) }}</div>
                </div>
                <div class="user">
                    <div class="flex items-center gap-2">
                        <div class="text-title">{{ $review->reviewer_name }}</div>
                        <div class="span text-line">-</div>
                        <div class="rate flex">
                            @for ($s = 1; $s <= 5; $s++)
                                <i class="ph {{ $s <= $review->rating ? 'ph-fill' : 'ph' }} ph-star text-xs {{ $s <= $review->rating ? 'text-yellow' : 'text-line' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="text-secondary2">{{ $review->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
            @auth
            @if(auth()->user()->isAdmin())
            <form action="{{ route('admin.reviews.destroy', $review) }}" method="post" class="inline-block delete-review-form" onsubmit="return confirm('Delete this review?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-secondary2 hover:text-red-600 text-sm cursor-pointer" title="Delete review"><i class="ph ph-trash"></i></button>
            </form>
            @endif
            @endauth
        </div>
        <div class="mt-3">{{ $review->comment ? e($review->comment) : '—' }}</div>
    </div>
    @empty
    <div class="py-6 text-secondary2">No reviews yet. Be the first to leave a comment!</div>
    @endforelse
</div>
<div id="form-review" class="form-review pt-8">
    <div class="heading4">Leave A comment</div>
    @if(session('success'))
        <p class="mt-3 text-green font-medium">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="mt-3 text-red-600 font-medium">{{ session('error') }}</p>
    @endif
    @if($errors->any())
        <ul class="mt-3 text-red-600 list-disc list-inside">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    @endif
    @auth
    <form action="{{ route('product.review.store', $product) }}" method="post" class="grid sm:grid-cols-2 gap-4 gap-y-5 mt-6">
        @csrf
        <div class="col-span-full">
            <label class="block caption1 mb-1">Rating *</label>
            <select name="rating" class="border border-line px-4 py-3 rounded-lg w-full max-w-[120px]" required>
                @for ($r = 5; $r >= 1; $r--)
                    <option value="{{ $r }}" {{ (int) old('rating', 5) === $r ? 'selected' : '' }}>{{ $r }} {{ $r === 1 ? 'star' : 'stars' }}</option>
                @endfor
            </select>
        </div>
        <div class="col-span-full message">
            <textarea class="border border-line px-4 py-3 w-full rounded-lg" name="comment" rows="4" placeholder="Your review (optional)">{{ old('comment') }}</textarea>
        </div>
        <div class="col-span-full sm:pt-3">
            <button type="submit" class="button-main bg-white text-black border border-black">Submit Review</button>
        </div>
    </form>
    @else
    <p class="mt-4 text-secondary2">You must be logged in to leave a review. <a href="{{ route('login') }}" class="text-black font-semibold hover:underline">Log in</a></p>
    @endauth
</div>
