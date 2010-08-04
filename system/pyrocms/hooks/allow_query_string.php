<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Allow Query Strings in CI while still using AUTO uri_protocol
 *
 * @author Dan Horrigan
 * @author Phil Sturgeon
 */

function clean_uri()
{
	$_GET = null;
	
	foreach(array('REQUEST_URI', 'PATH_INFO', 'ORIG_PATH_INFO') as $uri_protocol)
	{
		if(!isset($_SERVER[$uri_protocol]))
		{
			continue;
		}
		
		if(strpos($_SERVER[$uri_protocol], '?') !== FALSE)
		{
			$_SERVER[$uri_protocol] = str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER[$uri_protocol]);
		}
	}
}

function recreate_get()
{
	parse_str($_SERVER['QUERY_STRING'],$_GET);
}