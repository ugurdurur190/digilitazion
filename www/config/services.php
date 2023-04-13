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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    //kisinengin@gmail.com -> engin.kisin@sefamerve.com
    'google' => [
        'client_id' => '541002877508-7lvf6cuchcfqio49u1ci44qfovj17mg1.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://dpys.sefamerve.com.tr/login/google/callback',
    ],

];
