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
	 * @todo Document this... I don't have any idea of what is the purpose?
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