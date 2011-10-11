<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
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
	 * {pyro:user:logged_in group="admin"}
	 *	<p>Hello admin!</p>
	 * {/pyro:user:logged_in}
	 *
	 * @param	array
	 * @return	array
	 */
	public function logged_in()
	{
		$group = $this->attribute('group', NULL);

		if ($this->current_user)
		{
			if ($group AND $group !== $this->current_user->group)
			{
				return '';
			}

			return $this->content() ? $this->content() : TRUE;
		}

		return '';
	}

	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:user:not_logged_in group="admin"}
	 *	<p>Hello not an admin</p>
	 * {/pyro:user:not_logged_in}
	 *
	 * @param	array
	 * @return	array
	 */
	public function not_logged_in()
	{
		$group = $this->attribute('group', NULL);

		// Logged out or not the right user
		if ( ! $this->current_user OR ($group AND $group !== $this->current_user->group))
		{
			return $this->content() ? $this->content() : TRUE;
		}

		return '';
	}

	public function has_cp_permissions()
	{
		if ($this->current_user)
		{
			if ( ! (($this->current_user->group == 'admin') OR $this->permission_m->get_group($this->current_user->group_id)))
			{
				return '';
			}

			return $this->content() ? $this->content() : TRUE;
		}

		return '';
	}

	function __call($foo, $arguments)
	{
		return isset($this->current_user->$foo) ? $this->current_user->$foo : NULL;
	}
}

/* End of file user.php */