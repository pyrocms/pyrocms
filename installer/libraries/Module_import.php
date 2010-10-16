<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('PYROPATH', dirname(FCPATH).'/system/pyrocms/');
define('ADDONPATH', dirname(FCPATH).'/addons/');

// All modules talk to the Module class, best get that!
include PYROPATH .'libraries/Module'.EXT;

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
		$db['dbcollat'] = "utf8_unicode_ci";

		$this->ci->load->database($db);
	}


	/**
	 * Install
	 *
	 * Installs a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function install($slug, $is_core = FALSE)
	{
		$details_class = $this->_spawn_class($slug, $is_core);

		// Get some basic info
		$module = $details_class->info();

		// Now lets set some details ourselves
		$module['version'] = $details_class->version;
		$module['is_core'] = $is_core;
		$module['enabled'] = TRUE;
		$module['installed'] = TRUE;
		$module['slug'] = $slug;

		// Run the install method to get it into the database
		if ( ! $details_class->install())
		{
			return FALSE;
		}

		// Looks like it installed ok, add a record
		return $this->add($module);
	}

	public function add($module)
	{
		return $this->ci->db->insert('modules', array(
			'name' => serialize($module['name']),
			'slug' => $module['slug'],
			'version' => $module['version'],
			'description' => serialize($module['description']),
			'skip_xss' => !empty($module['skip_xss']),
			'is_frontend' => !empty($module['frontend']),
			'is_backend' => !empty($module['backend']),
			'menu' => !empty($module['menu']) ? $module['menu'] : FALSE,
			'enabled' => $module['enabled'],
			'installed' => $module['installed'],
			'is_core' => $module['is_core']
		));
	}


	public function import_all()
    {
		//drop the old modules table
		$this->ci->load->dbforge();
		$this->ci->dbforge->drop_table('modules');

		$modules = "
			CREATE TABLE `modules` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` TEXT NOT NULL,
			  `slug` varchar(50) NOT NULL,
			  `version` varchar(20) NOT NULL,
			  `type` varchar(20) DEFAULT NULL,
			  `description` TEXT DEFAULT NULL,
			  `skip_xss` tinyint(1) NOT NULL,
			  `is_frontend` tinyint(1) NOT NULL,
			  `is_backend` tinyint(1) NOT NULL,
			  `menu` varchar(20) NOT NULL,
			  `enabled` tinyint(1) NOT NULL,
			  `installed` tinyint(1) NOT NULL,
			  `is_core` tinyint(1) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		//create the modules table so that we can import all modules including the modules module
		$this->ci->db->query($modules);

    	// Loop through directories that hold modules
		$is_core = TRUE;

		foreach (array(PYROPATH, ADDONPATH) as $directory)
    	{
    		// Loop through modules
	        foreach(glob($directory.'modules/*', GLOB_ONLYDIR) as $module_name)
	        {
				$slug = basename($module_name);

				if ( ! $details_class = $this->_spawn_class($slug, $is_core))
				{
					continue;
				}

				$this->install($slug, $is_core);
			}

			// Going back around, 2nd time is addons
			$is_core = FALSE;
        }

		return TRUE;
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a details.php exists and returns a class
	 *
	 * @param	string	$module_slug	The folder name of the module
	 * @access	private
	 * @return	array
	 */
	private function _spawn_class($module_slug, $is_core = FALSE)
	{
		$path = $is_core ? PYROPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = $path . 'modules/' . $module_slug . '/details'.EXT;

		// Check the details file exists
		if (!is_file($details_file))
		{
			return FALSE;
		}

		// Sweet, include the file
		include_once $details_file;

		// Now call the details class
		$class = 'Details_'.ucfirst($module_slug);

		// Now we need to talk to it
		return new $class;
	}
}