<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Pagination Helpers
 *  
 * @author Philip Sturgeon
 * @package PyroCMS\Core\Helpers
 */
if ( ! function_exists('create_pagination'))
{

	/**
	 * The Pagination helper cuts out some of the bumf of normal pagination
	 *
	 * @param string $uri The current URI.
	 * @param int $total_rows The total of the items to paginate.
	 * @param int|null $limit How many to show at a time.
	 * @param int $uri_segment The current page.
	 * @param boolean $full_tag_wrap Option for the Pagination::create_links()
	 * @return array The pagination array. 
	 * @see Pagination::create_links()
	 */
	function create_pagination($uri, $total_rows, $limit = null, $uri_segment = 4, $full_tag_wrap = true)
	{
		$ci = & get_instance();
		$ci->load->library('pagination');

		$current_page = $ci->uri->segment($uri_segment, 0);
		$suffix = $ci->config->item('url_suffix');

		// Initialize pagination
		$ci->pagination->initialize(array(
			'suffix' 				=> $suffix,
			'base_url' 				=> ( ! $suffix) ? rtrim(site_url($uri), $suffix) : site_url($uri),
			'total_rows' 			=> $total_rows,
			'per_page' 				=> $limit === null ? Settings::get('records_per_page') : $limit,
			'uri_segment' 			=> $uri_segment,
			'use_page_numbers'		=> true,
			'reuse_query_string' 	=> true,
		));

		return array(
			'current_page' => $current_page,
			'per_page' => $limit,
			'limit' => array($limit, $limit * ($current_page - 1)),
			'links' => $ci->pagination->create_links($full_tag_wrap)
		);
	}
}