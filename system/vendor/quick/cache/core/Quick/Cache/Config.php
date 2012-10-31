<?php namespace Quick\Cache;

/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

class Config
{
    private $_config = array();
    private $_config_path;
    private $_loaded = array();

    /**
     * Set some default config values
     *
     * @param array $config
     */
    public function __construct()
    {
        $this->_config_path = __DIR__.'/../../../config/';

        // set the default config items
        $this->_config = require $this->_config_path.'global.php';
    }

    /**
     * Load a config file
     *
     * @param string $file The config file without the extension
     * @return
     */
    public function load($file)
    {
        $file_name = $this->_config_path.$file.'.php';

        // load the file, but only once
        if (is_file($file_name) and ! array_key_exists($file, $this->_loaded)) {
            // the config file values are secondary to the config values that have already been set
            $this->_config = array_merge(require $file_name, $this->_config);

            $this->_loaded[$file] = true;

            return true;
        } elseif (! is_file($file_name)) {
            throw new \QuickCacheException('The config file "'.$file.'" does not exist');
        }
    }

    /**
     * Set a config value by key
     *
     * @param string $key Array element
     * @param  $value
     * @return
     */
    public function set($key, $value = null)
    {
        $this->_config[$key] = $value;
    }

    /**
     * Get a config value by key
     *
     * @param string $key Array element
     * @return
     */
    public function get($key = false)
    {
        return isset($this->_config[$key]) ? $this->_config[$key] : null;
    }

    /**
     * Get all config values
     *
     * @return array
     */
    public function get_all()
    {
        return $this->_config;
    }

    /**
     * Merge a config array into the default config
     *
     * @param array $config
     * @return
     */
    public function set_many($config)
    {
        $this->_config = array_merge($this->_config, $config);
    }
}
