<?php

return [
    'default' => env('BROADCAST_DRIVER', 'pusher'),

   'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'host' => env('PUSHER_HOST') ?: null,
            'port' => env('PUSHER_PORT') ?: null,
            'scheme' => env('PUSHER_SCHEME', 'https'),
            'useTLS' => filter_var(env('PUSHER_APP_USE_TLS', true), FILTER_VALIDATE_BOOLEAN),
        ],
    ],
],
];
