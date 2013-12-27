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
use Cartalyst\Sentry\Hashing\WhirlpoolHasher as Hasher;
use PHPUnit_Framework_TestCase;

class WhirlpoolHasherTest extends PHPUnit_Framework_TestCase {

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

    public function testSaltMatchesLength()
    {
        $hasher = new Hasher;
        $hasher->saltLength = 32;

        $this->assertEquals(32, strlen($hasher->createSalt()));
    }

    public function testHashingIsAlwaysCorrect()
    {
        $hasher         = new Hasher;
        $password       = 'f00b@rB@zb@T';
        $hashedPassword = $hasher->hash($password);

        $this->assertTrue($hasher->checkHash($password, $hashedPassword));
        $this->assertFalse($hasher->checkHash($password.'$', $hashedPassword));
    }

}
