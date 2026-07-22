@extends('admin.layout')

@section('title', 'View Category')
@section('page-title', 'Category: ' . $category->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Details</h5>
            </div>
            <div class="card-body">
                @if($category->image)
                    <div class="mb-4 text-center">
                        <img src="{{ storage_asset($category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="img-fluid" 
                             style="max-width: 300px; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>
                @endif
                <table class="table table-borderless">
                    <tr>
                        <th width="200">ID:</th>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><strong>{{ $category->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code>{{ $category->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Parent Category:</th>
                        <td>
                            @if($category->parent)
                                <a href="{{{ route('admin.categories.show', $category->parent) }}}" class="badge bg-info text-decoration-none">
                                    {{ $category->parent->name }}
                                </a>
                            @else
                                <span class="text-muted">Main Category</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $category->description ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Sort Order:</th>
                        <td>{{ $category->sort_order }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated:</th>
                        <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{{ route('admin.categories.edit', $category) }}}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Category
                    </a>
                    <a href="{{{ route('admin.categories.index') }}}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                    <form action="{{{ route('admin.categories.destroy', $category) }}}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($category->children->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Sub-categories ({{ $category->children->count() }})</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($category->children as $child)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{{ route('admin.categories.show', $child) }}}" class="text-decoration-none">
                                    {{ $child->name }}
                                </a>
                                @if($child->children->count() > 0)
                                    <span class="badge bg-secondary">{{ $child->children->count() }} items</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection




