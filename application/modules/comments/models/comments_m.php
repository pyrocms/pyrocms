<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_m extends Model {

    function __construct() {
        parent::Model();
    }

    
    function getComments($module, $id) {
        
    	// Creatve selecting to return user details if they are a user, or just name and email if guest
    	$this->db->select('c.id, c.body, c.created_on, 
    						IF(user_id > 0, IF(u.last_name = "", u.first_name, CONCAT(u.first_name, " ", u.last_name)), c.name) as name, 
    						IF(user_id > 0, u.email, c.email) as email', FALSE);
    	
    	$this->db->join('users u', 'c.user_id = u.id', 'left');
    	
    	$module = str_replace('/', '', $module);
    	$this->db->where('module', $module);
    	$this->db->where('module_id', $id);
    	
    	$this->db->order_by('c.created_on DESC');
    	
    	$query = $this->db->get('comments as c');
        if ($query->num_rows() == 0) {
            return 'There are no comments';
        } else {
            $string = '';
            foreach ($query->result() as $comment) {
                $string .= '<p><strong>' . $comment->name .' says:</strong> "' . $comment->body . '"<br />'
                		.  '&nbsp;&nbsp;left at ' . date('h:i:s \o\n M d, Y', $comment->created_on) .'.</p>';
            }
            return $string;
        }
    }
    
    
	function newComment($input = array()) {
		$this->load->helper('date');
		
        $this->db->insert('comments', array(
        	'user_id'	=> isset($input['user_id']) ? $input['user_id'] : 0,
        	'name'		=> isset($input['name']) 	? ucwords(strtolower($input['name'])) : '',
        	'email'		=> isset($input['email']) 	? strtolower($input['email']) : '',
        	'body'		=> strip_tags($input['body']),
        	'module'	=> $input['module'],
        	'module_id'	=> $input['module_id'],
        	'created_on' => now()
        ));
        
        return $this->db->insert_id();
    }
    
    
    // NOTICE: PJS Currently not in use 24/07/08
    function deleteComment($id = 0) {
        $this->db->delete('comments', array('id'=>$id));
        return $this->db->affected_rows();
    }

}

?>