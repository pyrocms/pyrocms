<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */

// ------------------------------------------------------------------------

function get_supported_lang()
{
	$supported_lang = config_item('supported_languages');

	$arr = array();
	foreach ($supported_lang as $key => $lang)
	{
		$arr[] = $key . '=' . $lang['name'];
	}

	return $arr;
}

// ------------------------------------------------------------------------

/**
 * Language Label
 *
 * Takes a string and checks for lang: at the beginning. If the
 * string does not have lang:, it outputs it. If it does, then
 * it will remove lang: and use the rest as the language line key.
 *
 * @param 	string
 * @return 	string
 */
if ( ! function_exists('lang_label'))
{
	function lang_label($key)
	{
		if (substr($key, 0, 5) == 'lang:')
		{
			return lang(substr($key, 5));
		}
		else
		{
			return $key;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('sprintf_lang'))
{
    function sprintf_lang($line, $variables = array())
    {
        array_unshift($variables, lang($line));
        return call_user_func_array('sprintf', $variables);
    }
}