<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Permissions model
 * 
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Permissions module
 * @category Modules
 *
 */
class Permissions_m extends CI_Model
{
	/**
	 * Get a rule based on the ID
	 * 
	 * @access public
	 * @param int $id The ID
	 * @return mixed
	 */
	public function get_rule($id = 0)
	{
		// Execute the query
		$query = $this->db->get_where('permission_rules', array('id'=>$id));
		
		// Got results?
		if ($query->num_rows() == 0)
		{
			return FALSE;
		} 
		else 
		{
			return $query->row();
		}
	}

	/**
	 * Return an object of permission rules
	 * 
	 * @access public
	 * @param array $params Optional parameters
	 * @return mixed
	 */
	public function get_rules($params = array())
	{

		if( !empty($params['role']) ) 
		{
			$this->db->where('permission_role_id', $params['role']);
		}
		
		if( !empty($params['user_id']) ) 
		{
			$this->db->where('user_id', $params['user_id']);
		}

		if( !empty($params['order']) ) 
		{
			$this->db->order_by($params['order']);
		}
		else 
		{
			$this->db->order_by('module, controller, method');
		}

		// Query time!
		$query = $this->db->get('permission_rules');
		
		// Got results?
		if ( $query->num_rows() > 0 ) 
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Create a new permission rule
	 * 
	 * @access public
	 * @param array $input The input to use for creating a new rule
	 * @return array
	 */
	public function new_rule($input = array()) {
		$data = array(
			'module' 		=> $input['module'],
			'controller' 	=> $input['controller'],
			'method' 		=> $input['method']
		);
		
		// Got data?
		if ( $input['role_type'] == 'user' ) 
		{
			$data['user_id'] = (int) $input['user_id'];
		}
		else 
		{
			$data['permission_role_id'] = (int) $input['permission_role_id'];
		}
		
		// Return the results
		return $this->db->insert('permission_rules', $data);
	}

	/**
	 * Update a permission rule
	 * 
	 * @access public
	 * @param int $id The ID of the rule to update
	 * @param array $input The data to update
	 * @return mixed
	 */
	public function update_rule($id = 0, $input = array()) {
		
		$data = array(
			'module' 		=> $input['module'],
			'controller' 	=> $input['controller'],
			'method' 		=> $input['method'],
		);
		
		if ( $input['role_type'] == 'user' )
		{
			$data['user_id'] = (int) $input['user_id'];
		}
		else
		{
			$data['permission_role_id'] = (int) $input['permission_role_id']; 
		}
		
		// Update the DB
		$this->db->update('permission_rules', $data, array('id' => $id));
	}

	/**
	 * Delete a permission rule
	 * 
	 * @access public
	 * @param int $id The ID of the rule to delete
	 * @return array
	 */
	public function delete_rule($id)
	{
		// Is array?
		if( !is_array($id) )
		{
			 $id = array('id' => $id);
		}
		
		// Delete it
		$this->db->delete('permission_rules', $id);
        return $this->db->affected_rows();
	}

	
	/**
	 * Check a rule based on it's role
	 * 
	 * @access public
	 * @param string $role The role
	 * @param array $location
	 * @return mixed
	 */
	public function check_rule_by_role($role, $location)
	{
		// No more checking to do, admins win
		if ( $role == 1 )
		{
			return TRUE;
		}
		
		// Check the rule based on whatever parts of the location we have
		if ( isset($location['module']) )
		{
			 $this->db->where('(module = "'.$location['module'].'" or module = "*")');
		}
		
		if ( isset($location['controller']) )
		{
			 $this->db->where('(controller = "'.$location['controller'].'" or controller = "*")');
		}
		
		if ( isset($location['method']) )
		{
			 $this->db->where('(method = "'.$location['method'].'" or method = "*")');
		}
		
		// Check which kind of user?
		$this->db->where('roles.id', $role);
		
		$this->db->from('permission_rules rules');
		$this->db->join('groups as roles', 'roles.id = rules.permission_role_id');
		
		$query = $this->db->get();

		// Return the results
		return $query->num_rows() > 0;
	}
	
	/**
	 * Check a rule based on it's user
	 * 
	 * @access public
	 * @param int $user_id The user's ID
	 * @param array $location
	 * @return mixed
	 */
	public function check_rule_by_user($user_id, $location)
	{
		// Reserved id 1
		if ( $user_id == 1 )
		{
			return TRUE;
		}
		
		// Check the rule based on whatever parts of the location we have
		if ( isset($location['module']) )
		{
		 	$this->db->where('(module = "'.$location['module'].'" or module = "*")');
		}
		
		if ( isset($location['controller']) )
		{
			$this->db->where('(controller = "'.$location['controller'].'" or controller = "*")');
		}
		
		if ( isset($location['method']) )
		{
			 $this->db->where('(method = "'.$location['method'].'" or method = "*")');
		}
		
		// Check which kind of user?
		$this->db->where('user_id', $user_id);
		$this->db->from('permission_rules rules');
		$query = $this->db->get();

		// Return results
		return $query->num_rows() > 0;
	}
	
	/**
	 * Check if a user has admin access to any part of the admin panel at all, or a specific module
	 *
	 * @access public
	 * @param int $role The role ID
	 * @param bool $module
	 * @return mixed
	 */
	public function has_admin_access($role, $module = NULL)
	{
		// No more checking to do, admins win
		if ( $role == 1 )
		{
			return TRUE;
		}
		
		// Only use a module name if one is provided
		if ( $module )
		{
			$location['module'] = $module;
		}
		
		$location['controller'] = 'admin';

		return $this->check_rule_by_role($role, $location);
	}
	
	/**
	 * Return an object containing rule properties
	 * 
	 * @access public
	 * @param int $id The ID of the role
	 * @return mixed
	 */
	public function get_role($id = 0)
	{
		// Query time
		$query = $this->db->get_where('groups', array('id'=>$id));
		
		if ( $query->num_rows() == 0 )
		{
			return FALSE;
		}
		else
		{
			return $query->row();
		}
	}
	
	/**
	 * Return an array of permission roles
	 * 
	 * @access public
	 * @param array $params Optional parameters
	 * @return array
	 */
	public function get_roles($params = array())
	{	
		if ( isset($params['except']) )
		{
			$this->db->where_not_in('name', $params['except']);
		}
		
		return $this->db->get('groups')->result();
	}
	
	/**
	 * Create a new permission rule
	 *
	 * @access public 
	 * @param array $input The data to insert
	 * @return array
	 */
	public function new_role($input = array())
	{
		$data_array = array(
        	'title' => $input['title'],
        	'name' => $input['name']
		);
				
		$result = $this->db->insert('groups', $data_array);
		
		return $result;
	}
	
	/**
	 * Update a permission rule
	 * 
	 * @access public 
	 * @param int $id The ID of the role to update
	 * @param array $input The data to update
	 * @return void
	 */
	public function update_role($id = 0, $input = array()) {

		$this->db->update('groups', array(
        	'title' => $input['title']
		), array('id' => $id));

	}
	
	/**
	 * Delete a permission role
	 * 
	 * @access public
	 * @param int $id The ID of the role to delete
	 * @return
	 */
	public function delete_role($id) {
		
		if ( !is_array($id) )
		{
			$id = array('id' => $id);
		}

		// Dont let them delete these. The controller should handle the error message, this is just insurance
		$this->db->where_not_in('name', array('user', 'admin'));
		
		$this->db->delete('groups', $id);
        return $this->db->affected_rows();
	}
}