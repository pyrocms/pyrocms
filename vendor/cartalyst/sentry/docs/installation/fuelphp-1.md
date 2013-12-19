## Installing in FuelPHP 1.x (with Composer)

Using Sentry with FuelPHP is easy.

We begin by creating the `composer.json` file at `fuel/app/` with the following:

	{
		"require": {
			"cartalyst/sentry": "2.0.*",
			"illuminate/database": "4.0.*",
			"ircmaxell/password-compat": "1.0.*"
		},
		"minimum-stability": "dev"
	}

Navigate to your `app` folder in Terminal and run `composer update`.

You must put the following in `app/bootstrap.php` below `Autoloader::register()`:

	// Enable composer based autoloading
	require APPPATH.'vendor/autoload.php';

Great! You now have composer working with FuelPHP.

Just one more step is involved now, right at the bottom of that same file, `app/bootstrap.php`, put the following:

	class_alias('Cartalyst\Sentry\Facades\FuelPHP\Sentry', 'Sentry');

This will mean you can use the FuelPHP Sentry facade as the class `Sentry`. Vòila! Sentry automatically works with your current database configuration, there is no further setup required.

> **Note**: Sentry will always run off the default database connection, so ensure this is working. We may look at adding support for alternate connections in the future however it is not implemented at this stage. Pull requests are welcome.
