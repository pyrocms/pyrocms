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
		'br' => 'Acessa variáveis globais.',
		'el' => 'Πρόσβαση σε οικουμενικές μεταβλητές.',
            'fa' => 'دسترسی به متغییر های اصلی',
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
			'environment' => array(
				'description' => array(
					'en' => 'Check the current environment to determine if the site is in development, staging, or production.',
					'br' => 'Checa o ambiente atual para determinar se o site está em desenvolvimento (development), adaptação (staging) ou publicação (production).'
				),
				'single' => true,
			),
			'site_domain' => array(
				'description' => array(
					'en' => 'The current domain that this site is running on.',
					'br' => 'O domínio atual em que o site está rodando.'
				),
				'single' => true,
			),
			'addon_folder' => array(
				'description' => array(
					'en' => 'The name of the addon folder. For a Community site this will always be "default".',
					'br' => 'O nome da pasta de complementos. Para um site Community, este valor sempre será "default".'
				),
				'single' => true,
			),
			'site_ref' => array(
				'description' => array(
					'en' => 'The name of the site reference slug. For a Community site this will be "default".',
					'br' => 'O nome do slug de referência do site. Para um site Community, este valor será "default".'
				),
				'single' => true,
			),
			'addonpath' => array(
				'description' => array(
					'en' => 'The dynamic path to the site\'s addon folder. Example: addons/default/',
					'br' => 'O caminho dinâmico para a pasta de complementos do site. Exemplo: addons/default/'
				),
				'single' => true,
			),
			'shared_addonpath' => array(
				'description' => array(
					'en' => 'The path the the shared addons.',
					'br' => 'O caminho para os complementos compartilhados.'
				),
				'single' => true,
			),
			'apppath' => array(
				'description' => array(
					'en' => 'The application path. Example: system/cms/',
					'br' => 'O caminho da aplicação. Exemplo: system/cms/'
				),
				'single' => true,
			),
			'fcpath' => array(
				'description' => array(
					'en' => 'The server path to the application. Example: /var/www/site/',
					'br' => 'O caminho no servidor para a aplicação. Exemplo: /var/www/site/'
				),
				'single' => true,
			),
			'base_url' => array(
				'description' => array(
					'en' => 'The base url without the index.php regardless of mod_rewrite settings.',
					'br' => 'A url base sem "index.php" independente das configurações do mod_rewrite.'
				),
				'single' => true,
			),
			'base_uri' => array(
				'description' => array(
					'en' => 'The relative path to the application root.',
					'br' => 'O cainho relativo à raiz da aplicação.'
				),
				'single' => true,
			),
			'cms_version' => array(
				'description' => array(
					'en' => 'The current software version.',
					'br' => 'A versão atual do software.'
				),
				'single' => true,
			),
			'cms_edition' => array(
				'description' => array(
					'en' => 'The software edition.',
					'br' => 'A edição do software.'
				),
				'single' => true,
			),
			'cms_date' => array(
				'description' => array(
					'en' => 'The software release date.',
					'br' => 'A data de liberação do software.'
				),
				'single' => true,
			),
			'current_language' => array(
				'description' => array(
					'en' => 'The lang key of the language pack currently in use.',
					'br' => 'A chave do idioma em uso atualmente.'
				),
				'single' => true,
			),
			'admin_theme' => array(
				'description' => array(
					'en' => 'The slug of the admin theme currently in use.',
					'br' => 'O slug do tema administrativo em uso atualmente.'
				),
				'single' => true,
			),
			'module' => array(
				'description' => array(
					'en' => 'The module currently in use.',
					'br' => 'O módulo em uso atualmente.'
				),
				'single' => true,
			),
			'controller' => array(
				'description' => array(
					'en' => 'The controller currently being used to serve the page.',
					'br' => 'O controller utilizado para exibir a página corrente.'
				),
				'single' => true,
			),
			'method' => array(
				'description' => array(
					'en' => 'The controller\'s method currently in use.',
					'br' => 'O método do controller em uso atualmente.'
				),
				'single' => true,
			),
		);

		return $info;
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
		// only allow access to documented globals
		if ( ! array_key_exists($name, $this->_self_doc()))
		{
			return;
		}

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