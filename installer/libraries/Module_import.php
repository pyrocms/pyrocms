<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('ADDONPATH', dirname(FCPATH).'/addons/default/');
define('SHARED_ADDONPATH', dirname(FCPATH).'/addons/shared_addons/');

// All modules talk to the Module class, best get that!
include PYROPATH .'libraries/Module'.EXT;

class Module_import {

	private $ci;

	public function __construct($params)
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('file');

		// Getting our model and MY_Model class set up
		class_exists('CI_Model', FALSE) OR load_class('Model', 'core');
		include(PYROPATH.'/core/MY_Model.php');

		// Include some constants that modules may be looking for
		define('SITE_REF', 'default');

		$this->ci->load->database(array(
			'dsn'		=> $params['dsn'],
			'username'		=> $params['username'],
			'password'		=> $params['password'],
			'dbdriver'	=> "pdo",
			'dbprefix'	=> 'default_',
			'pconnect'	=> TRUE,
			'db_debug'	=> TRUE,
			'char_set'	=> "utf8",
			'dbcollat'	=> "utf8_unicode_ci",
		));

		// create the site specific addon folder
		is_dir(ADDONPATH.'modules') OR mkdir(ADDONPATH.'modules', DIR_READ_MODE, TRUE);
		is_dir(ADDONPATH.'themes') OR mkdir(ADDONPATH.'themes', DIR_READ_MODE, TRUE);
		is_dir(ADDONPATH.'widgets') OR mkdir(ADDONPATH.'widgets', DIR_READ_MODE, TRUE);
		is_dir(ADDONPATH.'field_types') OR mkdir(ADDONPATH.'field_types', DIR_READ_MODE, TRUE);

		// create the site specific upload folder
		is_dir(dirname(FCPATH).'/uploads/default') OR mkdir(dirname(FCPATH).'/uploads/default', DIR_WRITE_MODE, TRUE);

		//insert empty html files
		write_file(ADDONPATH.'modules/index.html','');
		write_file(ADDONPATH.'themes/index.html','');
		write_file(ADDONPATH.'widgets/index.html','');
		write_file(PYROPATH.'uploads/index.html','');
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

		// set the site_ref and upload_path for third-party devs
		$details_class->site_ref 	= 'default';
		$details_class->upload_path	= 'uploads/default/';

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
		// Loop through directories that hold modules
		$is_core = TRUE;
		foreach (array(PYROPATH, ADDONPATH, SHARED_ADDONPATH) as $directory)
		{
			// some servers return false instead of an empty array
			if ( ! $directory) continue;

			// Loop through modules
			if ($modules = glob($directory.'modules/*', GLOB_ONLYDIR))
			{
				foreach ($modules as $module_name)
				{
					$slug = basename($module_name);

					if ( ! $details_class = $this->_spawn_class($slug, $is_core))
					{
						continue;
					}

					$this->install($slug, $is_core);
				}
			}

			// Going back around, 2nd time is addons
			$is_core = FALSE;
		}

		// After modules are imported we need to modify the settings table
		// This allows regular admins to upload addons on the first install but not on multi
		$this->ci->db->where('slug', 'addons_upload')
			->update('settings', array('value' => '1'));

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
	private function _spawn_class($slug, $is_core = FALSE)
	{
		$path = $is_core ? PYROPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = $path . 'modules/'.$slug.'/details'.EXT;

		// Check the details file exists
		if ( ! is_file($details_file))
		{
			$details_file = SHARED_ADDONPATH.'modules/'.$slug.'/details'.EXT;

			if ( ! is_file($details_file))
			{
				return FALSE;
			}
		}

		// Sweet, include the file
		include_once $details_file;

		// Now call the details class
		$class = 'Module_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class : FALSE;
	}
}
