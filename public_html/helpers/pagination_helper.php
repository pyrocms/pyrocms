<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/*****
  * The Pagination helper gives you lots of handy functions to use with your modules
  * @author		Philip Sturgeon
  * @email		phil@styledna.net
  * @filename	matchbox_helper.php
  * @title		Matchbox Helper
  * @url		http://www.styledna.net
  * @version	1.0
  *****/

	function create_pagination($uri, $total_rows, $uri_segment = 4) {
		
		$CI =& get_instance();
		$CI->load->library('pagination');
		
		// Initialize pagination
        $config['base_url'] = site_url().'/'.$uri.'/';
		$config['total_rows'] = $total_rows; // count all records
		$config['per_page'] = $CI->settings->item('records_per_page');
		$config['uri_segment'] = $uri_segment;
		
		$CI->pagination->initialize($config); // initialize pagination
		
		$current_page = $CI->uri->segment($uri_segment, 0);
		
		return array(
			'current_page' 	=> $current_page,
			'per_page' 		=> $config['per_page'],
			'limit'			=> array($config['per_page'], $current_page),
			'links' 		=> $CI->pagination->create_links()
		);
	}

?>