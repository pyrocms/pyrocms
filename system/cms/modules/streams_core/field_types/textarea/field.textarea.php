<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams Textarea Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2012, Adam Fairholm
 */
class Field_textarea extends AbstractField
{
	public $field_type_slug			= 'textarea';

	public $db_col_type				= 'text';

	public $admin_display			= 'full';

	public $version					= '1.1.0';

	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

	public $custom_parameters		= array('default_text', 'allow_tags', 'content_type');
	
	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
		// Value
		// We only use the default value if this is a new entry
		if ( ! $this->entry->getKey())
		{
			$value = (isset($this->field->field_data['default_text']) and $this->field->field_data['default_text']) 
				? $this->field->field_data['default_text']
				: $this->value;

			// If we still don't have a default value, maybe we have it in
			// the old default value string. So backwards compat.
			if ( ! $value and isset($this->field->field_data['default_value']))
			{
				$value = $this->field->field_data['default_value'];
			}
		} else {
			$value = $this->value;
		}

		return form_textarea(array(
			'name'		=> $this->name,
			'id'		=> $this->name,
			'value'		=> $value
		));
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-Ouput content
	 *
	 * @return 	string
	 */
	public function pre_output()
	{
		$parse_tags = ( ! isset($params['allow_tags'])) ? 'n' : $params['allow_tags'];
		$content_type = ( ! isset($params['content_type'])) ? 'html' : $params['content_type'];

		// If this is the admin, show only the source
		// @TODO This is hacky, there will be times when the admin wants to see a preview or something
		if (defined('ADMIN_THEME'))
		{
			return $this->value;
		}

		// If this isn't the admin and we want to allow tags,
		// let it through. Otherwise we will escape them.
		if ($parse_tags == 'y')
		{
			$content = ci()->parser->parse_string($this->value, array(), true);
		}
		else
		{
			ci()->load->helper('text');
			$content = escape_tags($this->value);
		}

		// Not that we know what content is there, what format should we treat is as?
		switch ($content_type)
		{
			case 'md':
				ci()->load->helper('markdown');
				return parse_markdown($content);

			case 'html':
				return $content;

			default:
				return strip_tags($content);
		}

	}

	// --------------------------------------------------------------------------

	/**
	 * Default Textarea Value
	 *
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_default_text($value = null)
	{
		return form_textarea(array(
			'name'		=> 'default_text',
			'id'		=> 'default_text',
			'value'		=> $value,
		));
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
		$value or $value = 'n';
	
		return form_dropdown('allow_tags', $options, $value);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Content Type
	 *
	 * Is this plain text, HTML or Markdown?
	 */
	public function param_content_type($value = null)
	{
		$options = array(
			'text' => lang('global:plain-text'),
			'html' => 'HTML',
			'md'   => 'Markdown',
		);

		// Defaults to Plain Text
		$value or $value = 'text';
	
		return form_dropdown('content_type', $options, $value);
	}

}
