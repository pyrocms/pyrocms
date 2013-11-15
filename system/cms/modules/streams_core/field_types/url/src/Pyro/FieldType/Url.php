<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\AbstractFieldType;

/**
 * PyroStreams URL Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Url extends AbstractFieldType
{
	public $field_type_slug				= 'url';

	public $db_col_type					= 'string';

	public $extra_validation			= 'valid_url';

	public $version						= '1.0.0';

	public $author						= array('name' => 'Parse19', 'url' => 'http://parse19.com');

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
	{
		$options['name'] 	= $this->form_slug;
		$options['id']		= $this->form_slug;
		$options['value']	= $this->value;

		return form_input($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No PyroCMS tags in URL fields.
	 *
	 * @return string
	 */
	public function stringOutput()
	{
		ci()->load->helper('text');
		return escape_tags($this->value);
	}

}
