@extends('admin.layout')

@section('title', 'Quotations')
@section('page-title', 'Quotations')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Quotation requests</h4>
        <p class="text-muted mb-0">Requests submitted from the website quota list</p>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.quota-requests.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filter-status" class="form-label small text-muted mb-1">Status</label>
                        <select name="status" id="filter-status" class="form-select form-select-sm">
                            <option value="all" {{ ($status ?? '') === 'all' || ($status ?? '') === '' ? 'selected' : '' }}>All</option>
                            <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_review" {{ ($status ?? '') === 'in_review' ? 'selected' : '' }}>In review</option>
                            <option value="quoted" {{ ($status ?? '') === 'quoted' ? 'selected' : '' }}>Quoted</option>
                            <option value="closed" {{ ($status ?? '') === 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="search" class="form-label small text-muted mb-1">Search</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" value="{{ $search ?? '' }}" placeholder="Reference, name, email…">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Requests</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Lines</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quotaRequests as $req)
                            <tr>
                                <td><strong>{{ $req->reference }}</strong></td>
                                <td>{{ $req->contact_name }}</td>
                                <td>{{ $req->email }}</td>
                                <td>{{ $req->items_count }}</td>
                                <td>
                                    <span class="badge bg-{{ $req->status_badge_class }}">{{ str_replace('_', ' ', $req->status) }}</span>
                                </td>
                                <td>{{ $req->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.quota-requests.show', $req) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">No quota requests yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($quotaRequests->hasPages())
            <div class="card-footer card-footer-pagination">
                {{ $quotaRequests->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
