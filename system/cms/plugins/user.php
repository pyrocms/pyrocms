<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Plugin
 *
 * Run checks on a users status
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_User extends Plugin
{
	/**
	 * Logged in
	 *
	 * See if a user is logged in as an if or two-part tag.
	 *
	 * Usage:
	 * {{ user:logged_in group="admin" }}
	 *	<p>Hello admin!</p>
	 * {{ /user:logged_in }}
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
	 * Not logged in
	 *
	 * See if a user is logged out or not part of a group
	 *
	 * Usage:
	 * {{ user:not_logged_in group="admin" }}
	 *	<p>Hello not an admin</p>
	 * {{ /user:not_logged_in }}
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