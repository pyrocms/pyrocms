<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * URI Plugin
 *
 * {{ uri:segment_1 }} type stuff
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Plugins
 */
class Plugin_Uri extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'URI',
	);
	public $description = array(
		'en' => 'Access URI parameters.',
	);

	/**
	 * Load a variable
	 *
	 * Magic method to get the variable.
	 *
	 * @param string $name
	 * @param string $arguments
	 * @return string
	 */
	public function __call($name, $arguments)
	{
		return ci()->uri->segment(str_replace('segment_', '', $name));
	}
}
