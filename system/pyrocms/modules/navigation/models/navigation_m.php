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
class Navigation_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = 'navigation_links';
	}
	
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
		
		//get only links with no parent
		if(isset($params['top']))
		{
			$this->db->where('parent', $params['top']);
		}

		if(!empty($params['order']))
		{
			$this->db->order_by($params['order']);
		}
		
		else
		{
			$this->db->order_by('title');
		}

		$result = $this->db->get('navigation_links')->result();

		// If we should build the urls
		if( ! isset($params['make_urls']) or $params['make_urls'])
		{
			$this->load->helper('url');

			$result = $this->make_url($result);
		}

		return $result;
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
        	'url' 					=> isset($input['url']) ? $input['url'] : '',
        	'uri' 					=> isset($input['uri']) ? $input['uri'] : '',
        	'module_name' 			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
        	'position' 				=> $position,
			'target'				=> isset($input['target']) ? $input['target'] : '',
			'class'					=> isset($input['class']) ? $input['class'] : '',
        	'navigation_group_id'	=> (int) $input['navigation_group_id']
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
		 
		return $this->db->update('navigation_links', array(
        	'title' 				=> $input['title'],
        	'link_type' 			=> $input['link_type'],
        	'url' 					=> $input['url'] == 'http://' ? '' : $input['url'], // Do not insert if only http://
        	'uri' 					=> $input['uri'],
        	'module_name'			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
			'target'				=> $input['target'],
			'class'					=> $input['class'],
        	'navigation_group_id' 	=> (int) $input['navigation_group_id']
		), array('id' => $id));
	}
	
	/**
	 * Build a multi-array of parent > children.
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 * @return array An array representing the link tree
	 */
	public function get_link_tree($group_id)
	{

		$all_links = $this->db
			->select('id, parent, title', 'navigation_group_id')
			->where('navigation_group_id', $group_id)
			 ->order_by('position')
			 ->get($this->_table)
			 ->result_array();

		// we must reindex the array first
		foreach ($all_links as $row)
		{
			$links[$row['id']] = $row;
		}
		
		unset($all_links);

		// build a multidimensional array of parent > children
		foreach ($links as $row)
		{
			if (array_key_exists($row['parent'], $links))
			{
				// add this link to the children array of the parent link
				$links[$row['parent']]['children'][] =& $links[$row['id']];
			}
			
			// this is a root link
			if ($row['parent'] == 0)
			{
				$link_array[] =& $links[$row['id']];
			}
		}

		return $link_array;
	}
	
	/**
	 * Set the parent > child relations and child order
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @param array $link
	 * @return void
	 */
	public function _set_children($link)
	{
		if (isset($link['children']))
		{
			foreach ($link['children'] as $i => $child)
			{
				$this->db->where('id', str_replace('link_', '', $child['id']));
				$this->db->update($this->_table, array('parent' => str_replace('link_', '', $link['id']), 'position' => $i));
				
				//repeat as long as there are children
				if (isset($child['children']))
				{
					$this->_set_children($child);
				}
			}
		}
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
		$params = is_array($id) ? $id : array('id' => $id);
		
		return $this->db->delete('navigation_links', $params);
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
		if ( ! $group = $this->get_group_by('abbrev', $abbrev))
		{
			return FALSE;
		}

		$group_links = $this->get_links(array(
			'group'=> $group->id,
			'order'=>'position, title',
			'top'=> 0
		));
    		
		$has_current_link = false;
			
		// Loop through all links and add a "current_link" property to show if it is active
		if( ! empty($group_links) )
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

				//build a multidimensional array for submenus
				if ($link->parent == 0)
				{
					$link->children = $this->_build_multidimensional_array($link);
				}
			}
			
		}

		// Assign it 
	    return $group_links;
	}

	public function _build_multidimensional_array($link)
	{
		$children = array();

		if ($link->has_kids > 0)
		{
			$children = $this->get_children($link->id);
			
			foreach ($children as $key => $child)
			{
				$children[$key]->children = $this->_build_multidimensional_array($child);
			}
		}

		return $children;
	}
	
	/**
	 * Get children
	 *
	 * @access public
	 * @param integer Get links by parent id
	 * @return mixed
	 */
	public function get_children($id)
	{
		$children = $this->db->where('parent', $id)
							->order_by('position')
							->order_by('title')
							->get('navigation_links')
							->result();
							
		return $this->make_url($children);
	}
	
	/**
	 * Make URL
	 *
	 * @access public
	 * @param array $row Navigation record
	 * @return mixed Valid url
	 */
	public function make_url($result)
	{
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
					$page = $this->pages_m->get($row->page_id);
					$row->url = $page ? site_url($page->uri) : '';
				break;
			}
		}

		return $result;
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
		$params = is_array($id) ? $id : array('id'=>$id);
		 
		$this->db->delete('navigation_groups', $params);
        return $this->db->affected_rows();
	}
}