# Installation

- [Installation](#installation)
    - [Installing PyroCMS](#installing-pyrocms)
    - [Running The Installer](#installer)
- [Configuration](#configuration)
    - [Basic Configuration](#basic-configuration)
    - [Overriding Configuration](#overriding-configuration)
    - [Environment Configuration](#environment-configuration)
    - [Configuration Caching](#configuration-caching)
    - [Accessing Configuration Values](#accessing-configuration-values)
    - [Naming Your Application](#naming-your-application)
- [Maintenance Mode](#maintenance-mode)


<a name="installation"></a>
## Installation

### Server Requirements

PyroCMS has a few system requirements:

- PHP >= 5.5.9
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- Fileinfo PHP Extension
- GD Library (>=2.0) **OR** Imagick PHP extension (>=6.5.7)


<a name="install-pyrocms"></a>
### Installing PyroCMS

PyroCMS utilizes [Composer](http://getcomposer.org) to manage its dependencies. So, before using PyroCMS, make sure you have Composer installed on your machine.

#### Via Composer Create-Project

You may install PyroCMS by issuing the Composer `create-project` command in your terminal:

    composer create-project pyrocms/pyrocms=3.0-beta1 --prefer-dist

<a name="installer"></a>
### Running The Installer

After downloading and installing PyroCMS and it's dependencies, you still need to install the software in order to get started. By this time you should be able to visit your site's URL which will cause you to be redirected to the installer. **When accessing the installer for the first time it will take longer than normal. This is due to the theme assets compiling and caching for the first time.**

<a name="configuration"></a>
## Configuration

<a name="basic-configuration"></a>
### Basic Configuration

All of the configuration files for PyroCMS and the Laravel framework are stored in the `config` directory. Each option is documented, so feel free to look through the files and get familiar with the options available to you.

<a name="overriding-configuration"></a>
### Overriding Configuration

You can specify configuration values for the Streams Platform by overriding configuration values in `config/streams`. For example, if you would like to override the `streams::assets.paths` value you would add your own `assets.php` configuration file like so:

	config/streams/assets.php

Within the file you can define your own `paths` value:

	<?php

	return [
	    'paths' => [
	    	'https://s3-us-west-1.amazonaws.com/bucket'
	    ]
	];

You can view available configuration for Streams Platform in `vendor/anomaly/streams-platform/resources/config`. Simply mirror files / values in the override directory and you are set!

Similarly, you can override addon configuration in `config/addon/example-module`.


#### Directory Permissions

After installing, you may need to configure some permissions. Directories within the `storage`, `public/assets`, and the `bootstrap/cache` directories should be writable by your web server. If you are using the [Homestead](/docs/{{version}}/homestead) virtual machine, these permissions should already be set.

#### Application Key

The next thing you should do after installing is set your application key to a random string. If you installed via Composer or the Installer, this key has already been set for you by the `key:generate` command. Typically, this string should be 32 characters long. The key can also be set/changed in the `.env` environment file. **If the application key is not set, your user sessions and other encrypted data will not be secure!**

#### Additional Configuration

Almost no other configuration is needed out of the box. You are free to get started developing! However, you may wish to review the `config/app.php` file and its documentation. It contains several options such as `timezone` and `locale` that you may wish to change according to your application. **Certain values like locale, timezone and fallback_locale will be overridden by addons in order to provide a consistent value throughout the system. In this case, unless not yet set, configuration values will be different than their values in the file during runtime.**

You may also want to configure a few additional components of the Laravel framework, such as:

- [Cache](/docs/{{version}}/cache#configuration)
- [Database](/docs/{{version}}/database#configuration)
- [Session](/docs/{{version}}/session#configuration)

Once installed, you should also [configure your local environment](/docs/{{version}}/installation#environment-configuration) using the Laravel environment file. For your convenience, a default `.env` file has already been generated for you.

<a name="pretty-urls"></a>
#### Pretty URLs

**Apache**

PyroCMS ships as a Laravel installation which includes a `public/.htaccess` file that is used to allow URLs without `index.php`. If you use Apache to serve your application, be sure to enable the `mod_rewrite` module.

If the `.htaccess` file that ships with Laravel does not work with your Apache installation, try this one:

    Options +FollowSymLinks
    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

**Nginx**

On Nginx, the following directive in your site configuration will allow "pretty" URLs:

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

Of course, when using [Homestead](/docs/{{version}}/homestead), pretty URLs will be configured automatically.

<a name="environment-configuration"></a>
### Environment Configuration

It is often helpful to have different configuration values based on the environment the application is running in. For example, you may wish to use a different cache driver locally than you do on your production server. It's easy using environment based configuration.

To make this a cinch, PyroCMS utilizes the [DotEnv](https://github.com/vlucas/phpdotenv) PHP library by Vance Lucas as provided by Laravel. After completing installation via the CLI installer or GUI installer a default `.env` file will be generated for you.

All of the variables listed in this file will be loaded into the `$_ENV` PHP super-global when your application receives a request. You may use the `env` helper to retrieve values from these variables. In fact, if you review the configuration files, you will notice several of the options already using this helper!

Feel free to modify your environment variables as needed for your own local server, as well as your production environment. However, your `.env` file should not be committed to your application's source control, since each developer / server using your application could require a different environment configuration.

If you are developing with a team, you may wish to rename and include your `.env` file as `.env.example` with your application. By putting place-holder values in the example configuration file, other developers on your team can clearly see which environment variables are needed to run your application.

#### Accessing The Current Application Environment

The current application environment is determined via the `APP_ENV` variable from your `.env` file. You may access this value via the `environment` method on the `App` [facade](/docs/{{version}}/facades):

    $environment = App::environment();

You may also pass arguments to the `environment` method to check if the environment matches a given value. You may even pass multiple values if necessary:

    if (App::environment('local')) {
        // The environment is local
    }

    if (App::environment('local', 'staging')) {
        // The environment is either local OR staging...
    }

An application instance may also be accessed via the `app` helper method:

    $environment = app()->environment();

<a name="configuration-caching"></a>
### Configuration Caching

To give your application a speed boost, you should cache all of your configuration files into a single file using the `config:cache` Artisan command. This will combine all of the configuration options for your application into a single file which can be loaded quickly by the framework.

You should typically run the `php artisan config:cache` command as part of your production deployment routine. The command should not be run during local development as configuration options will frequently need to be changed during the course of your application's development.

<a name="accessing-configuration-values"></a>
### Accessing Configuration Values

You may easily access your configuration values using the global `config` helper function. The configuration values may be accessed using "dot" syntax, which includes the name of the file and option you wish to access. A default value may also be specified and will be returned if the configuration option does not exist:

    $value = config('app.timezone');

To set configuration values at runtime, pass an array to the `config` helper:

    config(['app.timezone' => 'America/Chicago']);

### Accessing Addon / Core Configuration Values

You may access configuration values for Streams Platform and any addon just as easily as any other configuration value:

	$value = config('streams::assets.paths');
	
	$value = config('anomaly.module.users::throttle.max_attempts');

<a name="maintenance-mode"></a>
## Maintenance Mode

When your application is in maintenance mode, a custom view will be displayed for all requests into your application. This makes it easy to "disable" your application while it is updating or when you are performing maintenance. A maintenance mode check is included in the default middleware stack for your application. If the application is in maintenance mode, an `HttpException` will be thrown with a status code of 503.

To enable maintenance mode, simply execute the `down` Artisan command:

    php artisan down

To disable maintenance mode, use the `up` command:

    php artisan up

### Maintenance Mode Response Template

The default template for maintenance mode responses is located in `vendor/anomaly/streams-platform/resources/views/errors/503.twig`.

Please see documentation for [overriding views](#todo) for more information.

### Maintenance Mode & Queues

While your application is in maintenance mode, no [queued jobs](/docs/{{version}}/queues) will be handled. The jobs will continue to be handled as normal once the application is out of maintenance mode.
