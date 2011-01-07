<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages Plugin
 *
 * Create links and whatnot.
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
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
	 * Creates a list of child pages
	 *
	 * Usage:
	 * {pyro:pages:children id="1" limit="5"}
	 *	<h2>{title}</h2>
	 *	    {body}
	 * {/pyro:pages:children}
	 *
	 * @param	array
	 * @return	array
	 */
	
	function children()
	{
		$limit = $this->attribute('limit');
		
		return $this->db->select('pages.*, revisions.*')
						->where('pages.parent_id', $this->attribute('id'))
						->where('status', 'live')
						->join('revisions', 'pages.revision_id = revisions.id', 'LEFT')
						->limit($limit)
						->get('pages')
						->result_array();
	}
}

/* End of file plugin.php */