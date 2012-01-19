<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Keywords Plugin
 *
 * Filter content by keywords
 *
 * @package		PyroCMS
 * @author		Osvaldo Brignoni
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Keywords extends Plugin
{

	public function __construct()
	{
		$this->load->library('keywords');	
	}
	
	/**
	 * Keywords Filter
	 *
	 * Create a filtered list of content by keywords
	 *
	 * Usage:
	 * {{ keywords:filter module="videos" matches="featured" }}
	 *		<a href="videos/{{ filename }}">{{ title }}</a>
	 * {{ /keywords:filter }}
	 *
	 * You can pass a list of matches separated by the pipe character
	 * i.e. {{ keywords:filter matches="art|music|food" }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function filter()
	{
		$module = $this->attribute('module', 'blog');
		$keywords	= explode('|', $this->attribute('matches'));
		$limit		= $this->attribute('limit', 5);
		$order_by 	= $this->attribute('order-by', 'created_on');
		$order_dir	= $this->attribute('order-dir', 'asc');

		// Get hashes for applied keywords
		$applied_hashes = $this->keyword_m->get_hashes_applied($keywords);
		
		if(!empty($applied_hashes))
		{
			// Format array for query
			foreach($applied_hashes as $keyword)
			{
				$hashes[] = $keyword->hash;
			}
		
			$results = $this->db
				->or_where_in('keywords', $hashes)
				->order_by($order_by, $order_dir)
				->limit($limit)
				->get($module)
				->result();
				
			// Keep supporting the blog url for convenience
			if($module == 'blog')
			{
				foreach ($results as &$post)
				{
					$post->url = site_url('blog/'.date('Y', $post->created_on).'/'.date('m', $post->created_on).'/'.$post->slug);
				}
			}
			
			return $results;
		}

	}
	
}

/* End of file plugin.php */