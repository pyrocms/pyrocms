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
		$data = array();

		$this->load->language('addons');

		$this->load->helper('directory');

		include APPPATH.'libraries/Plugins.php';

		// Get our core plugins
		$data['core_plugins'] = $this->_gather_plugin_info(APPPATH);

		$data['plugins'] = array();

		// Find all the plugins available.
		foreach (array(ADDONPATH, SHARED_ADDONPATH) as $directory)
		{
			$data['plugins'] = array_merge($data['plugins'], $this->_gather_plugin_info($directory));
		}

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/plugins/index', $data);
	}

	private function _gather_plugin_info($dir_path)
	{
		// Look for the plugins [age]
		$full_dir = $dir_path.'plugins/';

		// Get our files
		$files = directory_map($full_dir, 1);

		if (!$files)
		{
			return array();
		}

		$plugins = array();
		// Go through and load up some info about our plugin files.
		foreach ($files as $file)
		{
			$info = pathinfo($full_dir.$file);

			if ($info['extension'] == 'php')
			{
				include $full_dir.$file;

				$class_name = 'Plugin_'.ucfirst($info['filename']);

				if (class_exists($class_name))
				{
					$plugin = new $class_name();
					array_push($plugins, array(
						'name' => (isset($plugin->name[CURRENT_LANGUAGE])) ? $plugin->name[CURRENT_LANGUAGE] : (isset($plugin->name[CURRENT_LANGUAGE])) ? $plugin->name[CURRENT_LANGUAGE] : ((isset($plugin->name['en'])) ? $plugin->name['en'] : ucfirst($info['filename'])),
						'description' => (isset($plugin->description[CURRENT_LANGUAGE])) ? $plugin->description[CURRENT_LANGUAGE] : null,
						'version' => (isset($plugin->version)) ? $plugin->version : null,
					));

				}
			}

		}

		return $plugins;
	}

}
