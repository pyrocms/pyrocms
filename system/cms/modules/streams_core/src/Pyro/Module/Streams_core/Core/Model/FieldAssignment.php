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

    //public function findManyByStreamId()

    public function newCollection(array $models = array())
    {
        return new FieldAssignmentCollection($models);
    }

    public function stream()
    {
    	return $this->belongsTo('Pyro\Module\Streams_core\Core\Model\Stream', 'stream_id');
    }

    public function field()
    {
        return $this->belongsTo('Pyro\Module\Streams_core\Core\Model\Field');
    }

    public function getIsRequiredAttribute($is_required)
    {
        return $is_required == 'yes' ? true : false;
    }

    public function setIsRequiredAttribute($is_required)
    {
        $this->attributes['is_required'] = ! $is_required ? 'no' : 'yes';
    }

    public function getIsUniqueAttribute($is_unique)
    {
        return $is_unique == 'yes' ? true : false;
    }

    public function setIsUniqueAttribute($is_unique)
    {
        $this->attributes['is_unique'] = ! $is_unique ? 'no' : 'yes';
    }

}