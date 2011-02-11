<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
    		$this->db->where('users.id', $params['id']);
    	}
    	
    	if(isset($params['email']))
    	{
    		$this->db->where('LOWER(users.email)', strtolower($params['email']));
    	}
    	
    	if(isset($params['role']))
    	{
    		$this->db->where('users.group_id', $params['role']);
    	}
    	
    	$this->db->select('profiles.*, users.*, IF(profiles.last_name = "", profiles.first_name, CONCAT(profiles.first_name, " ", profiles.last_name)) as full_name', FALSE);
    	$this->db->limit(1);
    	$this->db->join('profiles', 'profiles.user_id = users.id', 'left');

    	return $this->db->get('users')->row();
    }
    
  	public function get_recent($limit = 10)
  	{
    	$this->db->order_by('users.created_on', 'desc');
    	$this->db->limit($limit);
    	return $this->get_all();
  	}
    
	function get_all()
    {
    	$this->db->select('profiles.*, users.*, g.description as group_name, IF(profiles.last_name = "", profiles.first_name, CONCAT(profiles.first_name, " ", profiles.last_name)) as full_name')
    			 ->join('groups g', 'g.id = users.group_id')
    			 ->join('profiles', 'profiles.user_id = users.id', 'left');
    		
        $this->db->group_by('users.id');
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
	
	public function count_by($params = array())
	{
		$this->db->from($this->_table)->join('profiles', 'users.id = profiles.user_id', 'left');
							
		if(!empty($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'] ;
			$this->db->where('users.active', $params['active']);
		}
		
		if(!empty($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}
		
		if(!empty($params['name']))
		{
			$this->db->like('users.username', trim($params['name']))
						->or_like('users.email', trim($params['name']))
						->or_like('profiles.first_name', trim($params['name']))
						->or_like('profiles.last_name', trim($params['name']));
		}
		
		return $this->db->count_all_results();
	}
	
	public function get_many_by($params = array())
	{
		if(!empty($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'] ;
			$this->db->where('active', $params['active']);
		}
		
		if(!empty($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}
		
		if(!empty($params['name']))
		{
			$this->db->like('users.username', trim($params['name']))
						->or_like('users.email', trim($params['name']))
						->or_like('profiles.first_name', trim($params['name']))
						->or_like('profiles.last_name', trim($params['name']));
		}
		
		return $this->get_all();
	}

}