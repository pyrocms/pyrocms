<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function page_url($id)
{
	$CI =& get_instance();
	$uri = $CI->pages_m->getPathById($id);
  
	return site_url($uri);
}

function page_anchor($id, $text = '', $options = array())
{
	$CI =& get_instance();
	$uri = $CI->pages_m->getPathById($id);
  
	return anchor($uri, $text, $options);
}

?>