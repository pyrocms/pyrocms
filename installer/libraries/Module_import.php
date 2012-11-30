<?php

include PYROPATH.'core/MY_Model.php';

// All modules talk to the Module class, best get that!
include PYROPATH.'libraries/Module.php';

class Module_import
{

	// private $ci;

	public function __construct(array $params)
	{
		$this->ci = get_instance();

		$this->ci->pdb = $this->pdb = $params['pdb'];

		// create the site specific addon folder
		is_dir(ADDONPATH.'modules') or mkdir(ADDONPATH.'modules', DIR_READ_MODE, true);
		is_dir(ADDONPATH.'themes') or mkdir(ADDONPATH.'themes', DIR_READ_MODE, true);
		is_dir(ADDONPATH.'widgets') or mkdir(ADDONPATH.'widgets', DIR_READ_MODE, true);
		is_dir(ADDONPATH.'field_types') or mkdir(ADDONPATH.'field_types', DIR_READ_MODE, true);

		// create the site specific upload folder
		if ( ! is_dir(dirname(FCPATH).'/uploads/default')) 
		{
			mkdir(dirname(FCPATH).'/uploads/default', DIR_WRITE_MODE, true);
		}
	}

	/**
	 * Installs a module
	 *
	 * @param string $slug The module slug
	 * @param bool   $is_core
	 *
	 * @return bool
	 */
	public function install($slug, $is_core = false)
	{
		$details_class = $this->_spawn_class($slug, $is_core);

		// Get some basic info
		$module = $details_class->info();

		// Now lets set some details ourselves
		$module['version'] = $details_class->version;
		$module['is_core'] = $is_core;
		$module['enabled'] = true;
		$module['installed'] = true;
		$module['slug'] = $slug;

		// set the site_ref and upload_path for third-party devs
		$details_class->site_ref = 'default';
		$details_class->upload_path = 'uploads/default/';

		// Run the install method to get it into the database
		try 
		{
			$details_class->install();
		} 
		catch (Exception $e)
		{
			return false;
		}

		// Looks like it installed ok, add a record
		return $this->add($module);
	}

	public function add($module)
	{
		return $this->pdb
			->table('modules')
			->insert(array(
				'name' => serialize($module['name']),
				'slug' => $module['slug'],
				'version' => $module['version'],
				'description' => serialize($module['description']),
				'skip_xss' => ! empty($module['skip_xss']),
				'is_frontend' => ! empty($module['frontend']),
				'is_backend' => ! empty($module['backend']),
				'menu' => ! empty($module['menu']) ? $module['menu'] : false,
				'enabled' => $module['enabled'],
				'installed' => $module['installed'],
				'is_core' => $module['is_core']
			)
		);
	}


	public function import_all()
	{
		// Loop through directories that hold modules
		$is_core = true;
		foreach (array(PYROPATH, ADDONPATH, SHARED_ADDONPATH) as $directory)
		{
			// some servers return false instead of an empty array
			if ( ! $directory) {
				continue;
			}

			// Loop through modules
			if ($modules = glob($directory.'modules/*', GLOB_ONLYDIR))
			{
				// Put the settings module first
				$modules = array_map('basename',$modules);
				$s = array_splice($modules, array_search('settings', $modules), 1);
				array_unshift($modules, $s[0]);

				foreach ($modules as $module_name)
				{
					if ( ! $details_class = $this->_spawn_class($module_name, $is_core))
					{
						continue;
					}

					$this->install($module_name, $is_core);

					// Settings is installed first. Once it's installed we load the library
					// so all modules can use settings in their install code.
					if ($module_name === 'settings')
					{
						$this->ci->load->library('settings/settings');
					}
				}
			}

			// Going back around, 2nd time is addons
			$is_core = false;
		}

		// After modules are imported we need to modify the settings table
		// This allows regular admins to upload addons on the first install but not on multi
		$this->pdb
			->table('settings')
			->where('slug', '=', 'addons_upload')
			->update(array('value' => true));

		return true;
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a details.php exists and returns a class
	 *
	 * @param string $slug    The folder name of the module
	 * @param bool   $is_core
	 *
	 * @return    Module
	 */
	private function _spawn_class($slug, $is_core = false)
	{
		$path = $is_core ? PYROPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module<<<<<<< HEAD
		$details_file = "{$path}modules/{$slug}/details.php";

		// Check the details file exists
		if ( ! is_file($details_file))
		{
			$details_file = "{SHARED_ADDONPATH}modules/{$slug}/details.php";

			if ( ! is_file($details_file))
			{
				return false;
			}
		}

		// Sweet, include the file
		include_once $details_file;

		// Now call the details class
		$class = 'Module_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class($this->pdb) : false;
	}
}
