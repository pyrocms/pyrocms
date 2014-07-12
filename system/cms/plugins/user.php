<?php

use Cartalyst\Sentry;
use Pyro\Module\Users;

/**
 * User Plugin
 *
 * Run checks on a users status
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_User extends Plugin
{
	public $version = '1.0.0';

	public $name = array(
		'en' => 'User',
	);

	public $description = array(
		'en' => 'Access current user profile variables and settings.',
		'el' => 'Πρόσβαση σε μεταβλητές και ρυθμίσεις προφίλ του εκάστοτε χρήστη.',
            'fa' => 'دسترسی به پروفایل کاربر حاضر و تنظیمات',
		'fr' => 'Accéder aux données de l\'utilisateur courant.',
		'it' => 'Accedi alle variabili del profilo e alle impostazioni dell\'utente corrente'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 * @todo  I did the __call magic method... the others still need to be documented
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array();

		// dynamically build the array for the magic method __call
		$user = $this->current_user->toArray();
		ksort($user);

		foreach ($user as $key => $value)
		{
			if (in_array($key, array('password', 'salt'))) continue;

			$info[$key]['description'] = array(
				'en' => 'Displays the '.$key.' for the current user.'
			);
			$info[$key]['single'] = true;
			$info[$key]['double'] = (is_array($value) ? true : false);
			$info[$key]['variables'] = (is_array($value) ? implode('|', array_keys($value)) : '');
			$info[$key]['params'] = array();
		}

		return $info;
	}

	public $user_data = array();

	/**
	 * Array of data for the currently
	 * logged in user.
	 */
	public $user_profile_data = array();

	/**
	 * Logged in
	 *
	 * See if a user is logged in as an if or two-part tag.
	 *
	 * Usage:
	 *
	 *     {{ if {user:logged_in group="admin"} }}
	 *         <p>Hello admin!</p>
	 *     {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function logged_in()
	{
		$group = $this->attribute('group');

		if ( ! $this->current_user) {
			return null;
		}

        $loggedIn = false;

		if ( ! is_null($group)) {
            foreach (explode('|', $group) as $group) {
                try {
                    $group = $this->sentry->getGroupProvider()->findByName($group);
                } catch (Sentry\Groups\GroupNotFoundException $e) {
                    continue;
                }

                if ($this->current_user->inGroup($group)) {
                    $loggedIn = true;
                }
            }
		}

		return $loggedIn ? $this->content() : true;
	}

    /**
     * Has access
     *
     * See if a user has access to a role
     *
     * Usage:
     *
     *     {{ if {user:has_access group="foo.bar"} }}
     *            <p>Hello not an admin</p>
     *     {{ endif }}
     *
     * @return boolean State indicator.
     */
    public function has_access()
    {
        $role = $this->attribute('role', null);

        $hasAccess = false;

        if (ci()->current_user) {
            $hasAccess = (bool) ci()->current_user->hasAccess($role);
        }

        return $hasAccess ? $this->content() : true;
    }

	/**
	 * Not logged in
	 *
	 * See if a user is logged out or not part of a group
	 *
	 * Usage:
	 *
	 *     {{ if {user:not_logged_in group="admin"} }}
	 *            <p>Hello not an admin</p>
	 *     {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function not_logged_in()
	{
		$group = $this->attribute('group', null);

		// Logged out or not the right user
		if ($this->current_user) {

			try {
				$group = $this->sentry->getGroupProvider()->findByName($group);
			} catch (Sentry\Groups\GroupNotFoundException $e) {
				return $this->content() ?: true;
			}

			if ($this->current_user->inGroup($group)) {
				return;
			}
		}

		return $this->content() ?: true;
	}

	/**
	 * Has Control Panel permissions
	 *
	 * See if a user can access the control panel.
	 *
	 * Usage:
	 *
	 *     {{ user:has_cp_permissions}}
	 *         <a href="/admin">Access the Control Panel</a>
	 *     {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function has_cp_permissions()
	{
		if ($this->current_user and $this->current_user->getMergedPermissions()) {
			return $this->content() ?: true;
		}
	}

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
			'value' => $profile_data['email'],
			'name'  => lang('global:email'),
			'slug'  => 'email'
		);

		$plugin_data[] = array(
			'value' => $profile_data['username'],
			'name'  => lang('user:username'),
			'slug'  => 'username'
		);

		$plugin_data[] = array(
			'value' => $profile_data['group_description'],
			'name'  => lang('user:group_label'),
			'slug'  => 'group_name'
		);

		$plugin_data[] = array(
			'value' => date(Settings::get('date_format'), strtotime($profile_data['last_login'])),
			'name'  => lang('user:profile_last_login_label'),
			'slug'  => 'last_login'
		);

		$plugin_data[] = array(
			'value' => $profile_data['created_at']->format(Settings::get('date_format')),
			'name'  => lang('user:profile_registred_on_label'),
			'slug'  => 'registered_on'
		);

		// Display name and updated on
		$plugin_data[] = array(
			'value' => $profile_data['display_name'],
			'name'  => lang('user:profile_display_name'),
			'slug'  => 'display_name'
		);
		$plugin_data[] = array(
			'value' => date(Settings::get('date_format'), $profile_data['updated_on']),
			'name'  => lang('user:profile_updated_on'),
			'slug'  => 'updated_on'
		);

		foreach ($profile = $this->current_user->profile->getAttributes() as $field_slug => $field)
		{
			if ($field = $this->current_user->profile->getField($field_slug))
			{
				$plugin_data[] = array(
					'value' => $profile[$field_slug],
					'name'  => $field->field_name,
					'slug'  => $field_slug
				);
			}
		}

		return $plugin_data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Allows usage of full user variables inside of a tag pair.
	 *
	 * Usage:
	 *
	 *     {{ user:profile }}
	 *         {{ variable }}
	 *     {{ /user:profile }}
	 *
	 * @return string
	 */
	public function profile()
	{
		// We can't parse anything if there is no content.
		if ( ! $this->content()) {
			return null;
		}

		$profile_data = $this->get_user_profile();

		if (is_null($profile_data)) {
			return null;
		}

		$this->load->driver('Streams');

		// Dumb hack that should be goine in 2.2
		$profile_data['user_id'] = $profile_data['id'];
		$profile_data['id']      = $profile_data['profile_id'];

		return $this->streams->parse->parse_tag_content($this->content(), $profile_data, 'profiles', 'users', false);
	}

	/**
	 * Get a user's profile data.
	 *
	 * Function shared by single user profile tags as well as the tag pair.
	 * Takes care of runtime caching as well.
	 *
	 * @param bool $plugin_call does this need to be processed with full plugin vars?
	 *
	 * @return array
	 */
	private function get_user_profile($plugin_call = true)
	{
		$user_id = $this->attribute('user_id');

		// If we do not have a user id and there is
		// no currently logged in user, there is nothing to display.
		if (is_null($user_id) and ! isset($this->current_user->id)) {
			return null;
		
		// No user provided, but we know one
		} elseif (is_null($user_id) and isset($this->current_user->id)) {
			// Otherwise, we can use the current user id
			$user = $this->current_user;
		}
		else
		{
			// We must have a user id at this point
			$user = Users\Model\User::find($user_id);	
		}

		

		// Got through each stream field and see if we need to format it
		// for plugin return (ie if we haven't already done that).
		foreach ($user->profile->getModel()->getAllColumns() as $field_key => $field_data) {
			if ($plugin_call) {
				if ( ! isset($this->user_profile_data[$user_id]['plugin'][$field_key]) and $user->{$field_key}) {
					$this->user_profile_data[$user_id]['plugin'][$field_key] = $user->profile->getPresenter('plugin')->{$var};
				}

				if ($user->$field_key) {
					$user->$field_key = $this->user_profile_data[$user_id]['plugin'][$field_key];
				}

			// Not a plugin call
			} else {
				if ( ! isset($this->user_profile_data[$user_id]['pre_formatted'][$field_key]) and isset($user[$field_key])) {
					$this->user_profile_data[$user_id]['pre_formatted'][$field_key] = $user->{$field_key};
				}

				if ($user->{$field_key}) {
					$user[$field_key] = $this->user_profile_data[$user_id]['pre_formatted'][$field_key];
				}
			}
		}

		return $user;
	}

	/**
	 * Get a single user variable
	 *
	 * @param string $var     The variable to get
	 * @param int    $user_id The id of the user
	 *
	 * @return string The formatted column
	 */
	private function get_user_var($var, $user_id)
	{
		if ( ! isset($this->user_data[$user_id]))
		{
			$this->user_data[$user_id] = Users\Model\User::find($user_id);
		}

		if (in_array($var, $this->user_data[$user_id]->getHidden())) return null;

		if ( ! isset($this->user_profile_data[$user_id]))
		{
			$this->user_profile_data[$user_id] = $this->user_data[$user_id]->profile;	
		}

		return isset($this->user_profile_data[$user_id]) ? $this->user_profile_data[$user_id]->getPresenter('plugin')->{$var} : null;
	}

	/**
	 * Load a variable
	 *
	 * Magic method to get a user variable.
	 * This is where the user_id gets set to the current user if none is specified.
	 *
	 * @param string $name
	 * @param string $data
	 *
	 * @return string
	 */
	public function __call($name, $data)
	{
		$user = new Users\Model\User;

		if (in_array($name, $user->getHidden())) return null;

		$user_id = $this->attribute('user_id', null);

		// If we do not have a user id and there is
		// no currently logged in user, there's nothing we can do
		if (is_null($user_id) and ! isset($this->current_user->id)) {
			return null;
		} elseif (is_null($user_id) and isset($this->current_user->id)) {
			// Otherwise, we can use the current user id
			$user_id = $this->current_user->id;

			// but first, is it data we already have? (such as user:username)
			if (isset($this->current_user->{$name})) {
				return $this->current_user->{$name};
			}
		}

		// we're fetching a different user than the currently logged in one
		return $this->get_user_var($name, $user_id);
	}

}
