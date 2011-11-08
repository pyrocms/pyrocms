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
	 * {{ blog:posts order-by="title" limit="5" }}
	 *		<h2>{{ title }}</h2>
	 *		<p> {{ body }} </p>
	 * {{ /blog:posts }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function posts()
	{
		$limit		= $this->attribute('limit', 10);
		$category	= $this->attribute('category');
		$order_by 	= $this->attribute('order-by', 'created_on');
													//deprecated
		$order_dir	= $this->attribute('order-dir', $this->attribute('order', 'ASC'));

		if ($category)
		{
			$this->db->where('blog_categories.' . (is_numeric($category) ? 'id' : 'slug'), $category);
		}

		$posts = $this->db
			->select('blog.*')
			->select('blog_categories.title as category_title, blog_categories.slug as category_slug')
			->select('p.display_name as author_name')
			->where('status', 'live')
			->where('created_on <=', now())
			->join('blog_categories', 'blog.category_id = blog_categories.id', 'left')
			->join('profiles p', 'blog.author_id = p.user_id', 'left')
			->order_by('blog.' . $order_by, $order_dir)
			->limit($limit)
			->get('blog')
			->result();

		foreach ($posts as &$post)
		{
			$post->url = site_url('blog/'.date('Y', $post->created_on).'/'.date('m', $post->created_on).'/'.$post->slug);
		}
		
		return $posts;
	}
}

/* End of file plugin.php */