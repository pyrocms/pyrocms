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
use Cartalyst\Sentry\Sessions\IlluminateSession;
use PHPUnit_Framework_TestCase;

class IlluminateSessionTest extends PHPUnit_Framework_TestCase {

	protected $store;

	protected $session;

	/**
	 * Setup resources and dependencies.
	 *
	 * @return void
	 */
	public function setUp()
	{
		$this->store = m::mock('Illuminate\Session\Store');
		$this->session = new IlluminateSession($this->store, 'session_name_here');
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
		$this->session = new IlluminateSession($this->store, 'foo');
		$this->assertEquals('foo', $this->session->getKey());
	}

	public function testPut()
	{
		$this->store->shouldReceive('put')->with('session_name_here', 'bar')->once();

		$this->session->put('bar');
	}

	public function testGet()
	{
		$this->store->shouldReceive('get')->with('session_name_here')->once()->andReturn('bar');

		// Test with default "null" param as well
		$this->assertEquals('bar', $this->session->get());
	}

	public function testForget()
	{
		$this->store->shouldReceive('forget')->with('session_name_here')->once();

		$this->session->forget();
	}

}
