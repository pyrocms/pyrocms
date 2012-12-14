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

	public $version = '1.0';
	public $name = array(
		'en' => 'Global',
	);
	public $description = array(
		'en' => 'Access global variables.',
		'el' => 'Πρόσβαση σε οικουμενικές μεταβλητές.',
		'fr' => 'Accéder à des variables globales.'
	);

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