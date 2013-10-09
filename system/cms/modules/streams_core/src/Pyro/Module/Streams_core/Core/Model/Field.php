<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Field\Type;

class Field extends Eloquent
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
        if ($type = Type::getLoader()->getType($attributes['field_type']))
        {
            $type->setPreSaveParameters($attributes);

            foreach ($type->getCustomParameters() as $param)
            {
                if (method_exists($type, 'param_'.$param.'_pre_save') and $value = $type->getPreSaveParameter($param))
                {
                    $attributes['field_data'][$param] = $type->{'param_'.$param.'_pre_save'}( $value );
                }
            }
        }

        return parent::create($attributes);
    }

    /**
     * Get the corresponding field type instance
     * @param  [type] $entry [description]
     * @return [type]        [description]
     */
    public function getType(Entry $entry = null)
    {
        // If no entry was passed at least instantiate an empty entry object
        if ( ! $entry)
        {
            $entry = new Entry;
        }

        // @todo - replace the Type library with the PSR version
        if ( ! $type = Type::getLoader()->getType($this->getAttribute('field_type')))
        {
            return false;
        }

        $type->setField($this);

        if ($entry)
        {
            $type->setEntry($entry);
            
            $type->setStream($entry->getModel()->getStream());

            $type->setModel($entry->getModel());
            
            $type->setEntryBuilder($entry->getModel()->newQuery());
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
            if (method_exists($type, 'param_'.$param.'_pre_save')) {
                $field_data[$param] = $type->{'param_'.$param.'_pre_save'}( $this );
            }
        }

        $attributes['field_data'] = $field_data;

        if (parent::update($attributes))
        {
            if ( ! $assignments->isEmpty() and $to and $from != $to)
            {
                Stream::updateTitleColumnByStreamIds($assignments->getStreamIds(), $from, $to);                
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
                FieldAssignment::cleanup();
                // Reset instances where the title column
                // is the field we are deleting. PyroStreams will
                // always just use the ID in place of the field.
                
                $title_column = $this->getAttribute('field_slug');

                Stream::updateTitleColumnByStreamIds($assignments->getStreamIds(), $title_column);
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
        $field_ids = FieldAssignment::all()->getFieldIds();

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

        throw new Exception\FieldNotFoundException;
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
     * @return \Pyro\Module\Streams_core\Core\Model\Field|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if ( ! is_null($model = static::find($id, $columns))) return $model;

        throw new Exception\FieldNotFoundException;
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
     * New collection instance
     * @param  array  $models
     * @return object         
     */
    public function newCollection(array $models = array())
    {
        return new Collection\FieldCollection($models);
    }

    /**
     * assignments
     * @return boolean
     */
    public function assignments()
    {
        return $this->hasMany(__NAMESPACE__.'\FieldAssignment', 'field_id');
    }

    /**
     * Streams
     * @return boolean
     */
    public function streams()
    {
        return $this->belongsToMany('Pyro\Module\Streams_core\Core\Model\Stream');
    }

    /**
     * Get field name attr
     * @param  strign $field_name
     * @return string
     */
    public function getFieldNameAttribute($field_name)
    {
        // This guarantees that the language will be loaded
       Type::getLoader()->getType($this->getAttribute('field_type'));

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
