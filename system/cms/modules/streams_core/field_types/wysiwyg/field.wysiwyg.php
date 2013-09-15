<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams WYSIWYG Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_wysiwyg extends AbstractField
{
	public $field_type_slug			= 'wysiwyg';

	public $db_col_type				= 'long_text';

	public $admin_display			= 'full';

	public $custom_parameters 		= array('editor_type', 'allow_tags');

	public $version					= '1.1.0';

	public $author					= array('name' => 'Parse19', 'url'=>'http://parse19.com');

	/**
	 * Event
	 *
	 * Called before the form is built.
	 *
	 * @return	void
	 */
	public function event()
	{
		if (defined('ADMIN_THEME')) {
			ci()->type->add_misc(ci()->type->load_view('wysiwyg', 'wysiwyg_admin', null));
		} else {
			ci()->type->add_misc(ci()->type->load_view('wysiwyg', 'wysiwyg_entry_form', null));
		}
	}

	/**
	 * Pre-Ouput WYSUWYG content
	 *
	 * @param 	string
	 * @return 	string
	 */
	public function pre_output()
	{
		// Legacy. This was a temp fix for a few things
		// that I'm sure a few sites are utilizing.
		$input = str_replace('&#123;&#123; url:site &#125;&#125;', site_url().'/', $this->value);

		$parse_tags = ( ! isset($params['allow_tags'])) ? 'n' : $params['allow_tags'];

		// If this isn't the admin and we want to allow tags,
		// let it through. Otherwise we will escape them.
		if ( ! defined('ADMIN_THEME') and $parse_tags == 'y') {
			return ci()->parser->parse_string($this->value, array(), true);
		} else {
			ci()->load->helper('text');
			return escape_tags($this->value);
		}

	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
		// Set editor type
		if (isset($this->field->field_data['editor_type'])) {
			$options['class']	= 'wysiwyg-'.$this->field->field_data['editor_type'];
		} else {
			$options['class']	= 'wysiwyg-simple';
		}

		$options['name'] 	= $this->name;
		$options['id']		= $this->name;
		$options['value']	= $this->value;

		return form_textarea($options);
	}

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
		$value or $value = 'n';

		return form_dropdown('allow_tags', $options, $value);
	}

}
