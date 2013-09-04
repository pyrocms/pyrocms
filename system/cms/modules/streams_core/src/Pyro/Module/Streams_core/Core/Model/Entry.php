<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;

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
    protected $assignments = null;

    protected $fields = null;

    protected $field_type_instances = null;

    protected $unformatted_values = array();

    protected $unformatted_entry = null;

    protected $format = true;

    protected $plugin = true;

    protected $plugin_values = array();

    protected $view_options = array();

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

        $fields = array();

        foreach ($instance->assignments as $assignment)
        {
            $fields[] = $assignment->field;
        }

        $instance->setFields($instance->newFieldCollection($fields));

        return $instance;
    }

    public function setFields(Collection\FieldCollection $fields = null)
    {
        $this->fields = $fields;

        return $this;
    }

    public function getFields()
    {
        if ($this->fields instanceof Collection\FieldCollection)
        {
            return $this->fields;
        }

        return new Collection\FieldCollection;
    }

    public function getField($field_slug = '')
    {
        return $this->getFields()->findBySlug($field_slug);
    }

    public function getFieldType($field_slug = '')
    {
        if ( ! $field = $this->getField($field_slug))
        {
            return false;
        }

        return $field->getType($this);
    }

    public function getFieldSlugs()
    {
        return $this->getFields()->getFieldSlugs();
    }

    public function setPlugin($plugin = true)
    {
        $this->plugin = $plugin;

        return $this;
    }

    public function setFormat($format = true)
    {
        $this->format = $format;

        return $this;
    }

    public function isFormat()
    {
        return $this->format;
    }

    public function isPlugin()
    {
        return $this->plugin;
    }

    public function setPluginValue($key = null, $value = null)
    {
        if ($key)
        {
            $this->plugin_values[$key] = $value;   
        }
    }

    public function getPluginValue($key)
    {
        return isset($this->plugin_values[$key]) ? $this->plugin_values[$key] : $this->getAttribute($key);
    }

    public function setUnformattedValue($key = null, $value = null)
    {
        if ($key)
        {
            $this->unformatted_values[$key] = $value;   
        }
    }

    public function getUnformattedValue($key)
    {
        return isset($this->unformatted_values[$key]) ? $this->unformatted_values[$key] : null;
    }

    public function newFormBuilder()
    {
        return new \Pyro\Module\Streams_core\Core\Field\Form($this);
    }

    public function setUnformattedEntry($unformatted_entry = null)
    {
        $this->unformatted_entry = $unformatted_entry;
    }

    public function unformatted()
    {
        return $this->unformatted_entry;
    }

    public function findEntry($id = null, array $columns = array('*'))
    {
        $entry = $this->where($this->getKeyName(), '=', $id)->first($columns);

        $this->passProperties($entry);

        return $entry;
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
                    $type->setValue($this->getAttribute($field->field_slug));

                    if ( $value = $this->getAttribute($field->field_slug) and ! empty($value))
                    {
                        // We don't process the alt process stuff.
                        // This is for field types that store data outside of the
                        // actual table
                        if ($type->alt_process)
                        {
                            $alt_process[] = $type;
                        }
                        else
                        {
                            if (method_exists($type, 'pre_save'))
                            {
                                $this->setAttribute($field->field_slug, $type->pre_save());
                            }

                            if (is_null($value))
                            {
                                $this->setAttribute($field->field_slug, null);
                            }
                            elseif(is_string($value))
                            {
                                $this->setAttribute($field->field_slug, trim($value));
                            }
                        }
                    }
                    
                    //unset($type);
                }
            }
        }


    // -------------------------------------
        // Set incremental ordering
        // -------------------------------------
        
/*        $db_obj = $this->db->select("MAX(ordering_count) as max_ordering")->get($stream->stream_prefix.$stream->stream_slug);
        
        if ($db_obj->num_rows() == 0 or !$db_obj)
        {
            $ordering = 0;
        }
        else
        {
            $order_row = $db_obj->row();
            
            if ( ! is_numeric($order_row->max_ordering))
            {
                $ordering = 0;
            }
            else
            {
                $ordering = $order_row->max_ordering;
            }
        }

        $insert_data['ordering_count']  = $ordering+1;*/

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

            // -------------------------------------
        

        return parent::save();
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
                            else
                            {
                                $return_data[$field->field_slug] = $return_data[$field->field_slug];
                            }
                        }
                        else
                        {
                            $return_data[$field->field_slug] = $form_data[$field->field_slug];
        
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

    public function total()
    {

    }

    /**
     * Get all the non-field standard columns for entries as an array
     * @return array An array of standard columns
     */
    public function getStandardColumns()
    {
        return array_merge(array($this->getKeyName()), $this->getDates(), array(static::CREATED_BY));
    }

    public function getAllColumns()
    {
        return array_merge($this->getStandardColumns(), $this->getFieldSlugs());
    }

    public function getAllColumnsExclude(array $columns = array())
    {
       return array_diff($this->getAllColumns(), $columns);
    }

    public function setViewOptions(array $columns = array())
    {
        $this->view_options = $columns;

        return $this;
    }

    public function getViewOptions()
    {
        return $this->view_options;
    }

    public function getViewOptionsFieldNames()
    {
        $field_names = array();

        $fields = $this->getFields()->getArrayIndexedBySlug();

        foreach ($this->getViewOptions() as $column)
        {
            $field_names[] = isset($fields[$column]) ? $fields[$column]->field_name : lang('streams:column_'.$column); 
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

    public function newCollection(array $entries = array(), array $unformatted_entries = array())
    {
        return new Collection\EntryCollection($entries, $unformatted_entries);
    }

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


    public function morphToEntry($related = 'Pyro\Module\Streams_core\Core\Model\Entry', $relation_name = 'entry', $stream_column = null, $id_column = null)
    {
        // Next we will guess the type and ID if necessary. The type and IDs may also
        // be passed into the function so that the developers may manually specify
        // them on the relations. Otherwise, we will just make a great estimate.
        list($stream_column, $id_column) = $this->getMorphs($relation_name, $stream_column, $id_column);

        return $this->belongsToEntry($related, $id_column, $this->$stream_column, $stream_column);
    }

    public function passProperties(Entry $instance = null)
    {
        $instance->setStream($this->stream);
        $instance->setFields($this->fields);

        return $instance;
    }

}