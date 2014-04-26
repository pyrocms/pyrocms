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

	public $version = '1.0.0';
	public $name = array(
		'en' => 'URL',
	);
	public $description = array(
		'en' => 'Access URL variables, segments, and more.',
		'br' => 'Acessa variáveis da URL, segmentos, e mais.',
		'el' => 'Πρόσβαση σε μεταβλητές που βρήσκονται σε URL, τμήματα URL και αλλού.',
            'fa' => 'دسترسی به متغییر ها و سگمت ها و موارد دیگری از URL',
		'fr' => 'Accéder aux informations sur une URL (URL courante, segments, ancres, etc.).',
		'it' => 'Accedi alle variabili URL, ai segmenti e molto altro'
	);

	/**
	 * Returns a PluginDoc array
	 *
	 * Refer to the Blog plugin for full documentation
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'current' => array(
				'description' => array(
					'en' => 'Output the current url.',
					'br' => 'Exibe a URL atual.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
				),
			'uri_string' => array(
				'description' => array(
					'en' => 'Output the current uri string.',
					'br' => 'Exibe a URI string atual.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
				),
			'get' => array(
				'description' => array(
					'en' => 'Retrieve a GET variable from the url.',
					'br' => 'Recupera uma variável GET da URL.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'key' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
						),
					),
				),
			'site' => array(
				'description' => array(
					'en' => 'Display the site url of this installation with or without the index.php (depending on url rewrite settings).',
					'br' => 'Exibe a URL do site desta instalação com ou sem o "index.php" (dependendo das configurações de url_rewrite).'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'uri' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					),
				),
			'base' => array(
				'description' => array(
					'en' => 'Display the base url of the installation without the index.php.',
					'br' => 'Exibe a URL base da instalação sem o "index.php".'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
				),
			'segments' => array(
				'description' => array(
					'en' => 'Return the specified segments from the url.',
					'br' => 'Retorna os segmentos especificos da URL.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'segment' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
						),
					'default' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					),
				),
			'anchor' => array(
				'description' => array(
					'en' => 'Build an anchor tag with the url segments you pass in.',
					'br' => 'Constrói uma tag <a> com os segmentos de URL que você passar.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'segments' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					'title' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					'class' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
						),
					),
				),
			'is_ssl' => array(
				'description' => array(
					'en' => 'Returns true if the site is running on https.',
					'br' => 'Retorna true se o site estiver rodando em https.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(),
				),
			'redirect' => array(
				'description' => array(
					'en' => 'Send the visitor to another url.',
					'br' => 'Envia o visitante para outra URL.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'to' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
						),
					),
				),
			);

		return $info;
	}

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
	 * Current uri string sans site_url()
	 *
	 * Usage:
	 *
	 *     {{ url:uri_string }}
	 *
	 * @return string The current URI string.
	 */
	public function uri_string()
	{
		return $this->uri->uri_string();
	}
	
	/**
	 * Current uri query_string
	 *
	 * Usage:
	 *
	 *     {{ url:query_string }}
	 *
	 * @return string The current URI string.
	 */
	public function query_string()
	{
		return $_SERVER['QUERY_STRING'];
	}
	
	/**
	 * Build a query string
	 *
	 * Usage:
	 *
	 *     {{ url:http_build_query use_query_string="no" skip="var1|var2" var3="foo" }}
	 *
	 * @return mixed Parameters
	 */
	public function http_build_query()
	{
		// Use current query_string?
		if ($this->attribute('use_query_string') == 'yes' and $this->input->get())
		{
			$query = $this->input->get();
		}
		else
		{
			$query = array();
		}

		
		// Skip any?
		if ($skips = $this->attribute('skip'))
		{
			foreach (explode('|', $this->attribute('skip')) as $skip)
			{
				unset($query[$skip]);
			}
		}


		// Build
		foreach ($this->attributes() as $key=>$value)
		{
			if (in_array($key, array('use_query_string', 'skip', 'parse_params'))) continue;

			$query[$key] = $value;
		}

		return http_build_query($query);
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
		$title    = $this->attribute('title', '');
		$class    = $this->attribute('class', '');

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
	public function is_ssl()
	{
		return (isset($_SERVER['HTTPS']) ? ($_SERVER['HTTPS'] == "on" ? true : false) : false);
	}

	/**
	 * Send the visitor to another location
	 *
	 * Usage:
	 *
	 *     {{ url:redirect to="contact" }}
	 *
	 * @return bool
	 */
	public function redirect()
	{
		redirect($this->attribute('to'));
	}
}
