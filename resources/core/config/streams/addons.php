<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Eager Addons
    |--------------------------------------------------------------------------
    |
    | Eager loaded addons are registered first and can be defined
    | here by specifying their relative path to the addon's root.
    |
    */

    'eager' => [
        'core/anomaly/sitemap-extension'
    ],

    /*
    |--------------------------------------------------------------------------
    | Deferred Addons
    |--------------------------------------------------------------------------
    |
    | Deferred addons are registered last and can be defined
    | here by specifying their relative path to the addon's root.
    |
    */

    'deferred' => [
        'core/anomaly/pages-module',
        'core/anomaly/redirects-module'
    ]

];
