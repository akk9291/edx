@extends('admin.layout')

@section('title', 'Policy Pages')
@section('page-title', 'Policy Pages')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">Policy & Legal Pages</h4>
            <p class="text-muted mb-0">Edit About Us, Terms & Conditions, Privacy Policy, Return & Refund, and Cancellation Policy. Content is shown on the frontend.</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Slug / URL</th>
                                <th>Status</th>
                                <th>Last updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td class="fw-semibold">{{ $page->title }}</td>
                                    <td><code>/{{ $page->slug }}</code></td>
                                    <td>
                                        @if($page->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $page->updated_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.policy-pages.edit', $page) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>
                                        <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View on site">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pages->isEmpty())
                    <p class="text-muted text-center py-4 mb-0">No policy pages found. Run <code>php artisan db:seed --class=PolicyPageSeeder</code> to create default pages.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
