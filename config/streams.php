<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Distribution
	|--------------------------------------------------------------------------
	|
	| This controls the primary distribution used by Streams. The Streams
    | distribution is like the DNA of the application's unique characteristics.
	|
	*/
    
    'distribution' => 'Anomaly\PyrocmsDistribution\PyrocmsDistribution',

    /*
    |--------------------------------------------------------------------------
    | Addon Types
    |--------------------------------------------------------------------------
    |
    | This controls the types of addons that are available and loaded. These
    | are loaded in the order in which they appear here.
    |
    */

    'addon_types' => [
        'distribution',
        'field_type',
        'extension',
        'module',
        'plugin',
        'block',
        'theme'
    ],

    /*
	|--------------------------------------------------------------------------
	| Available Locales
	|--------------------------------------------------------------------------
	|
	| This controls the top level locales that are available to the system.
    | This will prevent from locales where no translations exist.
    |
    | NOTE: This configuration may be overridden by the Localization module.
	|
	*/

    'available_locales' => [
        'en' => 'English'
    ],

    /*
	|--------------------------------------------------------------------------
	| Enabled Locales
	|--------------------------------------------------------------------------
	|
	| This controls the translations available to save when editing entries.
    |
    | NOTE: This configuration may be overridden by the Localization module.
	|
	*/

    'enabled_locales' => [
        'en' => 'English'
    ]
];
