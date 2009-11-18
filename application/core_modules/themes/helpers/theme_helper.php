<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function theme_view($view, $data = array())
{
	$CI =& get_instance();
	$CI->load->view('../themes/'.$CI->settings->item('default_theme').'/views/'.$view, $data);
}

?>