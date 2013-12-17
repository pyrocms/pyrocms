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

	/**
	 * Install
	 *
	 * This function is run to install the module
	 *
	 * @return bool
	 */
	public function install($pdb, $schema)
	{
		if ( ! $this->db->table_exists('core_domains'))
		{
			$result = $this->db->query('	
				CREATE TABLE IF NOT EXISTS `core_domains` (
				  `id` int NOT NULL AUTO_INCREMENT,
				  `domain` varchar(100) NOT NULL,
				  `site_id` int NOT NULL,
				  `type` enum("park", "redirect") NOT NULL DEFAULT "park",
				  PRIMARY KEY (`id`),
				  KEY `domain` (`domain`),
				  UNIQUE `unique` (`domain`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8; ');

			// Create alias table
			if ( ! $result)
			{
				return false;
			}
		}

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
