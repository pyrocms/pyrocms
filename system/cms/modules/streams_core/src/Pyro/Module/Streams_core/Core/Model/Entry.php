<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Field\Type;

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

class Entry extends Eloquent
{
    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array('id');

    protected $stream_slug = null;

    protected $stream_namespace = null;

    protected $stream_prefix = null;

    protected $stream = null;

    protected $assignments = null;

    protected $fields = null;

    protected $field_type_instances = null;

    protected $unformatted_values = array();

    protected $instance = null;

    protected $format = true;

    protected $plugin = true;

    protected $plugin_values = array();

    protected $view_options = array();

    protected $user_columns = array('id', 'username');

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_BY = 'created_by';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        if ($this->stream_slug and $this->stream_namespace)
        {
            $this->stream($this->stream_slug, $this->stream_namespace, $this);
        }
    }

    public static function stream($stream_slug, $stream_namespace, Entry $instance = null)
    {
        if ( ! $instance)
        {
            $instance = new static;
        }

        if ( ! $instance->stream = Stream::findBySlugAndNamespace($stream_slug, $stream_namespace))
        {
            $message = 'The Stream model was not found. Attempted [ '.$stream_slug.', '.$stream_namespace.' ]';

            throw new Exception\StreamNotFoundException($message);
        }

        $instance->setTable($instance->stream->stream_prefix.$instance->stream->stream_slug);

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

    /**
     * Return a new Entry model only if the stream is set
     * @return Pyro\Module\Streams_core\Core\Model\Entry The new Entry model
     */
    public function newEntry()
    {
        if ( ! $this->stream)
        {
            return false;
        }

        $new = $this->newInstance();

        $new->setFields($this->getFields());

        return $new;
    }

    public function getStream()
    {
        return $this->stream;
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

    public function getFieldSlugs()
    {
        if ($this->getFields())
        {
            return $this->getFields()->getFieldSlugs();
        }

        return false;
    }

    public function getDates()
    {
        $dates = array(static::CREATED_AT, static::UPDATED_AT);

        if ($this->softDelete)
        {
            $dates = array_push($dates, static::DELETED_AT);
        }

        return $dates;
    }

    public function getFieldType($field_slug = '')
    {
        if ( ! $this->getFields())
        {
            return false;
        }

        if ( ! $field = $this->getFields()->findBySlug($field_slug))
        {
            return false;
        }

        return Type::getFieldType($field, $this);
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
        $entry = $this->getKey() ? $this : new static;

        $entry->setFields($this->fields);

        return new \Pyro\Module\Streams_core\Core\Field\Form($entry);
    }

    public function getEntry($id = null, array $columns = array('*'))
    {
        return $this->where($this->getKeyName(), '=', $id)->first($columns);
    }

    public function total()
    {

    }

    public static function all($columns = array('*'))
    {
        if ($all = static::getCache('table::all'))
        {
            return $all;
        }

        return static::setCache('table::all', static::getCache('instance')->newQuery()->get($columns));
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
            $field_name = isset($fields[$column]) ? lang_label($fields[$column]->field_name) : null; 

            $field_names[] = $field_name ? $field_name : lang('streams:'.$column);
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
        ci()->load->config('streams');

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

    public function createdByUser()
    {
        return $this->belongsTo('\Pyro\Module\Users\Model\User', 'created_by')->select($this->user_columns);
    }

    // Exploring some ideas for relationships

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToStream($stream_slug, $stream_namespace, $foreign_key = null)
    {
        $stream_table = $this->getTable();

        static::stream($stream_slug, $stream_namespace);

        if ( ! $foreign_key)
        {
            $foreign_key = $stream_table.'_id';
        }

        return $this->belongsTo(get_called_class(), $foreign_key);
    }

    public function belongsToTable($table, $foreign_key = null)
    {
        $table = $this->getTable();

        static::setTable($table);

        if ( ! $foreign_key)
        {
            $foreign_key = $table.'_id';
        }

        return $this->belongsTo(get_called_class(), $foreign_key);
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

}