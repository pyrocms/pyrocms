<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Module
 *
 * @package		PyroStreams Core
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Module_Streams_core extends Module {

	public $version = '1.0';
	
	function __construct()
	{		
		$this->load->config('streams_core/streams');		
	}

	// --------------------------------------------------------------------------

	/**
	 * Module Info
	 *
	 * @access	public
	 * @return	array
	 */
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Streams Core'
			),
			'description' => array(
				'en' => 'Core data module for streams.'
			),
			'frontend' => FALSE,
			'backend' => FALSE,
			'author' => 'Parse19'
		);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Install PyroStreams Core Tables
	 *
	 * @access	public
	 * @return	bool
	 */
	public function install()
	{
		// Go through our schema and make sure
		// all the tables are complete.
		foreach ($this->config->item('streams:schema') as $table_name => $schema)
		{
			// Case where table does not exist.
			// Add fields and keys.
			if( ! $this->db->table_exists($table_name))
			{
				$this->dbforge->add_field($schema['fields']);
	
				// Add keys
				if(isset($schema['keys']) AND ! empty($schema['keys']))
				{
					$this->dbforge->add_key($schema['keys']);	
				}
	
				// Add primary key
				if(isset($schema['primary_key']))
				{
					$this->dbforge->add_key($schema['primary_key'], TRUE);
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
						$this->CI->dbforge->modify_column($table_name, array($field_name => $field_data));
					}
				}
			}
		}
		
		return TRUE;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Uninstall Streams Core
	 *
	 * This is a very dangerous function. It removes
	 * the core streams tables so watch out.
	 *
	 * @access	public
	 * @return	bool
	 */
	public function uninstall()
	{
		// Go through our schema and drop each table
		foreach ($this->config->item('streams:schema') as $table_name => $schema)
		{
			if ( ! $this->dbforge->drop_table($table_name)) return FALSE;
		}
		
		return TRUE;
	}

	// --------------------------------------------------------------------------
	
	public function upgrade($old_version)
	{
		return TRUE;
	}

}