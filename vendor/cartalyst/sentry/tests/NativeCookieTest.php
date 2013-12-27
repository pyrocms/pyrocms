<?php namespace Cartalyst\Sentry\Tests;
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

use Cartalyst\Sentry\Cookies\NativeCookie;
use Mockery as m;
use PHPUnit_Framework_TestCase;

class NativeCookieTest extends PHPUnit_Framework_TestCase {

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	public function testOverridingKey()
	{
		$cookie = new NativeCookie(array(), 'custom_key');
		$this->assertEquals('custom_key', $cookie->getKey());
	}

	public function testPut()
	{
		$cookie = m::mock('Cartalyst\Sentry\Cookies\NativeCookie[minutesToLifetime,setCookie]');

		$cookie->shouldReceive('minutesToLifetime')->with(123)->andReturn(12345);

		$cookie->shouldReceive('setCookie')->with('bar', 12345)->once();

		$cookie->put('bar', 123);
	}

	public function testForever()
	{
		$cookie = m::mock('Cartalyst\Sentry\Cookies\NativeCookie[put]');

		$me = $this;
		$cookie->shouldReceive('put')->with('bar', m::on(function($value) use ($me)
		{
			// Value must be at least 5 years in advance
			// to satisfy being "forever". We're using
			// PHPUnit assertions here so that an Exception
			// is thrown which is more meaningful to the user
			$me->assertGreaterThanOrEqual(2628000, $value, 'The expiry date must be at least 5 years (2628000 seconds) in advance.');

			// We never get here if the above assertion
			// was false, save to proceed.
			return true;

		}))->once();

		$cookie->forever('bar');
	}

	public function testGetWhenCookieDoesNotExist()
	{
		$cookie = m::mock('Cartalyst\Sentry\Cookies\NativeCookie[getCookie]');

		$cookie->shouldReceive('getCookie')->once();

		$this->assertNull($cookie->get());
	}

	public function testGet()
	{
		$cookie = m::mock('Cartalyst\Sentry\Cookies\NativeCookie[getCookie]');

		$cookie->shouldReceive('getCookie')->once()->andReturn('bar');

		$this->assertEquals('bar', $cookie->get());
	}

	public function testForget()
	{
		$cookie = m::mock('Cartalyst\Sentry\Cookies\NativeCookie[put]');

		$me = $this;
		$cookie->shouldReceive('put')->with(null, m::on(function($value) use ($me)
		{
			// Value must be at least 5 years in advance
			// to satisfy being "forever". We're using
			// PHPUnit assertions here so that an Exception
			// is thrown which is more meaningful to the user
			$me->assertLessThanOrEqual(-2628000, $value, 'The expiry date must be at least 5 years (2628000 seconds) in previous, so as to remove "forever" cookies.');

			// We never get here if the above assertion
			// was false, save to proceed.
			return true;

		}))->once();

		$cookie->forget();
	}

}
