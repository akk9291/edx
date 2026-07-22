@extends('admin.layout')

@section('title', 'Edit Pillow Block')
@section('page-title', 'Edit Pillow Block')

@section('content')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Pillow Block: {{ $pillowBlock->name }}</h5>
            </div>
            <div class="card-body">
                <form id="pillow-edit-form" action="{{ route('admin.pillow-block.update', $pillowBlock) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Product Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $pillowBlock->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $pillowBlock->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Brand -->
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" 
                                   class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" 
                                   name="brand" 
                                   value="{{ old('brand', $pillowBlock->brand) }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" 
                                   class="form-control @error('sku') is-invalid @enderror" 
                                   id="sku" 
                                   name="sku" 
                                   value="{{ old('sku', $pillowBlock->sku) }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to auto-generate</small>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" 
                                  name="short_description" 
                                  rows="3" 
                                  placeholder="Brief summary (shown in product cards and below price)">{{ old('short_description', $pillowBlock->short_description) }}</textarea>
                        <small class="text-muted">Brief teaser text, max 500 characters. Shown in product listings and below price.</small>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pricing Section -->
                    <div class="card border mb-3 bg-light">
                        <div class="card-body">
                            <h6 class="card-title mb-3 fw-bold">Pricing</h6>
                            <p class="small text-muted mb-3">Leave both empty or zero for <strong>Price on request</strong>. <strong>MRP</strong> is the list price; <strong>Sale price</strong> is optional promotional pricing.</p>
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="price" class="form-label">MRP</label>
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control @error('price') is-invalid @enderror"
                                           id="price"
                                           name="price"
                                           value="{{ old('price', $pillowBlock->price) }}"
                                           placeholder="0.00">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="sale_price" class="form-label">Sale price</label>
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control @error('sale_price') is-invalid @enderror"
                                           id="sale_price"
                                           name="sale_price"
                                           value="{{ old('sale_price', $pillowBlock->sale_price) }}"
                                           placeholder="Optional">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="card border mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-3 fw-bold">SEO</h6>
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta title</label>
                                <input type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       id="meta_title"
                                       name="meta_title"
                                       value="{{ old('meta_title', $pillowBlock->meta_title) }}"
                                       maxlength="255">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          id="meta_description"
                                          name="meta_description"
                                          rows="3"
                                          maxlength="5000">{{ old('meta_description', $pillowBlock->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-0">
                                <label for="meta_keywords" class="form-label">Meta keywords</label>
                                <input type="text"
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       id="meta_keywords"
                                       name="meta_keywords"
                                       value="{{ old('meta_keywords', $pillowBlock->meta_keywords) }}"
                                       maxlength="1000">
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Detailed Description</label>
                        <div id="editor-description" class="bg-white border rounded" style="min-height: 220px;"></div>
                        <textarea class="form-control @error('description') is-invalid @enderror d-none" 
                                  id="description" 
                                  name="description" 
                                  rows="8">{{ old('description', $pillowBlock->description) }}</textarea>
                        <small class="text-muted">Full product description. Shown in the Description tab. Use the toolbar to format.</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pillow Block Specifications Form Partial -->
                    @include('admin.pillow-block.partials.pillow-block-spec-form')

                    <!-- Media Uploads (Featured Image, Gallery, Video, PDF Catalogue) -->
                    <div class="card border mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0 text-white"><i class="bi bi-images me-2"></i>Media &amp; Attachments</h6>
                        </div>
                        <div class="card-body">
                            <div class="row border-bottom pb-3 mb-3">
                                <!-- Featured Image -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="image" class="form-label">Featured Image</label>
                                    @if($pillowBlock->image)
                                        <div class="mb-2 position-relative d-inline-block d-block">
                                            <img src="{{ $pillowBlock->image_url }}"
                                                 alt="{{ $pillowBlock->name }}" 
                                                 id="currentProductImage"
                                                 style="max-width: 150px; max-height: 150px; border-radius: 4px; border: 1px solid #ddd;">
                                            <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                                            <button type="button" class="btn btn-sm btn-outline-danger d-block mt-2" id="removeImageBtn" onclick="toggleRemoveImage()">
                                                <i class="bi bi-trash me-1"></i>Remove Image
                                            </button>
                                        </div>
                                    @endif
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted font-italic">Recommended size: 800x800px. Max size: 2MB</small>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    </div>
                                </div>

                                <!-- Gallery Images -->
                                <div class="col-md-6">
                                    <label class="form-label">Gallery Images</label>
                                    <div id="existing-gallery-images" class="mb-2 d-flex flex-wrap gap-2">
                                        @foreach($pillowBlock->galleryImages as $img)
                                            <div class="position-relative d-inline-block gallery-thumb-wrap" data-path="{{ $img->image_path }}">
                                                <img src="{{ storage_asset($img->image_path) }}" alt="Gallery Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #e2e8f0;">
                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle gallery-remove-btn" style="width: 24px; height: 24px; padding: 0; font-size: 12px; line-height: 1;" data-path="{{ $img->image_path }}" title="Remove">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="removeGalleryInputs"></div>
                                    <div id="new-gallery-images" class="mb-2 d-flex flex-wrap gap-2"></div>
                                    <div class="d-flex gap-2">
                                        <input type="file"
                                               class="form-control"
                                               id="gallery_image_single"
                                               accept="image/*">
                                        <button type="button" class="btn btn-sm btn-success text-nowrap" id="add-gallery-image-btn">
                                            <i class="bi bi-plus me-1"></i>Add Image
                                        </button>
                                    </div>
                                    <input type="file" name="gallery_images[]" id="gallery_images_hidden" multiple accept="image/*" style="display: none;">
                                    @error('gallery_images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('gallery_images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Upload new gallery images sequentially. Click the × button on thumbnails to delete existing gallery photos.</small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Product Video -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="video" class="form-label">Product Video</label>
                                    @if($pillowBlock->video)
                                        <div class="mb-2 d-block">
                                            <video src="{{ storage_asset($pillowBlock->video) }}" controls id="currentProductVideo" style="max-width: 250px; border-radius: 4px; border: 1px solid #ddd;"></video>
                                            <input type="hidden" name="remove_video" value="0" id="removeVideoInput">
                                            <button type="button" class="btn btn-sm btn-outline-danger d-block mt-2" id="removeVideoBtn" onclick="toggleRemoveVideo()">
                                                <i class="bi bi-trash me-1"></i>Remove Video
                                            </button>
                                        </div>
                                    @endif
                                    <input type="file"
                                           class="form-control @error('video') is-invalid @enderror"
                                           id="video"
                                           name="video"
                                           accept="video/*">
                                    @error('video')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Upload video file to replace. Max size: 50MB.</small>
                                </div>

                                <!-- PDF Catalogue -->
                                <div class="col-md-6">
                                    <label for="pdf_catalogue" class="form-label">PDF Catalogue</label>
                                    @if($pillowBlock->pdf_catalogue)
                                        <div class="mb-2 d-block">
                                            <a href="{{ storage_asset($pillowBlock->pdf_catalogue) }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" id="currentPdfLink">
                                                <i class="bi bi-file-earmark-pdf me-2"></i>View Catalogue (PDF)
                                            </a>
                                            <input type="hidden" name="remove_pdf_catalogue" value="0" id="removePdfInput">
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="removePdfBtn" onclick="toggleRemovePdf()">
                                                <i class="bi bi-trash me-1"></i>Remove PDF
                                            </button>
                                        </div>
                                    @endif
                                    <input type="file"
                                           class="form-control @error('pdf_catalogue') is-invalid @enderror"
                                           id="pdf_catalogue"
                                           name="pdf_catalogue"
                                           accept=".pdf">
                                    @error('pdf_catalogue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Upload a new PDF to replace the catalogue. Max size: 10MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status switches -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="in_stock" name="in_stock" value="1" {{ old('in_stock', $pillowBlock->in_stock) ? 'checked' : '' }}>
                                <label class="form-check-label" for="in_stock">In Stock</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $pillowBlock->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $pillowBlock->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_new_arrival" name="is_new_arrival" value="1" {{ old('is_new_arrival', $pillowBlock->is_new_arrival) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_new_arrival">New Arrival</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" class="form-control" name="sort_order" id="sort_order" value="{{ old('sort_order', $pillowBlock->sort_order) }}" min="0">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4 border-top pt-3">
                        <a href="{{ route('admin.pillow-block.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Pillow Block
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // Media removals toggles
    function toggleRemoveImage() {
        const input = document.getElementById('removeImageInput');
        const btn = document.getElementById('removeImageBtn');
        const img = document.getElementById('currentProductImage');
        
        if (input.value === '0') {
            input.value = '1';
            img.style.opacity = '0.3';
            btn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
            btn.classList.replace('btn-outline-danger', 'btn-outline-secondary');
        } else {
            input.value = '0';
            img.style.opacity = '1';
            btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove Image';
            btn.classList.replace('btn-outline-secondary', 'btn-outline-danger');
        }
    }

    function toggleRemoveVideo() {
        const input = document.getElementById('removeVideoInput');
        const btn = document.getElementById('removeVideoBtn');
        const video = document.getElementById('currentProductVideo');
        
        if (input.value === '0') {
            input.value = '1';
            video.style.opacity = '0.3';
            btn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
            btn.classList.replace('btn-outline-danger', 'btn-outline-secondary');
        } else {
            input.value = '0';
            video.style.opacity = '1';
            btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove Video';
            btn.classList.replace('btn-outline-secondary', 'btn-outline-danger');
        }
    }

    function toggleRemovePdf() {
        const input = document.getElementById('removePdfInput');
        const btn = document.getElementById('removePdfBtn');
        const link = document.getElementById('currentPdfLink');
        
        if (input.value === '0') {
            input.value = '1';
            link.style.opacity = '0.3';
            btn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
            btn.classList.replace('btn-outline-danger', 'btn-outline-secondary');
        } else {
            input.value = '0';
            link.style.opacity = '1';
            btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove PDF';
            btn.classList.replace('btn-outline-secondary', 'btn-outline-danger');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var descTa = document.getElementById('description');
        if (descTa && document.getElementById('editor-description')) {
            var quill = new Quill('#editor-description', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [5, 6, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link'],
                        ['clean']
                    ]
                }
            });
            if (descTa.value) quill.clipboard.dangerouslyPasteHTML(descTa.value);
            document.getElementById('pillow-edit-form').addEventListener('submit', function(e) {
                e.preventDefault();
                descTa.value = quill.root.innerHTML;
                this.submit();
            });
        }

        // Existing gallery images remove click
        const galleryContainer = document.getElementById('existing-gallery-images');
        const removeInputsContainer = document.getElementById('removeGalleryInputs');
        
        if (galleryContainer) {
            galleryContainer.addEventListener('click', function(e) {
                const btn = e.target.closest('.gallery-remove-btn');
                if (btn) {
                    e.preventDefault();
                    const path = btn.getAttribute('data-path');
                    const wrap = btn.closest('.gallery-thumb-wrap');
                    
                    // Add hidden input to post the deletion to the server
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_gallery_images[]';
                    input.value = path;
                    removeInputsContainer.appendChild(input);
                    
                    wrap.remove();
                }
            });
        }

        // New gallery single add handler
        var gallerySingleInput = document.getElementById('gallery_image_single');
        var galleryHiddenInput = document.getElementById('gallery_images_hidden');
        var newGalleryContainer = document.getElementById('new-gallery-images');
        var addGalleryBtn = document.getElementById('add-gallery-image-btn');
        var fileList = [];
        
        if (gallerySingleInput && addGalleryBtn) {
            addGalleryBtn.addEventListener('click', function() {
                gallerySingleInput.click();
            });
            gallerySingleInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    var file = e.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var div = document.createElement('div');
                        div.className = 'position-relative d-inline-block gallery-thumb-wrap';
                        div.innerHTML = '<img src="' + event.target.result + '" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 2px solid #e2e8f0;"><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle remove-new-gallery-btn" style="width: 24px; height: 24px; padding: 0; font-size: 12px;"><i class="bi bi-x"></i></button>';
                        div.querySelector('.remove-new-gallery-btn').addEventListener('click', function() {
                            var dataTransfer = new DataTransfer();
                            fileList = fileList.filter(function(f) { return f !== file; });
                            fileList.forEach(function(f) { dataTransfer.items.add(f); });
                            galleryHiddenInput.files = dataTransfer.files;
                            div.remove();
                        });
                        newGalleryContainer.appendChild(div);
                        fileList.push(file);
                        var dataTransfer = new DataTransfer();
                        fileList.forEach(function(f) { dataTransfer.items.add(f); });
                        galleryHiddenInput.files = dataTransfer.files;
                        gallerySingleInput.value = '';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
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
</script>
@endpush
@endsection
