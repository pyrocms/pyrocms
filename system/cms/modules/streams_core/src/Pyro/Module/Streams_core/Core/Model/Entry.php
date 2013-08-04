<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Collection\EntryCollection;
use Pyro\Module\Streams_core\Core\Query\EntryBuilder;
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
        
        // This picks up the stream that was set at runtime with the setStream() method
        if ($stream = static::getCache('stream'))
        {
            $this->setTable($stream->stream_prefix.$stream->stream_slug);
        }

        if ($table = static::getCache('table'))
        {
            $this->setTable($table);
        }
    }

    public function newCollection(array $models = array())
    {
        return new EntryCollection($models);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param  bool  $excludeDeleted
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new EntryBuilder($this->newBaseQueryBuilder());

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
    
    public static function setStream($slug, $namespace)
    {
        $stream = Stream::all()->findBySlugAndNamespace($slug, $namespace);
        
        return static::instance($stream->stream_prefix.$stream->stream_slug);
    }

    public static function instance($table)
    {
        static::setCache('table', $table);

        return static::setCache('instance', new static);
    }

    public function getDates()
    {
        return array('created', 'updated');
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

        static::setStream($slug, $namespace);

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
}