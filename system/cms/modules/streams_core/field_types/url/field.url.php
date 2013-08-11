<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams URL Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_url
{
	public $field_type_slug				= 'url';
	
	public $db_col_type					= 'varchar';
	
	public $extra_validation			= 'valid_url';

	public $version						= '1.0.0';
	
	public $author						= array('name' => 'Parse19', 'url' => 'http://parse19.com');
	
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
	 * Pre Output
	 *
	 * No PyroCMS tags in URL fields.
	 *
	 * @return string
	 */
	public function pre_output($input)
	{
		$this->CI->load->helper('text');
		return escape_tags($input);
	}

}