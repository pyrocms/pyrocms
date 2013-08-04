<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Collection\StreamCollection;

class Stream extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'data_streams';

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

	public function newCollection(array $models = array())
	{
	    return new StreamCollection($models);
	}

	// This returns a consistent Eloquent Collection from either the cache or a new query
	public static function findManyByNamespace($namespace)
	{
		if (static::isCache('all'))
		{	
			return static::all()->findManyByNamespace($namespace);
		}
		else
		{
			return static::where('namespace', '=', $namespace)->get();
		}
	}

    // This returns a consistent Eloquent model from either the cache or a new query
	public static function findBySlugAndNamespace($slug = '', $namespace = '')
	{
		// If the cache is set, get the model from it, if not query it.
		if (static::isCache('all'))
		{	
			return static::all()->findBySlugAndNamespace($slug, $namespace);
		} 
		else
		{
			return static::where('stream_slug', $slug)
				->where('stream_namespace', $namespace)
				->take(1)
				->first();
		}
	}

	public static function getIdFromSlugAndNamespace($slug = '', $namespace = '')
	{
		if ($stream = static::findBySlugAndNamespace($slug, $namespace))
		{
			return $stream->id;
		}

		return false;
	}

	public static function total($namespace = null)
	{
		if ($namespace)
		{
			return static::findManyByNamespace($namespace)->count();	
		}

		return static::all()->count();
	}

	public static function create(array $attributes = array())
	{
		// Slug and namespace are required attributes
		if (isset($attributes['stream_slug']) and isset($attributes['stream_namespace']))
		{
			return false;
		}

		// Check if it doesn't exist
		if(static::findBySlugAndNamespace($attributes['stream_slug'], $attributes['stream_namespace']))
		{
			return false;
		}

		return parent::create($attributes);
	}

	public function getViewOptionsAttribute($view_options)
    {
        return unserialize($view_options);
    }

	public function setViewOptionsAttribute($view_options)
    {
        $this->attributes['view_options'] = serialize($view_options);
    }



	public function assingments()
	{
		return $this->hasMany('Pyro\Module\Streams_core\Model\FieldAssignment', 'stream_id');
	}
}