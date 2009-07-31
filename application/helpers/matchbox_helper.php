<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/*****
  * The Matchbox helper gives you lots of handy functions to use with your modules
  * @author		Philip Sturgeon
  * @email		email@philsturgeon.co.uk
  * @filename	matchbox_helper.php
  * @title		Matchbox Helper
  * @url		http://philsturgeon.co.uk
  * @version	1.0
  *****/

	function module_directories() {
		$CI =& get_instance();
		
		//return $CI->matchbox->directory_array();
		
		/* What the shit is going on here? Well, i'll explain!
		 * The commented out line above will return all module directories.
		 * That doesnt mean a list of modules, it means a list of places modules can be.
		 * The line above allows users to add more module locations, but I dont want em doing that.
		 * The only place these functions should be looking is the main module folder
		 * This basically stops it checking if core modules are there and whatnot,
		 * cause they always should be, and I dont want core modules in lists of content modules.
		 * Ok?
		 * Good.
		 */
		
		return array('modules');
	}

	/***
	Returns an array of modules
	  * @return		array
	***/
	function module_array() {
		
		foreach (module_directories() as $directory) {
            
	        foreach(glob(APPPATH.$directory.'/*', GLOB_ONLYDIR) as $module):
				$modules[] = basename($module);
			endforeach;
            
        }
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
	
	function module_exists($module)
	{
		if(!$module) return FALSE;
		
		foreach (module_directories() as $directory) {
			if(is_dir(APPPATH.$directory.'/'.$module)) {
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	// depreciated
	function is_module($module)
	{
		return module_exists($module);
	}
	
	/***
	Returns true/false if the module has a controller with the name given
	  * @param		$controller string		The name of the controller we are testing
	  * @param		$module string		The name of the module we are testing
	  * @return		string
	***/
	function module_controller($controller, $module) {
		if(!$controller) return FALSE;
		
		foreach (module_directories() as $directory) {
			if(file_exists(APPPATH.$directory.'/'.$module.'/controllers/'.$controller.EXT)) {
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
?>