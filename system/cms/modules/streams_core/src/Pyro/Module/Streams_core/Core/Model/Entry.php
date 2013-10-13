<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Search\Model\Search;
use Pyro\Module\Streams_core\Core\Field\Form;

// Eloquent was not designed to talk to different tables from a single model but
// I am tring to bend the rules a little, I think it will be worth it
// Entry would work similar to the old row model
// it will extend eloquent and return collections most of the time
// The idea is for Entry to be used by the Streams core
// but to be extensible by devs so the their modules can act or be a mirror of the corresponding stream
// allowing to set the stream slug, namespace and prefix in the extending model
// and add custom funtionality to it.
// 
// They could override with their own collection or on builder
// 
// while keeping streams working the way they should
// 
// i.e. class Profile extends Entry
// {
// 
//      protected $stream_slug = 'profiles';
//      
//      protected $stream_namespace = 'users';
//      
//      protected $prefix = ''
//      
// }
// 

class Entry extends EntryOriginal
{
    /**
     * Assignments
     * @var array
     */
    protected $assignments = null;

    /**
     * Fields
     * @var array
     */
    protected $fields = null;

    /**
     * Field type instances
     * @var array
     */
    protected $field_type_instances = null;

    /**
     * Unformatted values
     * @var array
     */
    protected $unformatted_values = array();

    /**
     * Unformatted entry
     * @var object
     */
    protected $unformatted_entry = null;

    /**
     * Format or no
     * @var boolean
     */
    protected $format = true;

    /**
     * Plugin or no
     * @var boolean
     */
    protected $plugin = true;

    /**
     * An array of field slugs that will eager load relations
     * @var array
     */
    protected $eager_field_relations = array();

    /**
     * Enable or disable eager loading field type relations
     * @var boolean
     */
    protected $enable_eager_field_relations = false;

    /**
     * Enable or disable field relations for a query
     * @var boolean
     */
    protected $enable_field_relations = false;

    /**
     * Search index template
     * @var mixed The configuration array or false
     */
    protected $search_index_template = false;

    /**
     * Plugin values
     * @var array
     */
    protected $plugin_values = array();

    /**
     * View options
     * @var array
     */
    protected $view_options = array();

    /**
     * Load a stream
     * @param  string $stream_slug
     * @param  string $stream_namespace
     * @param  object $instance
     * @return object
     */
    public static function stream($stream_slug, $stream_namespace = null, Entry $instance = null)
    {
        $instance = parent::stream($stream_slug, $stream_namespace, $instance);

        $stream_relations = $instance->stream->getModel()->getRelations();
        
        // Check if the assignments are already loaded
        if ( ! isset($stream_relations['assignments']))
        {
            // Eager load assignments nested with fields 
            $instance->stream->load('assignments.field');    
        }

        $instance->assignments = $instance->stream->getModel()->getRelation('assignments');

        $instance->setFields($instance->assignments->getFields());

        return $instance;
    }

    /**
     * Set fields
     * @param array $fields
     */
    public function setFields(Collection\FieldCollection $fields = null)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get fields
     * @return array
     */
    public function getFields()
    {
        if ($this->fields instanceof Collection\FieldCollection)
        {
            return $this->fields;
        }

        return new Collection\FieldCollection;
    }

    /**
     * Get field
     * @param  string $field_slug
     * @return object
     */
    public function getField($field_slug = '')
    {
        return $this->getFields()->findBySlug($field_slug);
    }

    /**
     * Get entry type
     * @param  string $field_slug
     * @return object
     */
    public function getFieldType($field_slug = '')
    {
        if ( ! $field = $this->getField($field_slug))
        {
            return false;
        }

        return $field->getType($this);
    }

    /**
     * Get field slugs
     * @return array
     */
    public function getFieldSlugs()
    {
        return $this->getFields()->getFieldSlugs();
    }

    /**
     * Set plugin
     * @param boolean $plugin
     */
    public function setPlugin($plugin = true)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Set format
     * @param boolean $format
     */
    public function setFormat($format = true)
    {
        $this->format = $format;

        return $this;
    }

    public function getEagerFieldRelations()
    {
        return $this->eager_field_relations;
    }

    /**
     * Set format
     * @param boolean $format
     */
    public function enableFieldRelations($enable_field_relations = false)
    {
        $this->enable_field_relations = $enable_field_relations;

        return $this;
    }

