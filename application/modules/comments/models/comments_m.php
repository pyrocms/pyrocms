<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_m extends Model
{
	function __construct()
	{
		parent::Model();
	}	
	
	public function countComments($params = array())
	{  	
		$results = $this->getComments($params);
		// Silly Phil forgot that using count() without some decent if statements will always return 1
		if($results == FALSE)
		{
			return 0; // Return 0 instead of false since no rows were found.
		}
		else
		{
			return count($results);
		}
	}
		
	public function getComments($params = array())
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
	
	public function getModule($id)
	{
		$comment = $this->getComment($id);
		return $comment->module;
	}
		
	public function getUsedModules()
	{
		$sql = "
			SELECT DISTINCT c.module
			FROM comments c
		";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0)
		{
    	return FALSE;
    	}
		else
		{
    		return $query->result();
    	}
	}
	
	public function getModuleComments($module, $limit)
	{
		$comments = $this->getComments( array('module' => $module, 'limit' => $limit) );
		return $comments;
	}
	
	public function getCommentsOfModuleItem($module, $item, $limit)
	{
		$comments = $this->getComments( array('module' => $module, 'module_id' => $item, 'limit' => $limit) );
		return $comments;
	}
	
	public function getComment($id = 0)
	{
		$comment = $this->getComments( array('id'=>$id) );
		$comment =& $comment[0];
		return $comment;
	}
	
	public function newComment($input)
	{
		$this->load->helper('date');
		
		$this->db->insert('comments', array(
			'user_id'		=> isset($input['user_id']) 		? 	$input['user_id'] 							:  0,
			'is_active'		=> isset($input['is_active']) 		? 	$input['is_active'] 						:  0,
			'name'			=> isset($input['name']) 			? 	ucwords(strtolower($input['name'])) 		: '',
			'email'			=> isset($input['email']) 			? 	strtolower($input['email']) 				: '',
			'body'			=> strip_tags($input['body']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now()
		));
		
		return $this->db->insert_id();
	}
	
	public function updateComment($input, $id = 0)
	{
  		$this->load->helper('date');
		
		$this->db->where('id', $id);		
		$set = array(
			'user_id'		=> isset($input['user_id']) 		? 	$input['user_id'] 							:  0,
			'is_active'		=> isset($input['is_active']) 		? 	$input['is_active'] 						:  0,
			'name'			=> isset($input['name']) 			? 	ucwords(strtolower($input['name'])) 		: '',
			'email'			=> isset($input['email']) 			? 	strtolower($input['email']) 				: '',
			'body'			=> strip_tags($input['body']),
			'module'		=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now()
		);	
		
		return $this->db->update('comments', $set);
	}
	
	public function approveComment($id, $is_active = 0)
	{
  		$this->db->where('id', $id);
		return $this->db->update('comments', array('is_active' => $is_active));
	}

	public function deleteComment($id = 0)
	{
		$this->db->delete('comments', array('id'=>$id));
		return $this->db->affected_rows();
	}		
}
?>