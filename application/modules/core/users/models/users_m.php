<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Users Module
 * @since		v0.1
 *
 */
class Users_m extends MY_Model
{

    // Get a user's salt
    function getSalt($email = '')
    {
        if (!empty($email))
        {
            $this->db->select('salt');
            $query = $this->db->get_where('users', array('email'=>$email));
            
            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                return $row->salt;
            }
        }
        
        return FALSE;
    }
    
	// Get a specified (single) user
    function get($params)
    {
    	if(isset($params['id']))
    	{
    		$this->db->where('id', $params['id']);
    	}
    	
    	if(isset($params['email']))
    	{
    		$this->db->where('LOWER(email)', strtolower($params['email']));
    	}
    	
    	if(isset($params['role']))
    	{
    		$this->db->where('role', $params['role']);
    	}
    	
    	$this->db->select('*, IF(last_name = "", first_name, CONCAT(first_name, " ", last_name)) as full_name', FALSE);
    	$this->db->limit(1);
    	$query = $this->db->get('users');

    	return $query->row();
    }
    
    
	function get_all()
    {
    	$this->db->select('users.*, pr.title as role_title, IF(last_name = "", first_name, CONCAT(first_name, " ", last_name)) as full_name')
    		->join('permission_roles pr', 'pr.abbrev = users.role');
    		
    	return parent::get_all();
    }    

	// Create a new user
	function add($input = array())
    {
		$this->load->helper('date');

        return parent::insert(array(
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
			'last_login'		=> now(),
        	'ip' 				=> $this->input->ip_address()
        ));
	}
	
	// Update the last login time
	function update_last_login($id) {
		$this->load->helper('date');
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}
	
	// Activate a newly created user
	function activate($id)
	{
		return parent::update($id, array('is_active' => 1, 'activation_code' => ''));
	}

}

?>