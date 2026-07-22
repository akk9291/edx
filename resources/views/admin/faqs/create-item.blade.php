@extends('admin.layout')

@section('title', 'Add FAQ Question')
@section('page-title', 'Add FAQ Question - ' . $faq->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.faqs.store-item', $faq) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question') }}" required>
                        @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea name="answer" rows="5" class="form-control @error('answer') is-invalid @enderror" required>{{ old('answer') }}</textarea>
                        @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Question</button>
                    <a href="{{ route('admin.faqs.items', $faq) }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
