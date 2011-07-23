<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Widgets Plugin
 *
 * Load widget instances and asrea
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Widgets extends Plugin
{
	function __construct()
	{
		$this->load->library('widgets/widgets');
	}

	/**
	 * Area
	 *
	 * Display all widgets in a widget area
	 *
	 * Usage:
	 * {pyro:widgets:area slug="sidebar"}
	 *
	 * @param	array
	 * @return	array
	 */
	public function area()
	{
		$slug			= $this->attribute('slug');
		$slug_segment	= $this->attribute('slug_segment');
		
		is_numeric($slug_segment) ? $slug = $this->uri->segment($slug_segment) : NULL ;

		return $this->widgets->render_area($slug);
	}

	/**
	 * Instance
	 *
	 * Show one specific widget instance
	 *
	 * Usage:
	 * {pyro:widgets:instance id="8"}
	 *
	 * @param	array
	 * @return	array
	 */
	public function instance()
	{
		$id		= $this->attribute('id');
		$widget	= $this->widgets->get_instance($id);

		if ( ! $widget)
		{
			return;
		}

		$attributes = array_merge(array(
			'instance_title'	=> $widget->instance_title
		), $this->attributes(), array(
			'instance_id'		=> $widget->instance_id,
			'widget_id'			=> $widget->id,
			'widget_slug'		=> $widget->slug,
			'widget_title'		=> $widget->title,
			'widget_area_id'	=> $widget->widget_area_id,
			'widget_area_slug'	=> $widget->widget_area_slug
		));

		unset($attributes['id']);

		$widget->options['widget'] = $attributes;

		return $this->widgets->render($widget->slug, $widget->options);
	}
}

/* End of file plugin.php */