<?php namespace Quick\Cache\Driver;
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Redis
{
    protected $config;
    protected $redis;

    public function __construct($config)
    {
        // the config object instantiated by the Cache library
        $this->config = $config;
        $this->config->load('redis');

        $this->connect();
    }

    /**
     * Start the redis connection
     *
     * @return void
     */
    public function connect()
    {
        $connection = $this->config->get('redis_connection');
        $params = array('prefix' => $this->config->get('redis_prefix').':');

        // connect to redis using the connection details in the config file
        $this->redis = new \Predis\Client(
            $connection,
            $params
            );
    }

    /**
     * Set a simple key:value
     *
     * @param string $key   The key to retrieve the value with later
     * @param string $value A serialized string to store
     * @param int    $ttl   Seconds to live before expiration
     */
    public function set($key, $value, $ttl)
    {
        // if no ttl is provided use the default
        if (is_null($ttl)) $ttl = $this->config->get('expiration');
        return (bool) $this->redis->pipeline(function($pipe) use ($key, $value, $ttl) {
            $pipe->set($key, $value);
            $pipe->expire($key, $ttl);
        });
    }

    /**
     * Get your cached value
     *
     * @param  string $key
     * @return string A serialized string to be unserialized by the cache lib
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * Delete a value by its key
     *
     * @param  string $key Take a guess Watson.
     * @return bool
     */
    public function forget($key)
    {
        return (bool) $this->redis->del($key);
    }

    /**
     * Cache data for a class/method
     *
     * @param array   $identifier class|method|args
     * @param         $data       The data to store
     * @param integer $ttl        Seconds to expiration
     * @return $data
     */
    public function set_method($identifier, $data, $ttl)
    {
        extract($identifier);

        $key = $class.':'.$method;

        // create a unique field name
        $field = $this->_hash($args);

        // does a cache exist for this method?
        $exists = $this->redis->exists($key);

        // if no ttl is provided use the default
        if (is_null($ttl)) $ttl = $this->config->get('expiration');

        $this->redis->pipeline(function($pipe) use ($class, $method, $key, $field, $data, $exists, $ttl) {
            $pipe->hset($key, $field, $data);

            // we only set the ttl if this is the first argument set cached for this method
            if (! $exists) {
                $pipe->expire($key, $ttl);

                $pipe->hset('method_list:'.$class, $method, 'is_cached');
            }
        });

        return $data;
    }

    /**
     * Get cached data for a class/method
     *
     * @param array $identifier class|method|args
     * @return $data
     */
    public function get_method($identifier)
    {
        extract($identifier);

        $key = $class.':'.$method;

        // create a unique field name
        $field = $this->_hash($args);

        $result = $this->redis->hget($key, $field);

        return is_null($result) ?
            array('status' => false, 'data' => null) :
            array('status' => true, 'data' => $result);
    }

    /**
     * Clear all cached items for a class + method or class
     *
     * @param  string|object $class  The namespace class or object used to identify the cached item
     * @param  string        $method The method used to identify the cached item
     * @return bool
     */
    public function clear($class, $method)
    {
        // we know which one we're clearing
        if ($method) {
            $this->redis->del($class.':'.$method);

            return true;
        } else {
            // they want to clear the whole class so we have to get a method list
            $methods = $this->redis->hkeys('method_list:'.$class);

            // delete the method from the list of cached methods and clear the cache items
            $this->redis->pipeline(function($pipe) use ($class, $methods) {

                $pipe->del('method_list:'.$class);

                foreach ($methods as $method) {
                    $pipe->del($class.':'.$method);
                }
            });

            return true;
        }
    }

    /**
     * Clear all cached items for this driver
     *
     * @return bool
     */
    public function flush()
    {
        // this may take a while, but they shouldn't be flushing in production
        $cache_keys = $this->redis->keys(/* prefixed with cache: */ '*');

        foreach ($cache_keys as $key) {
            $this->redis->del($key);
        }

        unset($cache_keys);

        return true;
    }

    /**
     * This is only to be used with phpUnit.
     * It will FLUSH THE DATABASE!
     */
    public function test_shutdown()
    {
        return $this->redis->flushdb();
    }

    /**
     * Create a unique hash of the method arguments
     *
     * @param  array  $args
     * @return string The unique hash
     */
    private function _hash($args)
    {
        return md5(serialize($args));
    }
}
