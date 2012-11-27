<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS URL Helpers
 *
 * This overrides Codeigniter's helpers/url_helper.php file.
 *
 * @package   PyroCMS\Core\Helpers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */

if (!function_exists('url_title'))
{

	/**
	 * Create URL Title
	 *
	 * Takes a "title" string as input and creates a human-friendly URL string
	 * with either a dash or an underscore as the word separator.
	 * Cyrillic alphabet characters are supported.
	 *
	 * @param string  $str       The string
	 * @param string  $separator The separator, dash or underscore.
	 * @param boolean $lowercase Whether it should be converted to lowercase.
	 *
	 * @return string The URL slug
	 */
	function url_title($str, $separator = 'dash', $lowercase = false)
	{
		$replace = ($separator == 'dash') ? '-' : '_';

		$trans = array(
			'&\#\d+?;' => '',
			'&\S+?;' => '',
			'\s+' => $replace,
			'[^a-z0-9\-\._]' => '',
			$replace.'+' => $replace,
			$replace.'$' => $replace,
			'^'.$replace => $replace,
			'\.+$' => ''
		);

		$str = convert_accented_characters($str);
		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === true)
		{
			if (function_exists('mb_convert_case'))
			{
				$str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
			}
			else
			{
				$str = strtolower($str);
			}
		}

		$CI = & get_instance();
		$str = preg_replace('#[^'.$CI->config->item('permitted_uri_chars').']#i', '', $str);

		return trim(stripslashes($str));
	}

}

if (!function_exists('shorten_url'))
{

	/**
	 * Shorten URL
	 *
	 * Takes a long url and uses the TinyURL API to return a shortened version.
	 * Supports Cyrillic characters.
	 *
	 * @param  string $url long url
	 *
	 * @return string Short url
	 */
	function shorten_url($url = '')
	{
		$CI = & get_instance();

		$CI->load->spark('curl/1.2.1');

		if (!$url)
		{
			$url = site_url($CI->uri->uri_string());
		}

		// If no a protocol in URL, assume its a CI link
		elseif ( ! preg_match('!^\w+://! i', $url))
		{
			$url = site_url($url);
		}

		return $CI->curl->simple_get('http://tinyurl.com/api-create.php?url='.$url);
	}

}