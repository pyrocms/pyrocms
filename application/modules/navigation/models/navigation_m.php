<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Navigation_m extends Model {

	function getLink($id = 0)
	{
		$query = $this->db->getwhere('navigation_links', array('id'=>$id));
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}

	// Return an object of objects containing NavigationLink data
	function getLinks($params = array())
	{
		$this->db->select('*, IF(page_id > 0, "page", IF(module_name != "", "module", IF(url != "", "url", IF(uri != "", "uri", NULL)))) as link_type', FALSE);

		if(!empty($params['group']))
		{
			$this->db->where('navigation_group_id', $params['group']);
		}

		if(!empty($params['order']))
		{
			$this->db->order_by($params['order']);
		}
		
		else
		{
			$this->db->order_by('title');
		}

		$query = $this->db->get('navigation_links');

		if ($query->num_rows() > 0)
		{
			// If we should build the urls
			if(!isset($params['make_urls']) or $params['make_urls'])
			{
				$this->load->helper('url');

				$result = $query->result();
				foreach($result as &$row)
				{
					// If its any other type than a URL, it needs some help becoming one
					switch($row->link_type)
					{
						case 'uri':
							$row->url = site_url($row->uri);
						break;
							
						case 'module':
							$row->url = site_url($row->module_name);
						break;

						case 'page':
							$CI =& get_instance();
							$page_uri = $CI->pages_m->getPathById($row->page_id);
							$row->url = site_url($page_uri);
						break;
					}
				}
				
				return $result;
					
				// Just return the result, dont do anything fancy
			}
			
			else
			{
				return $query->result();
			}

		}
		
		return FALSE;
	}

	
	function frontendNavigation()
	{
		// Get Navigation Groups
		$groups = $this->getGroups();
		
		$navigation = array();
		
		// Go through all the groups 
    	foreach($groups as $group)
    	{
	    	$group_links = $this->getLinks(array(
    			'group'=>$group->id,
    			'order'=>'position, title'
    		));
    		
    		$has_current_link = false;
			
    		// Loop through all links and add a "current_link" property to show if it is active
    		if( !empty($group_links) )
    		{
	    		foreach($group_links as &$link)
	    		{
	    			$full_match = site_url($this->uri->uri_string()) == $link->url;
	    			$segment1_match = site_url($this->uri->rsegment(1, '')) == $link->url;
	    			
	    			// Either the whole URI matches, or the first segment matches
	    			if($link->current_link = $full_match || $segment1_match)
	    			{
	    				$has_current_link = true;
	    			}
	    		}
	    		
    		}
    		
    		else
    		{
    			$group_links = array();
    		}
    		
    		// Assign it 
    		$navigation[$group->abbrev] = $group_links;
    		
    	}
    	
    	return $navigation;
	}
	
	// Create a new Navigation Link
	function newLink($input = array())
	{
		$input = $this->_formatArray($input);
		 
		$this->db->insert('navigation_links', array(
        	'title' 				=> $input['title'],
        	'url' 					=> $input['url'],
        	'uri' 					=> $input['uri'],
        	'module_name' 			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
        	'position'				=> (int) $input['position'],
        	'navigation_group_id'	=> (int) $input['navigation_group_id']
		));
        
        return $this->db->insert_id();
	}

	// Update a Navigation Link
	function updateLink($id = 0, $input = array()) 
	{
		$input = $this->_formatArray($input);
		 
		$this->db->update('navigation_links', array(
        	'title' 				=> $input['title'],
        	'url' 					=> $input['url'] == 'http://' ? '' : $input['url'], // Do not insert if only http://
        	'uri' 					=> $input['uri'],
        	'module_name'			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
        	'position' 				=> (int) $input['position'],
        	'navigation_group_id' 	=> (int) $input['navigation_group_id']
		), array('id' => $id));
		
		return TRUE;
	}

	function _formatArray($input)
	{
		// If the url is not empty and not just the default http://
		if(!empty($input['url']) && $input['url'] != 'http://')
		{
			$input['uri'] = '';
			$input['module_name'] = '';
			$input['page_id'] = 0;
		}
		
		// If the uri is empty reset the others
		if(!empty($input['uri']))
		{
			$input['url'] = '';
			$input['module_name'] = '';
			$input['page_id'] = 0;
		}
		 
		// You get the idea...
		if(!empty($input['module_name']))
		{
			$input['url'] = '';
			$input['uri'] = '';
			$input['page_id'] = 0;
		}
		 
		if(!empty($input['page_id']))
		{
			$input['url'] = '';
			$input['uri'] = '';
			$input['module_name'] = '';
		}
		
		return $input;
	}
	
	// Delete a Navigation Link
	function deleteLink($id = 0)
	{
		if(is_array($id))  	$params = $id;
		else   				$params = array('id'=>$id);
		 
		$this->db->delete('navigation_links', $params);
        return $this->db->affected_rows();
	}


	// --------------------------------------------

	// Return an array of Navigation Groups
	function getGroups() 
	{
		return $this->db->get('navigation_groups')->result();
	}
	
	// Create a new Navigation Group
	function newGroup($input = array())
	{
		$this->db->insert('navigation_groups', array(
        	'title' => $input['title'],
        	'abbrev' => $input['abbrev']
		));
        
        return $this->db->insert_id();
	}
	
	// Delete a Navigation Group
	function deleteGroup($id = 0)
	{
		if(is_array($id))  	$params = $id;
		else   				$params = array('id'=>$id);
		 
		$this->db->delete('navigation_groups', $params);
        return $this->db->affected_rows();
	}
}

?>