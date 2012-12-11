<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Url extends Plugin
{

	public $version = '1.0';
	public $name = array(
		'en' => 'URL',
	);
	public $description = array(
		'en' => 'Access URL variables, segments, and more.',
		'el' => 'Πρόσβαση σε μεταβλητές που βρήσκονται σε URL, τμήματα URL και αλλού.',
		'fr' => 'Accéder aux informations sur une URL (URL courante, segments, ancres, etc.).'
	);

	/**
	 * Current uri string
	 *
	 * Usage:
	 *
	 *     {{ url:current }}
	 *
	 * @return string The current URI string.
	 */
	public function current()
	{
		return site_url($this->uri->uri_string());
	}

	/**
	 * Current uri string
	 *
	 * Usage:
	 *
	 *     {{ url:get key="foo" }}
	 *
	 * @return string The key of the item in $_GET
	 */
	public function get()
	{
		return $this->input->get($this->attribute('key'));
	}

	/**
	 * Site URL of the installation.
	 *
	 * Usage:
	 *
	 *     {{ url:site }}
	 *
	 * @return string Site URL of the install.
	 */
	public function site()
	{
		$uri = $this->attribute('uri');

		return $uri ? site_url($uri) : rtrim(site_url(), '/') . '/';
	}

	/**
	 * Base URL of the installation.
	 *
	 * Usage:
	 *
	 *     {{ url:base }}
	 *
	 * @return string The base URL for the installation.
	 */
	public function base()
	{
		return base_url();
	}

	/**
	 * Get URI segment.
	 *
	 * Usage:
	 *
	 *     {{ url:segments segment="1" default="home" }}
	 *
	 * @return string The URI segment, or the provided default.
	 */
	public function segments()
	{
		$default = $this->attribute('default');
		$segment = $this->attribute('segment');

		return $this->uri->segment($segment, $default);
	}

	/**
	 * Build an anchor tag
	 *
	 * Usage:
	 *
	 *     {{ url:anchor segments="users/login" title="Login" class="login" }}
	 *
	 * @return string The anchor HTML tag.
	 */
	public function anchor()
	{
		$segments = $this->attribute('segments');
		$title = $this->attribute('title', '');
		$class = $this->attribute('class', '');

		$class = !empty($class) ? 'class="' . $class . '"' : '';

		return anchor($segments, $title, $class);
	}

	/**
	 * Test if the current protocol is SSL or not (https)
	 *
	 * Usage:
	 *
	 *     {{ if url:is_ssl }} Yep {{ else }} Nope {{ endif }}
	 *
	 * @return bool
	 */
	function is_ssl()
	{
		return (isset($_SERVER['HTTPS']) ? ($_SERVER['HTTPS'] == "on" ? true : false) : false);
	}

}