<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('PYROPATH', dirname(FCPATH).'/system/cms/');
define('ADDONPATH', dirname(FCPATH).'/addons/default/');
define('SHARED_ADDONPATH', dirname(FCPATH).'/addons/shared_addons/');

// All modules talk to the Module class, best get that!
include PYROPATH.'libraries/Module'.EXT;

class Module_import
{

	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();

		// Getting our model and MY_Model class set up
		class_exists('CI_Model', false) OR load_class('Model', 'core');
		include(PYROPATH.'/core/MY_Model.php');

		// Include some constants that modules may be looking for
		define('SITE_REF', 'default');

		// Now we can use stuff from our system/cms directory, hooray!
		// Any dupes are generic so we shouldn't run into any 
		// meaningful conflicts.
		$this->ci->load->add_package_path(PYROPATH);
		$this->ci->load->add_package_path(SHARED_ADDONPATH);

		$db['hostname'] = $this->ci->session->userdata('hostname');
		$db['username'] = $this->ci->session->userdata('username');
		$db['password'] = $this->ci->session->userdata('password');
		$db['database'] = $this->ci->session->userdata('database');
		$db['port'] 	= $this->ci->session->userdata('port');
		$db['dbdriver'] = "mysql";
		$db['dbprefix'] = 'default_';
		$db['pconnect'] = false;
		$db['db_debug'] = true;
		$db['cache_on'] = false;
		$db['cachedir'] = "";
		$db['char_set'] = "utf8";
		$db['dbcollat'] = "utf8_unicode_ci";

		$this->ci->load->database($db);
		$this->ci->load->helper('file');

		// create the site specific addon folder
		is_dir(ADDONPATH.'modules') OR mkdir(ADDONPATH.'modules', DIR_READ_MODE, true);
		is_dir(ADDONPATH.'themes') OR mkdir(ADDONPATH.'themes', DIR_READ_MODE, true);
		is_dir(ADDONPATH.'widgets') OR mkdir(ADDONPATH.'widgets', DIR_READ_MODE, true);
		is_dir(ADDONPATH.'field_types') OR mkdir(ADDONPATH.'field_types', DIR_READ_MODE, true);

		// create the site specific upload folder
		is_dir(dirname(FCPATH).'/uploads/default') OR mkdir(dirname(FCPATH).'/uploads/default', DIR_WRITE_MODE, true);

		//insert empty html files
		write_file(ADDONPATH.'modules/index.html', '');
		write_file(ADDONPATH.'themes/index.html', '');
		write_file(ADDONPATH.'widgets/index.html', '');
		write_file(ADDONPATH.'field_types/index.html', '');
		write_file(PYROPATH.'uploads/index.html', '');
		write_file(ADDONPATH.'uploads/default/index.html', '');
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
		if (!$details_class->install())
		{
			return false;
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
			'skip_xss' => ! empty($module['skip_xss']),
			'is_frontend' => ! empty($module['frontend']),
			'is_backend' => ! empty($module['backend']),
			'menu' => ( ! empty($module['menu'])) ? $module['menu'] : false,
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
			CREATE TABLE IF NOT EXISTS ".$this->ci->db->dbprefix('modules')." (
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
			  `updated_on` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`),
			  INDEX `enabled` (`enabled`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		//create the modules table so that we can import all modules including the modules module
		$this->ci->db->query($modules);

		$session = "
			CREATE TABLE IF NOT EXISTS ".$this->ci->db->dbprefix(str_replace('default_', '', config_item('sess_table_name')))." (
			 `session_id` varchar(40) DEFAULT '0' NOT NULL,
			 `ip_address` varchar(45) DEFAULT '0' NOT NULL,
			 `user_agent` varchar(120) NOT NULL,
			 `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
			 `user_data` text NULL,
			PRIMARY KEY (`session_id`),
			KEY `last_activity_idx` (`last_activity`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		// create a session table so they can use it if they want
		$this->ci->db->query($session);

		// In case we are re-installing with existing data,
		// we'll need to make sure that these tables aren't here.
		$this->ci->dbforge->drop_table('data_streams');
		$this->ci->dbforge->drop_table('data_fields');
		$this->ci->dbforge->drop_table('data_field_assignments');

		// Install settings and streams core first. Other modules may need them.
		$this->install('settings', true);
		$this->ci->load->library('settings/settings');
		$this->install('streams_core', true);

		// Are there any modules to install on this path?
		if ($modules = glob(PYROPATH.'modules/*', GLOB_ONLYDIR))
		{
			// Loop through modules
			foreach ($modules as $module_name)
			{
				$slug = basename($module_name);

				if ($slug == 'streams_core' or $slug == 'settings')
				{
					continue;
				}

				// invalid details class?
				if ( ! $details_class = $this->_spawn_class($slug, true))
				{
					continue;
				}

				$this->install($slug, true);
			}
		}

		// After modules are imported we need to modify the settings table
		// This allows regular admins to upload addons on the first install but not on multi
		$this->ci->db
			->where('slug', 'addons_upload')
			->update('settings', array('value' => '1'));

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
	 * @return    array
	 */
	private function _spawn_class($slug, $is_core = false)
	{
		$path = $is_core ? PYROPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = $path.'modules/'.$slug.'/details'.EXT;

		// If it didn't exist as a core module or an addon then check shared_addons
		if ( ! is_file($details_file))
		{
			$details_file = SHARED_ADDONPATH.'modules/'.$slug.'/details'.EXT;

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
		return class_exists($class) ? new $class : false;
	}
}
