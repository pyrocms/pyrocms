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

interface SessionInterface {

	/**
	 * Returns the session key.
	 *
	 * @return string
	 */
	public function getKey();

	/**
	 * Put a value in the Sentry session.
	 *
	 * @param  mixed   $value
	 * @return void
	 */
	public function put($value);

	/**
	 * Get the Sentry session value.
	 *
	 * @return mixed
	 */
	public function get();

	/**
	 * Remove the Sentry session.
	 *
	 * @return void
	 */
	public function forget();

}
