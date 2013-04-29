<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Groups Library
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Libraries
 */

class Users
{
	/**
	 * The Permissions Construct
	 */
	public function __construct()
	{
		ci()->load->model('users/user_m');
		ci()->load->library('users/Ion_auth');
	}

	/**
	 * Get Users Array
	 *
	 * @return array Users
	 **/
	public static function get_users_array($group_name=false, $limit=null, $offset=null)
	{
		return ci()->ion_auth->get_users_array($group_name, $limit, $offset);
	}
	
	
}

/* End of file Users.php */