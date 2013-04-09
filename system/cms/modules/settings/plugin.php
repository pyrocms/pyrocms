<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Settings Plugin
 *
 * Allows settings to be used in content tags.
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Settings\Plugins
 */
class Plugin_Settings extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Settings',
            'fa' => 'تنظیمات',
	);
	public $description = array(
		'en' => 'Retrieve a setting from the database.',
            'fa' => 'دریافت تنظیمات سایت از دیتابیس',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array();

		// dynamically build the array for the magic method __call
		$settings = Settings::get_all();
		ksort($settings);

		foreach ($settings as $slug => $value)
		{
			$info[$slug]['description'] = array(
				'en' => 'Retrieve the value for setting '.$slug.'.'
			);
			$info[$slug]['single'] = true;
			$info[$slug]['double'] = false;
			$info[$slug]['variables'] = '';
			$info[$slug]['params'] = array();
		}

		return $info;
	}

	/**
	 * Load a variable
	 *
	 * Magic method to get the setting.
	 *
	 * @param string $name
	 * @param array $data
	 *
	 * @return string
	 */
	public function __call($name, $data)
	{
		return Settings::get($name);
	}
}