@extends('admin.layout')

@section('title', 'Hero Banners')
@section('page-title', 'Home Hero Banners')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Hero Banners</h4>
                <p class="text-muted mb-0">Manage the top hero slider on the homepage. Order by priority (lower = first).</p>
            </div>
            <a href="{{ route('admin.hero-banners.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Banner
            </a>
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
                                <th>#</th>
                                <th>Image</th>
                                <th>Title / Subtitle</th>
                                <th>Button</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        @if($banner->banner_image)
                                            <img src="{{ storage_asset($banner->banner_image) }}" alt="" class="rounded" style="width: 120px; height: 60px; object-fit: cover;" onerror="this.style.display='none';">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $banner->name }}</div>
                                        @if($banner->subtitle)
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($banner->subtitle, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($banner->button_text)
                                            <span class="badge bg-light text-dark">{{ $banner->button_text }}</span>
                                            @if($banner->deeplink)
                                                <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($banner->deeplink, 30) }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $banner->priority }}</td>
                                    <td>
                                        @if($banner->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.hero-banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('admin.hero-banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No hero banners yet. Add one to show on the homepage.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
