@extends('admin.layout')

@section('title', 'FAQs')
@section('page-title', 'FAQs')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">FAQ Categories</h4>
            <p class="text-muted mb-0">Manage FAQ categories and questions. Content is shown on the FAQs page.</p>
        </div>
        <a href="{{ route('admin.faqs.create-category') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
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
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Questions</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr>
                                    <td class="fw-semibold">{{ $cat->name }}</td>
                                    <td><code>{{ $cat->slug }}</code></td>
                                    <td>{{ $cat->items_count }}</td>
                                    <td>
                                        @if($cat->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $cat->sort_order }}</td>
                                    <td>
                                        <a href="{{ route('admin.faqs.items', $cat) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-list-ul"></i> Questions
                                        </a>
                                        <a href="{{ route('admin.faqs.edit-category', $cat) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy-category', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category and all its questions?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No FAQ categories. <a href="{{ route('admin.faqs.create-category') }}">Add one</a> or run <code>php artisan db:seed --class=FaqSeeder</code></td>
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
