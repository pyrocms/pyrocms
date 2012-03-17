<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams WYSIWYG Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_wysiwyg
{
	public $field_type_slug			= 'wysiwyg';
	
	public $db_col_type				= 'longtext';
	
	public $custom_parameters 		= array('editor_type');

	public $version					= '1.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
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
		$CI = get_instance();
		
		$html = $CI->type->load_view('wysiwyg', 'wysiwyg_js_code', '', true);
		
		$CI->type->add_misc($html);
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
		$options['value']	= $data['value'];
		
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
			'simple'	=> lang('streams.wysiwyg.simple'),
			'advanced'	=> lang('streams.wysiwyg.advanced')
		);
	
		return form_dropdown('editor_type', $types, $value);
	}	

}