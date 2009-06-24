<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_m extends Model
{
	function __construct()
	{
		parent::Model();
	}	
	
	public function countComments($params = array())
	{  	
		if(!empty($param['is_active']))
		{
			if($param['is_active'] == 1)
			{
				$this->db->where('is_active', 1);
			}
			else
			{
				$this->db->where('is_active', 0);
			}			
		}
		
		if(!empty($params['module']))
		{
			$this->db->where('module', $params['module']);
    }
		
		if(!empty($params['module_id']))
		{
			$this->db->where('module_id', $params['module_id']);
		}
		
		if(!empty($params['month']))
		{
			$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
		}
		
		if(!empty($params['year']))
		{
			$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
		}
		
		if(!empty($params['user']))
		{
			if(is_numeric($params['user']))
			{
				$this->db->where('user_id', $params['user']);
			}
			else
			{
				$this->db->where('name', $params['user']);
			}
		}
		       	
		return $this->db->count_all_results('comments');
  }
		
	public function getComments($params = array())
  {
    $sql = '
			SELECT
				c.id, c.is_active, c.body, c.created_on, c.module, c.module_id, c.user_id,
				IF(c.user_id > 0, IF(u.last_name = "", u.first_name, CONCAT(u.first_name, " ", u.last_name)), c.name) as name, 
				IF(c.user_id > 0, u.email, c.email) as email
			FROM
				comments c, users u
			WHERE
				IF(c.user_id > 0, c.user_id = u.id, true = true)
		';
		
		if(!empty($params['id']))
		{
			$sql .= ' AND c.id = "'. $params['id'] .'"';
		}
		
		if(!empty($params['is_active']))
		{
			if($params['is_active'] == 1)
			{
				$sql .= ' AND c.is_active = 1';
			}
			else
			{
				$sql .= ' AND c.is_active = 0';
			}			
		}
		
		if(!empty($params['module']))
		{			
			$sql .= ' AND c.module = "'. $params['module'] .'"';
    }
		
		if(!empty($params['module_id']))
		{
			$sql .= ' AND c.module_id = "'. $params['module_id'] .'"';
		}
				
		if(!empty($params['month']))
		{
			$sql .= ' AND MONTH(FROM_UNIXTIME(c.created_on)) = "'. $params['month'] .'"';
		}
		
		if(!empty($params['year']))
		{
			$sql .= ' AND YEAR(FROM_UNIXTIME(c.created_on)) = "'. $params['year'] .'"';
		}
		
		if(!empty($params['user']))
		{
			if(is_numeric($params['user']))
			{
				$sql .= ' AND c.user_id = "'. $params['user'] .'"';
			}
			else
			{
				$sql .= ' AND c.name = "'. $params['user'] .'"';
			}
		}
    		
		// Sorting the results based on a param
		if(!empty($params['order']))
		{
			switch($params['order'])
			{
				// Specific sorting options goes here
				case 'byNameDESC':
					$sql .= ' ORDER BY c.name DESC';
				break;
				
				// Default sorting of comments by wrong param
				default:
					$sql .= ' ORDER BY c.created_on DESC';
			}
		}
		else
		{
			// Default sorting of comments by no param
			$sql .= ' ORDER BY c.created_on DESC';
		}
		
		// Limit the results based on 1 number or 2 (2nd is offset)
    if(isset($params['limit']) && is_array($params['limit']))
		{
			$sql .= ' LIMIT '.$params['limit'][1].', '.$params['limit'][0];
		}
    elseif(isset($params['limit']))
		{
			$sql .= ' LIMIT '.$params['limit'];
		}
		  
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
			'user_id'			=> isset($input['user_id']) 	? 	$input['user_id'] 											:  0,
			'is_active'		=> isset($input['is_active']) ? 	$input['is_active'] 										:  0,
			'name'				=> isset($input['name']) 			? 	ucwords(strtolower($input['name'])) 		: '',
			'email'				=> isset($input['email']) 		? 	strtolower($input['email']) 						: '',
			'body'				=> strip_tags($input['body']),
			'module'			=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now()
		));
		
		return $this->db->insert_id();
	}
	
	public function updateComment($input, $id = 0)
  {
  	$this->load->helper('date');
		
		$this->db->where('id', $params['id']);		
		$set = array(
			'user_id'			=> isset($input['user_id']) 	? 	$input['user_id'] 											:  0,
			'is_active'		=> isset($input['is_active']) ? 	$input['is_active'] 										:  0,
			'name'				=> isset($input['name']) 			? 	ucwords(strtolower($input['name'])) 		: '',
			'email'				=> isset($input['email']) 		? 	strtolower($input['email']) 						: '',
			'body'				=> strip_tags($input['body']),
			'module'			=> $input['module'],
			'module_id'		=> $input['module_id'],
			'created_on' 	=> now()
		);	
		
		return $this->db->update('comments', $set);
	}
	
	public function aktivateComment($id, $is_active = 0)
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
