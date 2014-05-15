<?php namespace Pyro\Module\Streams\Stream;

use Illuminate\Support\Str;
use Pyro\Model\Eloquent;
use Pyro\Module\Streams\Entry\EntryModelGenerator;
use Pyro\Module\Streams\Exception\EmptyFieldNamespaceException;
use Pyro\Module\Streams\Exception\EmptyFieldSlugException;
use Pyro\Module\Streams\Exception\InvalidStreamModelException;
use Pyro\Module\Streams\Exception\StreamModelNotFoundException;
use Pyro\Module\Streams\Field\FieldAssignmentCollection;
use Pyro\Module\Streams\Field\FieldAssignmentModel;
use Pyro\Module\Streams\Field\FieldModel;

class StreamModel extends Eloquent
{
    protected static $streamsCache = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'data_streams';

    /**
     * Cache minutes
     *
     * @var boolean/int
     */
    protected $cacheMinutes = false;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Get entry model class
     *
     * @param $stream_slug
     * @param $stream_namespace
     * @return string
     */
    public static function getEntryModelClass($stream_slug, $stream_namespace)
    {
        return static::getEntryModelNamespace() . '\\' . Str::studly(
            "{$stream_namespace}_{$stream_slug}" . 'EntryModel'
        );
    }

    /**
     * Get entry model namespace
     *
     * @return string
     */
    public static function getEntryModelNamespace()
    {
        return 'Pyro\\Module\\Streams\\Model';
    }

