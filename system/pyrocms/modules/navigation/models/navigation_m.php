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

		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $query->row();
		}
	}
	
	/**
	 * Get a navigation link with all the trimmings
	 * 
	 * @access public 
	 * @param int $id The ID of the item
	 * @return mixed
	 */
	public function get_url($id = 0)
	{
		$query = $this->db->get_where('navigation_links', array('id'=>$id));

		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $this->make_url($query->result());
		}
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
		
		$insert = array(
        	'title' 				=> $input['title'],
        	'link_type' 			=> $input['link_type'],
        	'url' 					=> $input['url'] == 'http://' ? '' : $input['url'], // Do not insert if only http://
        	'uri' 					=> $input['uri'],
        	'module_name'			=> $input['module_name'],
        	'page_id' 				=> (int) $input['page_id'],
			'target'				=> $input['target'],
			'class'					=> $input['class'],
        	'navigation_group_id' 	=> (int) $input['navigation_group_id']
		);
		
		// if it was changed to a different group we need to reset the parent > child
		if ($input['current_group_id'] != $input['navigation_group_id'])
		{
			// modify the link update array to reset this link in case it's a child
			$insert['parent'] = 0;
		
			// reset all of this link's children
			$this->db->where('parent', $id)->update($this->_table, array('parent' => 0));
		}

		return $this->db->update('navigation_links', $insert, array('id' => $id));
	}
	
	/**
	 * Update links by group
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 * @param int $group
	 * @param array $data
	 * @return boolean
	 */
	public function update_by_group($group = 0, $data = array())
	{
		
		return $this->db->where_in('navigation_group_id', $group)
			->set($data)
			->update($this->_table);
	}
	
	/**
	 * Build a multi-array of parent > children.
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 * @param  string $group Either the group abbrev or the group id
	 * @return array An array representing the link tree
	 */
	public function get_link_tree($group, $params = array())
	{
		// the plugin passes the abbreviation
		if ( ! is_numeric($group))
		{
			$row = $this->get_group_by('abbrev', $group);
			$group = $row->id;
		}
		
		if ( ! empty($params['order']))
		{
			$this->db->order_by($params['order']);
		}
		else
		{
			$this->db->order_by('position');
		}

		$all_links = $this->db->where('navigation_group_id', $group)
			 ->get($this->_table)
			 ->result_array();

		$this->load->helper('url');

		$links = array();
		
		// we must reindex the array first and build urls
		$all_links = $this->make_url_array($all_links);
		foreach ($all_links AS $row)
		{
			$links[$row['id']] = $row;
		}

		unset($all_links);

		$link_array = array();

		// build a multidimensional array of parent > children
		foreach ($links AS $row)
		{
			if (array_key_exists($row['parent'], $links))
			{
				// add this link to the children array of the parent link
				$links[$row['parent']]['children'][] =& $links[$row['id']];
			}

			if ( ! isset($links[$row['id']]['children']))
			{
				$links[$row['id']]['children'] = array();
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
		if ($link['children'])
		{
			foreach ($link['children'] as $i => $child)
			{
				$this->db->where('id', str_replace('link_', '', $child['id']));
				$this->db->update($this->_table, array('parent' => str_replace('link_', '', $link['id']), 'position' => $i));
				
				//repeat as long as there are children
				if ($child['children'])
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
	 * Make URL
	 *
	 * @access public
	 * @param array $row Navigation record
	 * @return mixed Valid url
	 */
	public function make_url($result)
	{
		foreach($result as $key => &$row)
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
					if ($page = $this->pages_m->get_by(array_filter(array(
						'id'		=> $row->page_id,
						'status'	=> (is_subclass_of(ci(), 'Public_Controller') ? 'live' : NULL)
					))))
					{
						$row->url = site_url($page->uri);
						$row->is_home = $page->is_home;
					}
					else
					{
						unset($result[$key]);
					}
				break;
			}
		}

		return $result;
	}
	
	/**
	 * Make a URL array
	 *
	 * @access public
	 * @param array $row Array of links
	 * @return mixed Array of links with valid urls
	 */
	public function make_url_array($links)
	{
		foreach($links as $key => &$row)
		{
			// If its any other type than a URL, it needs some help becoming one
			switch($row['link_type'])
			{
				case 'uri':
					$row['url'] = site_url($row['uri']);
				break;

				case 'module':
					$row['url'] = site_url($row['module_name']);
				break;

				case 'page':
					if ($page = $this->pages_m->get_by(array_filter(array(
						'id'		=> $row['page_id'],
						'status'	=> (is_subclass_of(ci(), 'Public_Controller') ? 'live' : NULL)
					))))
					{
						$row['url'] = site_url($page->uri);
						$row['is_home'] = $page->is_home;
					}
					else
					{
						unset($links[$key]);
					}
				break;
			}
		}

		return $links;
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