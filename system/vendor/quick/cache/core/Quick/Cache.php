<?php namespace Quick;
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

use Quick\Cache\Config;

class Cache
{
    protected $driver;
    protected $config;
    public    $strict; // used for testing only

    public function __construct($config = array())
    {
        // instantiates the object and sets the defaults from the config files
        $this->config = new Config;

        // add config items / replace defaults with passed values
        $this->config->set_many($config);

        $driver_class = 'Quick\Cache\Driver\\' . ucfirst($this->config->get('driver'));

        $this->driver = new $driver_class($this->config);
    }

    /**
     * (Re?)connects to the database. Useful if connection parameters
     * change or are set after the driver class is instantiated
     *
     * @return  void
     */
    public function connect()
    {
    	if (method_exists($this->driver, 'connect')) {
    		$this->driver->connect();
    	}
    }

    /**
     * Returns this instance of the config library so the values
     * can be modified for this instance of the cache
     *
     * $cache = new Quick\Cache;
     * $config = $cache->config_instance();
     *
     * $config->set('connection', array('host'...));
     *
     * @return object
     */
    public function config_instance()
    {
        return $this->config;
    }

    /**
     * Cache a key/value item
     *
     * @param  string       $key
     * @param  string|array $value The value to cache
     * @param  integer      $ttl   Lifetime in seconds
     * @return bool
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->driver->set($key, serialize($value), $ttl);
    }

    /**
     * Get a value by key
     *
     * @param string $key
     * @return
     */
    public function get($key)
    {
        return unserialize($this->driver->get($key));
    }

    /**
     * Drop an item by key
     *
     * @param  string $key
     * @return bool
     */
    public function forget($key)
    {
        return $this->driver->forget($key);
    }

    /**
     * Call a method, cache the result, and return the data
     *
     * @param string|object $class  Either a namespace class or an object
     * @param string        $method The method to call
     * @param array         $args   The arguments to pass to the method
     * @param integer       $ttl    The time to live (seconds) will only be set on the first call for a method
     * @return
     */
    public function method($class, $method, $args = array(), $ttl = null)
    {
        $class_name = is_string($class) ? $class : get_class($class);

        $identifier = array(
            'class' => $class_name,
            'method' => $method,
            'args' => $args
            );

        // do we have the data cached already?
        $result = $this->driver->get_method($identifier);

        if ($result['status']) {
            // yep, we had it
            return unserialize($result['data']);
        }

        // no data found, run the method
        if (is_string($class)) {
            $class = new $class;
        }

        $data = call_user_func_array(array($class, $method), $args);

        $data_string = serialize($data);

        // now cache the newfound data and return it
        $this->driver->set_method($identifier, $data_string, $ttl);

        // if we are testing we drop out of "return the correct data at any cost mode" 
        // and instead make sure that our write was successful
        if ($this->strict) {
            $result = $this->driver->get_method($identifier);
            return unserialize($result['data']);
        }

        return $data;
    }

    /**
     * Clear all cached items for a class + method or class
     *
     * @param  string|object $class  The namespace class or object used to identify the cached item
     * @param  string        $method The method used to identify the cached item
     * @return bool
     */
    public function clear($class, $method = null)
    {
        return $this->driver->clear($class, $method);
    }

    /**
     * Clear all cached items for this driver. Example use would be when you move
     * a site to production. This can be intensive so don't use it regularly
     *
     * @return bool
     */
    public function flush()
    {
        return $this->driver->flush();
    }
}
