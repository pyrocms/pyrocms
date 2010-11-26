<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Code Igniter User Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

function loggedIn()
{
    $CI =& get_instance();
    $CI->load->library('session');
    return $CI->session->userdata('user_id') > 0;
}

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

    $user_name = empty($user['display_name']) ? $user['username'] : $user['display_name'];

    if (ci()->settings->enable_profiles)
    {
        $user_name = anchor('users/profile/view/' . $user['id'], $user_name);
    }

    return $user_name;
}
/* End of file users/helpers/user_helper.php */