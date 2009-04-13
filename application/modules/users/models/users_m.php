<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_m extends Model {

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
    
    function countUsers($params = array())
    {
    	if(isset($params['active'])) $this->db->where('is_active', $params['active']);
    	if(isset($params['role'])) $this->db->where('role', $params['role']);	

		return $this->db->count_all_results('users');
    }
    
    function getRoles() {
    	return array('user'=>'User',
    				 'staff'=>'Staff',
    				 'admin'=>'Admin');
    }
    
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
        	'activation_code' 	=> $input->activation_code,
        	'created_on' 		=> now(),
        	'ip' 				=> $this->input->ip_address()
        ));

		return $this->db->insert_id();		
		
	}
	
	function updateUser($id, $data) {
		return $this->db->update('users', $data, array('id' => $id));
	}

	function updateLastLogin($id) {
		$this->load->helper('date');
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}
	
	function activateUser($id) {
		$this->db->update('users', array('is_active' => 1, 'activation_code' => ''), array('id' => $id));
		return ($this->db->affected_rows() > 0);
	}

	function deleteUser($id) {
		$this->db->delete('users', array('id'=>$id));
		return $this->db->affected_rows();
	}

}

?>