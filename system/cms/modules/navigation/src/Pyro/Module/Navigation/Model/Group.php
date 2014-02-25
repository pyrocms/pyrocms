<?php namespace Pyro\Module\Navigation\Model;

use Pyro\Model\Eloquent;

/**
 * Navigation model for the navigation module.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Navigation\Models
 */
class Group extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'navigation_groups';

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

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
     * Relationship: Link
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany('Pyro\Module\Navigation\Model\Link', 'navigation_group_id')->where('parent', '=', 0)->orderBy('position', 'ASC');
    }

    /**
     * Get flat array of groups
     *
     * @return array
     */
    public static function getGroupOptions()
    {
        return static::lists('title', 'id');
    }

    /**
     * Get group by..
     *
     * @param  string $what  What to get
     * @param  string $value The value
     * @return object
     */
    public static function findGroupByAbbrev($value)
    {
        return static::where('abbrev', $value)->first();
    }

}
