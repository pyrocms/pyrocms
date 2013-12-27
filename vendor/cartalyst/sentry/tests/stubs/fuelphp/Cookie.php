<?php
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

class Cookie {

	public static function set($key, $value, $minutes)
	{
		$_SERVER['__cookie.set'] = array($key, $value, $minutes);
	}

	public static function get($key)
	{
		if ($key == 'foo')
		{
			return serialize('baz');
		}
	}

	public static function delete($key)
	{
		if ($key == 'foo')
		{
			$_SERVER['__cookie.delete'] = true;
		}
	}

}
