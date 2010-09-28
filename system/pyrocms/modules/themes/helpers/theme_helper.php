<?php defined('BASEPATH') OR exit('No direct script access allowed');

function theme_partial($view)
{
	$CI =& get_instance();

	$data =& $CI->load->_ci_cached_vars;

	echo $CI->parser->parse_string($CI->load->_ci_load(array(
		'_ci_path' => $data['template_views'].'partials/'.$view. '.html',
		'_ci_return' => TRUE
	)), $data, TRUE, TRUE);
}