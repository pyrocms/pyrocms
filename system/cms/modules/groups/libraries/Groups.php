<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Groups Library
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Groups\Libraries
 */

class Groups
{
	/**
	 * The Groups Construct
	 */
	public function __construct()
	{
		ci()->load->model('groups/group_m');
	}

	/**
	 * Get groups
	 *
	 * Gets all the groups
	 *
	 * @return	array
	 */
	public static function get_all()
	{	
		return ci()->group_m->get_all();
	}
	
	
}

/* End of file Groups.php */