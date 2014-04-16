<?php namespace Pyro\Module\Streams\Field;

use Illuminate\Support\Str;
use Pyro\Model\Eloquent;
use Pyro\Module\Streams\Entry\EntryModel;
use Pyro\Module\Streams\Exception\EmptyFieldNameException;
use Pyro\Module\Streams\Exception\EmptyFieldNamespaceException;
use Pyro\Module\Streams\Exception\EmptyFieldSlugException;
use Pyro\Module\Streams\Exception\FieldModelNotFoundException;
use Pyro\Module\Streams\Exception\InvalidFieldModelException;
use Pyro\Module\Streams\Exception\InvalidFieldTypeException;
use Pyro\Module\Streams\Exception\InvalidStreamModelException;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamModel;

class FieldModel extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'data_fields';

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Stream
     *
     * @var object
     */
    protected $_stream = null;

    protected $_type = null;

    /**
     * Add fields
     *
     * @param array  $fields             The array of fields
     * @param string $assign_stream_slug The optional stream slug to assign all fields. Avoids the need to add it individually.
     * @param string $namespace          The optional namespace for all fields. Avoids the need to add it individually.
     * @return bool
     */
    public static function addFields($fields = array(), $assign_stream_slug = null, $namespace = null)
    {
        if (empty($fields)) {
            return false;
        }

        $success = true;

        foreach ($fields as $field) {
            if ($assign_stream_slug) {
                $field['assign'] = $assign_stream_slug;
            }

            if ($namespace) {
                $field['namespace'] = $namespace;
            }

            if (!static::addField($field)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Add field
     *
     * @param   array - field_data
     * @return  object|bool
     */
    public static function addField($field)
    {
        extract($field);

        // -------------------------------------
        // Validate Data
        // -------------------------------------

        // Do we have a field name?
        if (!isset($name) or !trim($name)) {
            $name = "lang:{$namespace}.field.{$slug}.name";
        }

        // Do we have a field slug?
        if (!isset($slug) or !trim($slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($namespace) or !trim($namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        // Is this stream slug already available?
        if ($field = static::findBySlugAndNamespace($slug, $namespace)) {
            log_message(
                'debug',
                'The Field slug is already in use for this namespace. Attempted [' . $slug . ',' . $namespace . ']'
            );

            return false;
        }

        // Is this a valid field type?
        if (!isset($type) or !FieldTypeManager::getType($type)) {
            throw new InvalidFieldTypeException('Invalid field type. Attempted [' . $type . ']');
        }

        // Set is_locked
        $isLocked = (isset($is_locked) and $is_locked === true) ? 'yes' : 'no';

        // Set extra
        if (!isset($extra) or !is_array($extra)) {
            $extra = array();
        }

        // -------------------------------------
        // Create Field
        // -------------------------------------

        $attributes = array(
            'field_name'      => $name,
            'field_slug'      => $slug,
            'field_type'      => $type,
            'field_namespace' => $namespace,
            'field_data'      => $extra,
            'is_locked'       => $isLocked
        );

        if (!$field = static::create($attributes)) {
            return false;
        }

        // -------------------------------------
        // Assignment (Optional)
        // -------------------------------------

        if (isset($assign) and $assign != '' and $stream = StreamModel::findBySlugAndNamespace(
                $assign,
                $namespace,
                true
            )
        ) {
            $data = array();

            // Title column
            $data['title_column'] = isset($title_column) ? $title_column : false;

            // Instructions
            $data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;

            // Is Unique
            $data['is_unique'] = isset($is_unique) ? $is_unique : false;

            // Is Required
            $data['is_required'] = isset($is_required) ? $is_required : false;

            // Add actual assignment
            return $stream->assignField($field, $data);
        }

        return $field;
    }

    /**
     * Get a single field by the field slug
     *
     * @param   string field slug
     * @param   string field namespace
     * @return  object
     */
    public static function findBySlugAndNamespace($field_slug = null, $field_namespace = null)
    {
        return static::where('field_slug', $field_slug)
            ->where('field_namespace', $field_namespace)
            ->take(1)
            ->first();
    }

    /**
     * Assign field to stream
     *
     * @param   string - namespace
     * @param   string - stream slug
     * @param   string - field slug
     * @param   array  - assign data
     * @return  mixed - false or assignment ID
     */
    public static function assignField($stream_slug, $namespace, $field_slug, $assign_data = array())
    {
        // -------------------------------------
        // Validate Data
        // -------------------------------------
        if (!$field = static::findBySlugAndNamespace($field_slug, $namespace)) {
            throw new InvalidFieldModelException('Invalid field slug. Attempted [' . $field_slug . ']');
        }

        if ($stream = StreamModel::findBySlugAndNamespaceOrFail($stream_slug, $namespace)) {
            // -------------------------------------
            // Assign Field
            // -------------------------------------

            // Add actual assignment
            return $stream->assignField($field, $assign_data);
        }

        return false;
    }

    /**
     * De-assign field
     * This also removes the actual column
     * from the database.
     *
     * @param   string - namespace
     * @param   string - stream slug
     * @param   string - field slug
     * @return  bool
     */
    public static function deassignField($namespace, $stream_slug, $field_slug)
    {
        // -------------------------------------
        // Validate Data
        // -------------------------------------

        if (!$stream = StreamModel::findBySlugAndNamespace($stream_slug, $namespace)) {
            throw new InvalidStreamModelException('Invalid stream slug. Attempted [' . $stream_slug . ',' . $namespace . ']');
        }

        if (!$field = static::findBySlugAndNamespace($field_slug, $namespace)) {
            throw new InvalidFieldModelException('Invalid field slug. Attempted [' . $field_slug . ']');
        }

        // -------------------------------------
        // De-assign Field
        // -------------------------------------

        return $stream->removeFieldAssignment($field);
    }

    /**
     * Delete field
     *
     * @param   string - field slug
     * @param   string - field namespace
     * @return  bool
     */
    public static function deleteField($field_slug, $namespace)
    {
        // Do we have a field slug?
        if (!isset($field_slug) or !trim($field_slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($namespace) or !trim($namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        if (!$field = static::findBySlugAndNamespace($field_slug, $namespace)) {
            return false;
        }

        return $field->delete();
    }

    /**
     * Update field
     *
     * @param   string - slug
     * @param   array  - new data
     * @return  bool
     */
    public static function updateField(
        $field_slug,
        $field_namespace,
        $field_name = null,
        $field_type = null,
        $field_data = array()
    ) {
        // Do we have a field slug?
        if (!isset($field_slug) or !trim($field_slug)) {
            throw new EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if (!isset($field_namespace) or !trim($field_namespace)) {
            throw new EmptyFieldNamespaceException;
        }

        // Find the field by slug and namespace or throw an exception
        if (!$field = static::findBySlugAndNamespace($field_slug, $field_namespace)) {
            return false;
        }

        // Is this a valid field type?
        if (isset($field_type) and !FieldTypeManager::getType($field_type)) {
            throw new InvalidFieldTypeException('Invalid field type. Attempted [' . $type . ']');
        }

        return $field->update($field_data);
    }

    /**
     * Get assigned fields for
     * a stream.
     *
     * @param   string - field slug
     * @param   string - namespace
     * @return  object
     */
    public static function getFieldAssignments($field_slug, $namespace)
    {
        // Do we have a field slug?
        if (!isset($field_slug) or !trim($field_slug)) {
            throw new EmptyFieldSlugException;
        }

        if (!$field = static::findBySlugAndNamespace($field_slug, $namespace)) {
            return false;
        }

        return $field->assignments;
    }

    /**
     * Insert a field
     *
     * @param   string - the field name
     * @param   string - the field slug
     * @param   string - the field type
     * @param   [array - any extra data]
     * @return  bool
     */
    // $field_name, $field_slug, $field_type, $field_namespace, $extra = array(), $isLocked = 'no'
    /**
     * Tear down assignment + field combo
     * Usually we'd just delete the assignment,
     * but we need to delete the field as well since
     * there is a 1-1 relationship here.
     *
     * @param   int  - assignment id
     * @param   bool - force delete field, even if it is shared with multiple streams
     * @return  bool - success/fail
     */
    public static function teardownFieldAssignment($assign_id, $force_delete = false)
    {
        // Get the assignment
        if ($assignment = FieldAssignmentModel::find($assign_id)) {
            // Get stream
            if (!$stream = $assignment->stream) {
                return false;
            }

            // Get field
            if (!$field = $assignment->field) {
                return false;
            }

            // Delete the assignment
            $stream->removeFieldAssignment($field);

            // Remove the field only if unlocked and has no assingments
            if (!$field->is_locked or $field->assignments->isEmpty() or $force_delete) {
                // Remove the field
                return $field->delete();
            }
        }
    }

    /**
     * Count fields
     *
     * @return int
     */
    public static function countByNamespace($field_namespace = null)
    {
        if (!$field_namespace) {
            return 0;
        }

        return static::where('field_namespace', $field_namespace)->count();
    }

    /**
     * Cleanup stale fields that have no assignments
     *
     * @return [type] [description]
     */
    public static function cleanup()
    {
        $field_ids = FieldAssignmentModel::all()->getFieldIds();

        if (!$field_ids) {
            return true;
        }

        return static::whereNotIn('id', $field_ids)->delete();
    }

    /**
     * Delete fields by namespace
     *
     * @param  string $namespace
     * @return object
     */
    public static function deleteByNamespace($namespace)
    {
        return static::where('field_namespace', $namespace)->delete();
    }

    /**
     * Find by slug and namespace (or false)
     *
     * @param  string $field_slug
     * @param  string $field_namespace
     * @return mixed                  Object or false if none found
     */
    public static function findBySlugAndNamespaceOrFail($field_slug = null, $field_namespace = null)
    {
        if (!is_null($model = static::findBySlugAndNamespace($field_slug, $field_namespace))) {
            return $model;
        }

        throw new FieldModelNotFoundException;
    }

    /**
     * Find many by namespace
     *
     * @param  string  $field_namespace
     * @param  integer $limit
     * @param  integer $offset
     * @param  array   $skips
     * @return array
     */
    public static function findManyByNamespace(
        $field_namespace = null,
        $limit = null,
        $offset = null,
        array $skips = null
    ) {
        $query = static::where('field_namespace', '=', $field_namespace);

        if (!empty($skips)) {
            $query = $query->whereNotIn('field_slug', $skips);
        }

        if ($limit > 0) {
            $query = $query->take($limit)->skip($offset);
        }

        return $query->get();
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Pyro\Module\Streams\static|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }

        throw new FieldModelNotFoundException;
    }

    public static function getFieldOptions($skips = array())
    {
        if (is_string($skips)) {
            $skips = array($skips);
        }

        if (!empty($skips)) {
            return static::whereNotIn('field_slug', $skips)->lists('field_name', 'id');
        } else {
            return static::lists('field_name', 'id');
        }
    }

    /**
     * Get field namespace options
     *
     * @return array
     */
    public static function getFieldNamespaceOptions()
    {
        return static::all()->getFieldNamespaceOptions();
    }


    public function save(array $options = array())
    {
        $attributes = $this->getAttributes();

        // Load the type to see if there are other params
        if ($type = $this->getType()) {
            $type->setPreSaveParameters($attributes);

            foreach ($type->getCustomParameters() as $param) {
                if (method_exists(
                        $type,
                        Str::studly('param_' . $param . '_pre_save')
                    ) and $value = $type->getPreSaveParameter($param)
                ) {
                    $attributes['field_data'][$param] = $type->{Str::studly('param_' . $param . '_pre_save')}($value);
                }
            }
        }

        return parent::save($options);
    }

    /**
     * Get the corresponding field type instance
     *
     * @param  [type] $entry [description]
     * @return [type]        [description]
     */
    public function getType($entry = null)
    {
        // If no entry was passed at least instantiate an empty entry object

        if (!$type = FieldTypeManager::getType($this->field_type)) {
            return false;
        }

        if (!$entry) {
            $entry = new EntryModel;
        }

        if ($type) {
            $type->setField($this);
            $type->setEntry($entry);
            $type->setStream($entry->getStream());
        }

        return $type;
    }

    /**
     * Get a stream that was set on the field model
     *
     * @return object|null
     */
    public function getStream()
    {
        return $this->_stream;
    }

    /**
     * Set stream
     *
     * @param object
     */
    public function setStream(StreamModel $stream = null)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Update field
     *
     * @param   obj
     * @param   array - data
     * @param   int
     */
    public function update(array $attributes = array())
    {

        $field_type = $this->getAttribute('field_type');

        $type = $this->getType();

        // -------------------------------------
        // Alter Columns
        // -------------------------------------
        // We want to change columns if the
        // following change:
        //
        // * Field Type
        // * Field Slug
        // * Max Length
        // * Default Value
        // -------------------------------------

        // Eager load assignments with their related stream
        $this->load('assignments.stream');

        $assignments = $this->getAttribute('assignments');

        $field_data = $this->getAttribute('field_data');

        $field_slug = $this->getAttribute('field_slug');

        $attributes['field_slug'] = isset($attributes['field_slug']) ? $attributes['field_slug'] : null;

        $from = $field_slug;
        $to   = $attributes['field_slug'];

        if (
            (isset($attributes['field_type']) and $field_type != $attributes['field_type']) or
            (isset($attributes['field_slug']) and $field_slug != $attributes['field_slug']) or
            (isset($field_data['max_length']) and $field_data['max_length'] != $attributes['max_length']) or
            (isset($field_data['default_value']) and $field_data['default_value'] != $attributes['default_value'])
        ) {
            // If so, we need to update some table columns
            // Get the field assignments and change the table names

            // Check first to see if there are any assignments
            if (!$assignments->isEmpty()) {

                $schema = ci()->pdb->getSchemaBuilder();

                $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

                $streams = array();

                foreach ($assignments as $assignment) {
                    if (!method_exists($type, 'alt_rename_column')) {
                        if ($to and $from != $to) {
                            $schema->table(
                                $prefix . $assignment->stream->stream_prefix . $assignment->stream->stream_slug,
                                function ($table) use ($from, $to) {
                                    $table->renameColumn($from, $to);
                                }
                            );
                        }
                    }

                    if ($assignment->stream and isset($assignment->stream->view_options[$field_slug])) {
                        $assignment->stream->view_options[$field_slug] = $attributes['field_slug'];
                        $assignment->stream->save();
                    }
                }

                // Run though alt rename column routines. Needs to be done
                // after the above loop through assignments.
                foreach ($assignments as $assignment) {
                    if (method_exists($type, 'alt_rename_column')) {
                        // We run a different function for alt_process
                        $type->alt_rename_column($this, $assignment->stream, $assignment);
                    }
                }
            }
        }

        // Run edit field update hook
        if (method_exists($type, 'update_field')) {
            $type->update_field($this, $assignments);
        }

        // Gather extra data
        foreach ($type->getCustomParameters() as $param) {
            if (method_exists($type, Str::studly('param_' . $param . '_pre_save'))) {
                $field_data[$param] = $type->{Str::studly('param_' . $param . '_pre_save')}($this);
            }
        }

        $attributes['field_data'] = $field_data;

        if (parent::update($attributes)) {
            if (!$assignments->isEmpty() and $to and $from != $to) {
                StreamModel::updateTitleColumnByStreamIds($assignments->getStreamIds(), $from, $to);
            }

            return true;
        } else {
            // Boo.
            return false;
        }
    }

    /**
     * Delete a field
     *
     * @param   int
     * @return  bool
     */
    public function delete()
    {
        if ($success = parent::delete()) {
            // Find assignments, and delete rows from table
            if ($assignments = $this->getAttribute('assignments') and !$assignments->isEmpty()) {
                // Delete assignments
                FieldAssignmentModel::cleanup();
                // Reset instances where the title column
                // is the field we are deleting. PyroStreams will
                // always just use the ID in place of the field.

                $title_column = $this->getAttribute('field_slug');

                StreamModel::updateTitleColumnByStreamIds($assignments->getStreamIds(), $title_column);
            }
        }

        return $success;
    }

    /**
     * Get the field
     *
     * @return object
     */
    public function getParameter($key, $default = null)
    {
        $parameter = isset($this->field_data[$key]) ? $this->field_data[$key] : $default;

        // Check for empty string
        if (empty($parameter)) {
            return null;
        }

        return $parameter;
    }


    /**
     * New collection instance
     *
     * @param  array $models
     * @return object
     */
    public function newCollection(array $models = array())
    {
        return new FieldCollection($models);
    }

    /**
     * assignments
     *
     * @return boolean
     */
    public function assignments()
    {
        return $this->hasMany('Pyro\Module\Streams\Field\FieldAssignmentModel', 'field_id');
    }

    /**
     * Get field name attr
     *
     * @param  strign $field_name
     * @return string
     */
    public function getFieldNameAttribute($field_name)
    {
        // This guarantees that the language will be loaded
        FieldTypeManager::getType($this->getAttribute('field_type'));

        $name = lang($field_name);

        if (empty($name)) {
            $name = lang_label($field_name);
        }

        return $name;
    }

    /**
     * Set field data attr
     *
     * @param array $field_data
     */
    public function setFieldDataAttribute($field_data)
    {
        if (is_array($field_data)) {

            /**
             * Allow a chance to return values in Closures
             */
            foreach ($field_data as &$value) {
                $value = value($value);
            }

            $this->attributes['field_data'] = serialize($field_data);
        } else {
            $this->attributes['field_data'] = $field_data;
        }
    }

    /**
     * Get field data attr
     *
     * @param  string $field_data
     * @return array
     */
    public function getFieldDataAttribute($field_data)
    {
        if (is_string($field_data)) {
            return unserialize($field_data);
        }

        return $field_data;
    }

    /**
     * Get view options attr
     *
     * @param  string $view_options
     * @return array
     */
    public function getViewOptionsAttribute($view_options)
    {
        if (is_string($view_options)) {
            return unserialize($view_options);
        }

        return $view_options;
    }

    /**
     * Set view options attr
     *
     * @param array $view_options
     */
    public function setViewOptionsAttribute($view_options)
    {
        if (is_array($view_options)) {
            $this->attributes['view_options'] = serialize($view_options);
        } else {
            $this->attributes['view_options'] = $view_options;
        }
    }

    /**
     * Get is is_locked attr
     *
     * @param  string $isLocked
     * @return boolean
     */
    public function getIsLockedAttribute($isLocked)
    {
        return $isLocked;
    }

    /**
     * Set is_unlocked attr
     *
     * @param string $isLocked
     */
    public function setIsLockedAttribute($isLocked)
    {
        $this->attributes['is_locked'] = $isLocked;
    }

    /**
     * Is field name "lang:" prefixed?
     *
     * @return boolean
     */
    public function isFieldNameLang()
    {
        return substr($this->getOriginal('field_name'), 0, 5) === 'lang:';
    }
}
