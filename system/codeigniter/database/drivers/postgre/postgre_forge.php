<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Postgre Forge Class
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_postgre_forge extends CI_DB_forge {

	/**
	 * Create database
	 *
	 * @access	private
	 * @param	string	the database name
	 * @return	bool
	 */
	function _create_database($name)
	{
		return "CREATE DATABASE ".$name;
	}

	// --------------------------------------------------------------------

	/**
	 * Drop database
	 *
	 * @access	private
	 * @param	string	the database name
	 * @return	bool
	 */
	function _drop_database($name)
	{
		return "DROP DATABASE ".$name;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Process Fields
	 *
	 * @param	mixed	the fields
	 * @return	string
	 */
	function _process_fields($fields, $primary_keys=array())
	{
		$sql = '';
		$current_field_count = 0;

		foreach ($fields as $field=>$attributes)
		{
			// Numeric field names aren't allowed in databases, so if the key is
			// numeric, we know it was assigned by PHP and the developer manually
			// entered the field information, so we'll simply add it to the list
			if (is_numeric($field))
			{
				$sql .= "\n\t$attributes";
			}
			else
			{
				$attributes = array_change_key_case($attributes, CASE_UPPER);

				$sql .= "\n\t".$this->db->protect_identifiers($field);

				$is_unsigned = (array_key_exists('UNSIGNED', $attributes) && $attributes['UNSIGNED'] === TRUE);

				// Convert datatypes to be PostgreSQL-compatible
				switch (strtoupper($attributes['TYPE']))
				{
					case 'TINYINT':
						$attributes['TYPE'] = 'SMALLINT';
						break;
					case 'SMALLINT':
						$attributes['TYPE'] = ($is_unsigned) ? 'INTEGER' : 'SMALLINT';
						break;
					case 'MEDIUMINT':
						$attributes['TYPE'] = 'INTEGER';
						break;
					case 'INT':
						$attributes['TYPE'] = ($is_unsigned) ? 'BIGINT' : 'INTEGER';
						break;
					case 'BIGINT':
						$attributes['TYPE'] = ($is_unsigned) ? 'NUMERIC' : 'BIGINT';
						break;
					case 'DOUBLE':
						$attributes['TYPE'] = 'DOUBLE PRECISION';
						break;
					case 'DATETIME':
						$attributes['TYPE'] = 'TIMESTAMP';
						break;
					case 'LONGTEXT':
						$attributes['TYPE'] = 'TEXT';
						break;
					case 'BLOB':
						$attributes['TYPE'] = 'BYTEA';
						break;
				}

				// If this is an auto-incrementing primary key, use the serial data type instead
				if (in_array($field, $primary_keys) && array_key_exists('AUTO_INCREMENT', $attributes) 
					&& $attributes['AUTO_INCREMENT'] === TRUE)
				{
					$sql .= ' SERIAL';
				}
				else
				{
					$sql .=  ' '.$attributes['TYPE'];
				}

				// Modified to prevent constraints with integer data types
				if (array_key_exists('CONSTRAINT', $attributes) && strpos($attributes['TYPE'], 'INT') === false)
				{
					$sql .= '('.$attributes['CONSTRAINT'].')';
				}

				if (array_key_exists('DEFAULT', $attributes))
				{
					$sql .= ' DEFAULT \''.$attributes['DEFAULT'].'\'';
				}

				if (array_key_exists('NULL', $attributes) && $attributes['NULL'] === TRUE)
				{
					$sql .= ' NULL';
				}
				else
				{
					$sql .= ' NOT NULL';
				}

				// Added new attribute to create unqite fields. Also works with MySQL
				if (array_key_exists('UNIQUE', $attributes) && $attributes['UNIQUE'] === TRUE)
				{
					$sql .= ' UNIQUE';
				}
			}

			// don't add a comma on the end of the last field
			if (++$current_field_count < count($fields))
			{
				$sql .= ',';
			}
		}
		
		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Create Table
	 *
	 * @access	private
	 * @param	string	the table name
	 * @param	array	the fields
	 * @param	mixed	primary key(s)
	 * @param	mixed	key(s)
	 * @param	boolean	should 'IF NOT EXISTS' be added to the SQL
	 * @return	bool
	 */
	function _create_table($table, $fields, $primary_keys, $keys, $if_not_exists)
	{
		$sql = 'CREATE TABLE ';

		if ($if_not_exists === TRUE)
		{
			// PostgreSQL doesn't support IF NOT EXISTS syntax so we check if table exists manually
			if ($this->db->table_exists($table))
			{
				return TRUE;
			}
		}

		$sql .= $this->db->_escape_identifiers($table)." (";
		$sql .= $this->_process_fields($fields, $primary_keys);

		if (count($primary_keys) > 0)
		{
			// Something seems to break when passing an array to protect_identifiers()
			foreach ($primary_keys as $index => $key)
			{
				$primary_keys[$index] = $this->db->protect_identifiers($key);
			}

			$sql .= ",\n\tPRIMARY KEY (" . implode(', ', $primary_keys) . ")";
		}

		$sql .= "\n);";

		if (is_array($keys) && count($keys) > 0)
		{
			foreach ($keys as $key)
			{
				if (is_array($key))
				{
					$key = $this->db->protect_identifiers($key);
				}
				else
				{
					$key = array($this->db->protect_identifiers($key));
				}

				foreach ($key as $field)
				{
					$sql .= "CREATE INDEX " . $table . "_" . str_replace(array('"', "'"), '', $field) . "_index ON $table ($field); ";
				}
			}
		}

		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Drop Table
	 */
	function _drop_table($table)
	{
		return "DROP TABLE IF EXISTS ".$this->db->_escape_identifiers($table)." CASCADE";
	}

	// --------------------------------------------------------------------

	/**
	 * Alter table query
	 *
	 * Generates a platform-specific query so that a table can be altered
	 * Called by add_column(), drop_column(), and column_alter(),
	 *
	 * @access	private
	 * @param	string	the ALTER type (ADD, DROP, CHANGE)
	 * @param	string	the column name
	 * @param	string	the table name
	 * @param	string	the column definition
	 * @param	string	the default value
	 * @param	boolean	should 'NOT NULL' be added
	 * @param	string	the field after which we should add the new field
	 * @return	object
	 */
 	function _alter_table($alter_type, $table, $fields, $after_field = '')
 	{
 		$sql = 'ALTER TABLE '.$this->db->protect_identifiers($table).' '.$alter_type.' ';

 		// DROP has everything it needs now.
 		if ($alter_type == 'DROP')
 		{
 			return $sql.$this->db->protect_identifiers($fields);
 		}

 		$sql .= $this->_process_fields($fields);

 		if ($after_field != '')
 		{
 			return $sql.' AFTER '.$this->db->protect_identifiers($after_field);
 		}

 		return $sql;
 	}

	// --------------------------------------------------------------------

	/**
	 * Rename a table
	 *
	 * Generates a platform-specific query so that a table can be renamed
	 *
	 * @access	private
	 * @param	string	the old table name
	 * @param	string	the new table name
	 * @return	string
	 */
	function _rename_table($table_name, $new_table_name)
	{
		return 'ALTER TABLE '.$this->db->protect_identifiers($table_name).' RENAME TO '.$this->db->protect_identifiers($new_table_name);
	}
}

/* End of file postgre_forge.php */
/* Location: ./system/database/drivers/postgre/postgre_forge.php */
