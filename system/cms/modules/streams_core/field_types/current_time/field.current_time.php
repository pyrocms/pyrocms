<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Current Time Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_current_time
{
	public $field_type_slug			= 'current_time';
	
	public $db_col_type				= 'int';

	public $version					= '1.0';

	public $author					= array('name'=>'PyroCMS', 'url'=>'http://pyrocms.com');
	
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
		return null;
	}
	
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
		return now();
	}
	
}