<?php

/**
 * User Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Phil Sturgeon
 */

/**
 * Checks to see if a user is logged in or not.
 *
 * @return bool
 */
function is_logged_in()
{
    return (isset(ci()->current_user));
}

/**
 * Checks if a group has access to module or role
 *
 * @param string $module sameple: pages
 * @param string $role sample: put_live
 * @return bool
 * @deprecated Use $this->current_user->hasAccess()
 */
function group_has_role($module, $role)
{
    if ( ! is_logged_in()) {
        return false;
    }

    return ci()->current_user->hasAccess("{$module}.{$role}");
}

/**
 * Checks if role has access to module or returns error
 *
 * @param string $module sample: pages
 * @param string $role sample: edit_live
 * @param string $redirect_to (default: 'admin') Url to redirect to if no access
 * @param string $message (default: '') Message to display if no access
 * @return mixed
 */
function role_or_die($module, $role, $redirect_to = 'admin', $message = null)
{
    if (!$message) {
        $message = lang_label('lang:'.$module.'.role_'.$role.'.denied');

        if (empty($message)) {
            $message = lang('cp:access_denied');
        }
    }

    if (ci()->input->is_ajax_request() and ! group_has_role($module, $role)) {
        echo json_encode(array('error' => $message));
        return false;

    } elseif ( ! group_has_role($module, $role)) {
        ci()->session->set_flashdata('error', $message);
        redirect($redirect_to);
    }
    return true;
}

/**
 * Whacky old password hasher
 *
 * @param int    $identity  The users identity
 * @param string $password  The password provided to attempt a login
 * @return  string
 * @deprecated
 * Nobody gets to make fun of me for this. We're deleting Ion Auth and
 * had to keep the logic around for the lifetime of 2.3. When upgrading to 3.0
 * this will go away and users STILL using old-style passwords will need to do
 *  a "Forgot Password" to get in. More on this later. Phil
 */
function whacky_old_password_hasher($identity, $password)
{
    if ( ! isset($identity, $password)) {
        return rand_string(100);
    }

    $schema = ci()->pdb->getSchemaBuilder();

    if ($schema->hasColumn('users', 'salt')) {

        $salt = ci()->pdb
            ->table('users')
            ->select('salt')
            ->whereRaw('(username = ? OR email = ?)', array($identity, $identity))
            ->take(1)
            ->pluck('salt');

        if ( ! $salt) {
            return rand_string(100);
        }
    } else {
        return rand_string(100);
    }

    return sha1($password.$salt);
}

/* End of file users/helpers/user_helper.php */
