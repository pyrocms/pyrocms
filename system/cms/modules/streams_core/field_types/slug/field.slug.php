<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Slug Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_slug
{
	public $field_type_slug			= 'slug';
	
	public $db_col_type				= 'varchar';

	public $custom_parameters		= array( 'space_type', 'slug_field' );

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------

	/**
	 * Event
	 *
	 * Add the slugify plugin
	 *
	 * @access	public
	 * @return	void
	 */
	public function event()
	{
		if ( ! defined('ADMIN_THEME'))
		{
			$this->CI->type->add_js('slug', 'jquery.slugify.js');
		}
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
		$options['name'] 	= $params['form_slug'];
		$options['id']		= $params['form_slug'];
		$options['value']	= $params['value'];
		
		$jquery = "<script>(function($) {
			$(function(){
					pyro.generate_slug('#{$params['custom']['slug_field']}', '#{$params['form_slug']}', '{$params['custom']['space_type']}');
			});
		})(jQuery);
		</script>";
		
		return form_input($options)."\n".$jquery;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Dash or Underscore?
	 */	
	public function param_space_type($value = null)
	{	
		$options = array(
			'-' => $this->CI->lang->line('streams:slug.dash'),
			'_' => $this->CI->lang->line('streams:slug.underscore')
		);
	
		return form_dropdown('space_type', $options, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * What field to slugify?
	 */	
	public function param_slug_field($value = null)
	{
		$this->CI->load->model('fields_m');
	
		// Get all the fields
		$fields = $this->CI->fields_m->get_all_fields();
		
		$drop = array();
		
		foreach ($fields as $field)
		{
			// We don't want no slugs.
			if($field['field_type'] != 'slug')
			{
				$drop[$field['field_slug']] = $this->CI->fields->translate_label($field['field_name']);
			}
		}
		
		return form_dropdown('slug_field', $drop, $value);
	}

}