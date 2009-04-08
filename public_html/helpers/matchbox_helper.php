<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/*****
  * The Matchbox helper gives you lots of handy functions to use with your modules
  * @author		Philip Sturgeon
  * @email		phil@styledna.net
  * @filename	matchbox_helper.php
  * @title		Matchbox Helper
  * @url		http://www.styledna.net
  * @version	1.0
  *****/

	function module_directories() {
		$CI =& get_instance();
		return $CI->matchbox->directory_array();
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
	
	
	/***
	Returns true/false if the module exists
	  * @param		$module string		The name of the module we are testing
	  * @return		string
	***/
	function is_module($module) {
		if(!$module) return FALSE;
		
		foreach (module_directories() as $directory) {
			if(is_dir(APPPATH.$directory.'/'.$module)) {
				return TRUE;
			}
		}
		
		return FALSE;
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