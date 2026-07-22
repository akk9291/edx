@extends('admin.layout')

@section('title', 'Create Main Category')
@section('page-title', 'Create New Main Category')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Main Category Information</h5>
            </div>
            <div class="card-body">
                <form action="{{{ route('admin.main-categories.store') }}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" 
                                    id="is_active" 
                                    name="is_active">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Category Image</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               onchange="previewImage(this, 'imagePreview', 'previewImg')">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Recommended size: 800x400px. Max size: 2MB</small>
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 300px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 fw-bold">Category Page UI/Content Settings</h5>
                    <p class="text-muted mb-4">Configure the content and images displayed on the category page (optional).</p>

                    <hr class="my-4">
                    <h5 class="mb-3">Hero Section</h5>

                    <div class="mb-3">
                        <label for="hero_image" class="form-label">Hero Image</label>
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
                                   value="{{ old('hero_text') }}"
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
                                   value="{{ old('hero_button_text', 'Shop Now') }}">
                            @error('hero_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Text for hero button (default: Shop Now)</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Promotional Banners (3 Blocks)</h5>

                    @for($i = 0; $i < 3; $i++)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Banner {{ $i + 1 }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Banner Image {{ $i + 1 }}</label>
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
                                       value="{{ old('banner_texts.' . $i, '') }}"
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
                               value="{{ old('bottom_banner_text') }}"
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
                                  placeholder="e.g. I absolutely love this shop! The products are high-quality...">{{ old('testimonial_text') }}</textarea>
                        @error('testimonial_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Customer testimonial or quote text displayed on category page</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Additional Banner (Optional)</h5>

                    <div class="mb-3">
                        <label for="additional_banner_image" class="form-label">Additional Banner Image</label>
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
                               value="{{ old('additional_banner_text') }}"
                               placeholder="e.g. Palettes, Check & Coutour">
                        @error('additional_banner_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Text displayed on additional banner</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{{ route('admin.main-categories.index') }}}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-warning" onclick="resetForm()">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Main Category
                            </button>
                        </div>
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

    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All entered data will be cleared.')) {
            // Reset all form fields
            const form = document.querySelector('form');
            if (form) {
                form.reset();
            }
            
            // Reset image previews
            const previews = document.querySelectorAll('[id$="Preview"]');
            previews.forEach(preview => {
                preview.style.display = 'none';
            });
            
            // Reset file inputs
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.value = '';
            });
        }
    }
</script>
@endpush
@endsection


