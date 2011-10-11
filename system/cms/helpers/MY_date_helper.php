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

function format_date($unix, $format = '')
{
	if ($unix == '' || ! is_numeric($unix))
	{
		$unix = strtotime($unix);
	}

	if ( ! $format)
	{
		$format = Settings::get('date_format');
	}

	return strstr($format, '%') !== FALSE
		? ucfirst(utf8_encode(strftime($format, $unix))) //or? strftime($format, $unix)
		: date($format, $unix);
}