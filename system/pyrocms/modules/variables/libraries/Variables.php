<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Variable Library
 *
 * Handles the variables data
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS
 * @subpackage	Variables module
 * @category	Modules
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Variables {

	private $_CI;
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
		$this->_CI =& get_instance();
		$this->_CI->load->model('variables/variables_m');

		$vars = $this->_CI->variables_m->get_all();

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
		// Getting data
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