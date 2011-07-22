<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modules model
 *
 * @author 		PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Modules
 * @category	Modules
 * @since 		v1.0
 */
class Module_m extends MY_Model
{
	protected $_table = 'modules';
	private $_module_exists = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('modules/module');
	}

	/**
	 * Get
	 *
	 * Return an array containing module data
	 *
	 * @access	public
	 * @param	string	$module		The name of the module to load
	 * @return	array
	 */
	public function get($module = '')
	{
		// Have to return an associative array of NULL values for backwards compatibility.
		$null_array = array(
			'name' => NULL,
			'slug' => NULL,
			'version' => NULL,
			'description' => NULL,
			'skip_xss' => NULL,
			'is_frontend' => NULL,
			'is_backend' => NULL,
			'menu' => FALSE,
			'enabled' => 1,
			'is_core' => NULL,
			'is_current' => NULL
		);

		if (is_array($module) || empty($module))
		{
			return $null_array;
		}

		$result = $this->db
			->where('slug', $module)
			->get($this->_table)
			->row();

		if ($result)
		{
			// Return FALSE if the module is disabled
			if ($result->enabled == 0)
			{
				return FALSE;
			}

			if ( ! $descriptions = unserialize($result->description))
			{
				$this->session->set_flashdata('error', sprintf(lang('modules.details_error'), $result->slug));
			}
			$description = !isset($descriptions[CURRENT_LANGUAGE]) ? $descriptions['en'] : $descriptions[CURRENT_LANGUAGE];

			if ( ! $names = unserialize($result->name))
			{
				$this->session->set_flashdata('error', sprintf(lang('modules.details_error'), $result->slug));
			}
			$name = !isset($names[CURRENT_LANGUAGE]) ? $names['en'] : $names[CURRENT_LANGUAGE];

			return array(
				'name' => $name,
				'slug' => $result->slug,
				'version' => $result->version,
				'description' => $description,
				'skip_xss' => $result->skip_xss,
				'is_frontend' => $result->is_frontend,
				'is_backend' => $result->is_backend,
				'menu' => $result->menu,
				'enabled' => $result->enabled,
				'is_core' => $result->is_core,
				'is_current' => version_compare($result->version, $this->version($result->slug),  '>=')
			);
		}

		return $null_array;
	}

	/**
	 * Add
	 *
	 * Adds a module to the database
	 *
	 * @access	public
	 * @param	array	$module		Information about the module
	 * @return	object
	 */
	public function add($module)
	{
		return $this->db->insert($this->_table, array(
			'name'			=> serialize($module['name']),
			'slug'			=> $module['slug'],
			'version'		=> $module['version'],
			'description'	=> serialize($module['description']),
			'skip_xss'		=> ! empty($module['skip_xss']),
			'is_frontend'	=> ! empty($module['frontend']),
			'is_backend'	=> ! empty($module['backend']),
			'menu'			=> ! empty($module['menu']) ? $module['menu'] : FALSE,
			'enabled'		=> ! empty($module['enabled']),
			'installed'		=> ! empty($module['installed']),
			'is_core'		=> ! empty($module['is_core'])
		));
	}

	/**
	 * Update
	 *
	 * Updates a module in the database
	 *
	 * @access	public
	 * @param	array	$slug		Module slug to update
	 * @param	array	$module		Information about the module
	 * @return	object
	 */
	public function update($slug, $module)
	{
		return $this->db->where('slug', $slug)->update($this->_table, $module);
	}

	/**
	 * Delete
	 *
	 * Delete a module from the database
	 *
	 * @param	array	$slug	The module slug
	 * @access	public
	 * @return	object
	 */
	public function delete($slug)
	{
		return $this->db->delete($this->_table, array('slug' => $slug));
	}

	/**
	 * Get Modules
	 *
	 * Return an array of objects containing module related data
	 *
	 * @param	array	$params				The array containing the modules to load
	 * @param	bool	$return_disabled	Whether to return disabled modules
	 * @access	public
	 * @return	array
	 */
	public function get_all($params = array(), $return_disabled = FALSE)
	{
		$modules = array();

		// We have some parameters for the list of modules we want
		if ($params)
		{
			foreach ($params as $field => $value)
			{
				if (in_array($field, array('is_frontend', 'is_backend', 'menu', 'is_core')))
				{
					$this->db->where($field, $value);
				}
			}
		}

		// Skip the disabled modules
		if ($return_disabled === FALSE)
		{
			$this->db->where('enabled', 1);
		}

		foreach ($this->db->get($this->_table)->result() as $result)
		{
		
			if ( ! $descriptions = @unserialize($result->description))
			{
				$this->session->set_flashdata('error', sprintf(lang('modules.details_error'), $result->slug));
			}
			$description = ! isset($descriptions[CURRENT_LANGUAGE]) ? $descriptions['en'] : $descriptions[CURRENT_LANGUAGE];

			if ( ! $names = @unserialize($result->name))
			{
				$this->session->set_flashdata('error', sprintf(lang('modules.details_error'), $result->slug));
			}

			$name = ! isset($names[CURRENT_LANGUAGE]) ? $names['en'] : $names[CURRENT_LANGUAGE];

			$module = array(
				'name'				=> $name,
				'slug'				=> $result->slug,
				'version'			=> $result->version,
				'description'		=> $description,
				'skip_xss'			=> $result->skip_xss,
				'is_frontend'		=> $result->is_frontend,
				'is_backend'		=> $result->is_backend,
				'menu'				=> $result->menu,
				'enabled'			=> $result->enabled,
				'installed'			=> ! empty($result->installed),
				'is_core'			=> $result->is_core,
				'is_current'		=> version_compare($result->version, $this->version($result->slug),  '>='),
				'current_version'	=> $this->version($result->slug)
			);

			if ( ! empty($params['is_backend']))
			{

				// This user has no permissions for this module
				if ( $this->user->group !== 'admin' AND empty($this->permissions[$result->slug]))
				{
					continue;
				}
			}

			$modules[$module['name']] = $module;
		}

		ksort($modules);

		return array_values($modules);
	}

	/**
	 * Exists
	 *
	 * Checks if a module exists
	 *
	 * @param	string	$module	The module slug
	 * @return	bool
	 */
	public function exists($module)
	{
		$this->_module_exists = array();

		if ( ! $module)
		{
			return FALSE;
		}

		// We already know about this module
		if (isset($this->_module_exists[$module]))
		{
			return $this->_module_exists[$module];
		}

		return $this->_module_exists[$module] = $this->db
			->where('slug', $module)
			->count_all_results($this->_table) > 0;
	}

	/**
	 * Enable
	 *
	 * Enables a module
	 *
	 * @param	string	$module	The module slug
	 * @return	bool
	 */
	public function enable($module)
	{
		if ($this->exists($module))
		{
			$this->db->where('slug', $module)->update($this->_table, array('enabled' => 1));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Disable
	 *
	 * Disables a module
	 *
	 * @param	string	$module	The module slug
	 * @return	bool
	 */
	public function disable($module)
	{
		if ($this->exists($module))
		{
			$this->db->where('slug', $module)->update($this->_table, array('enabled' => 0));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Install
	 *
	 * Installs a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function install($slug, $is_core = FALSE, $insert = FALSE)
	{
		if ( ! $details_class = $this->_spawn_class($slug, $is_core))
		{
			return FALSE;
		}
		
		// They've just finished uploading it so we need to make a record
		if ($insert)
		{
			// Get some info for the db
			$module = $details_class->info();
	
			// Now lets set some details ourselves
			$module['slug']			= $slug;
			$module['version']		= $details_class->version;
			$module['enabled']		= $is_core; // enable if core
			$module['installed']	= $is_core; // install if core
			$module['is_core']		= $is_core; // is core if core
	
			// It's a valid module let's make a record of it
			$this->add($module);
		}

		// TURN ME ON BABY!
		$this->db->where('slug', $slug)->update('modules', array('enabled' => 1, 'installed' => 1));
		
		// set the site_ref and upload_path for third-party devs
		$details_class->site_ref 	= SITE_REF;
		$details_class->upload_path	= 'uploads/'.SITE_REF.'/';

		// Run the install method to get it into the database
		return $details_class->install();
	}

	/**
	 * Uninstall
	 *
	 * Unnstalls a module
	 *
	 * @param	string	$module	The module slug
	 * @return	bool
	 */
	public function uninstall($slug, $is_core = FALSE)
	{
		if ( ! $details_class = $this->_spawn_class($slug, $is_core))
		{
			// the files are missing so let's clean the "modules" table
			return $this->delete($slug);
		}
		
		// set the site_ref and upload_path for third-party devs
		$details_class->site_ref 	= SITE_REF;
		$details_class->upload_path	= 'uploads/'.SITE_REF.'/';

		// Run the uninstall method to drop the module's tables
		if ( ! $details_class->uninstall())
		{
			return FALSE;
		}

		if ($this->delete($slug))
		{
			// Get some info for the db
			$module = $details_class->info();
	
			// Now lets set some details ourselves
			$module['slug']			= $slug;
			$module['version']		= $details_class->version;
			$module['enabled']		= $is_core; // enable if core
			$module['installed']	= $is_core; // install if core
			$module['is_core']		= $is_core; // is core if core
	
			// We record it again here. If they really want to get rid of it they'll use Delete
			return $this->add($module);
		}
		return FALSE;
	}
	
	/**
	 * Upgrade
	 *
	 * Upgrade a module
	 *
	 * @param	string	$module	The module slug
	 * @return	bool
	 */
	public function upgrade($slug)
	{
		// Get info on the new module
		if ( ! $details_class = $this->_spawn_class($slug) )
		{
			return FALSE;
		}
		
		// Get info on the old module
		if ( ! $old_module = $this->get($slug) )
		{
			return FALSE;
		}
		
		// Get the old module version number
		$old_version = $old_module['version'];
		
		// set the site_ref and upload_path for third-party devs
		$details_class->site_ref 	= SITE_REF;
		$details_class->upload_path	= 'uploads/'.SITE_REF.'/';
		
		// Run the update method to get it into the database
		if ($details_class->upgrade($old_version))
		{
			// Update version number
			$this->db->where('slug', $slug)->update('modules', array('version' => $details_class->version));
			
			return TRUE;
		}
		
		// The upgrade failed
		else
		{
			return FALSE;
		}
	}
	
	public function import_unknown()
    {
    	$modules = array();

		$is_core = TRUE;

		$known = $this->get_all(array(), TRUE);
		$known_array = array();

		// Loop through the known array and assign it to a single dimension because
		// in_array can not search a multi array.
		if (is_array($known) && count($known) > 0)
		{
			foreach ($known AS $item)
			{
				$known_array = array_merge(array($item['slug']), $known_array);
			}
		}

		foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) AS $directory)
    	{
			foreach (glob($directory.'modules/*', GLOB_ONLYDIR) as $module_name)
			{
				$slug = basename($module_name);

				// This doesnt have a valid details.php file! :o
				if ( ! $details_class = $this->_spawn_class($slug, $is_core))
				{
					continue;
				}

				// Yeah yeah we know
				if (in_array($slug, $known_array))
				{
					continue;
				}

				// Get some basic info
				$module = $details_class->info();

				// Now lets set some details ourselves
				$module['slug']			= $slug;
				$module['version']		= $details_class->version;
				$module['enabled']		= $is_core; // enable if core
				$module['installed']	= $is_core; // install if core
				$module['is_core']		= $is_core; // is core if core

				// Looks like it installed ok, add a record
				$this->add($module);
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
	 * @param	string	$slug	The folder name of the module
	 * @access	private
	 * @return	array
	 */
	private function _spawn_class($slug, $is_core = FALSE)
	{
		$path = $is_core ? APPPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = $path . 'modules/' . $slug . '/details'.EXT;

		// Check the details file exists
		if ( ! is_file($details_file))
		{
			$details_file = SHARED_ADDONPATH . 'modules/' . $slug . '/details'.EXT;
			
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

	/**
	 * Help
	 *
	 * Retrieves help string from details.php
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function help($slug)
	{
		foreach (array(0, 1) AS $is_core)
    	{
			$path = $is_core ? APPPATH : ADDONPATH;
			$languages = $this->config->item('supported_languages');
			$default = $languages[$this->config->item('default_language')]['folder'];
			
			//first try it as a core module
			if ($details_class = $this->_spawn_class($slug, $is_core))
			{
				// if the file doesn't exist then we first check the shared folder and if it
				// still doesn't exist we show the default help text from the details.php file
				if (file_exists($path . 'modules/' . $slug . '/language/' . $default . '/help_lang.php'))
				{
					$this->lang->load($slug . '/help');

					if (lang('help_body'))
					{
						return lang('help_body');
					}
				}
				elseif (file_exists(SHARED_ADDONPATH . 'modules/' . $slug . '/language/' . $default . '/help_lang.php'))
				{
					$this->lang->load($slug . '/help');

					if (lang('help_body'))
					{
						return lang('help_body');
					}
				}
				else
				{
					return $details_class->help();
				}
			}
		}

		return FALSE;
	}

	/**
	 * Roles
	 *
	 * Retrieves roles for a specific module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function roles($slug)
	{
		foreach (array(0, 1) as $is_core)
    	{
			//first try it as a core module
			if ($details_class = $this->_spawn_class($slug, $is_core))
			{
				$info = $details_class->info();

				if ( ! empty($info['roles']))
				{
					$this->lang->load($slug . '/permission');
					return $info['roles'];
				}
			}
		}

		return array();
	}
	
	/**
	 * Help
	 *
	 * Retrieves version number from details.php
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function version($slug)
	{
		if ($details_class = $this->_spawn_class($slug))
		{
			return $details_class->version;
		}

		return FALSE;
	}

}