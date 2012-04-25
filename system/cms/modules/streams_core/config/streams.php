<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Config
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Config
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
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
$config['streams:reserved'] = array('ACCESSIBLE', 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FALSE', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MASTER_SSL_VERIFY_SERVER_CERT', 'MATCH', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RANGE', 'READ', 'READS', 'READ_WRITE', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'TRUE', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'XOR', 'YEAR_MONTH', 'ZEROFILL');


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
	        			'type' => 'VARCHAR',
	        			'constraint' => 60
	        		),
	        	'stream_namespace' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 60,
	        			'null' => TRUE
	        		),
	        	'stream_prefix' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 60,
	        			'null' => TRUE
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
    					'constraint' => array('title', 'custom'),
    					'default' => 'title')
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
	        			'type' => 'VARCHAR',
	        			'constraint' => 60
	        		),
	        	'field_namespace' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 60,
	        			'null' => TRUE
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
	        			'null' => TRUE),
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
	        			'null' => TRUE
	        		),
	        	'field_name' => array(
	        			'type' => 'VARCHAR',
	        			'constraint' => 255,
	        			'null' => TRUE
	        		)
	    ),
        'primary_key' => 'id')
);