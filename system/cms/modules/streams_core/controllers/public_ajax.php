<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Public AJAX Controller
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Public_ajax extends Public_Controller {

    function __construct()
    {
        parent::__construct();
       
        // We need this for all of the variable setups in
        // the Type library __construct
        $this->load->library('Type');
        
        // Only AJAX gets through!
       	if ( !$this->input->is_ajax_request())
       	{
       		die('Invalid request.');
       	}
    }
	
	// --------------------------------------------------------------------------

	/**
	 * Fieldtype AJAX Function
	 *
	 * Accessed via AJAX
	 *
	 * @access	public
	 * @return	void
	 */
	public function field()
	{	
		$field_type = $this->uri->segment(4);
		$method = $this->uri->segment(5);
		
		if ( ! $field_type OR ! $method)
		{
			exit('No data.');
		}
		
		// Is this a valid field type?
		if ( ! isset($this->type->types->$field_type))
		{
			exit('Invalid Field Type.');
		}
		
		// We prefix all ajax functions with ajax_
		$method = 'ajax_'.$method;

		// Does the method exist?		
		if ( method_exists($this->type->types->$field_type, $method))
		{
			exit($this->type->types->$field_type->$method());
		}
		
		exit("Method '{$method}' not found.");
	}
	
}