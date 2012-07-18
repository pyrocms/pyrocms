<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Email Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_email
{
	public $field_type_slug				= 'email';
	
	public $db_col_type					= 'varchar';
	
	public $extra_validation			= 'valid_email';

	public $version						= '1.0';
	
	public $author						= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		
		return form_input($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting for the plugin
	 *
	 * This creates an array of data to be merged with the
	 * tag array so relationship data can be called with
	 * a {field.column} syntax
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	public function pre_output_plugin($input, $params)
	{
		$choices = array();
		
		get_instance()->load->helper('url');
		
		$choices['email_address']		= $input;
		$choices['mailto_link']			= mailto($input, $input);
		$choices['safe_mailto_link']	= safe_mailto($input, $input);
		
		return $choices;
	}

}