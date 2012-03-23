<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Plugin
 *
 * Run checks on a users status
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_User extends Plugin
{

	public $current_user_profile_data = array();

	// --------------------------------------------------------------------------

	public $user_stream;

	// --------------------------------------------------------------------------

	public $user_stream_fields;

	// --------------------------------------------------------------------------

	public function __construct()
	{
		$this->load->driver('Streams');

		$this->user_stream = $this->streams_m->get_stream('profiles', true, 'users');
		$this->user_stream_fields = $this->streams_m->get_stream_fields($this->user_stream->id);

		if (isset($this->current_user->id))
		{
			$row = $this->db->limit(1)->where('user_id', $this->current_user->id)->get('profiles')->row_array();

			$this->current_user_profile_data = $this->row_m->format_row($row, $this->user_stream_fields, $this->user_stream, false, true);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Logged in
	 *
	 * See if a user is logged in as an if or two-part tag.
	 *
	 * Usage:
	 *   {{ user:logged_in group="admin" }}
	 *     <p>Hello admin!</p>
	 *   {{ /user:logged_in }}
	 *
	 * @return boolean State indicator.
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

	// --------------------------------------------------------------------------

	/**
	 * Not logged in
	 *
	 * See if a user is logged out or not part of a group
	 *
	 * Usage:
	 * {{ user:not_logged_in group="admin" }}
	 * 	<p>Hello not an admin</p>
	 * {{ /user:not_logged_in }}
	 *
	 * @return boolean State indicator.
	 */
	public function not_logged_in()
	{
		$group = $this->attribute('group', NULL);

		// Logged out or not the right user
		if (!$this->current_user OR ($group AND $group !== $this->current_user->group))
		{
			return $this->content() ? $this->content() : TRUE;
		}

		return '';
	}

	// --------------------------------------------------------------------------

	/**
	 * Has Control Panel permissions
	 *
	 * See if a user can access the control panel.
	 *
	 * Usage:
	 * {{ user:has_cp_permissions}}
	 * 	<a href="/admin">Access the Control Panel</a>
	 * {{ /user:has_cp_permissions }}
	 * 
	 * @return boolean State indicator.
	 */
	public function has_cp_permissions()
	{
		if ($this->current_user)
		{
			if (!(($this->current_user->group == 'admin') OR $this->permission_m->get_group($this->current_user->group_id)))
			{
				return '';
			}

			return $this->content() ? $this->content() : TRUE;
		}

		return '';
	}

	// --------------------------------------------------------------------------

	public function profile_fields()
	{
		$profile_data = $this->get_user_profile(false);

		if (is_null($profile_data))
		{
			return 'null';
		}

		$this->lang->load('streams_core/pyrostreams');
		$this->lang->load('users/user');

		$plugin_data = array();

		$user = $this->ion_auth->get_user($profile_data['user_id']);

		$plugin_data[] = array(
							'value'		=> $user->email,
							'name'		=> lang('user_email'),
							'slug'		=> 'email'
						);

		$plugin_data[] = array(
							'value'		=> $user->username,
							'name'		=> lang('user_username'),
							'slug'		=> 'username'
						);

		$plugin_data[] = array(
							'value'		=> $user->group_description,
							'name'		=> lang('user_group_label'),
							'slug'		=> 'group_name'
						);		

		$plugin_data[] = array(
							'value'		=> date($this->settings->item('date_format'), $user->last_login),
							'name'		=> lang('profile_last_login_label'),
							'slug'		=> 'email'
						);

		$plugin_data[] = array(
							'value'		=> date($this->settings->item('date_format'), $user->created_on),
							'name'		=> lang('profile_registred_on_label'),
							'slug'		=> 'registered_on'
						);

		$plugin_data[] = array(
							'value'		=> date($this->settings->item('date_format'), $user->created_on),
							'name'		=> lang('profile_registred_on_label'),
							'slug'		=> 'registered_on'
						);

		// Display name and updated on
		$plugin_data[] = array(
						'value'		=> $profile_data['display_name'],
						'name'		=> lang('profile_display_name'),
						'slug'		=> 'display_name'
					);
		$plugin_data[] = array(
						'value'		=> date($this->settings->item('date_format'), $profile_data['updated_on']),
						'name'		=> lang('profile_updated_on'),
						'slug'		=> 'updated_on'
					);

		foreach($this->user_stream_fields as $key => $field)
		{
			$name = (lang($field->field_name)) ? $this->lang->line($field->field_name) : $field->field_name;

			$plugin_data[] = array(
								'value'		=> $profile_data[$key],
								'name'		=> $this->fields->translate_label($name),
								'slug'		=> $field->field_slug
							);
		
			unset($name);
		}


		return $plugin_data;
	}

	// --------------------------------------------------------------------------

	public function profile()
	{
		$profile_data = $this->get_user_profile();

		if (is_null($profile_data))
		{
			return null;
		}

		// We don't want the ID - it's pretty useless
		unset($profile_data['id']);

		// Get the rest of the fields
		$user = $this->ion_auth->get_user($profile_data['user_id']);

		$profile_data['email'] 			= $user->email;
		$profile_data['username'] 		= $user->username;
		$profile_data['id'] 			= $user->id;
		$profile_data['group'] 			= $user->group_name;
		$profile_data['last_login'] 	= $user->last_login;

		return $profile_data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Current uri string
	 * 
	 * @return string The current URI string.
	 */
	private function get_user_profile($plugin_call = true)
	{
		$user_id = $this->attribute('user_id', null);

		// If we do not have a user id and there is
		// no currently logge in user, there's nothing we can do
		if (is_null($user_id) and ! isset($this->current_user->id))
		{
			return null;
		}
		elseif (is_null($user_id) and isset($this->current_user->id))
		{
			// Otherwise, we can use the current user id
			$user_id = $this->current_user->id;
		}

		// Does the stuff we got in the construct?
		// If so, we are almost there
		if ($this->current_user_profile_data['user_id'] == $user_id and $plugin_call === true)
		{
			$profile_data = $this->current_user_profile_data;
		}
		else
		{
			$row = $this->db->limit(1)->where('user_id', $this->current_user->id)->get('profiles')->row_array();
			$profile_data = $this->row_m->format_row($row, $this->user_stream_fields, $this->user_stream, false, $plugin_call, array('created_by'));

			// Display name and updated_on go manually
			$profile_data['display_name'] 	= $row['display_name'];
			$profile_data['updated_on'] 	= $row['updated_on'];
		}

		return $profile_data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single user variable
	 */
	private function get_user_var($var, $user_id)
	{
		if ($this->current_user_profile_data['user_id'] == $user_id)
		{
			if(isset($this->current_user_profile_data[$var]))
			{
				return $this->current_user_profile_data[$var];
			}
		}
		else
		{
			// Sigh - we need to grab this.
			// @todo - we need a function that just grabs one field.
			$row = $this->db->limit(1)->where('user_id', $this->current_user->id)->get('profiles')->row_array();
			$profile_data = $this->row_m->format_row($row, $this->user_stream_fields, $this->user_stream, false, true, array('created_by'));

			return $profile_data[$var];
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Load a variable
	 *
	 * Magic method to get the setting.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function __call($name, $data)
	{
		$user_id = $this->attribute('user_id', null);

		// If we do not have a user id and there is
		// no currently logge in user, there's nothing we can do
		if (is_null($user_id) and ! isset($this->current_user->id))
		{
			return null;
		}
		elseif (is_null($user_id) and isset($this->current_user->id))
		{
			// Otherwise, we can use the current user id
			$user_id = $this->current_user->id;
		}

		return $this->get_user_var($name, $user_id);
	}

}