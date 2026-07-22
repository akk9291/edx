@extends('admin.layout')

@section('title', 'Color & Size Master')
@section('page-title', 'Color & Size Master')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Color & Size Master</h4>
        <p class="text-muted mb-0">Manage master colors and sizes for products</p>
    </div>
</div>

<div class="row">
    {{-- Master Colors --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-palette me-2"></i>Master Colors</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.color-size-master.store-color') }}" method="POST" class="mb-4" id="form-add-color">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-sm col-md-4">
                            <label class="form-label small mb-1">Color name</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Red, Blue" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-12 col-sm col-md-4">
                            <label class="form-label small mb-1">Color code (hex) or pick</label>
                            <div class="d-flex gap-1 align-items-center flex-nowrap">
                                <input type="text" name="color_code" id="color_code_input" class="form-control form-control-sm" placeholder="#FF0000" value="{{ old('color_code') }}" maxlength="20" title="e.g. #FF0000 or #F00 (optional)">
                                <input type="color" id="color_picker" class="form-control form-control-color p-1 flex-shrink-0" style="width: 2.5rem; height: 2rem; min-width: 2.5rem; cursor: pointer;" value="#000000" title="Pick color">
                            </div>
                        </div>
                        <div class="col-6 col-sm-auto">
                            <label class="form-label small mb-1">Order</label>
                            <input type="number" name="sort_order" class="form-control form-control-sm" placeholder="0" value="{{ old('sort_order', 0) }}" min="0" style="width: 5rem;">
                        </div>
                        <div class="col-6 col-sm-auto d-flex align-items-end pb-1">
                            <button type="submit" class="btn btn-sm btn-primary w-100 w-sm-auto"><i class="bi bi-plus-lg"></i> Add</button>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <small class="text-muted">Enter hex (e.g. #FF0000) or use the picker</small>
                        </div>
                    </div>
                </form>
                <script>
                (function(){
                    var codeInput = document.getElementById('color_code_input');
                    var picker = document.getElementById('color_picker');
                    var nameInput = document.querySelector('#form-add-color input[name="name"]');
                    if (!codeInput || !picker) return;
                    var hexToName = {
                        '#ff0000':'Red','#00ff00':'Green','#0000ff':'Blue','#ffff00':'Yellow','#ff00ff':'Magenta','#00ffff':'Cyan',
                        '#000000':'Black','#ffffff':'White','#808080':'Grey','#c0c0c0':'Silver','#800000':'Maroon','#808000':'Olive',
                        '#008000':'Green (dark)','#008080':'Teal','#000080':'Navy','#800080':'Purple','#ffa500':'Orange','#a52a2a':'Brown',
                        '#dc143c':'Crimson','#ffc0cb':'Pink','#f5f5dc':'Beige','#2f4f4f':'Dark Slate Grey','#4682b4':'Steel Blue'
                    };
                    function normalizeHex(v){
                        v = (v || '').trim();
                        if (!/^#?[0-9A-Fa-f]{3,6}$/.test(v)) return null;
                        v = v[0]==='#' ? v : '#'+v;
                        if (v.length===4) v = '#'+v[1]+v[1]+v[2]+v[2]+v[3]+v[3];
                        return v.toLowerCase();
                    }
                    function autoFillName(hex){
                        if (!nameInput || !hex) return;
                        var name = hexToName[hex] || hex;
                        if (!nameInput.value || nameInput.dataset.autoFilled === '1') nameInput.value = name;
                        nameInput.dataset.autoFilled = '1';
                    }
                    function setCodeFromPicker(){
                        if (picker.value) {
                            codeInput.value = picker.value;
                            autoFillName(normalizeHex(picker.value));
                        }
                    }
                    function setPickerFromCode(){
                        var v = (codeInput.value || '').trim();
                        if (/^#?[0-9A-Fa-f]{3,6}$/.test(v)) {
                            v = v[0]==='#' ? v : '#'+v;
                            picker.value = v.length<=4 ? v : v.substring(0,7);
                            autoFillName(normalizeHex(v));
                        }
                    }
                    picker.addEventListener('input', setCodeFromPicker);
                    codeInput.addEventListener('input', setPickerFromCode);
                    codeInput.addEventListener('change', setPickerFromCode);
                    nameInput.addEventListener('input', function(){ nameInput.dataset.autoFilled = '0'; });
                })();
                </script>
                @if($colors->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Order</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colors as $color)
                                    <tr>
                                        <td>{{ $color->id }}</td>
                                        <td>{{ $color->name }}</td>
                                        <td>
                                            @if($color->color_code)
                                                <span class="d-inline-flex align-items-center gap-2">
                                                    <span class="d-inline-block rounded border" style="width:24px;height:24px;background:{{ $color->color_code }};" title="{{ $color->color_code }}"></span>
                                                    <span class="small text-muted">{{ $color->color_code }}</span>
                                                </span>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $color->sort_order }}</td>
                                        <td>
                                            <form action="{{ route('admin.color-size-master.destroy-color', $color) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this color?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0 small">No colors yet. Add one above.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Master Sizes --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-rulers me-2"></i>Master Sizes</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.color-size-master.store-size') }}" method="POST" class="row g-2 mb-4">
                    @csrf
                    <div class="col-auto flex-grow-1">
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Add new size (e.g. S, M, L, 32GB)" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-auto" style="width: 80px;">
                        <input type="number" name="sort_order" class="form-control form-control-sm" placeholder="Order" value="0" min="0">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add</button>
                    </div>
                </form>
                @if($sizes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sizes as $size)
                                    <tr>
                                        <td>{{ $size->id }}</td>
                                        <td>{{ $size->name }}</td>
                                        <td>{{ $size->sort_order }}</td>
                                        <td>
                                            <form action="{{ route('admin.color-size-master.destroy-size', $size) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this size?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0 small">No sizes yet. Add one above.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
