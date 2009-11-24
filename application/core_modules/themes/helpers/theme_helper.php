<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function theme_view($view)
{
	$CI =& get_instance();
	
	$data =& $CI->load->_ci_cached_vars;
	
	echo $CI->parser->parse('../themes/'.$CI->settings->item('default_theme').'/views/'.$view, $data, TRUE);
}

?>