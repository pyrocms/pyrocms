<?php namespace Cartalyst\Sentry\Sessions;
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

class NativeSession implements SessionInterface {

	/**
	 * The key used in the Session.
	 *
	 * @var string
	 */
	protected $key = 'cartalyst_sentry';

	/**
	 * Creates a new native session driver for Sentry.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __construct($key = null)
	{
		if (isset($key))
		{
			$this->key = $key;
		}

		$this->startSession();
	}

	/**
	 * Called upon destruction of the native session handler.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		$this->writeSession();
	}

	/**
	 * Returns the session key.
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Put a value in the Sentry session.
	 *
	 * @param  mixed  $value
	 * @return void
	 */
	public function put($value)
	{
		$this->setSession($value);
	}

	/**
	 * Get the Sentry session value.
	 *
	 * @return mixed
	 */
	public function get()
	{
		return $this->getSession();
	}

	/**
	 * Remove the Sentry session.
	 *
	 * @return void
	 */
	public function forget()
	{
		$this->forgetSession();
	}

	/**
	 * Starts the session if it does not exist.
	 *
	 * @return void
	 */
	public function startSession()
	{
		// Let's start the session
		if (session_id() == '')
		{
			session_start();
		}
	}

	/**
	 * Writes the session.
	 *
	 * @return void
	 */
	public function writeSession()
	{
		session_write_close();
	}

	/**
	 * Interacts with the $_SESSION global to set a property on it.
	 * The property is serialized initially.
	 *
	 * @param  mixed  $value
	 * @return void
	 */
	public function setSession($value)
	{
		$_SESSION[$this->getKey()] = serialize($value);
	}

	/**
	 * Unserializes a value from the session and returns it.
	 *
	 * @return mixed.
	 */
	public function getSession()
	{
		if (isset($_SESSION[$this->getKey()]))
		{
			return unserialize($_SESSION[$this->getKey()]);
		}
	}

	/**
	 * Forgets the Sentry session from the global $_SESSION.
	 *
	 * @return void
	 */
	public function forgetSession()
	{
		if (isset($_SESSION[$this->getKey()]))
		{
			unset($_SESSION[$this->getKey()]);
		}
	}

}
