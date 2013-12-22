<?php namespace Cartalyst\Sentry\Facades\FuelPHP;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Sentry\Cookies\FuelPHPCookie;
use Cartalyst\Sentry\Facades\ConnectionResolver;
use Cartalyst\Sentry\Facades\Facade;
use Cartalyst\Sentry\Groups\Eloquent\Provider as GroupProvider;
use Cartalyst\Sentry\Hashing\NativeHasher;
use Cartalyst\Sentry\Sessions\FuelPHPSession;
use Cartalyst\Sentry\Sentry as BaseSentry;
use Cartalyst\Sentry\Throttling\Eloquent\Provider as ThrottleProvider;
use Cartalyst\Sentry\Users\Eloquent\Provider as UserProvider;
use Database_Connection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Input;
use PDO;
use Session;

class Sentry extends Facade {

	/**
	 * Creates a new instance of Sentry.
	 *
	 * @return \Cartalyst\Sentry\Sentry
	 * @throws \RuntimeException
	 */
	public static function createSentry()
	{
		// If Eloquent doesn't exist, then we must assume they are using their own providers.
		if (class_exists('Illuminate\Database\Eloquent\Model'))
		{
			// Retrieve what we need for our resolver
			$database    = Database_Connection::instance();
			$pdo         = $database->connection();
			$driverName  = $database->driver_name();
			$tablePrefix = $database->table_prefix();

			// Make sure we're getting a PDO connection
			if ( ! $pdo instanceof PDO)
			{
				throw new \RuntimeException("Sentry will only work with PDO database connections.");
			}

			Eloquent::setConnectionResolver(new ConnectionResolver($pdo, $driverName, $tablePrefix));
		}

		return new BaseSentry(
			$userProvider = new UserProvider(new NativeHasher),
			new GroupProvider,
			new ThrottleProvider($userProvider),
			new FuelPHPSession(Session::instance()),
			new FuelPHPCookie,
			Input::real_ip()
		);
	}

}
