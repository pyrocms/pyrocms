<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;

class EntryOriginal extends Eloquent
{
    /**
     * The attributes that aren't mass assignable
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Stream slug
     * @var string
     */
    protected $stream_slug = null;

    /**
     * Stream namespace
     * @var string
     */
    protected $stream_namespace = null;

    /**
     * Stream
     * @var object
     */
    protected $stream = null;

    protected static $instance = null;

    /**
     * The array of user columns that will be selected
     * @var array 
     */
    protected $user_columns = array('id', 'username');

    /**
     * The name of the "created at" column.
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * The name of the "updated at" column.
     * @var string
     */
    const UPDATED_AT = 'updated';

    /**
     * The name of the "created at" column.
     * @var string
     */
    const CREATED_BY = 'created_by';

    /**
     * The class construct
     * @param array $attributes The attributes to instantiate the model with
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        if ($this->stream_slug and $this->stream_namespace)
        {
            $this->stream($this->stream_slug, $this->stream_namespace, $this);
        }

    }

    /**
     * Get a new instance of Entry with the corresponding stream and setup to query the correspoding table
     * @param  string $stream_slug      The stream slug
     * @param  string $stream_namespace The stream namespace
     * @param  Pyro\Module\Streams_core\Core\Model\Entry $instance         A passed instance of Entry
     * @return Pyro\Module\Streams_core\Core\Model\Entry                   The resulting instance of Entry
     */
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

        return static::$instance = $instance;
    }

    /**
     * Get stream
     * @return object
     */
    public function getStream()
    {
        return $this->stream instanceof Stream ? $this->stream : new Stream;
    }

    /**
     * Set stream
     * @param object $stream
     */
    public function setStream(Stream $stream = null)
    {
        return $this->stream = $stream;
    }

    /**
     * Get the dates the should use Carbon
     * @return array The array of date columns
     */
    public function getDates()
    {
        $dates = array(static::CREATED_AT, static::UPDATED_AT);

        if ($this->softDelete)
        {
            $dates = array_push($dates, static::DELETED_AT);
        }

        return $dates;
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Pyro\Module\Streams_core\Core\Model\Entry|Collection|static
     */
    public static function findOrFail($id, $columns = array('*'))
    {
        if ( ! is_null($model = static::find($id, $columns))) return $model;

        throw new Exception\EntryNotFoundException;
    }

    /**
     * Created by user format
     * @return [type] [description]
     */
    public function createdByUser()
    {
        return $this->belongsTo('\Pyro\Module\Users\Model\User', 'created_by')->select($this->user_columns);
    }
}
