<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends Model {

    public function getById($id = 0)
    {
    	$this->db->where('id', $id);
    	return $this->get();
    }
    
    public function getBySlug($slug = '', $lang = NULL)
    {
    	$this->db->where('slug', $slug);
    
    	if($lang == 'all')
		{
			exit('where did this code go?! tell me if you see this message email@philsturgeon.co.uk!');
		}  
		 	
    	elseif($lang != NULL)
    	{
		    $this->db->where('lang', $lang);
    	}
    	
    	return $this->get($lang);
    }
    
    // Return an object containing page data
    private function get($lang = NULL)
    {
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0)
        {
        	return $query->row();
        }
        
        else {
            return FALSE;
        }
    }
    
    // Return an object of objects containing page data
    function getPages($params = array())
    {
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
    		$this->db->where('lang', CURRENT_LANGUAGE);
    	}
    	
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
    // Create a new page
    function newPage($input = array())
    {
        $this->load->helper('date');
        
        $this->db->insert('pages', array(
        	'slug' 			=> $input['slug'],
        	'title' 		=> $input['title'],
        	'body' 			=> $input['body'],
        	'parent' 		=> $input['parent'],
        	'lang' 			=> $input['lang'],
        
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        
        	'updated_on'	=> now()
        ));
        
        return $this->db->insert_id();
    }
    
    // Update a Page
    function updatePage($id = 0, $input = array())
    {
        $this->load->helper('date');
        
        $this->db->update('pages', array(
	        'title' 		=> $input['title'],
	        'slug' 			=> $input['slug'],
	        'body' 			=> $input['body'],
	        'parent' 		=> $input['parent'],
        	'lang' 			=> $input['lang'],
        
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        
	        'updated_on' 	=> now()
        ), array('id' => $id));
    }
    
    // Delete a Page
    function deletePage($id = 0)
    {
        $this->db->delete('pages', array('id' => $id));
        
        $affected = $this->db->affected_rows();
        
		// Update parent page records whit empty slug???
        $this->db->update('pages', array('parent '=> 0), array('parent' => $id));
        
        return $affected;
    }
    
}

?>