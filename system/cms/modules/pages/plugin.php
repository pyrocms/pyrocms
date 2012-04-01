<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages Plugin
 *
 * Create links and whatnot.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Pages\Plugins
 */
class Plugin_Pages extends Plugin
{

	/**
	 * Get the URL of a page
	 *
	 * Attributes:
	 *  - (int) id : The id of the page to get the URL for.
	 *
	 * @return string
	 */
	public function url()
	{
		$id		= $this->attribute('id');
		$page	= $this->pyrocache->model('page_m', 'get', array($id));

		return site_url($page ? $page['uri'] : '');
	}

	/**
	 * Get a page by ID or slug
	 *
	 * Attributes:
	 * - (int) id: The id of the page.
	 * - (string) slug: The slug of the page.
	 *
	 * @return array
	 */
	public function display()
	{
		$page = $this->db
			->where('pages.id', $this->attribute('id'))
			->or_where('pages.slug', $this->attribute('slug'))
			->where('status', 'live')
			->get('pages')
			->row_array();

		// Grab all the chunks that make up the body
		$page['chunks'] = $this->db->get_where('page_chunks', array('page_id' => $page['id']))->result();
		
		$page['body'] = '';
		foreach ($page['chunks'] as $chunk)
		{
			$page['body'] .= 	'<div class="page-chunk ' . $chunk['slug'] . '">' .
									(($chunk['type'] == 'markdown') ? $chunk['parsed'] : $chunk['body']) .
								'</div>'.PHP_EOL;
		}

		// we'll unset the chunks array as Lex is grouchy about mixed data at the moment
		unset($page['chunks']);

		return $this->content() ? array($page) : $page['body'];
	}

	/**
	 * Get a page chunk by page ID and chunk name
	 *
	 * Attributes:
	 * - (int) id : The id of the page.
	 * - (string) slug : The name of the chunk.
	 *
	 * @return string|bool
	 */
	function chunk()
	{
		$chunk = $this->db
			->select('*')
			->where('page_id', $this->attribute('id'))
			->where('slug', $this->attribute('name'))
			->get('page_chunks')
			->row_array();

		return ($chunk ? ($this->content() ? $chunk : $chunk['body']) : false);
	}

	/**
	 * Children list
	 *
	 * Creates a list of child pages
	 *
	 * Attributes:
	 * - (int) limit: How many pages to show.
	 * - (string) order-by: One of the column names from the `pages` table.
	 * - (string) order-dir: Either `asc` or `desc`
	 *
	 * Usage:
	 * {{ pages:children id="1" limit="5" }}
	 *	<h2>{title}</h2>
	 *	    {body}
	 * {{ /pages:children }}
	 *
	 * @return array
	 */
	public function children()
	{

		$limit = $this->attribute('limit', 10);
		$order_by = $this->attribute('order-by', 'title');
		$order_dir = $this->attribute('order-dir', 'ASC');

		$pages = $this->db->select('pages.*')
			->where('pages.parent_id', $this->attribute('id'))
			->where('status', 'live')
			->order_by($order_by, $order_dir)
			->limit($limit)
			->get('pages')
			->result_array();

		if ($pages)
		{
			foreach ($pages AS &$page)
			{
				// Grab all the chunks that make up the body for this page
				$page['chunks'] = $this->db
					->get_where('page_chunks', array('page_id' => $page['id']))
					->result();

				$page['body'] = '';
				foreach ($page['chunks'] as $chunk)
				{
					$page['body'] .= '<div class="page-chunk '.$chunk['slug'].'">'.
						(($chunk['type'] == 'markdown') ? $chunk['parsed'] : $chunk['body']).
						'</div>'.PHP_EOL;
				}
			}
		}

		return $pages;
	}

	// --------------------------------------------------------------------------

	/**
	 * Page tree function
	 *
	 * Creates a nested ul of child pages
	 *
	 * Usage:
	 * {{ pages:page_tree start-id="5" }}
	 * optional attributes:
	 *
	 * disable-levels="slug"
	 * order-by="title"
	 * order-dir="desc"
	 * list-tag="ul"
	 * link="true"
	 *
	 * @param	array
	 * @return	array
	 */
	public function page_tree()
	{
		$start 			= $this->attribute('start');
		$start_id 		= $this->attribute('start-id', $this->attribute('start_id'));
		$disable_levels = $this->attribute('disable-levels');
		$order_by 		= $this->attribute('order-by', 'title');
		$order_dir		= $this->attribute('order-dir', 'ASC');
		$list_tag		= $this->attribute('list-tab', 'ul');
		$link			= $this->attribute('link', true);
		
		// If we have a start URI, let's try and
		// find that ID.
		if ($start)
		{
			$page = $this->page_m->get_by_uri($start);
		
			if ( ! $page) return null;
			
			$start_id = $page->id;
		}
		
		// If our start doesn't exist, then
		// what are we going to do? Nothing.
		if(!$start_id) return null;
		
		// Disable individual pages or parent pages by submitting their slug
		$this->disable = explode("|", $disable_levels);
		
		return '<'.$list_tag.'>' . $this->_build_tree_html(array(
			'parent_id' => $start_id,
			'order_by' => $order_by,
			'order_dir' => $order_dir,
			'list_tag' => $list_tag,
			'link' => $link
		)) . '</'.$list_tag.'>';
	}

	// --------------------------------------------------------------------------

