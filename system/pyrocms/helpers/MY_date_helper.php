<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * CodeIgniter Date Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

function format_date($unix)
{
	if ($unix == '' || ! is_numeric($unix))
	{
		$unix = strtotime($unix);
	}
	
	return date(get_instance()->settings->date_format, $unix);
}