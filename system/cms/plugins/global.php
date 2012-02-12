<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global Plugin
 *
 * Make global constants available as tags
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Global extends Plugin
{

	/**
	 * Load a constant
	 *
	 * Magic method to get a constant or global var
	 *
	 * @return	null|string
	 */
	function __call($name, $data)
	{
		// A constant
		if (defined(strtoupper($name)))
		{
			return constant(strtoupper($name));
		}
		
		// A global variable ($this->controller etc)
		elseif (isset(get_instance()->$name) AND is_scalar($this->$name))
		{
			return $this->$name;
		}

		return NULL;
	}

}