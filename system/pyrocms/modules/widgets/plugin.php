<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Widgets Plugin
 *
 * Load widget instances and asrea
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
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
		$slug = $this->attribute('slug');

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
		$id = $this->attribute('id');

		$widget = $this->widgets->get_instance($id);

		return $widget ? $this->widgets->render($widget->slug, $widget->options) : '';
	}
}

/* End of file plugin.php */