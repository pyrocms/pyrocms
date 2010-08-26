<?php defined('BASEPATH') OR exit('No direct script access allowed');

function theme_view($view)
{
	$ci =& get_instance();
	
	$data =& $ci->load->_ci_cached_vars;

	foreach($ci->template->theme_locations() as $location => $offset)
	{
		$view_path = $ci->settings->item('default_theme').'/views/'.$view;

		if(file_exists($location.$view_path.'.html'))
		{
			echo $ci->parser->parse($offset.$view_path.'.html', $data, TRUE);
			break;
		}

		// TODO Deprecate php
		if(file_exists($location.$view_path.EXT))
		{
			echo $ci->parser->parse($offset.$view_path, $data, TRUE);
			break;
		}
	}

}