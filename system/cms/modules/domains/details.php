<?php

use Pyro\Module\Addons\AbstractModule;

/**
 * Domains module
 *
 * @author  Ryan Thompson - AI Web Systems, Inc.
 * @package PyroCMS\Core\Modules\Domains
 */
class Module_Domains extends AbstractModule
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
				'cn' => '网域',
                                'km' => 'Domains',
			),
			'description' => array(
				'en' => 'Create domain aliases for your website.',
				'el' => 'Διαχειριστείτε συνώνυμα domain για τον ιστότοπό σας.',
				'fr' => 'Créer des alias de domaine pour votre site web',
				'se' => 'Skapa domänalias för din webbplats',
				'it' => 'Crea alias per il tuo sito',
				'ar' => 'أنشئ أسماء نطاقات بديلة لموقعك.',
				'tw' => '為您的網站建立網域別名',
				'cn' => '为您的网站建立网域别名',
                                'km' => 'បង្កើតឈ្មេាះ domain ក្លែងក្លាយសំរាប់គេហទំព័ររបស់អ្នក។',
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

	/**
	 * Install
	 *
	 * This function is run to install the module
	 *
	 * @return bool
	 */
	public function install($pdb, $schema)
	{
		$schema->dropIfExists('core_domains');

		$schema->create('core_domains', function($table) {

			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('domain', 100)->unique();
			$table->integer('site_id');
			$table->enum('type', array('park', 'redirect'))->default('park');

			$table->index('domain');
		});

		return true;
	}

	public function uninstall($pdb, $schema)
	{
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
