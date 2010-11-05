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
		$defaults = array(
			'limit' => 10,
			'category' => '',
		);

		$params = parent::attributes();

		if ( ! empty($params['category']))
		{
			if (is_numeric($params['category']))
			{
				$this->db->where('c.id', $params['category']);
			}
			
			else
			{
				$this->db->where('c.slug', $params['category']);
			}
		}
		if(empty($params['limit']))
		{
			$params['limit'] = 10;
		}

		$this->db->from('news')
				->where('status', 'live')
				->where('created_on <=', now())
				->limit($params['limit']);
	
		$query = $this->db->get();

		if ($query->num_rows() == 0) // no records so we can't continue
		{
			return FALSE;
		}

		$results = $query->result_array();

    	return $results;
	}
}

/* End of file plugin.php */