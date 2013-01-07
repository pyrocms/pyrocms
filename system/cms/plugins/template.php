<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Template Plugin
 *
 * Display theme templates
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Template extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Template',
	);
	public $description = array(
		'en' => 'Access and set theme settings and properties.',
		'el' => 'Πρόσβαση και αλλαγή ρυθμίσεων και ιδιοτήτων του θέματος εμφάνισης.',
		'fr' => 'Accéder aux paramètres et propriétés du thème.',
		'it' => 'Accedi e imposta le impostazioni e le proprietà del tema'
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
	 * Set Template Title
	 *
	 * Set your own custom page titles from within page content.
	 * Separate multiple segments with a comma
	 *
	 * Usage:
	 *
	 *     {{ template:set_title value="My Custom Page Title, Another Segment" }}
	 *
	 * @return void
	 */
	public function set_title()
	{
		$value = $this->attribute('value');

		call_user_func_array(array($this->template, 'title'), explode(',', $value));
	}

	/**
	 * Set Metadata
	 *
	 * Metadata can be set from inside page content.
	 * If meta info with the same name exists it will be replaced
	 *
	 * Usage:
	 *
	 *     {{ template:set_metadata name="description" value="My Description" type="meta" }}
	 *
	 * @return void
	 */
	public function set_metadata()
	{
		$name  = $this->attribute('name');
		$value = $this->attribute('value');
		$type  = $this->attribute('type', 'meta');

		$this->template->set_metadata($name, $value, $type);
	}

	/**
	 * Set Breadcrumb
	 *
	 * Breadcrumbs can be overridden by using this tag inside page content
	 *
	 * Usage:
	 *
	 *     {{ template:set_breadcrumb name="My Page" uri="some-page" reset="true" }}
	 *
	 * @return void
	 */
	public function set_breadcrumb()
	{
		$name  = $this->attribute('name');
		$uri   = $this->attribute('uri');
		$reset = str_to_bool($this->attribute('reset', false));

		$this->template->set_breadcrumb($name, $uri, $reset);
	}

	/**
	 * Loads a template partial
	 *
	 * Usage:
	 *
	 *     {{ template:partial name="sidebar" }}
	 *
	 * @return string The contents of the partial view.
	 */
	public function partial()
	{
		$name = $this->attribute('name');

		$data = & $this->load->_ci_cached_vars;

		return isset($data['template']['partials'][$name]) ? $data['template']['partials'][$name] : '';
	}

	/**
	 * Checks for existence of a partial
	 *
	 * Usage:
	 *
	 *     {{ template:has_partial name="sidebar" }}
	 *         <h2>Sidebar</h2>
	 *         {{ template:partial name="sidebar" }}
	 *     {{ /template:has_partial }}
	 *
	 * @return array|string|boolean
	 */
	public function has_partial()
	{
		$name = $this->attribute('name');

		$data = & $this->load->_ci_cached_vars;

		if (isset($data['template']['partials'][$name]))
		{
			return $this->content() ? array(array('partial' => $data['template']['partials'][$name])) : true;
		}

		return $this->content() ? array() : '';
	}

	/**
	 * Check for the existence of breadcrumbs
	 *
	 * Usage:
	 *
	 *     {{ if {template:has_breadcrumbs} }}
	 *         {{ template:breadcrumbs }}
	 *             {{ if uri }}
	 *                 {{ url:anchor segments='{{ uri }}' title='{{ name }}' }}
	 *             {{ else }}
	 *                 {{ name }}
	 *             {{ /if }}
	 *         {{ /template:breadcrumbs }}
	 *     {{ /if }}
	 *
	 * @return boolean
	 */
	public function has_breadcrumbs()
	{
		$data = & $this->load->_ci_cached_vars;

		$crumbs = $data['template']['breadcrumbs'];

		return !empty($crumbs);
	}

	/**
	 * Get the meta tags of the page, in a string.
	 *
	 * @return string|null The string for the meta tags.
	 */
	public function metadata()
	{
		return $this->template->get_metadata($this->attribute('in', 'header'));
	}

	/**
	 * Return template variables
	 *
	 * Example:
	 *
	 *     {{ template:title }}
	 *
	 * @param type $foo
	 * @param type $arguments
	 *
	 * @return type
	 */
	public function __call($foo, $arguments)
	{
		$data = & $this->load->_ci_cached_vars;

		return isset($data['template'][$foo]) ? $data['template'][$foo] : null;
	}

}