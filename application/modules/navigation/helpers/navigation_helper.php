<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function navigation($abbrev)
{
	$CI =& get_instance();
	
	$CI->load->model('navigation/navigation_m');

	return $CI->cache->model('navigation_m', 'load_group', $abbrev, $CI->settings->item('navigation_cache'));
}

?>