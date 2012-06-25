<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS' Exceptions handler.
 * 
 * Override Codeigniter's exceptions for managing our 404 errors.
 *
 * @package		PyroCMS\Core\Libraries\Exceptions
 * @author		PyroCMS Dev Team
 */
class MY_Exceptions extends CI_Exceptions
{

	/**
	 * 404 Not Found Handler
	 * 
	 * @todo Maybe actually do some logging here about 404s?
	 *
	 * @param string $page The URL of the page that is returning 404.
	 * @param bool $log_error Whether the error should be logged or not.
	 */
	function show_404($page = '', $log_error = TRUE)
	{
		// Set the HTTP Status header
		set_status_header(404);

		echo Modules::run('pages/_remap', '404');
	}

}