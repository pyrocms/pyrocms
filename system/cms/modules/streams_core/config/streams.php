<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Config
 *
 * @package		PyroStreams Core
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */

// --------------------------------------------------------------------------

/**
 * Streams select limit.
 *
 * Once the relationship stream reaches this
 * number, it'll turn into an auto-complete. 
 */
//$config['streams:select_limit'] 		= 100;

// --------------------------------------------------------------------------

/**
 * Database Table Names
 */
$config['streams:streams_table'] 		= 'data_streams';
$config['streams:fields_table'] 		= 'data_fields';
$config['streams:assignments_table'] 	= 'data_field_assignments';
$config['streams:searches_table'] 		= 'data_stream_searches';

// --------------------------------------------------------------------------

/**
 * The value presented for a
 * null value in a drop down
 */
$config['dropdown_choose_null'] 		= '-----';

// --------------------------------------------------------------------------

/**
 * Streams DB Schema
 */
$config['streams:schema'] = array(

    $config['streams:streams_table'] => array(
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
	        			'type' => 'VARCHAR', 'constraint' => 60),
	        			'about' => array('type' => 'VARCHAR', 'constraint' => 255),
	        			'view_options' => array('type' => 'BLOB'),
	        			'title_column' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
	        			'sorting' => array('type' => 'ENUM', 'constraint' => "'title', 'custom'", 'default' => 'title')
	        		),
        'primary_key' => 'id'),
    $config['streams:fields_table'] => array(
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
	        			'type' => 'VARCHAR', 'constraint' => 60),
			        	'field_type' => array('type' => 'VARCHAR', 'constraint' => 50),
			        	'field_data' => array('type' => 'BLOB', 'null' => true),
			        	'view_options' => array('type' => 'BLOB', 'null' => true)
			        ),
        'primary_key' => 'id'),
    $config['streams:fields_table'] => array(
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
	        			'null' => true
	        		)
	        	),
        'primary_key' => 'id'),
	$config['streams:searches_table'] => array(
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