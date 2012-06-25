<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Plugin
 *
 * Display theme templates
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Template extends Plugin
{

	/**
	 * Set Template Title
	 *
	 * Set your own custom page titles from within page content. 
	 * Separate multiple segments with a comma
	 *
	 * Usage:
	 *   {{ template:set_title value="My Custom Page Title, Another Segment" }}
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
	 * Metadata can be set from inside page content. If meta info 
	 * with the same name exists it will be replaced
	 *
	 * Usage:
	 *   {{ template:set_metadata name="description" value="My Description" type="meta" }}
	 *
	 * @return void
	 */
	public function set_metadata()
	{
		$name 	= $this->attribute('name');
		$value 	= $this->attribute('value');
		$type 	= $this->attribute('type', 'meta');

		$this->template->set_metadata($name, $value, $type);
	}

	/**
	 * Set Breadcrumb
	 *
	 * Breadcrumbs can be overridden by using this tag inside page content
	 *
	 * Usage:
	 *   {{ template:set_breadcrumb name="My Page" uri="some-page" reset="true" }}
	 *
	 * @return void
	 */
	public function set_breadcrumb()
	{
		$name 	= $this->attribute('name');
		$uri 	= $this->attribute('uri');
		$reset	= (strtolower($this->attribute('reset')) === 'true') ? TRUE : FALSE;

		$this->template->set_breadcrumb($name, $uri, $reset);
	}

	/**
	 * Data
	 *
	 * Loads a template partial
	 *
	 * Usage:
	 *   {{ template:partial name="sidebar" }}
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
	 * Checks for existance of a partial
	 *
	 * Usage:
	 * {{ template:has_partial name="sidebar" }}
	 *   <h2>Sidebar</h2>
	 *   {{ template:partial name="sidebar" }}
	 * {{ /template:has_partial }}
	 *
	 * @return array|string|boolean 
	 */
	public function has_partial()
	{
		$name = $this->attribute('name');

		$data = & $this->load->_ci_cached_vars;

		if (isset($data['template']['partials'][$name]))
		{
			return $this->content() ? array(array('partial' => $data['template']['partials'][$name])) : TRUE;
		}

		return $this->content() ? array() : '';
	}

	/**
	 * Check for the existance of breadcrumbs
	 *
	 * Usage:
	 * {{ if {template:has_breadcrumbs} }}
	 * 	{{ template:breadcrumbs }}
	 * 		{{ if uri }}
	 * 			{{ url:anchor segments='{{ uri }}' title='{{ name }}' }}
	 * 		{{ else }}
	 * 			{{ name }}
	 * 		{{ /if }}
	 * 	{{ /template:breadcrumbs }}
	 * {{ /if }}
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
	 * Example: {{ template:title }}
	 * 
	 * @param type $foo
	 * @param type $arguments
	 * @return type 
	 */
	public function __call($foo, $arguments)
	{
		$data = & $this->load->_ci_cached_vars;

		return isset($data['template'][$foo]) ? $data['template'][$foo] : NULL;
	}

}