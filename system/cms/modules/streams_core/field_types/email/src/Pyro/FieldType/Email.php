<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams Email Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Email extends AbstractField
{
	public $field_type_slug				= 'email';

	public $db_col_type					= 'string';

	public $extra_validation			= 'valid_email';

	public $version						= '1.0.0';

	public $author						= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formOutput()
	{
		$options['name'] = $this->form_slug;
		$options['id'] = $this->form_slug;
		$options['value'] = $this->value;
		$options['class'] = 'form-control';
		$options['placeholder'] = 'example@domain.com';

		return form_input($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No PyroCMS tags in email fields.
	 *
	 * @return string
	 */
	public function preOutput()
	{
		ci()->load->helper('text');
		return escape_tags($this->value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting for the plugin
	 *
	 * This creates an array of data to be merged with the
	 * tag array so relationship data can be called with
	 * a {field.column} syntax
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	public function preOutputPlugin()
	{
		$choices = array();

		$choices['email_address']		= $this->value;
		$choices['mailto_link']			= mailto($this->value, $this->value);
		$choices['safe_mailto_link']	= safe_mailto($this->value, $this->value);

		return $choices;
	}

}
