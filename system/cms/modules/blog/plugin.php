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
	 
	public function __construct()
	{
		 
		 $settings = $this->db->get_where('default_settings', array('module' => 'blog'))->result();

		$this->settings=array();
		
		foreach ($settings as $setting) {
			
			$this->settings[$setting->slug]=$setting->value;
			
		}	
		 
	 }
	public function posts()
	{
		$limit		= $this->attribute('limit', 10);
		$category	= $this->attribute('category');
		$order_by 	= $this->attribute('order-by', 'created_on');
		$order_dir	= $this->attribute('order-dir', 'ASC');
		$related_to	= $this->attribute('related_to');
		$keywords	= $this->attribute('keywords');

		if ($category)
		{
			$this->db->where('blog_categories.' . (is_numeric($category) ? 'id' : 'slug'), $category);
		}
		
		if ($related_to)
		{
			
			$this->db->where('blog.id !=', $related_to);
			
			if ($keywords) {
				
				if (is_array($keywords)) {
					
						
					foreach ($keywords as $keyword){ 
						
						$this->db->where(' default_keywords.name', $keyword->name);
					
					}
				}

			}
			
			$this->db->join('default_keywords_applied', 'blog.keywords = default_keywords_applied.hash');
			$this->db->join('default_keywords', 'default_keywords_applied.keyword_id = default_keywords.id');
			$this->db->group_by('blog.id');
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
			$post->url = site_url($this->settings['blog_uri'].'/'.$post->category_slug.'/'.$post->slug);
		}
		
		return $posts;
	}

	/**
	 * Categories
	 *
	 * Creates a list of blog categories
	 *
	 * Usage:
	 * {{ blog:categories order-by="title" limit="5" }}
	 *		<a href="{{ url }}" class="{{ slug }}">{{ title }}</a>
	 * {{ /blog:categories }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function categories()
	{
		$limit		= $this->attribute('limit', 10);
		$order_by 	= $this->attribute('order-by', 'title');
		$order_dir	= $this->attribute('order-dir', 'ASC');

		$categories = $this->db
			->select('title, slug')
			->order_by($order_by, $order_dir)
			->limit($limit)
			->get('blog_categories')
			->result();

		foreach ($categories as &$category)
		{
			$category->url = site_url($this->settings['blog_uri'].'/'.$category->slug);
		}
		
		return $categories;
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