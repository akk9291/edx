<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update - {{ $order->order_number }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center;">
        <h1 style="color: #333; margin: 0;">Order Status Update</h1>
    </div>
    
    <div style="background-color: #fff; padding: 30px; margin-top: 20px;">
        <p>Hello {{ $order->user->name }},</p>
        
        <p>Your order status has been updated.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #333;">
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Previous Status:</strong> {{ ucfirst($oldStatus) }}</p>
            <p><strong>Current Status:</strong> <span style="font-weight: bold; color: #28a745;">{{ ucfirst($newStatus) }}</span></p>
        </div>
        
        @if($newStatus === 'shipped' && $order->delhivery_waybill)
        <div style="background-color: #e8f4f8; padding: 15px; margin: 20px 0; border-left: 4px solid #17a2b8;">
            <p style="margin: 0;"><strong>Tracking Information:</strong></p>
            <p style="margin: 5px 0;">Your order has been shipped!</p>
            @if($order->delhivery_waybill)
                <p style="margin: 5px 0;"><strong>Waybill Number:</strong> {{ $order->delhivery_waybill }}</p>
            @endif
            <p style="margin: 10px 0 0 0;">You can track your order using the tracking number above.</p>
        </div>
        @endif
        
        @if($newStatus === 'delivered')
        <div style="background-color: #d4edda; padding: 15px; margin: 20px 0; border-left: 4px solid #28a745;">
            <p style="margin: 0;"><strong>Order Delivered!</strong></p>
            <p style="margin: 5px 0;">Your order has been successfully delivered. We hope you enjoy your purchase!</p>
        </div>
        @endif
        
        <p>If you have any questions, please don't hesitate to contact our support team.</p>
        
        <p>Thank you for shopping with us!</p>
        
        <p>Best regards,<br>{{ config('app.name') }} Team</p>
    </div>
    
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>




