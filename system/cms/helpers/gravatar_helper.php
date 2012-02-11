<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gravatar helper for CodeIgniter.
 *
 * @author		Phil Sturgeon
 * @package 	PyroCMS\Core\Helpers
 */
if (!function_exists('gravatar'))
{

	/**
	 * Gravatar helper for CodeIgniter.
	 *
	 * @param string $email The Email address used to generate the gravatar
	 * @param int $size The size of the gravatar in pixels. A size of 50 would return a gravatar with a width and height of 50px.
	 * @param string $rating The rating of the gravatar. Possible values are g, pg, r or x
	 * @param boolean $url_only Set this to TRUE if you want the plugin to only return the gravatar URL instead of the HTML.
	 * @param boolean $default Url to image used instead af Gravatars default when email has no gravatar
	 * @return string The gravatar's URL or the img HTML tag ready to be used.
	 */
	function gravatar($email = '', $size = 50, $rating = 'g', $url_only = FALSE, $default = FALSE)
	{
		$base_url = 'http://www.gravatar.com/avatar/';
		$email = empty($email) ? '3b3be63a4c2a439b013787725dfce802' : md5(strtolower(trim($email)));
		$size = '?s='.$size;
		$rating = '&amp;r='.$rating;
		$default = !$default ? '' : '&amp;d='.urlencode($default);

		$gravatar_url = $base_url.$email.$size.$rating.$default;
		// URL only or the entire block of HTML ?
		if ($url_only == TRUE)
		{
			return $gravatar_url;
		}

		return '<img src="'.$gravatar_url.'" alt="Gravatar" class="gravatar" />';
	}

}