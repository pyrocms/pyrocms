<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;
use Pyro\Module\Streams_core\Core\Model\Field;

/**
 * PyroStreams Slug Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_slug extends AbstractField
{
	public $field_type_slug			= 'slug';

	public $db_col_type				= 'string';

	public $custom_parameters		= array( 'space_type', 'slug_field' );

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------

	/**
	 * Event
	 *
	 * Add the slugify plugin
	 *
	 * @return	void
	 */
	public function event()
	{
		if ( ! defined('ADMIN_THEME')) {
			$this->js('jquery.slugify.js');
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Save
	 *
	 * No PyroCMS tags in slug fields.
	 *
	 * @return string
	 */
	public function pre_save()
	{
		ci()->load->helper('text');
		return escape_tags($this->value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No PyroCMS tags in slugs.
	 *
	 * @return string
	 */
	public function pre_output()
	{
		ci()->load->helper('text');
		return escape_tags($this->value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
		$options['name'] 	= $this->form_slug;
		$options['id']		= $this->form_slug;
		$options['value']	= $this->value;
		$options['autocomplete'] = 'off';

		$jquery = "<script>(function($) {
			$(function(){
					pyro.generate_slug('#{$this->getParameter('slug_field')}', '#{$this->field->field_slug}', '{$this->getParameter('space_type')}');
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
			'-' => ci()->lang->line('streams:slug.dash'),
			'_' => ci()->lang->line('streams:slug.underscore')
		);

		return form_dropdown('space_type', $options, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * What field to slugify?
	 */
	public function param_slug_field($value = null)
	{
		// Get all the fields
		$fields = Field::all();

		$drop = array();

		foreach ($fields as $field) {
			// We don't want no slugs.
			if ($field->field_type != 'slug')
			{
				$drop[$field->field_slug] = $this->field->field_name;
			}
		}

		return form_dropdown('slug_field', $drop, $value);
	}

}
