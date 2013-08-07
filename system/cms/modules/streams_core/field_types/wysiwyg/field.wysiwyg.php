<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams WYSIWYG Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_wysiwyg
{
	public $field_type_slug			= 'wysiwyg';
	
	public $db_col_type				= 'longtext';

	public $admin_display			= 'full';
	
	public $custom_parameters 		= array('editor_type', 'allow_tags');

	public $version					= '1.1.0';

	public $author					= array('name' => 'Parse19', 'url'=>'http://parse19.com');
	
	// --------------------------------------------------------------------------

	/**
	 * Event
	 *
	 * Called before the form is built.
	 *
	 * @access	public
	 * @return	void
	 */
	public function event()
	{
		if (defined('ADMIN_THEME'))
		{
			$this->CI->type->add_misc($this->CI->type->load_view('wysiwyg', 'wysiwyg_admin', null));
		}
		else
		{
			$this->CI->type->add_misc($this->CI->type->load_view('wysiwyg', 'wysiwyg_entry_form', null));
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-Ouput WYSUWYG content
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function pre_output($input, $params)
	{
		// Legacy. This was a temp fix for a few things
		// that I'm sure a few sites are utilizing.
		$input = str_replace('&#123;&#123; url:site &#125;&#125;', site_url().'/', $input);

		$parse_tags = ( ! isset($params['allow_tags'])) ? 'n' : $params['allow_tags'];

		// If this isn't the admin and we want to allow tags,
		// let it through. Otherwise we will escape them.
		if ( ! defined('ADMIN_THEME') and $parse_tags == 'y')
		{
			return $this->CI->parser->parse_string($input, array(), true);
		}
		else
		{
			$this->CI->load->helper('text');
			return escape_tags($input);
		}
		
	}

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
		// Set editor type
		if (isset($data['custom']['editor_type']))
		{
			$options['class']	= 'wysiwyg-'.$data['custom']['editor_type'];
		}
		else
		{
			$options['class']	= 'wysiwyg-simple';
		}
	
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= html_entity_decode($data['value'], ENT_COMPAT | ENT_HTML401, 'UTF-8');
		
		return form_textarea($options);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Editor Type Param
	 *
	 * Choose the type of editor.
	 */
	public function param_editor_type($value = null)
	{
		$types = array(
			'simple'	=> lang('streams:wysiwyg.simple'),
			'advanced'	=> lang('streams:wysiwyg.advanced')
		);
	
		return form_dropdown('editor_type', $types, $value);
	}	

	// --------------------------------------------------------------------------
	
	/**
	 * Allow tags param.
	 *
	 * Should tags go through or be converted to output?
	 */
	public function param_allow_tags($value = null)
	{
		$options = array(
			'n'	=> lang('global:no'),
			'y'	=> lang('global:yes')
		);
	
		// Defaults to No
		$value = ($value) ? $value : 'n';

		return form_dropdown('allow_tags', $options, $value);
	}	

}