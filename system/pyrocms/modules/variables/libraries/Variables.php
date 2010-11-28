<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Variable Library
 *
 * Handles the variables data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Variables {

	private $CI;

	private $_vars = array();

	// ------------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * Get all the variables and assign them to the vars array
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('variables/variables_m');

		$vars = $this->CI->variables_m->get_all();

		foreach ($vars as $var)
		{
			$this->_vars[$var->name] = $var->data;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Magic get
	 *
	 * Used to pull out a variable's data
	 *
	 * @param	string
	 * @return 	mixed
	 */
	public function __get($name)
	{
		// getting data
		if (isset($this->_vars[$name]))
		{
			return $this->_vars[$name];
		}

		return NULL;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all
	 *
	 * Get an array of all the vars
	 *
	 * @return array
	 */
	public function get_all()
	{
		return $this->_vars;
	}
}
/* End of file Variables.php */