	/**
	 * Page is function
	 *
	 * Check the pages parent or descendent relation
	 *
	 * Usage:
	 * {{ pages:is child="7" parent="cookbook" }} // return 1 (true)
	 * {{ pages:is child="recipes" descendent="books" }} // return 1 (true)
	 * {{ pages:is children="7,8,literature" parent="6" }} // return 0 (false)
	 * {{ pages:is children="recipes,ingredients,9" descendent="4" }} // return 1 (true)
	 *
	 * Use Id or Slug as param, following usage data reference
	 * Id: 4 = Slug: books
	 * Id: 6 = Slug: cookbook
	 * Id: 7 = Slug: recipes
	 * Id: 8 = Slug: ingredients
	 * Id: 9 = Slug: literature
	 *
	 * @param	array	Plugin attributes
	 * @return	int		0 or 1
	 */
	public function is()
	{
		$children_ids	= $this->attribute('children');
		$child_id		= $this->attribute('child');

		if ( ! $children_ids)
		{
			return (int) $this->_check_page_is($child_id);
		}

		$children_ids = explode(',', $children_ids);
		$children_ids = array_map('trim', $children_ids);

		if ($child_id)
		{
			$children_ids[] = $child_id;
		}

		foreach ($children_ids as $child_id)
		{
			if ( ! $this->_check_page_is($child_id))
			{
				return (int) false;
			}
		}

		return (int) true;
	}

	// --------------------------------------------------------------------------
	
	/**
	* Page has function
	*
	* Check if this page has children
	*
	* Usage:
	* {{ pages:has id="4" }}
	*
	* @param 	int id 	The id of the page you want to check
	* @return 	bool
	*/
	public function has()
	{
		return $this->page_m->has_children($this->attribute('id'));
	}

	// --------------------------------------------------------------------------

	/**
	 * Check Page is function
	 *
	 * Works for page is function
	 *
	 * @param	mixed	The Id or Slug of the page
	 * @param	array	Plugin attributes
	 * @return	int		0 or 1
	 */
	private function _check_page_is($child_id = 0)
	{
		$descendent_id	= $this->attribute('descendent');
		$parent_id		= $this->attribute('parent');

		if ($child_id && $descendent_id)
		{
			if ( ! is_numeric($child_id))
			{
				$child_id = ($child = $this->page_m->get_by(array('slug' => $child_id))) ? $child->id: 0;
			}

			if ( ! is_numeric($descendent_id))
			{
				$descendent_id = ($descendent = $this->page_m->get_by(array('slug' => $descendent_id))) ? $descendent->id: 0;
			}

			if ( ! ($child_id && $descendent_id))
			{
				return false;
			}

			$descendent_ids	= $this->page_m->get_descendant_ids($descendent_id);

			return in_array($child_id, $descendent_ids);
		}

		if ($child_id && $parent_id)
		{
			if ( ! is_numeric($child_id))
			{
				$parent_id = ($parent = $this->page_m->get_by(array('slug' => $parent_id))) ? $parent->id : 0;
			}

			return $parent_id ? (int) $this->page_m->count_by(array(
				(is_numeric($child_id) ? 'id' : 'slug') => $child_id,
				'parent_id'	=> $parent_id
			)) > 0 : false;
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Tree html function
	 *
	 * Creates a page tree
	 *
	 * @param	array
	 * @return	array
	 */
	private function _build_tree_html($params)
	{
		$params = array_merge(array(
			'tree'			=> array(),
			'parent_id'		=> 0
		), $params);

		extract($params);

		if ( ! $tree)
		{
			$this->db
				->select('id, parent_id, slug, uri, title')
				->where_not_in('slug', $this->disable);
			
			// check if they're logged in
			if ( isset($this->current_user->group) )
			{
				// admins can see them all
				if ($this->current_user->group != 'admin')
				{
					$id_list = array();
					
					$page_list = $this->db
						->select('id, restricted_to')
						->get('pages')
						->result();

					foreach ($page_list AS $list_item)
					{
						// make an array of allowed user groups
						$group_array = explode(',', $list_item->restricted_to);

						// if restricted_to is 0 or empty (unrestricted) or if the current user's group is allowed
						if (($group_array[0] < 1) OR in_array($this->current_user->group_id, $group_array))
						{
							$id_list[] = $list_item->id;
						}
					}
					
					// if it's an empty array then evidentally all pages are unrestricted
					if (count($id_list) > 0)
					{
						// select only the pages they have permissions for
						$this->db->where_in('id', $id_list);
					}
					
					// since they aren't an admin they can't see drafts
					$this->db->where('status', 'live');
				}
			}
			else
			{
				//they aren't logged in, show them all live, unrestricted pages
				$this->db
					->where('status', 'live')
					->where('restricted_to <', 1)
					->or_where('restricted_to', null);
			}
			
			$pages = $this->db
				->order_by($order_by, $order_dir)
				->get('pages')
				->result();

			if ($pages)
			{
				foreach($pages as $page)
				{
					$tree[$page->parent_id][] = $page;
				}
			}
		}

		if ( ! isset($tree[$parent_id]))
		{
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item)
		{
			$html .= '<li';
			$html .= (current_url() == site_url($item->uri)) ? ' class="current">' : '>';
			$html .= ($link === true) ? '<a href="' . site_url($item->uri) . '">' . $item->title . '</a>' : $item->title;
			
			
			
			$nested_list = $this->_build_tree_html(array(
				'tree'			=> $tree,
				'parent_id'		=> (int) $item->id,
				'link'			=> $link,
				'list_tag'		=> $list_tag
			));
			
			if ($nested_list)
			{
				$html .= '<'.$list_tag.'>' . $nested_list . '</'.$list_tag.'>';
			}
			
			$html .= '</li>';
		}

		return $html;
	}
}