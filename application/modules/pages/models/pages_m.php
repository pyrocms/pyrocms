<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends Model {

    function __construct() {
        parent::Model();
    }
    
    // Return an object containing page data
    function getPage($params = array()) {
    
    	if(!empty($params['id']))
    	{
    		$this->db->where('id', $params['id']);
    	}
    	
    	// Slug: The slug parameter is set
    	if(!empty($params['slug']))
    	{
    		$this->db->where('slug', $params['slug']);
	    	
    		$lang = (!empty($params['lang'])) ? $params['lang'] : DEFAULT_LANGUAGE;
		    $this->db->where('lang', $lang);
    	}
    	
        $query = $this->db->getwhere('pages');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
    
    // Return an object of objects containing page data
    function getPages($params = array()) {
    	
    	// Dont return body
        $this->db->select('id, slug, title, parent, lang, updated_on');
        
        if(!empty($params['order'])) {
        	$this->db->order_by($params['order']);
        }
    
    	// Whick language should we use?
    	if(!empty($params['lang']))
    	{
    		if($params['lang'] != 'all')
    		{
    			$this->db->where('lang', $params['lang']);
    		}
    	}
    	
    	// Pick from default language
    	else
    	{
    		$this->db->where('lang', DEFAULT_LANGUAGE);
    	}
    	
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
    // Create a new page
    function newPage($input = array()) {
        $this->load->helper('date');
        
        $this->db->insert('pages', array(
        	'slug' 			=> $input['slug'],
        	'title' 		=> $input['title'],
        	'body' 			=> $input['body'],
        	'parent' 		=> $input['parent'],
        	'lang' 			=> $input['lang'],
        	'updated_on'	=> now()
        ));
        
        return $this->db->insert_id();
    }
    
    // Update a Page
    function updatePage($id = 0, $input = array()) {
        $this->load->helper('date');
        
        $this->db->update('pages', array(
	        'title' 		=> $input['title'],
	        'slug' 			=> $input['slug'],
	        'body' 			=> $input['body'],
	        'parent' 		=> $input['parent'],
        	'lang' 			=> $input['lang'],
	        'updated_on' 	=> now()
        ), array('id' => $id));
        
    }
    
    // Delete a Page
    function deletePage($id = 0) {
        $this->db->delete('pages', array('id' => $id));
        
        $affected = $this->db->affected_rows();
        
		// Update parent page records whit empty slug???
        $this->db->update('pages', array('parent '=> 0), array('parent' => $id));
        
        return $affected;
    }

}

?>