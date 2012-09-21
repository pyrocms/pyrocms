<?php
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Config_Test extends PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = new Quick\Cache\Config;
    }

    public function test_set_and_get(/* $key */)
    {
        $this->config->set('name', 'Bob');

        $this->assertEquals($this->config->get('name'), 'Bob');
    }

    public function test_set_many_and_get_all()
    {
        $this->config->set_many(array('my_config_item' => 'foo', 'my_second_config' => 'bar'));

        $this->assertArrayHasKey('my_config_item', $this->config->get_all());
    }

    public function test_load()
    {
        $this->assertTrue($this->config->load('file'));
    }

    public function test_load_non_existant_file()
    {
        $this->setExpectedException('QuickCacheException', 'The config file "I_dont_exist" does not exist');

        $this->config->load('I_dont_exist');
    }
}
