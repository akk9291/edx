@extends('admin.layout')

@section('title', 'Main Categories')
@section('page-title', 'Main Categories Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Main Categories</h4>
                <p class="text-muted mb-0">Manage main product categories</p>
                <div class="small mt-1">
                    @if(empty($showAll))
                        <span class="text-muted">Showing mains linked to the bearing catalog.</span>
                        <a href="{{ route('admin.main-categories.index', ['show_all' => 1]) }}" class="text-primary ms-2">Show all</a>
                    @else
                        <a href="{{ route('admin.main-categories.index') }}" class="text-primary">Only mains used in catalog</a>
                    @endif
                </div>
            </div>
            <a href="{{{ route('admin.main-categories.create') }}}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Main Category
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($mainCategories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Sub Categories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainCategories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td><code>{{ $category->slug }}</code></td>
                                        <td>{{ $category->sort_order ?? 0 }}</td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->categories->count() ?? 0 }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{{ route('admin.main-categories.show', $category) }}}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{{ route('admin.main-categories.edit', $category) }}}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{{ route('admin.main-categories.destroy', $category) }}}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No main categories found. 
                        <a href="{{{ route('admin.main-categories.create') }}}">Create your first main category</a>.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


