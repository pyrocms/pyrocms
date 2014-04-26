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

if(!function_exists('slugify'))
{
	/**
	 * Make slug from a given string
	 * 
	 * @param string $str The string you want to convert to a slug.
	 * @param string $separator The symbol you want in between slug parts.
	 * @return string The string in slugified form.
	 */
	function slugify($string, $separator = '-')
	{	
		$string = trim($string);
		$string = strtolower($string);
		$string = preg_replace('/[\s-]+/', $separator, $string);
		$string = preg_replace("/[^0-9a-zA-Z-]/", '', $string);
		
		return $string;
	}
}

if(!function_exists('rand_string'))
{
	/**
	 * Create a random hash string based on microtime
	 * @param 	int $length
	 * @return 	string
	*/
	function rand_string($length = 10)
	{
		$chars = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz';
		$max = strlen($chars)-1;
		$string = '';
		mt_srand((double)microtime() * 1000000);
		while (strlen($string) < $length)
		{
			$string .= $chars{mt_rand(0, $max)};
		}
		return $string;
	}
}
