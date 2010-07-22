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
	private $_rendered_areas = array();
	private $_widget_locations = array();

	function __construct()
	{
		$this->load->model('widgets/widgets_m');

		// Map where all widgets are
		foreach ($this->load->_ci_library_paths as $path)
		{
			$widgets = array_merge(glob($path.'widgets/*', GLOB_ONLYDIR), glob($path.'modules/*/widgets/*', GLOB_ONLYDIR));

			foreach ($widgets as $widget_path)
			{
				$slug = basename($widget_path);

				// Set this so we know where it is later
				$this->_widget_locations[$slug] = $widget_path;
			}
		}
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

		foreach ($available as $widget)
		{
			$available_slugs[] = $widget->slug;
		}

		$uninstalled = array();
		foreach ($this->_widget_locations as $widget_path)
		{
			$slug = basename($widget_path);

			if ( ! in_array($slug, $available_slugs) && $widget = $this->read_widget($widget_path))
			{
				$uninstalled[] = $widget;
			}
		}

		return $uninstalled;
	}

	function get_instance($instance_id)
	{
		$widget = $this->widgets_m->get_instance($instance_id);

		if ($widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);
			return $widget;
		}

		return FALSE;
	}

	function get_area($id)
	{
		return is_numeric($id)
			? $this->widgets_m->get_area_by('id', $id)
			: $this->widgets_m->get_area_by('slug', $id);
	}

	function get_widget($id)
	{
		return is_numeric($id)
			? $this->widgets_m->get_widget_by('id', $id)
			: $this->widgets_m->get_widget_by('slug', $id);
	}


	function read_widget($path)
	{
		$slug = pathinfo($path, PATHINFO_BASENAME);
		$path = pathinfo($path, PATHINFO_DIRNAME);

    	$this->_spawn_widget($slug);

		if ( $this->_widget === FALSE OR ! is_subclass_of($this->_widget, 'Widgets'))
		{
			throw new Exception('Stuff');
			return FALSE;
		}

    	$widget = (object) get_object_vars($this->_widget);
    	$widget->slug = $slug;
		$widget->module = strpos($slug, 'modules/') ? basename(dirname($path)) : NULL;
		$widget->is_third_party = strpos($slug, 'third_party/') !== FALSE;

		return $widget;
	}

    function render($name, $options = array())
    {
    	$path = $this->_spawn_widget($name);

        $data = method_exists($this->_widget, 'run')
			? call_user_func(array($this->_widget, 'run'), $options)
			: array();

		// Don't run this widget
		if ($data === FALSE)
		{
			return FALSE;
		}

		// If we have TRUE, just make an empty array
		$data !== TRUE || $data = array();

		// convert to array
		is_array($data) || $data = (array) $data;

		$data['options'] = $options;

        return $this->load->view('../../'.$path.'/views/display', $data, TRUE);
    }

    function render_backend($name, $default_options = array())
    {
    	$path = $this->_spawn_widget($name);

    	// Check for default data if there is any
    	$data = method_exists($this->_widget, 'prep_form') ? call_user_func(array(&$this->_widget, 'prep_form')) : array();

    	$data['options'] = array();

		// If there are fields
		if (!empty($this->_widget->fields))
		{
			foreach ($this->_widget->fields as $field)
			{
				$field_name =& $field['field'];

				$data['options'][$field_name] = set_value($field_name, @$default_options[$field_name]);
			}

			return $this->load->view('../..'.$path.'/views/form', $data, TRUE);
		}

		return '';
    }

	function render_area($area)
	{
		if (isset($this->_rendered_areas[$area]))
		{
			return $this->_rendered_areas[$area];
		}

		$widgets = $this->widgets_m->get_by_area($area);

		$output = '';

		foreach ($widgets as $widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);
			$widget->body = $this->render($widget->slug, $widget->options);

			if ($widget->body !== FALSE)
			{
				$output .= $this->load->view('widgets/widget_wrapper', array('widget' => $widget), TRUE) . "\n";
			}
		}

		$this->_rendered_areas[$area] = $output;

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

		if ( $error = $this->validation_errors($slug, $options) )
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

		if ( $error = $this->validation_errors($slug, $options) )
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

	    if (property_exists($this->_widget, 'fields'))
    	{
    		$_POST = $options;

    		$this->load->library('form_validation');
    		$this->form_validation->set_rules($this->_widget->fields);

    		if (!$this->form_validation->run('', FALSE))
    		{
    			return validation_errors();
    		}
    	}
	}

    function prepare_options($name, $options = array())
    {
    	$this->_widget || $this->_spawn_widget($name);

    	if (method_exists($this->_widget, 'prep_options'))
	    {
			return (array) call_user_func(array(&$this->_widget, 'prep_options'), $options);
	    }

	    return $options;
    }

    private function _spawn_widget($name)
    {
		$widget_path = $this->_widget_locations[$name] . '/' . $name . EXT;

		if (file_exists($widget_path))
		{
			require_once $widget_path;
			$class_name = ucfirst($name);
			$this->_widget = new $class_name;

			return $this->_widget_locations[$name].'/';
		}

		return FALSE;
    }

    function __get($var)
    {
        static $ci;
    	isset($ci) OR $ci =& get_instance();
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