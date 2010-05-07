<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * The Matchbox helper gives you lots of handy functions to use with your modules
 * 
 * @author 		Philip Sturgeon
 * @package 	PyroCMS
 * @subpackage 	Modules module
 * @category 	Modules
 * @version 	1.0
 */

function module_directories()
{
	return array_keys(Modules::$locations);
}

/***
* Returns an array of modules
* @return		array
***/
function module_array()
{
	$ci =& get_instance();

	$modules = $ci->modules_m->get_modules();
	asort($modules);
     
	return $modules;
}


/**
* module_exists
* Returns true/false if the module exists
* 
* @param		$module string		The name of the module we are testing
* @return		string
*
*/

function module_exists($module = '')
{
	static $_module_exists = array();

	if(!$module)
	{
		return FALSE;
	}

	// We already know about this module
	if(isset($_module_exists[$module]))
	{
		return $_module_exists[$module];
	}

	// Start looking
	$ci =& get_instance();

	$_module_exists[$module] = $ci->modules_m->exists($module);

	return $_module_exists[$module];
}


/***
Returns true/false if the module has a controller with the name given
  * @param		$controller string		The name of the controller we are testing
  * @param		$module string		The name of the module we are testing
  * @return		string
***/
function module_controller($controller, $module)
{
	if(!$controller)
	{
		return FALSE;
	}
	
	foreach (module_directories() as $directory)
	{
		if(file_exists($directory.$module.'/controllers/'.$controller.EXT))
		{
			return TRUE;
		}
	}
	
	return FALSE;
}
	
?>