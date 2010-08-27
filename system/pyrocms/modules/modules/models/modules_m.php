<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modules model
 *
 * @author 		PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Modules
 * @category	Modules
 * @since 		v0.9.7
 */
class Modules_m extends CI_Model
{
	private $_table = 'modules';
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
			'is_backend_menu' => NULL,
			'enabled' => 1,
			'is_core' => NULL
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

			$descriptions = unserialize($result->description);
			$description = isset($descriptions[CURRENT_LANGUAGE]) ? $descriptions[CURRENT_LANGUAGE] : $descriptions['en'];

			$names = unserialize($result->name);
			$name = isset($names[CURRENT_LANGUAGE]) ? $names[CURRENT_LANGUAGE] : $names['en'];

			return array(
				'name' => $name,
				'slug' => $result->slug,
				'version' => $result->version,
				'description' => $description,
				'skip_xss' => $result->skip_xss,
				'is_frontend' => $result->is_frontend,
				'is_backend' => $result->is_backend,
				'is_backend_menu' => $result->is_backend_menu,
				'enabled' => $result->enabled,
				'is_core' => $result->is_core
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
			'name' => serialize($module['name']),
			'slug' => $module['slug'],
			'version' => $module['version'],
			'description' => serialize($module['description']),
			'skip_xss' => !empty($module['skip_xss']),
			'is_frontend' => !empty($module['frontend']),
			'is_backend' => !empty($module['backend']),
			'is_backend_menu' => !empty($module['menu']),
			'enabled' => $module['enabled'],
			'controllers' => '',
			'is_core' => $module['is_core']
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
	 * @param	array	$module_slug	The module slug
	 * @access	public
	 * @return	object
	 */
	public function delete($module_slug)
	{
		return $this->db->delete($this->_table, array('slug' => $module_slug));
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
		if ($params) foreach($params as $field => $value)
		{
			if (in_array($field, array('is_frontend', 'is_backend', 'is_backend_menu', 'is_core')))
			$this->db->where($field, $value);
		}

		// Skip the disabled modules
		if ($return_disabled === FALSE)
		{
			$this->db->where('enabled', 1);
		}

		foreach ($this->db->get($this->_table)->result() as $result)
		{
			$descriptions = unserialize($result->description);
			$description = !isset($descriptions[CURRENT_LANGUAGE]) ? $descriptions['en'] : $descriptions[CURRENT_LANGUAGE];

			$names = unserialize($result->name);
			$name = !isset($names[CURRENT_LANGUAGE]) ? $names['en'] : $names[CURRENT_LANGUAGE];

			$module = array(
				'name' => $name,
				'slug' => $result->slug,
				'version' => $result->version,
				'description' => $description,
				'skip_xss' => $result->skip_xss,
				'is_frontend' => $result->is_frontend,
				'is_backend' => $result->is_backend,
				'is_backend_menu' => $result->is_backend_menu,
				'enabled' => $result->enabled,
				'is_core' => $result->is_core
			);

			if (!empty($params['is_backend']))
			{
				// This user has no permissions for this module
				if (!$this->permissions_m->has_admin_access($this->user->group_id, $module['slug']))
				{
					continue;
				}
			}

			$modules[] = $module;
		}

		return $modules;
	}

	/**
	 * Get Module Controllers
	 *
	 * Gets the controller of the specified module
	 *
	 * @param	string	$module		The name of the module
	 * @access	public
	 * @return	array
	 */
	function get_module_controllers($module = '')
	{
		$module = $this->get($module);

		if (is_array($module['controllers']))
		{
			return array_keys($module['controllers']);
		}

		return array();
	}

	/**
	 * Get Module Controller Methods
	 *
	 * Get the methods of the specified module/controller combination
	 *
	 * @access public
	 * @return mixed
	 */
	public function get_module_controller_methods($module, $controller)
	{
		$module = $this->get($module);

		return !empty($module['controllers'][$controller]['methods']) ? $module['controllers'][$controller]['methods'] : array();
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

		if(!$module)
		{
			return FALSE;
		}

		// We already know about this module
		if(isset($this->_module_exists[$module]))
		{
			return $this->_module_exists[$module];
		}

		$query = $this->db->get_where($this->_table, array('slug' => $module), 1);

		return $this->_module_exists[$module] = ($query->num_rows() > 0);
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
	public function install($slug, $is_core = FALSE)
	{
		$details_class = $this->_spawn_class($slug, $is_core);

		// Get some basic info
		$module = $details_class->info();

		// Now lets set some details ourselves
		$module['version'] = $details_class->version;
		$module['is_core'] = $is_core;
		$module['enabled'] = TRUE;
		$module['slug'] = $slug;

		$module['controllers'] = array();

		// Run the install method to get it into the database
		if ( ! $details_class->install())
		{
			return FALSE;
		}

		// Looks like it installed ok, add a record
		return $this->add($module);
	}

	/**
	 * Uninstall
	 *
	 * Unnstalls a module
	 *
	 * @param	string	$module	The module slug
	 * @return	bool
	 */
	public function uninstall($module_slug)
	{
		$details_class = $this->_spawn_class($slug);

		// Run the uninstall method to get it into the database
		if ( ! $details_class->uninstall())
		{
			return FALSE;
		}

		return $this->delete($module_slug);
	}


	public function import_all()
    {
    	$modules = array();
		
		$this->db->empty_table($this->_table);

    	// Loop through directories that hold modules
    	foreach (array(APPPATH, ADDONPATH) as $directory)
    	{
			$is_core = $directory == APPPATH;

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
		$path = $is_core ? APPPATH : ADDONPATH;

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
		$class = ucfirst($module_slug).'_details';

		// Now we need to talk to it
		return new $class;
	}

}