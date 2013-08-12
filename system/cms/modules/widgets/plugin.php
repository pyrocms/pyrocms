<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Widgets Plugin
 *
 * Load widget instances and area
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets\Plugins
 */
class Plugin_Widgets extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Widgets',
		'ar' => 'الودجتس',
            'fa' => 'ویجت ها',
	);
	public $description = array(
		'en' => 'Display widgets by widget area or individually.',
		'ar' => 'عرض الودجتس في مساحة ودجت أو لوحدها.',
            'fa' => 'نمایش دادن ویجت ها با استفاده از مکان ها و یا به صورتی تکی',
		'it' => 'Mostra singolarmente o a gruppi i Widget',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'area' => array(
				'description' => array(
					'en' => 'Render a widget area specified by either its slug or the number of a uri segment that holds its slug.',
					'ar' => 'عرض مساحة ودجت بتحديد اسمها المختر أو جزء العنوان الذي يحتوي اسمها المختصر',
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'slug' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'slug_segment' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
				),
			),// end first method
			'instance' => array(
				'description' => array(
					'en' => 'Render a widget specified by its id.',
					'ar' => 'عرض ودجت بتحديد id الخاص بها',
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end first method
		);
	
		return $info;
	}


	public function __construct()
	{
		$this->load->library('widgets/widgets');
	}

	/**
	 * Area
	 *
	 * Display all widgets in a widget area
	 *
	 * Usage:
	 * {{ widgets:area slug="sidebar" }}
	 *
	 * @param array
	 * @return array
	 */
	public function area()
	{
		$slug         = $this->attribute('slug');
		$slug_segment = $this->attribute('slug_segment');
		
		is_numeric($slug_segment) ? $slug = $this->uri->segment($slug_segment) : null ;

		return $this->widgets->render_area($slug);
	}

	/**
	 * Instance
	 *
	 * Show one specific widget instance
	 *
	 * Usage:
	 * {{ widgets:instance id="8" }}
	 *
	 * @param array
	 * @return array
	 */
	public function instance()
	{
		$id     = $this->attribute('id');
		$widget = $this->widgets->get_instance($id);

		if ( ! $widget)
		{
			return;
		}

		$attributes = array_merge(array(
			'instance_title'  => $widget->instance_title
		), $this->attributes(), array(
			'instance_id'       => $widget->instance_id,
			'widget_id'         => $widget->id,
			'widget_slug'       => $widget->slug,
			'widget_title'      => $widget->title,
			'widget_area_id'    => $widget->widget_area_id,
			'widget_area_slug'  => $widget->widget_area_slug
		));

		unset($attributes['id']);

		$widget->options['widget'] = $attributes;

		return $this->widgets->render($widget->slug, $widget->options);
	}
}

/* End of file plugin.php */
