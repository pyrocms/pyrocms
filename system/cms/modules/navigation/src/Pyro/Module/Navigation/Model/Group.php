<?php namespace Pyro\Module\Navigation\Model; 

/**
 * Navigation model for the navigation module.
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Navigation\Models
 */
class Group extends \Illuminate\Database\Eloquent\Model
{
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	protected $table = 'navigation_groups';

	/**
	 * Disable updated_at and created_at on table
	 *
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Relationship: Link
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function links()
	{
		return $this->hasMany('Pyro\Module\Navigation\Model\Link', 'navigation_group_id');
	}

	/**
	 * Get flat array of groups
	 *
	 * @return array
	 */
	public static function getGroupOptions()
	{
		return self::lists('title', 'id');
	}

	/**
	 * Get group by..
	 *
	 * @param string $what What to get
	 * @param string $value The value
	 * @return object
	 */
	public static function getGroupByAbbrev($value)
	{
		return ci()->pdb
			->table('navigation_groups')
			->where('abbrev', $value)
			->first();
	}

}