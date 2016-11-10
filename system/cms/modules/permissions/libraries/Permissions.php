<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Groups Library
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Permissions\Libraries
 */

class Permissions
{
	/**
	 * The Permissions Construct
	 */
	public function __construct()
	{
		ci()->load->model('permissions/permission_m');
	}

	/**
	 * Get a rule based on the ID
	 *
	 * @param int $group_id The id for the group to get the rule for.
	 * @param null|string $module The module to check access against
	 * @return bool
	 */
	public static function check_access($group_id, $module = null)
	{	
		return ci()->permission_m->check_access($group_id,$module);
	}
	
		/**
	 * Get a rule and role based on the ID
	 *
	 * @param int $group_id The id for the group to get the rule for.
	 * @param null|string $module The module to check access against
	 * @return bool
	 */
	public static function check_access_role($group_id, $module = null,$role = null)
	{	
		return ci()->permission_m->check_access_role($group_id,$module,$role);
	}
	
	
}

/* End of file Permissions.php */