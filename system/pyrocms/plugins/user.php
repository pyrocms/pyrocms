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
class Plugin_User extends Plugin
{
	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:helper:lang line="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	function logged_in()
	{
		$group = $this->attribute('group', NULL);

		if ($this->user)
		{
			if($group AND $group !== $this->user->group)
			{
				return '';
			}

			return $this->content();
		}
		
		return '';
	}

	function __call($foo, $arguments)
	{
		return $this->user->$foo;
	}
}

/* End of file theme.php */