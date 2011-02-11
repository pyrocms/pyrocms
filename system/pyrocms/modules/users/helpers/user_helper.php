<?php  defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Phil Sturgeon
 */

// ------------------------------------------------------------------------

/**
 * Return a users display name based on settings
 *
 * @param int $user the users id
 * @return  string
 */
function user_displayname($user)
{
    if (is_numeric($user))
    {
        $user = ci()->ion_auth->get_user($user);
    }

    $user = (array) $user;

	// Static var used for cache
	if ( ! isset($_users))
	{
		static $_users = array();
	}

	// check it exists
	if (isset($_users[$user['id']]))
	{
		return $_users[$user['id']];
	}

    $user_name = empty($user['display_name']) ? $user['username'] : $user['display_name'];

    if (ci()->settings->enable_profiles)
    {
        $user_name = anchor('users/profile/view/' . $user['id'], $user_name);
    }

	$_users[$user['id']] = $user_name;

    return $user_name;
}
/* End of file users/helpers/user_helper.php */