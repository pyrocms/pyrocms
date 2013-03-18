<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Integer Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright © 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_integer
{
	public $field_type_slug			= 'integer';
	
	public $db_col_type				= 'int';
	
	public $custom_parameters		= array('max_length', 'default_value');
	
	public $extra_validation		= 'integer';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
		
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
		
		// Max length
		$max_length = (isset($data['max_length']) and $data['max_length']) ? $options['maxlength'] = $data['max_length'] : null;

		return form_input($options);
	}
	
}