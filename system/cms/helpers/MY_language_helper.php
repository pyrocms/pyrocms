<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		PyroCMS development team
 */

// ------------------------------------------------------------------------

function get_supported_lang()
{
	$supported_lang = Settings::get('supported_languages');

	$arr = array();
	foreach ($supported_lang as $key => $lang)
	{
		$arr[] = $key . '=' . $lang['name'];
	}

	return $arr;
}