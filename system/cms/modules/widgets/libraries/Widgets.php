<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Widget library takes care of the logic for widgets
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Widgets\Libraries
 */
class Widgets {

	private $_widget = NULL;
	private $_rendered_areas = array();
	private $_widget_locations = array();

	function __construct()
	{
		$this->load->model('widgets/widget_m');

		$locations = array(
		   APPPATH,
		   ADDONPATH,
		   SHARED_ADDONPATH,
		);

		if (defined('ADMIN_THEME'))
		{
			$locations += array(
			   SHARED_ADDONPATH.'themes/'.ADMIN_THEME.'/',
			   APPPATH.'themes/'.ADMIN_THEME.'/',
			   ADDONPATH.'themes/'.ADMIN_THEME.'/',
			);
		}

		// Map where all widgets are
		foreach ($locations as $path)
		{
			$widgets = glob($path . 'widgets/*', GLOB_ONLYDIR);

			if ( ! is_array($widgets))
			{
				$widgets = array();
			}

			$module_widgets = glob($path . 'modules/*/widgets/*', GLOB_ONLYDIR);

			if ( ! is_array($module_widgets))
			{
				$module_widgets = array();
			}

			$widgets = array_merge($widgets, $module_widgets);

			foreach ($widgets as $widget_path)
			{
				$slug = basename($widget_path);

				// Set this so we know where it is later
				$this->_widget_locations[$slug] = $widget_path . '/';
			}
		}
	}

	function list_areas()
	{
		return $this->widget_m->get_areas();
	}

	function list_area_instances($slug)
	{
		return is_array($slug) ? $this->widget_m->get_by_areas($slug) : $this->widget_m->get_by_area($slug);
	}

	function list_available_widgets()
	{
		// Firstly, install any uninstalled widgets
		$uninstalled_widgets = $this->list_uninstalled_widgets();

		foreach ($uninstalled_widgets as $widget)
		{
			$this->add_widget((array) $widget);
		}

		// Secondly, uninstall any installed widgets missed
		$installed_widgets = $this->widget_m->order_by('slug')->get_all();

		$avaliable = array();

		foreach ($installed_widgets as $widget)
		{
			if ( ! isset($this->_widget_locations[$widget->slug]))
			{
				$this->delete_widget($widget->slug);

				continue;
			}

			// Finally, check if is need and update the widget info
			$widget_file = FCPATH . $this->_widget_locations[$widget->slug] . $widget->slug . EXT;

			if (file_exists($widget_file) &&
				filemtime($widget_file) > $widget->updated_on)
			{

				$this->reload_widget($widget->slug);

				log_message('debug', sprintf('The information of the widget "%s" has been updated', $widget->slug));
			}

			$avaliable[] = $widget;
		}

		return $avaliable;
	}

	function list_uninstalled_widgets()
	{
		$available = $this->widget_m->order_by('slug')->get_all();
		$available_slugs = array();

		foreach ($available as $widget)
		{
			$available_slugs[] = $widget->slug;
		}
		unset($widget);

		$uninstalled = array();
		foreach ($this->_widget_locations as $widget_path)
		{
			$slug = basename($widget_path);

			if ( ! in_array($slug, $available_slugs) AND $widget = $this->read_widget($slug))
			{
				$uninstalled[] = $widget;
			}
		}

		return $uninstalled;
	}

	function get_instance($instance_id)
	{
		$widget = $this->widget_m->get_instance($instance_id);

		if (!$widget){
			return FALSE;
		}

		$this->_map_saved_data_to_widget_options($widget);

		return $widget;
	}

	function _map_saved_data_to_widget_options(stdClass &$widget){
		$saved_data = $this->_unserialize_options($widget->options);

		$options = array();
		$_list_array_keys = array();

		$this->_spawn_widget($widget->slug);

		foreach ($this->_widget->fields as $field)
		{
			$field_name = &$field['field'];

			$options[$field_name] = $this->_get_saved_data_from_field_name($saved_data, $field_name, $_list_array_keys);

			if(array_key_exists($field_name,$saved_data)){
				unset($saved_data[$field_name]);
			}
		}

		//we are cleaning $saved_data array members, which were created by the _unserialize_options method.
		foreach($_list_array_keys as $array_key){
			if(array_key_exists($array_key,$saved_data)){
				unset($saved_data[$array_key]);
			}
		}

		// Any extra data? Merge it in, but options wins!
		if ( !empty($saved_data) )
		{
			$options = array_merge($saved_data, $options);
		}

		$widget->options = $options;
	}

