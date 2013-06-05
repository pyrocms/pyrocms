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
    protected $guarded = array('id', 'options', 'order', 'created_on', 'updated_on');

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

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

        $rules = array(
            array(
                'field' => 'name',
                'label' => 'lang:widgets:widget_area_name',
                'rules' => 'trim|required|max_length[100]'
            ),
            array(
                'field' => 'slug',
                'label' => 'lang:widgets:widget_area_slug',
                'rules' => 'trim|required|alpha_dash|max_length[100]'
            ),
        );
        
        ci()->form_validation->set_rules($rules);
        ci()->form_validation->set_data($this->toArray());

        return ci()->form_validation->run();
    }

	public function insert_instance($input)
	{
		$last_widget = $this->db
			->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('widget_instances', array('widget_area_id' => $input['widget_area_id']))
			->row();

		$order = isset($last_widget->order) ? $last_widget->order + 1 : 1;

		return $this->db->insert('widget_instances', array(
			'title'				=> $input['title'],
			'widget_id'			=> $input['widget_id'],
			'widget_area_id'	=> $input['widget_area_id'],
			'options'			=> $input['options'],
			'order'				=> $order,
			'created_on'		=> time(),
		));
	}

	public function update_instance($instance_id, $input)
	{
		$this->db->where('id', $instance_id);

		return $this->db->update('widget_instances', array(
        	'title'				=> $input['title'],
			'widget_area_id'	=> $input['widget_area_id'],
			'options'			=> $input['options'],
			'updated_on'		=> time()
		));
	}

	protected function setOptionsAttribute($value)
	{
		$this->attributes['options'] = serialize((array) $value);
	}

	protected function getOptionsAttribute($options)
	{
		$options = (array) unserialize($options);

		if ( ! isset($options['show_title'])) {
			$options['show_title'] = false;
		}

		return $options;
	}
}
