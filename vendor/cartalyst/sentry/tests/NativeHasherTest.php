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
use Cartalyst\Sentry\Hashing\NativeHasher as Hasher;
use PHPUnit_Framework_TestCase;

class NativeHasherTest extends PHPUnit_Framework_TestCase {

	/**
	 * Setup resources and dependencies.
	 *
	 * @return void
	 */
	public function setUp()
	{

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

	public function testHashingIsAlwaysCorrect()
	{
		$hasher         = new Hasher;
		$password       = 'f00b@rB@zb@T';
		$hashedPassword = $hasher->hash($password);

		$this->assertTrue($hasher->checkHash($password, $hashedPassword));
		$this->assertFalse($hasher->checkHash($password.'$', $hashedPassword));
	}

	/**
	 * Regression test for https://github.com/cartalyst/sentry/issues/98
	 *
	 * @runInSeparateProcess
	 */
	public function testExceptionIsThrownIfHasherFails()
	{
		// Override the password hash function if it doesn't exist
		if (version_compare(PHP_VERSION, '5.5.0') < 0)
		{
			$this->setExpectedException('RuntimeException');

			function password_hash()
			{
				return false;
			}

			$hasher = new Hasher;

			$hasher->hash('foo');
		}
	}

}
