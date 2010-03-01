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
	
	$config['num_links'] = 4;
	
	// Admin page
	if(strpos($uri, 'admin/') !== FALSE)
	{
		$config['first_link'] = '&lt;&lt;';
		$config['first_tag_open'] = '<span class="prev">';
		$config['first_tag_close'] = '</span>';
		
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<span class="prev">';
		$config['prev_tag_close'] = '</span>';

		$config['cur_tag_open'] = '<span class="current roundedBordersLite">';
		$config['cur_tag_close'] = '</span>';
		
		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';
		
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<span class="next">';
		$config['next_tag_close'] = '</span>';
		
		$config['last_link'] = '&gt;&gt;';
		$config['last_tag_open'] = '<span class="next">';
		$config['last_tag_close'] = '</span>';
	}
	
	$CI->pagination->initialize($config); // initialize pagination
	
	return array(
		'current_page' 	=> $current_page,
		'per_page' 		=> $config['per_page'],
		'limit'			=> array($config['per_page'], $current_page),
		'links' 		=> $CI->pagination->create_links()
	);
}

?>