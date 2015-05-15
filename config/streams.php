<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Information
    |--------------------------------------------------------------------------
    |
    | This is used as the default application name / description / logo.
    |
    */

    'app' => [
        'name' => 'PyroCMS',
        'description' => 'PyroCMS is an MVC PHP Content Management System built to be easy to use, theme and develop with. It is used by individuals and organizations of all sizes around the world.',
        'logo' => 'theme::img/logo.png'
    ],

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

    'admin_theme'  => env('ADMIN_THEME', 'anomaly.theme.anomaly'),
    'standard_theme' => env('STANDARD_THEME', 'anomaly.theme.anomaly'),

    /*
    |--------------------------------------------------------------------------
    | Asset / Image Paths
    |--------------------------------------------------------------------------
    |
    | Asset / image path hints let the system know where to look for files
    | when prefixed with a namespace like "theme::".
    |
    | These asset and image path hints will be merged into the system paths
    | during boot.
    |
    */

    'asset_paths' => [],
    'image_paths' => [],

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

    'force_https' => 'none',

    /*
    |--------------------------------------------------------------------------
    | Date/Time Format
    |--------------------------------------------------------------------------
    |
    | This is the default format of dates and times displayed.
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'date_format' => 'D M j, Y',
    'time_format' => 'g:i A',

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | This is the timezone used for display purposes only. It is suggested
    | to keep the system timezone (app.timezone) as UTC.
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'timezone' => env('TIMEZONE', 'UTC')
];
