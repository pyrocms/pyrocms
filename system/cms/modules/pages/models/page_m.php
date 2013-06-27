<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Regular pages model
 *
 * @author Phil Sturgeon
 * @author Jerel Unruh
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages\Models
 *
 */
class Page_m extends MY_Model
{

	/**
	 * Array containing the validation rules
	 * 
	 * @var array
	 */
	public $validate = array(
		array(
			'field' => 'title',
			'label'	=> 'lang:global:title',
			'rules'	=> 'trim|required|max_length[250]'
		),
		'slug' => array(
			'field' => 'slug',
			'label'	=> 'lang:global:slug',
			'rules'	=> 'trim|required|alpha_dot_dash|max_length[250]|callback__check_slug'
		),
		array(
			'field'	=> 'css',
			'label'	=> 'lang:pages:css_label',
			'rules'	=> 'trim'
		),
		array(
			'field'	=> 'js',
			'label'	=> 'lang:pages:js_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'meta_title',
			'label' => 'lang:pages:meta_title_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field'	=> 'meta_keywords',
			'label' => 'lang:pages:meta_keywords_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field'    => 'meta_robots_no_index',
			'label'    => 'lang:pages:meta_robots_no_index_label',
			'rules'    => 'trim'
		),
		array(
			'field'    => 'meta_robots_no_follow',
			'label'    => 'lang:pages:meta_robots_no_follow_label',
			'rules'    => 'trim'
		),
		array(
			'field'	=> 'meta_description',
			'label'	=> 'lang:pages:meta_description_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'restricted_to[]',
			'label'	=> 'lang:pages:access_label',
			'rules'	=> 'trim|required'
		),
		array(
			'field' => 'rss_enabled',
			'label'	=> 'lang:pages:rss_enabled_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'comments_enabled',
			'label'	=> 'lang:pages:comments_enabled_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'is_home',
			'label'	=> 'lang:pages:is_home_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'strict_uri',
			'label'	=> 'lang:pages:strict_uri_label',
			'rules'	=> 'trim'
		),
		array(
			'field'	=> 'status',
			'label'	=> 'lang:pages:status_label',
			'rules'	=> 'trim|alpha|required'
		),
		array(
			'field' => 'navigation_group_id[]',
			'label' => 'lang:pages:navigation_label',
			'rules' => 'numeric'
		)
	);

    // --------------------------------------------------------------------------

	// For streams
	public $compiled_validate = array();

    // --------------------------------------------------------------------------

	public function __construct() {
		parent::__construct();
		$this->load->model('pages/page_type_m');
	}

