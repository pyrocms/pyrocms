<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Blog Plugin
 *
 * Create lists of posts
 * 
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Blog\Plugins
 */
class Plugin_Blog extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Blog',
	);
	public $description = array(
		'en' => 'A plugin to display information such as blog categories and posts.',
        'fr' => 'Un plugin permettant d\'afficher des informations comme les catégories et articles du blog.'
	);

	/**
	 * Returns a PluginDoc array
	 *
	 * @return array
	 */
	public function _self_doc()
	{

		$info = array(
			'posts' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Display blog posts optionally filtering them by category.',
                    'fr' => 'Permet d\'afficher des articles de blog en les filtrants par catégorie.'
				),
				'single' => false,// single tag or double tag (tag pair)
				'double' => true,
				'variables' => 'category_title|category_slug|author_name|title|slug|url|category_id|intro|body|parsed|created_on|updated_on|count',// the variables available inside the double tags
				'attributes' => array(// an array of all attributes
					'category' => array(// the attribute name. If the attribute name is used give most common values as separate attributes
						'type' => 'slug',// Can be: slug, number, flag, text, any. A flag is a predefined value.
						'flags' => '',// valid flag values that the plugin will recognize. IE: asc|desc|random
						'default' => '',// the value that it defaults to
						'required' => false,// is this attribute required?
						),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					'offset' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '0',
						'required' => false,
						),
					'order-by' => array(
						'type' => 'column',
						'flags' => '',
						'default' => 'created_on',
						'required' => false,
						),
					'order-dir' => array(
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
						),
					),
				),
			'categories' => array(
				'description' => array(
					'en' => 'List blog categories.',
                    'fr' => 'Lister les catégories du blog'
				),
				'single' => false,
				'double' => true,
				'variables' => 'title|slug|url',
				'attributes' => array(
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					'order-by' => array(
						'type' => 'flag',
						'flags' => 'id|title',
						'default' => 'title',
						'required' => false,
						),
					'order-dir' => array(
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
						),
					),
				),
			'count_posts' => array(
				'description' => array(
					'en' => 'Count blog posts that meet the conditions specified.',
                    'fr' => 'Permet de compter les articles de blog qui remplissent certaines conditions spécifiées.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'category_id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					'author_id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					'status' => array(
						'type' => 'flag',
						'flags' => 'live|draft',
						'default' => '',
						'required' => false,
						),
					),
				),
			// method name
			'tags' => array(
				'description' => array(
					'en' => 'Retrieve all tags that have been applied to blog posts.',
                    'fr' => 'Récupère la liste de tout les tags qui ont été utilisés dans les articles.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'title|url',
				'attributes' => array(
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					),
				),
			);

		return $info;
	}

	/**
	 * Blog List
	 *
	 * Creates a list of blog posts. Takes all of the parameters
	 * available to streams, sans stream, where, and namespace.
	 *
	 * Usage:
	 * {{ blog:posts limit="5" }}
	 *		<h2>{{ title }}</h2>
	 * {{ /blog:posts }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function posts()
	{
		$this->load->driver('Streams');

		// Get all of our default entry items:
		$params = $this->streams->entries->entries_params;

		// Override them with some settings
		// that should be these values:
		$overrides = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'where'			=> array("`status` = 'live'"),
			'order_by'		=> 'created_on',
			'sort'			=> 'desc',
			'show_past'		=> 'no',
			'date_by'		=> 'created_on',
			'limit'			=> $this->attribute('limit', null),
			'offset'		=> $this->attribute('offset')
		);
		foreach ($overrides as $k => $v)
		{
			$params[$k] = $v;
		}

		// Convert our two non-matching posts params to their
		// stream counterparts. This is for backwards compatability.

		// Order by
		if ($this->attribute('order-by')) {
			$params['order_by'] = $this->attribute('order-by');
		}
		elseif ($this->attribute('order_by')) {
			$params['order_by'] = $this->attribute('order_by');
		}

		// Sort
		if ($this->attribute('order-dir')) {
			$params['sort'] = $this->attribute('order-dir');
		}
		elseif ($this->attribute('order_by')) {
			$params['sort'] = $this->attribute('sort');
		}

		// See if we have any attributes to contribute.
		foreach ($params as $key => $default_value)
		{
			if ( ! in_array($key, array('where', 'stream', 'namespace')))
			{
				$params[$key] = $this->attribute($key, $default_value);
			}
		}

		// Categories
		// We need to filter by certain categories
		if ($category_string = $this->attribute('category'))
		{
			$categories = explode('|', $category_string);
			$cate_filter_by = array();

			foreach($categories as $category)
			{
				$cate_filter_by[] = '`'.$this->db->dbprefix('blog_categories').'`.`'.(is_numeric($category) ? 'id' : 'slug').'` = \''.$category."'";
			}

			if ($cate_filter_by)
			{
				$params['where'][] = implode(' OR ', $cate_filter_by);
			}
		}

		// Extra join and selects for categories.
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.title', true)." as 'category_title'";
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.slug', true)." as 'category_slug'";
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.title', true)." as 'category||title'";
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.slug', true)." as 'category||slug'";
		$this->row_m->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('blog_categories', true).' ON '.$this->db->protect_identifiers('blog_categories.id', true).' = '.$this->db->protect_identifiers('blog.category_id', true);

		// Get our posts.
		$posts = $this->streams->entries->get_entries($params);

		if ($posts['entries'])
		{		
			// Process posts.
			// Each post needs some special treatment.
			foreach ($posts['entries'] as &$post)
			{
				$this->load->helper('text');

				// Keywords array
				$keywords = Keywords::get($post['keywords']);
				$formatted_keywords = array();
				$keywords_arr = array();

				foreach ($keywords as $key)
				{
					$formatted_keywords[] 	= array('keyword' => $key->name);
					$keywords_arr[] 		= $key->name;

				}
				$post['keywords'] = $formatted_keywords;
				$post['keywords_arr'] = $keywords_arr;

				// Full URL for convenience.
				$post['url'] = site_url('blog/'.date('Y/m', $post['created_on']).'/'.$post['slug']);
			
				// What is the preview? If there is a field called intro,
				// we will use that, otherwise we will cut down the blog post itself.
				$post['preview'] = (isset($post['intro'])) ? $post['intro'] : $post['body'];
			}
		}
		
		// {{ entries }} Bypass.
		// However, users can use {{ entries }} if using pagination.
		$loop = false;

		if (preg_match('/\{\{\s?entries\s?\}\}/', $this->content()) == 0)
		{
			$posts = $posts['entries'];
			$loop = true;
		}

		// Return our content.	
		return $this->streams->parse->parse_tag_content($this->content(), $posts, 'blog', 'blogs', $loop);
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
	 * @param array
	 * @return array
	 */
	public function categories()
	{
		$limit     = $this->attribute('limit', null);
		$order_by  = $this->attribute('order-by', 'title');
		$order_dir = $this->attribute('order-dir', 'ASC');

		$categories = $this->db
			->select('title, slug')
			->order_by($order_by, $order_dir)
			->limit($limit)
			->get('blog_categories')
			->result();

		foreach ($categories as &$category)
		{
			$category->url = site_url('blog/category/'.$category->slug);
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
	 * 
	 * @return int
	 */
	public function count_posts()
	{
		$wheres = $this->attributes();

		// make sure they provided a where clause
		if (count($wheres) == 0) return false;

		foreach ($wheres as $column => $value)
		{
			$this->db->where($column, $value);
		}

		return $this->db->count_all_results('blog');
	}
	
	/**
	 * Tag/Keyword List
	 *
	 * Create a list of blog keywords/tags
	 *
	 * Usage:
	 * {{ blog:tags limit="10" }}
	 *		<span><a href="{{ url }}" title="{{ title }}">{{ title }}</a></span>
	 * {{ /blog:tags }}
	 *
	 * @param array
	 * @return array
	 */	
	public function tags()
	{
		$limit = $this->attribute('limit', null);
		
		$this->load->library(array('keywords/keywords'));

		$posts = $this->db->select('keywords')->get('blog')->result();

		$buffer = array(); // stores already added keywords
		$tags   = array();

		foreach($posts as $p)
		{
			$kw = Keywords::get_array($p->keywords);

			foreach($kw as $k)
			{
				$k = trim(strtolower($k));

				if(!in_array($k, $buffer)) // let's force a unique list
				{
					$buffer[] = $k;

					$tags[] = array(
						'title' => ucfirst($k),
						'url'   => site_url('blog/tagged/'.$k)
					);
				}
			}
		}
		
		if(count($tags) > $limit) // Enforce the limit
		{
			return array_slice($tags, 0, $limit);
		}
	
		return $tags;
	}
		
}