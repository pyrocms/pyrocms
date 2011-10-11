<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Variable Plugin
 *
 * Allows tags to be used in content items.
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Variables extends Plugin
{	
	/**
	 * Load a variable
	 *
	 * Magic method to get the variable.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function __call($name, $arguments)
	{
		$this->load->library('variables/variables');
		return $this->variables->$name;
	}
	
	/**
	 * Load a variable
	 *
	 * Magic method to get the variable.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function set()
	{
		$this->variables->{$this->attribute('name')} = $this->attribute('value');
	}
}

/* End of file plugin.php */