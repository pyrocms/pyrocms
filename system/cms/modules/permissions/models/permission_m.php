<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permission model
 *
 * @author Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Permissions\Models
 *
 */
class Permission_m extends CI_Model
{
	private $_groups = array();

	/**
	 * Get the permission rules for a group.
	 *
	 * @param int $group_id The id for the group.
	 * @return array
	 */
	public function get_group($group_id)
	{
		// Save a query if you can
		if (isset($this->_groups[$group_id]))
		{
			return $this->_groups[$group_id];
		}

		// Execute the query
		$result = $this->db
			->where('group_id', $group_id)
			->get('permissions')
			->result();

		// Store the final rules here
		$rules = array();

		foreach ($result as $row)
		{
			// Either pass roles or just TRUE
			$rules[$row->module] = $row->roles ? json_decode($row->roles, true) : TRUE;
		}

		// Save this result for later
		$this->_groups[$group_id] = $rules;

		return $rules;
	}

	/**
	 * Get a rule based on the ID
	 *
	 * @param int $group_id The id for the group to get the rule for.
	 * @param null|string $module The module to check access against
	 * @return bool
	 */
	public function check_access($group_id, $module = NULL)
	{
		// If no module is set, just make sure they have SOMETHING
		if ($module !== NULL)
		{
			$this->db->where('module', $module);
		}

		return $this->db
			->where('group_id', $group_id)
			->count_all_results('permissions') > 0;
	}

	/**
	 * Save the permissions passed
	 *
	 * @param int $group_id
	 * @param array $modules
	 * @param array $module_roles
	 * @return bool
	 */
	public function save($group_id, $modules, $module_roles)
	{
		// Clear out the old permissions
		$this->db->where('group_id', $group_id)->delete('permissions');

		if ($modules)
		{
			// For each module mentioned (with a value of 1 for most browser compatibility).
			foreach ($modules as $module => $permission)
			{
				if ( ! empty($permission))
				{
					$data = array(
						'module' => $module,
						'group_id' => $group_id,
						'roles' => ! empty($module_roles[$module]) ? json_encode($module_roles[$module]) : NULL,
					);

					// Save this module in the list of "allowed modules"
					if ( ! $result = $this->db->insert('permissions', $data))
					{
						// Fail, give up trying
						return FALSE;
					}
				}
			}
			// All done!
			return TRUE;
		}

		return FALSE;
	}

}