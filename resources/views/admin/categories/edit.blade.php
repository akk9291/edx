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

                    <hr class="my-4">
                    <h5 class="mb-3">Hero Section (Main Banner)</h5>

                    <div class="mb-3">
                        <label for="hero_image" class="form-label">Hero/Banner Image</label>
                        @if($category->hero_image)
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="{{ storage_asset($category->hero_image) }}" 
                                     alt="Hero" 
                                     id="currentHeroImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_hero_image" value="0" id="removeHeroImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('hero_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('hero_image') is-invalid @enderror" 
                               id="hero_image" 
                               name="hero_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'heroImagePreview', 'heroPreviewImg')">
                        @error('hero_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Main banner image for category page. Recommended size: 1920x600px. Max size: 5MB</small>
                        <div id="heroImagePreview" class="mt-2" style="display: none;">
                            <img id="heroPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="hero_text" class="form-label">Hero Text</label>
                            <input type="text" 
                                   class="form-control @error('hero_text') is-invalid @enderror" 
                                   id="hero_text" 
                                   name="hero_text" 
                                   value="{{ old('hero_text', $category->hero_text) }}"
                                   placeholder="e.g. Loved For A Lifetime, FOR EVERY SHADE IN YOU">
                            @error('hero_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Main heading text displayed on hero banner</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hero_button_text" class="form-label">Button Text</label>
                            <input type="text" 
                                   class="form-control @error('hero_button_text') is-invalid @enderror" 
                                   id="hero_button_text" 
                                   name="hero_button_text" 
                                   value="{{ old('hero_button_text', $category->hero_button_text ?? 'Shop Now') }}">
                            @error('hero_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Text for hero button (default: Shop Now)</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Promotional Banners (3 Blocks)</h5>

                    @php
                        $bannerImages = old('banner_images', is_array($category->banner_images) ? $category->banner_images : []);
                        $bannerTexts = old('banner_texts', is_array($category->banner_texts) ? $category->banner_texts : []);
                        while(count($bannerImages) < 3) $bannerImages[] = null;
                        while(count($bannerTexts) < 3) $bannerTexts[] = '';
                    @endphp

                    @for($i = 0; $i < 3; $i++)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Banner {{ $i + 1 }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Banner Image {{ $i + 1 }}</label>
                                @if(!empty($bannerImages[$i]))
                                    <div class="mb-2 position-relative d-inline-block">
                                        <img src="{{ storage_asset($bannerImages[$i]) }}" 
                                             alt="Banner {{ $i + 1 }}" 
                                             style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                        <input type="hidden" name="remove_banner_image[{{ $i }}]" value="0" id="removeBannerImageInput{{ $i }}">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveBannerImage({{ $i }})">
                                            <i class="bi bi-trash me-1"></i>Remove
                                        </button>
                                    </div>
                                @endif
                                <input type="file" 
                                       class="form-control" 
                                       name="banner_images[]" 
                                       accept="image/*"
                                       onchange="previewBannerImage(this, {{ $i }})">
                                <small class="form-text text-muted">Recommended size: 600x400px. Max size: 2MB</small>
                                <div id="bannerImagePreview{{ $i }}" class="mt-2" style="display: none;">
                                    <img id="bannerPreviewImg{{ $i }}" src="" alt="Preview" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Text {{ $i + 1 }}</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="banner_texts[]" 
                                       value="{{ $bannerTexts[$i] ?? '' }}"
                                       placeholder="e.g. Drinkware, Barware, Kitchenware">
                                <small class="form-text text-muted">Text to display on this banner</small>
                            </div>
                        </div>
                    </div>
                    @endfor

                    <hr class="my-4">
                    <h5 class="mb-3">Bottom Banner Section</h5>

                    <div class="mb-3">
                        <label for="bottom_banner_image" class="form-label">Bottom Banner Image</label>
                        @if($category->bottom_banner_image)
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="{{ storage_asset($category->bottom_banner_image) }}" 
                                     alt="Bottom Banner" 
                                     id="currentBottomBannerImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_bottom_banner_image" value="0" id="removeBottomBannerImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('bottom_banner_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('bottom_banner_image') is-invalid @enderror" 
                               id="bottom_banner_image" 
                               name="bottom_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'bottomBannerImagePreview', 'bottomBannerPreviewImg')">
                        @error('bottom_banner_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Bottom section banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="bottomBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="bottomBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bottom_banner_text" class="form-label">Bottom Banner Text</label>
                        <input type="text" 
                               class="form-control @error('bottom_banner_text') is-invalid @enderror" 
                               id="bottom_banner_text" 
                               name="bottom_banner_text" 
                               value="{{ old('bottom_banner_text', $category->bottom_banner_text) }}"
                               placeholder="e.g. Created to be loved for a lifetime">
                        @error('bottom_banner_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Text displayed on bottom banner</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Testimonial Section</h5>

                    <div class="mb-3">
                        <label for="testimonial_text" class="form-label">Testimonial/Quote Text</label>
                        <textarea class="form-control @error('testimonial_text') is-invalid @enderror" 
                                  id="testimonial_text" 
                                  name="testimonial_text" 
                                  rows="3"
                                  placeholder="e.g. I absolutely love this shop! The products are high-quality...">{{ old('testimonial_text', $category->testimonial_text) }}</textarea>
                        @error('testimonial_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Customer testimonial or quote text displayed on category page</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Additional Banner (Optional)</h5>

                    <div class="mb-3">
                        <label for="additional_banner_image" class="form-label">Additional Banner Image</label>
                        @if($category->additional_banner_image)
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="{{ storage_asset($category->additional_banner_image) }}" 
                                     alt="Additional Banner" 
                                     id="currentAdditionalBannerImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_additional_banner_image" value="0" id="removeAdditionalBannerImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('additional_banner_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        @endif
                        <input type="file" 
                               class="form-control @error('additional_banner_image') is-invalid @enderror" 
                               id="additional_banner_image" 
                               name="additional_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'additionalBannerImagePreview', 'additionalBannerPreviewImg')">
                        @error('additional_banner_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Optional additional banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="additionalBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="additionalBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additional_banner_text" class="form-label">Additional Banner Text</label>
                        <input type="text" 
                               class="form-control @error('additional_banner_text') is-invalid @enderror" 
                               id="additional_banner_text" 
                               name="additional_banner_text" 
                               value="{{ old('additional_banner_text', $category->additional_banner_text) }}"
                               placeholder="e.g. Palettes, Check & Coutour">
                        @error('additional_banner_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Text displayed on additional banner</small>
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

    function previewBannerImage(input, index) {
        previewImage(input, 'bannerImagePreview' + index, 'bannerPreviewImg' + index);
    }

    function toggleRemoveImage(type) {
        let removeInput, removeBtn, currentImg;
        
        if (type === 'image') {
            removeInput = document.getElementById('removeImageInput');
            removeBtn = document.getElementById('removeImageBtn');
            currentImg = document.getElementById('currentCategoryImage');
        } else if (type === 'hero_image') {
            removeInput = document.getElementById('removeHeroImageInput');
            currentImg = document.getElementById('currentHeroImage');
        } else if (type === 'bottom_banner_image') {
            removeInput = document.getElementById('removeBottomBannerImageInput');
            currentImg = document.getElementById('currentBottomBannerImage');
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

    function toggleRemoveBannerImage(index) {
        const removeInput = document.getElementById('removeBannerImageInput' + index);
        if (removeInput) {
            removeInput.value = removeInput.value == '0' ? '1' : '0';
        }
    }
</script>
@endpush
@endsection




