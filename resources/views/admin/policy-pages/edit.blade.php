@extends('admin.layout')

@section('title', 'Edit ' . $policy_page->title)
@section('page-title', 'Edit ' . $policy_page->title)

@section('content')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $policy_page->title }}</h5>
                <a href="{{ url('/' . $policy_page->slug) }}" target="_blank" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View on site
                </a>
            </div>
            <div class="card-body">
                <form id="policy-page-form" action="{{ route('admin.policy-pages.update', $policy_page) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $policy_page->title) }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <label for="content" class="form-label mb-0">Content</label>
                            <button type="button" id="toggle-html-mode" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-code-slash me-1"></i> <span id="toggle-html-label">Edit as HTML</span>
                            </button>
                        </div>
                        <div id="editor-wrap" class="border rounded overflow-hidden">
                            <div id="editor" class="bg-white" style="min-height: 400px;"></div>
                            <textarea class="form-control font-monospace small @error('content') is-invalid @enderror d-none"
                                      id="content"
                                      name="content"
                                      rows="18"
                                      placeholder="Paste or type HTML here (e.g. <p>, <strong>, <a>, <ul>)">{{ old('content', $policy_page->content) }}</textarea>
                        </div>
                        <small class="text-muted d-block mt-1">Use the toolbar for formatting, or switch to <strong>Edit as HTML</strong> to paste raw HTML. Content saved while in <strong>Edit as HTML</strong> is stored exactly as entered (no code change).</small>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $policy_page->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active (show this page on the website)</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light border-top py-3 d-flex gap-2 flex-wrap">
                <button type="submit" form="policy-page-form" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i> Save changes
                </button>
                <a href="{{ route('admin.policy-pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('policy-page-form');
    var textarea = document.getElementById('content');
    var editorWrap = document.getElementById('editor-wrap');
    var toggleBtn = document.getElementById('toggle-html-mode');
    var toggleLabel = document.getElementById('toggle-html-label');
    var quill = new Quill('#editor', {
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
    if (textarea && textarea.value.trim()) quill.clipboard.dangerouslyPasteHTML(textarea.value);
    var isHtmlMode = false;
    var editorEl = document.getElementById('editor');
    toggleBtn.addEventListener('click', function() {
        isHtmlMode = !isHtmlMode;
        if (isHtmlMode) {
            // Do NOT overwrite textarea with Quill HTML – preserve raw HTML (like CKEditor HTML support)
            editorEl.classList.add('d-none');
            textarea.classList.remove('d-none');
            toggleLabel.textContent = 'Visual editor';
        } else {
            quill.clipboard.dangerouslyPasteHTML(textarea.value || '');
            editorEl.classList.remove('d-none');
            textarea.classList.add('d-none');
            toggleLabel.textContent = 'Edit as HTML';
        }
    });
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isHtmlMode) {
            textarea.classList.remove('d-none');
            // Submit raw textarea value as-is (no Quill transformation)
        } else {
            textarea.value = quill.root.innerHTML;
        }
        form.submit();
    });
});
</script>
@endpush
