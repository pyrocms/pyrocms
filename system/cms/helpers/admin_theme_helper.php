<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS Admin Theme Helpers
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package		PyroCMS\Core\Modules\Theme\Helpers
 */

// ------------------------------------------------------------------------

/**
 * Partial Helper
 *
 * Loads the partial
 *
 * @param string $file The name of the file to load.
 * @param string $ext The file's extension.
 */
function file_partial($file = '', $ext = 'php')
{
	$CI = & get_instance();
	$data = & $CI->load->_ci_cached_vars;

	$path = $data['template_views'].'partials/'.$file;

	echo $CI->load->_ci_load(array(
		'_ci_path' => $data['template_views'].'partials/'.$file.'.'.$ext,
		'_ci_return' => true
	));
}

// ------------------------------------------------------------------------

/**
 * Template Partial
 *
 * Display a partial set by the template
 *
 * @param string $name The view partial to display.
 */
function template_partial($name = '')
{
	$CI = & get_instance();
	$data = & $CI->load->_ci_cached_vars;

	echo isset($data['template']['partials'][$name]) ? $data['template']['partials'][$name] : '';
}

// ------------------------------------------------------------------------

/**
 * Add an admin menu item to the order array
 * at a specific place.
 *
 * For instance, if you have a menu item with a keu 'lang:my_menu',
 * and you want to add it to the 2nd position, you can do this:
 *
 * add_admin_menu_place('lang:my_menu', 2);
 *
 * @param 	string
 * @param 	int
 * @return 	void
 */
function add_admin_menu_place($key, $place)
{
	if ( ! is_numeric($place) or $place < 1)
	{
		return null;
	}

	$place--;

	$CI = get_instance();

	$CI->template->menu_order = array_merge(array_slice($CI->template->menu_order, 0, $place, true), array($key), array_slice($CI->template->menu_order, $place, count($CI->template->menu_order)-1, true));
}

// ------------------------------------------------------------------------

/**
 * Accented Foreign Characters Output
 *
 * @return null|array The array of the accented characters and their replacements.
 */
function accented_characters()
{
	if (defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php'))
	{
		include(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php');
	}
	elseif (is_file(APPPATH.'config/foreign_chars.php'))
	{
		include(APPPATH.'config/foreign_chars.php');
	}

	if (!isset($foreign_characters))
	{
		return;
	}

	$languages = array();
	foreach ($foreign_characters as $key => $value)
	{
		$languages[] = array(
			'search' => $key,
			'replace' => $value
		);
	}

	return $languages;
}