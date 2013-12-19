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

use Mockery as m;
use Cartalyst\Sentry\Cookies\IlluminateCookie;
use PHPUnit_Framework_TestCase;

class IlluminateCookieTest extends PHPUnit_Framework_TestCase {

	protected $jar;

	protected $cookie;

	/**
	 * Setup resources and dependencies.
	 *
	 * @return void
	 */
	public function setUp()
	{
		$this->jar = m::mock('Illuminate\Cookie\CookieJar');

		$this->cookie = new IlluminateCookie($this->jar, 'cookie_name_here');
	}

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	public function testPut()
	{
		$this->jar->shouldReceive('make')->with('cookie_name_here', 'bar', 123)->once();
		$this->cookie->put('bar', 123);
	}

	public function testForever()
	{
		$this->jar->shouldReceive('forever')->with('cookie_name_here', 'bar')->once();
		$this->cookie->forever('bar');
	}

	public function testGet()
	{
		$this->jar->shouldReceive('get')->with('cookie_name_here')->once()->andReturn('bar');

		// Ensure default param is "null"
		$this->assertEquals('bar', $this->cookie->get());
	}

	public function testForget()
	{
		$this->jar->shouldReceive('forget')->with('cookie_name_here')->once();
		$this->cookie->forget();
	}

}