	function _get_saved_data_from_field_name($saved_data, $field_name, &$_list_array_keys){

		$value = "";

		//is field_name referencing an array value ?
		$bracket_index = strpos($field_name, '[');
		if ($bracket_index !== FALSE)
		{
			$array_key = substr($field_name, 0, $bracket_index);
			$_list_array_keys[] = $array_key; //reference the array_key to unset it from the saved_data later

			if(!function_exists('callback')){
				function callback($item_value,$item_key){
					global $saved_data_params;
					if(!empty($saved_data_params['value'])){
						return; //optimization
					}
					$field_name = $saved_data_params['field_name'];
					$bracket_index = strpos($field_name, '[');
					$key = substr($field_name, 0, $bracket_index);
					if($key != $item_key){
						return;
					}

					$field_part = substr($field_name, $bracket_index+1);

					//handle array[key][] and array[key]
					$is_last_key =  substr($field_part, 0, 1) == ']' || ( strpos($field_part,']') == strlen($field_part)-1  );

					if($is_last_key){
						$saved_data_params['value'] = $item_value;
					}else{
						if(!is_array($item_value)){
							return;
						}

						$next_bracket_index = strpos($field_part, ']');
						$next_key = substr($field_part, 0, $next_bracket_index);
						$new_field_name =  $next_key . substr($field_part, $next_bracket_index+1);
						$saved_data_params['field_name'] = $new_field_name;
						return array_walk($item_value,'callback');
					}
				}
			}

			//"ugly" hack to pass by reference data to the array_walk callback :
			//see : http://stackoverflow.com/questions/5155411/pass-by-reference-the-third-parameter-in-php-array-walk-without-a-warning
			global $saved_data_params;
			$saved_data_params = array("value"=>$value,"field_name"=>$field_name);
			array_walk($saved_data,'callback');
			$value = $saved_data_params['value'];
			unset($saved_data_params); //do not need this global var anymore
		}else{
			if( isset($saved_data[$field_name]) ){
				$value = $saved_data[$field_name];
			}
		}

		return set_value($field_name, $value);
	}

	function get_area($id)
	{
		return is_numeric($id) ? $this->widget_m->get_area_by('id', $id) : $this->widget_m->get_area_by('slug', $id);
	}

	function get_widget($id)
	{
		return is_numeric($id) ? $this->widget_m->get_widget_by('id', $id) : $this->widget_m->get_widget_by('slug', $id);
	}

	function read_widget($slug)
	{
		$this->_spawn_widget($slug);

		if ($this->_widget === FALSE OR ! is_subclass_of($this->_widget, 'Widgets'))
		{
			return FALSE;
		}

		$widget = (object) get_object_vars($this->_widget);
		$widget->slug = $slug;
		$widget->module = strpos($this->_widget->path, 'modules/') ? basename(dirname($this->_widget->path)) : NULL;
		$widget->is_addon = strpos($this->_widget->path, 'addons/') !== FALSE;

		return $widget;
	}

	function render($name, $options = array())
	{
		$this->_spawn_widget($name);

		$data = method_exists($this->_widget, 'run') ? call_user_func(array($this->_widget, 'run'), $options) : array();

		// Don't run this widget
		if ($data === FALSE)
		{
			return FALSE;
		}

		// If we have TRUE, just make an empty array
		$data !== TRUE OR $data = array();

		// convert to array
		is_array($data) OR $data = (array) $data;

		$data['options'] = $options;

		return $this->load_view('display', $data);
	}

	function render_backend($name, $options = array())
	{
		$this->_spawn_widget($name);

		// No fields, no backend, no rendering
		if (empty($this->_widget->fields))
		{
			return '';
		}

		$options = array();
		$_arrays = array();

		foreach ($this->_widget->fields as $field)
		{
			$field_name = &$field['field'];
			if (($pos = strpos($field_name, '[')) !== FALSE)
			{
				$key = substr($field_name, 0, $pos);

				if ( ! in_array($key, $_arrays))
				{
					$options[$key] = $this->input->post($key);
					$_arrays[] = $key;
				}
			}
			$options[$field_name] = set_value($field_name, isset($saved_data[$field_name]) ? $saved_data[$field_name] : '');
			unset($saved_data[$field_name]);
		}

		// Any extra data? Merge it in, but options wins!
		if ( ! empty($saved_data))
		{
			$options = array_merge($saved_data, $options);
		}

		// Check for default data if there is any
		$data = method_exists($this->_widget, 'form') ? call_user_func(array(&$this->_widget, 'form'), $options) : array();

		// Options we'rent changed, lets use the defaults
		isset($data['options']) OR $data['options'] = $options;

		return $this->load_view('form', $data);
	}

