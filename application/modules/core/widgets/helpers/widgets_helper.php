<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function widget($id, $options = array())
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');

	return $ci->widgets->render($id, $options);
}

function widget_area($slug)
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');

	return $ci->widgets->render_area($slug);
}

?>