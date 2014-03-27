<?php namespace Pyro\Module\Addons;

use Pyro\Model\Eloquent;

/**
 * Widget Area Model
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.WidgetInstanceModel.html
 */
class WidgetInstanceModel extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'widget_instances';

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array('id', 'options', 'order', 'created_at', 'updated_at');

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * Relationship: Options
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo('Pyro\Module\Addons\WidgetAreaModel', 'widget_area_id');
    }

    /**
     * Relationship: Widget
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function widget()
    {
        return $this->belongsTo('Pyro\Module\Addons\WidgetModel');
    }

        /**
     * Array containing the validation rules
     *
     * @var array
     */
    public function validate()
    {
        ci()->load->library('form_validation');

        ci()->form_validation->set_rules(array(
            array(
                'field' => 'name',
                'label' => 'lang:name_label',
                'rules' => 'trim|required|max_length[250]',
            ),
            array(
                'field' => 'widget_id',
                'rules' => 'trim|numeric|required',
            ),
            array(
                'field' => 'widget_area_id',
                'rules' => 'trim|numeric|required',
            ),
        ));

        ci()->form_validation->set_data($this->toArray());

        return ci()->form_validation->run();
    }

    protected function setOptionsAttribute($value)
    {
        $this->attributes['options'] = serialize((array) $value);
    }

    protected function getOptionsAttribute($options)
    {
        $options = (array) unserialize($options);

        if (! isset($options['show_title'])) {
            $options['show_title'] = false;
        }

        return $options;
    }
}
