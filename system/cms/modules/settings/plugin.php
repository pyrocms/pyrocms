<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Settings Plugin
 *
 * Allows settings to be used in content tags.
 *
 * @author        PyroCMS Dev Team
 * @package        PyroCMS\Core\Modules\Settings\Plugins
 */
class Plugin_Settings extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Settings',
	);
	public $description = array(
		'en' => 'Retrieve a setting from the database.',
	);

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
		return $this->settings->get($name);
	}
}