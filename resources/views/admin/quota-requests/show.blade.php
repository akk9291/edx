@extends('admin.layout')

@section('title', 'Quotation '.$quotaRequest->reference)
@section('page-title', 'Quotation: '.$quotaRequest->reference)

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex flex-wrap align-items-center gap-2 justify-content-between">
        <a href="{{ route('admin.quota-requests.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to list</a>
        <form method="POST" action="{{ route('admin.quota-requests.destroy', $quotaRequest) }}" onsubmit="return confirm('Delete this quota request permanently?');" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete quotation</button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer</h5>
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr><th width="180">Reference</th><td><strong>{{ $quotaRequest->reference }}</strong></td></tr>
                    <tr><th>Company</th><td>{{ $quotaRequest->company_name ?: '—' }}</td></tr>
                    <tr><th>Contact</th><td>{{ $quotaRequest->contact_name }}</td></tr>
                    <tr><th>Email</th><td><a href="mailto:{{ $quotaRequest->email }}">{{ $quotaRequest->email }}</a></td></tr>
                    <tr><th>Phone</th><td>{{ $quotaRequest->phone ?: '—' }}</td></tr>
                    <tr><th>Message</th><td>@if($quotaRequest->message){!! nl2br(e($quotaRequest->message)) !!}@else—@endif</td></tr>
                    <tr><th>Submitted</th><td>{{ $quotaRequest->created_at->format('F d, Y h:i A') }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Requested products</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotaRequest->items as $item)
                            <tr>
                                <td>{{ $item->product_sku ?? '—' }}</td>
                                <td>{{ $item->product_name ?? '—' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @php
                                        $link = null;
                                        if ($item->product) {
                                            $link = route('frontend.product', $item->product->slug);
                                        } else {
                                            $pb = \App\Models\PillowBlock::where('sku', $item->product_sku)->first();
                                            if ($pb) {
                                                $link = route('frontend.product', $pb->slug);
                                            }
                                        }
                                    @endphp
                                    @if($link)
                                        <a href="{{ $link }}" target="_blank" rel="noopener">View</a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Admin</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.quota-requests.update', $quotaRequest) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            @foreach(['pending', 'in_review', 'quoted', 'closed', 'cancelled'] as $st)
                            <option value="{{ $st }}" {{ old('status', $quotaRequest->status) === $st ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Internal notes</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="6" maxlength="10000">{{ old('admin_notes', $quotaRequest->admin_notes) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
