<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
class Plugin_news
{
	private $_ci;

	// ------------------------------------------------------------------------

	function __construct($data = array())
	{
		$this->_ci =& get_instance();
	}

	// ------------------------------------------------------------------------

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

		$params = $this->get_params($data['attributes'], $defaults);

		if ( ! empty($params['category']))
		{
			if (is_numeric($params['category']))
			{
				$this->_ci->db->where('c.id', $params['category']);
			}
			else
			{
				$this->_ci->db->where('c.slug', $params['category']);
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

	// ------------------------------------------------------------------------

	/**
	 * Get params
	 *
	 * This is a helper used from the parser files to process a list of params
	 *
	 * @param	array - Params passed from view
	 * @param	array - Array of default params
	 * @return 	array
	 */
	public function get_params($params = array(), $defaults = array())
	{
		// parse the params
		$options = $params;

		// now loop through and change the defaults
		foreach ($defaults as $key => $val)
		{
			if ( ! is_array($options))
			{
				if ( ! isset($$key) OR $$key == '')
				{
					$options[$key] = $val;
				}
			}
			else
			{
				$options[$key] = ( ! isset($options[$key])) ? $val : $options[$key];
				$key = ( ! isset($options[$key])) ? $val : $options[$key];
			}
		}

		return $options;
	}
}

/* End of file contact_forms.php */
/* Location: ./upload/includes/addons/contact_forms/libraries/contact_forms.php */