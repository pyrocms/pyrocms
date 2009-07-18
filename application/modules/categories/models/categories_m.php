<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories_m extends Model {

    function __construct() {
        parent::Model();
    }

	function getCategories($params = array()) {
		
		// Limit the results based on 1 number or 2 (2nd is offset)
       	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
    	
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('categories');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
	function getCategory($id = 0) {
        
    	if(is_numeric($id))  $this->db->where('id', $id);
    	else  				 $this->db->where('slug', $id);
		
		$query = $this->db->getwhere('categories');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }
    
    function countCategories($params = array())
    {
		return $this->db->count_all_results('categories');
    }
    
    function newCategory($input = array()) {

    	$this->db->insert('categories', array(
        	'slug'=>url_title(strtolower($input['title'])),
        	'title'=>$input['title']
        ));
        
        return $input['title'];
    }
    
    function updateCategory($input, $old_slug) {
            
		$this->db->update('categories', array(
            'title'	=> $input['title'],
            'slug'	=> url_title(strtolower($input['title']))
		), array('slug'=>$old_slug));
            
		return TRUE;
    }
    
    function deleteCategory($slug = '') {
        $this->db->delete('categories', array('slug'=>$slug));
        return $this->db->affected_rows();
    }
    
    function checkTitle($title = '') {
        $this->db->select('COUNT(title) AS total');
        $query = $this->db->getwhere('categories', array('slug'=>url_title($title)));
        $row = $query->row();
        if ($row->total == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

?>
