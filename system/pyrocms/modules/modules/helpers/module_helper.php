<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * The Matchbox helper gives you lots of handy functions to use with your modules
 *
 * @author 		Philip Sturgeon
 * @modified	Dan Horrigan
 * @package 	PyroCMS
 * @subpackage 	Modules module
 * @category 	Modules
 * @version 	1.0
 */

/**
 * Returns the module directories.
 *
 * @return	array
 */
function module_directories()
{
	return array_keys(Modules::$locations);
}

/**
 * Module Array
 *
 * Returns an array of modules
 *
 * @return	array
 */
function module_array()
{
	$ci =& get_instance();

	$modules = $ci->module_m->get_all();
	asort($modules);

	return $modules;
}


/**
 * Module Exists
 *
 * Returns true/false if the module exists
 *
 * @param	string	$module		The name of the module we are testing
 * @return	string
 */

function module_exists($module = '')
{
	// Start looking
	$ci =& get_instance();

	return $ci->module_m->exists($module);
}


/**
 * Module Controller
 *
 * Returns true/false if the module has a controller with the name given
 *
 * @param	string	$controller		The name of the controller we are testing
 * @param	string	$module			The name of the module we are testing
 * @return	string
 */
function module_controller($controller, $module)
{
	if(!$controller)
	{
		return FALSE;
	}

	$ci =& get_instance();

	$controllers = $ci->module_m->get_module_controllers($module);

	return isset($controllers[$controller]) ? TRUE : FALSE;
}
