<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_m extends MY_Model
{
	public function get_comments($params = array())
	{
    	$this->db->select('c.id, c.is_active, c.body, c.created_on, c.module, c.module_id, c.user_id');
    	$this->db->select('IF(c.user_id > 0, IF(u.last_name = "", u.first_name, CONCAT(u.first_name, " ", u.last_name)), c.name) as name');
    	$this->db->select('IF(c.user_id > 0, u.email, c.email) as email');

    	$this->db->from('comments c');
    	
    	$this->db->join('users u', 'c.user_id = u.id', 'left');
	
    	// If there is a comment user id, make sure the user still exists
    	$this->db->where('IF(c.user_id > 0, c.user_id = u.id, TRUE)');
		
		if(isset($params['id']))
		{
			$this->db->where('c.id', $params['id']);
		}
		
		if(isset($params['is_active']))
		{
			$this->db->where('c.is_active', $params['is_active']);
		}
		
		if(!empty($params['module']))
		{			
			$this->db->where('c.module', $params['module']);
    	}
		
		if(!empty($params['module_id']))
		{
			$this->db->where('c.module_id', $params['module_id']);
		}
				
		if(!empty($params['month']))
		{
			$this->db->where('MONTH(FROM_UNIXTIME(c.created_on))', $params['month']);
		}
		
		if(!empty($params['year']))
		{
			$this->db->where('YEAR(FROM_UNIXTIME(c.created_on))', $params['year']);
		}
		
		if(!empty($params['user']))
		{
			if(is_numeric($params['user']))
			{
				$this->db->where('c.user_id', $params['user']);
			}
			else
			{
				$this->db->where('c.name', $params['user']);
			}
		}
    		
		// Sorting the results based on a param
		switch(@$params['order'])
		{
			// Specific sorting options goes here
			case 'byNameDESC':
				$this->db->orderby('c.name DESC');
			break;
			
			// Default sorting of comments by wrong param
			default:
				$this->db->orderby('c.created_on DESC');
			break;
		}
		
		// Limit the results based on 1 number or 2 (2nd is offset)
    	if(isset($params['limit']) && is_array($params['limit']))
		{
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		}
		
    	elseif(isset($params['limit']))
		{
			$this->db->limit($params['limit']);
		}
		  
    	$query = $this->db->get();
    
		if ($query->num_rows() == 0)
		{
    		return FALSE;
    	}
		else
		{
    		return $query->result();
   		}
  	}
	
	public function insert($input)
	{
		$this->load->helper('date');
		
		$comment = array(
			'user_id'		=> isset($input['user_id']) 	? 	$input['user_id'] 						:  0,
			'is_active'		=> isset($input['is_active']) 	? 	$input['is_active'] 					:  0,
			'name'			=> isset($input['name']) 		? 	ucwords(strtolower($input['name'])) 	: '',
			'email'			=> isset($input['email']) 		? 	strtolower($input['email']) 			: '',
			'body'			=> strip_tags($input['body']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now()
		);
		
		return parent::insert($comment);
	}
	
	public function update($id, $input)
	{
  		$this->load->helper('date');
		
		$comment = array(
			'user_id'		=> isset($input['user_id']) 	? 	$input['user_id'] 						:  0,
			'is_active'		=> isset($input['is_active']) 	? 	$input['is_active'] 					:  0,
			'name'			=> isset($input['name']) 		? 	ucwords(strtolower($input['name'])) 	: '',
			'email'			=> isset($input['email']) 		? 	strtolower($input['email']) 			: '',
			'body'			=> strip_tags($input['body']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now()
		);	
		
		return parent::update($id, $comment);
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