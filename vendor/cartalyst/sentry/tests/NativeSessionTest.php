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

use Cartalyst\Sentry\Sessions\NativeSession;
use Mockery as m;
use PHPUnit_Framework_TestCase;
use stdClass;

class NativeSessionTest extends PHPUnit_Framework_TestCase {

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	public function testFoo()
	{
		$session = m::mock('Cartalyst\Sentry\Sessions\NativeSession[startSession,writeSession]');
		$session->shouldReceive('writeSession');
	}

	public function testOverridingKey()
	{
		$session = m::mock('Cartalyst\Sentry\Sessions\NativeSession[startSession,writeSession]');
		$session->shouldReceive('startSession')->once();
		$session->shouldReceive('writeSession');

		$session->__construct('foo');

		$this->assertEquals('foo', $session->getKey());
	}

	public function testPutting()
	{
		$session = m::mock('Cartalyst\Sentry\Sessions\NativeSession[startSession,writeSession]');
		$session->shouldReceive('startSession')->once();
		$session->shouldReceive('writeSession');
		$session->__construct('foo');

		$class = new stdClass;
		$class->foo = 'bar';

		$session->put($class);
		$this->assertEquals(serialize($class), $_SESSION['foo']);
	}

	public function testGettingWhenNothingIsInSessionReturnsNull()
	{
		$session = m::mock('Cartalyst\Sentry\Sessions\NativeSession[getSession]');

		$session->shouldReceive('getSession')->once();
		$this->assertNull($session->get());
	}

	public function testGetting()
	{
		$session = m::mock('Cartalyst\Sentry\Sessions\NativeSession[startSession,writeSession]');
		$session->shouldReceive('startSession')->once();
		$session->shouldReceive('writeSession');
		$session->__construct('foo');

		$class = new stdClass;
		$class->foo = 'bar';
		$_SESSION['foo'] = serialize($class);

		$this->assertEquals($class, $session->get());
	}

	public function testForgetting()
	{
		$_SESSION['foo'] = 'bar';

		$session = m::mock('Cartalyst\Sentry\Sessions\NativeSession[startSession,writeSession]');
		$session->shouldReceive('startSession')->once();
		$session->shouldReceive('writeSession');
		$session->__construct('foo');

		$this->assertEquals('bar', $_SESSION['foo']);
		$session->forget();
		$this->assertFalse(isset($_SESSION['foo']));
	}

}
