<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
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
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Database Utility Class
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_forge {

	var $fields			= array();
	var $keys			= array();
	var $primary_keys	= array();
	var $db_char_set	=	'';

	/**
	 * Constructor
	 *
	 * Grabs the CI super object instance so we can access it.
	 *
	 */
	function __construct()
	{
		// Assign the main database object to $this->db
		$CI =& get_instance();
		$this->db =& $CI->db;
		log_message('debug', "Database Forge Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Create database
	 *
	 * @access	public
	 * @param	string	the database name
	 * @return	bool
	 */
	function create_database($db_name)
	{
		$sql = $this->_create_database($db_name);

		if (is_bool($sql))
		{
			return $sql;
		}

		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Drop database
	 *
	 * @access	public
	 * @param	string	the database name
	 * @return	bool
	 */
	function drop_database($db_name)
	{
		$sql = $this->_drop_database($db_name);

		if (is_bool($sql))
		{
			return $sql;
		}

		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Add Key
	 *
	 * @param	string	key
	 * @param	string	type
	 * @return	object
	 */
	public function add_key($key = '', $primary = FALSE)
	{
		if (is_array($key))
		{
			foreach ($key as $one)
			{
				$this->add_key($one, $primary);
			}

			return;
		}

		if ($key == '')
		{
			show_error('Key information is required for that operation.');
		}

		if ($primary === TRUE)
		{
			$this->primary_keys[] = $key;
		}
		else
		{
			$this->keys[] = $key;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Add Field
	 *
	 * @param	string	collation
	 * @return	object
	 */
	public function add_field($field = '')
	{
		if ($field == '')
		{
			show_error('Field information is required.');
		}

		if (is_string($field))
		{
			if ($field == 'id')
			{
				$this->add_field(array(
					'id' => array(
						'type' => 'INT',
						'constraint' => 9,
						'auto_increment' => TRUE
					)
				));
				$this->add_key('id', TRUE);
			}
			else
			{
				if (strpos($field, ' ') === FALSE)
				{
					show_error('Field information is required for that operation.');
				}

				$this->fields[] = $field;
			}
		}

		if (is_array($field))
		{
			$this->fields = array_merge($this->fields, $field);
		}
		
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Create Table
	 *
	 * @param	string	the table name
	 * @return	bool
	 */
	public function create_table($table = '', $if_not_exists = FALSE)
	{
		if ($table == '')
		{
			show_error('A table name is required for that operation.');
		}

		if (count($this->fields) == 0)
		{
			show_error('Field information is required.');
		}

		$sql = $this->_create_table($this->db->dbprefix.$table, $this->fields, $this->primary_keys, $this->keys, $if_not_exists);

		$this->_reset();

		if (is_bool($sql))
		{
			return $sql;
		}

		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Drop Table
	 *
	 * @param	string	the table name
	 * @return	bool
	 */
	public function drop_table($table_name)
	{
		$sql = $this->_drop_table($this->db->dbprefix.$table_name);

		if (is_bool($sql))
		{
			return $sql;
		}

		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Rename Table
	 *
	 * @param	string	the old table name
	 * @param	string	the new table name
	 * @return	bool
	 */
	public function rename_table($table_name, $new_table_name)
	{
		if ($table_name == '' OR $new_table_name == '')
		{
			show_error('A table name is required for that operation.');
		}

		$sql = $this->_rename_table($this->db->dbprefix.$table_name, $this->db->dbprefix.$new_table_name);
		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Column Add
	 *
	 * @param	string	the table name
	 * @param	string	the column name
	 * @param	string	the column definition
	 * @return	bool
	 */
	public function add_column($table = '', $field = array(), $after_field = '')
	{
		if ($table == '')
		{
			show_error('A table name is required for that operation.');
		}

		// add field info into field array, but we can only do one at a time
		// so we cycle through

		foreach ($field as $k => $v)
		{
			$this->add_field(array($k => $field[$k]));

			if (count($this->fields) == 0)
			{
				show_error('Field information is required.');
			}

			$sql = $this->_alter_table('ADD', $this->db->dbprefix.$table, $this->fields, $after_field);

			$this->_reset();

			if ($this->db->query($sql) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Column Drop
	 *
	 * @param	string	the table name
	 * @param	string	the column name
	 * @return	bool
	 */
	public function drop_column($table = '', $column_name = '')
	{

		if ($table == '')
		{
			show_error('A table name is required for that operation.');
		}

		if ($column_name == '')
		{
			show_error('A column name is required for that operation.');
		}

		$sql = $this->_alter_table('DROP', $this->db->dbprefix.$table, $column_name);

		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Column Modify
	 *
	 * @param	string	the table name
	 * @param	string	the column name
	 * @param	string	the column definition
	 * @return	bool
	 */
	public function modify_column($table = '', $field = array())
	{
		if ($table == '')
		{
			show_error('A table name is required for that operation.');
		}

		// add field info into field array, but we can only do one at a time
		// so we cycle through

		foreach ($field as $k => $v)
		{
			// If no name provided, use the current name
			if ( ! isset($field[$k]['name']))
			{
				$field[$k]['name'] = $k;
			}

			$this->add_field(array($k => $field[$k]));

			if (count($this->fields) == 0)
			{
				show_error('Field information is required.');
			}

			$sql = $this->_alter_table('CHANGE', $this->db->dbprefix.$table, $this->fields);

			$this->_reset();

			if ($this->db->query($sql) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Reset
	 *
	 * Resets table creation vars
	 *
	 * @return	void
	 */
	protected function _reset()
	{
		$this->fields		= array();
		$this->keys			= array();
		$this->primary_keys	= array();
	}

}

/* End of file DB_forge.php */
/* Location: ./system/database/DB_forge.php */