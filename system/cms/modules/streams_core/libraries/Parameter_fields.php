<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Core Parameter Fields Library
 *
 * These are re-usable, common field parameters. Any
 * field can use them.
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Libraries
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Parameter_fields
{	
    function __construct()
    {
		$this->CI = get_instance();
		
		$this->CI->load->helper('form');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Maxlength field
	 *
	 * @access	public
	 * @param	string
	 * @return 	string
	 */
	public function max_length($value = '')
	{
		$data = array(
        	'name'        => 'max_length',
            'id'          => 'max_length',
        	'value'       => $value,
        	'maxlength'   => '100'
 		);
	
		return form_input($data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Upload location field
	 *
	 * @access	public
	 * @param	string
	 * @return 	string
	 */
	function upload_location($value = '')
	{
		$data = array(
        	'name'        => 'upload_location',
            'id'          => 'upload_location',
        	'value'       => $value,
        	'maxlength'   => '255'
 		);
	
		return form_input($data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Default default field
	 *
	 * @access	public
	 * @param	string
	 * @return 	string
	 */
	function default_value($value = '')
	{
		$data = array(
        	'name'        => 'default_value',
            'id'          => 'default_value',
        	'value'       => $value,
        	'maxlength'   => '255'
 		);
	
		return form_input($data);
	}

}