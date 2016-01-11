<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Eager Loaded Addons
    |--------------------------------------------------------------------------
    |
    | Eager loaded addons are registered first and can be defined
    | here by specifying their relative path to the project root.
    |
    */

    'eager' => [
        'core/anomaly/redirects-module'
    ],
    'deferred' => [
        'core/anomaly/addons-module'
    ]
];
