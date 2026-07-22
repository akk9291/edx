<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ $order->order_number }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center;">
        <h1 style="color: #333; margin: 0;">Order Confirmation</h1>
    </div>
    
    <div style="background-color: #fff; padding: 30px; margin-top: 20px;">
        <p>Hello {{ $order->user->name }},</p>
        
        <p>Thank you for your order! Your order has been confirmed and we're getting it ready for you.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #333;">
            <h2 style="margin-top: 0; color: #333;">Order Details</h2>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        </div>
        
        <h3 style="color: #333; border-bottom: 2px solid #333; padding-bottom: 10px;">Order Items</h3>
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <thead>
                <tr style="background-color: #f4f4f4;">
                    <th style="padding: 10px; text-align: left; border-bottom: 2px solid #ddd;">Product</th>
                    <th style="padding: 10px; text-align: center; border-bottom: 2px solid #ddd;">Quantity</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 2px solid #ddd;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $item->product->name ?? $item->product_name }}</td>
                    <td style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0;">
            <div style="display: flex; justify-content: space-between; margin: 5px 0;">
                <span>Subtotal:</span>
                <span>₹{{ number_format($order->total_amount - $order->shipping_charge - ($order->coupon_discount ?? 0), 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 5px 0;">
                <span>Shipping:</span>
                <span>₹{{ number_format($order->shipping_charge, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 15px 0; padding-top: 15px; border-top: 2px solid #333; font-weight: bold; font-size: 1.1em;">
                <span>Total:</span>
                <span>₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
        
        <h3 style="color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; margin-top: 30px;">Shipping Address</h3>
        <p>
            {{ $order->shipping_address['full_name'] ?? '' }}<br>
            {{ $order->shipping_address['address_line_1'] ?? '' }}<br>
            @if(!empty($order->shipping_address['address_line_2']))
                {{ $order->shipping_address['address_line_2'] }}<br>
            @endif
            {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['pincode'] ?? '' }}<br>
            Phone: {{ $order->shipping_address['phone'] ?? '' }}
        </p>
        
        <div style="background-color: #e8f4f8; padding: 15px; margin: 20px 0; border-left: 4px solid #17a2b8;">
            <p style="margin: 0;"><strong>Next Steps:</strong></p>
            <p style="margin: 5px 0;">We'll send you another email once your order ships with tracking information.</p>
        </div>
        
        <p>If you have any questions, please don't hesitate to contact our support team.</p>
        
        <p>Thank you for shopping with us!</p>
        
        <p>Best regards,<br>{{ config('app.name') }} Team</p>
    </div>
    
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>




