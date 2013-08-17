<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Field\Type;
use Pyro\Module\Streams_core\Core\Model\Stream;

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
//      protected $stream = 'profiles';
//      
//      protected $namespace = 'users';
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

    protected $dates = array('created', 'updated');

    protected $audits = array('created_by');

    protected $stream_slug = null;

    protected $stream_namespace = null;

    protected $stream = null;

    protected $stream_prefix = null;

    protected $assignments = null;

    protected $field_type_instances = null;

    protected $unformatted_values = array();

    protected $instance = null;

    protected $format = true;

    protected $plugin = true;



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

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        /*
         * When a model extends Entry you can set the stream_prefix, stream_slug and stream_namespace
         * properties in order for the model to interact with the stream table
         */
        if ($this->stream_prefix and $this->stream_slug and $this->stream_namespace)
        {
            $this->setTable($this->stream_prefix.$this->stream_slug);
        }
        
        // This picks up the stream that was set at runtime with the stream() method
        if ($this->stream = static::getCache('stream'))
        {
            $this->setTable($this->stream->stream_prefix.$this->getStream()->stream_slug);
            
            $relations = $this->stream->getModel()->getRelations();
            
            // Check if the assignments are already loaded
            if ( ! isset($relations['assignments']))
            {
                // Eager load assignments nested with fields 
                $this->getStream()->load('assignments.field');    
            }

            $this->assignments = $this->stream->getModel()->getRelation('assignments');
        }

        $this->instance = static::getCache('instance');
    }

    public static function stream($slug, $namespace)
    {   
        if ( ! static::getCache('stream'))
        {
            static::setCache('stream', Stream::findBySlugAndNamespace($slug, $namespace));
        }

        return static::setCache('instance', new static);
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function getFields()
    {
        $fields = $this->assignments->getFields();

        $fields->setStandardColumns($this->getStandardColumns());

        return $fields;
    }

    public function getDates()
    {
        return $this->dates;
    }

    public function getAudits()
    {
        return $this->audits;
    }

    public function getFieldType($field_slug = '')
    {
        $entry = $this->exists ? $this : new static;
        
        if ( ! $field = $entry->getFields()->findBySlug($field_slug))
        {
            return false;
        }

        return Type::getFieldType($field, $entry);
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

    public function setUnformattedValue($key = null, $value = null)
    {
        if ($key) {
            $this->unformatted_values[$key] = $value;   
        }
    }

    public function getUnformattedValue($key)
    {
        return isset($this->unformatted_values[$key]) ? $this->unformatted_values[$key] : null;
    }

    public function buildForm()
    {
        $entry = $this->exists ? $this : new static;

        $form = new \Pyro\Module\Streams_core\Core\Field\Form($entry); 

        return $form->buildForm();
    }

    public function getEntry($id, array $columns = array('*'))
    {
        return $this->newQuery()->where($this->getKeyName(), '=', $id)->first($columns);
    }

    public function first(array $columns = array('*'))
    {
        return $this->newQuery()->take(1)->get($columns)->first();
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
        return array_merge($this->getDates(), $this->getAudits());
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


    // Exploring some ideas for relationships

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToStream($slug, $namespace, $foreign_key = null)
    {
        $stream_table = $this->getTable();

        static::stream($slug, $namespace);

        if ( ! $foreign_key)
        {
            $foreign_key = $stream_table.'_id';
        }

        return $this->belongsTo('Pyro\Module\Streams_core\Model\Entry', $foreign_key);
    }

    public function belongsToTable($table, $foreign_key = null)
    {
        $table = $this->getTable();

        static::setTable($table);

        if ( ! $foreign_key)
        {
            $foreign_key = $table.'_id';
        }

        return $this->belongsTo('Pyro\Module\Streams_core\Model\Entry', $foreign_key);
    }

    public function newCollection(array $entries = array(), array $unformatted_entries = array())
    {
        return new \Pyro\Module\Streams_core\Core\Collection\EntryCollection($entries, $unformatted_entries);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool  $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new \Pyro\Module\Streams_core\Core\Query\EntryBuilder($this->newBaseQueryBuilder());

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