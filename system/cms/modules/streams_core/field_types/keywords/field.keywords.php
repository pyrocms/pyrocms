<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Keywords Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_keywords
{
	public $field_type_slug				= 'keywords';

	public $db_col_type					= 'varchar';

	public $version						= '1.0';
	
	public $author						= array('name'=>'Osvaldo Brignoni', 'url'=>'http://obrignoni.com');

	// --------------------------------------------------------------------------
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('keywords/keywords');
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
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= Keywords::get_string($data['value']);

		return form_input($options);
	}

	public function event($field)
	{  	
		$this->CI->template->append_css('jquery/jquery.tagsinput.css');
		$this->CI->template->append_js('jquery/jquery.tagsinput.js');
		$this->CI->type->add_js('keywords', 'keywords.js');
		$this->CI->type->add_misc(
			'<script type="text/javascript">
				$(document).ready(function(){pyro.field_tags_input("'.$field->field_slug.'");});
			</script>'
		);
	}


	public function pre_save($input)
	{
		return Keywords::process($input);
	}

	public function pre_output($input)
	{
		return Keywords::get_string($input);
	}
}