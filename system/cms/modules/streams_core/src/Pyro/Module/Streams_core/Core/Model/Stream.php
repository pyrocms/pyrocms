<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Field\Type;

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

	public static function updateTitleColumnByStreamIds($stream_ids = null, $from = null, $to = null)
	{
		if (empty($stream_ids) or $from == $to) return false;

		if ( ! is_array($stream_ids))
		{
			$stream_ids = array($stream_ids);
		}

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

    public function assignField($field = null, $data = array())
    {
    	// TODO This whole method needs to be recoded to use Schema...

		// -------------------------------------
		// Get the field data
		// -------------------------------------

    	if (is_numeric($field))
    	{
			$field = Field::findOrFail($field_id);
    	}

		if ( ! $field instanceof Field) return false;

		if ($assignment = FieldAssignment::findByFieldIdAndStreamId($field->id, $this->data->stream->id))
		{
			$assignment = new FieldAssignment;
		}

		// -------------------------------------
		// Load the field type
		// -------------------------------------

		if ( ! $field_type = $field->getType()) return false;

		// Do we have a pre-add function?
		if (method_exists($field_type, 'field_assignment_construct'))
		{
			$field_type->setStream($this);
			$field_type->field_assignment_construct();
		}

		// -------------------------------------
		// Create database column
		// -------------------------------------

		if ($field_type->db_col_type !== false)
		{
			$this->schema_thing($this, $field_type, $field);
		}

		// -------------------------------------
		// Check for title column
		// -------------------------------------
		// See if this should be made the title column
		// -------------------------------------

		if (isset($data['title_column']) and ($data['title_column'] == 'yes' or $data['title_column'] === true))
		{
			$update_data['title_column'] = $field->field_slug;

			$this->update($update_data);
		}

		// -------------------------------------
		// Create record in assignments
		// -------------------------------------

		$assignment->stream_id 		= $this->getKey();
		$assignment->field_id		= $field->getKey();

		$assignment->instructions	= isset($data['instructions']) ? $data['instructions'] : null;

		// First one! Make it 1
		$insert_data['sort_order'] = FieldAssignment::getIncrementalSortNumber($this->getKey());

		// Is Required
		$assignment->is_required = $data['is_required'];

		// Unique
		$assignment->is_unique = $data['is_unique'];

		// Return the field assignment or false
		return $assignment->save();	
    }

	public function schema_thing($stream, $type, $field)
	{
		$schema = ci()->pdb->getSchemaBuilder();

		$prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

		// Check if the table exists
		if ( ! $schema->hasTable($stream->stream_prefix.$stream->stream_slug)) return false;

		// Check if the column does not exist already to avoid errors, specially on migrations
		// @todo - hasColunm() has a bug in illuminate/database where it does not apply the table prefix, we have to pass it ourselves
		// Remove the prefix as soon as the pull request / fix gets merged https://github.com/laravel/framework/pull/2070
		if ($schema->hasColumn($prefix.$stream->stream_prefix.$stream->stream_slug, $field->field_slug)) return false;

		$schema->table($stream->stream_prefix.$stream->stream_slug, function($table) use ($type, $field) {

			$db_type_method = camel_case($type->db_col_type);

			// This seems like a sane default, and allows for 2.2 style widgets
			if (! method_exists($type, $db_type_method)) {
				$db_type_method = 'text';
			}

			// -------------------------------------
			// Constraint
			// -------------------------------------

			$constraint = null;

			// First we check and see if a constraint has been added
			if (isset($type->col_constraint) and $type->col_constraint) {
				$constraint = $type->col_constraint;

			// Otherwise, we'll check for a max_length field
			} elseif (isset($field->field_data['max_length']) and is_numeric($field->field_data['max_length'])) {
				$constraint = $field->field_data['max_length'];
			}

			// Only the string method cares about a constraint
			if ($db_type_method === 'string') {
				$col = $table->{$db_type_method}($field->field_slug, $constraint);
			} else {
				$col = $table->{$db_type_method}($field->field_slug);
			}

			// -------------------------------------
			// Default
			// -------------------------------------
			if (! empty($field->field_data['default_value']) and ! in_array($db_type_method, array('text', 'longText'))) {
				$col->default($field->field_data['default_value']);
			}

			// -------------------------------------
			// Default to allow null
			// -------------------------------------

			$col->nullable();
		});
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