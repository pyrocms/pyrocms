<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends Model {

    public function getById($id = 0)
    {
    	$this->db->where('id', $id);
    	return $this->db->get('pages')->row();
    }
    
    public function getByParentId($parent_id = 0)
    {
    	$this->db->where('parent_id', $parent_id);
    	return $this->db->get('pages')->row();
    }
    
    public function getByPath($segments = array())
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
            ++$level;
        }
        
        // Can only be one result
        $this->db->limit(1);
        
        return $this->db->get()->row();
    }
    
	// Get children from a Parent ID
	function getChildrenByParentId($parent_id = 0)
	{
		return $this->get( array('parent_id' => $parent_id) );
	}
    
    // Return an object of objects containing page data
    function get($params = array())
    {
    	// Dont return body
        $this->db->select('id, slug, title, parent_id, lang, updated_on');
        
        if(!empty($params['order']))
        {
        	$this->db->order_by($params['order']);
        	unset($params['order']);
        }
    
        return $this->db->get_where('pages', $params)->result();
    }
    
	// Count the amount of pages with param X
	function countPages($params = array())
	{
		$results = $this->get($params);
		
		return count($results);
	}
    
	function hasChildren($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		return $this->db->count_all_results('pages') > 0;
	}
	
	function getDescendantIds($id, $id_array = array())
	{
		$id_array[] = $id;
	
		$children = $this->db->select('id, title')
			->where('parent_id', $id)
			->get('pages')->result();
		
		$has_children = !empty($children);
		
		if($has_children)
		{
			// Loop through all of the children and run this function again
			foreach($children as $child)
			{
				$id_array = $this->getDescendantIds($child->id, $id_array);
			}
		}
		
		return $id_array;
	}
	
	// ----- PAGE INDEX --------------

	function getPathById($id)
	{
		return @$this->db->select('path')
					->where('id', $id)
					->get('pages_lookup')
					->row()
					->path;
	}
	
	function getIdByPath($path)
	{
		// If the URI has been passed as a string, explode to create an array of segments
    	if(is_array($path))
        {
        	$path = implode('/', $path);
        }
        
		return @$this->db->select('id')
					->where('path', $path)
					->get('pages_lookup')
					->row()
					->id;
	}
	
	function generateLookup($id)
	{
		$current_id = $id;
		
		$segments = array();
		do
		{
			$this->db->select('slug, parent_id');
			$this->db->where('id', $current_id);
			$page = $this->db->get('pages')->row();
			
			$current_id = $page->parent_id;
			array_unshift($segments, $page->slug);
		}
		while( $page->parent_id > 0 );
		
		// If the URI has been passed as a string, explode to create an array of segments
    	$this->db->set('id', $id);
    	$this->db->set('path', implode('/', $segments));
    	
		return $this->db->insert('pages_lookup');
	}
	
	function deleteLookup($id)
	{
    	$this->db->where('id', $id);
		return $this->db->delete('pages_lookup');
	}
	
	// ----- CRUD --------------------
	
    // Create a new page
    function create($input = array())
    {
        $this->load->helper('date');
        
        $this->db->trans_start();
        
        $this->db->insert('pages', array(
        	'slug' 			=> $input['slug'],
        	'title' 		=> $input['title'],
        	'body' 			=> $input['body'],
        	'parent_id'		=> $input['parent_id'],
        	'lang' 			=> $this->config->item('default_language'),
            'layout_file'	=> $input['layout_file'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        
        	'updated_on'	=> now()
        ));
        
        $id = $this->db->insert_id();
        
        $this->generateLookup($id);
        
        $this->db->trans_complete();
        
        return ($this->db->trans_status() !== FALSE) ? $id : FALSE;
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
        $this->db->trans_start();
        
        $ids = $this->getDescendantIds($id);
        
        $this->db->where_in('id', $ids);
    	$this->db->delete('pages');
    	
        $this->db->where_in('id', $ids);
    	$this->db->delete('pages_lookup');
    	
        $this->db->where_in('page_id', $ids);
    	$this->db->delete('navigation_links');
        
        $this->db->trans_complete();
        
        return ($this->db->trans_status() !== FALSE) ? $ids : FALSE;
    }
    
}

?>