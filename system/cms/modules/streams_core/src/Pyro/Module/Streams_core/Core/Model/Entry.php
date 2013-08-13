<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
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

    protected $stream_slug = null;

    protected $stream_namespace = null;

    protected $stream_prefix = null;

    protected $field_assignments = null;

    protected $field_type_instances = null;

    protected static $instance;

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
        if ($this->stream_object = static::getCache('stream'))
        {
            $this->setTable($this->getStream()->stream_prefix.$this->getStream()->stream_slug);

            if ($relations = $this->getStream()->getModel()->getRelations());
            
            if (empty($relations))
            {
                // Eager load assignments nested with fields 
                // @todo - find a way to cache the eager load
                $this->getStream()->load('assignments.field');    
            }
        }

        $this->instance = static::getCache('instance');

        if ($table = static::getCache('table'))
        {
            $this->setTable($table);
        }
    }

    public static function stream($slug, $namespace)
    {
        $stream = Stream::all()->findBySlugAndNamespace($slug, $namespace);
        
        static::setCache('stream', $stream);
        static::setCache('table', $stream->stream_prefix.$stream->stream_slug);

        return static::setCache('instance', new static);
    }

    public function getStream()
    {
        return $this->stream_object;
    }

    public function getStreamFields()
    {
        $this->getStream()->getModel()->getRelation('assignments');
    }

    public function getDates()
    {
        return array('created', 'updated');
    }

    public function getFieldType($field_slug = '')
    {
        $entry = new static;
        
        if ( ! $field = $entry->getStream()->getModel()->getRelation('assignments')->getFields()->findBySlug($field_slug))
        {
            return false;
        }

        // @todo - replace the Type library with the PSR version
        if ( ! $type = isset(ci()->type->types->{$field->field_type}) ? ci()->type->types->{$field->field_type} : null)
        {
            return false;
        }

        $type->setEntryBuilder($this->newQuery());
        $type->setModel($this);
        $type->setField($field);
        $type->setEntry($entry);

        if ($this->exists and $value = $this->getAttributeValue($field_slug)) {
            
            $type->setValue($value);
            $type->setEntries($this->newCollection($this->newQuery()->getModels()));

        }

        return $type;
    }

    public function buildForm()
    {
        $entry = $this->exists ? $this : new static;

        $form = new \Pyro\Module\Streams_core\Core\Field\Form($entry); 

        return $form->buildForm();
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