<?php

# If the user is viewing the mobile site and is requesting to view the full site
# We will set a cookie here and then redirect them to the page they were requesting
if(strpos($_SERVER['REQUEST_URI'], 'mobile_override') !== false) {
	// Generate the hostname to be used for the cookie
	$host = (isset($_SERVER['HTTP_HOST']))? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
	// first set the mobile_override cookie
	setcookie('mobile_override', true, 0, '/', $host);
	// remove the mobile override get parameter
	$new_uri = str_replace('mobile_override', '', $_SERVER['REQUEST_URI']);
	$new_link = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$new_uri}";

	// if the new link ends in just a ? we will stip it off. Otherwise we will leave it.
	if(substr($new_link, -1) === '?') {
		$new_link = substr($new_link, 0, -1);
	}
	
	// then redirect to the current page to activate the cookie
	header('Location: ' . $new_link);
	exit;
}

/**
 * MY_User_agent
 * Fix to allow users to bounce back to the full site if they are on a mobile device
 *
 * @author      Brennon Loveless
 */
class MY_User_agent extends CI_User_agent
{
	public function __construct()
	{
		parent::__construct();
	}


	public function is_mobile($key = null)
	{
		// If the mobile override cookie is set then ignore is_mobile and just return false
		if(isset($_COOKIE['mobile_override'])) {
			return FALSE;
		}

		// If the mobile override cookie is not set then we will return to the standard is_mobile function
		return parent::is_mobile($key);
	}
}
