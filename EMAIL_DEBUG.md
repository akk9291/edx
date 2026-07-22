# Email Debugging Guide

## Check Email Configuration

Run this command to check your email settings:
```bash
php artisan tinker
```

Then run:
```php
config('mail.default');
config('mail.mailers.smtp.host');
config('mail.mailers.smtp.port');
config('mail.mailers.smtp.encryption');
config('mail.mailers.smtp.username');
config('mail.from.address');
```

## Check Laravel Logs

To see email errors, check the log file:
```bash
tail -f storage/logs/laravel.log
```

Or view recent errors:
```bash
tail -100 storage/logs/laravel.log | grep -i "mail\|email\|verification"
```

## Test Email Sending

You can test email sending using tinker:
```bash
php artisan tinker
```

Then:
```php
Mail::raw('Test email', function ($message) {
    $message->to('your-email@example.com')
            ->subject('Test Email');
});
```

## Common Issues

1. **Email not sending**: Check `.env` file has correct SMTP settings
2. **Connection timeout**: Verify SMTP host and port are correct
3. **Authentication failed**: Check username and password
4. **SSL/TLS error**: Make sure encryption matches port (465 = ssl, 587 = tls)

## Required .env Settings

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

## After Registration

If email doesn't send:
1. Check Laravel logs: `storage/logs/laravel.log`
2. You'll see a warning message on the page
3. Use "Resend Verification Email" button
4. Check email configuration in `.env`

