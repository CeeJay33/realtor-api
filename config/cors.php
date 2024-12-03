<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['sanctum/csrf-cookie', '/sign-up'],

    'allowed_methods' => ['GET, POST, PUT, DELETE, OPTIONS'],

    'allowed_origins' => ['https://realtor-xi-nine.vercel.app'],

    'allowed_headers' => [ 'Content-Type, Authorization'],

    'exposed_headers' => [],

    'max_age' => 7732346777,

    'supports_credentials' => true,

];

