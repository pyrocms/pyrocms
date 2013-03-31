<?php namespace Pyro\Module\Groups\Model;

use Cartalyst\Sentry\Groups\Eloquent\Group as EloquentGroup;

/**
 * Group model
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Groups\Models
 *
 */
class Group extends EloquentGroup
{
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	protected $table = 'groups';

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

    /**
     * Get all groups as a flat array
     *
     * @return array
     */
	public static function getGroupOptions()
	{
		return static::lists('description', 'id');
	}

    /**
     * Get all groups except the Admin as a flat array
     *
     * @return array
     */
	public static function getGeneralGroupOptions()
	{
		return static::where('name', '!=', 'admin')->lists('description', 'id');
	}

    /**
     * Get groups by ids as a flat array
     *
     * @param ids - The group ids to get
     * @return array
     */
	public static function findManyInId($ids = array())
	{
		return static::whereIn('id', $ids)->lists('description', 'id');
	}

	/**
     * Get group by name
     *
     * @param string - The group name to get
     * @return array
     */
	public static function findByName($group_name)
	{
		return static::where('name', '=', $group_name)->first();
	}
}
