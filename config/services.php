<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '1285666988123344',
        'client_secret' => '4475f57e8d1e944f82a04a9baecba9da',
        'redirect' => 'http://lamdev.dev/vi/login-facebook/callback'
    ],
    'google' => [
        'client_id' => '517893014638-tov50po160v4ovao8fvp1es7tjqtegg7.apps.googleusercontent.com',
        'client_secret' => 'YtBp2ABj_sVdg1yNzmUUobwO',
        'redirect' => 'http://lamdev.dev/vi/login-google/callback',
        'app_name' => 'lamdev.dev',
        'scopes' => 'email,profile,http://www.googleapis.com/auth/drive',
        'approval_prompt' => 'force',
        'access_type' => 'offline'
    ]
];
