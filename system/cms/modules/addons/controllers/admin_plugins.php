<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package   PyroCMS\Core\Modules\Addons\Controllers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */
class Admin_plugins extends Admin_Controller
{

	/** @var string The current active section */
	protected $section = 'plugins';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index method
	 * 
	 * Lists all plugins.
	 */
	public function index()
	{
		$data = array('plugins' => array(), 'core_plugins' => array());

		$this->load->language('addons');

		$this->load->helper('directory');

		$this->load->library('plugins');

		$is_core = true;
		// Find all the plugins available.
		foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) as $directory)
		{
			$index = $is_core ? 'core_plugins' : 'plugins';
			$data[$index] = array_merge($data[$index], $this->_gather_plugin_info($directory.'modules/*/plugin.php'));
			$data[$index] = array_merge($data[$index], $this->_gather_plugin_info($directory.'plugins/*.php'));

			$is_core = false;
		}

		sort($data['core_plugins']);
		sort($data['plugins']);

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/plugins/index', $data);
	}

	private function _gather_plugin_info($path)
	{
		if ( ! $files = glob($path))
		{
			return array();
		}

		$plugins = array();
		// Go through and load up some info about our plugin files.
		foreach ($files as $file)
		{
			$module_path = false;

			$tmp         = explode('/', $file);
			$file_name   = array_pop($tmp);

			// work out the filename
			$file_parts = explode('.', $file_name);
			array_pop($file_parts);
			$file_name = implode('.', $file_parts);

			// it's in a module, we have to use the module slug
			if ($file_name === 'plugin')
			{
				$module_path = dirname($file);
				$tmp         = explode('/', $module_path);
				$module      = array_pop($tmp);
				$class_name  = 'Plugin_'.ucfirst($module);
				$slug        = $module;

				// add the package path so $this->load will work in the plugin
				$this->load->add_package_path($module_path);
			}
			else
			{
				$class_name = 'Plugin_'.ucfirst($file_name);
				$slug = $file_name;
			}

			include_once $file;

			if (class_exists($class_name))
			{
				$plugin = new $class_name();
				array_push($plugins, array(
					'name' => (isset($plugin->name[CURRENT_LANGUAGE])) ? $plugin->name[CURRENT_LANGUAGE] : (isset($plugin->name[CURRENT_LANGUAGE])) ? $plugin->name[CURRENT_LANGUAGE] : ((isset($plugin->name['en'])) ? $plugin->name['en'] : ucfirst($file_name)),
					'slug' => $slug,
					'description' => (isset($plugin->description[CURRENT_LANGUAGE])) ? $plugin->description[CURRENT_LANGUAGE] : null,
					'version' => (isset($plugin->version)) ? $plugin->version : null,
					'self_doc' => (method_exists($plugin, '_self_doc') ? $plugin->_self_doc() : array()),
				));

			}

			if ($module_path)
			{
				$this->load->remove_package_path($module_path);
			}
		}

		return $plugins;
	}

}
