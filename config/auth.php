<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Authentication Defaults
     |--------------------------------------------------------------------------
     |
     | The default guard and password broker for your application.
     |
     */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'customers',
    ],

    /*
     |--------------------------------------------------------------------------
     | Authentication Guards
     |--------------------------------------------------------------------------
     |
     | Define the guards used for authentication. Here we define "web" using
     | the Customer provider.
     |
     */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | User Providers
     |--------------------------------------------------------------------------
     |
     | Define how users are retrieved from your database. We define a
     | "customers" provider using the Eloquent Customer model.
     |
     */

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Resetting Passwords
     |--------------------------------------------------------------------------
     |
     | Password reset settings.
     |
     */

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Password Confirmation Timeout
     |--------------------------------------------------------------------------
     |
     | The amount of seconds before password confirmation times out.
     |
     */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
