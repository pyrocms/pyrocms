<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

/**
 * ODBC Result Class
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_odbc_result extends CI_DB_result {

	public $num_rows;

	/**
	 * Number of rows in the result set
	 *
	 * @return	int
	 */
	public function num_rows()
	{
		if (is_int($this->num_rows))
		{
			return $this->num_rows;
		}

		// Work-around for ODBC subdrivers that don't support num_rows()
		if (($this->num_rows = @odbc_num_rows($this->result_id)) === -1)
		{
			$this->num_rows = count($this->result_array());
		}

		return $this->num_rows;
	}

	/**
	 * Number of fields in the result set
	 *
	 * @return	int
	 */
	public function num_fields()
	{
		return @odbc_num_fields($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch Field Names
	 *
	 * Generates an array of column names
	 *
	 * @return	array
	 */
	public function list_fields()
	{
		$field_names = array();
		$num_fields = $this->num_fields();

		if ($num_fields > 0)
		{
			for ($i = 1; $i <= $num_fields; $i++)
			{
				$field_names[] = odbc_field_name($this->result_id, $i);
			}
		}

		return $field_names;
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 *
	 * Generates an array of objects containing field meta-data
	 *
	 * @return	array
	 */
	public function field_data()
	{
		$retval = array();
		for ($i = 0, $odbc_index = 1, $c = $this->num_fields(); $i < $c; $i++, $odbc_index++)
		{
			$retval[$i]			= new stdClass();
			$retval[$i]->name		= odbc_field_name($this->result_id, $odbc_index);
			$retval[$i]->type		= odbc_field_type($this->result_id, $odbc_index);
			$retval[$i]->max_length		= odbc_field_len($this->result_id, $odbc_index);
			$retval[$i]->primary_key	= 0;
			$retval[$i]->default		= '';
		}

		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Free the result
	 *
	 * @return	void
	 */
	public function free_result()
	{
		if (is_resource($this->result_id))
		{
			odbc_free_result($this->result_id);
			$this->result_id = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Result - associative array
	 *
	 * Returns the result set as an array
	 *
	 * @return	array
	 */
	protected function _fetch_assoc()
	{
		return function_exists('odbc_fetch_array')
			? odbc_fetch_array($this->result_id)
			: $this->_odbc_fetch_array($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @return	object
	 */
	protected function _fetch_object()
	{
		return function_exists('odbc_fetch_object')
			? odbc_fetch_object($this->result_id)
			: $this->_odbc_fetch_object($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * subsititutes the odbc_fetch_object function when
	 * not available (odbc_fetch_object requires unixODBC)
	 *
	 * @return	object
	 */
	protected function _odbc_fetch_object(& $odbc_result)
	{
		$rs = array();
		if ( ! odbc_fetch_into($odbc_result, $rs))
		{
			return FALSE;
		}

		$rs_obj = new stdClass();
		foreach ($rs as $k => $v)
		{
			$field_name = odbc_field_name($odbc_result, $k+1);
			$rs_obj->$field_name = $v;
		}

		return $rs_obj;
	}

	// --------------------------------------------------------------------

	/**
	 * Result - array
	 *
	 * subsititutes the odbc_fetch_array function when
	 * not available (odbc_fetch_array requires unixODBC)
	 *
	 * @return	array
	 */
	protected function _odbc_fetch_array(& $odbc_result)
	{
		$rs = array();
		if ( ! odbc_fetch_into($odbc_result, $rs))
		{
			return FALSE;
		}

		$rs_assoc = array();
		foreach ($rs as $k => $v)
		{
			$field_name = odbc_field_name($odbc_result, $k+1);
			$rs_assoc[$field_name] = $v;
		}

		return $rs_assoc;
	}

	// --------------------------------------------------------------------

	/**
	 * Query result. Array version.
	 *
	 * @return	array
	 */
	public function result_array()
	{
		if (count($this->result_array) > 0)
		{
			return $this->result_array;
		}
		elseif (($c = count($this->result_object)) > 0)
		{
			for ($i = 0; $i < $c; $i++)
			{
				$this->result_array[$i] = (array) $this->result_object[$i];
			}
		}
		elseif ($this->result_id === FALSE)
		{
			return array();
		}
		else
		{
			while ($row = $this->_fetch_assoc())
			{
				$this->result_array[] = $row;
			}
		}

		return $this->result_array;
	}

	// --------------------------------------------------------------------

	/**
	 * Query result. Object version.
	 *
	 * @return	array
	 */
	public function result_object()
	{
		if (count($this->result_object) > 0)
		{
			return $this->result_object;
		}
		elseif (($c = count($this->result_array)) > 0)
		{
			for ($i = 0; $i < $c; $i++)
			{
				$this->result_object[$i] = (object) $this->result_array[$i];
			}
		}
		elseif ($this->result_id === FALSE)
		{
			return array();
		}
		else
		{
			while ($row = $this->_fetch_object())
			{
				$this->result_object[] = $row;
			}
		}

		return $this->result_object;
	}

}

/* End of file odbc_result.php */
/* Location: ./system/database/drivers/odbc/odbc_result.php */