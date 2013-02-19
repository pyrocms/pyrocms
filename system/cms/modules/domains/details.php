<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Domains module
 *
 * @author  Ryan Thompson - AI Web Systems, Inc.
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
				'el' => 'Domains',
				'fr' => 'Domaines',
				'se' => 'Domäner',
				'it' => 'Domini',
				'ar' => 'أسماء النطاقات',
				'tw' => '網域',
				'cn' => '网域'
			),
			'description' => array(
				'en' => 'Create domain aliases for your website.',
				'el' => 'Διαχειριστείτε συνώνυμα domain για τον ιστότοπό σας.',
				'fr' => 'Créer des alias de domaine pour votre site web',
				'se' => 'Skapa domänalias för din webbplats',
				'it' => 'Crea alias per il tuo sito',
				'ar' => 'أنشئ أسماء نطاقات بديلة لموقعك.',
				'tw' => '為您的網站建立網域別名',
				'cn' => '为您的网站建立网域别名'
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'structure',
			'shortcuts' => array(
				array(
					'name' => 'domains:add_domain',
					'uri' => 'admin/domains/add',
					'class' => 'add'
				),
			),
		);
	}

	public function install()
	{
		$this->pdb->getQueryGrammar()->setTablePrefix('core_');
		$schema = $this->pdb->getSchemaBuilder();

		$schema->dropIfExists('domains');

		// @TODO Make this install core_domains
		$schema->create('domains', function($table) { 
			$table->increments('id');
			$table->string('domain', 100);
			$table->integer('site_id');
			$table->enum('type', array('park', 'redirect'))->default('park');
			
			$table->index('domain');
			$table->unique('domain');
		});

		$this->pdb->getQueryGrammar()->setTablePrefix(SITE_REF.'_');

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
