<?php

use App\Models\Staff;
use App\Models\Tenant;
use App\Models\User;

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'staff' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],

        // ── Tenant guard for mobile app (Sanctum token auth) ──────────────────
        'tenant' => [
            'driver'   => 'session',
            'provider' => 'tenants',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],
        'staff' => [
            'driver' => 'eloquent',
            'model' => Staff::class,
        ],

        // ── Tenant provider ───────────────────────────────────────────────────
        'tenants' => [
            'driver' => 'eloquent',
            'model'  => Tenant::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
