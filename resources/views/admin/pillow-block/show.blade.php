@extends('admin.layout')

@section('title', 'Pillow Block Details')
@section('page-title', 'Pillow Block Details')

@section('content')
<div class="row">
    <!-- Basic Details Card -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-info-circle me-2"></i>Pillow Block Information</h5>
            </div>
            <div class="card-body">
                @if($pillowBlock->resolveMainImagePath())
                    <div class="mb-3 text-center">
                        <img src="{{ $pillowBlock->image_url }}"
                             alt="{{ $pillowBlock->name }}"
                             class="img-fluid rounded"
                             style="max-height: 250px; border: 1px solid #ddd; padding: 5px; background-color: #fff;">
                    </div>
                @endif
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width="180">ID</th>
                        <td>{{ $pillowBlock->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><strong>{{ $pillowBlock->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code>{{ $pillowBlock->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>SKU</th>
                        <td>{{ $pillowBlock->sku ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Brand</th>
                        <td>{{ $pillowBlock->brand ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>MRP</th>
                        <td>{{ (float) $pillowBlock->price > 0 ? number_format((float) $pillowBlock->price, 2) . ' RON' : 'Price on request' }}</td>
                    </tr>
                    <tr>
                        <th>Sale price</th>
                        <td>{{ $pillowBlock->sale_price !== null && (float) $pillowBlock->sale_price > 0 ? number_format((float) $pillowBlock->sale_price, 2) . ' RON' : '—' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>
                            @if($pillowBlock->category)
                                <span class="badge bg-info">{{ $pillowBlock->category->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($pillowBlock->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                            @if($pillowBlock->is_featured)
                                <span class="badge bg-primary ms-1">Featured</span>
                            @endif
                            @if($pillowBlock->is_new_arrival)
                                <span class="badge bg-warning text-dark ms-1">New Arrival</span>
                            @endif
                        </td>
                    </tr>
                    @if($pillowBlock->short_description)
                    <tr>
                        <th>Short Description</th>
                        <td>{{ $pillowBlock->short_description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Specifications Card -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-gear-fill me-2"></i>Pillow Block Specifications</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th width="220">Bearing Number</th>
                        <td>{{ $pillowBlock->bearing_number ?? '—' }}</td>
                    </tr>
                    @php
                        $specs = $pillowBlock->specifications ?? [];
                    @endphp
                    @forelse($specs as $spec)
                        <tr>
                            <th>
                                {{ $spec['title'] ?? 'Specification' }}
                                @if(!empty($spec['dimension']))
                                    ({{ $spec['dimension'] }})
                                @endif
                            </th>
                            <td>{{ $spec['value'] ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted text-center py-2">No additional specifications defined.</td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="2" class="table-secondary text-center fw-bold">Equivalents</th>
                    </tr>
                    <tr>
                        <th>SKF</th>
                        <td>{{ $pillowBlock->equiv_skf ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>FAG</th>
                        <td>{{ $pillowBlock->equiv_fag ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>NTN</th>
                        <td>{{ $pillowBlock->equiv_ntn ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Timken</th>
                        <td>{{ $pillowBlock->equiv_timken ?? '—' }}</td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Description & Media Links -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($pillowBlock->description)
                    <h6 class="fw-bold mb-2">Detailed Description:</h6>
                    <div class="p-3 bg-light rounded border mb-4">
                        {!! $pillowBlock->description !!}
                    </div>
                @endif

                @if($pillowBlock->video || $pillowBlock->pdf_catalogue || count($pillowBlock->images) > 0)
                    <h6 class="fw-bold mb-3">Media Attachments:</h6>
                    <div class="row">
                        <!-- Video -->
                        @if($pillowBlock->video)
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small fw-semibold">Product Video</p>
                                <video src="{{ storage_asset($pillowBlock->video) }}" controls class="img-fluid rounded border bg-black" style="max-height: 200px; width: 100%;"></video>
                            </div>
                        @endif

                        <!-- PDF -->
                        @if($pillowBlock->pdf_catalogue)
                            <div class="col-md-4 mb-3 d-flex flex-col justify-content-center align-items-start">
                                <p class="mb-1 text-muted small fw-semibold">Catalogue Sheet</p>
                                <a href="{{ storage_asset($pillowBlock->pdf_catalogue) }}" target="_blank" class="btn btn-outline-danger d-inline-flex align-items-center p-3 rounded">
                                    <i class="bi bi-file-earmark-pdf-fill fs-2 me-2"></i>
                                    <div>
                                        <div class="fw-bold text-start">Download PDF Catalog</div>
                                        <div class="small text-muted text-start">Open in new tab</div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        <!-- Gallery -->
                        @if(count($pillowBlock->images) > 0)
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small fw-semibold">Gallery Images</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($pillowBlock->galleryImages as $img)
                                        <a href="{{ storage_asset($img->image_path) }}" target="_blank">
                                            <img src="{{ storage_asset($img->image_path) }}" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="d-flex gap-2 border-top pt-3 mt-4">
                    <a href="{{ route('admin.pillow-block.edit', $pillowBlock) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Pillow Block
                    </a>
                    <a href="{{ route('admin.pillow-block.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