	/**
	 * Get a page by its URI
	 *
	 * @param string $uri The uri of the page.
	 * @param bool $is_request Is this an http request or called from a plugin
	 *
	 * @return object
	 */
	public function get_by_uri($uri, $is_request = false, $simple_return = false)
	{
		// it's the home page
		if ($uri === null)
		{
			$page = $this->pyrocache->model('page_m', 'get_home', array());
		}
		else
		{
			// If the URI has been passed as an array, implode to create a string of uri segments
			is_array($uri) && $uri = trim(implode('/', $uri), '/');

			// $uri gets shortened so we save the original
			$original_uri = $uri;
			$page = false;
			$i = 0;

			while ( ! $page AND $uri AND $i < 15) /* max of 15 in case it all goes wrong (this shouldn't ever be used) */
			{
				$page = $this->pyrocache->model('page_m', 'get_page_simple', array($uri));

				// if it's not a normal page load (plugin or etc. that is not cached)
				// then we won't do our recursive search
				if ( ! $is_request)
				{
					break;
				}

				// if we didn't find a page with that exact uri AND there's more than one segment
				if ( ! $page and strpos($uri, '/') !== false)
				{
					// pop the last segment off and we'll try again
					$uri = preg_replace('@^(.+)/(.*?)$@', '$1', $uri);
				}
				// we didn't find a page and there's only one segment; it's going to 404
				elseif ( ! $page)
				{
					break;
				}
				++$i;
			}

			if ($page)
			{
				// so we found a page but if strict uri matching is required and the unmodified
				// uri doesn't match the page we fetched then we pretend it didn't happen
				if ($is_request and (bool)$page->strict_uri and $original_uri !== $uri)
				{
					return false;
				}

				// things like breadcrumbs need to know the actual uri, not the uri with extra segments
				$page->base_uri = $uri;
			}
		}

		// Looks like we have a 404
		if ( ! $page) return false;

		// If this is a simple page call, then we just want this page
		// object, we don't need anything else.
		if ($simple_return) return $page;

		// ---------------------------------
		// Legacy Page Chunks Logic
		// ---------------------------------
		// This is here so upgrades will not
		// break entire sites. We can get rid
		// of this in a newer version.
		// ---------------------------------

		if ($this->db->table_exists('page_chunks'))
		{
			if ($page->chunks = $this->get_chunks($page->id))
			{
				$chunk_html = '';
				foreach ($page->chunks as $chunk)
				{
					$chunk_html .= '<section id="'.$chunk->slug.'" class="page-chunk '.$chunk->class.'">'.
						'<div class="page-chunk-pad">'.
						(($chunk->type == 'markdown') ? $chunk->parsed : $chunk->body).
						'</div>'.
						'</section>'.PHP_EOL;
				}
				$page->body = $chunk_html;
			}
		}

		// ---------------------------------
		// End Legacy Logic
		// ---------------------------------

		// Wrap the page with a page layout, otherwise use the default 'Home' layout
		if ( ! $page->layout = $this->pyrocache->model('page_type_m', 'get', array($page->type_id)))
		{
			// Some pillock deleted the page layout, use the default and pray to god they didnt delete that too
			$page->layout = $this->pyrocache->model('page_type_m', 'get', array(1));
		}

		// ---------------------------------
		// Load Page Vars
		// We need to get these in before we
		// call the stream entry so fields
		// can access vars like {{ page:id }}
		// ---------------------------------

		$this->load->vars(array('page' => $page, 'current_user' => $this->current_user));

		// ---------------------------------
		// Get Stream Entry
		// ---------------------------------

		if ($page->entry_id and $page->layout->stream_id)
		{
			$this->load->driver('Streams');

			// Get Streams
			$stream = $this->pyrocache->model('streams_m', 'get_stream', array($page->layout->stream_id));

			if ($stream)
			{
				$params = array(
					'limit' => 1,
					'stream' => $stream->stream_slug,
					'namespace' => $stream->stream_namespace,
					'id' => $page->entry_id,
					'cache_query' => true,
					'cache_folder' => 'page_m',
					'cache_expires'=> 9000
				);

				if ($entry = $this->streams->entries->get_entries($params))
				{
					if (isset($entry['entries'][0]))
					{
						$page = (object) array_merge((array)$entry['entries'][0], (array)$page);
					}
				}
			}
		}

		return $page;
	}

    // --------------------------------------------------------------------------

	/**
	 * Get a page from the database.
	 *
	 * Also retrieves the content fields for that page.
	 *
	 * @param int $id The page id.
	 * @param bool $get_data Whether to retrieve the stream data for this page or not. Defaults to true.
	 *
	 * @return array The page data.
	 */
	public function get($id, $get_data = true)
	{
		$page = $this->db
			->select('pages.*, page_types.id as page_type_id, page_types.stream_id, page_types.body')
			->select('page_types.save_as_files, page_types.slug as page_type_slug, page_types.title as page_type_title, page_types.js as page_type_js, page_types.css as page_type_css')
			->join('page_types', 'page_types.id = pages.type_id', 'left')
			->where('pages.id', $id)
			->get($this->_table)
			->row();

        if ( ! $page)
        {
            return;
        }
        
		$page->stream_entry_found = false;

		// ---------------------------------
		// Load Page Vars
		// We need to get these in before we
		// call the stream entry so fields
		// can access vars like {{ page:id }}
		// ---------------------------------

		$this->load->vars(array('page' => $page));

		// ---------------------------------
		// Get Page Stream Entry
		// ---------------------------------

		if ($page and $page->type_id and $get_data)
		{
			// Get our page type files in case we are grabbing
			// the body/html/css from the filesystem. 
			$this->page_type_m->get_page_type_files_for_page($page);

			$this->load->driver('Streams');
			$stream = $this->streams_m->get_stream($page->stream_id);

			if ($stream)
			{
				$params = array(
					'stream' 	=> $stream->stream_slug,
					'namespace' => $stream->stream_namespace,
					'where' 	=> "`id`='".$page->entry_id."'",
					'limit' 	=> 1
				);

				$ret = $this->streams->entries->get_entries($params);

				if (isset($ret['entries'][0]))
				{
					// For no collisions
					$ret['entries'][0]['entry_id'] = $ret['entries'][0]['id'];
					unset($ret['entries'][0]['id']);

					$page->stream_entry_found = true;

					return (object) array_merge((array) $page, (array) $ret['entries'][0]);
				}

				$this->page_type_m->get_page_type_files_for_page($page);
			}
		}

		return $page;
	}

