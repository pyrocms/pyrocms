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
class Plugin_Pages extends Plugin
{
	/**
	 * Get a page's URL
	 *
	 * @param int $id The ID of the page
	 * @return string
	 */
	function url()
	{
		$id = $this->attribute('id');
		$uri = $this->pages_m->get_path_by_id($id);

		return site_url($uri);
	}
	
	/**
	 * Children list
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
	function children()
	{
		return $this->pages_m->get_many_by('parent_id', $this->attribute('id'));
	}
}

/* End of file contact_forms.php */
/* Location: ./upload/includes/addons/contact_forms/libraries/contact_forms.php */