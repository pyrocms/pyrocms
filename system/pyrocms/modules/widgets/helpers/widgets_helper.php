<?php defined('BASEPATH') OR exit('No direct script access allowed');

function widget($slug, $options = array())
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');

	return $ci->widgets->render($slug, $options);
}

function widget_area($slug)
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');

	return $ci->widgets->render_area($slug);
}

function widget_instance($id)
{
	$ci =& get_instance();
	
	$ci->load->library('widgets/widgets');
	
	$widget = $ci->widgets->get_instance($id);

	return $widget ? $ci->widgets->render($widget->slug, $widget->options) : '';
}

?>