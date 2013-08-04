<?php namespace Pyro\Module\Streams_core\Core\Model;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\Core\Collection\FieldCollection;

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

    public function newCollection(array $models = array())
    {
        return new FieldCollection($models);
    }

    public function assignments()
    {
        return $this->hasMany('Pyro\Module\Streams_core\Core\Model\FieldAssignment');
    }

    public function getFieldDataAttribute($field_data)
    {
        return unserialize($field_data);
    }

    public function getViewOptionsAttribute($view_options)
    {
        return unserialize($view_options);
    }

    public function setViewOptionsAttribute($view_options)
    {   
        $this->attributes['view_options'] = serialize($view_options);
    }

    public function getIsLockedAttribute($is_locked)
    {
        return $is_locked == 'yes' ? true : false;
    }

    public function setIsLockedAttribute($is_locked)
    {
        $this->attributes['is_locked'] = ! $is_locked ? 'no' : 'yes';
    }
}