<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 * 
 * @package 	PyroCMS\Core\Modules\Addons\Controllers
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 *
 */
class Admin_plugins extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'instances';

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index method, lists all plugins.
	 * 
	 * @return void
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
			->build('admin/list_plugins', $data);
	}

	private function _gather_plugin_info($dir_path)
	{
		// Look for the plugins [age]
		$full_dir = $dir_path.'plugins/';

		// Get our files
		$files = directory_map($full_dir, 1);

		if( ! $files) continue;

		$count = 0;

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

					$plugins[$count]['name'] = (isset($plugin->name[CURRENT_LANGUAGE])) ? $plugin->name[CURRENT_LANGUAGE] : ucfirst($info['filename']);
					$plugins[$count]['description'] = (isset($plugin->description[CURRENT_LANGUAGE])) ? $plugin->description[CURRENT_LANGUAGE] : null;
					$plugins[$count]['version'] = (isset($plugin->version)) ? $plugin->version : null;

				}
			}

			$count++;
		}
	
		return $plugins;
	}

}
