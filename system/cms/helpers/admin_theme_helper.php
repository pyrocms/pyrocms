<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* PyroCMS Theme Helpers
*
* @package		PyroCMS
* @subpackage	Helpers
* @category		Helpers
* @author       Jerel Unruh - PyroCMS Dev Team
*/

// ------------------------------------------------------------------------

/**
 * Partial Helper
 *
 * Loads the partial
 *
 * @access		public
 * @param		mixed    file name to load
 */
function file_partial($file = '', $ext = 'php')
{
	$CI =& get_instance();
	$data =& $CI->load->_ci_cached_vars;

	$path = $data['template_views'].'partials/'.$file;

	echo $CI->load->_ci_load(array(
		'_ci_path' => $data['template_views'].'partials/'.$file.'.'.$ext,
		'_ci_return' => TRUE
	));
}

// ------------------------------------------------------------------------

/**
 * Template Partial
 *
 * Display a partial set by the template
 *
 * @access		public
 * @param		mixed    partial to display
 */
function template_partial($name = '')
{
	$CI =& get_instance();
	$data =& $CI->load->_ci_cached_vars;

	echo isset($data['template']['partials'][$name]) ? $data['template']['partials'][$name] : '';
}

// ------------------------------------------------------------------------

/**
 * Accented Foreign Characters Output
 *
 * Return accented foreign characters array
 *
 * @access		public
 * @return		array
 */
function accented_characters()
{
	if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php'))
	{
		include(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php');
	}
	elseif (is_file(APPPATH.'config/foreign_chars.php'))
	{
		include(APPPATH.'config/foreign_chars.php');
	}

	if ( ! isset($foreign_characters))
	{
		return;
	}

	$languages = array();
	foreach ($foreign_characters as $key => $value) {
		$languages[] = array(
			'search' => $key,
			'replace' => $value
		);
	}

	return $languages;
}
