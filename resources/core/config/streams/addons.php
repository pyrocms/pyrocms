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

    'eager' => [],

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
        'core/anomaly/redirects-module',
        'core/anomaly/sitemap-extension'
    ]

];
