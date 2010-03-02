<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function widget($id)
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');

	return $ci->widgets->render($id);
}

function widget_area($slug)
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');

	return $ci->widgets->render_area($slug);
}

?>