<?php namespace Cartalyst\Sentry\Facades\CI;
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

use Cartalyst\Sentry\Cookies\CICookie;
use Cartalyst\Sentry\Facades\ConnectionResolver;
use Cartalyst\Sentry\Facades\Facade;
use Cartalyst\Sentry\Groups\Eloquent\Provider as GroupProvider;
use Cartalyst\Sentry\Hashing\NativeHasher;
use Cartalyst\Sentry\Sessions\CISession;
use Cartalyst\Sentry\Sentry as BaseSentry;
use Cartalyst\Sentry\Throttling\Eloquent\Provider as ThrottleProvider;
use Cartalyst\Sentry\Users\Eloquent\Provider as UserProvider;
use Illuminate\Database\Eloquent\Model as Eloquent;
use PDO;

class Sentry {

	/**
	 * Array of PDO options suitable for making the
	 * CodeIgniter connection play nicely with
	 * illuminate/database.
	 *
	 * @var array
	 */
	protected static $pdoOptions = array(
		PDO::ATTR_CASE              => PDO::CASE_LOWER,
		PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_ORACLE_NULLS      => PDO::NULL_NATURAL,
		PDO::ATTR_STRINGIFY_FETCHES => false,
		PDO::ATTR_EMULATE_PREPARES  => false,
	);

	/**
	 * Creates a new instance of Sentry.
	 *
	 * @return \Cartalyst\Sentry\Sentry
	 * @throws \RuntimeException
	 */
	public static function createSentry()
	{
		// Get some resources
		$ci =& get_instance();
		$ci->load->driver('session');

		// If Eloquent doesn't exist, then we must assume they are using their own providers.
		if (class_exists('Illuminate\Database\Eloquent\Model'))
		{
			$ci->load->database();

			// Let's connect and get the PDO instance
			$pdo = $ci->db->db_pconnect();

			// Validate PDO
			if ( ! $pdo instanceof PDO)
			{
				throw new \RuntimeException("Sentry will only work with PDO database connections.");
			}

			// Setup PDO
			foreach (static::$pdoOptions as $key => $value)
			{
				$pdo->setAttribute($key, $value);
			}

			$driverName  = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
			$tablePrefix = substr($ci->db->dbprefix('.'), 0, -1);

			Eloquent::setConnectionResolver(new ConnectionResolver($pdo, $driverName, $tablePrefix));
		}

		return new BaseSentry(
			$userProvider = new UserProvider(new NativeHasher),
			new GroupProvider,
			new ThrottleProvider($userProvider),
			new CISession($ci->session),
			new CICookie($ci->input),
			$ci->input->ip_address()
		);
	}

}
