<?php
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Redis_Test extends PHPUnit_Framework_TestCase
{
    protected $redis;

    public function setUp()
    {
        $this->redis = new Quick\Cache\Driver\Redis(new Quick\Cache\Config);
    }

    public function test_set_and_get()
    {
        $this->redis->set('name', 'Jerel Unruh', 3600);

        $this->assertEquals($this->redis->get('name'), 'Jerel Unruh');
    }

    public function test_forget()
    {
        $this->assertEquals($this->redis->forget('name'), 1);
    }

    /**
     * @medium
     */
    public function test_check_ttl()
    {
        $this->redis->set('my_key', 'my lock', 1 /* one second */);
        $this->assertEquals($this->redis->get('my_key'), 'my lock');

        sleep(2);

        $this->assertNull($this->redis->get('my_key'));
    }

    public function test_set_method()
    {
        $this->assertEquals($this->redis->set_method(
            array('class' => 'Some\Class\Foo',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                ),
                'This is my data.',
                1500
            ), 'This is my data.');
    }

    public function test_get_method()
    {
        $this->assertEquals($this->redis->get_method(
            array('class' => 'Some\Class\Foo',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                )
            ), array('status' => true, 'data' => 'This is my data.'));
    }

    public function test_get_method_missing()
    {
        $this->assertEquals($this->redis->get_method(
            array('class' => 'Some\Class\Foo\Missing',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                )
            ), array('status' => false, 'data' => null));
    }

    public function test_clear_method()
    {
        $this->assertTrue($this->redis->clear('Some\Class\Foo', 'my_method'));

        // make sure it's gone
        $this->assertEquals($this->redis->get_method(
            array('class' => 'Some\Class\Foo',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                )
            ), array('status' => false, 'data' => null));
    }

    public function test_clear_class()
    {
        // set some data again
        $this->assertEquals($this->redis->set_method(
            array('class' => 'Some\Class\Foo',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                ),
                'This is my data.',
                1500
            ), 'This is my data.');

        // clear it
        $this->assertTrue($this->redis->clear('Some\Class\Foo', null));

        // make sure it's gone
        $this->assertEquals($this->redis->get_method(
            array('class' => 'Some\Class\Foo',
                'method' => 'my_method',
                'args' => array('first', 'second', 'third'),
                )
            ), array('status' => false, 'data' => null));
    }

    public function test_flush()
    {
        $this->assertTrue($this->redis->flush());
    }

    public function test_shutdown()
    {
        $this->assertTrue($this->redis->test_shutdown());
    }
}
