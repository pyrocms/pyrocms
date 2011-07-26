<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Theme Plugin
 *
 * Load partials and access data
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.
 *
 */
class Plugin_Integration extends Plugin
{
	/**
	 * Partial
	 *
	 * Loads Google Analytic
	 *
	 * Usage:
	 * {pyro:integration:analytics}
	 *
	 * @param	array
	 * @return	array
	 */
	function analytics()
	{
		return $this->load->view('fragments/google_analytics', NULL, TRUE);
	}
}

/* End of file theme.php */