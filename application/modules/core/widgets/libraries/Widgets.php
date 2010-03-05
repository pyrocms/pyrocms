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
	private $_widget = NULL;
	
	function __construct()
	{
		$this->load->model('widgets/widgets_m');
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

	function get_instance($instance_id)
	{
		$widget = $this->widgets_m->get_instance($instance_id);
		$widget->options = $this->_unserialize_options($widget->options);
		return $widget;
	}
	
	function get_area($id)
	{
		if(is_numeric($id))
		{
			return $this->widgets_m->get_area_by('id', $id);
		}
		
		else
		{
			return $this->widgets_m->get_area_by('slug', $id);
		}
	}
	
	function get_widget($id)
	{
		if(is_numeric($id))
		{
			return $this->widgets_m->get_widget_by('id', $id);
		}
		
		else
		{
			return $this->widgets_m->get_widget_by('slug', $id);
		}
	}

	
	function read_widget($slug)
	{
    	$this->_widget || $this->_spawn_widget($slug);
		
    	$widget = (object) get_object_vars($this->_widget);
    	$widget->slug = $slug;

    	return $widget;
	}

	
    function render($name, $options = array())
    {
    	$this->_spawn_widget($name);
    	
        $data = call_user_func(array(&$this->_widget, 'run'), $options);
        
		if(is_array($data))
		{
			$data['options'] = $options;
		}
        
        return $this->load->view('../widgets/' . $name . '/views/display', $data, TRUE);
    }
	
    function render_backend($name, $default_options = array())
    {
    	$this->_spawn_widget($name);
    	
    	// Check for default data if there is any
    	$data = method_exists($this->_widget, 'prep_form') ? call_user_func(array(&$this->_widget, 'prep_form')) : array();
	    
    	$data['options'] = array();
    	
    	foreach($this->_widget->fields as $field)
    	{
    		$field_name =& $field['field'];
    		
    		$data['options'][$field_name] = set_value($field_name, @$default_options[$field_name]);
    	}
    	
		return $this->load->view('../widgets/' . $name . '/views/form', $data, TRUE);
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

	
	function add_widget($input)
	{
		return $this->widgets_m->insert_widget($input);
	}
	
	function delete_widget($slug)
	{
		return $this->widgets_m->delete_widget($slug);
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
		$slug = $this->get_widget($widget_id)->slug;

		if( $error = $this->validation_errors($slug, $options) )
		{
			return array('status' => 'error', 'error' => $error);
		}
		
		// The widget has to do some stuff before it saves
		$options = $this->widgets->prepare_options($slug, $options);
		
		$this->widgets_m->insert_instance(array(
			'title' => $title,
			'widget_id' => $widget_id,
			'widget_area_id' => $widget_area_id,
			'options' => $this->_serialize_options($options)
		));
		
		return array('status' => 'success');
	}
	
	function edit_instance($instance_id, $title, $widget_area_id, $options = array())
	{
		$slug = $this->widgets_m->get_instance($instance_id)->slug;
		
		if( $error = $this->validation_errors($slug, $options) )
		{
			return array('status' => 'error', 'error' => $error);
		}
		
		// The widget has to do some stuff before it saves
		$options = $this->widgets->prepare_options($slug, $options);
		
		$this->widgets_m->update_instance($instance_id, array(
			'title' => $title,
			'widget_area_id' => $widget_area_id,
			'options' => $this->_serialize_options($options)
		));
		
		return array('status' => 'success');
	}
	
	function update_instance_order($id, $position) 
	{
		return $this->widgets_m->update_instance_order($id, $position);
	}
	
	function delete_instance($id) 
	{
		return $this->widgets_m->delete_instance($id);
	}
	
	
	function validation_errors($name, $options)
	{
		$this->_widget || $this->_spawn_widget($name);
		
	    if(property_exists($this->_widget, 'fields'))
    	{
    		$_POST = $options;
    		
    		$this->load->library('form_validation');
    		$this->form_validation->set_rules($this->_widget->fields);
    		
    		if(!$this->form_validation->run())
    		{
    			return validation_errors();
    		}
    	}
	}
	
    function prepare_options($name, $options = array())
    {
    	$this->_widget || $this->_spawn_widget($name);

    	if(method_exists($this->_widget, 'prep_options'))
	    {
			return (array) call_user_func(array(&$this->_widget, 'prep_options'), $options);
	    }

	    return $options;
    }
	
    private function _spawn_widget($name)
    {
    	require_once APPPATH . 'widgets/' . $name . '/' . $name . EXT;
    	$class_name = ucfirst($name);
    	$this->_widget = new $class_name;
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
