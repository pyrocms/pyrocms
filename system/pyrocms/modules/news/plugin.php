<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * News Plugin
 *
 * Create lists of articles
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_News extends Plugin
{
	/**
	 * News List
	 *
	 * Creates a list of news posts
	 *
	 * Usage:
	 * {pyro:news:posts limit="5"}
	 *	<h2>{pyro:title}</h2>
	 *	{pyro:body}
	 * {/pyro:news:posts}
	 *
	 * @param	array
	 * @return	array
	 */
	function posts($data = array())
	{
		$limit = $this->attribute('limit', 10);
		$category = $this->attribute('category');

		if ($category)
		{
			if (is_numeric($category))
			{
				$this->db->where('c.id', $category);
			}
			
			else
			{
				$this->db->where('c.slug', $category);
			}
		}
		
		return $this->db
			->where('status', 'live')
			->where('created_on <=', now())
			->limit($limit)
			->get('news')
			->result_array();
	}
}

/* End of file plugin.php */