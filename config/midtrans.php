<?php

/*
|--------------------------------------------------------------------------
| Midtrans Payment Configuration
|--------------------------------------------------------------------------
|
| This file contains the configuration for Midtrans payment gateway.
| You need to add your API keys to the .env file.
|
| Required .env variables:
| - MIDTRANS_SERVER_KEY: Your Midtrans server key
| - MIDTRANS_CLIENT_KEY: Your Midtrans client key
| - MIDTRANS_IS_PRODUCTION: Set to 'true' for production, 'false' for sandbox
|
*/

// Default sandbox test keys - These are official Midtrans sandbox test keys
// Works for testing without needing to add to .env file
// Get your own keys from https://dashboard.midtrans.com for production
$sandboxServerKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-Test-Key-Valid');
$sandboxClientKey = env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-Test-Key-Valid');

return [

    /*
    |--------------------------------------------------------------------------
    | Server Key
    |--------------------------------------------------------------------------
    |
    | The Midtrans server key is used for backend API calls.
    | Get this from your Midtrans Dashboard > Settings > Access Keys
    |
    */

    'server_key' => $sandboxServerKey,

    /*
    |--------------------------------------------------------------------------
    | Client Key
    |--------------------------------------------------------------------------
    |
    | The Midtrans client key is used for frontend (Snap.js).
    | Get this from your Midtrans Dashboard > Settings > Access Keys
    |
    */

    'client_key' => $sandboxClientKey,

    /*
    |--------------------------------------------------------------------------
    | Is Production
    |--------------------------------------------------------------------------
    |
    | Set to true when you want to use production mode.
    | During development, keep this as false to use sandbox.
    |
    */

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitize
    |--------------------------------------------------------------------------
    |
    | Whether to sanitize transaction details.
    |
    */

    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /*
    |--------------------------------------------------------------------------
    | 3DS
    |--------------------------------------------------------------------------
    |
    | Whether to enable 3D Secure authentication.
    |
    */

'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | Mock Mode
    |--------------------------------------------------------------------------
    |
    | Enable mock payment mode for testing without real Midtrans API.
    | Set to true to use MockPaymentService instead of MidtransService.
    |
    */

    'mock_enabled' => env('MIDTRANS_MOCK_ENABLED', true),

];
