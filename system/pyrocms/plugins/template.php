<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Template extends Plugin
{
	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:template:has_partial name="sidebar"}
	 *	<p>Hello admin!</p>
	 * {/pyro:template:has_partial}
	 *
	 * @param	array
	 * @return	array
	 */
	function has_partial()
	{
		$name = $this->attribute('name');

		$data =& $this->load->_ci_cached_vars;

		if (isset($data['template']['partials'][$name]))
		{
			return array(array('partial' => $data['template']['partials'][$name]));
		}

		return array();
	}

	function __call($foo, $arguments)
	{
		$data =& $this->load->_ci_cached_vars;
		
		return isset($data['template'][$foo]) ? $data['template'][$foo] : NULL;
	}
}

/* End of file theme.php */