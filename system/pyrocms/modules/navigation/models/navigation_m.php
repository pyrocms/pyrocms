<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Navigation model for the navigation module.
 * 
 * @package 		PyroCMS
 * @subpackage 		Navigation Module
 * @category		Modules
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 */
class Navigation_m extends CI_Model
{
	/**
	 * Get a navigation link
	 * 
	 * @access public 
	 * @param int $id The ID of the item
	 * @return mixed
	 */
	public function get_link($id = 0)
	{
		$query = $this->db->get_where('navigation_links', array('id'=>$id));
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}

	/**
	 * Return an object of objects containing NavigationLink data
	 * 
	 * @access public
	 * @param array $params The link parameters
	 * @return mixed
	 */
	public function get_links($params = array())
	{
		if(!empty($params['group']))
		{
			$this->db->where('navigation_group_id', $params['group']);
		}

		if(!empty($params['parent']))
		{
			$this->db->where('parent_link_id', $params['parent']);
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
			$result = $query->result();

			// If we only want a simple array with id => title
			if(isset($params['title_array']) and $params['title_array'])
			{
				$return = array();
				foreach($result as &$row)
				{
					$return[$row->id] = $row->title;
				}
				return $return;
			}

			if(isset($params['children']) and $params['children'] == true)
			{
				foreach($result as &$row)
				{
					$row->children = $this->get_links(array('parent'=>$row->id)+$params);
				}
			}

			// If we should build the urls
			if(!isset($params['make_urls']) or $params['make_urls'])
			{
				$this->load->helper('url');

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
				
					
				// Just return the result, dont do anything fancy
			}

			return $result;
		}
		
		return array();
	}

	/**
	 * Get a tree of the links 
	 * @param int $navigation_group_id The navigation group for which to retrieve the tree
	 */
	function get_links_tree($group)
	{
		return $this->get_links(array(
			'group'			=> $group,
			'parent'		=> '-1',
			'children' 		=> true,
			'order' 		=> 'position',
		));
	}
	
	/**
	 * Create a new Navigation Link
	 * 
	 * @access public
	 * @param array $input The data to insert
	 * @return int
	 */
	public function insert_link($input = array())
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
			'navigation_group_id'	=> (int) $input['navigation_group_id'],
			'parent_link_id'		=> (int) $input['parent_link_id'],
		));
        
        return $this->db->insert_id();
	}

	/**
	 * Update a Navigation Link
	 * 
	 * @access public
	 * @param int $id The ID of the link to update
	 * @param array $input The data to update
	 * @return bool
	 */
	public function update_link($id = 0, $input = array()) 
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
        	'navigation_group_id' 	=> (int) $input['navigation_group_id'],
			'parent_link_id'		=> (int) $input['parent_link_id'],
		), array('id' => $id));
		
		return TRUE; // #FIXME: Wait, doesn't this kinda kill the whole possibility of validating the results? It will now always return TRUE, or is it just me? - Yorick
	}
	
	/**
	 * Update a link's position
	 * 
	 * @access public
	 * @param int $id The ID of the link item
	 * @param int $position The current position of the link item
	 * @return void
	 */
	public function update_link_position($id = 0, $position) 
	{
		return $this->db->update('navigation_links', array(
        	'position' => (int) $position
		), array('id' => $id));
	}

	/**
	 * Format an array
	 * 
	 * @access public
	 * @param array $input The data to format
	 * @return array
	 */
	public function _format_array($input)
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
	
	/**
	 * Delete a Navigation Link
	 * 
	 * @access public
	 * @param int $id The ID of the link to delete
	 * @return array
	 */
	public function delete_link($id = 0)
	{
		if(is_array($id))  	$params = $id;
		else   				$params = array('id'=>$id);
		 
		$this->db->delete('navigation_links', $params);
        return $this->db->affected_rows();
	}


	/**
	 * Load a group
	 * 
	 * @access public
	 * @param string $abbrev The group abbrevation
	 * @return mixed
	 */
	public function load_group($abbrev)
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


	/**
	 * Load a group with tree structure
	 *
	 * @access public
	 * @param string $abbrev The group abbreviation
	 * @return mixed
	 */
	public function load_group_tree($abbrev)
	{
		$group = $this->get_group_by('abbrev', $abbrev);

		$group_root = $this->get_links_tree($group->id);

		$has_current_link = false;

		if($this->_check_current_links($group_root))
		{
			$has_current_link = true;
		}

		return $group_root;
	}

	/**
	 * Function for iterating through the link tree structure to determine which link
	 * is currently active. Returns true if any provided links are active.
	 *
	 * @access private
	 * @param array $group_links An array of navigation link objects to run through
	 * @return boolean
	 */
	private function _check_current_links(&$group_links)
	{
		$has_current_link = false;
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

				// Check if there are any current links in the children too
				if(isset($link->children) and $this->_check_current_links($link->children))
				{
					$has_current_link = true;
				}
			}
			
		}

		return $has_current_link;
	}

	/**
	 * Get group by..
	 * 
	 * @access public
	 * @param string $what What to get
	 * @param string $value The value
	 * @return mixed
	 */
	public function get_group_by($what, $value) 
	{
		return $this->db->where($what, $value)->get('navigation_groups')->row();
	}
	
	/**
	 * Return an array of Navigation Groups
	 * 
	 * @access public
	 * @return void
	 */
	public function get_groups() 
	{
		return $this->db->get('navigation_groups')->result();
	}
	
	/**
	 * 
	 * Insert a new group into the DB
	 * 
	 * @param array $input The data to insert
	 * @return int
	 */
	public function insert_group($input = array())
	{
		$this->db->insert('navigation_groups', array(
        	'title' => $input['title'],
        	'abbrev' => $input['abbrev']
		));
        
        return $this->db->insert_id();
	}
	
	/**
	 * Delete a Navigation Group
	 * 
	 * @access public
	 * @param int $id The ID of the group to delete
	 * @return array
	 */
	public function delete_group($id = 0)
	{
		if(is_array($id))  	$params = $id;
		else   				$params = array('id'=>$id);
		 
		$this->db->delete('navigation_groups', $params);
        return $this->db->affected_rows();
	}
}
