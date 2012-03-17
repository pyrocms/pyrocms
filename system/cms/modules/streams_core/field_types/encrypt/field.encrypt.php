<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Encrypt Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_encrypt
{
	public $field_type_slug			= 'encrypt';
	
	public $db_col_type				= 'blob';

	public $custom_parameters		= array( 'hide_typing' );

	public $version					= '1.0';

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
		
		return $this->CI->encrypt->decode($input);
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
		$options['value']	= $this->CI->encrypt->decode( $params['value'] );
		
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
	public function param_hide_typing($params = FALSE)
	{
		$selected = 'yes';
	
		if ($params == 'no')
		{
			$selected = 'no';
		}
		
		$yes_select 	= ($selected == 'yes') ? true : false;
		$no_select 		= ($selected == 'no') ? true : false;
	
		$form  = '<ul><li><label>'.form_radio('hide_typing', 'yes', $yes_select).' Yes </label></li>';
		
		$form .= '<li><label>'.form_radio('hide_typing', 'no', $no_select).' No </label></li></ul>';
		
		return $form;
	}

}