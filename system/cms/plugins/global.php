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
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
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