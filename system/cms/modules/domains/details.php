<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Domains module
 *
 * @author Ryan Thompson - AI Web Systems, Inc.
 * @package PyroCMS\Core\Modules\Domains
 */
class Module_Domains extends Module
{
	public $version = '1.0.0';

	public function info()
	{
		return array(
		    'name' => array(
		        'en' => 'Domains',
		        'fr' => 'Domaines',
		        'se' => 'Domäner',
		    ),
		    'description' => array(
		        'en' => 'Create domain aliases for your website.',
		        'fr' => 'Créer des alias de domaine pour votre site web',
		        'se' => 'Skapa domänalias för din webbplats',
		    ),
		    'frontend' => false,
		    'backend'  => true,
		    'menu'     => 'structure',
		    'shortcuts' => array(
		        array(
		            'name'  => 'domains:add_domain',
		            'uri'   => 'admin/domains/add',
		            'class' => 'add'
		        ),
		    ),
		);
	}

	public function install()
	{
		$schema = $this->pdb->getSchemaBuilder();

		$schema->drop('domains');

		// @TODO Make this install core_domains
		$schema->create('domains', function($table) { 
			$table->increments('id');
			$table->string('domain', 100);
			$table->integer('site_id');
			$table->enum('type', array('park', 'redirect'))->default('park');
			
			$table->key('domain');
			$table->unique('domain');
		});

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