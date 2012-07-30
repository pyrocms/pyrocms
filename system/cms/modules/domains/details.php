<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Domains module
 *
 * @author Ryan Thompson - AI Web Systems, Inc.
 * @package PyroCMS\Core\Modules\Domains
 */
class Module_Domains extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Domains',
			),
			'description' => array(
				'en' => 'Create domain aliases for your website.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'utilities',

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
		if ( ! $this->db->table_exists('core_domains'))
		{
			// Create alias table
			if ( ! $this->db->query('	
				CREATE TABLE `core_domains` (
				  `id` int NOT NULL AUTO_INCREMENT,
				  `domain` varchar(100) NOT NULL,
				  `site_id` int NOT NULL,
				  `type` enum("park", "redirect") NOT NULL DEFAULT "park",
				  PRIMARY KEY (`id`),
				  KEY `domain` (`domain`),
				  UNIQUE `unique` (`domain`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8; '))
			{
				return false;
			}
		}

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