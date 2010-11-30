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

    function __get($var)
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
	public function set_data($data)
	{
		isset($data['content']) AND $this->content = $data['content'];
		isset($data['attributes']) AND $this->attributes = $data['attributes'];
	}
}

class Plugins
{
	private $loaded = array();

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

		foreach (array(APPPATH, ADDONPATH) as $directory)
		{
			if (file_exists($path = $directory.'plugins/'.$class.EXT))
			{
				return $this->_process($path, $class, $method, $data);
			}

			// Maybe it's a module
			if (module_exists($class))
			{
				if (file_exists($path = $directory.'modules/'.$class.'/plugin'.EXT))
				{
					return $this->_process($path, $class, $method, $data);
				}
			}
		}

		log_message('error', 'Unable to load: '.$class);

		return '';
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
		$class = strtolower($class);
		$class_name = 'Plugin_'.ucfirst($class);

		if ( ! isset($this->loaded[$class]))
		{
			include $path;
			$this->loaded[$class] = TRUE;
		}

		$class_init = new $class_name;
		$class_init->set_data($data);

		if ( ! class_exists($class_name))
		{
			throw new Exception('Plugin "'.$class_name.'" does not exist.');
			return FALSE;
		}

		return $class_init->$method();
	}
}