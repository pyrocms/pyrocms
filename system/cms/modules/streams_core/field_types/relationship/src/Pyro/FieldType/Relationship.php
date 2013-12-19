<?php namespace Pyro\FieldType;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\AbstractFieldType;
use Pyro\Module\Streams_core\EntryModel;
use Pyro\Module\Streams_core\FieldModel;
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
		'label_field',
		'search_fields',
		'option_format',
		'label_format',
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
	 * Fired when form is built
	 * @param  boolean $field 
	 */
	public function event()
	{
		// Basically the selectize config mkay?
		$this->appendMetadata(
			$this->view(
				'data/relationship.js.php',
				array(
					'field_type' => $this,
					),
				true
				)
			);
	}

	/**
	 * Relation
	 * @return object The relation object
	 */
	public function relation()
	{
		// Extract our relationship stream
		list($stream_slug, $stream_namespace) = explode('.', $this->getParameter('stream'));

		// Get the relationship class
		if (! $relation_class = $this->getRelationClass()) return null;

		// If the stream doesn't exist..
		if (! $stream = StreamModel::findBySlugAndNamespace($stream_slug, $stream_namespace)) return null;

		// Create a new instance
		// of our relation class to use/abuse
		$instance = new $relation_class;

		// 
		if ($instance instanceof EntryModel) {
			return $this->belongsToEntry($relation_class)->select('*');	
		}

		return $this->belongsTo($relation_class)->select('*');
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
		if ($entry = $this->getRelationResult())
		{
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
		if ($entry = $this->getRelationResult())
		{
			return $entry->asPlugin();
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
		if ($entry = $this->getRelationResult())
		{
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
	 * Relation class
	 * @return string
	 */
	public function getRelationClass()
	{
		return $this->getParameter('relation_class', 'Pyro\Module\Streams_core\EntryModel');
	}

	/**
	 * Options
	 * @return array
	 */
	public function getOptions()
	{
		// Get options
		$options = array();

		if ($relation_class = $this->getRelationClass())
		{
			list($stream_slug, $stream_namespace) = explode('.', $this->getParameter('stream'));

			$stream = StreamModel::findBySlugAndNamespace($stream_slug, $stream_namespace);

			$instance = new $relation_class;

			$options = $instance::stream($stream_slug, $stream_namespace)->limit(1000)->select('*')->get()->toArray();
		}

		// Format options
		$formatted_options = array();

		$option_format = $this->getParameter('option_format', '{{ '.($stream->title_column ? $stream->title_column : 'id').' }}');

		$value_field = $this->getParameter('value_field', 'id');

		foreach ($options as $option)
			$formatted_options[$option[$value_field]] = ci()->parser->parse_string($option_format, $option, true, false, array(), false);

		// Boom
		return $formatted_options;
	}
}