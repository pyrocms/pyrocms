<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Inflector Helpers
 * 
 * This overrides Codeigniter's helpers/inflector_helper.php file.
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package		PyroCMS\Core\Helpers
 */

if ( ! function_exists('keywords'))
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