<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages Plugin
 *
 * Create links and whatnot.
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Pages extends Plugin
{
	/**
	 * Get a page's URL
	 *
	 * @param int $id The ID of the page
	 * @return string
	 */
	function url()
	{
		$id		= $this->attribute('id');
		$page	= $this->pyrocache->model('pages_m', 'get', array($id));

		return site_url($page ? $page->uri : '');
	}
	
	/**
	 * Get a page by ID or slug
	 *
	 * @param int 		$id The ID of the page
	 * @param string 	$slug The uri of the page
	 * @return array
	 */
	function display()
	{
		$page = $this->db->select('pages.*, page_chunks.*')
					->where('pages.id', $this->attribute('id'))
					->or_where('pages.slug', $this->attribute('slug'))
					->where('status', 'live')
					->join('page_chunks', 'pages.id = page_chunks.page_id', 'LEFT')
					->get('pages')
					->row_array();
					
		return $this->content() ? $page : $page['body'];
	}
	
	/**
	 * Children list
	 *
	 * Creates a list of child pages
	 *
	 * Usage:
	 * {pyro:pages:children id="1" limit="5"}
	 *	<h2>{title}</h2>
	 *	    {body}
	 * {/pyro:pages:children}
	 *
	 * @param	array
	 * @return	array
	 */
	
	function children()
	{
		$limit = $this->attribute('limit');
		
		return $this->db->select('pages.*, page_chunks.body')
			->where('pages.parent_id', $this->attribute('id'))
			->where('status', 'live')
			->join('page_chunks', 'pages.id = page_chunks.page_id', 'LEFT')
			->limit($limit)
			->get('pages')
			->result_array();
	}

	// --------------------------------------------------------------------------

	/**
	 * Page tree function
	 *
	 * Creates a nested ul of child pages
	 *
	 * Usage:
	 * {pyro:pages:page_tree start-id="5"}
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
		$start_id 		= $this->attribute('start-id', $this->attribute('start_id'));
		$disable_levels = $this->attribute('disable-levels');
		$order_by 		= $this->attribute('order-by', 'title');
		$order_dir		= $this->attribute('order-dir', 'ASC');
		$list_tag		= $this->attribute('list-tab', 'ul');
		$link			= $this->attribute('link', TRUE);
		
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
	 * {pyro:pages:is child="7" parent="cookbook"} // return 1 (TRUE)
	 * {pyro:pages:is child="recipes" descendent="books"} // return 1 (TRUE)
	 * {pyro:pages:is children="7,8,literature" parent="6"} // return 0 (FALSE)
	 * {pyro:pages:is children="recipes,ingredients,9" descendent="4"} // return 1 (TRUE)
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
				return (int) FALSE;
			}
		}

		return (int) TRUE;
	}

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
				$child_id = ($child = $this->pages_m->get_by(array('slug' => $child_id))) ? $child->id: 0;
			}

			if ( ! is_numeric($descendent_id))
			{
				$descendent_id = ($descendent = $this->pages_m->get_by(array('slug' => $descendent_id))) ? $descendent->id: 0;
			}

			if ( ! ($child_id && $descendent_id))
			{
				return FALSE;
			}

			$descendent_ids	= $this->pages_m->get_descendant_ids($descendent_id);

			return in_array($child_id, $descendent_ids);
		}

		if ($child_id && $parent_id)
		{
			if ( ! is_numeric($child_id))
			{
				$parent_id = ($parent = $this->pages_m->get_by(array('slug' => $parent_id))) ? $parent->id: 0;
			}

			return $parent_id ? (int) $this->pages_m->count_by(array(
				(is_numeric($child) ? 'id' : 'slug') => $child,
				'parent_id'	=> $parent_id
			)) > 0: FALSE;
		}
	}
	
	/**
	 * Tree html function
	 *
	 * Creates a page tree
	 *
	 * @param	array
	 * @return	array
	 */
	function _build_tree_html($params)
	{
		$params = array_merge(array(
			'tree'			=> array(),
			'parent_id'		=> 0
		), $params);

		extract($params);

		if ( ! $tree)
		{
			$this->db->select('id, parent_id, slug, uri, title')
					->order_by($order_by, $order_dir)
					->where_not_in('slug', $this->disable);
			
			// check if they're logged in
			if ( isset($this->user->group) )
			{
				// admins can see them all
				if ($this->user->group != 'admin')
				{
					// show pages for their group and all unrestricted
					$this->db->where('status', 'live')
						->where_in('restricted_to', array($this->user->group_id, 0, NULL));					
				}
			}
			else
			{
				//they aren't logged in, show them all unrestricted pages
				$this->db->where('status', 'live')
					->where('restricted_to <=', 0);
			}
			
			$pages = $this->db->get('pages')
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
			$html .= ($link === TRUE) ? '<a href="' . site_url($item->uri) . '">' . $item->title . '</a>' : $item->title;
			
			
			
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

/* End of file plugin.php */