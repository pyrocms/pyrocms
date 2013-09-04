<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;

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
	    return new Collection\StreamCollection($models);
	}

	// This returns a consistent Eloquent Collection from either the cache or a new query
	public static function findManyByNamespace($stream_namespace, $limit = 0, $offset = 0)
	{
		return static::where('namespace', '=', $stream_namespace)->take($limit)->skip($offset)->get();
	}

    // This returns a consistent Eloquent model from either the cache or a new query
	public static function findBySlugAndNamespace($stream_slug = null, $stream_namespace = null)
	{
		if ( ! $stream_namespace)
        {
            @list($stream_slug, $stream_namespace) = explode('.', $stream_slug);
        }

		if ( ! $stream = static::getCache(static::getStreamCacheName($stream_slug, $stream_namespace)))
		{
			$stream = static::where('stream_slug', $stream_slug)
			->where('stream_namespace', $stream_namespace)
			->take(1)
			->first();

			$stream = static::setCache(static::getStreamCacheName($stream_slug, $stream_namespace), $stream);
		}

		return $stream;
	}

    protected static function getStreamCacheName($stream_slug = '', $stream_namespace = '')
    {
        return 'stream['.$stream_slug.','.$stream_namespace.']';
    }

	public static function findBySlug($stream_slug = '')
	{
		return static::where('stream_slug', $stream_slug)->take(1)->first();
	}

	public static function getIdFromSlugAndNamespace($stream_slug = '', $stream_namespace = '')
	{
		if ($stream = static::findBySlugAndNamespace($stream_slug, $stream_namespace))
		{
			return $stream->id;
		}

		return false;
	}

	public static function total($stream_namespace = null)
	{
		if ($stream_namespace)
		{
			return static::findManyByNamespace($stream_namespace)->count();	
		}

		return static::all()->count();
	}

	public static function updateTitleColumnByStreamIds($stream_ids = array(), $from = null, $to = null)
	{
		if ($from == $to) return false;

		return static::whereIn('id', $stream_ids)
		->where('title_column', $from)
		->update(array(
			'title_column' => $to
		));
	}

	public static function create(array $attributes = array())
	{
		// Slug and namespace are required attributes
		if ( ! isset($attributes['stream_slug']) and ! isset($attributes['stream_namespace']))
		{
			return false;
		}

		// Check if it doesn't exist
		if(static::findBySlugAndNamespace($attributes['stream_slug'], $attributes['stream_namespace']))
		{
			return false;
		}

		$attributes['is_hidden']		= isset($attributes['is_hidden']) ? $attributes['is_hidden'] : false;
		$attributes['sorting']			= isset($attributes['sorting']) ? $attributes['sorting'] : 'title';
		$attributes['view_options']		= isset($attributes['view_options']) ? $attributes['view_options'] : array('id', 'created');

		$schema = ci()->pdb->getSchemaBuilder();

		// See if table exists. You never know if it sneaked past validation
		if ($schema->hasTable($attributes['stream_prefix'].$attributes['stream_slug']))
		{
			return false;
		}

		// Create the table for our new stream
		$schema->create($attributes['stream_prefix'].$attributes['stream_slug'], function($table) {
            $table->increments('id');
            $table->datetime('created');
            $table->datetime('updated');
            $table->integer('created_by')->nullable();
            $table->integer('ordering_count')->nullable();
        });

		// Create the stream in the data_streams table
		return parent::create($attributes);
	}

	/**
	 * Update Stream
	 *
	 * @param	int
	 * @param	array - attributes
	 * @return	bool
	 */
	public function update(array $attributes = array())
	{
		$attributes['stream_prefix'] = isset($attributes['stream_prefix']) ? $attributes['stream_prefix'] : $this->attribute['stream_prefix'];
		$attributes['stream_slug'] = isset($attributes['stream_slug']) ? $attributes['stream_slug'] : $this->attribute['stream_slug'];

		$schema = ci()->pdb->getSchemaBuilder();

		$from = $this->getAttribute('stream_prefix').$this->getAttribute('stream_slug');
		$to = $attributes['stream_prefix'].$attributes['stream_slug'];

		if ($schema->hasTable($from) and $from != $to)
		{
			$schema->rename($from, $to);
		}

		return parent::update($attributes);
	}

	public function delete()
	{
		$schema = ci()->pdb->getSchemaBuilder();

		$schema->dropIfExists($this->getAttribute('prefix').$this->getAttribute('stream_slug'));

		$success = parent::delete();

		FieldAssignment::cleanup();

		return $success;
	}

	/**
	 * Find a model by its primary key or throw an exception.
	 *
	 * @param  mixed  $id
	 * @param  array  $columns
	 * @return \Pyro\Module\Streams_core\Core\Model\Stream|Collection|static
	 */
	public static function findOrFail($id, $columns = array('*'))
	{
		if ( ! is_null($model = static::find($id, $columns))) return $model;

		throw new Exception\StreamNotFoundException;
	}

	public function getIsHiddenAttribute($is_hidden)
	{
		return $is_hidden == 'yes' ? true : false;
	}

	public function setIsHiddenAttribute($is_hidden)
	{
		$this->attributes['is_hidden'] = ! $is_hidden ? 'no' : 'yes';
	}

	public function getViewOptionsAttribute($view_options)
	{
	    return unserialize($view_options);
	}

	public function setViewOptionsAttribute($view_options)
	{	
		$this->attributes['view_options'] = serialize($view_options);
	}

	public function getPermissionsAttribute($permissions)
    {
        return unserialize($permissions);
    }

	public function setPermissionsAttribute($permissions)
    {
        $this->attributes['permissions'] = serialize($permissions);
    }

	public function assignments()
	{
		return $this->hasMany('Pyro\Module\Streams_core\Core\Model\FieldAssignment');
	}
}