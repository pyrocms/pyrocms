<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modules_m extends Model {

    function __construct() {
        parent::Model();
        $this->load->helper('matchbox');
    }
    
    // Return an object containing module data
    function getModule($module = '') {
    	foreach (module_directories() as $directory)
    	{
			if(file_exists($xml_file = APPPATH.$directory.'/'.$module.'/details.xml'))
			{
				return $this->_formatXML($xml_file);
			}
		}
    }
    
	// Return an object containing module data
    function getModuleToolbar($module = '') {
    	foreach (module_directories() as $directory)
    	{
			if(file_exists($xml_file = APPPATH.$directory.'/'.$module.'/details.xml'))
			{
				return $this->_formatToolbarXML($xml_file);
			}
		}
    }
    
    // Return an array of objects containing module data
    function getModules($params = array()) {
		
    	$modules = array();
    	
    	// Loop through directories that hold modules
    	foreach (module_directories() as $directory)
    	{
    		// Loop through modules
	        foreach(glob(APPPATH.$directory.'/*', GLOB_ONLYDIR) as $module_name)
	        {
	        	if(file_exists($xml_file = $module_name.'/details.xml'))
	        	{
	        		$module = $this->_formatXML($xml_file) + array('slug'=>basename($module_name));

		        	// Ignore modules of the incorrect type
		        	if(!empty($params['type']) && $module['type'] != $params['type']) continue;
		        	
	        		// If we only want frontend modules, check its frontend
		        	if(!empty($params['is_frontend']) && empty($module['is_frontend'])) continue;
		        	
		        	// Looking for backend modules
		        	if(!empty($params['is_backend']))
		        	{
		        		// This module is not a backend module
		        		if(empty($module['is_backend'])) continue;
		        		
		        		// This user has no permissions for this module
		        		if(!$this->permissions_m->hasAdminAccess( $this->user_lib->user_data->role, $module['slug']) ) continue;
		        	}
	       			
			 	// Check a module is intended for the sidebar
				if(isset($params['is_backend_sidebar']) && $module['is_backend_sidebar'] != $params['is_backend_sidebar']) continue;
 
	        		$modules[] = $module;
	        	}
	        }
        }
    	
        return $modules;
    }
    
    
    function getControllers($module = '') {
		
    	$controllers = array();
    	
    	// Loop through directories that hold modules
    	foreach (module_directories() as $directory):
            
    		// Loop through modules
	        foreach(glob(APPPATH.$directory.'/'.$module.'/controllers/*.php') as $controller):
        		$controllers[] = basename($controller, '.php');
			endforeach;
            
        endforeach;

        return $controllers;
        /*
    	$module = $this->getModule($module);
    	
		return !empty($module['controllers']) ? $module['controllers'] : array();    	
    	*/
    }
    
    
    function getMethods($module, $controller) {
    	
    	$module = $this->getModule($module);
    	
		return !empty($module['controllers'][$controller]['methods']) ? $module['controllers'][$controller]['methods'] : array();    	
    }
    
    
    function _formatXML($xml_file) {
    	$xml = simplexml_load_file($xml_file);
    	
    	// Loop through all controllers in the XML file
    	$controllers = array();

    	foreach($xml->controllers as $controller):
    		$controller = $controller->controller;
    		$controller_array['name'] = (string) $controller->attributes()->name;	
    		
    		// Store methods from the controller
    		$controller_array['methods'] = array();
    		if($controller->method):
    			// Loop through to save methods
    			foreach($controller->method as $method) $controller_array['methods'][] = (string) $method;
			endif;    		
    		
			// Save it all to one variable
    		$controllers[$controller_array['name']] = $controller_array;
    	endforeach;

    	return array(
    		'name'			=>	(string) $xml->name->{constant('CURRENT_LANGUAGE')},
    		'version' 		=> 	(float) $xml->attributes()->version,
    		'type' 			=> 	(string) $xml->attributes()->type,
    		'description' 	=> 	(string) $xml->description->{constant('CURRENT_LANGUAGE')},
    		'icon' 			=> 	(string) $xml->icon,
    		'required'		=>	$xml->required == 1,
    		'is_frontend'	=>	$xml->is_frontend == 1,
    		'is_backend'	=>	$xml->is_backend == 1,
    		'is_backend_sidebar'	 =>	$xml->is_backend_sidebar == 1,
    		'controllers'	=>	$controllers
    	);
    }
    
    function _formatToolbarXML($xml_file)
    {
    	$toolbar = array(
    		'new_item' => array(),
    		'links' => array(),
    		'search' => array()
    	);
    	
    	$xml = simplexml_load_file($xml_file);
    	
    	// New item
    	if( !empty($xml->navigation->admin->new_item) )
    	{
    		$new_item =& $xml->navigation->admin->new_item;
    		
    		$uri = (string) $new_item->attributes()->href;
    		
    		$toolbar['new_item'] = array(
    			'link' => $uri,
    			'title' => $new_item->{CURRENT_LANGUAGE}
    		);
    		
    	}

    	// Toolbar links
    	if( !empty($xml->navigation->admin->toolbar) )
    	{
	    	foreach($xml->navigation->admin->toolbar as $link)
	    	{
	    		$controller = $controller->controller;
	    		$navigation = (string) $controller->attributes()->name;	
	    		
				// Save it all to one variable
	    		$controllers[$controller_array['name']] = $controller_array;
    		}
    	}
    	
    	return $toolbar;
    	
    }
}

?>
