<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
 * Checks to see if a user is logged in or not.
 * 
 * @access public
 * @return bool
 */
function is_logged_in()
{
    return (isset(get_instance()->current_user->id)) ? true : false; 
}

// ------------------------------------------------------------------------

/**
 * Checks if a group has access to module or role
 * 
 * @access public
 * @param string $module sameple: pages
 * @param string $role sample: put_live
 * @return bool
 */
function group_has_role($module, $role)
{
	if (empty(ci()->current_user))
	{
		return false;
	}

	if (ci()->current_user->group == 'admin')
	{
		return true;
	}

	$permissions = ci()->permission_m->get_group(ci()->current_user->group_id);
	
	if (empty($permissions[$module]) or empty($permissions[$module][$role]))
	{
		return false;
	}

	return true;
}

// ------------------------------------------------------------------------

/**
 * Checks if role has access to module or returns error 
 * 
 * @access public
 * @param string $module sample: pages
 * @param string $role sample: edit_live
 * @param string $redirect_to (default: 'admin') Url to redirect to if no access
 * @param string $message (default: '') Message to display if no access
 * @return mixed
 */
function role_or_die($module, $role, $redirect_to = 'admin', $message = '')
{
	ci()->lang->load('admin');

	if (ci()->input->is_ajax_request() and ! group_has_role($module, $role))
	{
		echo json_encode(array('error' => ($message ? $message : lang('cp:access_denied')) ));
		return false;
	}
	elseif ( ! group_has_role($module, $role))
	{
		ci()->session->set_flashdata('error', ($message ? $message : lang('cp:access_denied')) );
		redirect($redirect_to);
	}
	return true;
}

// ------------------------------------------------------------------------

/**
 * Return a users display name based on settings
 *
 * @param int $user the users id
 * @param string $linked if true a link to the profile page is returned, 
 *                       if false it returns just the display name.
 * @return  string
 */
function user_displayname($user, $linked = true)
{
    // User is numeric and user hasn't been pulled yet isn't set.
    if (is_numeric($user))
    {
        $user = ci()->ion_auth->get_user($user);
    }

    $user = (array) $user;
    $name = empty($user['display_name']) ? $user['username'] : $user['display_name'];

    // Static var used for cache
    if ( ! isset($_users))
    {
        static $_users = array();
    }

    // check if it exists
    if (isset($_users[$user['id']]))
    {
        if( ! empty( $_users[$user['id']]['profile_link'] ) and $linked)
        {
            return $_users[$user['id']]['profile_link'];
        }
        else
        {
            return $name;
        }
    }

    // Set cached variable.
    if (ci()->settings->enable_profiles and $linked)
    {
        $_users[$user['id']]['profile_link'] = anchor('user/'.$user['id'], $name);
        return $_users[$user['id']]['profile_link'];
    }

    // Not cached, Not linked. get_user caches the result so no need to cache non linked
    return $name;
}

/* End of file users/helpers/user_helper.php */