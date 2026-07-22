@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('content')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <form id="product-create-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
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
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" 
                                  name="short_description" 
                                  rows="3" 
                                  placeholder="Brief summary (shown in product cards and below price)">{{ old('short_description') }}</textarea>
                        <small class="text-muted">Brief teaser text, max 500 characters. Shown in product listings and below price.</small>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card border mb-3 bg-light">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Pricing</h6>
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
                                           value="{{ old('price', '') }}"
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
                                           value="{{ old('sale_price', '') }}"
                                           placeholder="Optional">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-3">SEO</h6>
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta title</label>
                                <input type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       id="meta_title"
                                       name="meta_title"
                                       value="{{ old('meta_title') }}"
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
                                          maxlength="5000">{{ old('meta_description') }}</textarea>
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
                                       value="{{ old('meta_keywords') }}"
                                       maxlength="1000">
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Detailed Description</label>
                        <div id="editor-description" class="bg-white border rounded" style="min-height: 220px;"></div>
                        <textarea class="form-control @error('description') is-invalid @enderror d-none" 
                                  id="description" 
                                  name="description" 
                                  rows="8">{{ old('description') }}</textarea>
                        <small class="text-muted">Full product description. Shown in the Description tab. Use the toolbar to format.</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $bearing_specs = [];
                        foreach (\App\Models\Product::bearingStructuredSpecKeys() as $_k) {
                            $bearing_specs[$_k] = old('bearing_specs.'.$_k, '');
                        }
                        $sfxOld = old('bearing_specs.suffix_pairs');
                        $bearing_specs['suffix_pairs'] = (is_array($sfxOld) && count($sfxOld) > 0)
                            ? $sfxOld
                            : [['suffix' => '', 'description' => '']];
                        $extraSpecs = old('specifications');
                        if (! is_array($extraSpecs) || empty($extraSpecs)) {
                            $extraSpecs = [['key' => '', 'value' => '']];
                        }
                    @endphp
                    @include('admin.products.partials.bearing-spec-form', ['bearing_specs' => $bearing_specs])

                    <div class="mb-3">
                        <label class="form-label">Additional specifications <span class="text-muted fw-normal">(optional)</span></label>
                        <p class="small text-muted mb-2">Custom key/value rows. Do not reuse the same internal keys as the bearing fields above (they are ignored here).</p>
                        <div id="extra-specifications-container">
                            @foreach($extraSpecs as $idx => $spec)
                                <div class="spec-row mb-2 d-flex gap-2 align-items-start" data-index="{{ $idx }}">
                                    <div class="flex-grow-1">
                                        <input type="text"
                                               name="specifications[{{ $idx }}][key]"
                                               class="form-control form-control-sm"
                                               placeholder="Custom key"
                                               value="{{ $spec['key'] ?? '' }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="text"
                                               name="specifications[{{ $idx }}][value]"
                                               class="form-control form-control-sm"
                                               placeholder="Value"
                                               value="{{ $spec['value'] ?? '' }}">
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-success add-spec-btn" title="Add">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger remove-spec-btn" title="Remove" {{ count($extraSpecs) <= 1 ? 'style="display:none;"' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" 
                                   class="form-control @error('sku') is-invalid @enderror" 
                                   id="sku" 
                                   name="sku" 
                                   value="{{ old('sku') }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to auto-generate</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 800x800px. Max size: 2MB</small>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gallery Images</label>
                            <div id="new-gallery-images" class="mb-2 d-flex flex-wrap gap-2"></div>
                            <div class="d-flex gap-2">
                                <input type="file"
                                       class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror"
                                       id="gallery_image_single"
                                       accept="image/*">
                                <button type="button" class="btn btn-sm btn-success" id="add-gallery-image-btn">
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
                            <small class="form-text text-muted">You can select multiple images for the product gallery. Max size: 2MB each.</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="video" class="form-label">Product Video</label>
                            <input type="file"
                                   class="form-control @error('video') is-invalid @enderror"
                                   id="video"
                                   name="video"
                                   accept="video/*">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Optional product video (MP4, MOV, AVI, MKV). Max size: 50MB.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="in_stock" 
                                       name="in_stock" 
                                       value="1" 
                                       {{ old('in_stock', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="in_stock">
                                    In Stock
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_new_arrival" 
                                       name="is_new_arrival" 
                                       value="1" 
                                       {{ old('is_new_arrival') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_new_arrival">
                                    New Arrival
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{{ route('admin.products.index') }}}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Product
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
            document.getElementById('product-create-form').addEventListener('submit', function(e) {
                e.preventDefault();
                descTa.value = quill.root.innerHTML;
                this.submit();
            });
        }

        var specIndex = {{ count($extraSpecs) }};
        var specContainer = document.getElementById('extra-specifications-container');
        
        function updateRemoveButtons() {
            var rows = specContainer.querySelectorAll('.spec-row');
            rows.forEach(function(btn) {
                var removeBtn = btn.querySelector('.remove-spec-btn');
                if (removeBtn) {
                    removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
                }
            });
        }
        
        if (specContainer) {
            specContainer.addEventListener('click', function(e) {
                if (e.target.closest('.add-spec-btn')) {
                    var row = e.target.closest('.spec-row').cloneNode(true);
                    var idx = specIndex++;
                    row.setAttribute('data-index', idx);
                    row.querySelector('input[name*="[key]"]').setAttribute('name', 'specifications[' + idx + '][key]');
                    row.querySelector('input[name*="[value]"]').setAttribute('name', 'specifications[' + idx + '][value]');
                    row.querySelector('input[name*="[key]"]').value = '';
                    row.querySelector('input[name*="[value]"]').value = '';
                    specContainer.appendChild(row);
                    updateRemoveButtons();
                } else if (e.target.closest('.remove-spec-btn')) {
                    e.target.closest('.spec-row').remove();
                    updateRemoveButtons();
                }
            });
            updateRemoveButtons();
        }

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

