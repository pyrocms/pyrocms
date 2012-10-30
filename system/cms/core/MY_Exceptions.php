<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS' Exceptions handler.
 * 
 * Override Codeigniter's exceptions for managing our 404 errors.
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package		PyroCMS\Core\Libraries\Exceptions
 */
class MY_Exceptions extends CI_Exceptions
{

	/**
	 * 404 Not Found Handler
	 * 
	 * @param string $page The slug of the Page Missing page. Since this is handled by the Page module it is immutable
	 * @param bool $log_error All 404s are logged by the Page module as the page segments are not available here
	 */
	public function show_404($page = 404, $log_error = true)
	{
		// Set the HTTP Status header
		set_status_header(404);

		// clear out assets set by the first module before the 404 handler takes over
		Asset::reset();

		Modules::run('pages/_remap', '404');
	}
}