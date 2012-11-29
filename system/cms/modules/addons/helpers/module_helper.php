<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * Modules helper gives you lots of handy functions to use with your modules
 *
 * @author 		Philip Sturgeon
 * @modified	Dan Horrigan
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Modules\Helpers
 */

/**
 * Returns the module directories.
 *
 * @return	array
 */
function module_directories()
{
	return array_keys(Modules::$locations);
}

/**
 * Module Array
 *
 * Returns an array of modules
 *
 * @return	array
 */
function module_array()
{
	$ci =& get_instance();

	$modules = $ci->module_m->get_all();
	asort($modules);

	return $modules;
}


/**
 * Module Exists
 *
 * Returns true/false if the module exists
 *
 * @param	string	$slug		The name of the module we are testing
 * @return	string
 */

function module_exists($slug = '')
{
	// Start looking
	$ci =& get_instance();

	return $ci->module_m->exists($slug);
}


/**
 * Module Enabled
 *
 * Returns true/false if the module is enabled
 *
 * @param	string	$slug		The name of the module we are testing
 * @return	bool
 */

function module_enabled($slug = '')
{
	// Start looking
	$ci =& get_instance();

	return $ci->module_m->enabled($slug);
}


/**
 * Module Installed
 *
 * Returns true/false if the module is installed
 *
 * @param	string	$slug		The name of the module we are testing
 * @return bool
 */

function module_installed($slug = '')
{
	// Start looking
	$ci =& get_instance();

	return $ci->module_m->installed($slug);
}


/**
 * Module Controller
 *
 * Returns true/false if the module has a controller with the name given
 *
 * @param	string	$controller		The name of the controller we are testing
 * @param	string	$module			The name of the module we are testing
 * @return	string
 */
function module_controller($controller, $module)
{
	if(!$controller)
	{
		return false;
	}

	$ci =& get_instance();

	$controllers = $ci->module_m->get_module_controllers($module);

	return isset($controllers[$controller]);
}

// will that your place is here? or maybe should it exists?
// if yes.. help to document it.. else.. move it, delete, etc, you can do best..
function reload_module_details($slug = '')
{
	if ( ! $slug)
	{
		return false;
	}

	if (is_array($slug))
	{
		foreach ($slug as $_slug)
		{
			if ( ! reload_module_details($_slug))
			{
				return false;
			}
		}
		return true;
	}

	$ci =& get_instance();

	// Loop through directories that hold modules
	$is_core = true;

	foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) as $directory)
	{
		// Loop through modules
		foreach (glob($directory.'modules/*', GLOB_ONLYDIR) as $module_name)
		{
			$slug = basename($module_name);

			//$this->_output .=  'Re-indexing new module: <strong>' . $slug .'</strong>.<br/>';

			// Before we can install anything we need to know some details about the module
			$details_file = $directory . 'modules/' . $slug . '/details'.EXT;

			// Check the details file exists
			if ( ! is_file($details_file))
			{
				$details_file = SHARED_ADDONPATH . 'modules/' . $slug . '/details'.EXT;
				
				if ( ! is_file($details_file))
				{
					//$this->_output .= '<span style="color:red">Error with <strong>' . $slug .'</strong>: File '.$details_file.' does not exist.</span><br/>';
					continue;
				}
			}

			// Sweet, include the file
			include_once $details_file;

			// Now call the details class
			$class_name = 'Module_'.ucfirst(strtolower($slug));

			if ( ! class_exists($class_name))
			{
				//$this->_output .= '<span style="color:red">Error with <strong>' . $slug .'</strong>: Class '.$class_name.' does not exist in file '.$details_file.'.</span><br/>';
				continue;
			}

			$details_class = new $class_name;

			// Get some basic info
			$module = $details_class->info();

			// Looks like it installed ok, add a record
			$ci->db->where('slug', $slug)->update('modules', array(
				'name'				=> serialize($module['name']),
				'slug'				=> $slug,
				'version'			=> $details_class->version,
				'description'		=> serialize($module['description']),
				'skip_xss'			=> ! empty($module['skip_xss']),
				'is_frontend'		=> ! empty($module['frontend']),
				'is_backend'		=> ! empty($module['backend']),
				'menu'				=> ! empty($module['menu']) ? $module['menu'] : false,
				'enabled'			=> true,
				'installed'			=> true,
				'is_core'			=> $is_core
			));
		}

		// Going back around, 2nd time is addons
		$is_core = false;
	}

	return true;
}