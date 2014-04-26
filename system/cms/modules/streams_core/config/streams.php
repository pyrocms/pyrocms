<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Config
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */

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
 * Streams Reserved Words
 */
$config['streams:reserved'] = array('ACCESSIBLE', 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'false', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MASTER_SSL_VERIFY_SERVER_CERT', 'MATCH', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG', 'null', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RANGE', 'READ', 'READS', 'READ_WRITE', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'true', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'created', 'page_id', 'updated', 'id', 'created_by');


// --------------------------------------------------------------------------

/**
 * Streams DB Schema
 */
$config['streams:schema'] = array(

    $config['streams:streams_table'] => array(
        'fields' => array(
        		'id' => array(
        				'type' => 'INT',
        				'unsigned' => true,
        				'auto_increment' => true
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
	        			'constraint' => 60,
	        			'null' => true
	        		),
	        	'stream_prefix' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 60,
	        			'null' => true
	        		),
    			'about' => array(
    					'type' => 'VARCHAR',
    					'constraint' => 255,
    					'null' => true
    				),
    			'view_options' => array(
    					'type' => 'BLOB'
    				),
    			'title_column' => array(
    					'type' => 'VARCHAR',
    					'constraint' => 255,
    					'null' => true
    				),
    			'sorting' => array(
    					'type' => 'ENUM',
    					'constraint' => array('title', 'custom'),
    					'default' => 'title'
    				),
    			'permissions' => array(
    					'type' => 'TEXT',
    					'null' => true
    				),
   				'is_hidden' => array(
						'type' => 'ENUM',
						'constraint' => array('yes', 'no'),
						'default' => 'no'
					),
   				'menu_path' => array(
   						'type' => 'VARCHAR',
   						'constraint' => 255,
   						'null' => true
   					)
	     ),
        'primary_key' => 'id'),
    $config['streams:fields_table'] => array(
        'fields' => array(
	        	'id' => array(
	        			'type' => 'INT',
	        			'constraint' => 11,
	        			'unsigned' => true,
	        			'auto_increment' => true
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
	        			'constraint' => 60,
	        			'null' => true
	        		),
	        	'field_type' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 50
	        		),
	        	'field_data' => array(
	        			'type' => 'BLOB',
	        			'null' => true
	        		),
	        	'view_options' => array(
	        			'type' => 'BLOB',
	        			'null' => true),
				'is_locked' => array(
						'type' => 'ENUM',
						'constraint' => array('yes', 'no'),
						'default' => 'no'
					),
	     ),
        'primary_key' => 'id'),
    $config['streams:assignments_table'] => array(
        'fields' => array(
	        	'id' => array(
	        			'type' => 'INT',
	        			'constraint' => 11,
	        			'unsigned' => true,
	        			'auto_increment' => true
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
	        			'constraint' => array('yes', 'no'),
	        			'default' => 'no'
	        		),
	        	'is_unique' => array(
	        			'type' => 'ENUM',
	        			'constraint' => array('yes', 'no'),
	        			'default' => 'no'
	        		),
	        	'instructions' => array(
	        			'type' => 'TEXT',
	        			'null' => true
	        		),
	        	'field_name' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 255,
	        			'null' => true
	        		)
	    ),
        'primary_key' => 'id')
);