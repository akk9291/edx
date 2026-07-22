<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    ],

    'delhivery' => [
        'client_id' => env('DELHIVERY_CLIENT_ID'),
        'client_secret' => env('DELHIVERY_CLIENT_SECRET'),
        'api_endpoint' => env('DELHIVERY_API_ENDPOINT', 'https://staging-express.delhivery.com'),
    ],

    'shiprocket' => [
        'email' => env('SHIPROCKET_EMAIL'),
        'password' => env('SHIPROCKET_PASSWORD'),
        'api_url' => env('SHIPROCKET_API_URL', 'https://apiv2.shiprocket.in'),
        'pickup_postcode' => env('SHIPROCKET_PICKUP_POSTCODE', '110001'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'msg91' => [
        'auth_key' => env('MSG91_AUTH_KEY'),
        'sender_id' => env('MSG91_SENDER_ID', 'PRCBOT'),
        'route' => env('MSG91_ROUTE', 4),
        'country' => env('MSG91_COUNTRY', 91),
        'template_id' => env('MSG91_TEMPLATE_ID'),
    ],

];
