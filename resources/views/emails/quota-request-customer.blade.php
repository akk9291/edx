<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation request received</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #111; max-width: 640px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">Thank you, {{ $quotaRequest->contact_name }}</h1>
    <p>We received your quotation request <strong>{{ $quotaRequest->reference }}</strong> and will get back to you shortly.</p>
    @if($quotaRequest->items->isNotEmpty())
    <h2 style="font-size: 16px; margin-top: 20px;">Your requested lines</h2>
    <ul style="padding-left: 20px;">
        @foreach($quotaRequest->items as $item)
        <li>{{ $item->product_sku ?? 'Item' }} × {{ $item->quantity }}</li>
        @endforeach
    </ul>
    @endif
    <p style="font-size: 14px; color: #6b7280;">If you did not submit this request, you can ignore this email.</p>
</body>
</html>
