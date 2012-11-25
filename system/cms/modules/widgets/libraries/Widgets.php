<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Widget library takes care of the logic for widgets
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Widgets\Libraries
 */
class Widgets {

	private $_widget = null;
	private $_rendered_areas = array();
	private $_widget_locations = array();
	
	private $_page_type;

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
		
		// get the "page type" for the widget context so it only runs once
		$this->_page_type = $this->_get_pagetype();
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

			if ( ! in_array($slug, $available_slugs) and $widget = $this->read_widget($slug))
			{
				$uninstalled[] = $widget;
			}
		}

		return $uninstalled;
	}

	function get_instance($instance_id)
	{ 
		$widget = $this->widget_m->get_instance($instance_id);

		if ($widget)
		{	
			$widget->options = $this->_unserialize_options($widget->options);

			return $widget;
		}

		return false;
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

		if ($this->_widget === false or ! is_subclass_of($this->_widget, 'Widgets'))
		{
			return false;
		}

		$widget = (object) get_object_vars($this->_widget);
		$widget->slug = $slug;
		$widget->module = strpos($this->_widget->path, 'modules/') ? basename(dirname($this->_widget->path)) : null;
		$widget->is_addon = strpos($this->_widget->path, 'addons/') !== false;

		return $widget;
	}

	function render($name, $options = array())
	{
		$this->_spawn_widget($name);

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

		return $this->load_view('display', $data);
	}

	function render_backend($name, $saved_data = array())
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
			// are we supposed to show this widget here?
			if (!$this->_check_widget_context($widget)) continue;
			
			$widget->options = $this->_unserialize_options($widget->options);
			$widget->body = $this->render($widget->slug, $widget->options);
			
			if ($widget->body !== false)
			{
				// add this view location to the array
				$this->load->set_view_path($path);

				$output .= $this->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => array('widget' => $widget), '_ci_return' => true)) . "\n";

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

	function add_instance($title, $widget_id, $widget_area_id, $widget_soh, $widget_page_slugs = '', $options = array(), $data = array())
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
			'show_or_hide' => $widget_soh,
			'page_slugs' => $widget_page_slugs,
			'data' => $data
		));

		return array('status' => 'success');
	}

	function edit_instance($instance_id, $title, $widget_area_id, $widget_soh, $widget_page_slugs = '', $options = array(), $data = array())
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
			'show_or_hide' => $widget_soh,
			'page_slugs' => $widget_page_slugs,
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

		if ( ! $this->form_validation->run('', false))
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

		$this->_widget = null;
	}

	function __get($var)
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
				'_ci_return'	=> true
			)), array(), true)

			: $this->load->_ci_load(array(
				'_ci_path'		=> $path . 'views/' . $view . EXT,
				'_ci_vars'		=> $data,
				'_ci_return'	=> true
			));
	}

	private function _serialize_options($options)
	{
		return serialize((array) $options);
	}

	private function _unserialize_options($options)
	{
		$options = (array) unserialize($options);

		isset($options['show_title']) OR $options['show_title'] = false;

		return $options;
	}
				
	/**
	 * checks the "availability" of a widget
	 * this can be set to show or not on specific page(s) like a Drupal block
	 * 
	 * @access private
	 * @param string
	 * @return bool
	 * @uses _get_pagetype()
	 * @uses widget_m model
	 */	
	private function _check_widget_context($widget)
	{
		if (!empty($widget->page_slugs))
		{	
			// split the string
			$slugs = preg_split("/\r\n|\n|\r/", $widget->page_slugs);
			
			// show only on these pages
			if ($widget->show_or_hide == 1)
			{
				if (in_array($this->_page_type, $slugs)) // show on these pages only
				{
					return TRUE;
				}
				else
				{
					// have to check for "blog", since $page might == "category:cat_name"
					if (strpos($this->_page_type, 'category') !== FALSE && in_array('blog', $slugs))
					{
						return TRUE;
					}
					return FALSE;
				}
			} 
			// hide only on these pages
			elseif ($widget->show_or_hide == 0)
			{
				if (in_array($this->_page_type, $slugs)) // do not show on these pages
				{
					return FALSE;
				}
				else
				{
					// have to check for "blog", since $page might == "category:cat_name"
					if (strpos($this->_page_type, 'category') !== FALSE && in_array('blog', $slugs)) // "blog" not allowed
					{
						return FALSE;
					}
					return TRUE;
				}
			}
		}
		
		return TRUE; // not listed, so allow it to show
	}
	
	/**
	 * get the page type from the segments or the breadcrumbs
	 * this returns "home", "category:category_slug", "blog", or page slug from parsed url
	 * 
	 * @access private
	 * @param void
	 * @return string
	 */	 	 	  	 	 	 	
	private function _get_pagetype()
	{
		if (current_url() == BASE_URL) // homepage
		{
			return '<home>';
		}
		
		// check for a custom module (should widgets even be possible to use in custom modules)
		$core_modules = array('blog', 'pages'); // these are only ones available to front side
		$module_name = $this->router->fetch_module();
		if (!in_array($module_name, $core_modules))
		{
			return '<module:' . $module_name . '>';
		}
		
		// get the breadcrumbs
		$data = & $this->load->_ci_cached_vars;
		$first = array_shift($data['template']['breadcrumbs']); // the first element will have the most segments
		
		// get the uri segments
		$segs = $this->uri->segment_array();
				
		// combine them, get rid of duplicates, numeric values and empty strings
		$arr = explode('/', $first['uri']);
		$segments = array_merge($segs, $arr);
		$segments = array_unique($segments);
		foreach($segments as $k=>&$v)
		{
			if (is_numeric($v) || empty($v))
			{
				unset($segments[$k]);
			}
		}
		$segments = array_values($segments);
		
		if (in_array('blog', $segments)) // a blog page of some sort
		{
			if (in_array('category', $segments)) // a category index, archive or post in that category
			{
				return '<category:' . $segments[count($segments) - 1] . '>';	
			}
			else // must be blog index page
			{
				return '<blog>';
			}
		}
		else // must be a page, so return last segment
		{
			return $segments[0];
		}

	}

}