    // --------------------------------------------------------------------------

	/**
	 * Get the home page
	 *
	 * @return object
	 */
	public function get_home()
	{
		return $this->db
			->where('is_home', true)
			->get('pages')
			->row();
	}

    // --------------------------------------------------------------------------

	/**
	 * Build a multi-array of parent > children.
	 *
	 * @return array An array representing the page tree.
	 */
	public function get_page_tree()
	{
		$all_pages = $this->db
			->select('id, parent_id, title, status')
			->order_by('`order`')
			->get('pages')
			->result_array();

		// First, re-index the array.
		foreach ($all_pages as $row)
		{
			$pages[$row['id']] = $row;
		}

		unset($all_pages);

		// Build a multidimensional array of parent > children.
		foreach ($pages as $row)
		{
			if (array_key_exists($row['parent_id'], $pages))
			{
				// Add this page to the children array of the parent page.
				$pages[$row['parent_id']]['children'][] =& $pages[$row['id']];
			}

			// This is a root page.
			if ($row['parent_id'] == 0)
			{
				$page_array[] =& $pages[$row['id']];
			}
		}

		return $page_array;
	}

    // --------------------------------------------------------------------------

	/**
	 * Return page data
	 *
	 * @return array An array containing data fields for a page
	 */
	public function get_data($stream_entry_id, $stream_slug)
	{
		return $this->streams->entries->get_entry($stream_entry_id, $stream_slug, 'pages');
	}

    // --------------------------------------------------------------------------

	/**
	 * Set the parent > child relations and child order
	 *
	 * @param array $page
	 */
	public function _set_children($page)
	{
		if (isset($page['children']))
		{
			foreach ($page['children'] as $i => $child)
			{
				$child_id = (int) str_replace('page_', '', $child['id']);
				$page_id = (int) str_replace('page_', '', $page['id']);

				$this->update($child_id, array('parent_id' => $page_id, '`order`' => $i), true);

				//repeat as long as there are children
				if (isset($child['children']))
				{
					$this->_set_children($child);
				}
			}
		}
	}

    // --------------------------------------------------------------------------

	/**
	 * Get Page Simple
	 *
	 * @param 	string $uri
	 * @return 	obj
	 */
	public function get_page_simple($uri)
	{
		return $this->db
			->where('uri', $uri)
			->limit(1)
			->get('pages')
			->row();		
	}

    // --------------------------------------------------------------------------

	/**
	 * Does the page have children?
	 *
	 * @param int $parent_id The ID of the parent page
	 *
	 * @return bool
	 */
	public function has_children($parent_id)
	{
		return parent::count_by(array('parent_id' => $parent_id)) > 0;
	}

    // --------------------------------------------------------------------------

	/**
	 * Return page chunks
	 *
	 * @DEPRECATED
	 *
	 * @return array An array containing all chunks for a page
	 */
	public function get_chunks($id)
	{
		return $this->db
			->order_by('sort')
			->get_where('page_chunks', array('page_id' => $id))
			->result();
	}

    // --------------------------------------------------------------------------

	/**
	 * Get the child IDs
	 *
	 * @param int $id The ID of the page?
	 * @param array $id_array ?
	 *
	 * @return array
	 */
	public function get_descendant_ids($id, $id_array = array())
	{
		$id_array[] = $id;

		$children = $this->db->select('id, title')
			->where('parent_id', $id)
			->get('pages')
			->result();

		if ($children)
		{
			// Loop through all of the children and run this function again
			foreach ($children as $child)
			{
				$id_array = $this->get_descendant_ids($child->id, $id_array);
			}
		}

		return $id_array;
	}

    // --------------------------------------------------------------------------

	/**
	 * Build a lookup
	 *
	 * @param int $id The id of the page to build the lookup for.
	 *
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
		while ($page->parent_id > 0);

		return $this->update($id, array('uri' => implode('/', $segments)), true);
	}

    // --------------------------------------------------------------------------

	/**
	 * Reindex child items
	 *
	 * @param int $id The ID of the parent item
	 */
	public function reindex_descendants($id)
	{
		$descendants = $this->get_descendant_ids($id);
		foreach ($descendants as $descendant)
		{
			$this->build_lookup($descendant);
		}
	}

