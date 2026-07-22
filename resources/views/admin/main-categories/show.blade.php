@extends('admin.layout')

@section('title', 'View Main Category')
@section('page-title', 'Main Category Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">{{ $category->name }}</h4>
                <p class="text-muted mb-0">Main category details</p>
            </div>
            <div>
                <a href="{{{ route('admin.main-categories.edit', $category) }}}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
                <a href="{{{ route('admin.main-categories.index') }}}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Name:</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code>{{ $category->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Sort Order:</th>
                        <td>{{ $category->sort_order ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Sub Categories:</th>
                        <td>{{ $category->categories->count() ?? 0 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @if($category->image)
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Image</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ storage_asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid" style="max-height: 300px; border-radius: 8px;">
            </div>
        </div>
    </div>
    @endif
</div>

@if($category->categories->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sub Categories ({{ $category->categories->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->categories as $subCategory)
                                <tr>
                                    <td>{{ $subCategory->name }}</td>
                                    <td><code>{{ $subCategory->slug }}</code></td>
                                    <td>
                                        @if($subCategory->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{{ route('admin.categories.show', $subCategory) }}}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection


