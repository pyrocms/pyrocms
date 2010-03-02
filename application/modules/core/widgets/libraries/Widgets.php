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
		$this->load->model('widgets/widget_instances_m');
	}
	
	function list_areas()
	{
		return $this->widget_areas_m->get_all();
	}

	
	function list_widgets()
	{
		return $this->widgets_m->get_all();
	}
	
	
	function get_widget($slug)
	{
		return $this->widgets_m->get_by('slug', $slug);
	}

	
    function render($name, $args)
    {
    	require_once APPPATH . 'widgets/' . $name . '/' . $name . EXT;
        
    	$widget = new $name;
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

?>
