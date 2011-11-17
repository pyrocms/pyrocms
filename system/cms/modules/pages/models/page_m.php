<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Regular pages model
*
* @author Phil Sturgeon - PyroCMS Dev Team, Don Myers
* @package PyroCMS
* @subpackage Pages Module
* @category Modules
*
*/
class Page_m extends MY_Model
{
	
	private $chunk_index = 1;
	
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
		// flush uri cache
		$this->chunk_uris = array();
		
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
	public function insert(array $input = array(), $chunks = array())
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
			'order'		=> now()
		));
		
		$id = $this->db->insert_id();
	
		$this->build_lookup($id);
		
		$this->insert_chunks($id,$chunks);
		
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
		
		$this->update_chunks($chunks);

		// Wipe cache for this model, the content has changd
		$this->pyrocache->delete_all('page_m');
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
		
		// the page
		$this->db->where_in('id', $ids);
		$this->db->delete('pages');
		
		// any navigations links to that page
		$this->db->where_in('page_id', $ids);
		$this->db->delete('navigation_links');
		
		// the pages - page chunks
		foreach ($ids as $id)
		{
			$chunks = $this->get_chunks($id);
			foreach ($chunks as $chunk)
			{
				$this->delete_chunks($chunk);
			}
		}
		
		$this->db->trans_complete();
		
		return $this->db->trans_status() !== FALSE ? $ids : FALSE;
	}
	
	/**
	 * Check Slug for Uniqueness
	 * @access public
	 * @param slug, parent id, this records id
	 * @return bool
	*/
	public function check_slug($slug, $parent_id, $id = 0)
	{
		return (int) parent::count_by(array('id !='	=> $id,'slug' => $slug,'parent_id' => $parent_id)) > 0;
	}
		
	/*
	* ** Chunk Handling Section **
	*/

	/**
	 * Make a empty page chunk 
	 * the model should be the keeper of what a empty chunk looks like
	 *
	 * @access public
	 * @param mixed random slug name true (default) or string containing slug name
	 * @return array containing basic page chunk
	 */
	public function create_chunk($random = true)
	{
		return array(
			'id' => md5(uniqid()),
			'type' => 'wysiwyg-advanced',
			'slug' => ($random === true) ? 'chunk-'.substr(time().mt_rand(10,99),-6) : $random,
			'body' => '',
			'parsed' => '',
			'sort' => 0,
			'page_id' => 0		
		);
	}
	
	/**
	 * get page chunks based on page id
	 *
	 * @access public
	 * @param int page id
	 * @return array chunk as array
	 */
	 public function get_chunks($page_id)
	 {
		return $this->db->get_where('page_chunks', array('page_id' => $page_id))->result();			
	 }
	
	/**
	 * get page chunk based on chunk id
	 *
	 * @access public
	 * @param int chunk id
	 * @return array chunk as array
	 */
	public function get_chunk($chunk_id)
	{
		return $this->db->get_where('page_chunks', array('id' => $chunk_id))->result();
	}
	
	/**
	 * insert a page chunk(s)
	 *
	 * @access public
	 * @param int $page_id current page id
	 * @param array $chunks array of posted page chunks
	 * @return int last chunk inserted primary id
	 */
	public function insert_chunks($page_id,$chunks)
	{
		// is it a chunk or chunks?
		$chunks = (!isset($chunks[0])) ? array($chunks) : $chunks;

		foreach ($chunks as $chunk)
		{
			$chunk = (array)$chunk;

			$this->db->insert('page_chunks', array(
				'page_id' 	=> $page_id,
				'sort' 		=> $this->chunk_index++,
				'slug' 		=> $chunk['slug'],
				'body' 		=> $chunk['body'],
				'type' 		=> $chunk['type'],
				'parsed'	=> ($chunk['type'] == 'markdown') ? parse_markdown($chunk['body']) : ''
			));

		}
		// return id of last insert - if you want each insert id then send them in one at a time
		return $this->db->insert_id();
	}
	
	/**
	 * update a page chunk(s)
	 *
	 * @access public
	 * @param array of page chunks
	 * @return void
	 */
	public function update_chunks($chunks)
	{
		// is it a chunk or chunks?
		$chunks = (!isset($chunks[0])) ? array($chunks) : $chunks;

		foreach ($chunks as $chunk)
		{
			$chunk = (array)$chunk;

			$chunk_id = $chunk['id'];
			unset($chunk['id']);
			
			$this->db->update('page_chunks',array(
				'page_id' 	=> $chunk['page_id'],
				'sort' 		=> $this->chunk_index++,
				'slug' 		=> $chunk['slug'],
				'body' 		=> $chunk['body'],
				'type' 		=> $chunk['type'],
				'parsed'	=> ($chunk['type'] == 'markdown') ? parse_markdown($chunk['body']) : ''
			),array('id'=>$chunk_id));
		}
	}
	
	/**
	 * Delete a page chunk(s)
	 *
	 * @access public
	 * @param array of chunk objects
	 * @returns void
	 */
	public function delete_chunks($chunks)
	{
		// is it a chunk or chunks?
		$chunks = (array)$chunks;
		$chunks = (!isset($chunks[0])) ? array($chunks) : $chunks;

		foreach ($chunks as $chunk)
		{
			// let's turn this into an array incase it's a object
			$chunk = (array)$chunk;

			$this->db->delete('page_chunks',array('id'=>$chunk['id']));
		}
	}
	
}