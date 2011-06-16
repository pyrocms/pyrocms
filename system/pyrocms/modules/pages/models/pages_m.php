<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Regular pages model
*
* @author Phil Sturgeon - PyroCMS Dev Team
* @package PyroCMS
* @subpackage Pages Module
* @category Modules
*
*/
class Pages_m extends MY_Model
{
	
	/**
	* Get a page by it's path
	*
	* @access public
	* @param array $segments The path segments
	* @return array
	*/
	/*
	* Not in use right now but added back for a) historical purposes and b) it was f**king difficult to write and I dont want to have to do it again
	* 
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
	$this->db->select($target_alias.'.*, revisions.id as revision_id, revisions.owner_id, revisions.table_name, revisions.body, revisions.revision_date, revisions.author_id');
	$this->db->from('pages p1');
	
		// Simple join enables revisions - Yorick
		$this->db->join('revisions', 'p1.revision_id = revisions.id');
	
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
	*/
		
	/**
	 * Get a page by it's URI
	 *
	 * @access public
	 * @param string	The uri of the page
	 * @return object
	 */
	public function get_by_uri($uri)
	{
		// If the URI has been passed as a array, implode to create an string of uri segments
		is_array($uri) && $uri = implode('/', $uri);
	
		return $this->db
			->where('uri', trim($uri, '/'))
			->limit(1)
			->get('pages')
			->row();
	}

	/**
	* Get the home page
	*
	* @access public
	* @param string  The uri of the page
	* @return object
	*/
	public function get_home()
	{
		return $this->db
			->where('is_home', 1)
			->get('pages')
			->row();
	}
	
	/**
	 * Build a multi-array of parent > children.
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 * @return array An array representing the page tree
	 */
	public function get_page_tree()
	{
		$all_pages = $this->db
			->select('id, parent_id, title')
			 ->order_by('`order`')
			 ->get('pages')
			 ->result_array();
	
		// we must reindex the array first
		foreach ($all_pages as $row)
		{
			$pages[$row['id']] = $row;
		}
		
		unset($all_pages);
	
		// build a multidimensional array of parent > children
		foreach ($pages as $row)
		{
			if (array_key_exists($row['parent_id'], $pages))
			{
				// add this page to the children array of the parent page
				$pages[$row['parent_id']]['children'][] =& $pages[$row['id']];
			}
			
			// this is a root page
			if ($row['parent_id'] == 0)
			{
				$page_array[] =& $pages[$row['id']];
			}
		}
	
		return $page_array;
	}
	
	/**
	 * Set the parent > child relations and child order
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @param array $page
	 * @return void
	 */
	public function _set_children($page)
	{
		if (isset($page['children']))
		{
			foreach ($page['children'] as $i => $child)
			{
				$this->db->where('id', str_replace('page_', '', $child['id']));
				$this->db->update('pages', array('parent_id' => str_replace('page_', '', $page['id']), '`order`' => $i));
				
				//repeat as long as there are children
				if (isset($child['children']))
				{
					$this->_set_children($child);
				}
			}
		}
	}
	
	/**
	 * Does the page have children?
	 *
	 * @access public
	 * @param int $parent_id The ID of the parent page
	 * @return mixed
	 */
	public function has_children($parent_id)
	{
		return parent::count_by(array('parent_id' => $parent_id)) > 0;
	}
	
	/**
	 * Get the child IDs
	 *
	 * @param int $id The ID of the page?
	 * @param array $id_array ?
	 * @return array
	 */
	public function get_descendant_ids($id, $id_array = array())
	{
		$id_array[] = $id;
	
		$children = $this->db->select('id, title')
			->where('parent_id', $id)
			->get('pages')->result();
	
		$has_children = !empty($children);
	
		if ($has_children)
		{
			// Loop through all of the children and run this function again
			foreach ($children as $child)
			{
				$id_array = $this->get_descendant_ids($child->id, $id_array);
			}
		}
	
		return $id_array;
	}
	
	/**
	 * Build a lookup
	 *
	 * @access public
	 * @param int $id
	 * @return array
	 */
	public function build_lookup($id)
	{
		$current_id = $id;
	
		$segments = array();
		do
		{
			$page = $this->db
				->select('slug, parent_id')
				->where('id', $current_id)
				->get('pages')
				->row();
	
			$current_id = $page->parent_id;
			array_unshift($segments, $page->slug);
		}
		while( $page->parent_id > 0 );
	
		// If the URI has been passed as a string, explode to create an array of segments
		return parent::update($id, array(
			'uri' => implode('/', $segments)
		));
	}
	
	/**
	 * Reindex child items
	 *
	 * @access public
	 * @param int $id The ID of the parent item
	 * @return void
	 */
	public function reindex_descendants($id)
	{
		$descendants = $this->get_descendant_ids($id);
		foreach ($descendants as $descendant)
		{
			$this->build_lookup($descendant);
		}
	}
	
