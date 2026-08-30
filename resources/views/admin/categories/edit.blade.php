@extends('admin.layout')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category: ' . $category->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <form action="{{{ route('admin.categories.update', $category) }}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" 
                                    id="parent_id" 
                                    name="parent_id">
                                <option value="">None (Main Category)</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" 
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to make it a main category</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Category Thumbnail Image</label>
                        @if($category->image)
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="{{ storage_asset($category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     id="currentCategoryImage"
                                     style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" id="removeImageBtn" onclick="toggleRemoveImage('image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               onchange="previewImage(this, 'imagePreview', 'previewImg')">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Category thumbnail. Recommended size: 400x400px. Max size: 2MB</small>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $category->sort_order) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Lower numbers appear first</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <small class="form-text text-muted">Inactive categories won't appear on the website</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Slug</label>
                        <input type="text" 
                               class="form-control" 
                               value="{{ $category->slug }}" 
                               disabled>
                        <small class="form-text text-muted">Slug is auto-generated from name and cannot be edited directly</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{{ route('admin.categories.index') }}}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input, previewId, imgId) {
        const preview = document.getElementById(previewId);
        const previewImg = document.getElementById(imgId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    function toggleRemoveImage(type) {
        let removeInput, removeBtn, currentImg;
        
        if (type === 'image') {
            removeInput = document.getElementById('removeImageInput');
            removeBtn = document.getElementById('removeImageBtn');
            currentImg = document.getElementById('currentCategoryImage');
        }
        
        if (removeInput) {
            if (removeInput.value == '0') {
                removeInput.value = '1';
                if (removeBtn) {
                    removeBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
                    removeBtn.classList.remove('btn-outline-danger');
                    removeBtn.classList.add('btn-danger');
                }
                if (currentImg) currentImg.style.opacity = '0.5';
            } else {
                removeInput.value = '0';
                if (removeBtn) {
                    removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                    removeBtn.classList.remove('btn-danger');
                    removeBtn.classList.add('btn-outline-danger');
                }
                if (currentImg) currentImg.style.opacity = '1';
            }
        }
    }
</script>
@endpush
@endsection




