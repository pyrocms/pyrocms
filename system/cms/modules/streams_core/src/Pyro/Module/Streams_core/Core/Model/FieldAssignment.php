<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Collection\FieldAssignmentCollection;

class FieldAssignment extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
	protected $table = 'data_field_assignments';

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

    public function newCollection(array $models = array())
    {
        return new FieldAssignmentCollection($models);
    }

    public function stream()
    {
    	return $this->belongsTo('Pyro\Module\Streams_core\Core\Model\Stream', 'stream_id');
    }

}