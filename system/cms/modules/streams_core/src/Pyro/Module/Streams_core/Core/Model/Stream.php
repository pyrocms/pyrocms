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
		if ( ! isset($attributes['stream_slug']) and ! isset($attributes['stream_namespace']))
		{
			return false;
		}

		// Check if it doesn't exist
		if(static::findBySlugAndNamespace($attributes['stream_slug'], $attributes['stream_namespace']))
		{
			return false;
		}

		$attributes['stream_prefix']	= isset($attributes['stream_prefix']) ? $attributes['stream_prefix'] : null;
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
		// See if the stream slug is different
		//$stream = static::find($id);

		if ($stream->stream_slug != $data['stream_slug'] or (isset($data['stream_prefix']) and $stream->stream_prefix != $data['stream_prefix'])) {
			// Use the right DB prefix
			if (isset($data['stream_prefix'])) {
				$prefix = $data['stream_prefix'];
				$attributes['stream_prefix'] = $prefix;
			} else {
				$prefix = $stream->stream_prefix;
			}

			// Use the right stream slug
			if (isset($data['stream_slug'])) {
				$stream_slug = $data['stream_slug'];
				$attributes['stream_slug'] = $stream_slug;
			} else {
				$stream_slug = $stream->stream_slug;
			}

			// Okay looks like we need to alter the table name.
			// Check to see if there is a table, then alter it.
			if ($this->db->table_exists($prefix.$stream_slug)) {
				show_error(sprintf(lang('streams:table_exists'), $data['stream_slug']));
			}

			$this->load->dbforge();

			// Using the PyroStreams DB prefix because rename_table
			// does not prefix the table name properly, it would seem
			if ( ! $this->dbforge->rename_table($stream->stream_prefix.$stream->stream_slug, $prefix.$stream_slug)) {
				return false;
			}
		}

		if (isset($data['stream_name']))		$attributes['stream_name']		= $data['stream_name'];
		if (isset($data['about']))				$attributes['about']			= $data['about'];
		if (isset($data['sorting']))			$attributes['sorting']			= $data['sorting'];
		if (isset($data['title_column']))		$attributes['title_column']		= 	$data['title_column'];
		if (isset($data['is_hidden']))			$attributes['is_hidden']		= $data['is_hidden'];
		if (isset($data['sorting']))			$attributes['sorting']			= $data['sorting'];
		if (isset($data['menu_path']))			$attributes['menu_path']		= $data['menu_path'];

		// Extra enum data checks


		if (isset($attributes['sorting']) and $attributes['sorting'] != 'title' and $attributes['sorting'] != 'custom')
		{
			$attributes['sorting'] = 'title';
		}

		// Permissions
		if (isset($data['permissions']) and is_array($data['permissions'])) {
			$attributes['permissions']		= serialize($data['permissions']);
		}

		// View options.
		if (isset($extra['view_options']) and is_array($extra['view_options'])) {
			$insert_data['view_options']		= serialize($extra['view_options']);
		} else {
			// Since this is a new stream, we are going to add a basic view profile
			// with data we know will be there.
			$insert_data['view_options']		= serialize(array('id', 'created'));
		}

		return parent::update($attributes);
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
		return $this->hasMany('Pyro\Module\Streams_core\Model\FieldAssignment', 'stream_id');
	}
}