	function render_area($area)
	{
		if (isset($this->_rendered_areas[$area]))
		{
			return $this->_rendered_areas[$area];
		}

		$widgets = $this->widget_m->get_by_area($area);

		$output = '';

		if ($area == 'dashboard')
		{
			$view = 'admin/widget_wrapper';
		}
		else
		{
			$view = 'widget_wrapper';
		}

		$path = $this->template->get_views_path() . 'modules/widgets/';

		if ( ! file_exists($path . $view . EXT))
		{
			list($path, $view) = Modules::find($view, 'widgets', 'views/');
		}

		// save the existing view array so we can restore it
		$save_path = $this->load->get_view_paths();

		foreach ($widgets as $widget)
		{
			$this->_map_saved_data_to_widget_options($widget);
			$widget->body = $this->render($widget->slug, $widget->options);

			if ($widget->body !== FALSE)
			{
				// add this view location to the array
				$this->load->set_view_path($path);

				$output .= $this->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => array('widget' => $widget), '_ci_return' => TRUE)) . "\n";

				// Put the old array back
				$this->load->set_view_path($save_path);
			}
		}

		$this->_rendered_areas[$area] = $output;

		return $output;
	}

	function reload_widget($slug)
	{
		if (is_array($slug))
		{
			foreach ($slug as $_slug)
			{
				if ( ! $this->reload_widget($_slug))
				{
					return FALSE;
				}
			}
			return TRUE;
		}

		$widget = $this->read_widget($slug);

		return $this->edit_widget(array(
			'title' 		=> $widget->title,
			'slug' 			=> $widget->slug,
			'description' 	=> $widget->description,
			'author' 		=> $widget->author,
			'website' 		=> $widget->website,
			'version' 		=> $widget->version
		));
	}

	function add_widget($input)
	{
		return $this->widget_m->insert_widget($input);
	}

	function edit_widget($input)
	{
		return $this->widget_m->update_widget($input);
	}

	function update_widget_order($id, $position)
	{
		return $this->widget_m->update_widget_order($id, $position);
	}

	function delete_widget($slug)
	{
		return $this->widget_m->delete_widget($slug);
	}

	function add_area($input)
	{
		return $this->widget_m->insert_area((array) $input);
	}

	function edit_area($input)
	{
		return $this->widget_m->update_area((array) $input);
	}

	function delete_area($slug)
	{
		return $this->widget_m->delete_area($slug);
	}

	function add_instance($title, $widget_id, $widget_area_id, $options = array(), $data = array())
	{
		$slug = $this->get_widget($widget_id)->slug;

		if ($error = $this->validation_errors($slug, $data))
		{
			return array('status' => 'error', 'error' => $error);
		}

		// The widget has to do some stuff before it saves
		$options = $this->widgets->prepare_options($slug, $options);

		$this->widget_m->insert_instance(array(
			'title' => $title,
			'widget_id' => $widget_id,
			'widget_area_id' => $widget_area_id,
			'options' => $this->_serialize_options($options),
			'data' => $data
		));

		return array('status' => 'success');
	}

	function edit_instance($instance_id, $title, $widget_area_id, $options = array(), $data = array())
	{
		$slug = $this->widget_m->get_instance($instance_id)->slug;

		if ($error = $this->validation_errors($slug, $options))
		{
			return array('status' => 'error', 'error' => $error);
		}

		// The widget has to do some stuff before it saves
		$options = $this->widgets->prepare_options($slug, $options);

		$this->widget_m->update_instance($instance_id, array(
			'title' => $title,
			'widget_area_id' => $widget_area_id,
			'options' => $this->_serialize_options($options),
			'data' => $data
		));

		return array('status' => 'success');
	}

	function update_instance_order($id, $position)
	{
		return $this->widget_m->update_instance_order($id, $position);
	}

	function delete_instance($id)
	{
		return $this->widget_m->delete_instance($id);
	}

	function validation_errors($name, $options)
	{
//		$_POST = $options;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', lang('global:title'), 'trim|required|max_length[100]');

		$this->_widget OR $this->_spawn_widget($name);

		if (property_exists($this->_widget, 'fields'))
		{
			$this->form_validation->set_rules($this->_widget->fields);
		}

		if ( ! $this->form_validation->run('', FALSE))
		{
			return validation_errors();
		}
	}

	function prepare_options($name, $options = array())
	{
		$this->_widget OR $this->_spawn_widget($name);

		if (method_exists($this->_widget, 'save'))
		{
			return (array) call_user_func(array(&$this->_widget, 'save'), $options);
		}

		return $options;
	}

	private function _spawn_widget($name)
	{
		$widget_path = $this->_widget_locations[$name];
		$widget_file = FCPATH . $widget_path . $name . EXT;

		if (file_exists($widget_file))
		{
			require_once $widget_file;
			$class_name = 'Widget_' . ucfirst($name);

			$this->_widget = new $class_name;
			$this->_widget->path = $widget_path;

			return;
		}

		$this->_widget = NULL;
	}

	public function __get($var)
	{
		if (isset(get_instance()->$var))
		{
			return get_instance()->$var;
		}
	}

	protected function load_view($view, $data = array())
	{
		$path = isset($this->_widget->path) ? $this->_widget->path : $this->path;

		return $view == 'display'

			? $this->parser->parse_string($this->load->_ci_load(array(
				'_ci_path'		=> $path . 'views/' . $view . EXT,
				'_ci_vars'		=> $data,
				'_ci_return'	=> TRUE
			)), array(), TRUE)

			: $this->load->_ci_load(array(
				'_ci_path'		=> $path . 'views/' . $view . EXT,
				'_ci_vars'		=> $data,
				'_ci_return'	=> TRUE
			));
	}

	private function _serialize_options($options)
	{
		return serialize((array) $options);
	}

	private function _unserialize_options($options)
	{
		$options = (array) unserialize($options);

		isset($options['show_title']) OR $options['show_title'] = FALSE;

		return $options;
	}
}