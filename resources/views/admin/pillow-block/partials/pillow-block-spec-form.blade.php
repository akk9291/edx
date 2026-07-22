<div class="card border mb-3">
    <div class="card-header bg-secondary text-white">
        <h6 class="mb-0 text-white"><i class="bi bi-gear-fill me-2"></i>Pillow Block Specifications</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Bearing Number -->
            <div class="col-md-12 mb-3">
                <label for="bearing_number" class="form-label">Bearing Number</label>
                <input type="text" 
                       name="bearing_number" 
                       id="bearing_number" 
                       class="form-control form-control-sm @error('bearing_number') is-invalid @enderror" 
                       value="{{ old('bearing_number', $pillowBlock->bearing_number ?? '') }}" 
                       placeholder="e.g. UCP201">
                @error('bearing_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-3 border-top pt-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-list-stars me-2"></i>Specifications Details</h6>
            
            <div id="specs-container">
                @php
                    $existingSpecs = old('specifications', $pillowBlock->specifications ?? []);
                    if (!is_array($existingSpecs)) {
                        $existingSpecs = [];
                    }
                @endphp
                
                @forelse($existingSpecs as $index => $spec)
                    <div class="row g-2 align-items-end mb-2 spec-row">
                        <div class="col-md-4">
                            <label class="form-label-sm small fw-semibold text-secondary mb-1">Title</label>
                            <input type="text" name="specifications[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $spec['title'] ?? '' }}" placeholder="e.g. Center Height">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-sm small fw-semibold text-secondary mb-1">Dimension</label>
                            <input type="text" name="specifications[{{ $index }}][dimension]" class="form-control form-control-sm" value="{{ $spec['dimension'] ?? '' }}" placeholder="e.g. h">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-sm small fw-semibold text-secondary mb-1">Value</label>
                            <input type="text" name="specifications[{{ $index }}][value]" class="form-control form-control-sm" value="{{ $spec['value'] ?? '' }}" placeholder="e.g. 30.2 mm">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-spec-row w-100">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="row g-2 align-items-end mb-2 spec-row">
                        <div class="col-md-4">
                            <label class="form-label-sm small fw-semibold text-secondary mb-1">Title</label>
                            <input type="text" name="specifications[0][title]" class="form-control form-control-sm" placeholder="e.g. Center Height">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-sm small fw-semibold text-secondary mb-1">Dimension</label>
                            <input type="text" name="specifications[0][dimension]" class="form-control form-control-sm" placeholder="e.g. h">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-sm small fw-semibold text-secondary mb-1">Value</label>
                            <input type="text" name="specifications[0][value]" class="form-control form-control-sm" placeholder="e.g. 30.2 mm">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-spec-row w-100">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-spec-row">
                <i class="bi bi-plus-circle me-1"></i>Add Row
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('specs-container');
    const addButton = document.getElementById('add-spec-row');
    
    if (addButton && container) {
        addButton.addEventListener('click', function () {
            const rows = container.getElementsByClassName('spec-row');
            let maxIndex = -1;
            for (let i = 0; i < rows.length; i++) {
                const inputs = rows[i].getElementsByTagName('input');
                if (inputs.length > 0) {
                    const name = inputs[0].getAttribute('name');
                    const match = name.match(/specifications\[(\d+)\]/);
                    if (match) {
                        const idx = parseInt(match[1]);
                        if (idx > maxIndex) {
                            maxIndex = idx;
                        }
                    }
                }
            }
            const nextIndex = maxIndex + 1;
            
            const newRow = document.createElement('div');
            newRow.className = 'row g-2 align-items-end mb-2 spec-row';
            newRow.innerHTML = `
                <div class="col-md-4">
                    <label class="form-label-sm small fw-semibold text-secondary mb-1">Title</label>
                    <input type="text" name="specifications[${nextIndex}][title]" class="form-control form-control-sm" placeholder="e.g. Center Height">
                </div>
                <div class="col-md-3">
                    <label class="form-label-sm small fw-semibold text-secondary mb-1">Dimension</label>
                    <input type="text" name="specifications[${nextIndex}][dimension]" class="form-control form-control-sm" placeholder="e.g. h">
                </div>
                <div class="col-md-4">
                    <label class="form-label-sm small fw-semibold text-secondary mb-1">Value</label>
                    <input type="text" name="specifications[${nextIndex}][value]" class="form-control form-control-sm" placeholder="e.g. 30.2 mm">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-spec-row w-100">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });
        
        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-spec-row') || e.target.closest('.remove-spec-row')) {
                const btn = e.target.classList.contains('remove-spec-row') ? e.target : e.target.closest('.remove-spec-row');
                const row = btn.closest('.spec-row');
                if (row) {
                    const rows = container.getElementsByClassName('spec-row');
                    if (rows.length > 1) {
                        row.remove();
                    } else {
                        const inputs = row.getElementsByTagName('input');
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].value = '';
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="card border mb-3">
    <div class="card-header bg-secondary text-white">
        <h6 class="mb-0 text-white"><i class="bi bi-shuffle me-2"></i>Equivalents (Manufacturer Designations)</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- SKF -->
            <div class="col-md-3 mb-3">
                <label for="equiv_skf" class="form-label">SKF</label>
                <input type="text" 
                       name="equiv_skf" 
                       id="equiv_skf" 
                       class="form-control form-control-sm @error('equiv_skf') is-invalid @enderror" 
                       value="{{ old('equiv_skf', $pillowBlock->equiv_skf ?? '') }}" 
                       placeholder="Model / ref.">
                @error('equiv_skf')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- FAG -->
            <div class="col-md-3 mb-3">
                <label for="equiv_fag" class="form-label">FAG</label>
                <input type="text" 
                       name="equiv_fag" 
                       id="equiv_fag" 
                       class="form-control form-control-sm @error('equiv_fag') is-invalid @enderror" 
                       value="{{ old('equiv_fag', $pillowBlock->equiv_fag ?? '') }}" 
                       placeholder="Model / ref.">
                @error('equiv_fag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- NTN -->
            <div class="col-md-3 mb-3">
                <label for="equiv_ntn" class="form-label">NTN</label>
                <input type="text" 
                       name="equiv_ntn" 
                       id="equiv_ntn" 
                       class="form-control form-control-sm @error('equiv_ntn') is-invalid @enderror" 
                       value="{{ old('equiv_ntn', $pillowBlock->equiv_ntn ?? '') }}" 
                       placeholder="Model / ref.">
                @error('equiv_ntn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Timken -->
            <div class="col-md-3 mb-3">
                <label for="equiv_timken" class="form-label">Timken</label>
                <input type="text" 
                       name="equiv_timken" 
                       id="equiv_timken" 
                       class="form-control form-control-sm @error('equiv_timken') is-invalid @enderror" 
                       value="{{ old('equiv_timken', $pillowBlock->equiv_timken ?? '') }}" 
                       placeholder="Model / ref.">
                @error('equiv_timken')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
