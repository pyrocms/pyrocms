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
			// Either pass roles or just true
			$rules[$row->module] = $row->roles ? json_decode($row->roles, true) : true;
		}

		// Save this result for later
		$this->_groups[$group_id] = $rules;

		return $rules;
	}

	/**
	 * Get a role based on the group slug
	 *
	 * @param string|array $roles Either a single role or an array
	 * @param null|string $module The module to check access against
	 * @param bool $strict If set to true the user must have every role in $roles. Otherwise having one role is sufficient
	 * @return bool
	 */
	public function has_role($roles, $module = null, $strict = false)
	{
		$access = array();
		$module === null and $module = $this->module;

		// must be logged in
		if ( ! $this->current_user) return false;

		// admins can have anything
		if ($this->current_user->group == 'admin') return true;

		// do they even have access to the module?
		if ( ! isset($this->permissions[$module])) return false;

		if (is_array($roles))
		{
			foreach ($roles as $role)
			{
				if (array_key_exists($role, $this->permissions[$module]))
				{
					// if not strict then one role is enough to get them in the door
					if ( ! $strict)
					{
						return true;
					}
					else
					{
						array_push($access, false);
					}
				}
			}

			// we have to have a non-empty array but one false in the array gets them canned
			return $access and ! in_array(false, $access);
		}
		else
		{
			// they just passed one role to check
			return array_key_exists($roles, $this->permissions[$module]);
		}
	}

	/**
	 * Get a rule based on the ID
	 *
	 * @param int $group_id The id for the group to get the rule for.
	 * @param null|string $module The module to check access against
	 * @return bool
	 */
	public function check_access($group_id, $module = null)
	{
		// If no module is set, just make sure they have SOMETHING
		if ($module !== null)
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
						'roles' => ! empty($module_roles[$module]) ? json_encode($module_roles[$module]) : null,
					);

					// Save this module in the list of "allowed modules"
					if ( ! $result = $this->db->insert('permissions', $data))
					{
						// Fail, give up trying
						return false;
					}
				}
			}
			// All done!
			return true;
		}

		return false;
	}

}