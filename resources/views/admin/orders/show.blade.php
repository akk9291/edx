@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order Details: ' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="200">Order Number</th>
                        <td><strong>{{ $order->order_number }}</strong></td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    @if($order->customer_phone)
                    <tr>
                        <th>Phone</th>
                        <td>{{ $order->customer_phone }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $order->status_badge_class }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td>
                            <span class="badge bg-{{ $order->payment_status_badge_class }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @if($order->payment_method)
                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Subtotal</th>
                        <td>₹{{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Tax</th>
                        <td>₹{{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Shipping</th>
                        <td>₹{{ number_format($order->shipping, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Billing Address</h5>
            </div>
            <div class="card-body">
                @php
                    $billing = is_array($order->billing_address) ? $order->billing_address : (is_string($order->billing_address) ? json_decode($order->billing_address, true) : []);
                @endphp
                @if(!empty($billing))
                    <p class="mb-0">
                        {{ ($billing['first_name'] ?? '') . ' ' . ($billing['last_name'] ?? '') }}<br>
                        {{ $billing['address_line_1'] ?? '' }}<br>
                        @if(!empty($billing['address_line_2'])){{ $billing['address_line_2'] }}<br>@endif
                        {{ $billing['city'] ?? '' }}, {{ $billing['state'] ?? '' }} {{ $billing['pincode'] ?? '' }}<br>
                        @if(!empty($billing['email']))Email: {{ $billing['email'] }}<br>@endif
                        @if(!empty($billing['phone']))Phone: {{ $billing['phone'] }}@endif
                    </p>
                @else
                    <p class="text-muted mb-0">—</p>
                @endif
            </div>
        </div>

        @if($order->shipping_address)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                @php
                    $shipping = is_array($order->shipping_address) ? $order->shipping_address : (is_string($order->shipping_address) ? json_decode($order->shipping_address, true) : []);
                @endphp
                @if(!empty($shipping))
                    <p class="mb-0">
                        {{ ($shipping['first_name'] ?? '') . ' ' . ($shipping['last_name'] ?? '') }}<br>
                        {{ $shipping['address_line_1'] ?? '' }}<br>
                        @if(!empty($shipping['address_line_2'])){{ $shipping['address_line_2'] }}<br>@endif
                        {{ $shipping['city'] ?? '' }}, {{ $shipping['state'] ?? '' }} {{ $shipping['pincode'] ?? '' }}<br>
                        @if(!empty($shipping['email']))Email: {{ $shipping['email'] }}<br>@endif
                        @if(!empty($shipping['phone']))Phone: {{ $shipping['phone'] }}@endif
                    </p>
                @else
                    <p class="text-muted mb-0">—</p>
                @endif
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                @php
                                    $colorLines = $item->adminCustomizationColorLines();
                                    $sizeLabel = $item->adminDisplaySize();
                                    $custArr = $item->customizationArray();
                                    $engrText = is_array($custArr) && !empty($custArr['engraving_text']) && is_string($custArr['engraving_text']) ? trim($custArr['engraving_text']) : '';
                                    $engrObj = is_array($custArr) && isset($custArr['engraving']) && is_array($custArr['engraving']) ? $custArr['engraving'] : null;
                                    $engrArtPath = $engrObj && !empty($engrObj['engraving_image']) && is_string($engrObj['engraving_image']) ? trim($engrObj['engraving_image']) : '';
                                    $engrTop = $engrObj && isset($engrObj['top']) && is_array($engrObj['top']) ? $engrObj['top'] : null;
                                    $engrBottom = $engrObj && isset($engrObj['bottom']) && is_array($engrObj['bottom']) ? $engrObj['bottom'] : null;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->adminDisplayProductTitle() }}</div>
                                        @if($item->customization_json && $item->product_name && $item->adminDisplayProductTitle() !== $item->product_name)
                                            <div class="small text-muted">Catalog: {{ $item->product_name }}</div>
                                        @endif
                                        @if($item->customization_image)
                                            <div class="mt-2">
                                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->customization_image) }}" alt="Customizer preview" class="rounded border" style="max-width:140px;height:auto;">
                                            </div>
                                        @endif
                                        @if($engrObj)
                                            @php
                                                $isDouble = !empty($engrObj['mode']) && is_string($engrObj['mode']) && strtolower(trim($engrObj['mode'])) === 'double';
                                                $legacyName = $engrObj['category_name'] ?? $engrObj['category_slug'] ?? '—';
                                                $legacyText = !empty($engrObj['text']) && is_string($engrObj['text']) ? trim($engrObj['text']) : '';
                                                $renderSlot = function ($slot, string $label) {
                                                    if (!is_array($slot)) { return ''; }
                                                    $name = $slot['category_name'] ?? $slot['category_slug'] ?? '—';
                                                    $text = !empty($slot['text']) && is_string($slot['text']) ? trim($slot['text']) : '';
                                                    $img = !empty($slot['engraving_image']) && is_string($slot['engraving_image']) ? trim($slot['engraving_image']) : '';
                                                    $html = '<div class="small mt-2"><span class="text-muted fw-semibold">'.e($label).':</span> '.e($name);
                                                    if ($text !== '') { $html .= '<span class="text-muted"> — </span>'.e($text); }
                                                    $html .= '</div>';
                                                    if ($img !== '') {
                                                        $url = \Illuminate\Support\Facades\Storage::disk('public')->url($img);
                                                        $html .= '<div class="small mt-1"><a href="'.e($url).'" target="_blank" rel="noopener">Engraving artwork</a></div>';
                                                        $html .= '<div class="mt-1"><img src="'.e($url).'" alt="Engraving upload" class="rounded border" style="max-width:120px;height:auto;"></div>';
                                                    }
                                                    return $html;
                                                };
                                            @endphp
                                            @if($engrTop || $engrBottom)
                                                {!! $renderSlot($engrTop, 'Top') !!}
                                                @if($isDouble)
                                                    {!! $renderSlot($engrBottom, 'Bottom') !!}
                                                @endif
                                            @else
                                                <div class="small mt-2">
                                                    <span class="text-muted fw-semibold">Engraving:</span>
                                                    {{ $legacyName }}
                                                    @if($legacyText !== '')
                                                        <span class="text-muted"> — </span>{{ $legacyText }}
                                                    @endif
                                                </div>
                                                @if($engrArtPath !== '')
                                                    <div class="small mt-1">
                                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($engrArtPath) }}" target="_blank" rel="noopener">Engraving artwork</a>
                                                    </div>
                                                    <div class="mt-1">
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($engrArtPath) }}" alt="Engraving upload" class="rounded border" style="max-width:120px;height:auto;">
                                                    </div>
                                                @endif
                                            @endif
                                        @elseif($engrText !== '')
                                            <div class="small mt-2"><span class="text-muted fw-semibold">Engraving:</span> {{ $engrText }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $item->product_sku ?? '—' }}</td>
                                    <td>
                                        @if(count($colorLines) > 0)
                                            <ul class="list-unstyled small mb-0">
                                                @foreach($colorLines as $line)
                                                    <li class="d-flex align-items-center gap-2 py-1">
                                                        @if(!empty($line['hex']))
                                                            <span class="d-inline-block rounded border flex-shrink-0" style="width:16px;height:16px;background-color:{{ $line['hex'] }}"></span>
                                                        @endif
                                                        <span><span class="text-muted">{{ $line['label'] }}:</span> {{ $line['name'] !== '' ? $line['name'] : ($line['hex'] ?? '—') }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ $item->color ?: '—' }}
                                        @endif
                                    </td>
                                    <td>{{ $sizeLabel !== '' ? $sizeLabel : '—' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ currency($item->price) }}</td>
                                    <td><strong>{{ currency($item->total) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Notes</h5>
            </div>
            <div class="card-body">
                <p>{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-between">
            <a href="{{{ route('admin.orders.index') }}}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
            <a href="{{{ route('admin.orders.edit', $order) }}}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Order
            </a>
        </div>
    </div>
</div>
@endsection

