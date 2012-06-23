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

	/**
	 * Array of data for the currently
	 * logged in user.
	 */
	public $user_profile_data = array();

	// --------------------------------------------------------------------------

	/**
	 * Logged in
	 *
	 * See if a user is logged in as an if or two-part tag.
	 *
	 * Usage:
	 *   {{ user:logged_in group="admin" }}
	 *     <p>Hello admin!</p>
	 *   {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function logged_in()
	{
		$group = $this->attribute('group', null);

		if ($this->current_user)
		{
			if ($group AND $group !== $this->current_user->group)
			{
				return '';
			}

			return $this->content() ? $this->content() : true;
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
	 * {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function not_logged_in()
	{
		$group = $this->attribute('group', null);

		// Logged out or not the right user
		if ( ! $this->current_user OR ($group AND $group !== $this->current_user->group))
		{
			return $this->content() ? $this->content() : true;
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
	 * 3{{ endif }}
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

			return $this->content() ? $this->content() : true;
		}

		return '';
	}

	// --------------------------------------------------------------------------

	public function profile_fields()
	{
		$profile_data = $this->get_user_profile(false);

		if (is_null($profile_data))
		{
			return null;
		}

		$this->lang->load('streams_core/pyrostreams');
		$this->lang->load('users/user');

		$plugin_data = array();

		$plugin_data[] = array(
							'value'		=> $profile_data['email'],
							'name'		=> lang('user_email'),
							'slug'		=> 'email'
						);

		$plugin_data[] = array(
							'value'		=> $profile_data['username'],
							'name'		=> lang('user_username'),
							'slug'		=> 'username'
						);

		$plugin_data[] = array(
							'value'		=> $profile_data['group_description'],
							'name'		=> lang('user_group_label'),
							'slug'		=> 'group_name'
						);		

		$plugin_data[] = array(
							'value'		=> date($this->settings->get('date_format'), $profile_data['last_login']),
							'name'		=> lang('profile_last_login_label'),
							'slug'		=> 'email'
						);

		$plugin_data[] = array(
							'value'		=> date($this->settings->get('date_format'), $profile_data['created_on']),
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
						'value'		=> date($this->settings->get('date_format'), $profile_data['updated_on']),
						'name'		=> lang('profile_updated_on'),
						'slug'		=> 'updated_on'
					);

		foreach($this->ion_auth_model->user_stream_fields as $key => $field)
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

		return array($profile_data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a user's profile data.
	 * 
	 */
	private function get_user_profile($plugin_call = true)
	{
		$user_id = $this->attribute('user_id', null);

		// If we do not have a user id and there is
		// no currently logged in user, there is nothing to display.
		if (is_null($user_id) and ! isset($this->current_user->id))
		{
			return null;
		}
		elseif (is_null($user_id) and isset($this->current_user->id))
		{
			// Otherwise, we can use the current user id
			$user_id = $this->current_user->id;
		}

		$user = $this->ion_auth_model->get_user($user_id)->row_array();

		// Nobody needs these as profile fields.
		unset($user['password']);
		unset($user['salt']);

		// Got through each stream field and see if we need to format it
		// for plugin return (ie if we haven't already done that).
		foreach ($this->ion_auth_model->user_stream_fields as $field_key => $field_data)
		{
			if($plugin_call)
			{
				if ( ! isset($this->user_profile_data[$user_id]['plugin'][$field_key]))
				{
					$this->user_profile_data[$user_id]['plugin'][$field_key] = $this->row_m->format_column(
																			$field_key,
																			$user[$field_key],
																			$user['profile_id'],
																			$field_data->field_type,
																			$field_data->field_data,
																			$this->ion_auth_model->user_stream,
																			true);
				}
				
				$user[$field_key] = $this->user_profile_data[$user_id]['plugin'][$field_key];
			}
			else
			{
				if ( ! isset($this->user_profile_data[$user_id]['pre_formatted'][$field_key]))
				{
					$this->user_profile_data[$user_id]['pre_formatted'][$field_key] = $this->row_m->format_column(
																			$field_key,
																			$user[$field_key],
																			$user['profile_id'],
																			$field_data->field_type,
																			$field_data->field_data,
																			$this->ion_auth_model->user_stream,
																			false);
				}
				
				$user[$field_key] = $this->user_profile_data[$user_id]['pre_formatted'][$field_key];
			}

		}

		return $user;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single user variable
	 *
	 * @param 	string - the variable to get
	 * @param 	int - the is of the user
	 * @return 	string - the formatted column
	 */
	private function get_user_var($var, $user_id)
	{
		if (isset($this->user_profile_data[$user_id]['plugin'][$var]))
		{
			return $this->user_profile_data[$user_id]['plugin'][$var];
		}
		
		$user = $this->ion_auth_model->get_user($user_id)->row_array();

		// Is this a user stream field?
		if(array_key_exists($var, $this->ion_auth_model->user_stream_fields))
		{
			$formatted_column = $this->row_m->format_column(
												$var,
												$user[$var],
												$user['profile_id'],
												$this->ion_auth_model->user_stream_fields->{$var}->field_type,
												$this->ion_auth_model->user_stream_fields->{$var}->field_data,
												$this->ion_auth_model->user_stream,
												true);
		}
		else
		{
			$formatted_column = $user[$var];
		}

		// Save for later user
		$this->user_profile_data[$user_id]['plugin'][$var] = $formatted_column;

		if (is_array($formatted_column))
		{
			return array($formatted_column);
		}
		else
		{
			return $formatted_column;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Load a variable
	 *
	 * Magic method to get a user variable. This is where
	 * the user_id gets set to the current user if none
	 * is specified.
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