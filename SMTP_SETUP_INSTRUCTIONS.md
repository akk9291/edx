# SMTP Email Configuration Instructions

## Email Credentials
- **Email**: work@coderpoint.in
- **Password**: Jain1008#$
- **SMTP Host**: smtp.hostinger.com
- **Port**: 465
- **Encryption**: SSL

## Setup Steps

### 1. Update .env File

Open your `.env` file and add/update the following lines:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=work@coderpoint.in
MAIL_PASSWORD="Jain1008#$"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=work@coderpoint.in
MAIL_FROM_NAME="${APP_NAME}"
```

**Important Notes:**
- Keep the password in quotes if it contains special characters like `#` or `$`
- Make sure `MAIL_ENCRYPTION=ssl` (not tls) for port 465
- `MAIL_FROM_ADDRESS` should match your `MAIL_USERNAME`

### 2. Clear Configuration Cache

After updating `.env`, run these commands:

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test Email Configuration

You can test the email configuration by creating a test route or using tinker:

```bash
php artisan tinker
```

Then run:
```php
Mail::raw('Test email from Laravel', function ($message) {
    $message->to('work@coderpoint.in')
            ->subject('Test Email');
});
```

### 4. Verify Email Sending

The application sends emails for:
- Order confirmation (when order is placed)
- Order status updates (when admin updates order status)
- Password reset (if implemented)
- OTP verification (if implemented)

### Troubleshooting

If emails are not sending:

1. **Check .env file**: Make sure all values are correct and password is in quotes
2. **Check encryption**: Port 465 requires `ssl`, port 587 requires `tls`
3. **Check credentials**: Verify email and password are correct
4. **Check firewall**: Make sure port 465 is not blocked
5. **Check logs**: Check `storage/logs/laravel.log` for email errors
6. **Test connection**: Try using a mail client (like Thunderbird) with same credentials

### Common Issues

**Issue**: "Connection timeout"
- **Solution**: Check if port 465 is open and SMTP host is correct

**Issue**: "Authentication failed"
- **Solution**: Verify username and password are correct, check if account requires app-specific password

**Issue**: "SSL certificate problem"
- **Solution**: For development, you can temporarily disable SSL verification (not recommended for production)

### Production Recommendations

1. Use environment-specific email settings
2. Set up email queue for better performance
3. Monitor email delivery rates
4. Set up email logging for debugging
5. Consider using a service like Mailgun or SendGrid for better deliverability

