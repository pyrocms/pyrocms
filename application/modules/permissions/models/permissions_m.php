<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permissions_m extends Model {

	function __construct() {
		parent::Model();
	}

	function getRule($id = 0) {
		$query = $this->db->getwhere('permission_rules', array('id'=>$id));
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}

	// Return an object of permisison rules
	function getRules($params = array()) {

		if(!empty($params['role'])) {
			$this->db->where('permission_role_id', $params['role']);
		}

		if(!empty($params['order'])) {
			$this->db->order_by($params['order']);
		} else {
			$this->db->order_by('module, controller, method');
		}

		$query = $this->db->get('permission_rules');
		if ($query->num_rows() > 0) {
			return $query->result();
		}

		return FALSE;
	}

	// Create a new permission rule
	function newRule($input = array()) {
		 
		return $this->db->insert('permission_rules', array(
        	'module' => $input['module'],
        	'controller' => $input['controller'],
        	'method' => $input['method'],
        	'permission_role_id' => (int) $input['permission_role_id']
		));
	}

	// Update a permission rule
	function updateRule($id = 0, $input = array()) {

		$this->db->update('permission_rules', array(
        	'module' => $input['module'],
        	'controller' => $input['controller'],
        	'method' => $input['method'],
        	'permission_role_id' => (int) $input['permission_role_id']
		), array('id' => $id));

	}

	// Delete a permission rule
	function deleteRule($id) {
		
		if(!is_array($id))  $id = array('id'=>$id);
		
		$this->db->delete('permission_rules', $id);
        return $this->db->affected_rows();
	}

	
	// --------------------------------------------
	
	function checkRuleByRole($role, $location)
	{
		// No more checking to do, admins win
		if($role == 'admin')
		{
			return TRUE;
		}
		
		// Check the rule based on whatever parts of the location we have
		if(isset($location['module'])) 		$this->db->where('(module = "'.$location['module'].'" or module = "*")');
		if(isset($location['controller'])) 	$this->db->where('(controller = "'.$location['controller'].'" or controller = "*")');
		if(isset($location['method'])) 		$this->db->where('(method = "'.$location['method'].'" or method = "*")');
		
		// Check which kind of user?
		$this->db->where('roles.abbrev', $role);
		
		$this->db->from('permission_rules rules');
		$this->db->join('permission_roles as roles', 'roles.id = rules.permission_role_id');
		
		$query = $this->db->get();

		return $query->num_rows() > 0;
	}
	
	// Check if a user has admin access to any part of the admin panel at all, or a specific module
	function hasAdminAccess($role, $module = NULL)
	{
		// No more checking to do, admins win
		if($role == 'admin')
		{
			return TRUE;
		}
		
		// Only use a module name if one is provided
		if($module)
		{
			$location['module'] = $module;
		}
		
		$location['controller'] = 'admin';

		return $this->checkRuleByRole($role, $location);
		
	}
	
	// --------------------------------------------
	
	
	// Return an object containing rule properties
	function getRole($id = 0)
	{
		$query = $this->db->getwhere('permission_roles', array('id'=>$id));
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}
	
	// Return an array of permission roles
	function getRoles($params = array()) {
		
		if(isset($params['except'])) {
			$this->db->where_not_in('abbrev', $params['except']);
		}
		
		return $this->db->get('permission_roles')->result();
	}
	
	// Create a new permission rule
	function newRole($input = array()) {

		return $this->db->insert('permission_roles', array(
        	'title' => $input['title'],
        	'abbrev' => $input['abbrev']
		));
		
	}
	
	// Update a permission rule
	function updateRole($id = 0, $input = array()) {

		$this->db->update('permission_roles', array(
        	'title' => $input['title']
		), array('id' => $id));

	}
	
	// Delete a permission role
	function deleteRole($id) {
		
		if(!is_array($id))  $id = array('id'=>$id);

		// Dont let them delete these. The controller should handle the error message, this is just insurance
		$this->db->where_not_in('abbrev', array('user', 'admin'));
		
		$this->db->delete('permission_roles', $id);
        return $this->db->affected_rows();
	}

}

?>