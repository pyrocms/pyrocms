<?php namespace Pyro\FieldType;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\AbstractFieldType;
use Pyro\Module\Streams_core\StreamModel;

/**
 * PyroStreams Relationship Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Relationship extends AbstractFieldType
{
	/**
	 * Field type slug
	 * @var string
	 */
	public $field_type_slug = 'relationship';

	/**
	 * DB column type
	 * @var string
	 */
	public $db_col_type = 'integer';

	/**
	 * Custom parameters
	 * @var array
	 */
	public $custom_parameters = array(
		'stream',
		'placeholder',
		'value_field',
		'title_field',
		'option_format',
		'template',
		'module_slug',
		'relation_class',
		);

	/**
	 * Version
	 * @var string
	 */
	public $version = '2.0';

	/**
	 * Author
	 * @var  array
	 */
	public $author = array(
		'name' => 'Ryan Thompson - PyroCMS',
		'url' => 'http://pyrocms.com/'
		);

	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	METHODS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Relation
	 * @return object The relation object
	 */
	public function relation()
	{
		return $this->belongsTo($this->getRelationClass('Pyro\Module\Streams_core\EntryModel'));
	}

	/**
	 * Output form input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function formInput()
	{
		$data = array(
			'form_slug' => $this->form_slug,
			'id' => $this->value,
			'options' => $this->getOptions()
		);

		return $this->view($this->getParameter('form_input_view', 'form_input'), $data);
	}

	/**
	 * Output filter input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function filterInput()
	{
		return form_dropdown($this->form_slug, $this->getOptions(), ci()->input->get($this->getFilterSlug('is')));
	}

	/**
	 * Pre Ouput
	 *
	 * Process before outputting on the CP. Since
	 * there is less need for performance on the back end,
	 * this is accomplished via just grabbing the title column
	 * and the id and displaying a link (ie, no joins here).
	 *
	 * @return	mixed 	null or string
	 */
	public function stringOutput()
	{
		if ($entry = $this->getRelationResult()) {
			return $entry->getTitleColumnValue();
		}

		return null;
	}

	/**
	 * Pre Ouput Plugin
	 * 
	 * This takes the data from the join array
	 * and formats it using the row parser.
	 * 
	 * @return array
	 */
	public function pluginOutput()
	{
		if ($entry = $this->getRelationResult()) {
			return $entry->asPlugin()->toArray();
		}

		return null;
	}

	/**
	 * Pre Ouput Data
	 * 
	 * @return array
	 */
	public function dataOutput()
	{
		if ($entry = $this->getRelationResult()) {
			return $entry;
		}

		return null;
	}

	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	PARAMETERS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Choose a stream to relate to.. or remote source
	 * @param  mixed $value
	 * @return string
	 */
	public function paramStream($value = '')
	{
		$options = StreamModel::getStreamAssociativeOptions();

		return form_dropdown('stream', $options, $value);
	}

	/**
	 * Option format
	 * @param  string $value
	 * @return html
	 */
	public function paramOptionFormat($value = '')
	{
		return form_input('option_format', $value);
	}

	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	UTILITIES 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Options
	 * @return array
	 */
	public function getOptions()
	{
		// Boom
		return array();
	}
}
