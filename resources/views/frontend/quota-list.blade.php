@extends('layouts.frontend')

@section('title', 'Quota list - EDX Rulmenti Romania')

@section('content')
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">Quota list</div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div>Quota list</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container md:py-16 py-10">
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg border border-green-200 bg-green-50 text-green-900">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg border border-red-200 bg-red-50 text-red-900">{{ session('error') }}</div>
    @endif

    @if(! ($hasAnyLines ?? false))
        <p class="text-secondary text-lg mb-8">Your quota list is empty. Browse the <a href="{{ route('frontend.range') }}" class="underline text-black">product range</a> and add items.</p>
    @else
        @if($hasStaleRows ?? false)
            <div class="mb-6 p-4 rounded-lg border border-amber-200 bg-amber-50 text-amber-950">
                Some saved items are no longer in the catalogue. Remove them below or clear the list.
            </div>
            <div class="overflow-x-auto border border-line rounded-xl mb-8">
                <table class="w-full text-left text-sm">
                    <thead class="bg-surface border-b border-line">
                        <tr>
                            <th class="p-4 font-semibold">Product ID</th>
                            <th class="p-4 font-semibold w-28"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            @if(!$row['product'] && $row['product_id'])
                            <tr class="border-b border-line last:border-0">
                                <td class="p-4 text-secondary">#{{ $row['product_id'] }} (unavailable)</td>
                                <td class="p-4">
                                    <form method="POST" action="{{ route('frontend.quota-list.remove') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $row['product_id'] }}">
                                        <input type="hidden" name="product_type" value="{{ $row['product_type'] }}">
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($hasValidRows ?? false)
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <p class="text-secondary mb-0">Review quantities, then send the list for a formal quotation.</p>
                <form method="POST" action="{{ route('frontend.quota-list.clear') }}" onsubmit="return confirm('Clear all products from your quota list?');">
                    @csrf
                    <button type="submit" class="text-sm border border-line rounded-lg px-4 py-2 hover:bg-surface">Clear entire list</button>
                </form>
            </div>

            <div class="overflow-x-auto border border-line rounded-xl mb-10">
                <table class="w-full text-left text-sm">
                    <thead class="bg-surface border-b border-line">
                        <tr>
                            <th class="p-4 font-semibold">Product</th>
                            <th class="p-4 font-semibold">SKU</th>
                            <th class="p-4 font-semibold w-40">Qty</th>
                            <th class="p-4 font-semibold w-28"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            @if($row['product'])
                            <tr class="border-b border-line last:border-0">
                                <td class="p-4">
                                    <a href="{{ route('frontend.product', $row['product']->slug) }}" class="font-semibold hover:underline">{{ $row['product']->display_name }}</a>
                                    <div class="text-secondary caption1 mt-1">{{ $row['product']->category->name ?? '' }}</div>
                                </td>
                                <td class="p-4 text-secondary">{{ $row['product']->sku ?? '—' }}</td>
                                <td class="p-4">
                                    <form method="POST" action="{{ route('frontend.quota-list.update') }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $row['product_id'] }}">
                                        <input type="hidden" name="product_type" value="{{ $row['product_type'] }}">
                                        <input type="number" name="quantity" min="1" max="99999" value="{{ $row['quantity'] }}" class="w-20 border border-line rounded-lg px-2 py-1.5">
                                        <button type="submit" class="text-sm underline">Update</button>
                                    </form>
                                </td>
                                <td class="p-4">
                                    <form method="POST" action="{{ route('frontend.quota-list.remove') }}" onsubmit="return confirm('Remove this product from your list?');">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $row['product_id'] }}">
                                        <input type="hidden" name="product_type" value="{{ $row['product_type'] }}">
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="request-quotation" class="max-w-xl scroll-mt-24 mt-10">
                <h2 class="heading5 mb-4">Request a quotation</h2>
                <p class="text-secondary mb-6">Send your list to our sales team. We will reply with availability and pricing. Confirmation emails are sent when mail is configured.</p>
                <form method="POST" action="{{ route('frontend.quota-list.submit') }}" class="flex flex-col gap-4 mt-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Company <span class="text-secondary">(optional)</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" class="w-full border border-line rounded-lg px-4 py-2.5" maxlength="255">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Contact name <span class="text-red-600">*</span></label>
                        <input type="text" name="contact_name" value="{{ old('contact_name') }}" required class="w-full border border-line rounded-lg px-4 py-2.5" maxlength="255">
                        @error('contact_name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email <span class="text-red-600">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-line rounded-lg px-4 py-2.5" maxlength="255">
                        @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Phone <span class="text-secondary">(optional)</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-line rounded-lg px-4 py-2.5" maxlength="64">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Message <span class="text-secondary">(optional)</span></label>
                        <textarea name="message" rows="4" class="w-full border border-line rounded-lg px-4 py-2.5" maxlength="5000">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="button-main  sm:w-auto text-center bg-red hover:bg-black hover:text-white text-white border border-black py-3 px-10">Submit quota request</button>
                </form>
            </div>
        @elseif($hasStaleRows ?? false)
            <p class="text-secondary">Remove unavailable lines above, then add products from the <a href="{{ route('frontend.range') }}" class="underline text-black">range</a> to build a new list.</p>
        @endif
    @endif
</div>
@endsection
