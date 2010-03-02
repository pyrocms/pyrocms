<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Widget module
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Widget library takes care of the logic for widgets
 */
class Widgets
{
	function __construct()
	{
		$this->load->model('widgets/widgets_m');
		$this->load->model('widgets/widget_areas_m');
	}
	
	function list_areas()
	{
		return $this->widget_areas_m->get_all();
	}

	
	function list_available_widgets()
	{
		return $this->widgets_m->get_all();
	}
	
	function list_uninstalled_widgets()
	{
		$available = $this->list_available_widgets();
		$available_slugs = array();
		
		foreach($available as $widget)
		{
			$available_slugs[] = $widget->slug;
		}
		
		$uninstalled = array();
		foreach(glob(APPPATH . 'widgets/*', GLOB_ONLYDIR) as $slug)
		{
			$slug = basename($slug);

			if(!in_array($slug, $available_slugs))
			{
				$uninstalled[] = $this->read_widget($slug);
			}
		}

		return $uninstalled;
	}
	
	
	function get_widget($slug)
	{
		return $this->widgets_m->get_by('slug', $slug);
	}

	
	function read_widget($slug)
	{
		if( ! require(APPPATH . 'widgets/' . $slug . '/' . $slug . EXT))
		{
			return FALSE;
		}
		
    	$class_name = ucfirst($slug);
    	
    	$widget = (object) get_object_vars(new $class_name);
    	$widget->slug = $slug;

    	return $widget;
	}
	
	
    function render($name, $args)
    {
    	require APPPATH . 'widgets/' . $name . '/' . $name . EXT;
    	$class_name = ucfirst($name);
    	$widget = new $class_name;
        $data = call_user_func(array(&$widget, 'run'), $args);
        
        return $this->load->view('../widgets/' . $name . '/views/display' . EXT, $data, TRUE);
    }
	
	function render_area($area, $return = FALSE)
	{
		$widgets = $this->widgets_m->get_by_area($area);
		
		$output = '';
		
		foreach($widgets as $widget)
		{
			$widget->data = $this->_unserialize_data($widget->data);
			$widget->body = $this->render($widget->slug, $widget->data);

			$output .= $this->load->view('widgets/widget_wrapper', array('widget' => $widget), TRUE) . "\n";
		}
		
		return $output;
	}

	
	function add_area($input)
	{
		return $this->widgets_m->insert_area((array)$input);
	}
	
	function delete_area($slug)
	{
		return $this->widgets_m->delete_area($slug);
	}
	
	
	// wirdesignz you genius
    function __get($var)
    {
        static $ci;
    	isset($ci) OR $ci = get_instance();
        return $ci->$var;
    }
	
	private function _serialize_data($data)
	{
		return serialize((array) $data);
	}
	
	private function _unserialize_data($data)
	{
		return (array) unserialize($data);
	}

}
