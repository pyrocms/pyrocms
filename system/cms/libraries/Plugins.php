<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Libraries
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 * Central library for Plugin logic
 */
abstract class Plugin
{
	private $attributes = array();
	private $content = array();

	// ------------------------------------------------------------------------

	/**
	 * Set Data
	 *
	 * Set Data for the plugin. Avoid doing this in constructor so we dont force logic on developers
	 *
	 * @param	array - Content of the tags if any
	 * @param	array - Attributes passed to the plugin
	 * @return 	array
	 */
	public function set_data($content, $attributes)
	{
		$content AND $this->content = $content;
		$attributes AND $this->attributes = $attributes;
	}

	// ------------------------------------------------------------------------

	public function __get($var)
	{
		return get_instance()->$var;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get param
	 *
	 * This is a helper used from the parser files to process a list of params
	 *
	 * @param	array - Params passed from view
	 * @param	array - Array of default params
	 * @return 	array
	 */
	public function content()
	{
		return $this->content;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get param
	 *
	 * This is a helper used from the parser files to process a list of params
	 *
	 * @param	array - Params passed from view
	 * @param	array - Array of default params
	 * @return 	array
	 */
	public function attributes()
	{
		return $this->attributes;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get param
	 *
	 * This is a helper used from the parser files to process a list of params
	 *
	 * @param	array - Params passed from view
	 * @param	array - Array of default params
	 * @return 	array
	 */
	public function attribute($param, $default = NULL)
	{
		return isset($this->attributes[$param]) ? $this->attributes[$param] : $default;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get param
	 *
	 * This is a helper used from the parser files to process a list of params
	 *
	 * @param	array - Params passed from view
	 * @param	array - Array of default params
	 * @return 	array
	 */
	public function module_view($module, $view, $vars = array())
	{
		if (file_exists($this->template->get_views_path() . 'modules/' . $module . '/' . $view . (pathinfo($view, PATHINFO_EXTENSION) ? '' : '.php')))
		{
			$path = $this->template->get_views_path() . 'modules/' . $module . '/';
		}
		else
		{
			list($path, $view) = Modules::find($view, $module, 'views/');
		}

		// save the existing view array so we can restore it
		$save_path = $this->load->get_view_paths();

		// add this view location to the array
		$this->load->set_view_path($path);

		$content = $this->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => ((array) $vars), '_ci_return' => TRUE));

		// Put the old array back
		$this->load->set_view_path($save_path);

		return $content;
	}
}

class Plugins
{
	private $loaded = array();

	public function __construct()
	{
		$this->_ci = & get_instance();
	}

	public function locate($plugin, $attributes, $content)
	{
		if (strpos($plugin, ':') === FALSE)
		{
			return FALSE;
		}
		// Setup our paths from the data array
		list($class, $method) = explode(':', $plugin);

		foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) as $directory)
		{
			if (file_exists($path = $directory.'plugins/'.$class.'.php'))
			{
				return $this->_process($path, $class, $method, $attributes, $content);
			}

			else if (defined('ADMIN_THEME') and file_exists($path = APPPATH.'themes/'.ADMIN_THEME.'/plugins/'.$class.'.php'))
			{
				return $this->_process($path, $class, $method, $attributes, $content);
			}

			// Maybe it's a module
			if (module_exists($class))
			{
				if (file_exists($path = $directory . 'modules/' . $class . '/plugin.php'))
				{
					$dirname = dirname($path).'/';

					// Set the module as a package so I can load stuff
					$this->_ci->load->add_package_path($dirname);

					$response = $this->_process($path, $class, $method, $attributes, $content);

					$this->_ci->load->remove_package_path($dirname);

					return $response;
				}
			}
		}

		log_message('debug', 'Unable to load: ' . $class);

		return FALSE;
	}

	 // --------------------------------------------------------------------

	/**
	 * Process
	 *
	 * Just process the class
	 *
	 * @access	private
	 * @param	object
	 * @param	string
	 * @param	array
	 * @return	mixed
	 */
	private function _process($path, $class, $method, $attributes, $content)
	{
		$class = strtolower($class);
		$class_name = 'Plugin_'.ucfirst($class);

		if ( ! isset($this->loaded[$class]))
		{
			include $path;
			$this->loaded[$class] = TRUE;
		}

		if ( ! class_exists($class_name))
		{
//			throw new Exception('Plugin "' . $class_name . '" does not exist.');
//			return FALSE;

			log_message('error', 'Plugin class "' . $class_name . '" does not exist.');

			return FALSE;
		}

		$class_init = new $class_name;
		$class_init->set_data($content, $attributes);

		if ( ! is_callable(array($class_init, $method)))
		{
			// But does a property exist by that name?
			if (property_exists($class_init, $method))
			{
				return TRUE;
			}

//			throw new Exception('Method "' . $method . '" does not exist in plugin "' . $class_name . '".');
//			return FALSE;

			log_message('error', 'Plugin method "' . $method . '" does not exist on class "' . $class_name . '".');

			return FALSE;
		}

		return call_user_func(array($class_init, $method));
	}
}
