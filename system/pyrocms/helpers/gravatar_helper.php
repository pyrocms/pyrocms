<?php
/**
 * Gravatar helper for CodeIgniter.
 *
 * @subpackage 	Plugins
 * @author		Phil Sturgeon
 *
 * @param 	string 	$email 		The Email address used to generate the gravatar
 * @param	int 	$size 		The size of the gravatar in pixels. A size of 50 would return a gravatar with a width and height of 50px.
 * @param	string 	$rating		The rating of the gravatar. Possible values are g, pg, r or x
 * @param	bool	$url_only 	Set this to TRUE if you want the plugin to only return the gravatar URL instead of the HTML.
 * @return  string	$gravatar	The string containing the HTML code for the image or just the URL
 */
function gravatar($email = '', $size = 50, $rating = 'g', $url_only = FALSE)
{
	$base_url 	= 'http://www.gravatar.com/avatar/';
	$email		= empty($email) ? '3b3be63a4c2a439b013787725dfce802' : md5(strtolower(trim($email)));
	$size		= '?s=' . $size;
	$rating		= '&amp;r=' . $rating;

	// URL only or the entire block of HTML ?
	if($url_only == TRUE)
	{
		$gravatar = $base_url . $email . $size . $rating;
	}
	else
	{
		$url 		= $base_url . $email . $size . $rating;
		$gravatar 	= "<img src='$url' alt='Gravatar' class='gravatar' />";
	}

	return $gravatar;
}