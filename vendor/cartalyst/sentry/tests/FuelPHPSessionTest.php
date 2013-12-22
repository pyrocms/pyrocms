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
use Cartalyst\Sentry\Sessions\FuelPHPSession;
use PHPUnit_Framework_TestCase;

class FuelPHPSessionTest extends PHPUnit_Framework_TestCase {

	/**
	 * Setup resources and dependencies.
	 *
	 * @return void
	 */
	public static function setUpBeforeClass()
	{
		require_once __DIR__.'/stubs/fuelphp/Fuel/Core/Session_Driver.php';
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

	public function testOverridingKey()
	{
		$session = new FuelPHPSession($store = m::mock('Fuel\Core\Session_Driver'), 'foo');
		$this->assertEquals('foo', $session->getKey());
	}

	public function testPut()
	{
		$session = new FuelPHPSession($store = m::mock('Fuel\Core\Session_Driver'), 'foo');

		$store->shouldReceive('set')->with('foo', 'bar')->once();

		$session->put('bar');
	}

	public function testGet()
	{
		$session = new FuelPHPSession($store = m::mock('Fuel\Core\Session_Driver'), 'foo');

		$store->shouldReceive('get')->with('foo')->once()->andReturn('bar');

		// Test with default "null" param as well
		$this->assertEquals('bar', $session->get());
	}

	public function testForget()
	{
		$session = new FuelPHPSession($store = m::mock('Fuel\Core\Session_Driver'), 'foo');

		$store->shouldReceive('delete')->with('foo')->once();

		$session->forget();
	}

}
