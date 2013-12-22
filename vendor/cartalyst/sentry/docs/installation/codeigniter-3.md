## Installing in CodeIgniter 3.0-dev

Installation in CodeIgniter is fairly straightforward.

Obviously, using Sentry in CodeIgniter brings the minimum PHP version to 5.3.0. To install, add the following to your `composer.json` file:

	{
		"require": {
			"cartalyst/sentry": "2.0.*",
			"illuminate/database": "4.0.*",
			"ircmaxell/password-compat": "1.0.*"
		},
		"minimum-stability": "dev"
	}

> **Note**: You may need to merge the `require` attribute with what you already
have in `composer.json`

Now, simply run `composer update`. Then, visit `application/config/config.php` and right down the bottom, add the following:

	class_alias('Cartalyst\Sentry\Facades\CI\Sentry', 'Sentry');

This will allow you to use Sentry as normal in CodeIgniter and sets up dependencies required for Sentry to run smoothly within the CI environment.

> **Note**: You must be running your database using the `PDO` driver (though this would be recommended anyway). Configuration for a MySQL database running PDO could be as follows (in `application/config/database.php`):

	// Ensure the active group is the default config.
	// Sentry always runs off your application's default
	// database connection.
	$active_group = 'default';

	// Setup the default config
	$db['default'] = array(

		// PDO requires the host, dbname and charset are all specified in the "dsn",
		// so we'll go ahead and do these now.
		'dsn'	   => 'mysql:host=localhost;dbname=cartalyst_sentry;charset=utf8;',
		'hostname' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'database' => '',
		'dbdriver' => 'pdo',
		'dbprefix' => '',
		'pconnect' => TRUE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'autoinit' => TRUE,
		'encrypt'  => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array()
	);
