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

    public function validate()
    {
        ci()->load->library('form_validation');

        $rules = array(
            array(
                'field' => 'name',
                'label' => 'lang:widgets:widget_area_title',
                'rules' => 'trim|required|max_length[100]'
            ),
            array(
                'field' => 'slug',
                'label' => 'lang:widgets:widget_area_slug',
                'rules' => 'trim|required|alpha_dash|max_length[100]'
            )
        );

        ci()->form_validation->set_rules($rules);
        ci()->form_validation->set_data($this->toArray());

        return ci()->form_validation->run();
    }

    /**
     * Find all areas. Exciting!
     *
     * @return string
     */
    public function findAll()
    {
        return $this->orderBy('name')->get();
    }

    /**
     * Find all areas, along with all of their instances
     *
     * @return string
     */
    public function findAllWithInstances()
    {
        return $this
            ->orderBy('name')
            ->with('instances', 'instances.widget')
            ->get();
    }

    /**
     * Find By Slug
     *
     * @param  string $slug
     * @return WidgetModel
     */
    public function findBySlug($slug)
    {
        return $this
            ->where('slug', '=', $slug)
            ->take(1)
            ->first();
    }

    /**
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
