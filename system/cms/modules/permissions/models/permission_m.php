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
	
	
	/***
	* get all modules roles with permissions for the group
	* sort roles into binary (on/off) types and array(db table based) types
	* @access public
	* @param group_id
	* @return array
	* @author Peter Digby
	***/
	
	public function get_modules($group_id) 
	{
		
		//get existing permissions for this group
		$edit_permissions = $this->get_group($group_id);
		
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
			
			//html format strings
			$binary_fstring = '<label><input type=checkbox name="module_roles[' . $module['slug'] . '][%1$s]" value=1 %2$s> %3$s</label>';
			$array_fstring 	= '<label><input type=checkbox name="module_roles[' . $module['slug'] . '][%1$s][%2$s]" value=1 %3$s> %4$s</label>';
			
			$roles = $this->module_m->roles($module['slug']);
			
			foreach ($roles as $role) 
			{
				
				//the on/off roles first
				if ( ! is_array($role))
				{
					$title = lang($module['slug'].'.role_'. $role);
					$checked = (@$edit_permissions[$module['slug']]->$role) ? 'checked':'';
					$module['binary_roles'][$role] = sprintf ($binary_fstring, $role, $checked, $title);
					
				}
				//then the array type roles
				else				
				{   
					$role_permissions =  @$edit_permissions[$module['slug']]->$role['name'];
						
					$this->db->order_by ($role['field']);
					$query = $this->db->get($role['table']);
					
					//sort out structure (with parent-child tree if there is one) 
					$sub_list = array();
					$subs = array();
					
					foreach ($query->result() as $row) 
					{
						$sub_list[$row->id] = array_merge((array)$row, array('children'=> array()));
					}
					
					foreach ($sub_list as $sub_id => &$sub) 
					{
						$sub ['checked'] 	= (@$role_permissions->{$sub_id}) ? 'checked': '';
						$sub ['name'] 		= $sub [$role['field']];
						 
						if ( ! array_key_exists ('parent_id',$sub) || ! array_key_exists($sub['parent_id'], $sub_list)) 
						{
							$subs[] = &$sub;
						} 
						else 
						{
							$sub_list[$sub['parent_id']]['children'][] = &$sub;
						}
					}
						
					
					//ok - structure sorted - build html list string 
					$html = '';
					foreach ($subs as $subrole) 
					{
						$html .= '<ul>';
						
						$html .= $this->_build_role_tree($role['name'],$subrole,$array_fstring);
						
						$html .= '</ul>';
					}
						
					$module['array_roles'][$role['name']] = $html;
					
				}
			}
		}
		
		return $permission_modules;
	}
	
	/**
	 * sort recursive permission tree into list items
	 * @param $rolename string 
	 * @param $sub array the sub-permissions
	 * @param $fstring string the item html format
	 * @return string html list
	 * @author Peter Digby
	**/
	private function _build_role_tree($rolename,$sub,$fstring) 
	{
		$htstring = '<li>';
		
		$htstring .= sprintf ($fstring, $rolename, $sub['id'], $sub ['checked'], $sub['name'] ) ;
		
		if (isset($sub['children'][0])) 
		{	
			$htstring .= '<ul>';
			
			foreach ($sub['children'] as $resub)
			{
				$htstring .= $this->_build_role_tree($rolename,$resub,$fstring);			
			}
			
			$htstring .= '</ul>';
			
		}
		
		$htstring .= '</li>';
		
		return $htstring ;
		
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
	 * Set group permissions 
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