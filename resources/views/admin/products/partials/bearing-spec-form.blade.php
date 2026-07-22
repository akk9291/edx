{{-- Expects $bearing_specs: array<string, string> with keys from Product::bearingStructuredSpecKeys() --}}
@php
    $b = is_array($bearing_specs ?? null) ? $bearing_specs : [];
    $val = function (string $key) use ($b): string {
        return old('bearing_specs.'.$key, $b[$key] ?? '');
    };
@endphp

<div class="card mb-4 border-primary">
    <div class="card-header bg-light">
        <h6 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Bearing catalog &amp; technical data</h6>
        <small class="text-muted d-block mt-1">These values are saved in <strong>specifications</strong> and power the storefront product tabs (Overview, Equivalents, Suffix) and PDF.</small>
    </div>
    <div class="card-body">
        <h6 class="text-secondary text-uppercase small mb-3">Boundary dimensions</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Bore diameter</label>
                <input type="text" name="bearing_specs[bore_diameter]" class="form-control @error('bearing_specs.bore_diameter') is-invalid @enderror" value="{{ $val('bore_diameter') }}" placeholder="e.g. 15 mm">
                @error('bearing_specs.bore_diameter')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Outside diameter</label>
                <input type="text" name="bearing_specs[outside_diameter]" class="form-control @error('bearing_specs.outside_diameter') is-invalid @enderror" value="{{ $val('outside_diameter') }}" placeholder="e.g. 32 mm">
                @error('bearing_specs.outside_diameter')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Width</label>
                <input type="text" name="bearing_specs[width]" class="form-control @error('bearing_specs.width') is-invalid @enderror" value="{{ $val('width') }}" placeholder="e.g. 8 mm">
                @error('bearing_specs.width')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Performance</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Basic dynamic load rating</label>
                <input type="text" name="bearing_specs[dynamic_load_rating]" class="form-control @error('bearing_specs.dynamic_load_rating') is-invalid @enderror" value="{{ $val('dynamic_load_rating') }}" placeholder="e.g. 5.60 KN">
                @error('bearing_specs.dynamic_load_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Basic static load rating</label>
                <input type="text" name="bearing_specs[static_load_rating]" class="form-control @error('bearing_specs.static_load_rating') is-invalid @enderror" value="{{ $val('static_load_rating') }}" placeholder="e.g. 2.83 KN">
                @error('bearing_specs.static_load_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Limiting speed – grease</label>
                <input type="text" name="bearing_specs[limiting_speed_grease]" class="form-control @error('bearing_specs.limiting_speed_grease') is-invalid @enderror" value="{{ $val('limiting_speed_grease') }}" placeholder="e.g. 22000 r/min">
                @error('bearing_specs.limiting_speed_grease')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Limiting speed – oil</label>
                <input type="text" name="bearing_specs[limiting_speed_oil]" class="form-control @error('bearing_specs.limiting_speed_oil') is-invalid @enderror" value="{{ $val('limiting_speed_oil') }}" placeholder="e.g. 26000 r/min">
                @error('bearing_specs.limiting_speed_oil')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Properties</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Number of rows</label>
                <input type="text" name="bearing_specs[number_of_rows]" class="form-control @error('bearing_specs.number_of_rows') is-invalid @enderror" value="{{ $val('number_of_rows') }}" placeholder="e.g. 1">
                @error('bearing_specs.number_of_rows')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Bore type</label>
                <input type="text" name="bearing_specs[bore_type]" class="form-control @error('bearing_specs.bore_type') is-invalid @enderror" value="{{ $val('bore_type') }}" placeholder="e.g. Cylindrical">
                @error('bearing_specs.bore_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Cage</label>
                <input type="text" name="bearing_specs[cage]" class="form-control @error('bearing_specs.cage') is-invalid @enderror" value="{{ $val('cage') }}" placeholder="e.g. Sheet Steel">
                @error('bearing_specs.cage')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Radial internal clearance</label>
                <input type="text" name="bearing_specs[radial_clearance]" class="form-control @error('bearing_specs.radial_clearance') is-invalid @enderror" value="{{ $val('radial_clearance') }}" placeholder="e.g. CN">
                @error('bearing_specs.radial_clearance')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Tolerance class for dimensions</label>
                <input type="text" name="bearing_specs[tolerance_class]" class="form-control @error('bearing_specs.tolerance_class') is-invalid @enderror" value="{{ $val('tolerance_class') }}" placeholder="e.g. P6">
                @error('bearing_specs.tolerance_class')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Product net weight</label>
                <input type="text" name="bearing_specs[weight]" class="form-control @error('bearing_specs.weight') is-invalid @enderror" value="{{ $val('weight') }}" placeholder="e.g. 0.02 kg">
                @error('bearing_specs.weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Equivalents (manufacturer designations)</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-3">
                <label class="form-label">SKF</label>
                <input type="text" name="bearing_specs[equiv_skf]" class="form-control @error('bearing_specs.equiv_skf') is-invalid @enderror" value="{{ $val('equiv_skf') }}" placeholder="Model / ref.">
                @error('bearing_specs.equiv_skf')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label">FAG</label>
                <input type="text" name="bearing_specs[equiv_fag]" class="form-control @error('bearing_specs.equiv_fag') is-invalid @enderror" value="{{ $val('equiv_fag') }}" placeholder="Model / ref.">
                @error('bearing_specs.equiv_fag')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label">NTN</label>
                <input type="text" name="bearing_specs[equiv_ntn]" class="form-control @error('bearing_specs.equiv_ntn') is-invalid @enderror" value="{{ $val('equiv_ntn') }}" placeholder="Model / ref.">
                @error('bearing_specs.equiv_ntn')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label">Timken</label>
                <input type="text" name="bearing_specs[equiv_timken]" class="form-control @error('bearing_specs.equiv_timken') is-invalid @enderror" value="{{ $val('equiv_timken') }}" placeholder="Model / ref.">
                @error('bearing_specs.equiv_timken')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <h6 class="text-secondary text-uppercase small mb-3">Suffix &amp; description</h6>
        <p class="small text-muted mb-2">Add one or more rows (suffix / field name and description). Shown on the product page &quot;Suffix description&quot; tab.</p>
        @php
            $suffixPairs = $bearing_specs['suffix_pairs'] ?? [];
            if (! is_array($suffixPairs) || count($suffixPairs) === 0) {
                $suffixPairs = [['suffix' => '', 'description' => '']];
            }
        @endphp
        <div id="suffix-pairs-container" class="border rounded p-3 bg-light">
            @foreach($suffixPairs as $spIdx => $pair)
                <div class="suffix-pair-row row g-3 mb-3 align-items-end pb-3 {{ !$loop->last ? 'border-bottom' : '' }}" data-index="{{ $spIdx }}">
                    <div class="col-md-4">
                        <label class="form-label">Suffix / field</label>
                        <input type="text"
                               name="bearing_specs[suffix_pairs][{{ $spIdx }}][suffix]"
                               data-suffix-field="suffix"
                               class="form-control @error('bearing_specs.suffix_pairs.'.$spIdx.'.suffix') is-invalid @enderror"
                               value="{{ old('bearing_specs.suffix_pairs.'.$spIdx.'.suffix', $pair['suffix'] ?? '') }}"
                               placeholder="e.g. 2RS, C3">
                        @error('bearing_specs.suffix_pairs.'.$spIdx.'.suffix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text"
                               name="bearing_specs[suffix_pairs][{{ $spIdx }}][description]"
                               data-suffix-field="description"
                               class="form-control @error('bearing_specs.suffix_pairs.'.$spIdx.'.description') is-invalid @enderror"
                               value="{{ old('bearing_specs.suffix_pairs.'.$spIdx.'.description', $pair['description'] ?? '') }}"
                               placeholder="e.g. Rubber seals on both sides">
                        @error('bearing_specs.suffix_pairs.'.$spIdx.'.description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 d-flex gap-1 flex-wrap">
                        <button type="button" class="btn btn-sm btn-success add-suffix-pair" title="Add row"><i class="bi bi-plus-lg"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-suffix-pair" title="Remove row"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            @endforeach
        </div>
        @error('bearing_specs.suffix_pairs')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('suffix-pairs-container');
        if (!container) return;
        var suffixPairIndex = {{ count($suffixPairs) }};

        function reindexSuffixRows() {
            var rows = container.querySelectorAll('.suffix-pair-row');
            rows.forEach(function (row, i) {
                row.setAttribute('data-index', String(i));
                row.querySelectorAll('input[data-suffix-field]').forEach(function (inp) {
                    var field = inp.getAttribute('data-suffix-field');
                    if (field) {
                        inp.name = 'bearing_specs[suffix_pairs][' + i + '][' + field + ']';
                    }
                });
            });
            rows.forEach(function (row, i) {
                if (i < rows.length - 1) {
                    row.classList.add('border-bottom', 'pb-3');
                } else {
                    row.classList.remove('border-bottom', 'pb-3');
                }
            });
        }

        function updateSuffixRemoveButtons() {
            var rows = container.querySelectorAll('.suffix-pair-row');
            container.querySelectorAll('.remove-suffix-pair').forEach(function (btn) {
                btn.style.display = rows.length > 1 ? 'inline-block' : 'none';
            });
        }

        container.addEventListener('click', function (e) {
            if (e.target.closest('.add-suffix-pair')) {
                var row = e.target.closest('.suffix-pair-row');
                var clone = row.cloneNode(true);
                clone.querySelectorAll('input').forEach(function (inp) { inp.value = ''; });
                clone.classList.add('border-bottom', 'pb-3', 'mb-3');
                container.appendChild(clone);
                suffixPairIndex++;
                reindexSuffixRows();
                updateSuffixRemoveButtons();
            } else if (e.target.closest('.remove-suffix-pair')) {
                var rows = container.querySelectorAll('.suffix-pair-row');
                if (rows.length <= 1) return;
                e.target.closest('.suffix-pair-row').remove();
                reindexSuffixRows();
                updateSuffixRemoveButtons();
            }
        });
        updateSuffixRemoveButtons();
    });
})();
</script>
@endpush
