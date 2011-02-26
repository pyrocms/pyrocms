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

	$format = get_instance()->settings->date_format;

	return strstr($format, '%') !== FALSE
		? strftime($format, $unix) //or? mb_convert_case(strftime($format, $unix), MB_CASE_TITLE, 'UTF-8')
		: date($format, $unix);
}