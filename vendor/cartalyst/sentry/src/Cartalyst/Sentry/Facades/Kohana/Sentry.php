<?php namespace Cartalyst\Sentry\Facades\Kohana;
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

use Cartalyst\Sentry\Cookies\KohanaCookie;
use Cartalyst\Sentry\Facades\Facade;
use Cartalyst\Sentry\Groups\Kohana\Provider as GroupProvider;
use Cartalyst\Sentry\Sessions\KohanaSession;
use Cartalyst\Sentry\Sentry as BaseSentry;
use Cartalyst\Sentry\Throttling\Kohana\Provider as ThrottleProvider;
use Cartalyst\Sentry\Users\Kohana\Provider as UserProvider;

class Sentry extends Facade {

	/**
	 * Creates a new instance of Sentry.
	 *
	 * @return \Cartalyst\Sentry\Sentry
	 */
	public static function createSentry()
	{
		$config = \Kohana::$config->load('sentry')->as_array();

		//If the user hasn't defined a config file offer defaults
		if ( count($config) == 0 )
		{
			$config = array(
				'session_driver' => 'native',
				'session_key' => 'cartalyst_sentry',
				'cookie_key' => 'cartalyst_sentry',
				'hasher' => 'Bcrypt'
			);
		}

		//Choose the hasher
		switch ( $config['hasher'] )
		{
			default:
			case 'Bcrypt':
				$hasher = new \Cartalyst\Sentry\Hashing\BcryptHasher;
				break;
			case 'Native':
				$hasher = new \Cartalyst\Sentry\Hashing\NativeHasher;
				break;
			case 'Sha256':
				$hasher = new \Cartalyst\Sentry\Hashing\Sha256Hasher;
				break;
		}

		return new BaseSentry(
			$userProvider = new UserProvider($hasher),
			new GroupProvider,
			new ThrottleProvider($userProvider),
			new KohanaSession(\Session::instance($config['session_driver']), $config['session_key']),
			new KohanaCookie($config['cookie_key']),
			\Request::$client_ip
		);
	}

}
