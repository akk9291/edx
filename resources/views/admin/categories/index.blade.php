@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Category Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Categories</h4>
                <p class="text-muted mb-0">
                    @if(! empty($bearingCatalogOnly))
                        Bearing catalogue only (main category <strong>Bearings</strong>).
                    @else
                        All categories in the database.
                    @endif
                </p>
                <div class="small mt-2 d-flex flex-wrap gap-2 align-items-center">
                    @if(! empty($bearingCatalogOnly))
                        <a href="{{ route('admin.categories.index', ['show_all' => 1]) }}" class="text-primary">Show all categories</a>
                    @else
                        <a href="{{ route('admin.categories.index') }}" class="text-primary">Bearing categories only</a>
                    @endif
                    <span class="text-muted">·</span>
                    @if(empty($subOnly))
                        <a href="{{ route('admin.categories.index', array_merge(['sub_only' => 1], ! empty($showAll) ? ['show_all' => 1] : [])) }}" class="text-primary">Sub-categories only</a>
                    @else
                        <a href="{{ route('admin.categories.index', ! empty($showAll) ? ['show_all' => 1] : []) }}" class="text-primary">Show top-level + sub</a>
                    @endif
                </div>
            </div>
            <a href="{{{ route('admin.categories.create') }}}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Category
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Children</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        @if($category->image)
                                            @php $catImgUrl = storage_asset($category->image); @endphp
                                            <div class="position-relative" style="width: 60px; height: 60px;">
                                                <img src="{{ $catImgUrl }}" 
                                                     alt="{{ $category->name }}" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                                     onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                                <div class="d-none bg-light d-flex align-items-center justify-content-center position-absolute top-0 start-0" 
                                                     style="width: 60px; height: 60px; border-radius: 8px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 8px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        @if($category->description)
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-info">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->children->count() > 0)
                                            <span class="badge bg-secondary">{{ $category->children->count() }}</span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{{ route('admin.categories.show', $category) }}}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{{ route('admin.categories.edit', $category) }}}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{{ route('admin.categories.destroy', $category) }}}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <p class="text-muted mb-2">No categories match this filter.</p>
                                        @if(! empty($bearingCatalogOnly))
                                            <a href="{{ route('admin.categories.index', ['show_all' => 1]) }}" class="btn btn-sm btn-outline-primary me-2">Show all categories</a>
                                        @endif
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary mt-2">
                                            Add category
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Tree View -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Category Tree</h5>
            </div>
            <div class="card-body">
                <div class="category-tree">
                    @php
                        $mainCategories = $categories->whereNull('parent_id');
                    @endphp
                    @foreach($mainCategories as $mainCategory)
                        <div class="tree-item mb-3">
                            <div class="d-flex align-items-center mb-2">
                                @if($mainCategory->image)
                                    <span class="position-relative d-inline-block" style="width: 40px; height: 40px;">
                                        <img src="{{ storage_asset($mainCategory->image) }}" 
                                             alt="{{ $mainCategory->name }}" 
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; margin-right: 10px;"
                                             onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                        <span class="d-none position-absolute top-0 start-0 bg-light rounded" style="width:40px;height:40px;"><i class="bi bi-image text-muted"></i></span>
                                    </span>
                                @else
                                    <i class="bi bi-folder-fill text-warning me-2"></i>
                                @endif
                                <strong>{{ $mainCategory->name }}</strong>
                                @if(!$mainCategory->is_active)
                                    <span class="badge bg-danger ms-2">Inactive</span>
                                @endif
                            </div>
                            @if($mainCategory->children->count() > 0)
                                <div class="ms-4">
                                    @foreach($mainCategory->children as $subCategory)
                                        <div class="tree-item mb-2">
                                            <div class="d-flex align-items-center mb-1">
                                                @if($subCategory->image)
                                                    <span class="position-relative d-inline-block" style="width: 35px; height: 35px;">
                                                        <img src="{{ storage_asset($subCategory->image) }}" 
                                                             alt="{{ $subCategory->name }}" 
                                                             style="width: 35px; height: 35px; object-fit: cover; border-radius: 5px; margin-right: 8px;"
                                                             onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                                        <span class="d-none position-absolute top-0 start-0"><i class="bi bi-image text-muted"></i></span>
                                                    </span>
                                                @else
                                                    <i class="bi bi-folder text-info me-2"></i>
                                                @endif
                                                <span>{{ $subCategory->name }}</span>
                                                @if(!$subCategory->is_active)
                                                    <span class="badge bg-danger ms-2">Inactive</span>
                                                @endif
                                            </div>
                                            @if($subCategory->children->count() > 0)
                                                <div class="ms-4">
                                    @foreach($subCategory->children as $product)
                                        <div class="d-flex align-items-center mb-1">
                                            @if($product->image)
                                                <span class="position-relative d-inline-block" style="width: 30px; height: 30px;">
                                                    <img src="{{ storage_asset($product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px; margin-right: 8px;"
                                                         onerror="this.style.display='none'; var n=this.nextElementSibling; if(n) n.classList.remove('d-none');">
                                                    <span class="d-none position-absolute top-0 start-0"><i class="bi bi-image text-muted"></i></span>
                                                </span>
                                            @else
                                                <i class="bi bi-file-earmark text-secondary me-2"></i>
                                            @endif
                                            <small>{{ $product->name }}</small>
                                            @if(!$product->is_active)
                                                <span class="badge bg-danger ms-2">Inactive</span>
                                            @endif
                                        </div>
                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

