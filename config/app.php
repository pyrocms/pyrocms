<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug'           => true,
    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url'             => 'http://localhost',
    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone'        => 'UTC',
    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale'          => 'en',
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',
    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key'             => 'eXkXG8CBk2Iei1kb8gpt1KJarwlpQX4M',
    'cipher'          => MCRYPT_RIJNDAEL_128,
    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers'       => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Log\LogServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Reminders\ReminderServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        /**
         * 3rd party service providers
         */
        'Cartalyst\Sentry\SentryServiceProvider',
        'Barryvdh\Debugbar\ServiceProvider',
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
        'Intervention\Image\ImageServiceProvider',
        'Anomaly\Lexicon\LexiconServiceProvider',
        /**
         * Streams service providers
         */
        //'Streams\Core\Provider\AppServiceProvider',
        //'Streams\Core\Provider\ArtisanServiceProvider',
        'Streams\Core\Provider\ErrorServiceProvider',
        //'App\Providers\FilterServiceProvider',
        'Streams\Core\Provider\LogServiceProvider',
        'Streams\Core\Provider\PresenterServiceProvider',
        'Streams\Core\Provider\ApplicationServiceProvider',
        'Streams\Core\Provider\FilterServiceProvider',
        'Streams\Core\Provider\RouteServiceProvider',
        'Streams\Core\Provider\AssetServiceProvider',
        'Streams\Core\Provider\ImageServiceProvider',
        'Streams\Core\Provider\AddonServiceProvider',
        'Streams\Core\Provider\HelperServiceProvider',
        'Streams\Core\Provider\MessagesServiceProvider',
        'Streams\Core\Provider\TranslationServiceProvider',
    ],
    /*
    |--------------------------------------------------------------------------
    | Service Provider Manifest
    |--------------------------------------------------------------------------
    |
    | The service provider manifest is used by Laravel to lazy load service
    | providers which are not needed for each request, as well to keep a
    | list of all of the services. Here, you may set its storage spot.
    |
    */

    'manifest'        => storage_path() . '/meta',
    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases'         => [
        /**
         * Laravel aliases
         */
        'App'                 => 'Illuminate\Support\Facades\App',
        'Artisan'             => 'Illuminate\Support\Facades\Artisan',
        'Auth'                => 'Illuminate\Support\Facades\Auth',
        'Blade'               => 'Illuminate\Support\Facades\Blade',
        'Cache'               => 'Illuminate\Support\Facades\Cache',
        'Config'              => 'Illuminate\Support\Facades\Config',
        'Cookie'              => 'Illuminate\Support\Facades\Cookie',
        'Crypt'               => 'Illuminate\Support\Facades\Crypt',
        'DB'                  => 'Illuminate\Support\Facades\DB',
        'Event'               => 'Illuminate\Support\Facades\Event',
        'File'                => 'Illuminate\Support\Facades\File',
        'Hash'                => 'Illuminate\Support\Facades\Hash',
        'Input'               => 'Illuminate\Support\Facades\Input',
        'Lang'                => 'Illuminate\Support\Facades\Lang',
        'Log'                 => 'Illuminate\Support\Facades\Log',
        'Mail'                => 'Illuminate\Support\Facades\Mail',
        'Paginator'           => 'Illuminate\Support\Facades\Paginator',
        'Password'            => 'Illuminate\Support\Facades\Password',
        'Queue'               => 'Illuminate\Support\Facades\Queue',
        'Redirect'            => 'Illuminate\Support\Facades\Redirect',
        'Redis'               => 'Illuminate\Support\Facades\Redis',
        'Request'             => 'Illuminate\Support\Facades\Request',
        'Response'            => 'Illuminate\Support\Facades\Response',
        'Route'               => 'Illuminate\Support\Facades\Route',
        'Schema'              => 'Illuminate\Support\Facades\Schema',
        'Session'             => 'Illuminate\Support\Facades\Session',
        'URL'                 => 'Illuminate\Support\Facades\URL',
        'Validator'           => 'Illuminate\Support\Facades\Validator',
        'View'                => 'Illuminate\Support\Facades\View',
        'Form'                => 'Illuminate\Html\FormFacade',
        'HTML'                => 'Illuminate\Html\HtmlFacade',
        /**
         * 3rd party aliases
         */
        'Sentry'              => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
        /**
         * Streams aliases
         */
        'Block'               => 'Streams\Core\Facade\BlockFacade',
        'Extension'           => 'Streams\Core\Facade\ExtensionFacade',
        'FieldType'           => 'Streams\Core\Facade\FieldTypeFacade',
        'Module'              => 'Streams\Core\Facade\ModuleFacade',
        'Tag'                 => 'Streams\Core\Facade\TagFacade',
        'Theme'               => 'Streams\Core\Facade\ThemeFacade',
        'StreamSchemaUtility' => 'Streams\Core\Facade\StreamSchemaUtilityFacade',
        'Application'         => 'Streams\Core\Facade\ApplicationFacade',
        'Asset'               => 'Streams\Core\Facade\AssetFacade',
        'Image'               => 'Streams\Core\Facade\ImageFacade',
        'StreamsHelper'       => 'Streams\Core\Facade\StreamsHelperFacade',
        'EntryHelper'         => 'Streams\Core\Facade\EntryHelperFacade',
        'CacheHelper'         => 'Streams\Core\Facade\CacheHelperFacade',
        'ArrayHelper'         => 'Streams\Core\Facade\ArrayHelperFacade',
        'StringHelper'        => 'Streams\Core\Facade\StringHelperFacade',
        'Messages'            => 'Streams\Core\Facade\MessagesFacade',

    ],

];
