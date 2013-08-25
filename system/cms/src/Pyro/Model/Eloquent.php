<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Model
 *
 * Extends Illuminates Eloquent model and adds validation
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Model\Eloquent
 */
abstract class Eloquent extends Model
{   

    // --------------------------------------------------------------------------
    // Runtime Cache
    // --------------------------------------------------------------------------
    // The runtime cache is based on how streams and fields use to do it by storing data in a static variable.
    // We put it on this base Eloquent model to make it available to any that extend it.

    /*
     * The static runtime cache variables used to store results on each request
     */
    protected static $runtime_cache = array();

    /**
     * We can store data in the class at runtime so we don't have to keep hitting the database
     *
     * @param  string  $key The key that is going to be appended to the called model class
     * @param mixed $value The value to be chached
     * @return mixed
     */
    public static function setCache($key, $value)
    {
        return static::$runtime_cache[get_called_class()][$key] = $value;
    }

    /**
     * Check if a key has being set in the runtime cache
     *
     * @param  string  $key The key that is going to be appended to the called model class
     * @return bool
     */
    public static function isCache($key)
    {
        return isset(static::$runtime_cache[get_called_class()][$key]);
    }

    /**
     * Get a runtime cache value by key
     *
     * @param  array  $options
     * @return mixed
     */
    public static function getCache($key)
    {
        if (static::isCache($key))
        {
            return static::$runtime_cache[get_called_class()][$key];    
        }

        return false;
    }

    /**
     * Get a the entire runtime cache key - values
     *
     * @return array
     */
    public static function getRuntimeCache()
    {
        return static::$runtime_cache;
    }

    public function getAttributeKeys()
    {
        return array_keys($this->getAttributes());
    }

    /**
     * Caches the result of all() in the runtime cache
     *
     * @param  array  $options
     * @return bool
     */
    public static function all($columns = array('*'))
    {
        if (static::isCache('all'))
        {
            return static::getCache('all');
        }
        
        return static::setCache('all', parent::all($columns));
    }

    public function update(array $attributes = array())
    {
        // Remove any post values that do not correspond to existing columns
        foreach ($attributes as $key => $value)
        {
            if ( ! in_array($key, $this->getAttributeKeys()))
            {
                unset($attributes[$key]);
            }
        }

        return parent::update($attributes);
    }

    // abstract public function validate();

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        if (method_exists($this, 'validate') and ! $this->validate())
        {
            return false;
        }
        
        return parent::save($options);
    }
}

/* End of file Eloquent.php */