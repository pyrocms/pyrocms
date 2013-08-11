<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Encrypt Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_encrypt
{
	public $field_type_slug			= 'encrypt';
	
	public $db_col_type				= 'blob';

	public $custom_parameters		= array('hide_typing');

	public $version					= '1.1.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
	// --------------------------------------------------------------------------

	/**
	 * Process before saving to database
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_save($input)
	{
		$this->CI->load->library('encrypt');
		
		return $this->CI->encrypt->encode($input);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input)
	{
		$this->CI->load->library('encrypt');
		
		$out = $this->CI->encrypt->decode($input);
	
		// No PyroCMS tags in your ouput!
		$this->CI->load->helper('text');
		return escape_tags($out);
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function form_output($params)
	{
		$this->CI->load->library('encrypt');

		$options['name'] 	= $params['form_slug'];
		$options['id']		= $params['form_slug'];

		// If we have post data and are returning form
		// values (because of most likely a form validation error),
		// we will just have the posted plain text value
		$options['value'] = ($_POST) ? $params['value'] : $this->CI->encrypt->decode($params['value']);
		
		if ($params['custom']['hide_typing'] == 'yes')
		{
			return form_password($options);
		}
		else
		{
			return form_input($options);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Yes or no box to hide typing
	 *
	 * @access	public
	 * @param	[array - param]
	 * @return	string
	 */	
	public function param_hide_typing($params = false)
	{
		$selected 		= ($params == 'no') ? 'no' : 'yes';

		$yes_select 	= ($selected == 'yes') ? true : false;
		$no_select 		= ($selected == 'no') ? true : false;
	
		$form  = '<ul><li><label>'.form_radio('hide_typing', 'yes', $yes_select).' Yes </label></li>';
		
		$form .= '<li><label>'.form_radio('hide_typing', 'no', $no_select).' No </label></li></ul>';
		
		return $form;
	}

}