<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Navigation Module
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Navigation model for the navigation module.
 */
class Navigation_m extends Model
{
	function get_link($id = 0)
	{
		$query = $this->db->get_where('navigation_links', array('id'=>$id));
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}

	// Return an object of objects containing NavigationLink data
	function get_links($params = array())
	{
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
							$page_uri = $CI->pages_m->get_path_by_id($row->page_id);
							$row->url = site_url($page_uri);
						break;
					}
				}
				
				return $result;
					
				// Just return the result, dont do anything fancy
			}
			
			return $query->result();

		}
		
		return array();
	}
	
	// Create a new Navigation Link
	function insert_link($input = array())
	{
		$input = $this->_format_array($input);
		
		$row = $this->db->order_by('position', 'desc')
			->limit(1)
			->get_where('navigation_links', array('navigation_group_id' => (int) $input['navigation_group_id']))
			->row();
			
		$position = isset($row->position) ? $row->position + 1 : 1;
		
		$this->db->insert('navigation_links', array(
        	'title' 				=> $input['title'],
        	'link_type' 			=> $input['link_type'],
        	'url' 					=> $input['url'],
        	'uri' 					=> $input['uri'],
        	'module_name' 			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
        	'position' 				=> $position,
			'target'				=> $input['target'],
        	'navigation_group_id'	=> (int) $input['navigation_group_id']
		));
        
        return $this->db->insert_id();
	}

	// Update a Navigation Link
	function update_link($id = 0, $input = array()) 
	{
		$input = $this->_format_array($input);
		 
		$this->db->update('navigation_links', array(
        	'title' 				=> $input['title'],
        	'link_type' 			=> $input['link_type'],
        	'url' 					=> $input['url'] == 'http://' ? '' : $input['url'], // Do not insert if only http://
        	'uri' 					=> $input['uri'],
        	'module_name'			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
			'target'				=> $input['target'],
        	'navigation_group_id' 	=> (int) $input['navigation_group_id']
		), array('id' => $id));
		
		return TRUE;
	}
	
	function update_link_position($id = 0, $position) 
	{
		return $this->db->update('navigation_links', array(
        	'position' => (int) $position
		), array('id' => $id));
	}

	function _format_array($input)
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
	function delete_link($id = 0)
	{
		if(is_array($id))  	$params = $id;
		else   				$params = array('id'=>$id);
		 
		$this->db->delete('navigation_links', $params);
        return $this->db->affected_rows();
	}


	// --------------------------------------------

	function load_group($abbrev)
	{
		$group = $this->get_group_by('abbrev', $abbrev);
		
		$group_links = $this->get_links(array(
    			'group'=>$group->id,
    			'order'=>'position, title'
    		));
    		
		$has_current_link = false;
			
		// Loop through all links and add a "current_link" property to show if it is active
		if( !empty($group_links) )
		{
			foreach($group_links as &$link)
			{
				$full_match 	= site_url($this->uri->uri_string()) == $link->uri;
				$segment1_match = site_url($this->uri->rsegment(1, '')) == $link->uri;
				
				// Either the whole URI matches, or the first segment matches
				if($link->current_link = $full_match || $segment1_match)
				{
					$has_current_link = true;
				}
			}
			
		}
			
		// Assign it 
	    	return $group_links;
	}
	
	function get_group_by($what, $value) 
	{
		return $this->db->where($what, $value)->get('navigation_groups')->row();
	}
	
	// Return an array of Navigation Groups
	function get_groups() 
	{
		return $this->db->get('navigation_groups')->result();
	}
	
	// Create a new Navigation Group
	function insert_group($input = array())
	{
		$this->db->insert('navigation_groups', array(
        	'title' => $input['title'],
        	'abbrev' => $input['abbrev']
		));
        
        return $this->db->insert_id();
	}
	
	// Delete a Navigation Group
	function delete_group($id = 0)
	{
		if(is_array($id))  	$params = $id;
		else   				$params = array('id'=>$id);
		 
		$this->db->delete('navigation_groups', $params);
        return $this->db->affected_rows();
	}
}

?>
