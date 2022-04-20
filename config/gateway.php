<?php

return [

    'paypal' => [
        'mode' => 'sandbox',
        'sandbox' => [
            'username' => env('PAYPAL_SANDBOX_USERNAME'),
            'password' => env('PAYPAL_SANDBOX_PASSWORD'),
            'signature' => env('PAYPAL_SANDBOX_SIGNATURE'),
        ],
        'live' => [
            'username' => env('PAYPAL_LIVE_USERNAME'),
            'password' => env('PAYPAL_LIVE_PASSWORD'),
            'signature' => env('PAYPAL_LIVE_SIGNATURE'),
        ]
    ],


    'stripe' => [
        'key' => [
            'secret' => env('STRIPE_KEY_SECRET'),
            'public' => env('STRIPE_KEY_PUBLIC'),
        ]
    ],

    'sogecom' => [
        'mode' => strtoupper(env('SOGECOM_MODE')),
        'test' => [
            'site_id' => env('SOGECOM_TEST_SITE_ID'),
            'key' => env('SOGECOM_TEST_KEY'),
        ],
        'production' => [
            'site_id' => env('SOGECOM_PRODUCTION_SITE_ID'),
            'key' => env('SOGECOM_PRODUCTION_KEY'),
        ],
    ],

];