    // --------------------------------------------------------------------------

	/**
	 * Update lookup.
	 *
	 * Updates lookup for entire page tree used to update
	 * page uri after ajax sort.
	 *
	 * @param array $root_pages An array of top level pages
	 */
	public function update_lookup($root_pages)
	{
		// first reset the URI of all root pages
		$this->db
			->where('parent_id', 0)
			->set('uri', 'slug', false)
			->update('pages');

		foreach ($root_pages as $page)
		{
			$this->reindex_descendants($page);
		}
	}

    // --------------------------------------------------------------------------

	/**
	 * Create a new page
	 *
	 * @param array $input The page data to insert.
	 * @param obj   $stream The stream tied to this page.
	 *
	 * @return bool `true` on success, `false` on failure.
	 */
	public function create($input, $stream = false)
	{
		$this->db->trans_start();

		if ( ! empty($input['is_home']))
		{
			// Remove other homepages so this one can have the spot
			$this->skip_validation = true;
			$this->update_by('is_home', 1, array('is_home' => 0));
		}

		// validate the data and insert it if it passes
		$id = $this->insert(array(
			'slug'				=> $input['slug'],
			'title'				=> $input['title'],
			'uri'				=> null,
			'parent_id'			=> (int) $input['parent_id'],
			'type_id'			=> (int) $input['type_id'],
			'css'				=> isset($input['css']) ? $input['css'] : null,
			'js'				=> isset($input['js']) ? $input['js'] : null,
			'meta_title'    	=> isset($input['meta_title']) ? $input['meta_title'] : '',
			'meta_keywords' 	=> isset($input['meta_keywords']) ? $this->keywords->process($input['meta_keywords']) : '',
			'meta_robots_no_index'	=> ! empty($input['meta_robots_no_index']),
			'meta_robots_no_follow'    => ! empty($input['meta_robots_no_follow']),
			'meta_description' 	=> isset($input['meta_description']) ? $input['meta_description'] : '',
			'rss_enabled'		=> ! empty($input['rss_enabled']),
			'comments_enabled'	=> ! empty($input['comments_enabled']),
			'status'			=> $input['status'],
			'created_on'		=> now(),
			'restricted_to'		=> isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '0',
			'strict_uri'		=> ! empty($input['strict_uri']),
			'is_home'			=> ! empty($input['is_home']),
			'order'				=> now()
		));

		// did it pass validation?
		if ( ! $id) return false;

		// We define this for the field type.
		ci()->page_id = $id;

		$this->build_lookup($id);

		// Add a Navigation Link
		if (isset($input['navigation_group_id']) and count($input['navigation_group_id']) > 0)
		{
			$this->load->model('navigation/navigation_m');

			if (isset($input['navigation_group_id']) and is_array($input['navigation_group_id']))
			{
				foreach ($input['navigation_group_id'] as $group_id)
				{
					$this->navigation_m->insert_link(array(
						'title'					=> $input['title'],
						'link_type'				=> 'page',
						'page_id'				=> $id,
						'navigation_group_id'	=> $group_id
					));
				}
			}
		}

		// Add the stream data.
		if ($stream)
		{
			$this->load->driver('Streams');

			// Insert the stream using the streams driver.
			if ($entry_id = $this->streams->entries->insert_entry($input, $stream->stream_slug, $stream->stream_namespace))
			{
				// Update with our new entry id
				if ( ! $this->db->limit(1)->where('id', $id)->update($this->_table, array('entry_id' => $entry_id)))
				{
					return false;
				}
			}
			else
			{
				// Something went wrong. Abort!
				return false;
			}
		}

		$this->db->trans_complete();

		return ($this->db->trans_status() === false) ? false : $id;
	}

    // --------------------------------------------------------------------------

