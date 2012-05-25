<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Pagination Helpers
 *  
 * @author Philip Sturgeon
 * @package PyroCMS\Core\Helpers
 */
if (!function_exists('create_pagination'))
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
	function create_pagination($uri, $total_rows, $limit = NULL, $uri_segment = 4, $full_tag_wrap = TRUE)
	{
		$ci = & get_instance();
		$ci->load->library('pagination');

		$current_page = $ci->uri->segment($uri_segment, 0);

		// Initialize pagination
		$config['suffix'] = $ci->config->item('url_suffix');
		$config['base_url'] = $config['suffix'] !== FALSE ? rtrim(site_url($uri), $config['suffix']) : site_url($uri);
		// Count all records
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit === NULL ? Settings::get('records_per_page') : $limit;
		$config['uri_segment'] = $uri_segment;
		$config['page_query_string'] = FALSE;

		$config['num_links'] = 8;

		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div>';

		$config['first_link'] = '&lt;&lt;';
		$config['first_tag_open'] = '<li class="first">';
		$config['first_tag_close'] = '</li>';

		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '</span></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';

		$config['last_link'] = '&gt;&gt;';
		$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';

		// Initialize pagination
		$ci->pagination->initialize($config);

		return array(
			'current_page' => $current_page,
			'per_page' => $config['per_page'],
			'limit' => array($config['per_page'], $current_page),
			'links' => $ci->pagination->create_links($full_tag_wrap)
		);
	}

}