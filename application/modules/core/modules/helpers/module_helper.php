<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

	/*****
	* The Matchbox helper gives you lots of handy functions to use with your modules
	* @author		Philip Sturgeon
	* @email		email@philsturgeon.co.uk
	* @filename		module_helper.php
	* @title		Module Helper
	* @url			http://philsturgeon.co.uk
	* @version		1.0
	*****/

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
		foreach (module_directories() as $directory)
		{
	        foreach(glob($directory.'/*', GLOB_ONLYDIR) as $module)
	        {
				$modules[] = basename($module);
	        }
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
		
		foreach (module_directories() as $directory)
		{
			if(is_dir($directory.'/'.$module))
			{
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