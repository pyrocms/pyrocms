<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function theme_view($view)
{
	$CI =& get_instance();
	
	// This is like the main data var but with added in layout stuff
	$data =& $CI->template->data;
	
	echo $CI->parser->parse('../themes/'.$CI->settings->item('default_theme').'/views/'.$view, $data, TRUE);
}

?>