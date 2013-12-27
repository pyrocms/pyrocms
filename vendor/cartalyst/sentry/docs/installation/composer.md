## Installing & Configure through Composer

Open your `composer.json` file and add the following lines

	{
		"require": {
			"cartalyst/sentry": "2.0.*",
			"illuminate/database": "4.0.*",
			"ircmaxell/password-compat": "1.0.*"
		},
		"minimum-stability": "stable"
	}

Run a composer update from the command line

	composer update

If you haven't yet, make sure to require Composer's autoload file in your app root to autoload the installed packages.

	require 'vendor/autoload.php';

<!--
Example usage

	// Create an alias for our Facade
	class_alias('Cartalyst\Sentry\Facades\Native\Sentry', 'Sentry');

	// Setup our database
	$dsn      = 'mysql:dbname=my_database;host=localhost';
	$user     = 'root';
	$password = 'password';
	Sentry::setupDatabaseResolver(new PDO($dsn, $user, $password));

	// Done!

	// Create our first user!
	$user = Sentry::createUser(array(
		'email'    => 'testing@test.com',
		'password' => 'test',
		'permissions' => array(
			'test'  => 1,
			'other' => -1,
			'admin' => 1
		)
	));

	var_dump($user);

----------

### Installing Using Composer (Customization example)

	{
		"require": {
			"cartalyst/sentry": "2.0.*"
		},
    	"minimum-stability": "dev"
	}

You heard us say how Sentry is completely interface driven? We have a number of implementations already built in for using Sentry which require the following `composer.json` file:

	{
		"require": {
			"cartalyst/sentry": "2.0.*",
			"illuminate/database": "4.0.*",
			"ircmaxell/password-compat": "1.0.*"
		},
    	"minimum-stability": "dev"
	}

Now run `php composer.phar update` from the command line.

Initializing Sentry requires you pass a number of dependencies to it. These dependencies are the following:

1. A hasher (must implement `Cartalyst\Sentry\Hashing\HasherInterface`).
2. A user provider, taking a hasher (must implement `Cartalyst\Sentry\Users\ProviderInterface`).
3. A group provider (must implement `Cartalyst\Sentry\Groups\ProviderInterface`).
4. A throtte provider, taking a user provider (must implement `Cartalyst\Sentry\Throttling\ProviderInterface`).
5. A session manager (must implement `Cartalyst\Sentry\Sessions\SessionInterface`).
6. A cookie manager (must implement `Cartalyst\Sentry\Cookies\CookieInterface`).

Of course, we provide default implementations of all these for you. To setup our default implementations, the following should suffice:

	$hasher = new Cartalyst\Sentry\Hashing\NativeHasher; // There are other hashers available, take your pick

	$userProvider = new Cartalyst\Sentry\Users\Eloquent\Provider($hasher);

	$groupProvider = new Cartalyst\Sentry\Groups\Eloquent\Provider;

	$throttleProvider = new Cartalyst\Sentry\Throttling\Eloquent\Provider($userProvider);

	$session = new Cartalyst\Sentry\Sessions\NativeSession;

	// Note, all of the options below are, optional!
	$options = array(
		'name'     => null, // Default "cartalyst_sentry"
		'time'     => null, // Default 300 seconds from now
		'domain'   => null, // Default ""
		'path'     => null, // Default "/"
		'secure'   => null, // Default "false"
		'httpOnly' => null, // Default "false"
	);

	$cookie = new Cartalyst\Sentry\Cookies\NativeCookie($options);

	$sentry = new Sentry(
		$userProvider,
		$groupProvider,
		$throttleProvider
		$session,
		$cookie,
	);

----------

### Setup the database

Don't forget to setup database tables for Sentry. In the schema folder you will find a [mysql file](https://github.com/cartalyst/sentry/blob/master/schema/mysql.sql) that will setup the tables for you.
-->
