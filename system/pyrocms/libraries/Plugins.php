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
		$this->set_data($data);
	}

	// ------------------------------------------------------------------------

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
	public function set_data($data)
	{
		isset($data['attributes']) AND $this->attributes = $data['attributes'];
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

		if (file_exists($path = APPPATH.'plugins/'.$class.EXT))
		{
			return $this->_process($path, $class, $method, $data);
		}

		if (file_exists($path = ADDONPATH.'plugins/'.$class.EXT))
		{
			return $this->_process($path, $class, $method, $data);
		}

		// Maybe it's a module
		if ($module = $this->_ci->module_m->get($class))
		{
			// First check core addons then 3rd party
			$path = $module['is_core'] ? APPPATH : ADDONPATH;

			if (file_exists($path = APPPATH.'modules/'.$class.'/plugin'.EXT))
			{
				return $this->_process($path, $class, $method, $data);
			}
		}

		log_message('error', 'Unable to load: '.$class);

		throw new Exception('Unable to load: '.$class);

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
	private function _process($path, $class, $method, $data)
	{
		$class_name = 'Plugin_'.ucfirst(strtolower($class));
		
		if ( ! isset($this->instances[$class]))
		{
			// Load it up
			include_once $path;

			$class_init = new $class_name($data);

			$this->instances[$class] = $class_init;
		}

		else
		{
			$this->instances[$class]->set_data($data);
		}

		if ( ! class_exists($class_name) OR ! method_exists($class_name, $method))
		{
			throw new Exception('Plugin "'.$class_name.'" does not exist.');
			return FALSE;
		}

		return $this->instances[$class]->$method();
	}
}