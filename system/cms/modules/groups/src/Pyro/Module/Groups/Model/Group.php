<?php namespace Pyro\Module\Groups\Model;

/**
 * Group model
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Groups\Models
 *
 */
class Group extends \Illuminate\Database\Eloquent\Model
{
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	protected $table = 'groups';

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
		return static::whereNotIn('name', 'admin')->lists('description', 'id');
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