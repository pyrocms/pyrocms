<?php namespace Pyro\Module\Addons;

use Pyro\Model\Eloquent;

/**
 * Widget Area Model
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.WidgetAreaModel.html
 */
class WidgetAreaModel extends Eloquent
{
	/**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'widget_areas';

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
     * Relationship: Instances
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instances()
    {
        return $this->hasMany('Pyro\Module\Addons\WidgetInstanceModel', 'widget_area_id');
    }

    /**
	 * Find By Slug With Instances
	 *
	 * Find an area, along with all of its instances
	 *
	 * @param  string $slug 
	 * @return string
	 */
	public function findBySlugWithInstances($slug)
	{
		return $this
			->with('instances', 'instances.widget')
			->where('slug', '=', $slug)
			->take(1)
			->first();
	}

}
