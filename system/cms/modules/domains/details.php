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
		        'fr' => 'Domaines'
		    ),
		    'description' => array(
		        'en' => 'Create domain aliases for your website.',
		        'fr' => 'Créer des alias de domaine pour votre site web'
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
		if ( ! $this->db->table_exists('core_domains'))
		{
			$result = $this->db->query('	
				CREATE TABLE `core_domains` (
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