    /**
     * Enable or disable eager loading of field relations
     * @param boolean $format
     */
    public function enableEagerFieldRelations($enable_eager_field_relations = false)
    {
        $this->enableFieldRelations($enable_eager_field_relations);

        $this->enable_eager_field_relations = $enable_eager_field_relations;

        return $this;
    }

    /**
     * Is formatted
     * @return boolean
     */
    public function isFormat()
    {
        return $this->format;
    }

    /**
     * Is plugin call
     * @return boolean
     */
    public function isPlugin()
    {
        return $this->plugin;
    }

    /**
     * Is field relations enabled
     * @return boolean
     */
    public function isEnableFieldRelations()
    {
        return $this->enable_field_relations;
    }

    /**
     * Is eager loading field relations enabled
     * @return boolean
     */
    public function isEnableEagerFieldRelations()
    {
        return $this->enable_eager_field_relations;
    }

    /**
     * Set eager field relations
     * @param array $field_slugs The array of field slugs
     */
    public function setEagerFieldRelations($field_slugs = array())
    {
        if ($this->isEnableEagerFieldRelations() and empty($this->eager_field_relations))
        {
            $eager_field_relations = array();

            foreach ($field_slugs as $field_slug)
            {
                if ($type = $this->getFieldType($field_slug) and $type->hasRelation())
                {
                    $eager_field_relations[] = $field_slug;
                }
            }

            $this->eager_field_relations = $eager_field_relations;
        }

        return $this;
    }

    /**
     * Set plugin value
     * @param string $key  
     * @param mixed $value
     */
    public function setPluginValue($key = null, $value = null)
    {
        if ($key)
        {
            $this->plugin_values[$key] = $value;   
        }
    }

    /**
     * Get plugin value
     * @param  string $key
     * @return mixed
     */
    public function getPluginValue($key)
    {
        return isset($this->plugin_values[$key]) ? $this->plugin_values[$key] : $this->getAttribute($key);
    }

    /**
     * Set unformatted value
     * @param string $key
     * @param mixed $value
     */
    public function setUnformattedValue($key = null, $value = null)
    {
        if ($key)
        {
            $this->unformatted_values[$key] = $value;   
        }
    }

    /**
     * Get unformatted value
     * @param  string $key
     * @return mixed
     */
    public function getUnformattedValue($key)
    {
        return isset($this->unformatted_values[$key]) ? $this->unformatted_values[$key] : null;
    }

    /**
     * Create a new form builder
     * @return object
     */
    public function newFormBuilder()
    {
        return new \Pyro\Module\Streams_core\Core\Field\Form($this);
    }

    /**
     * Set unformatted uentry
     * @param object $unformatted_entry
     */
    public function setUnformattedEntry($unformatted_entry = null)
    {
        $this->unformatted_entry = $unformatted_entry;

        return $this;
    }

    /**
     * Unformatted
     * @return object
     */
    public function unformatted()
    {
        return $this->unformatted_entry;
    }

    /**
     * Find entry
     * @param  integer $id
     * @param  array  $columns
     * @return object
     */
    public static function find($id, $columns = array('*'))
    {
        $entry = static::$instance->where(static::$instance->getKeyName(), '=', $id)->first($columns);

        $entry->exists = true;

        return $entry;
    }

