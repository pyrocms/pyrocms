<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Blog Plugin
 *
 * Create lists of posts
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Blog extends Plugin
{
	/**
	 * Blog List
	 *
	 * Creates a list of blog posts
	 *
	 * Usage:
	 * {pyro:blog:posts limit="5"}
	 *	<h2>{pyro:title}</h2>
	 *	{pyro:body}
	 * {/pyro:blog:posts}
	 *
	 * @param	array
	 * @return	array
	 */
	function posts($data = array())
	{
		$limit		= $this->attribute('limit', 10);
		$category	= $this->attribute('category');
		$order		= $this->attribute('order');

		if ($category)
		{
			$this->db->where('c.' . (is_numeric($category) ? 'id' : 'slug'), $category);
		}

		return $this->db
			->select('blog.*, c.title as category_title, c.slug as category_slug')
			->where('status', 'live')
			->where('created_on <=', now())
			->join('blog_categories c', 'blog.category_id = c.id', 'LEFT')
			->order_by('blog.created_on', $order)
			->limit($limit)
			->get('blog')
			->result_array();
	}
}

/* End of file plugin.php */