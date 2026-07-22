@extends('admin.layout')

@section('title', 'Edit FAQ Category')
@section('page-title', 'Edit FAQ Category')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.faqs.update-category', $faq) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $faq->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order) }}">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
