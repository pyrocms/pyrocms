<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_m extends MY_Model
{
    		
  	public function get($id)
  	{
    	$this->db->select('c.*')
    		->select('IF(c.user_id > 0, IF(u.last_name = "", u.first_name, CONCAT(u.first_name, " ", u.last_name)), c.name) as name')
    		->select('IF(c.user_id > 0, u.email, c.email) as email')
    		->from('comments c')
    		->join('users u', 'c.user_id = u.id', 'left');
    	
    	// If there is a comment user id, make sure the user still exists
    	$this->db->where('IF(c.user_id > 0, c.user_id = u.id, TRUE)')
    		->where('c.id', $id);
    	
    	return $this->db->get()->row();
  	}
  	
  	public function get_recent($limit = 10)
  	{
    	$this->db->order_by('comments.created_on', 'desc');
    	
    	if($limit > 0)
    	{
	    	$this->db->limit($limit);
    	}
    	
    	return $this->get_all();
  	}
  	
  	public function get_by_module_item($module, $module_id, $is_active = 1)
  	{
    	$this->db
    		->where('module', $module)
    		->where('module_id', $module_id)
    		->where('comments.is_active', $is_active)
    		->order_by('comments.created_on', 'desc');
    	
	    return $this->get_all();
  	}
  	
  	public function get_all()
  	{
    	$this->db->select('comments.*');
    	$this->db->select('IF(comments.user_id > 0, IF(u.last_name = "", u.first_name, CONCAT(u.first_name, " ", u.last_name)), comments.name) as name');
    	$this->db->select('IF(comments.user_id > 0, u.email, comments.email) as email');

    	$this->db->join('users u', 'comments.user_id = u.id', 'left');
    	
    	return parent::get_all();
  	}
	
	public function insert($input)
	{
		$this->load->helper('date');
		
		return parent::insert(array(
			'user_id'		=> isset($input['user_id']) 	? 	$input['user_id'] 						:  0,
			'is_active'		=> isset($input['is_active']) 	? 	$input['is_active'] 					:  0,
			'name'			=> isset($input['name']) 		? 	ucwords(strtolower($input['name'])) 	: '',
			'email'			=> isset($input['email']) 		? 	strtolower($input['email']) 			: '',
			'website'		=> isset($input['website']) 	? 	prep_url($input['website']) 			: '',
			'comment'		=> strip_tags($input['comment']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now(),
			'ip_address'	=> $this->input->ip_address()
		));
	}
	
	public function update($id, $input)
	{
  		$this->load->helper('date');
		
		return parent::update($id, array(
			'user_id'		=> isset($input['user_id']) 	? 	$input['user_id'] 						:  0,
			'is_active'		=> isset($input['is_active']) 	? 	$input['is_active'] 					:  0,
			'name'			=> isset($input['name']) 		? 	ucwords(strtolower($input['name'])) 	: '',
			'email'			=> isset($input['email']) 		? 	strtolower($input['email']) 			: '',
			'website'		=> isset($input['website']) 	? 	prep_url($input['website']) 			: '',
			'comment'		=> strip_tags($input['comment']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id']
		));
	}
	
	public function approve($id)
	{
		return parent::update($id, array('is_active' => 1));
	}
	
	public function unapprove($id)
	{
		return parent::update($id, array('is_active' => 0));
	}

}
?>