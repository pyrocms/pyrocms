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
		foreach ($this->schema() as $table_name => $schema)
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
		foreach ($this->schema() as $table_name => $schema)
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

	// --------------------------------------------------------------------------
	
	/**
	 * Our database schema for 
	 * Streams core
	 *
	 * @access	public
	 * @return	array
	 */
	public function schema()
	{
		return array(
	
	    'data_streams' => array(
	        'fields' => array(
	        		'id' => array(
	        				'type' => 'INT',
	        				'constraint' => 11,
	        				'unsigned' => TRUE,
	        				'auto_increment' => TRUE
	        			),
	        		'stream_name' => array(
	        				'type' => 'VARCHAR',
	        				'constraint' => 60
	        			),
		        	'stream_slug' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 60
		        		),
		        	'stream_namespace' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 60
		        		),
		        	'stream_prefix' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 60
		        		),
	    			'about' => array(
	    					'type' => 'VARCHAR',
	    					'constraint' => 255,
	    					'null' => TRUE
	    				),
	    			'view_options' => array(
	    					'type' => 'BLOB'
	    				),
	    			'title_column' => array(
	    					'type' => 'VARCHAR',
	    					'constraint' => 255,
	    					'null' => TRUE
	    				),
	    			'sorting' => array(
	    					'type' => 'ENUM',
	    					'constraint' => "'title', 'custom'",
	    					'default' => 'title')
		     ),
	        'primary_key' => 'id'),
		'data_fields' => array(
	        'fields' => array(
		        	'id' => array(
		        			'type' => 'INT',
		        			'constraint' => 11,
		        			'unsigned' => TRUE,
		        			'auto_increment' => TRUE
		        	),
		        	'field_name' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 60
		        	),
		        	'field_slug' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 60
		        		),
		        	'field_namespace' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 60
		        		),
		        	'field_type' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 50
		        		),
		        	'field_data' => array(
		        			'type' => 'BLOB',
		        			'null' => TRUE
		        		),
		        	'view_options' => array(
		        			'type' => 'BLOB',
		        			'null' => true)
		     ),
	        'primary_key' => 'id'),
	    'data_field_assignments' => array(
	        'fields' => array(
		        	'id' => array(
		        			'type' => 'INT',
		        			'constraint' => 11,
		        			'unsigned' => TRUE,
		        			'auto_increment' => TRUE
		        		),
		        	'sort_order' => array(
		        			'type' => 'INT',
		        			'constraint' => 11
		        		),
		        	'stream_id' => array(
		        			'type' => 'INT',
		        			'constraint' => 11
		        		),
		        	'field_id' => array(
		        			'type' => 'INT',
		        			'constraint' => 11
		        		),
		        	'is_required' => array(
		        			'type' => 'ENUM',
		        			'constraint' => "'yes', 'no'",
		        			'default' => 'no'
		        		),
		        	'is_unique' => array(
		        			'type' => 'ENUM',
		        			'constraint' => "'yes', 'no'",
		        			'default' => 'no'
		        		),
		        	'instructions' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 255
		        		),
		        	'field_name' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 255,
		        			'null' => TRUE
		        		)
		    ),
	        'primary_key' => 'id'),
		'data_stream_searches' => array(
	        'fields' => array(
		        	'id' => array(
		        			'type' => 'INT',
		        			'constraint' => 11,
		        			'unsigned' => TRUE,
		        			'auto_increment' => TRUE
		        		),
		        	'search_id' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 255
		        		),
		        	'search_term' => array(
		        			'type' => 'TEXT'
		        		),
		        	'ip_address' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 100
		        		),
		        	'total_results' => array(
		        			'type' => 'INT',
		        			'constraint' => 11
		        		),
		        	'query_string' => array(
		        			'type' => 'LONGTEXT'
		        		),
		        	'stream_slug' => array(
		        			'type' => 'VARCHAR',
		        			'constraint' => 255
		        		)
		    ),
	        'primary_key' => 'id')
		);
	}

}