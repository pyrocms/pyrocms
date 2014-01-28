<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Events\Dispatcher;
use Pyro\Module\Streams_core\EntryModel;

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

    protected $cacheMinutes = false;

    /**
     * Skio validation
     * @var boolean
     */
    public $skip_validation = false;

    /**
     * Replicated
     * @var boolean
     */
    protected $replicated = false;

    public static function boot()
    {
        parent::boot();

        static::$dispatcher = new Dispatcher;
    }

    /**
     * Get cache minutes
     * @return integer
     */
    public function getCacheMinutes()
    {
        return $this->cacheMinutes;
    }

    /**
     * Set cache minutes
     * @return integer
     */
    public function setCacheMinutes($cacheMinutes)
    {
        $this->cacheMinutes = $cacheMinutes;

        return $this;
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

        $this->flushCacheCollection();

        return parent::save($options);
    }

    public function delete()
    {
        $this->flushCacheCollection();

        return parent::delete();
    }

    public function flushCacheCollection()
    {
        ci()->cache->collection($this->getCacheCollectionKey())->flush();

        return $this;
    }

    /**
     * Replicate 
     * @return object The model clone
     */
    public function replicate()
    {
        $clone = parent::replicate();
        $clone->skip_validation = true;
        $clone->replicated = true;
        return $clone;
    }

    /**
     * New collection
     * @param  array  $models The array of models
     * @return object         The Collection object
     */
    public function newCollection(array $models = array())
    {
        return new EloquentCollection($models);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool  $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new EloquentQueryBuilder($this->newBaseQueryBuilder());

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

    /**
     * Get cache collection key
     * @return string
     */
    public function getCacheCollectionKey($suffix = null)
    {
        return $this->getCacheCollectionPrefix().$suffix;
    }

    /**
     * Get cache collection prefix
     * @return string
     */
    public function getCacheCollectionPrefix()
    {
        return get_called_class();
    }

    /**
     * Get the title column value
     */
    public function getTitleColumnValue()
    {
        return null;
    }

    public function getRelation($attribute)
    {
        if (isset($this->relations[$attribute])) return $this->relations[$attribute];

        return null;
    }
}

/* End of file Eloquent.php */