	/**
	 * Update lookup for entire page tree
	 * used to update page uri after ajax sort
	 *
	 * @access public
	 * @param array $root_pages An array of top level pages
	 * @return void
	 */
	public function update_lookup($root_pages)
	{
		// first reset the URI of all root pages
		$this->db
			->where('parent_id', 0)
			->set('uri', 'slug', FALSE)
			->update('pages');
			
		foreach ($root_pages as $page)
		{
			$this->reindex_descendants($page);
		}
	}
	
	/**
	 * Create a new page
	 *
	 * @access public
	 * @param array $input The data to insert
	 * @return bool
	 */
	public function insert($input = array(), $chunks = array())
	{
		$this->db->trans_start();
	
		if ( ! empty($input['is_home']))
		{
			// Remove other homepages
			$this->db
				->where('is_home', 1)
				->update('pages', array('is_home' => 0));
		}
	
		parent::insert(array(
			'slug'			=> $input['slug'],
			'title'			=> $input['title'],
			'uri'			=> NULL,
			'parent_id'		=> (int) $input['parent_id'],
			'layout_id'		=> (int) $input['layout_id'],
			'css'			=> $input['css'],
			'js'			=> $input['js'],
			'meta_title'		=> $input['meta_title'],
			'meta_keywords'		=> $input['meta_keywords'],
			'meta_description'	=> $input['meta_description'],
			'rss_enabled'		=> (int) ! empty($input['rss_enabled']),
			'comments_enabled'	=> (int) ! empty($input['comments_enabled']),
			'is_home'		=> (int) ! empty($input['is_home']),
			'status'		=> $input['status'],
			'created_on'		=> now(),
			'`order`'		=> now()
		));
		
		$id = $this->db->insert_id();
	
		$this->build_lookup($id);
		
		if ($chunks)
		{
			// And add the new ones
			$i = 1;
			foreach ($chunks as $chunk)
			{
				$this->db->insert('page_chunks', array(
					'page_id' => $id,
					'sort' => $i++,
					'slug' => $chunk->slug,
					'body' => $chunk->body,
					'type' => $chunk->type,
				));
			}
		}	
		
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : $id;
	}
	
	/**
	* Update a Page
	 *
	 * @access public
	 * @param int $id The ID of the page to update
	 * @param array $input The data to update
	 * @return void
	*/
	public function update($id = 0, $input = array(), $chunks = array())
	{
		$this->db->trans_start();
	
		if ( ! empty($input['is_home']))
		{
			// Remove other homepages
			$this->db
				->where('is_home', 1)
				->update($this->_table, array('is_home' => 0));
		}
	
		parent::update($id, array(
			'title'				=> $input['title'],
			'slug'				=> $input['slug'],
			'uri'				=> NULL,
			'parent_id'			=> $input['parent_id'],
			'layout_id'			=> $input['layout_id'],
			'css'				=> $input['css'],
			'js'				=> $input['js'],
			'meta_title'		=> $input['meta_title'],
			'meta_keywords'		=> $input['meta_keywords'],
			'meta_description'	=> $input['meta_description'],
			'restricted_to'		=> $input['restricted_to'],
			'rss_enabled'		=> (int) ! empty($input['rss_enabled']),
			'comments_enabled'	=> (int) ! empty($input['comments_enabled']),
			'is_home'			=> (int) ! empty($input['is_home']),
			'status'			=> $input['status'],
			'updated_on'		=> now()
		));
		
		$this->build_lookup($id);
		
		if ($chunks)
		{
			// Remove the old chunks
			$this->db->delete('page_chunks', array('page_id' => $id));
			
			// And add the new ones
			$i = 1;
			foreach ($chunks as $chunk)
			{
				$this->db->insert('page_chunks', array(
					'page_id' => $id,
					'sort' => $i++,
					'slug' => $chunk->slug,
					'body' => $chunk->body,
					'type' => $chunk->type,
				));
			}
		}	
		// Wipe cache for this model, the content has changd
		$this->pyrocache->delete_all('pages_m');
		$this->pyrocache->delete_all('navigation_m');
	
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE;
	}
	
	/**
	* Delete a Page
	 *
	 * @access public
	 * @param int $id The ID of the page to delete
	 * @return bool
	*/
	public function delete($id = 0)
	{
		$this->db->trans_start();
		
		$ids = $this->get_descendant_ids($id);
		
		$this->db->where_in('id', $ids);
		$this->db->delete('pages');
		
		$this->db->where_in('page_id', $ids);
		$this->db->delete('navigation_links');
		
		$this->db->trans_complete();
		
		return $this->db->trans_status() !== FALSE ? $ids : FALSE;
	}
}