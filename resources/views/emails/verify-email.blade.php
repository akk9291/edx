<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center;">
        <h1 style="color: #333; margin: 0;">Verify Your Email Address</h1>
    </div>
    
    <div style="background-color: #fff; padding: 30px; margin-top: 20px;">
        <p>Hello {{ $user->name }},</p>
        
        <p>Thank you for registering with {{ config('app.name') }}! Please verify your email address by clicking the button below.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $verificationUrl }}" 
               style="display: inline-block; background-color: #000; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Verify Email Address
            </a>
        </div>
        
        <p style="color: #666; font-size: 14px;">Or copy and paste this link into your browser:</p>
        <p style="color: #666; font-size: 12px; word-break: break-all;">{{ $verificationUrl }}</p>
        
        <div style="background-color: #e8f4f8; padding: 15px; margin: 20px 0; border-left: 4px solid #17a2b8;">
            <p style="margin: 0; font-size: 14px;"><strong>Note:</strong> This verification link will expire in 24 hours.</p>
        </div>
        
        <p style="color: #666; font-size: 14px;">If you did not create an account, please ignore this email.</p>
        
        <p>Thank you,<br>{{ config('app.name') }} Team</p>
    </div>
    
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>

