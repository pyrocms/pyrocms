<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/*****
  * The Pagination helper cuts out some of the bumf of normal pagination
  * @author		Philip Sturgeon
  * @email		email@philsturgeon.co.uk
  * @filename	pagination_helper.php
  * @title		Pagination Helper
  * @version	1.0
  *****/

	function create_pagination($uri, $total_rows, $limit = NULL, $uri_segment = 4) {
		
		$CI =& get_instance();
		$CI->load->library('pagination');
		
		$current_page = $CI->uri->segment($uri_segment, 0);
		
		// Initialize pagination
        $config['base_url'] = site_url().$uri.'/';
		$config['total_rows'] = $total_rows; // count all records
		$config['per_page'] = $limit === NULL ? $CI->settings->item('records_per_page') : $limit;
		$config['uri_segment'] = $uri_segment;
		$config['page_query_string'] = FALSE;

		$CI->pagination->initialize($config); // initialize pagination
		
		return array(
			'current_page' 	=> $current_page,
			'per_page' 		=> $config['per_page'],
			'limit'			=> array($config['per_page'], $current_page),
			'links' 		=> $CI->pagination->create_links()
		);
	}

?>