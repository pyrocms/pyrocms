<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams URL Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_url
{
	public $field_type_slug				= 'url';
	
	public $db_col_type					= 'varchar';
	
	public $extra_validation			= 'valid_url';

	public $version						= '1.0';
	
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

}