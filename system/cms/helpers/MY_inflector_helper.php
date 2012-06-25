<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Inflector Helpers
 * 
 * This overrides Codeigniter's helpers/inflector_helper.php file.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Helpers
 */
if (!function_exists('humanize'))
{

	/**
	 * Humanize - Cyrillic character support
	 *
	 * Takes multiple words separated by underscores and changes them to spaces
	 *
	 * @access	public
	 * @param	string
	 * @return	str
	 */
	function humanize($str)
	{
		$str = preg_replace('/[_]+/', ' ', trim($str));

		if (function_exists('mb_convert_case'))
		{
			return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
		}

		return ucwords(strtolower($str));
	}

}

if (!function_exists('keywords'))
{

	/**
	 * Keywords
	 *
	 * Takes multiple words separated by spaces and changes them to keywords
	 * Makes sure the keywords are separated by a comma followed by a space.
	 *
	 * @param string $str The keywords as a string, separated by whitespace.
	 * @return string The list of keywords in a comma separated string form.
	 */
	function keywords($str)
	{
		return preg_replace('/[\s]+/', ', ', trim($str));
	}

}