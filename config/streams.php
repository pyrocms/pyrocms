<?php

return [

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
        'field_type',
        'extension',
        'module',
        'plugin',
        'block',
        'theme'
    ],

    /*
	|--------------------------------------------------------------------------
	| Default Themes
	|--------------------------------------------------------------------------
	|
	| This defines fallback / default themes for the front and backend.
	|
	*/

    'admin_theme'  => env('ADMIN_THEME', 'Anomaly\StreamsTheme\StreamsTheme'),
    'standard_theme' => env('STANDARD_THEME', 'Anomaly\StreamsTheme\StreamsTheme'),

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
    ],

    /*
	|--------------------------------------------------------------------------
	| Site Enabled
	|--------------------------------------------------------------------------
	|
	| This controls whether the site is enabled to the public or not. When the
    | site is disabled you may only access the frontend if you are in the IP
    | white-list.
    |
    | NOTE: This configuration may be overridden by the Settings module.
	|
	*/

    'site_enabled' => true,

    /*
	|--------------------------------------------------------------------------
	| IP Whitelist
	|--------------------------------------------------------------------------
	|
	| If the site is disabled, only these IPs will be allowed to view public
    | facing content.
    |
    | NOTE: This configuration may be overridden by the Settings module.
	|
	*/

    'ip_whitelist' => [],

    /*
	|--------------------------------------------------------------------------
	| Force HTTPS
	|--------------------------------------------------------------------------
	|
	| You may opt to force an SSL connection when accessing the application.
    | Supported options are "none", "all", "public", "admin"
    |
    | NOTE: This configuration may be overridden by the Settings module.
	|
	*/

    'force_https' => "none",
];
