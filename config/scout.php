<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'search'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', 'tntsearch'),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => false,

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'algolia' => [
        'id'     => env('ALGOLIA_APP_ID'),
        'secret' => env('ALGOLIA_SECRET'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | TNT Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your TNT settings. TNT is the default search
    | indexing mechanism for the Streams Platform. TNT Search is a fully
    | featured full text search engine for PHP.
    |
    */

    'tntsearch' => [
        'fuzziness'     => env('TNTSEARCH_FUZZINESS', false),
        'fuzzy'         => [
            'prefix_length'  => 2,
            'max_expansions' => 10,
            'distance'       => 2,
        ],
        'searchBoolean' => env('TNTSEARCH_BOOLEAN', true),
    ],
];