    /**
     * Being querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function with($relations)
    {
        if (is_string($relations)) $relations = func_get_args();

        return static::$instance->newQuery()->with($relations);
    }

    /**
     * Set search index template
     * @param mixed $search_index_template
     */
    public function setSearchIndexTemplate($search_index_template = false)
    {
        $this->search_index_template = $search_index_template;

        return $this;
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function create(array $attributes = null)
    {
        static::$instance->fill($attributes)->save();

        return static::$instance;
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array(), $skips = array())
    {
        $fields = $this->getFields();

        $insert_data = array();

        $alt_process = array();
        
        $types = array();
        
        // Set some values for a new entry
        if ( ! $this->exists)
        {
            $created_by = (isset(ci()->current_user->id) and is_numeric(ci()->current_user->id)) ? ci()->current_user->id : null;

            $this->setAttribute('created_by', $created_by);
            $this->setAttribute('updated', '0000-00-00 00:00:00');
            $this->setAttribute('ordering_count', $this->count('id')+1);
        }
        else
        {
            $this->setAttribute('updated', time());
        }

        // Reset values if the unformatted entry is available
        if (($unformatted = $this->unformatted()) instanceof Entry)
        {
            if ($this->replicated)
            {
                $attributes = array_except($unformatted->getAttributes(), array($this->getKeyName()));
            }
            else
            {
                $attributes = $unformatted->getAttributes();
            }

            $this->setRawAttributes($attributes);
        }

        if ( ! $fields->isEmpty())
        {
            foreach ($fields as $field)
            {
                // or (in_array($field->field_slug, $skips) and isset($_POST[$field->field_slug]))
                if ( ! in_array($field->field_slug, $skips))
                {

                    $type = $field->getType($this);
                    $types[] = $type;

                    $type->setStream($this->stream);

                    $value = $this->getAttribute($field->field_slug);

                    // We don't process the alt process stuff.
                    // This is for field types that store data outside of the
                    // actual table
                    if ($type->alt_process)
                    {
                        $alt_process[] = $type;
                    }
                    else
                    {
                        if (is_null($value))
                        {
                            $this->setAttribute($field->field_slug, null);
                        }

                        if (method_exists($type, 'pre_save'))
                        {
                            $this->setAttribute($field->field_slug, $type->pre_save());
                        }
                        elseif(is_string($value))
                        {
                            $this->setAttribute($field->field_slug, trim($value));
                        }
                    }
                }
            }
        }


        // -------------------------------------
        // Insert data
        // -------------------------------------

        // Is there any logic to complete before inserting?
        //if ( \Events::trigger('streams_pre_insert_entry', array('stream' => $this->stream, 'insert_data' => $this->getAttributes())) === false ) return false;

         
        // Process any alt process stuff
        foreach ($alt_process as $type)
        {
            $type->pre_save();
        }
        
        // -------------------------------------
        // Event: Post Insert Entry
        // -------------------------------------

        $trigger_data = array(
            'entry_id'      => $this->getKey(),
            'stream'        => $this->stream,
            'insert_data'   => $this->getAttributes()
        );

        \Events::trigger('streams_post_insert_entry', $trigger_data);

        if ($saved = parent::save($options) and $this->search_index_template)
        {
            Search::indexEntry($this, $this->search_index_template);
        }

        return $saved;
    }

    /**
     * Delete de model
     * @return boolean
     */
    public function delete()
    {
        if ( ! $search_index_module = $this->getModuleSlug())
        {
            $search_index_module = $this->getStream()->stream_namespace;
        }

        $search_index_scope = $this->getStreamTypeSlug();

        Search::dropIndex($search_index_module, $search_index_scope, $this->getKey());

        return parent::delete();
    }

    /**
     * Get model slug
     * @return string
     */
    public function getModuleSlug()
    {
        $module = false;

        $entry_class = get_called_class();

        // Try to figure out if the module from an extended entry model
        if ($entry_class != 'Pyro\Module\Streams_core\Core\Model\Entry')
        {
            $folders = explode($entry_class, '\\');

            $module = isset($folders[2]) ? strtolower($folders[2]) : null;

            // Check if this module exists, set to null if it doesn't
            if ( ! module_exists($module))
            {
                $module = false;
            }
        }

        return $module;
    }

    /**
     * Get stream type slug
     * @return string
     */
    public function getStreamTypeSlug()
    {
        $stream = $this->getStream();

        return $stream->stream_slug.'.'.$stream->stream_namespace;
    }

    /**
     * Update ordering count
     * @param  int $ordering_count
     * @return boolean
     */
    public function updateOrderingCount($ordering_count = null)
    {
        return $this->where($this->getKeyName(), $this->getKey())->update(array('ordering_count' => $ordering_count));
    }

    /**
     * Run fields through their pre-process
     *
     * Just used for updating right now
     *
     * @access  public
     * @param   obj
     * @param   string
     * @param   int
     * @param   array - update data
     * @param   skips - optional array of skips
     * @param   bool - set_missing_to_null. Should we set missing pieces of data to null
     *                  for the database?
     * @return  bool
     */
    public static function runFieldPreProcesses($fields, $entry = null, $form_data = array(), $skips = array(), $set_missing_to_null = true)
    {
        $return_data = array();
        
        if ($fields)
        {
            foreach ($fields as $field)
            {
                // If we don't have a post item for this field, 
                // then simply set the value to null. This is necessary
                // for fields that want to run a pre_save but may have
                // a situation where no post data is sent (like a single checkbox)
                if ( ! isset($form_data[$field->field_slug]) and $set_missing_to_null)
                {
                    $form_data[$field->field_slug] = null;
                }

                // If this is not in our skips list, process it.
                if ( ! in_array($field->field_slug, $skips))
                {
                    $type = $field->getType($entry);
                    $type->setFormData($form_data);
        
                    if ( ! $type->alt_process)
                    {
                        // If a pre_save function exists, go ahead and run it
                        if (method_exists($type, 'pre_save'))
                        {
                            $return_data[$field->field_slug] = $type->pre_save();

                            // We are unsetting the null values to as to
                            // not upset db can be null rules.
                            if (is_null($return_data[$field->field_slug]))
                            {
                                unset($return_data[$field->field_slug]);
                            }
                        }
                        else
                        {
                            $return_data[$field->field_slug] = isset($form_data[$type->getFormSlug()]) ? $form_data[$type->getFormSlug()] : null;

                            // Make null - some fields don't like just blank values
                            if ($return_data[$field->field_slug] == '')
                            {
                                $return_data[$field->field_slug] = null;
                            }
                        }
                    }
                    else
                    {
                        // If this is an alt_process, there can still be a pre_save,
                        // it just won't return anything so we don't have to
                        // save the value
                        if (method_exists($type, 'pre_save'))
                        {
                            $type->pre_save();
                        }
                    }
                }
            }   
        }

        return $return_data;
    }

    /**
     * Get all the non-field standard columns for entries as an array
     * @return array An array of standard columns
     */
    public function getStandardColumns()
    {
        return array_merge(array($this->getKeyName()), $this->getDates(), array(static::CREATED_BY));
    }

    /**
     * Get all columns
     * @return array
     */
    public function getAllColumns()
    {
        return array_merge($this->getStandardColumns(), $this->getFieldSlugs());
    }

    /**
     * Get columns exluding
     * @param  array  $columns [description]
     * @return array
     */
    public function getAllColumnsExclude(array $columns = array())
    {
       return array_diff($this->getAllColumns(), $columns);
    }

    /**
     * Set view options
     * @param $columns
     */
    public function setViewOptions(array $columns = array())
    {
        $this->view_options = $columns;

        return $this;
    }

    /**
     * Get view options
     * @return array
     */
    public function getViewOptions()
    {
        return $this->view_options;
    }

    /**
     * Get view options field names
     * @return array
     */
    public function getViewOptionsFieldNames()
    {
        $field_names = array();

        $fields = $this->getFields()->getArrayIndexedBySlug();

        foreach ($this->getViewOptions() as $column)
        {
            $field_names[$fields[$column]->field_slug] = isset($fields[$column]) ? $fields[$column]->field_name : lang('streams:column_'.$column); 
        }

        return $field_names;
    }

    /**
     * Get data from a stream.
     *
     * Only really shown on the back end.
     *
     * @param   obj
     * @param   obj
     * @param   int
     * @param   int
     * @return  obj
     */
    public function getEntries($limit = null, $offset = 0, $order = null, $filter_data = array())
    {
        //ci()->load->config('streams');

        $query = static::getCache('instance')->newQuery();

        // -------------------------------------
        // Set Ordering
        // -------------------------------------

        // Query string API overrides all
        // Check if there is one now
/*        if ($this->input->get('order-'.$stream->stream_slug))
        {
            $this->db->order_by($this->input->get('order-'.$stream->stream_slug), $this->input->get('order-'.$stream->stream_slug) ? $this->input->get('order-'.$stream->stream_slug) : 'ASC');
        }
        elseif ($stream->sorting == 'title' and ($stream->title_column != '' and $this->db->field_exists($stream->title_column, $stream->stream_prefix.$stream->stream_slug)))
        {
            if ($stream->title_column != '' and $this->db->field_exists($stream->title_column, $stream->stream_prefix.$stream->stream_slug))
            {
                $this->db->order_by($stream->title_column, 'ASC');
            }
        } elseif ($stream->sorting == 'custom') {
            $this->db->order_by('ordering_count', 'ASC');
        } else {
            $this->db->order_by('created', 'DESC');
        }*/

        // -------------------------------------
        // Filter results
        // -------------------------------------

/*        if ( ! empty($filter_data)) {

            // Loop through and apply the filters
            foreach ($filter_data['filters'] as $filter=>$value) {
                if ( strlen($value) > 0 ) {
                    $this->db->like($stream->stream_prefix.$stream->stream_slug.'.'.str_replace('f_', '', $filter), $value);
                }
            }
        }*/

        // -------------------------------------
        // Optional Limit
        // -------------------------------------

/*        if (is_numeric($limit)) {
            $this->db->limit($limit, $offset);
        }*/

        // -------------------------------------
        // Created By
        // -------------------------------------

/*        $this->db->select($stream->stream_prefix.$stream->stream_slug.'.*, '.$this->db->dbprefix('users').'.username as created_by_username, '.$this->db->dbprefix('users').'.id as created_by_user_id, '.$this->db->dbprefix('users').'.email as created_by_email');
        $this->db->join('users', 'users.id = '.$stream->stream_prefix.$stream->stream_slug.'.created_by', 'left');*/

        // -------------------------------------
        // Get Data
        // -------------------------------------

        //$entries = $query->get();

        // -------------------------------------
        // Get Format Profile
        // -------------------------------------

/*        $stream_fields = $this->streams_m->get_stream_fields($stream->id);
*/
        // -------------------------------------
        // Run formatting
        // -------------------------------------

/*        if (count($entries) != 0) {
            $fields = new stdClass;

            foreach ($entries as $id => $item) {
                $fields->$id = $this->row_m->format_row($item, $stream_fields, $stream);
            }
        } else {
            $fields = false;
        }
*/
        return $query->get();
    }

    /**
     * Get entry options
     * @return array The array of entry options
     */
    public function getEntryOptions()
    {
        $columns = array();

        $columns[] = $this->getKeyName();

        if ($title_column = $this->getStream()->title_column)
        {
            $columns[] = $title_column;
        }

        return $this->get($columns)->getEntryOptions();
    }

    /**
     * Get title column value
     * @return mixed The title column value or model key
     */
    public function getTitleColumnValue($default = null)
    {
        if ( ! $column = $default)
        {
            $column = $this->getTitleColumn();
        }

        return $this->getAttribute($column);
    }

    /**
     * Get title column
     * @return string The title column or model key name
     */
    public function getTitleColumn()
    {
        $title_column = $this->getStream()->title_column;

        // Default to ID for title column
        if ( ! trim($title_column) or ! $this->getAttribute($title_column))
        {
            $title_column = $this->getKeyName();
        }

        return $title_column;
    }

    /**
     * Replicate
     * @return object The clone entry
     */
    public function replicate()
    {
        $entry = parent::replicate();

        $this->passProperties($entry);

        return $entry;
    }

    /**
     * New collection instance
     * @param  array  $entries             
     * @param  array  $unformatted_entries 
     * @return object
     */
    public function newCollection(array $entries = array(), array $unformatted_entries = array())
    {
        return new Collection\EntryCollection($entries, $unformatted_entries);
    }

    /**
     * New field collection instance
     * @param  array  $fields
     * @return object
     */
    protected function newFieldCollection(array $fields = array())
    {
        return new Collection\FieldCollection($fields);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool  $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new Query\EntryBuilder($this->newBaseQueryBuilder());

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
     * Define a polymorphic one-to-one relationship.
     *
     * @param  string  $related
     * @param  string  $name
     * @param  string  $type
     * @param  string  $id
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function morphOneEntry($related, $name, $type = null, $id = null)
    {
        $instance = new $related;

        list($type, $id) = $this->getMorphs($name, $type, $id);

        $table = $instance->getTable();

        return new Relation\MorphOneEntry($instance->newQuery(), $this, $table.'.'.$type, $table.'.'.$id);
    }

    /**
     * Pass properties
     * @param  object $instance
     * @return object
     */
    public function passProperties(Entry $model = null)
    {
        $model->setStream($this->stream);
        $model->setFields($this->fields);
        $model->setTable($this->table);
        $model->setUnformattedEntry($this->unformatted_entry);

        if ($model->getKey())
        {
            $model->exists = true;
        }

        return $model;
    }
}
