<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Users Module
 * @since		v0.1
 *
 */
class Users_m extends Model {

	// Constructor function
    function __construct() {
        parent::Model();
    }

    // Get a user's salt
    function getSalt($email = '') {
        if (!empty($email)) {
            $this->db->select('salt');
            $query = $this->db->getwhere('users', array('email'=>$email));
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->salt;
            }
        }
        return FALSE;
    }
    
	// Get a specified (single) user
    function getUser($params) {
    	
    	if(isset($params['id'])) {
    		$this->db->where('id', $params['id']);
    	}
    	
    	if(isset($params['email'])) {
    		$this->db->where('LOWER(email)', strtolower($params['email']));
    	}
    	
    	if(isset($params['role'])) {
    		$this->db->where('role', $params['role']);
    	}
    	
    	$this->db->select('*, IF(last_name = "", first_name, CONCAT(first_name, " ", last_name)) as full_name', FALSE);
    	$this->db->limit(1);
    	$query = $this->db->get('users');

    	return $query->row();
    }
    
	// Get multiple users based on the $params array
	function getUsers($params = array())
    {
    	if(isset($params['active'])) $this->db->where('is_active', $params['active']);
    	if(isset($params['role'])) $this->db->where('role', $params['role']);	
    	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
    	if(isset($params['order'])) $this->db->order_by($params['order']);
    	
    	$this->db->select('*, IF(last_name = "", first_name, CONCAT(first_name, " ", last_name)) as full_name');
    	$query = $this->db->get('users');

    	return $query->result();
    }    

    // Count the amount of users based on the parameters.
    function countUsers($params = array())
    {
    	if(isset($params['active'])) $this->db->where('is_active', $params['active']);
    	if(isset($params['role'])) $this->db->where('role', $params['role']);	

		return $this->db->count_all_results('users');
    }
    
	// Get a list of available (default) roles.
    function getRoles() {
    	return array('user'=>'User',
    				 'staff'=>'Staff',
    				 'admin'=>'Admin');
    }
    
	// Create a new user
	function newUser($input = array())
    {
		$this->load->helper('date');

        $this->db->insert('users', array(
        	'email'				=> $input->email,
        	'password'			=> $input->password,
        	'salt'				=> $input->salt,
        	'first_name' 		=> ucwords(strtolower($input->first_name)),
        	'last_name' 		=> ucwords(strtolower($input->last_name)),
        	'role' 				=> empty($input->role) ? 'user' : $input->role,
        	'is_active' 		=> 0,
        	'lang'				=> $this->config->item('default_language'),
        	'activation_code' 	=> $input->activation_code,
        	'created_on' 		=> now(),
			'last_login'		=> '',
        	'ip' 				=> $this->input->ip_address()
        ));

		return $this->db->insert_id();		
		
	}
	
	// Update an existing user
	function updateUser($id, $data) {
		return $this->db->update('users', $data, array('id' => $id));
	}

	// Update the last login time
	function updateLastLogin($id) {
		$this->load->helper('date');
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}
	
	// Activate a newly created user
	function activateUser($id) {
		$this->db->update('users', array('is_active' => 1, 'activation_code' => ''), array('id' => $id));
		return ($this->db->affected_rows() > 0);
	}

	// Delete an existing user
	function deleteUser($id) {
		$this->db->delete('users', array('id'=>$id));
		return $this->db->affected_rows();
	}

}

?>