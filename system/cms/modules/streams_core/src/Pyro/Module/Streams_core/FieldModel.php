<?php namespace Pyro\Module\Streams_core;

use Pyro\Model\Eloquent;
use Illuminate\Support\Str;

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
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Stream
     * @var object
     */
    public $stream = null;

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
        if ( ! isset($name) or ! trim($name))
        {
            throw new Exception\EmptyFieldNameException;
        }           

        // Do we have a field slug?
        if( ! isset($slug) or ! trim($slug))
        {
            throw new Exception\EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if( ! isset($namespace) or ! trim($namespace))
        {
            throw new Exception\EmptyFieldNamespaceException;   
        }
        
        // Is this stream slug already available?
        if ($field = static::findBySlugAndNamespace($slug, $namespace))
        {
            throw new Exception\FieldSlugInUseException('The Field slug is already in use for this namespace. Attempted ['.$slug.','.$namespace.']');
        }

        if (! class_exists('Module_import'))
        {
            // Is this a valid field type?
            if ( ! isset($type) or ! FieldTypeManager::getType($type))
            {
                throw new Exception\InvalidFieldTypeException('Invalid field type. Attempted ['.$type.']');
            }            
        }

        // Set locked 
        $locked = (isset($locked) and $locked === true) ? 'yes' : 'no';
        
        // Set extra
        if ( ! isset($extra) or ! is_array($extra)) $extra = array();
    
        // -------------------------------------
        // Create Field
        // -------------------------------------

        $attributes = array(
            'field_name' => $name,
            'field_slug' => $slug,
            'field_type' => $type,
            'field_namespace' => $namespace,
            'field_data' => $extra,
            'is_locked' => $locked
        );

        if ( ! $field = static::create($attributes)) return false;

        // -------------------------------------
        // Assignment (Optional)
        // -------------------------------------

        if (isset($assign) and $assign != '' and $stream = StreamModel::findBySlugAndNamespace($assign, $namespace))
        {
            $data = array();
        
            // Title column
            $data['title_column'] = isset($title_column) ? $title_column : false;

            // Instructions
            $data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;
            
            // Is Unique
            $data['is_unique'] = isset($unique) ? $unique : false;
            
            // Is Required
            $data['is_required'] = isset($required) ? $required : false;
        
            // Add actual assignment
            return $stream->assignField($field, $data);
        }
        
        return $field;
    }

    /**
     * Add fields
     * @param array  $fields             The array of fields
     * @param string $assign_stream_slug The optional stream slug to assign all fields. Avoids the need to add it individually.
     * @param string $namespace          The optional namespace for all fields. Avoids the need to add it individually.
     * @return bool
     */
    public static function addFields($fields = array(), $assign_stream_slug = null, $namespace = null)
    {
        if (empty($fields)) return false;

        $success = true;

        foreach ($fields as $field)
        {
            if ($assign_stream_slug)
            {
                $field['assign'] = $assign_stream_slug;
            }

            if ($namespace)
            {
                $field['namespace'] = $namespace;
            }

            if( ! static::addField($field))
            {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Assign field to stream
     *
     * @param   string - namespace
     * @param   string - stream slug
     * @param   string - field slug
     * @param   array - assign data
     * @return  mixed - false or assignment ID
     */
    public static function assignField($stream_slug, $namespace, $field_slug, $assign_data = array())
    {
        // -------------------------------------
        // Validate Data
        // -------------------------------------

        $stream = StreamModel::findBySlugAndNamespaceOrFail($stream_slug, $namespace);
        
        if ( ! $field = static::findBySlugAndNamespace($field_slug, $namespace))
        {
            throw new Exception\InvalidFieldModelException('Invalid field slug. Attempted ['.$field_slug.']');
        }

        // -------------------------------------
        // Assign Field
        // -------------------------------------
    
        // Add actual assignment
        return $stream->assignField($field, $assign_data);
    }

    /**
     * De-assign field
     *
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

        if ( ! $stream = StreamModel::findBySlugAndNamespace($stream_slug, $namespace))
        {
            throw new Exception\InvalidStreamModelException('Invalid stream slug. Attempted ['.$stream_slug.','.$namespace.']');
        }

        if ( ! $field = static::findBySlugAndNamespace($field_slug, $namespace))
        {
            throw new Exception\InvalidFieldModelException('Invalid field slug. Attempted ['.$field_slug.']');
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
        if( ! isset($field_slug) or ! trim($field_slug))
        {
            throw new Exception\EmptyFieldSlugException;
        }
        
        // Do we have a namespace?
        if( ! isset($namespace) or ! trim($namespace))
        {
            throw new Exception\EmptyFieldNamespaceException;   
        }

        if ( ! $field = static::findBySlugAndNamespace($field_slug, $namespace)) return false;
    
        return $field->delete();
    }

    /**
     * Update field
     *
     * @param   string - slug
     * @param   array - new data
     * @return  bool
     */
    public static function updateField($field_slug, $field_namespace, $field_name = null, $field_type = null, $field_data = array())
    {
        // Do we have a field slug?
        if( ! isset($field_slug) or ! trim($field_slug))
        {
            throw new Exception\EmptyFieldSlugException;
        }

        // Do we have a namespace?
        if( ! isset($field_namespace) or ! trim($field_namespace))
        {
            throw new Exception\EmptyFieldNamespaceException;   
        }
    
        // Find the field by slug and namespace or throw an exception
        if ( ! $field = static::findBySlugAndNamespace($field_slug, $field_namespace)) return false;

        if (! class_exists('Module_import'))
        {
            // Is this a valid field type?
            if (isset($field_type) and ! FieldTypeManager::getType($field_type))
            {
                throw new Exception\InvalidFieldTypeException('Invalid field type. Attempted ['.$type.']');
            }
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
        if( ! isset($field_slug) or ! trim($field_slug))
        {
            throw new Exception\EmptyFieldSlugException;
        }
    
        if ( ! $field = static::findBySlugAndNamespace($field_slug, $namespace)) return false;
    
        return $field->assignments;
    }

    /**
     * Tear down assignment + field combo
     *
     * Usually we'd just delete the assignment,
     * but we need to delete the field as well since
     * there is a 1-1 relationship here.
     *
     * @param   int - assignment id
     * @param   bool - force delete field, even if it is shared with multiple streams
     * @return  bool - success/fail
     */
    public static function teardownFieldAssignment($assign_id, $force_delete = false)
    {
        // Get the assignment
        if ($assignment = FieldAssignmentModel::find($assign_id))
        {
            // Get stream
            if ( ! $stream = $assignment->stream)
            {
                return false;
            }

            // Get field
            if ( ! $field = $assignment->field)
            {
                return false;
            }

            // Delete the assignment
            $stream->removeFieldAssignment($field);
            
            // Remove the field only if unlocked and has no assingments
            if ( ! $field->is_locked or $field->assignments->isEmpty() or $force_delete)
            {
                // Remove the field
                return $field->delete();
            }           
        }
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
    // $field_name, $field_slug, $field_type, $field_namespace, $extra = array(), $locked = 'no'
    public static function create(array $attributes = array())
    {
        $instance = new static;

        // Load the type to see if there are other params
        if ($type = FieldTypeManager::getType($attributes['field_type']))
        {
            $type->setPreSaveParameters($attributes);

            foreach ($type->getCustomParameters() as $param)
            {
                if (method_exists($type, Str::studly('param_'.$param.'_pre_save')) and $value = $type->getPreSaveParameter($param))
                {
                    $attributes['field_data'][$param] = $type->{Str::studly('param_'.$param.'_pre_save')}( $value );
                }
            }
        }

        return parent::create($attributes);
    }

    public function setStream(StreamModel $stream = null)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the corresponding field type instance
     * @param  [type] $entry [description]
     * @return [type]        [description]
     */
    public function getType(EntryModel $entry = null, StreamModel $stream = null)
    {
        // If no entry was passed at least instantiate an empty entry object
        if ( ! $entry)
        {
            $entry = new EntryModel;
        }

        // @todo - replace the Type library with the PSR version
        if ( ! $type = FieldTypeManager::getType($this->getAttribute('field_type')))
        {
            return false;
        }

        $type->setField($this);
        $type->setEntry($entry);

        if ( ! $stream and $this->stream)
        {
            $type->setStream($this->stream);
        }
        elseif ($stream)
        {
            $type->setStream($stream);
        }
        elseif ($entry instanceof EntryModel)
        {   
            if ( ! $stream and ! $this->stream)
            {
                $type->setStream($entry->getModel()->getStream());
            }
        }

        return $type;
    }

    // --------------------------------------------------------------------------

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
        $to = $attributes['field_slug'];

        if(
            (isset($attributes['field_type']) and $field_type != $attributes['field_type']) or 
            (isset($attributes['field_slug']) and $field_slug != $attributes['field_slug']) or
            (isset($field_data['max_length']) and $field_data['max_length'] != $attributes['max_length']) or
            (isset($field_data['default_value']) and $field_data['default_value'] != $attributes['default_value'])
        )
        {
            // If so, we need to update some table columns
            // Get the field assignments and change the table names

            // Check first to see if there are any assignments
            if ( ! $assignments->isEmpty()) {

                $schema = ci()->pdb->getSchemaBuilder();

                $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

                $streams = array();

                foreach ($assignments as $assignment)
                {
                    if ( ! method_exists($type, 'alt_rename_column'))
                    {
                        if ( $to and $from != $to)
                        {
                            $schema->table($prefix.$assignment->stream->stream_prefix.$assignment->stream->stream_slug, function ($table) use ($from, $to) {
                                $table->renameColumn($from, $to);
                            });                            
                        }
                    }

                    if ($assignment->stream and isset($assignment->stream->view_options[$field_slug]))
                    {
                        $assignment->stream->view_options[$field_slug] = $attributes['field_slug'];
                        $assignment->stream->save();
                    }
                }
                
                // Run though alt rename column routines. Needs to be done
                // after the above loop through assignments.
                foreach ($assignments as $assignment)
                {
                    if (method_exists($type, 'alt_rename_column'))
                    {
                        // We run a different function for alt_process
                        $type->alt_rename_column($this, $assignment->stream, $assignment);
                    }
                }
            }
        }

        // Run edit field update hook
        if (method_exists($type, 'update_field'))
        {
            $type->update_field($this, $assignments);
        }
    
        // Gather extra data
        foreach ($type->getCustomParameters() as $param)
        {
            if (method_exists($type, Str::studly('param_'.$param.'_pre_save'))) {
                $field_data[$param] = $type->{Str::studly('param_'.$param.'_pre_save')}( $this );
            }
        }

        $attributes['field_data'] = $field_data;

        if (parent::update($attributes))
        {
            if ( ! $assignments->isEmpty() and $to and $from != $to)
            {
                StreamModel::updateTitleColumnByStreamIds($assignments->getStreamIds(), $from, $to);                
            }

            return true;
        }
        else {
            // Boo.
            return false;
        }
    }

    /**
     * Count fields
     *
     * @return int
     */
    public static function countByNamespace($field_namespace = null)
    {
        if ( ! $field_namespace) return 0;

        return static::where('field_namespace', $field_namespace)->count();
    }

    /**
     * Delete a field
     *
     * @param   int
     * @return  bool
     */
    public function delete()
    {
        if ($success = parent::delete())
        {
            // Find assignments, and delete rows from table
            if ($assignments = $this->getAttribute('assignments') and ! $assignments->isEmpty())
            {
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
     * Cleanup stale fields that have no assignments
     * @return [type] [description]
     */
    public static function cleanup()
    {
        $field_ids = FieldAssignmentModel::all()->getFieldIds();

        return static::whereNotIn('id', $field_ids)->delete();
    }
    
    /**
     * Delete fields by namespace
     * @param  string $namespace
     * @return object
     */
    public static function deleteByNamespace($namespace)
    {
        return static::where('field_namespace', $namespace)->delete();
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
     * Find by slug and namespace (or false)
     * @param  string $field_slug      
     * @param  string $field_namespace 
     * @return mixed                  Object or false if none found
     */
    public static function findBySlugAndNamespaceOrFail($field_slug = null, $field_namespace = null)
    {
        if ( ! is_null($model = static::findBySlugAndNamespace($field_slug, $field_namespace))) return $model;

        throw new Exception\staticNotFoundException;
    }

    /**
     * Find many by namespace
     * @param  string $field_namespace 
     * @param  integer $limit           
     * @param  integer $offset          
     * @param  array $skips           
     * @return array                  
     */
    public static function findManyByNamespace($field_namespace = null, $limit = null, $offset = null, array $skips = null)
    {
        $query = static::where('field_namespace', '=', $field_namespace);

        if ( ! empty($skips))
        {
            $query = $query->whereNotIn('field_slug', $skips);
        }

        return $query->skip($offset)->take($limit)->get();
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Pyro\Module\Streams_core\static|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if ( ! is_null($model = static::find($id, $columns))) return $model;

        throw new Exception\staticNotFoundException;
    }

    public static function getFieldOptions($skips = array())
    {
        if (is_string($skips))
        {
            $skips = array($skips);
        }

        if ( ! empty($skips))
        {
            return static::whereNotIn('field_slug', $skips)->lists('field_name', 'id');    
        }
        else
        {
            return static::lists('field_name', 'id'); 
        }
    }

    /**
     * Get field namespace options
     * @return array
     */
    public static function getFieldNamespaceOptions()
    {
        return static::all()->getFieldNamespaceOptions();
    }

    /**
     * Get the field
     * @return object 
     */
    public function getParameter($key, $default = null)
    {
        return isset($this->field_data[$key]) ? $this->field_data[$key] : $default;
    }

    /**
     * New collection instance
     * @param  array  $models
     * @return object         
     */
    public function newCollection(array $models = array())
    {
        return new FieldCollection($models);
    }

    /**
     * assignments
     * @return boolean
     */
    public function assignments()
    {
        return $this->hasMany('Pyro\Module\Streams_core\FieldAssignmentModel', 'field_id');
    }

    /**
     * Get field name attr
     * @param  strign $field_name
     * @return string
     */
    public function getFieldNameAttribute($field_name)
    {
        // This guarantees that the language will be loaded
        FieldTypeManager::getType($this->getAttribute('field_type'));

        return lang_label($field_name);
    }

    /**
     * Set field data attr
     * @param array $field_data
     */
    public function setFieldDataAttribute($field_data)
    {
        $this->attributes['field_data'] = serialize($field_data);
    }

    /**
     * Get field data attr
     * @param  string $field_data
     * @return array
     */
    public function getFieldDataAttribute($field_data)
    {
        return unserialize($field_data);
    }

    /**
     * Get view options attr
     * @param  string $view_options
     * @return array               
     */
    public function getViewOptionsAttribute($view_options)
    {
        return unserialize($view_options);
    }

    /**
     * Set view options attr
     * @param array $view_options
     */
    public function setViewOptionsAttribute($view_options)
    {   
        $this->attributes['view_options'] = serialize($view_options);
    }

    /**
     * Get is locked attr
     * @param  string $is_locked
     * @return boolean
     */
    public function getIsLockedAttribute($is_locked)
    {
        return $is_locked == 'yes' ? true : false;
    }

    /**
     * Set is unlocked attr
     * @param string $is_locked
     */
    public function setIsLockedAttribute($is_locked)
    {
        $this->attributes['is_locked'] = ! $is_locked ? 'no' : 'yes';
    }

    /**
     * Is field name "lang:" prefixed?
     * @return boolean
     */
    public function isFieldNameLang()
    {
        return substr($this->getOriginal('field_name'), 0, 5) === 'lang:';
    }
}
