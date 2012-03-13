<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * API module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\API
 */
class Module_Api extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'API Management',
				'el' => 'Διαχείριση API',
				'fr' => 'Gestionnaire d\'API',
				'hu' => 'API Kezelés'
			),
			'description' => array(
				'en' => 'Set up a RESTful API with API Keys and out in JSON, XML, CSV, etc.',
				'el' => 'Ρυθμίσεις για ένα RESTful API με κλειδιά API και αποτελέσματα σε JSON, XML, CSV, κτλ.',
				'fr' => 'Paramétrage d\'une API RESTgul avec clés API et export en JSON, XML, CSV, etc.',
                                'hu' => 'Körültekintően állítsd be az API-t (alkalmazásprogramozási felület) az API Kulcsokkal együtt és küldd JSON-ba, XML-be, CSV-be, vagy bármi egyébbe.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'utilities',
			'sections' => array(
				'overview' => array(
					'name' => 'api:overview',
					'uri' => 'admin/api',
				),
				'keys' => array(
					'name' => 'api:keys',
					'uri' => 'admin/api/keys',
					'shortcuts' => array(
					// array(
					//     'name' => 'cat_create_title',
					//     'uri' => 'admin/blog/categories/create',
					//     'class' => 'add'
					// ),
					),
				),
			),
		);
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}