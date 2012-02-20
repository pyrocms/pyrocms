<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Text Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_text
{
	public $field_type_slug			= 'text';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
	public $custom_parameters		= array('max_length', 'default_value');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output( $data )
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		
		if (isset($data['max_length']) and is_numeric($data['max_length']))
		{
			$options['maxlength'] = $data['max_length'];
		}
		
		return form_input($options);
	}
	
}