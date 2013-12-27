## Install & Configure in Laravel 4

### 1. Composer {#composer}

----

Open your `composer.json` file and add the following lines:

	{
		"require": {
			"cartalyst/sentry": "2.0.*",
		},
		"minimum-stability": "stable"
	}

Run composer update from the command line

	composer update


### 2. Service Provider {#service-provider}

----

Add the following to the list of service providres in `app/config/app.php`.

	'Cartalyst\Sentry\SentryServiceProvider',


### 3. Alias {#aliases}

----

Add the following to the list of class aliases in `app/config/app.php`.

	'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',


### 4. Migrations {#migrations}

----

Sentry comes with it's own migration files and in order for you to run these migrations succesfully you need to have
a default database connection setup on your Laravel 4 application, once you have that setup, you can run the following
command to run the migrations:

	php artisan migrate --package=cartalyst/sentry

Feel free to write your own migrations which insert the correct tables if you'd like!

### 5. Configuration {#configuration}

----

After installing, you can publish the package's configuration file into your application, by running the following command:

	php artisan config:publish cartalyst/sentry

This will publish the config file to `app/config/packages/cartalyst/sentry/config.php` where you modify the package configuration.
