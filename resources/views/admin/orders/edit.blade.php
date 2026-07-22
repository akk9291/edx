@extends('admin.layout')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order: ' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Order Status</h5>
            </div>
            <div class="card-body">
                <form action="{{{ route('admin.orders.update', $order) }}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Order Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="pending" {{ old('status', $order->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ old('status', $order->status) === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ old('status', $order->status) === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ old('status', $order->status) === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ old('status', $order->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('payment_status') is-invalid @enderror" 
                                id="payment_status" 
                                name="payment_status" 
                                required>
                            <option value="pending" {{ old('payment_status', $order->payment_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status', $order->payment_status) === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ old('payment_status', $order->payment_status) === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ old('payment_status', $order->payment_status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="4">{{ old('notes', $order->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{{ route('admin.orders.show', $order) }}}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

