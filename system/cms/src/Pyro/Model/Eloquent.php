<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Pyro\Module\Streams_core\Core\Model\Entry;
use Pyro\Module\Streams_core\Core\Model\Exception\ClassNotInstanceOfEntryException;
use Pyro\Module\Streams_core\Core\Model\Relation\BelongsToEntry;

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

    public $skip_validation = false;

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
        if (method_exists($this, 'validate') and ! $this->validate() and ! $this->skip_validation)
        {
            return false;
        }
        
        return parent::save($options);
    }

    public function newCollection(array $models = array())
    {
        return new Collection\EloquentCollection($models);
    }

    /**
     * Define an polymorphic, inverse one-to-one or many relationship.
     *
     * @param  string  $name
     * @param  string  $type
     * @param  string  $id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function morphToEntry($related = 'Pyro\Module\Streams_core\Core\Model\Entry', $relation_name = 'entry', $stream_column = null, $id_column = null)
    {
        // Next we will guess the type and ID if necessary. The type and IDs may also
        // be passed into the function so that the developers may manually specify
        // them on the relations. Otherwise, we will just make a great estimate.
        list($stream_column, $id_column) = $this->getMorphs($relation_name, $stream_column, $id_column);

        if ( ! $stream = $this->$stream_column)
        {
            // @todo - do we want to throw an exception if the stream is not stored?
        }

        return $this->belongsToEntry($related, $id_column, $stream, $stream_column);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToEntry($related = 'Pyro\Module\Streams_core\Core\Model\Entry', $foreignKey = null, $stream = null, $stream_column = null)
    {
        list(, $caller) = debug_backtrace(false);

        // If no foreign key was supplied, we can use a backtrace to guess the proper
        // foreign key name by using the name of the relationship function, which
        // when combined with an "_id" should conventionally match the columns.
        $relation = $caller['function'];

        if (is_null($foreignKey))
        {
            $foreignKey = snake_case($relation).'_id';
        }

        $instance = new $related;

        if( ! ($instance instanceof Entry))
        {
            throw new ClassNotInstanceOfEntryException;
        }

        // Once we have the foreign key names, we'll just create a new Eloquent query
        // for the related models and returns the relationship instance which will
        // actually be responsible for retrieving and hydrating every relations.
        if ( ! empty($stream))
        {
            $instance = call_user_func(array($related, 'stream'), $stream);
        }

        $query = $instance->newQuery();

        $relation_instance = new BelongsToEntry($query, $this, $foreignKey, $relation);

        $relation_instance->setStreamColumn($stream_column);

        return $relation_instance;
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool  $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new Query\Builder($this->newBaseQueryBuilder());

        // Once we have the query builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        $builder->setModel($this)->with($this->with);

        if ($excludeDeleted and $this->softDelete)
        {
            $builder->whereNull($this->getQualifiedDeletedAtColumn());
        }

        return $builder;
    }
}

/* End of file Eloquent.php */