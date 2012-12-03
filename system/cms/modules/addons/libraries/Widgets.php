<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Widget library takes care of the logic for widgets
 * 
 * @package		PyroCMS\Core\Modules\Widgets\Libraries
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class Widgets 
{
	/**
	 * Current widget in use (yay singletons!)
	 * 
	 * @var	object
	 */
	protected $_widget = null;
	
	/**
	 * Cache of rendered widget areas (html)
	 * 
	 * @var	array
	 */
	protected $_rendered_areas = array();
	
	/**
	 * Locations where widget files are located
	 * 
	 * @var	array
	 */
	protected $_widget_locations = array();

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->load->model('addons/widget_m');
		
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
			$widgets = glob($path.'widgets/*', GLOB_ONLYDIR);

			if ( ! is_array($widgets))
			{
				$widgets = array();
			}

			$module_widgets = glob($path.'modules/*/widgets/*', GLOB_ONLYDIR);

			if ( ! is_array($module_widgets))
			{
				$module_widgets = array();
			}

			$widgets = array_merge($widgets, $module_widgets);

			foreach ($widgets as $widget_path)
			{
				$slug = basename($widget_path);

				// Set this so we know where it is later
				$this->_widget_locations[$slug] = $widget_path.'/';
			}
		}
	}

	/**
	 * List available widget areas
	 * 
	 * <strong>Note:</strong> This method is used mainly for the Control Panel.
	 *
	 * <code>
	 * echo $this->widgets->list_areas();
	 * </code>
	 * 
	 * @return array
	 */
	public function list_areas()
	{
		return $this->widget_m->get_areas();
	}

	/**
	 * List area instances
	 * 
	 * <strong>Note:</strong> This method is used mainly for the Control Panel.
	 *
	 * <code>
	 * echo $this->widgets->list_area_instances();
	 * </code>
	 * 
	 * @return array
	 */
	public function list_area_instances($slug)
	{
		return is_array($slug) ? $this->widget_m->get_by_areas($slug) : $this->widget_m->get_by_area($slug);
	}

	/**
	 * List available widgets
	 * 
	 * These are all installed widgets that are available to be used by the system.
	 * 
	 * <strong>Note:</strong> This method is used mainly for the Control Panel.
	 *
	 * <code>
	 * echo $this->widgets->list_available_widgets();
	 * </code>
	 * 
	 * @return array
	 */
	public function list_available_widgets()
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
			$widget_file = FCPATH.$this->_widget_locations[$widget->slug].$widget->slug.EXT;

			if (file_exists($widget_file) and (filemtime($widget_file) > $widget->updated_on))
			{
				$this->reload_widget($widget->slug);

				log_message('debug', sprintf('The information of the widget "%s" has been updated', $widget->slug));
			}

			$avaliable[] = $widget;
		}

		return $avaliable;
	}

	/**
	 * List uninstalled widgets
	 * 
	 * Called by list_available_widgets() to automatically install any uninstalled widgets
	 * 
	 * <strong>Note:</strong> This method is used mainly for the Control Panel.
	 *
	 * @return array
	 */
	protected function list_uninstalled_widgets()
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

			if ( ! in_array($slug, $available_slugs) and ($widget = $this->read_widget($slug)))
			{
				$uninstalled[] = $widget;
			}
		}

		return $uninstalled;
	}

	/**
	 * Get Instance
	 * 
	 * Nothing to do with the CodeIgniter get instance, this refers to Widget Instance data
	 *
	 * <code>
	 * echo $this->widgets->get_instance($instance_id);
	 * </code>
	 * 
	 * @param  int    $instance_id	Widget instance id number
	 * @return array
	 */
	public function get_instance($instance_id)
	{
		$widget = $this->widget_m->get_instance($instance_id);

		if ($widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);

			return $widget;
		}

		return false;
	}

	/**
	 * Get Area
	 *
	 * <code>
	 * echo $this->widgets->get_area($id);
	 * </code>
	 * 
	 * @param  int    $id	Widget area id number
	 * @return object stdObject
	 */
	public function get_area($id)
	{
		return is_numeric($id) ? $this->widget_m->get_area_by('id', $id) : $this->widget_m->get_area_by('slug', $id);
	}

	/**
	 * Read widget
	 *
	 * Spawn a widget and get some basic information back, such as the module and wether its an addon or not
	 * 
	 * <code>
	 * echo $this->widgets->read_widget($id);
	 * </code>
	 * 
	 * @param  int    $slug	
	 * @return object stdObject
	 */
	public function read_widget($slug)
	{
		$this->_spawn_widget($slug);

		if ($this->_widget === false or ! is_subclass_of($this->_widget, 'Widgets'))
		{
			return false;
		}

		$widget = (object) get_object_vars($this->_widget);
		$widget->slug = $slug;
		$widget->module = strpos($this->_widget->path, 'modules/') ? basename(dirname($this->_widget->path)) : null;
		$widget->is_addon = strpos($this->_widget->path, 'system/') === false;

		return $widget;
	}

	/**
	 * Render
	 *
	 * Display the actual widget HTML based on slug and options provided
	 * 
	 * <code>
	 * echo $this->widgets->render('rss_feed', array('feed_url' => 'http://philsturgeon.co.uk/blog/feed.rss'));
	 * </code>
	 * 
	 * @param  int    $slug	    Widget slug
	 * @param  array  $options	Options (data saved in the DB or provided on-the-fly)
	 * @return string
	 */
	public function render($slug, array $options = array())
	{
		$this->_spawn_widget($slug);

		$data = method_exists($this->_widget, 'run') ? call_user_func(array($this->_widget, 'run'), $options) : array();

		// Don't run this widget
		if ($data === false)
		{
			return false;
		}

		// If we have true, just make an empty array
		$data !== true OR $data = array();

		// convert to array
		is_array($data) OR $data = (array) $data;

		$data['options'] = $options;
		
		// Check that the widget is enabled = 1 , if it's 1
		// we go ahead and return it
		$result = $this->db->select('enabled')
		->where('slug', $name)
		->get('widgets');
		if($result->row()->enabled == 1)
		{
			return $this->load_view('display', $data);
		}	
	}

	/**
	 * Render Backend
	 *
	 * Display the widget form for the Control Panel
	 * 
	 * @param  int    $slug	    	Widget slug
	 * @param  array  $saved_data	Options (data saved in the DB or provided on-the-fly)
	 * @return string
	 */
	public function render_backend($slug, array $saved_data = array())
	{
		$this->_spawn_widget($slug);

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
			if (($pos = strpos($field_name, '[')) !== false)
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

	/**
	 * Render Area
	 *
	 * Display the widget area HTML
	 * 
	 * <code>
	 * echo $this->widgets->read_widget('sidebar');
	 * </code>
	 * 
	 * @param  int    $slug	    Widget slug
	 * @param  array  $options	Options (data saved in the DB or provided on-the-fly)
	 * @return string
	 */
	public function render_area($area)
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

		$path = $this->template->get_views_path().'modules/widgets/';

		if ( ! file_exists($path.$view.EXT))
		{
			list($path, $view) = Modules::find($view, 'widgets', 'views/');
		}

		// save the existing view array so we can restore it
		$save_path = $this->load->get_view_paths();

		foreach ($widgets as $widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);
			$widget->body = $this->render($widget->slug, $widget->options);

			if ($widget->body !== false)
			{
				// add this view location to the array
				$this->load->set_view_path($path);

				$output .= $this->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => array('widget' => $widget), '_ci_return' => true))."\n";

				// Put the old array back
				$this->load->set_view_path($save_path);
			}
		}

		$this->_rendered_areas[$area] = $output;

		return $output;
	}

	public function reload_widget($slug)
	{
		if (is_array($slug))
		{
			foreach ($slug as $_slug)
			{
				if ( ! $this->reload_widget($_slug))
				{
					return false;
				}
			}
			return true;
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

	public function add_widget($input)
	{
		return $this->widget_m->insert_widget($input);
	}

	public function edit_widget($input)
	{
		return $this->widget_m->update_widget($input);
	}

	public function update_widget_order($id, $position)
	{
		return $this->widget_m->update_widget_order($id, $position);
	}

	public function delete_widget($slug)
	{
		return $this->widget_m->delete_widget($slug);
	}

	public function add_area($input)
	{
		return $this->widget_m->insert_area((array) $input);
	}

	public function edit_area($input)
	{
		return $this->widget_m->update_area((array) $input);
	}

	public function delete_area($slug)
	{
		return $this->widget_m->delete_area($slug);
	}

	public function add_instance($title, $widget_id, $widget_area_id, $options = array(), $data = array())
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

	public function edit_instance($instance_id, $title, $widget_area_id, $options = array(), $data = array())
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

	public function update_instance_order($id, $position)
	{
		return $this->widget_m->update_instance_order($id, $position);
	}

	public function delete_instance($id)
	{
		return $this->widget_m->delete_instance($id);
	}

	public function validation_errors($name, $options)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', lang('global:title'), 'trim|required|max_length[100]');

		$this->_widget OR $this->_spawn_widget($name);

		if (property_exists($this->_widget, 'fields'))
		{
			$this->form_validation->set_rules($this->_widget->fields);
		}

		if ( ! $this->form_validation->run('', false))
		{
			return validation_errors();
		}
	}

	public function prepare_options($name, array $options = array())
	{
		$this->_widget or $this->_spawn_widget($name);

		if (method_exists($this->_widget, 'save'))
		{
			return (array) call_user_func(array(&$this->_widget, 'save'), $options);
		}

		return $options;
	}

	protected function _spawn_widget($name)
	{
		$widget_path = $this->_widget_locations[$name];
		$widget_file = FCPATH.$widget_path.$name.EXT;

		if (file_exists($widget_file))
		{
			require_once $widget_file;
			$class_name = 'Widget_'.ucfirst($name);

			$this->_widget = new $class_name;
			$this->_widget->path = $widget_path;

			return;
		}

		$this->_widget = null;
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
				'_ci_path'		=> $path.'views/'.$view.EXT,
				'_ci_vars'		=> $data,
				'_ci_return'	=> true
			)), array(), true)

			: $this->load->_ci_load(array(
				'_ci_path'		=> $path.'views/'.$view.EXT,
				'_ci_vars'		=> $data,
				'_ci_return'	=> true
			));
	}

	protected function _serialize_options($options)
	{
		return serialize((array) $options);
	}

	protected function _unserialize_options($options)
	{
		$options = (array) unserialize($options);

		isset($options['show_title']) OR $options['show_title'] = false;

		return $options;
	}
}