<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Global Plugin
 *
 * Make global constants available as tags
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Global extends Plugin
{
	/**
	 * Load a constant
	 *
	 * Magic method to get a constant or global var
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function __call($name, $data)
	{
		// is it a constant?
		if (defined(strtoupper($name)))
		{
			return constant(strtoupper($name));
		}
		// or is it a global variable ($this->controller etc)
		elseif(isset(get_instance()->$name) AND is_scalar($this->$name))
		{
			return $this->$name;
		}
		//neither
		return NULL;
	}
}

/* End of file theme.php */