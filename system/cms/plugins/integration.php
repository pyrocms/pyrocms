<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Integration Plugin
 *
 * Attaches a Google Analytics tracking piece of code.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Integration extends Plugin
{

	/**
	 * Partial
	 *
	 * Loads Google Analytic
	 *
	 * Usage:
	 *   {{ integration:analytics }}
	 *
	 * @return string The analytics partial view.
	 */
	function analytics()
	{
		return $this->load->view('fragments/google_analytics', NULL, TRUE);
	}

}