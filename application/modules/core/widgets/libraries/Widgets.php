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
		$this->load->model('widgets_m');
	}
	
	function list_areas()
	{
		return $this->widgets_m->get_areas();
	}

	function list_area_instances($slug)
	{
		return $this->widgets_m->get_by_area($slug);
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

	
	function get_area($slug)
	{
		return $this->widgets_m->get_area($slug);
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
    	require_once APPPATH . 'widgets/' . $name . '/' . $name . EXT;
    	$class_name = ucfirst($name);
    	$widget = new $class_name;
        $data = call_user_func(array(&$widget, 'run'), $args);
        
        return $this->load->view('../widgets/' . $name . '/views/display' . EXT, $data, TRUE);
    }
	
    function render_backend($name)
    {
    	require_once APPPATH . 'widgets/' . $name . '/' . $name . EXT;
    	$class_name = ucfirst($name);
    	$widget = new $class_name;
    	
    	// Check for default data if there is any
    	$data = method_exists($widget, 'prep_form') ? call_user_func(array(&$widget, 'prep_form')) : array();
	    
		return $this->load->view('../widgets/' . $name . '/views/form' . EXT, $data, TRUE);
    }
	
	function render_area($area)
	{
		$widgets = $this->widgets_m->get_by_area($area);
		
		$output = '';
		
		foreach($widgets as $widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);
			$widget->body = $this->render($widget->slug, $widget->options);

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
	
	function add_instance($title, $widget_id, $widget_area_id, $options = array())
	{
		$slug = $this->widgets_m->get($widget_id)->slug;
		
		// The widget has to do some stuff before it saves
		$options = $this->widgets->prep_options($slug, $options);
		
		$this->widgets_m->insert_instance(array(
			'title' => $title,
			'widget_id' => $widget_id,
			'widget_area_id' => $widget_area_id,
			'options' => $this->_serialize_options($options)
		));
	}
	
    function prep_options($name, $options)
    {
    	require_once APPPATH . 'widgets/' . $name . '/' . $name . EXT;
    	$class_name = ucfirst($name);
    	$widget = new $class_name;
    	
    	if(method_exists($widget, 'prep_options'))
	    {
			return (array) call_user_func(array(&$widget, 'prep_options'), $options);
	    }
	    
	    return array();
    }
	
	// wirdesignz you genius
    function __get($var)
    {
        static $ci;
    	isset($ci) OR $ci = get_instance();
        return $ci->$var;
    }
	
	private function _serialize_options($options)
	{
		return serialize((array) $options);
	}
	
	private function _unserialize_options($options)
	{
		return (array) unserialize($options);
	}

}
