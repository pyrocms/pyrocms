<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permission model
 * 
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Permissions module
 * @category Modules
 *
 */
class Permission_m extends CI_Model
{
	private $_groups = array();

	/**
	 * Get a rule based on the ID
	 *
	 * @access public
	 * @param int $id The ID
	 * @return mixed
	 */
	public function get_group($group_id)
	{
		// Save a query if you can
		if (isset($this->_groups[$group_id]))
		{
			return $this->_groups[$group_id];
		}

		$result = $this->db
			->where('group_id', $group_id)
			->get('permissions')
			->result();

		$permissions = array();
		foreach ($result as $row)
		{
			// Either pass roles or just TRUE
			$permissions[$row->module] = $row->roles ? json_decode($row->roles) : TRUE;
		}

		// Save this result for later
		$this->_groups[$group_id] = $permissions;

		return $permissions;
	}
	
	/**
	 * Get a rule based on the ID
	 *
	 * @access public
	 * @param int $id The ID
	 * @return mixed
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
	 * Get a rule based on the ID
	 *
	 * @access public
	 * @param int $id The ID
	 * @return mixed
	 */
	function save($group_id, $modules, $module_roles)
	{
		// Clear out the old permissions
		$this->db->where('group_id', $group_id)->delete('permissions');

		if ($modules)
		{
			// For each module mentioned (with a value of 1 for most browser compatibility
			foreach ($modules as $module => $permission)
			{
				if ( ! empty($permission))
				{
					// Save this module in the list of "allowed modules"
					$result = $this->db->insert('permissions', array(
						'module' => $module,
						'group_id' => $group_id,
						'roles' => ! empty($module_roles[$module]) ? json_encode($module_roles[$module]) : NULL,
					));

					// Fail, give up trying
					if ( ! $result)
					{
						return FALSE;
					}
				}
			}
		}

		return TRUE;
	}

}