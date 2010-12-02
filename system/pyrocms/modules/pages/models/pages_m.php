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

		// Simple join enables revisions - Yorick
		$this->db->join('revisions', $target_alias.'.revision_id = revisions.id');

        // Can only be one result
        $this->db->limit(1);

        return $this->db->get()->row();
    }

	/**
	 * Count the amount of pages with param X
	 *
	 * @access public
	 * @param array $params The parameters
	 * @return int
	 */
	public function count($params = array())
	{
		$results = $this->get_many_by($params);

		return count($results);
	}

	/**
	 * Does the page has any children, wait, can pages actually get pregnant and have kids?
	 *
	 * @access public
	 * @param int $parent_id The ID of the parent page
	 * @return mixed
	 */
	public function has_children($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		return $this->db->count_all_results('pages') > 0;
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

	/**
	 * Get a path based on ID X
	 *
	 * @access public
	 * @param int $id The ID to use
	 * @return string
	 */
	public function get_path_by_id($id)
	{
		$page = $this->db->select('path')
			->where('id', $id)
			->get('pages_lookup')
			->row();

		return isset($page->path) ? $page->path : '';
	}

	/**
	 * Get an ID based on a specified path
	 *
	 * @access public
	 * @param string $path The path to use
	 * @return array
	 */
	public function get_id_by_path($path)
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
    	return $this->db
			->set('id', $id)
			->set('path', implode('/', $segments))
			->insert('pages_lookup');
	}

	/**
	 * Delete a lookup
	 *
	 * @access public
	 * @param int $id
	 * @return array
	 */
	public function delete_lookup($id)
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
		$this->delete_lookup($descendants);
		foreach($descendants as $descendant)
		{
			$this->build_lookup($descendant);
		}
	}

	/**
	 * Create a new page
	 *
	 * @access public
	 * @param array $input The data to insert
	 * @return bool
	 */
    public function create($input = array())
    {
        $this->load->helper('date');

        $this->db->trans_start();

        $this->db->insert('pages', array(
        	'slug' 			=> $input['slug'],
        	'title' 		=> $input['title'],
        	'parent_id'		=> (int) $input['parent_id'],
            'layout_id'		=> (int) $input['layout_id'],
            'css'			=> $input['css'],
            'js'			=> $input['js'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        	'rss_enabled' 	=> (int) !empty($input['rss_enabled']),
        	'comments_enabled' 	=> (int) !empty($input['comments_enabled']),
        	'status' 		=> $input['status'],
        	'created_on'	=> now()
        ));

        $id = $this->db->insert_id();

        $this->build_lookup($id);

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
    public function update($id = 0, $input = array())
    {
        $this->load->helper('date');

        $return = $this->db->update('pages', array(
	        'title' 		=> $input['title'],
	        'slug' 			=> $input['slug'],
	        'revision_id'	=> $input['revision_id'],
	        'parent_id'		=> $input['parent_id'],
	        'layout_id'		=> $input['layout_id'],
	        'css'			=> $input['css'],
	        'js'			=> $input['js'],
        	'meta_title'	=> $input['meta_title'],
        	'meta_keywords'	=> $input['meta_keywords'],
        	'meta_description' => $input['meta_description'],
        	'rss_enabled' 	=> (int) !empty($input['rss_enabled']),
        	'comments_enabled' 	=> (int) !empty($input['comments_enabled']),
        	'status' 		=> $input['status'],
	        'updated_on' 	=> now()
        ), array('id' => $id));

        $this->cache->delete_all('navigation_m');

        return $return;
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

        $this->db->where_in('id', $ids);
    	$this->db->delete('pages_lookup');

        $this->db->where_in('page_id', $ids);
    	$this->db->delete('navigation_links');

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE ? $ids : FALSE;
    }
}