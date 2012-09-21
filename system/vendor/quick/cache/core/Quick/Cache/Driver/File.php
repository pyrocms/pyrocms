<?php namespace Quick\Cache\Driver;
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class File
{
    protected $config;

    public function __construct($config)
    {
        // the config object instantiated by the Cache library
        $this->config = $config;

        $this->config->load('file');
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
        $filename = $this->_hash(array($key));

        return (bool) $this->_write($filename, $value, null, $ttl);
    }

    /**
     * Get your cached value
     *
     * @param  string $key
     * @return string A serialized string to be unserialized by the cache lib
     */
    public function get($key)
    {
        $filename = $this->_hash(array($key));

        return $this->_read($filename);
    }

    /**
     * Delete a value by its key
     *
     * @param  string $key Take a guess.
     * @return bool
     */
    public function forget($key)
    {
        $filename = $this->_hash(array($key));

        return (bool) $this->_delete($filename);
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

        $directory = $this->_prep_path($class, $method);

        // create a unique field name
        $filename = $this->_hash($args);

        // does a cache exist for this method? If so we leave the ttl
        if ($this->exists($filename, $directory)) {
            $ttl = null;
        }

        return $this->_write($filename, $data, $directory, $ttl);
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

        $directory = $this->_prep_path($class, $method);

        // create a unique field name
        $filename = $this->_hash($args);

        $result = $this->_read($filename, $directory);

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
        $cache_path = $this->config->get('cache_path');

        // we know which one we're clearing
        if ($method) {
            $directory = $this->_prep_path($class, $method);

            return (bool) $this->_delete_dir($cache_path.$directory);
        } else {
            // we're clearing everything for this class
            $directory = $this->_prep_path($class);

            return (bool) $this->_delete_dir($cache_path.$directory);
        }
    }

    /**
     * Clear all cached items for this driver
     *
     * @return bool
     */
    public function flush()
    {
        $cache_path = $this->config->get('cache_path');

        // this may take a while, but they shouldn't be flushing in production
        return (bool) $this->_delete_dir($cache_path);
    }

    /**
     * Does a cache object exist?
     *
     * @param  string      $filename The cache file filename
     * @return string|null
     */
    public function exists($filename, $directory = null)
    {
        $cache_path = $this->config->get('cache_path');

        if (is_null($directory)) {
            $path = $cache_path.$this->config->get('object_dir').$filename.'.cache';
        } else {
            $path = $cache_path.$directory.$filename.'.cache';
        }

        return (bool) file_exists($path);
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

    /**
     * Prep directory from class + method
     *
     * @param  string $class
     * @param  string $method
     * @return string The underscored path
     */
    private function _prep_path($class, $method = '')
    {
        return rtrim(str_replace('\\', '_', $class).'/'.str_replace('\\', '_', $method), '/').'/';
    }

    /**
     * Write the cache file
     *
     * @param  string $filename  The cache file filename
     * @param  string $data      A serialized string of data
     * @param  string $directory The directory path
     * @param  int    $ttl       The time to live of this cache object
     * @return bool
     */
    private function _write($filename, $data, $directory = null, $ttl = null)
    {
        $cache_path = $this->config->get('cache_path');

        // did they provide a subdirectory to namespace the cache?
        if ($directory) {
            $path = $cache_path.$directory.'/';
        } else {
            // they didn't provide a directory so we set the directory used for simple object caching
            $path = $cache_path.$this->config->get('object_dir');
        }

        if ( ! is_dir($path) and ! @mkdir($path, $this->config->get('dir_chmod'), true)) {
            throw new \QuickCacheException($path.' is not writable and cannot be created.');
        }

        // if we can't open perhaps it is being written by another, just return
        if ( ! $fh = @fopen($path.$filename.'.cache', 'wb')) return;

        // if no ttl is provided use the default
        if (is_null($ttl)) $ttl = $this->config->get('expiration');

        // using the current time and the ttl set the expiration date
        $expires = time() + (int) $ttl;

        flock($fh, LOCK_EX);
        fwrite($fh, $expires.$data);
        flock($fh, LOCK_UN);
        fclose($fh);

        return $data;
    }

    /**
     * Write the cache file
     *
     * @param  string      $filename The cache file filename
     * @return string|null
     */
    private function _read($filename, $directory = null)
    {
        $cache_path = $this->config->get('cache_path');

        if (is_null($directory)) {
            $path = $cache_path.$this->config->get('object_dir').$filename.'.cache';
        } else {
            $path = $cache_path.$directory.$filename.'.cache';
        }

        // nope. not here.
        if ( ! file_exists($path)) return null;

        $fh = @fopen($path, 'rb');
        flock($fh, LOCK_SH);

        // read out the expiration date
        $use_before_date = fread($fh, 10);

        // still a valid cache object or is it stale?
        if ($use_before_date < time()) return null;

        $data = fread($fh, filesize($path));

        flock($fh, LOCK_UN);
        fclose($fh);

        return $data;
    }

    /**
     * Delete the cache file
     *
     * @param  string $filename The cache file filename
     * @return bool
     */
    private function _delete($filename, $directory = null)
    {
        $cache_path = $this->config->get('cache_path');

        if (is_null($directory)) {
            $path = $cache_path.$this->config->get('object_dir').$filename.'.cache';
        } else {
            $path = $cache_path.$directory.$filename.'.cache';
        }

        // nope. not here.
        if ( ! file_exists($path)) return true;
        return (bool) unlink($path);
    }

    /**
     * Delete the cache directory
     *
     * @param  string $directory The cache directory (class/ or class/method/)
     * @return bool
     */
    private function _delete_dir($path = '')
    {
        $cache_path = $this->config->get('cache_path');

        // make sure nobody can delete above the cache root
        if (strpos($path, $cache_path) === false) return;

        if (is_file($path)) {
            return (bool) unlink($path);
        } elseif (is_dir($path)) {
            $scan = glob(rtrim($path,'/').'/*');

            foreach ($scan as $item) {
                $this->_delete_dir($item);
            }

            return rmdir($path);
        }
    }
}
