<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends Model {

    public function getById($id = 0)
    {
    	$this->db->where('id', $id);
    	return $this->db->get('pages')->row();
    }
    
    public function getByURL($segments = array())
    {
		// If the URI has been passed as a string, explode to create an array of segments
    	if(is_string($segments))
        {
        	$segments = explode('/', $segments);
        }
    	
    	// Work out how many segments there are
        $total_segments = count($segments);
        
		// Which is the target alias (the final page in the tree)
        $target_alias = 'p'.$total_segments;

        // Start Query, Select (*) from Target Alias, from Pages
        $this->db->select($target_alias.'.*');
        $this->db->from('pages p1');
        
        // Loop thorugh each Slug
        $level = 1;
        foreach( $segments as $segment )
        {
            // Current is the current page, child is the next page to join on.
            $current_alias = 'p'.$level;
            $child_alias = 'p'.($level - 1);
    
            // We dont want to join the first page again
            if($level != 1)
            {
                $this->db->join('pages '.$current_alias, $current_alias.'.parent_id = '.$child_alias.'.id');
            }
            
            // Add slug to where clause to keep us on the right tree
            $this->db->where($current_alias . '.slug', $segment);
    
            // Increment
            $level++;
        }
        
        // Can only be one result
        $this->db->limit(1);
        
        return $this->db->get()->row();
    }
    
	// Count the amount of pages with param X
	function countPages($params = array())
	{
		$results = $this->get($params);
		
		if($results == FALSE)
		{
			return 0; 
		}
		else
		{
			return count($results);
		}
	}
    
    // Return an object of objects containing page data
    function get($params = array())
    {
    	// Dont return body
        $this->db->select('id, slug, title, parent_id, lang, updated_on');
        
        if(!empty($params['order']))
        {
        	$this->db->order_by($params['order']);
        }
    
        return $this->db->get('pages')->result();
    }
    
    // Create a new page
    function create($input = array())
    {
        $this->load->helper('date');
        
        $this->db->insert('pages', array(
        	'slug' 			=> $input['slug'],
        	'title' 		=> $input['title'],
        	'body' 			=> $input['body'],
        	'parent_id'		=> $input['parent_id'],
        	//'lang' 			=> $input['lang'],
        	'lang' 			=> $this->config->item('default_language'),
            'layout_file'	=> $input['layout_file'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        
        	'updated_on'	=> now()
        ));
        
        return $this->db->insert_id();
    }
    
    // Update a Page
    function update($id = 0, $input = array())
    {
        $this->load->helper('date');
        
        $this->db->update('pages', array(
	        'title' 		=> $input['title'],
	        'slug' 			=> $input['slug'],
	        'body' 			=> $input['body'],
	        'parent_id'		=> $input['parent_id'],
        	//'lang' 			=> $input['lang'],
        	'lang' 			=> $this->config->item('default_language'),
            'layout_file'	=> $input['layout_file'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        
	        'updated_on' 	=> now()
        ), array('id' => $id));
    }
    
    // Delete a Page
    function delete($id = 0)
    {
        $thia->db->where('id', $id)->or_where('parent_id', $id);
    	$this->db->delete('pages');
        
        return $this->db->affected_rows();
    }
    
}

?>