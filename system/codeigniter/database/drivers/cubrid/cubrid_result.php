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
 * @since		Version 2.1
 * @filesource
 */

/**
 * CUBRID Result Class
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @category	Database
 * @author		Esen Sagynov
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_cubrid_result extends CI_DB_result {

	/**
	 * Number of rows in the result set
	 *
	 * @return	int
	 */
	public function num_rows()
	{
		return @cubrid_num_rows($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Number of fields in the result set
	 *
	 * @return	int
	 */
	public function num_fields()
	{
		return @cubrid_num_fields($this->result_id);
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
		return cubrid_column_names($this->result_id);
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
		$i = 0;

		while ($field = cubrid_fetch_field($this->result_id))
		{
			$retval[$i]			= new stdClass();
			$retval[$i]->name		= $field->name;
			// CUBRID returns type as e.g. varchar(100),
			// so we need to remove all digits and brackets.
			$retval[$i]->type		= preg_replace('/[\d()]/', '', $field->type);
			$retval[$i]->default		= $field->def;
			// Use CUBRID's native API to obtain column's max_length,
			// otherwise $field->max_length has incorrect info
			$retval[$i]->max_length		= cubrid_field_len($this->result_id, $i);
			$retval[$i++]->primary_key	= $field->primary_key;
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
		if (is_resource($this->result_id) OR
			(get_resource_type($this->result_id) === 'Unknown' && preg_match('/Resource id #/', strval($this->result_id))))
		{
			cubrid_close_request($this->result_id);
			$this->result_id = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Data Seek
	 *
	 * Moves the internal pointer to the desired offset. We call
	 * this internally before fetching results to make sure the
	 * result set starts at zero
	 *
	 * @return	bool
	 */
	protected function _data_seek($n = 0)
	{
		return cubrid_data_seek($this->result_id, $n);
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
		return cubrid_fetch_assoc($this->result_id);
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
		return cubrid_fetch_object($this->result_id);
	}

}

/* End of file cubrid_result.php */
/* Location: ./system/database/drivers/cubrid/cubrid_result.php */