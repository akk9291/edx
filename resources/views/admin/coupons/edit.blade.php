@extends('admin.layout')

@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Coupon Information</h5>
            </div>
            <div class="card-body">
                <form action="{{{ route('admin.coupons.update', $coupon) }}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Coupon Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $coupon->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code', $coupon->code) }}" 
                                   required 
                                   style="text-transform: uppercase;">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description', $coupon->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('discount_type') is-invalid @enderror" 
                                    id="discount_type" 
                                    name="discount_type" 
                                    required>
                                <option value="">Select Type</option>
                                <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('discount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.01" 
                                   min="0" 
                                   class="form-control @error('discount_value') is-invalid @enderror" 
                                   id="discount_value" 
                                   name="discount_value" 
                                   value="{{ old('discount_value', $coupon->discount_value) }}" 
                                   required>
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="valid_from" class="form-label">Valid From <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('valid_from') is-invalid @enderror" 
                                   id="valid_from" 
                                   name="valid_from" 
                                   value="{{ old('valid_from', $coupon->valid_from ? $coupon->valid_from->format('Y-m-d') : '') }}" 
                                   required>
                            @error('valid_from')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="valid_until" class="form-label">Valid Until <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('valid_until') is-invalid @enderror" 
                                   id="valid_until" 
                                   name="valid_until" 
                                   value="{{ old('valid_until', $coupon->valid_until ? $coupon->valid_until->format('Y-m-d') : '') }}" 
                                   required>
                            @error('valid_until')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="minimum_order_amount" class="form-label">Minimum Order Amount</label>
                            <input type="number" 
                                   step="0.01" 
                                   min="0" 
                                   class="form-control @error('minimum_order_amount') is-invalid @enderror" 
                                   id="minimum_order_amount" 
                                   name="minimum_order_amount" 
                                   value="{{ old('minimum_order_amount', $coupon->minimum_order_amount) }}">
                            @error('minimum_order_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="usage_limit" class="form-label">Usage Limit</label>
                            <input type="number" 
                                   min="1" 
                                   class="form-control @error('usage_limit') is-invalid @enderror" 
                                   id="usage_limit" 
                                   name="usage_limit" 
                                   value="{{ old('usage_limit', $coupon->usage_limit) }}">
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty for unlimited</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" 
                                id="is_active" 
                                name="is_active">
                            <option value="1" {{ old('is_active', $coupon->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $coupon->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{{ route('admin.coupons.index') }}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


