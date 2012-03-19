<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Module
 *
 * @package		PyroCMS\Core\Modules\Streams Core
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Module_Streams_core extends Module {

	public $version = '1.0.0';

	/**
	 * Module Info
	 *
	 * @return array
	 */
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Streams Core',
				'fr' => 'Noyau Flux',
				'el' => 'Πυρήνας Ροών',
                                'se' => 'Streams grundmodul'
			),
			'description' => array(
				'en' => 'Core data module for streams.',
				'fr' => 'Noyau de données pour les Flux.',
				'el' => 'Προγραμματιστικός πυρήνας για την λειτουργία ροών δεδομένων.',
                                'se' => 'Streams grundmodul för enklare hantering av data.'
			),
			'frontend' => false,
			'backend' => false,
			'skip_xss' => true,
			'author' => 'Parse19'
		);
	}

	/**
	 * Install PyroStreams Core Tables
	 *
	 * @return bool
	 */
	public function install()
	{
		$config = $this->_load_config();

		if ($config === false)
		{
			return false;
		}

		// Go through our schema and make sure
		// all the tables are complete.
		foreach ($config['streams:schema'] as $table_name => $schema)
		{
			// Case where table does not exist.
			// Add fields and keys.
			if( ! $this->db->table_exists($table_name))
			{
				$this->dbforge->add_field($schema['fields']);

				// Add keys
				if(isset($schema['keys']) and ! empty($schema['keys']))
				{
					$this->dbforge->add_key($schema['keys']);
				}

				// Add primary key
				if(isset($schema['primary_key']))
				{
					$this->dbforge->add_key($schema['primary_key'], true);
				}

				$this->dbforge->create_table($table_name);
			}
			else
			{
				foreach ($schema['fields'] as $field_name => $field_data)
				{
					// If a field does not exist, then create it.
					if ( ! $this->db->field_exists($field_name, $table_name))
					{
						$this->dbforge->add_column($table_name, array($field_name => $field_data));
					}
					else
					{
						// Okay, it exists, we are just going to modify it.
						// If the schema is the same it won't hurt it.
						$this->dbforge->modify_column($table_name, array($field_name => $field_data));
					}
				}
			}
		}

		return true;
	}

	/**
	 * Uninstall Streams Core
	 *
	 * This is a very dangerous function. It removes the core streams tables so
	 * watch out.
	 *
	 * @return bool
	 */
	public function uninstall()
	{
		$config = $this->_load_config();

		if ($config === false)
		{
			return false;
		}

		// Go through our schema and drop each table
		foreach ($config['streams:schema'] as $table_name => $schema)
		{
			if ( ! $this->dbforge->drop_table($table_name))
			{
				return false;
			}
		}

		return true;
	}


	public function upgrade($old_version)
	{
		return true;
	}

	/**
	 * Manually load config that has all of our streams table data.
	 *
	 * @return mixed False or the config array
	 */
	private function _load_config()
	{
		if (defined('PYROPATH'))
		{
			require_once(PYROPATH.'modules/streams_core/config/streams.php');
		}
		elseif (defined('APPPATH'))
		{
			require_once(APPPATH.'modules/streams_core/config/streams.php');
		}

		return (isset($config)) ? $config : false;
	}
}