    /**
     * Add a Stream.
     *
     * @access    public
     * @param    string - stream name
     * @param    string - stream slug
     * @param    string - stream namespace
     * @param     [string - stream prefix]
     * @param     [string - about notes for stream]
     * @param     [array - extra data]
     * @return    false or new stream ID
     */
    public static function addStream(
        $stream_slug,
        $stream_namespace,
        $stream_name,
        $stream_prefix = null,
        $about = null,
        $extra = array()
    ) {
        // -------------------------------------
        // Validate Data
        // -------------------------------------

        // Do we have a field slug?
        if (!isset($stream_slug) or !trim($stream_slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($stream_namespace) or !trim($stream_namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        // Do we have a field name?
        if (!isset($stream_name) or !trim($stream_name)) {
            throw new EmptyFieldNameException;
        }

        // -------------------------------------
        // Create Stream
        // -------------------------------------

        $stream = array(
            'stream_slug'      => $stream_slug,
            'stream_namespace' => $stream_namespace,
            'stream_name'      => $stream_name,
            'stream_prefix'    => $stream_prefix,
            'about'            => $about,
        );

        $stream['view_options'] = (isset($extra['view_options']) and is_array(
                $extra['view_options']
            )) ? $extra['view_options'] : array('id', 'created_at');
        $stream['title_column'] = isset($extra['title_column']) ? $extra['title_column'] : null;
        $stream['sorting']      = isset($extra['sorting']) ? $extra['sorting'] : 'title';
        $stream['permissions']  = isset($extra['permissions']) ? $extra['permissions'] : null;
        $stream['is_hidden']    = isset($extra['is_hidden']) ? $extra['is_hidden'] : false;
        $stream['menu_path']    = isset($extra['menu_path']) ? $extra['menu_path'] : null;

        return static::create($stream);
    }

    /**
     * Create
     *
     * @param  array $attributes
     * @return boolean
     */
    public static function create(array $attributes = array())
    {
        // Slug and namespace are required attributes
        if (!isset($attributes['stream_slug']) and !isset($attributes['stream_namespace'])) {
            return false;
        }

        // Check if it doesn't exist
        if (static::findBySlugAndNamespace($attributes['stream_slug'], $attributes['stream_namespace'])) {
            return false;
        }

        $attributes['is_hidden']    = isset($attributes['is_hidden']) ? $attributes['is_hidden'] : false;
        $attributes['sorting']      = isset($attributes['sorting']) ? $attributes['sorting'] : 'title';
        $attributes['view_options'] = isset($attributes['view_options']) ? $attributes['view_options'] : array(
            'id',
            'created_at'
        );

        $schema = ci()->pdb->getSchemaBuilder();

        // See if table exists. You never know if it sneaked past validation
        if (!$schema->hasTable($attributes['stream_prefix'] . $attributes['stream_slug'])) {
            // Create the table for our new stream
            $schema->create(
                $attributes['stream_prefix'] . $attributes['stream_slug'],
                function ($table) {
                    $table->increments('id');
                    $table->datetime('created_at');
                    $table->datetime('updated_at')->nullable();
                    $table->integer('created_by')->nullable();
                    $table->integer('ordering_count')->nullable();
                }
            );
        }

        // Create the stream in the data_streams table
        return parent::create($attributes);
    }

    /**
     * This returns a consistent Eloquent
     * model from either the cache or a new query
     *
     * @param  string $stream_slug
     * @param  string $stream_namespace
     * @return object
     */
    public static function findBySlugAndNamespace($stream_slug, $stream_namespace = null)
    {
        if (!$stream_namespace) {
            @list($stream_slug, $stream_namespace) = explode('.', $stream_slug);
        }

        return static::with('assignments.field')->where('stream_slug', $stream_slug)
            ->where('stream_namespace', $stream_namespace)
            ->take(1)
            ->first();
    }

    /**
     * Delete a stream
     *
     * @access    public
     * @param    mixed  $stream           object, int or string stream
     * @param    string $stream_namespace namespace if first param is string
     * @return    object
     */
    public static function deleteStream($stream_slug, $stream_namespace = null)
    {
        if ($stream = static::getStream($stream_slug, $stream_namespace)) {
            return $stream->delete();
        }

        return false;
    }

    /**
     * Get Stream
     *
     * @access    public
     * @param    mixed  $stream           object, int or string stream
     * @param    string $stream_namespace namespace if first param is string
     * @return    object
     */
    public static function getStream($stream_slug, $stream_namespace = null)
    {
        if (!$stream = static::findBySlugAndNamespace($stream_slug, $stream_namespace)) {
            throw new InvalidStreamModelException('Invalid stream. Attempted [' . $stream_slug . ',' . $stream_namespace . ']');
        }

        return $stream;
    }

    // --------------------------------------------------------------------------

    /**
     * Update a stream
     *
     * @access    public
     * @param    mixed  $stream           object, int or string stream
     * @param    string $stream_namespace namespace if first param is string
     * @param    array  $data             associative array of new data
     * @return    object
     */
    public static function updateStream($stream_slug, $stream_namespace = null, $data = array())
    {
        $stream = static::getStream($stream_slug, $stream_namespace);

        return $stream->update($data);
    }

    /**
     * Get stream field assignments
     *
     * @access    public
     * @param    mixed  $stream           object, int or string stream
     * @param    string $stream_namespace namespace if first param is string
     * @return    object
     */
    public static function getFieldAssignments($stream_slug, $stream_namespace = null)
    {
        $stream = static::getStream($stream_slug, $stream_namespace);

        return $stream->assignments;
    }

    /**
     * Get Stream Metadata
     * Returns an array of the following data:
     * name            The stream name
     * slug            The streams slug
     * namespace        The stream namespace
     * db_table        The name of the stream database table
     * raw_size        Raw size of the stream database table
     * size            Formatted size of the stream database table
     * entries_count    Number of the entries in the stream
     * fields_count    Number of fields assigned to the stream
     * last_updated        Unix timestamp of when the stream was last updated
     *
     * @access    public
     * @param    mixed  $stream           object, int or string stream
     * @param    string $stream_namespace namespace if first param is string
     * @return    object
     */
    public static function getStreamMetadata($stream_slug = null, $stream_namespace = null)
    {
        $stream = static::getStream($stream_slug, $stream_namespace);

        $data = array();

        $data['name']      = $stream->stream_name;
        $data['slug']      = $stream->stream_slug;
        $data['namespace'] = $stream->stream_namespace;

        // Get DB table name
        $data['db_table'] = $stream->stream_prefix . $stream->stream_slug;

        // @todo - convert to Query Builder

        // Get the table data
        $info = ci()->db->query("SHOW TABLE STATUS LIKE '" . ci()->db->dbprefix($data['db_table']) . "'")->row();

        // Get the size of the table
        $data['raw_size'] = $info->Data_length;

        ci()->load->helper('number');
        $data['size'] = byte_format($info->Data_length);

        // Last updated time
        $data['last_updated'] = (!$info->Update_time) ? $info->Create_time : $info->Update_time;

        ci()->load->helper('date');
        $data['last_updated'] = mysql_to_unix($data['last_updated']);

        // Get the number of rows (the table status data on this can't be trusted)
        $data['entries_count'] = ci()->db->count_all($data['db_table']);

        // Get the number of fields
        $data['fields_count'] = ci()->db->select('id')->where('stream_id', $stream->id)->get(ASSIGN_TABLE)->num_rows();

        return $data;
    }

    /**
     * This returns a consistent Eloquent
     * Collection from either the cache or a new query
     *
     * @param  string  $stream_namespace
     * @param  string  $limit
     * @param  integer $offset
     * @return object
     */
    public static function findManyByNamespace($stream_namespace, $take = 0, $skip = null)
    {
        $query = static::where('stream_namespace', '=', $stream_namespace);

        if ($take > 0) {
            $query = $query->take($take)->skip($skip);
        }

        return $query->get();
    }

    /**
     * Find a model by slug and namespace or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Pyro\Module\Streams\StreamModel|Collection|static
     */
    public static function findBySlugAndNamespaceOrFail($stream_slug = null, $stream_namespace = null)
    {
        if (!is_null($model = static::findBySlugAndNamespace($stream_slug, $stream_namespace))) {
            return $model;
        }

        throw new StreamModelNotFoundException;
    }

    /**
     * Find by slug
     *
     * @param  string $stream_slug
     * @return object
     */
    public static function findBySlug($stream_slug = '')
    {
        return static::where('stream_slug', $stream_slug)->take(1)->first();
    }

    /**
     * Get ID from slug and namespace
     *
     * @param  string $stream_slug
     * @param  string $stream_namespace
     * @return mixed
     */
    public static function getIdFromSlugAndNamespace($stream_slug = '', $stream_namespace = '')
    {
        if ($stream = static::findBySlugAndNamespace($stream_slug, $stream_namespace)) {
            return $stream->id;
        }

        return false;
    }

    /**
     * Update title column by stream IDs
     *
     * @param  array   $stream_ids
     * @param  integer $from
     * @param  integer $to
     * @return object
     */
    public static function updateTitleColumnByStreamIds($stream_ids = null, $from = null, $to = null)
    {
        if (empty($stream_ids) or $from == $to) {
            return false;
        }

        if (!is_array($stream_ids)) {
            $stream_ids = array($stream_ids);
        }

        return static::whereIn('id', $stream_ids)
            ->where('title_column', $from)
            ->update(
                array(
                    'title_column' => $to
                )
            );
    }

    /**
     * Get Stream options
     *
     * @return array The array of Stream options indexed by id
     */
    public static function getStreamOptions()
    {
        return static::all(array('id', 'stream_name', 'stream_namespace'))->getStreamOptions();
    }

    /**
     * Get Stream associative options
     *
     * @return array The array of Stream options indexed by "stream_slug.stream_namespace"
     */
    public static function getStreamAssociativeOptions()
    {
        return static::all(array('stream_name', 'stream_slug', 'stream_namespace'))->getStreamAssociativeOptions();
    }

    /**
     * Check if table exists
     *
     * @param  string $stream
     * @param  string $prefix
     * @return boolean
     */
    public static function tableExists($stream, $prefix = null)
    {
        $schema = ci()->pdb->getSchemaBuilder();

        if ($stream instanceof static) {
            $table = $stream->stream_prefix . $stream->stream_slug;
        } else {
            $table = $prefix . $stream;
        }

        return $schema->hasTable($table);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Pyro\Module\Streams\StreamModel|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }

        throw new StreamNotFoundException;
    }

    public static function find($id, $columns = array('*'))
    {
        if (isset(static::$streamsCache[$id])) {
            return static::$streamsCache[$id];
        }

        $stream = static::with('assignments.field')->where('id', $id)
            ->take(1)
            ->first();

        return static::$streamsCache[$id] = static::$streamsCache[$id] = $stream;
    }

    /**
     * Get stream model object from stream data array
     *
     * @param  array $streamData
     * @return Pyro\Module\Streams\StreamModel
     */
    public static function object($streamData)
    {
        $assignments = array();

        if (isset($streamData['stream_namespace'], $streamData['stream_slug'])) {
            if (isset(static::$streamsCache[$streamData['stream_namespace'] . '.' . $streamData['stream_slug']])) {
                return static::$streamsCache[$streamData['stream_namespace'] . '.' . $streamData['stream_slug']];
            }
        }

        if (is_array($streamData) and !empty($streamData['assignments'])) {

            foreach ($streamData['assignments'] as $assignment) {

                if (!empty($assignment['field'])) {
                    $fieldModel = new FieldModel($assignment['field']);
                    unset($assignment['field']);
                }

                $assignmentModel = new FieldAssignmentModel($assignment);

                $assignmentModel->setRawAttributes($assignment);

                $assignmentModel->setRelation('field', $fieldModel);

                $assignments[] = $assignmentModel;
            }

            unset($streamData['assignments']);
        }

        $streamModel = new static;

        $streamModel->setRawAttributes($streamData);

        $assignmentsCollection = new FieldAssignmentCollection($assignments);

        $streamModel->setRelation('assignments', $assignmentsCollection);

        $streamModel->assignments = $assignmentsCollection;

        return static::$streamsCache[$streamModel->stream_namespace . '.' . $streamModel->stream_slug] = $streamModel;
    }

    /**
     * Get stream cache name
     *
     * @param  string $stream_slug
     * @param  string $stream_namespace
     * @return object
     */
    protected static function getStreamCacheName($stream_slug = '', $stream_namespace = '')
    {
        return 'stream[' . $stream_slug . ',' . $stream_namespace . ']';
    }

    /**
     * Validation Array
     * Get a validation array for a stream. Takes
     * the format of an array of arrays like this:
     * array(
     * 'field' => 'email',
     * 'label' => 'Email',
     * 'rules' => 'required|valid_email'
     */
    public function validationArray(
        $stream,
        $stream_namespace = null,
        $method = 'new',
        $skips = array(),
        $row_id = null
    ) {
        if (!$stream instanceof static) {
            if (!$stream = static::findBySlugAndNamespace($stream, $namespace)) {
                throw new InvalidStreamModelException('Invalid stream. Attempted [' . $stream_slug . ',' . $namespace . ']');
            }
        }

        $stream_fields = $stream->assignments;

        // @todo = This has to be redone as PSR
        return ci()->fields->set_rules($stream_fields, $method, $skips, true, $row_id);
    }

    /**
     * New stream collection
     *
     * @param  array $models
     * @return object
     */
    public function newCollection(array $models = array())
    {
        return new StreamCollection($models);
    }

    /**
     * Delete
     *
     * @return boolean
     */
    public function delete()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        foreach ($this->assignments as $field) {
            if ($type = $field->getType()) {
                $type->setStream($this)->namespaceDestruct();
            }
        }

        try {
            $schema->dropIfExists($this->getAttribute('stream_prefix') . $this->getAttribute('stream_slug'));
        } catch (Exception $e) {
            // @todo - log error
        }

        if ($success = parent::delete()) {
            FieldAssignmentModel::cleanup();

            FieldModel::cleanup();
        }

        return $success;
    }

    /**
     * Assign field
     *
     * @param  string $field
     * @param  mixed  $data
     * @return boolean
     */
    public function assignField($field = null, $data = array(), $createColumn = true)
    {
        // TODO This whole method needs to be recoded to use Schema...

        // -------------------------------------
        // Get the field data
        // -------------------------------------

        if (is_numeric($field)) {
            $field = FieldModel::findOrFail($field);
        }

        if (!$field instanceof FieldModel) {
            return false;
        }

        if (!$assignment = FieldAssignmentModel::findByFieldIdAndStreamId($field->getKey(), $this->getKey(), true)) {
            $assignment = new FieldAssignmentModel;
        }

        // -------------------------------------
        // Load the field type
        // -------------------------------------

        if (!$field_type = $field->getType()) {
            return false;
        }

        // Do we have a pre-add function?
        if (method_exists($field_type, 'fieldAssignmentConstruct')) {
            $field_type->setStream($this);
            $field_type->fieldAssignmentConstruct(ci()->pdb->getSchemaBuilder());
        }

        // -------------------------------------
        // Create database column
        // -------------------------------------

        if ($field_type->db_col_type !== false and $createColumn === true) {
            $this->schema_thing($this, $field_type, $field);
        }

        // -------------------------------------
        // Check for title column
        // -------------------------------------
        // See if this should be made the title column
        // -------------------------------------

        if (isset($data['title_column']) and ($data['title_column'] == 'yes' or $data['title_column'] === true)) {
            $update_data['title_column'] = $field->field_slug;

            $this->update($update_data);
        }

        // -------------------------------------
        // Create record in assignments
        // -------------------------------------

        $assignment->stream_id = $this->getKey();
        $assignment->field_id  = $field->getKey();

        if (isset($data['instructions'])) {
            $assignment->instructions = $data['instructions'];
        } else {
            $assignment->instructions = "lang:{$this->stream_namespace}.field.{$field->field_slug}.instructions";
        }

        // First one! Make it 1
        $assignment->sort_order = FieldAssignmentModel::getIncrementalSortNumber($this->getKey());

        // Is Required
        $assignment->is_required = isset($data['is_required']) ? $data['is_required'] : false;

        // Is unique
        $assignment->is_unique = isset($data['is_unique']) ? $data['is_unique'] : false;

        // Return the field assignment or false
        return $assignment->save();
    }

    /**
     * Schema thing..
     *
     * @param  object $stream
     * @param  object $type
     * @param  object $field
     * @return void
     */
    public function schema_thing($stream, $type, $field)
    {
        $schema = ci()->pdb->getSchemaBuilder();

        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        // Check if the table exists
        if (!$schema->hasTable($stream->stream_prefix . $stream->stream_slug)) {
            return false;
        }

        // Check if the column does not exist already to avoid "duplicate column" errors
        if ($schema->hasColumn($stream->stream_prefix . $stream->stream_slug, $type->getColumnName())) {
            return false;
        }

        $schema->table(
            $stream->stream_prefix . $stream->stream_slug,
            function ($table) use ($type, $field) {

                $db_type_method = camel_case($type->db_col_type);

                // This seems like a sane default, and allows for 2.2 style widgets
                // Bad boy.. whomever.
                if (!method_exists($type, $db_type_method)) {
                    //$db_type_method = 'text';
                }

                // -------------------------------------
                // Constraint
                // -------------------------------------

                $constraint = 255;

                // First we check and see if a constraint has been added
                if (isset($type->col_constraint) and $type->col_constraint) {
                    $constraint = $type->col_constraint;

                    // Otherwise, we'll check for a max_length field
                } elseif (isset($field->field_data['max_length']) and is_numeric($field->field_data['max_length'])) {
                    $constraint = $field->field_data['max_length'];
                }

                // Only the string method cares about a constraint
                if ($db_type_method === 'string') {
                    $col = $table->{$db_type_method}($type->getColumnName(), $constraint);
                } else {
                    $col = $table->{$db_type_method}($type->getColumnName());
                }

                // -------------------------------------
                // Default to allow null
                // -------------------------------------

                $col->nullable();

                // -------------------------------------
                // Default
                // -------------------------------------
                if (!empty($field->field_data['default_value']) and !in_array(
                        $db_type_method,
                        array('text', 'longText')
                    )
                ) {
                    $col->default($field->field_data['default_value']);
                }
            }
        );
    }

    /**
     * Update Stream
     *
     * @param    int
     * @param    array - attributes
     * @return    bool
     */
    public function update(array $attributes = array())
    {
        $attributes['stream_prefix'] = isset($attributes['stream_prefix']) ? $attributes['stream_prefix'] : $this->getAttribute(
            'stream_prefix'
        );
        $attributes['stream_slug']   = isset($attributes['stream_slug']) ? $attributes['stream_slug'] : $this->getAttribute(
            'stream_slug'
        );

        $schema = ci()->pdb->getSchemaBuilder();

        $from = $this->getAttribute('stream_prefix') . $this->getAttribute('stream_slug');
        $to   = $attributes['stream_prefix'] . $attributes['stream_slug'];

        try {
            if (!empty($to) and $schema->hasTable($from) and $from != $to) {
                $schema->rename($from, $to);
            }
        } catch (Exception $e) {
            // @todo - throw exception
        }

        return parent::update($attributes);
    }

    /**
     * Add view option
     *
     * @param string $field_slug
     * @return bool
     */
    public function addViewOption($field_slug = null)
    {
        if (!$field_slug) {
            return false;
        }

        $view_options = $this->view_options;

        $view_options[] = $field_slug;

        $this->view_options = array_unique($view_options);

        $this->save();
    }

    public function save(array $options = array())
    {
        $this->compileEntryModel();

        return parent::save($options);
    }

    /**
     * Compile entry model
     *
     * @return [type] [description]
     */
    public function compileEntryModel()
    {
        $generator = new EntryModelGenerator;

        return $generator->compile($this);
    }

    /**
     * Remove a field assignment
     *
     * @param    object
     * @param    object
     * @param    object
     * @return    bool
     */
    public function removeFieldAssignment($field)
    {
        $schema = ci()->pdb->getSchemaBuilder();
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        if (!$field instanceof FieldModel) {
            return false;
        }

        // Do we have a destruct function
        if ($type = $field->getType()) {
            // @todo - also pass the schema builder
            $type->setStream($this);
            $type->fieldAssignmentDestruct();

            // -------------------------------------
            // Remove from db structure
            // -------------------------------------
            if (!$type->alt_process) {
                $schema->table(
                    $this->stream_prefix . $this->stream_slug,
                    function ($table) use ($type, $schema) {
                        if ($schema->hasColumn($table->getTable(), $type->getColumnName())) {
                            $table->dropColumn($type->getColumnName());
                        }
                    }
                );
            }
        }

        if ($assignment = FieldAssignmentModel::findByFieldIdAndStreamId($field->getKey(), $this->getKey())) {
            // -------------------------------------
            // Remove from field assignments table
            // -------------------------------------
            if (!$assignment->delete()) {
                return false;
            }
        }


        // -------------------------------------
        // Remove from from field options
        // -------------------------------------
        $this->removeViewOption($field->field_slug);

        return true;
    }

    /**
     * Remove view option
     *
     * @param string $field_slug
     * @return bool
     */
    public function removeViewOption($field_slug = null)
    {
        if (!$field_slug) {
            return false;
        }

        $view_options = $this->view_options;

        if (in_array($field_slug, $view_options)) {
            foreach ($view_options as $key => $view_option) {
                if ($field_slug == $view_option) {
                    unset($view_options[$key]);
                }
            }
        }

        $this->view_options = $view_options;

        $this->save();
    }

    /**
     * Get is is_hidden attr
     *
     * @param  string $isHidden
     * @return boolean
     */
    public function getIsHiddenAttribute($isHidden)
    {
        return $isHidden == 'yes' ? true : false;
    }

    /**
     * Set is_hidden attr
     *
     * @param boolean $isHidden
     */
    public function setIsHiddenAttribute($isHidden)
    {
        $this->attributes['is_hidden'] = !$isHidden ? 'no' : 'yes';
    }

    /**
     * Get view options
     *
     * @param  string $view_options
     * @return array
     */
    public function getViewOptionsAttribute($view_options)
    {
        if (!is_string($view_options)) {
            return $view_options;
        }

        return unserialize($view_options);
    }

    /**
     * Set view options
     *
     * @param array $view_options
     */
    public function setViewOptionsAttribute($view_options)
    {
        $this->attributes['view_options'] = serialize($view_options);
    }

    /**
     * Get permissions attribute
     *
     * @param  string $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        return unserialize($permissions);
    }

    /**
     * Set permissions
     *
     * @param array $permissions
     */
    public function setPermissionsAttribute($permissions)
    {
        $this->attributes['permissions'] = serialize($permissions);
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->stream_prefix . $this->stream_slug;
    }

    /**
     * Span new class
     *
     * @return object
     */
    public function assignments()
    {
        return $this->hasMany('Pyro\Module\Streams\Field\FieldAssignmentModel', 'stream_id')->orderBy('sort_order');
    }
}
