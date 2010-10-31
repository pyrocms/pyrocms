<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * News Parser Library
 *
 * @subpackage	Libraries
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

		$params = parent::attributes($data['attributes'], $defaults);

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

    	$this->_ci->db->from('news')
			->where('status', 'live')
			->where('created_on <=', now())
    		->limit($params['limit']);

		$query = $this->_ci->db->get();

		if ($query->num_rows() == 0) // no records so we can't continue
		{
			return FALSE;
		}

		$results = $query->result_array();

    	return $results;
	}
}

/* End of file news.plugin.php */