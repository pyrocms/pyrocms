<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_m extends MY_Model
{
    public function get_by_path($segments = array())
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
    
	// Count the amount of pages with param X
	function count($params = array())
	{
		$results = $this->get_many_by($params);
		
		return count($results);
	}
    
	function has_children($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		return $this->db->count_all_results('pages') > 0;
	}
	
	function get_descendant_ids($id, $id_array = array())
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
				$id_array = $this->get_descendant_ids($child->id, $id_array);
			}
		}
		
		return $id_array;
	}
	
	// ----- PAGE INDEX --------------

	function get_path_by_id($id)
	{
		$page = $this->db->select('path')
			->where('id', $id)
			->get('pages_lookup')
			->row();
					
		return isset($page->path) ? $page->path : '';
	}
	
	function get_id_by_path($path)
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
	
	function build_lookup($id)
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
	
	function delete_lookup($id)
	{
    	if( is_array($id) )
    	{
    		$this->db->where_in('id', $id);
    	}
		
    	else
    	{
    		$this->db->where('id', $id);
    	}
    	
		return $this->db->delete('pages_lookup');
	}
	
	function reindex_descendants($id)
	{
		$descendants = $this->get_descendant_ids($id);
		$this->delete_lookup($descendants);
		foreach($descendants as $descendant)
		{
			$this->build_lookup($descendant);
		}
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
        	'parent_id'		=> (int) $input['parent_id'],
            'layout_id'		=> (int) $input['layout_id'],
            'css'			=> $input['css'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'status' 		=> $input['status'],
        	'meta_description' => $input['meta_description'],
        	'updated_on'	=> now()
        ));
        
        $id = $this->db->insert_id();
        
        $this->build_lookup($id);
        
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
            'layout_id'		=> $input['layout_id'],
            'css'			=> $input['css'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        	'status' 		=> $input['status'],
	        'updated_on' 	=> now()
        ), array('id' => $id));
    }
    
    // Delete a Page
    function delete($id = 0)
    {
        $this->db->trans_start();
        
        $ids = $this->get_descendant_ids($id);
        
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