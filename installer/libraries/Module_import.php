<?php

class Module_import {

	private $ci;

	function Module_import()
	{
		$this->ci =& get_instance();
		$db['hostname'] = $this->ci->session->userdata('hostname');
		$db['username'] = $this->ci->session->userdata('username');
		$db['password'] = $this->ci->session->userdata('password');
		$db['database'] = $this->ci->input->post('database');
		$db['port'] = $this->ci->input->post('port');
		$db['dbdriver'] = "mysql";
		$db['dbprefix'] = "";
		$db['pconnect'] = TRUE;
		$db['db_debug'] = TRUE;
		$db['cache_on'] = FALSE;
		$db['cachedir'] = "";
		$db['char_set'] = "utf8";
		$db['dbcollat'] = "utf8_general_ci";

		$this->ci->load->database($db);

	}


	private function add($module)
    {

		return $this->ci->db->insert('modules', array(
    		'name'				=>	$module['name'],
    		'slug'				=>	$module['slug'],
    		'version' 			=> 	$module['version'],
    		'type' 				=> 	$module['type'],
    		'description' 		=> 	$module['description'],
    		'skip_xss'			=>	$module['skip_xss'],
    		'is_frontend'		=>	$module['is_frontend'],
    		'is_backend'		=>	$module['is_backend'],
    		'is_backend_menu' 	=>	$module['is_backend_menu'],
    		'controllers'		=>	serialize($module['controllers']),
			'enabled'			=>  $module['enabled'],
			'is_core'			=>  $module['is_core']
    	));
    }
	
	private function _format_xml($xml_file)
    {
    	$xml = simplexml_load_file($xml_file);

    	// Loop through all controllers in the XML file
    	$controllers = array();

    	foreach($xml->controllers as $controller)
    	{
    		$controller = $controller->controller;
    		$controller_array['name'] = (string) $controller->attributes()->name;

    		// Store methods from the controller
    		$controller_array['methods'] = array();

    		if($controller->method)
    		{
    			// Loop through to save methods
    			foreach($controller->method as $method)
    			{
    				$controller_array['methods'][] = (string) $method;
    			}
    		}

			// Save it all to one variable
    		$controllers[$controller_array['name']] = $controller_array;
    	}

    	return array(
    		'name'				=>	serialize((array) $xml->name),
    		'version' 			=> 	(string) $xml->attributes()->version,
    		'type' 				=> 	(string) $xml->attributes()->type,
    		'description' 		=> 	serialize((array) $xml->description),
    		'skip_xss'			=>	$xml->skip_xss == 1,
    		'is_frontend'		=>	$xml->is_frontend == 1,
    		'is_backend'		=>	$xml->is_backend == 1,
    		'is_backend_menu' 	=>	$xml->is_backend_menu == 1,
    		'controllers'		=>	$controllers
    	);
    }


	public function _import()
    {
    	$modules = array();

    	// Loop through directories that hold modules
    	foreach (array('../application/modules/', '../third_party/modules/') as $directory)
    	{
    		// Loop through modules
	        foreach(glob($directory.'*', GLOB_ONLYDIR) as $module_name)
	        {
	        	if(file_exists($xml_file = $module_name.'/details.xml'))
	        	{
	        		$module = $this->_format_xml($xml_file) + array('slug'=>basename($module_name));

	        		$module['is_core'] = basename(dirname($directory)) != 'third_party';

					$module['enabled'] = 1;

					$this->add($module);
	        	}
	        }
        }
		
	}

}