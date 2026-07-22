<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quota request {{ $quotaRequest->reference }}</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #111; max-width: 640px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">New quota request</h1>
    <p><strong>Reference:</strong> {{ $quotaRequest->reference }}</p>
    <p><strong>Company:</strong> {{ $quotaRequest->company_name ?: '—' }}</p>
    <p><strong>Contact:</strong> {{ $quotaRequest->contact_name }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $quotaRequest->email }}">{{ $quotaRequest->email }}</a></p>
    <p><strong>Phone:</strong> {{ $quotaRequest->phone ?: '—' }}</p>
    @if($quotaRequest->message)
    <p><strong>Message:</strong><br>{{ $quotaRequest->message }}</p>
    @endif

    <h2 style="font-size: 16px; margin-top: 24px;">Products</h2>
    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; font-size: 14px;">
        <thead>
            <tr style="background: #f3f4f6;">
                <th align="left">SKU</th>
                <th align="left">Name</th>
                <th align="right">Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotaRequest->items as $item)
            <tr>
                <td>{{ $item->product_sku ?? '—' }}</td>
                <td>{{ $item->product_name ?? '—' }}</td>
                <td align="right">{{ $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top: 24px; font-size: 14px; color: #6b7280;">
        Open the admin panel to update status and add internal notes.
    </p>
</body>
</html>
