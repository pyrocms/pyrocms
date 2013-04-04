<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Global Plugin
 *
 * Make global constants available as tags
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Global extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Global',
	);
	public $description = array(
		'en' => 'Access global variables.',
		'el' => 'Πρόσβαση σε οικουμενικές μεταβλητές.',
            'fa' => 'دسترسی به متغییر های اصلی',
		'fr' => 'Accéder à des variables globales.',
		'it' => 'Accedi a variabili globali',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'environment' => array(
				'description' => array(
					'en' => 'Check the current environment to determine if the site is in development, staging, or production.'
				),
				'single' => true,
			),
			'site_domain' => array(
				'description' => array(
					'en' => 'The current domain that this site is running on.'
				),
				'single' => true,
			),
			'addon_folder' => array(
				'description' => array(
					'en' => 'The name of the addon folder. For a Community site this will always be "default".'
				),
				'single' => true,
			),
			'site_ref' => array(
				'description' => array(
					'en' => 'The name of the site reference slug. For a Community site this will be "default".'
				),
				'single' => true,
			),
			'addonpath' => array(
				'description' => array(
					'en' => 'The dynamic path to the site\'s addon folder. Example: addons/default/'
				),
				'single' => true,
			),
			'shared_addonpath' => array(
				'description' => array(
					'en' => 'The path the the shared addons.'
				),
				'single' => true,
			),
			'apppath' => array(
				'description' => array(
					'en' => 'The application path. Example: system/cms/'
				),
				'single' => true,
			),
			'fcpath' => array(
				'description' => array(
					'en' => 'The server path to the application. Example: /var/www/site/'
				),
				'single' => true,
			),
			'base_url' => array(
				'description' => array(
					'en' => 'The base url without the index.php regardless of mod_rewrite settings.'
				),
				'single' => true,
			),
			'base_uri' => array(
				'description' => array(
					'en' => 'The relative path to the application root.'
				),
				'single' => true,
			),
			'cms_version' => array(
				'description' => array(
					'en' => 'The current software version.'
				),
				'single' => true,
			),
			'cms_edition' => array(
				'description' => array(
					'en' => 'The software edition.'
				),
				'single' => true,
			),
			'cms_date' => array(
				'description' => array(
					'en' => 'The software release date.'
				),
				'single' => true,
			),
			'current_language' => array(
				'description' => array(
					'en' => 'The lang key of the language pack currently in use.'
				),
				'single' => true,
			),
			'admin_theme' => array(
				'description' => array(
					'en' => 'The slug of the admin theme currently in use.'
				),
				'single' => true,
			),
			'module' => array(
				'description' => array(
					'en' => 'The module currently in use.'
				),
				'single' => true,
			),
			'controller' => array(
				'description' => array(
					'en' => 'The controller currently being used to serve the page.'
				),
				'single' => true,
			),
			'method' => array(
				'description' => array(
					'en' => 'The controller\'s method currently in use.'
				),
				'single' => true,
			),
		);

		return $info;
	}

	/**
	 * Load a constant
	 *
	 * Magic method to get a constant or global var
	 *
	 * @param string $name
	 * @param mixed  $data
	 *
	 * @return null|string
	 */
	public function __call($name, $data)
	{
		// A constant
		if (defined(strtoupper($name)))
		{
			return constant(strtoupper($name));
		}

		// A global variable ($this->controller etc)
		if (isset(get_instance()->$name) and is_scalar($this->$name))
		{
			return $this->$name;
		}

		return null;
	}

}