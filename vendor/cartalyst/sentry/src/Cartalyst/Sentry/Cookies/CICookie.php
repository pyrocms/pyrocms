<?php namespace Cartalyst\Sentry\Cookies;
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

use CI_Input as Input;

class CICookie implements CookieInterface {

	/**
	 * The key used in the Cookie.
	 *
	 * @var string
	 */
	protected $key = 'cartalyst_sentry';

	/**
	 * The CodeIgniter input object.
	 *
	 * @var \CI_Input
	 */
	protected $input;

	/**
	 * Default settings
	 *
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Create a new CodeIgniter cookie driver for Sentry.
	 *
	 * @param  \CI_Input  $input
	 * @param  array     $config
	 * @param  string    $key
	 */
	public function __construct(Input $input, array $config = array(), $key = null)
	{
		$this->input = $input;

		// Defining default settings
		$sentryDefaults = array(
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
			'secure' => false
		);

		// Merge settings
		$this->defaults = array_merge($sentryDefaults, $config);

		if (isset($key))
		{
			$this->key = $key;
		}
	}

	/**
	 * Returns the cookie key.
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Put a value in the Sentry cookie.
	 *
	 * @param  mixed  $value
	 * @param  int    $minutes
	 * @return void
	 */
	public function put($value, $minutes)
	{
		extract($this->defaults);

		$this->input->set_cookie(array(
			'name'   => $this->getKey(),
			'value'  => serialize($value),
			'expire' => $minutes,
			'domain' => $domain,
			'path'   => $path,
			'prefix' => $prefix,
			'secure' => $secure
		));
	}

	/**
	 * Put a value in the Sentry cookie forever.
	 *
	 * @param  mixed  $value
	 * @return void
	 */
	public function forever($value)
	{
		// Forever can set a cookie for 5 years.
		// This should suffice "forever".
		$this->put($value, 2628000);
	}

	/**
	 * Get the Sentry cookie value.
	 *
	 * @return mixed
	 */
	public function get()
	{
		return unserialize($this->input->cookie($this->getKey()));
	}

	/**
	 * Remove the Sentry cookie.
	 *
	 * @return void
	 */
	public function forget()
	{
		$this->input->set_cookie(array(
			'name'   => $this->getKey(),
			'value'  => '',
			'expiry' => '',
		));
	}

}
