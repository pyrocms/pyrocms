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

	function __construct($data)
	{
		isset($data['attributes']) AND $this->attributes = $data['attributes'];
	}

    function __get($var)
    {
		return CI_Base::get_instance()->$var;
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
}

class Plugins
{
	private $instances = array();

	function __construct()
	{
		$this->_ci = & get_instance();
	}

	function locate($data)
	{
		if ( ! isset($data['segments'][0]) OR ! isset($data['segments'][1]))
		{
			return FALSE;
		}

		// Setup our paths from the data array
		$class = $data['segments'][0];
		$method = $data['segments'][1];
		
		$addon = strtolower($class);

		// Get active add-ons
		$this->_ci->load->model('modules/module_m');
		$modules = $this->_ci->module_m->get_all();

		if (file_exists($path = ADDONPATH.'plugins/'.$class.EXT))
		{
			return $this->_process($path, $class, $method, $data);
		}

		foreach ($modules as $module)
		{
			// First check core addons then 3rd party
			if ($module['is_core'] == 1)
			{
				if (file_exists($path = APPPATH.'modules/'.$class.'/plugin'.EXT))
				{
					return $this->_process($path, $class, $method, $data);
				}
			}
			else
			{
				if (file_exists($path = ADDONPATH.'modules/'.$class.'/plugin'.EXT))
				{
					return $this->_process($path, $class, $method, $data);
				}
			}

			log_message('error', 'Unable to load: '.$class);
		}
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
	private function _process($path, $class, $method, $data)
	{
		if ( ! isset($this->instances[$class]))
		{
			// Load it up
			include_once $path;

			$class_name = 'Plugin_'.ucfirst(strtolower($class));
			$class_init = new $class_name($data);

			$this->instances[$class] = $class_init;
		}

		if ( ! class_exists($class_name) OR ! method_exists($class_name, $method))
		{
			return FALSE;
		}
		
		return $this->instances[$class]->$method();
	}
}