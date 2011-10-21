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
	
	
	/***
	* get all modules roles with permissions per group
	* sort roles into binary (on/off) types and array(db table based) types
	* @access public
	* @param group_id
	* @return array
	* @author Peter Digby
	***/
	
	public function get_modules($group_id) 
	{
		//get existing permissions for this group
		$edit_permissions = $this->permission_m->get_group($group_id);
		
		//get all module roles
		$permission_modules = $this->module_m->get_all(array('is_backend' => TRUE));
		
		//put them together
		foreach ($permission_modules as &$module)
		{
			//is the whole module allowed ?
			$module['checked'] = array_key_exists($module['slug'], $edit_permissions);
			
			//extract roles and permissions 
			$module['binary_roles'] = array();
			$module['array_roles'] 	= array();
			
			$roles = $this->module_m->roles($module['slug']);
			
			foreach ($roles as $role) 
			{
				//the on/off roles first
				if (!is_array($role))
				{
					$module['binary_roles'][$role] = @$edit_permissions[$module['slug']]->$role;
				}
				//then the array type roles
				else				
				{
					$role_permissions =  @$edit_permissions[$module['slug']]->$role['name'];
					
					//TODO: need to allow for recursive db query below (eg. file folder permissions)
					//perhaps a 'recursive' param in the role means look for 'parent_id' in db and structure accordingly?
					
					//get db id and name fields
					$this->db->select(array('id',$role['field']));
					$query = $this->db->get($role['table']);
					$subs = array();
					foreach ($query->result() as $row) 
					{
						$subs[$row->id] = array(
												'name' => $row->{$role['field']},
												'checked' => isset($role_permissions->{$row->id}) ? TRUE: FALSE
												);
					}	
					$module['array_roles'][$role['name']] = $subs;
				}
			}
		}
		
		return $permission_modules;
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