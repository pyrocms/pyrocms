<?php
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Cache_Test extends PHPUnit_Framework_TestCase
{
    protected $cache;
    protected $user_m;

    public function setUp()
    {
        $this->cache = new Quick\Cache(/* array('driver' => 'redis') */);
        $this->user_m = new Quick\Cache\Mock\User;

        $this->cache->strict = true;
    }

    public function test_config_instance()
    {
        $this->assertObjectHasAttribute('_config', $this->cache->config_instance());
    }

    public function test_connect()
    {
        $this->assertNull($this->cache->connect());
    }

    public function test_set(/* $key, $value */)
    {
        $this->assertTrue($this->cache->set('bob', 'builder'));
    }

    public function test_get(/* $key */)
    {
        $this->assertEquals($this->cache->get('bob'), 'builder');
    }

    public function test_forget(/* $key */)
    {
        $this->assertTrue($this->cache->forget('bob'));
    }

    public function test_method_string(/* $class, $method, $args = array(), $ttl = null */)
    {
        $this->assertEquals(
            $this->cache->method('Quick\Cache\Mock\User', 'get_by_email', array('billy@thekid.com'), 20),
            array('first' => 'Billy', 'last' => 'the Kid'));
    }

    public function test_method_object(/* $class, $method, $args = array(), $ttl = null */)
    {
        $this->assertEquals(
            $this->cache->method($this->user_m, 'get_by_email', array('billy@thekid.com'), 20),
            array('first' => 'Billy', 'last' => 'the Kid'));
    }

    public function test_method_no_args(/* $class, $method, $args = array(), $ttl = null */)
    {
        $this->assertEquals(
            $this->cache->method($this->user_m, 'get'),
            'jimbobjones');
    }

    public function test_clear_method(/* $class, $method */)
    {
        $this->assertTrue($this->cache->clear('Quick\Cache\Mock\User', 'get_by_email'));
    }

    public function test_clear_all(/* $class */)
    {
        $this->assertTrue($this->cache->clear('Quick\Cache\Mock\User'));
    }

    public function test_flush()
    {
        $this->assertTrue($this->cache->flush());
    }
}