	/**
	 * Update a Page
	 *
	 * 
	 * @param int $id The ID of the page to update
	 * @param array $input The data to update
	 * @return void
	*/
	public function edit($id, $input, $stream = null, $entry_id = null)
	{
		$this->db->trans_start();

		if ( ! empty($input['is_home']))
		{
			// Remove other homepages so this one can have the spot
			$this->skip_validation = true;
			$this->update_by('is_home', 1, array('is_home' => 0));
		}
			// replace the old slug with the new
		
		// validate the data and update
		$result = $this->update($id, array(
			'slug'				=> $input['slug'],
			'title'				=> $input['title'],
			'uri'				=> null,
			'parent_id'			=> (int) $input['parent_id'],
			'type_id'			=> (int) $input['type_id'],
			'css'				=> isset($input['css']) ? $input['css'] : null,
			'js'				=> isset($input['js']) ? $input['js'] : null,
			'meta_title'    	=> isset($input['meta_title']) ? $input['meta_title'] : '',
			'meta_keywords' 	=> isset($input['meta_keywords']) ? $this->keywords->process($input['meta_keywords'], (isset($input['old_keywords_hash'])) ? $input['old_keywords_hash'] : null) : '',
			'meta_robots_no_index'    => ! empty($input['meta_robots_no_index']),
			'meta_robots_no_follow'    => ! empty($input['meta_robots_no_follow']),	
			'meta_description' 	=> isset($input['meta_description']) ? $input['meta_description'] : '',
			'rss_enabled'		=> ! empty($input['rss_enabled']),
			'comments_enabled'	=> ! empty($input['comments_enabled']),
			'status'			=> $input['status'],
			'updated_on'		=> now(),
			'restricted_to'		=> isset($input['restricted_to']) ? implode(',', $input['restricted_to']) : '0',
			'strict_uri'		=> ! empty($input['strict_uri']),
			'is_home'			=> ! empty($input['is_home'])
		));

		// did it pass validation?
		if ( ! $result) return false;
		$page_ids = $this->get_descendant_ids($id);
		foreach($page_ids as $page)
		{	
			$this->build_lookup($page);
		}
		// Add the stream data.
		if ($stream and $entry_id)
		{
			$this->load->driver('Streams');

			// Insert the stream using the streams driver. Our only extra field is the page_id
			// which links this particular entry to our page.
			$this->streams->entries->update_entry($entry_id, $input, $stream->stream_slug, $stream->stream_namespace);
		}

		$this->db->trans_complete();

		return (bool) $this->db->trans_status();
	}

    // --------------------------------------------------------------------------

	/**
	 * Delete a Page
	 *
	 * @param int $id The ID of the page to delete
	 *
	 * @return array|bool
	 */
	public function delete($id = 0)
	{
		$this->db->trans_start();

		$ids = $this->get_descendant_ids($id);

		foreach ($ids as $id)
		{
			$page = $this->get($id);

			// Get the stream and delete the entry. Yeah this is a lot of queries
			// but hey we're deleting stuff. Get off my back!
			if ($page->stream_id)
			{
				if ($stream = $this->streams_m->get_stream($page->stream_id))
				{
					$this->streams->entries->delete_entry($page->entry_id, $stream->stream_slug, $stream->stream_namespace);
				}
			}
		}

		// Delete the page.
		$this->db->where_in('id', $ids);
		$this->db->delete('pages');

		// Our navigation links should go as well.
		$this->db->where_in('page_id', $ids);
		$this->db->delete('navigation_links');	

		$this->db->trans_complete();

		return ($this->db->trans_status() !== false) ? $ids : false;
	}

    // --------------------------------------------------------------------------

	/**
	 * Check Slug for Uniqueness
	 *
	 * Slugs should be unique among sibling pages.
	 *
	 * @param string $slug The slug to check for.
	 * @param int $parent_id The parent_id if any.
	 * @param int $id The id of the page.
	 *
	 * @return bool
	*/
	public function _unique_slug($slug, $parent_id, $id = 0)
	{		
		return (bool) parent::count_by(array(
			'id !=' => $id,
			'slug' => $slug,
			'parent_id' => $parent_id
		)) > 0;
	}

    // --------------------------------------------------------------------------

	/**
	 * Callback to check uniqueness of slug + parent
	 *
	 * 
	 * @param $slug slug to check
	 * @return bool
	 */
	 public function _check_slug($slug)
	 {
	 	$page_id = $this->uri->segment(4);

		if ($this->_unique_slug($slug, $this->input->post('parent_id'), (int) $page_id))
		{
			if ($this->input->post('parent_id') == 0)
			{
				$parent_folder = lang('pages:root_folder');
				$url = '/'.$slug;
			}
			else
			{
				$page_obj = $this->get($page_id);
				$url = '/'.trim(dirname($page_obj->uri),'.').$slug;
				$page_obj = $this->get($this->input->post('parent_id'));
				$parent_folder = $page_obj->title;
			}

			$this->form_validation->set_message('_check_slug',sprintf(lang('pages:page_already_exist_error'),$url, $parent_folder));
			return false;
		}

		return true;
	}
}
