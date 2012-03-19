<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Blog Plugin
 *
 * Create lists of posts
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Blog\Plugins
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

	/**
	 * Count Posts By Column
	 *
	 * Usage:
	 * {{ blog:count_posts author_id="1" }}
	 *
	 * The attribute name is the database column and 
	 * the attribute value is the where value
	 */
	public function count_posts()
	{
		$wheres = $this->attributes();

		// make sure they provided a where clause
		if (count($wheres) == 0) return FALSE;

		foreach ($wheres AS $column => $value)
		{
			$this->db->where($column, $value);
		}

		return $this->db->count_all_results('blog');
	}
}

/* End of file plugin.php */