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
		return FALSE;
	}

	if (ci()->current_user->group == 'admin')
	{
		return TRUE;
	}

	$permissions = ci()->permission_m->get_group(ci()->current_user->group_id);
	
	if (empty($permissions[$module]) or empty($permissions[$module][$role]))
	{
		return FALSE;
	}

	return TRUE;
}


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

	if (ci()->input->is_ajax_request() AND ! group_has_role($module, $role))
	{
		echo json_encode(array('error' => ($message ? $message : lang('cp_access_denied')) ));
		return FALSE;
	}
	elseif ( ! group_has_role($module, $role))
	{
		ci()->session->set_flashdata('error', ($message ? $message : lang('cp_access_denied')) );
		redirect($redirect_to);
	}
	return TRUE;
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
function user_displayname($user, $linked = TRUE)
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

	if (ci()->settings->enable_profiles and $linked)
	{
		$user_name = anchor('user/'.$user['id'], $user_name);
	}
	
	$_users[$user['id']] = $user_name;

	return $user_name;
}

/* End of file users/helpers/user_helper.php */