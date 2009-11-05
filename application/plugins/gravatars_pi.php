<?php
/**
 * Gravatar plugin for PyroCMS.
 *
 * @package 	PyroCMS
 * @subpackage 	Plugins
 * @author		Yorick Peterse - PyroCMS Development Team
 * @since 		v0.9.8
 *
 * @param 	string 	$email 		The Email address used to generate the gravatar
 * @param	int 	$size 		The size of the gravatar in pixels. A size of 50 would return a gravatar with a width and height of 50px.
 * @param	string 	$rating T	he rating of the gravatar. Possible values are g, pg, r or x
 * @param	bool	$url_only 	Set this to TRUE if you want the plugin to only return the gravatar URL instead of the HTML.
 * @return  string	$gravatar	The string containing the HTML code for the image or just the URL
 */
function gravatar($email,$size = 50,$rating = 'g',$url_only = FALSE)
{
	// Base URL
	$base_url 	= 'http://www.gravatar.com/avatar/';
	// Default or custom email ? 
	if(!empty($email))
	{
		// User based gravatar
		$email 		= md5($email);
	}
	else
	{
		// Set the default gravatar
		$email = '3b3be63a4c2a439b013787725dfce802';
	}
	// Size
	$size		= '?s=' . $size;
	// Rating
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
	
	// Return it
	return $gravatar;
}
?>