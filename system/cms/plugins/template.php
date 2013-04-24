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
            'fa' => 'دسترسی و ست کردن تنظیمات',
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
			'breadcrumbs' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Loop through the breadcrumbs and output them as links.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'name|uri',
				'attributes' => array(),
			),// end breadcrumbs method
			'set_breadcrumb' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Add a segment to the breadcrumb trail. If [reset] is used all breadcrumbs will be cleared first.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'uri' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'reset' => array(
						'type' => 'flag',
						'flags' => 'Y|N',
						'default' => 'N',
						'required' => false,
					),
				),
			),// end set_breadcrumb method
			'has_breadcrumbs' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Check if any breadcrumbs exist.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
			),// end has_breadcrumbs method
			'title' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output the template title.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
			),// end title method
			'set_title' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Set the template title from within your content.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'value' => array(
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end title method
			'metadata' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output the compiled metadata set by any and all controllers.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
			),// end metadata method
			'set_metadata' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Set metadata by name/value pairs.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'value' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'type' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'meta',
						'required' => false,
					),
				),
			),// end set_metadata method
			'partial' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output a template partial set in a controller. Note that a theme partial different.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end partial method
			'has_partial' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Check if a template partial has been set.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end has_partial method
			'body' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output the completed template. This is the final output.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
			),// end body method
		);

		return $info;
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

		call_user_func_array(array($this->template, 'override_title'), explode(',', $value));
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
		$place = $this->attribute('place', 'header');
		$type  = $this->attribute('type', 'meta');

		// We are going to set the metadata with the fifth parameter to true,
		// meaning that if this conflicts with a previously set value,
		// it will override it.
		$this->template->set_metadata($name, $value, $type, $place, true);
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

		$this->template->set_breadcrumb($name, $uri, $reset, true);
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