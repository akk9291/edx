@extends('admin.layout')

@section('title', 'Edit Hero Banner')
@section('page-title', 'Edit Hero Banner')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Banner details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.hero-banners.update', $heroBanner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Title (main heading) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $heroBanner->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="subtitle" class="form-label">Subtitle (optional)</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $heroBanner->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="button_text" class="form-label">Button text</label>
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text', $heroBanner->button_text) }}">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="deeplink" class="form-label">Button link (URL)</label>
                            <input type="text" class="form-control @error('deeplink') is-invalid @enderror" id="deeplink" name="deeplink" value="{{ old('deeplink', $heroBanner->deeplink) }}">
                            @error('deeplink')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priority (order)</label>
                            <input type="number" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" value="{{ old('priority', $heroBanner->priority) }}" min="0">
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $heroBanner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active (show on homepage)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="banner_image" class="form-label">Banner image</label>
                        @if($heroBanner->banner_image)
                            <div class="mb-2">
                                <img src="{{ storage_asset($heroBanner->banner_image) }}" alt="Current" style="max-width: 300px; max-height: 150px; object-fit: cover; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image" accept="image/*">
                        @error('banner_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave empty to keep current image. Max 5MB.</small>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 300px; max-height: 150px; object-fit: cover; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.hero-banners.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('banner_image').addEventListener('change', function() {
    var preview = document.getElementById('imagePreview');
    var img = document.getElementById('previewImg');
    if (this.files && this.files[0]) {
        var r = new FileReader();
        r.onload = function(e) { img.src = e.target.result; preview.style.display = 'block'; };
        r.readAsDataURL(this.files[0]);
    } else { preview.style.display = 'none'; }
});
</script>
@endpush
@endsection
