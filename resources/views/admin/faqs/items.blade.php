@extends('admin.layout')

@section('title', 'FAQ Items - ' . $faq->name)
@section('page-title', 'FAQ Items - ' . $faq->name)

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('admin.faqs.index') }}" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> Back to Categories</a>
            <h4 class="mb-1 fw-bold mt-2" style="color: #2d3748;">{{ $faq->name }}</h4>
            <p class="text-muted mb-0">Manage questions and answers for this category.</p>
        </div>
        <a href="{{ route('admin.faqs.create-item', $faq) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Question
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
                                <th>Question</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="fw-semibold">{{ Str::limit($item->question, 60) }}</td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->sort_order }}</td>
                                    <td>
                                        <a href="{{ route('admin.faqs.edit-item', [$faq, $item]) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy-item', [$faq, $item]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No questions yet. <a href="{{ route('admin.faqs.create-item', $faq) }}">Add one</a></td>
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
