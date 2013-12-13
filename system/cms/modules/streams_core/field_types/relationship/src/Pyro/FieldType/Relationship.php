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
		'placeholder',
		'value_field',
		'label_field',
		'search_field',
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

	/**
	 * Runtime funtime cache
	 * @var array
	 */
	public $runtime_cache = array(
		'pluginOutput' => array(),
		);

	///////////////////////////////////////////////////////////////////////////////
	// --------------------------	METHODS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Run before form is built
	 *
	 * @return	void
	 */
	public function event()
	{
		$this->appendMetadata($this->view('fragments/relationship.js.php'));
	}

	/**
	 * Run before table is built
	 *
	 * @return	void
	 */
	public function filterEvent()
	{
		$this->appendMetadata($this->view('fragments/relationship.js.php'));
	}

	/**
	 * Relation
	 * @return object The relation object
	 */
	public function relation()
	{
		// Crate our runtime cache hash
		$hash = md5($this->stream->stream_slug.$this->stream->stream_namespace.$this->field->field_slug.$this->value);

		// Check / retreive hashed storage
		if (! isset($this->runtime_cache[$hash])) {

			list($stream_slug, $stream_namespace) = explode('.', $this->getParameter('stream'));

			if (! $relation_class = $this->relationClass()) return null;

			if (! $stream = StreamModel::findBySlugAndNamespace($stream_slug, $stream_namespace)) return null;

			$instance = new $relation_class;

			if ($instance instanceof EntryModel) {
				return $this->belongsToEntry($relation_class);	
			}

			$this->runtime_cache[$hash] = $this->belongsTo($relation_class);
		}

		return $this->runtime_cache[$hash];
	}

	/**
	 * Relation class
	 * @return string
	 */
	public function relationClass()
	{
		return $this->getParameter('relation_class', 'Pyro\Module\Streams_core\EntryModel');
	}

	/**
	 * Output form input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function formInput()
	{
		// Entry options
		$options = $this->getRelationResult();

		// To array
		if ($options) $options = $options->toArray(); else array();

		// Data
		$data = '
			data-options="'.htmlentities(json_encode($options)).'"
			data-value="'.htmlentities(implode(',', $value)).'"
			data-form_slug="'.$this->form_slug.'"
			data-field_slug="'.$this->field->field_slug.'"
			data-stream_param="'.$this->getParameter('stream').'"
			data-stream_namespace="'.$this->stream->stream_namespace.'"

			data-value_field="'.$this->getParameter('value_field', 'id').'"
			data-label_field="'.$this->getParameter('label_field', '_title_column').'"
			data-search_field="'.$this->getParameter('search_field', '_title_column').'"
			
			id="'.$this->form_slug.'"
			class="skip selectize-relationship"
			placeholder="'.lang_label($this->getParameter('placeholder', 'lang:streams:relationship.placeholder')).'"
			';

		// Start the HTML
		return form_dropdown(
			$this->form_slug,
			array(),
			null,
			$data
			);
	}
	
	/**
	 * Output filter input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function filterInput()
	{
		// Set the value
		$this->setValue(ci()->input->get($this->getFilterSlug('is')));

		// Entry options
		$options = $this->getRelationResult();

		// To array
		if ($options) $options = $options->toArray(); else array();

		// Data
		$data = '
			data-options="'.htmlentities(json_encode($options)).'"
			data-form_slug="'.$this->getFilterSlug('is').'"
			data-field_slug="'.$this->field->field_slug.'"
			data-stream_param="'.$this->getParameter('stream').'"
			data-stream_namespace="'.$this->stream->stream_namespace.'"
			
			data-value_field="'.$this->getParameter('value_field', 'id').'"
			data-label_field="'.$this->getParameter('label_field', '_title_column').'"
			data-search_field="'.$this->getParameter('search_field', '_title_column').'"
			
			id="'.$this->form_slug.'"
			class="skip selectize-relationship"
			placeholder="'.lang_label($this->getParameter('placeholder', 'lang:streams:relationship.placeholder')).'"
			';

		// Start the HTML
		return form_dropdown(
			$this->getFilterSlug('is'),
			array(),
			null,
			$data
			);
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
		// Crate our runtime cache hash
		$hash = md5($this->stream->stream_slug.$this->stream->stream_namespace.$this->field->field_slug.$this->value);

		if (! isset($this->runtime_cache['pluginOutput'][$hash])) {
			if ($entry = $this->getRelationResult())
			{
				return $this->runtime_cache['pluginOutput'][$hash] = $entry->asPlugin()->toArray();
			} else {
				return $this->runtime_cache['pluginOutput'][$hash] = null;
			}
		} else {
			return $this->runtime_cache['pluginOutput'][$hash];
		}
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
	 * Title column for options
	 * @param  string $value
	 * @return html
	 */
	public function paramTitleColumn($value = '')
	{
		return form_input('title_column', $value);
	}

	///////////////////////////////////////////////////////////////////////////
	// -------------------------	AJAX 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////

	public function ajaxSearch()
	{
		/**
		 * Determine the stream
		 */
		$stream = explode('.', ci()->uri->segment(7));
		$stream = StreamModel::findBySlugAndNamespace($stream[0], $stream[1]);


		/**
		 * Determine our field / type
		 */
		$field = FieldModel::findBySlugAndNamespace(ci()->uri->segment(8), ci()->uri->segment(6));
		$field_type = $field->getType();


		/**
		 * Determine our select
		 */
		$select = array_unique(
			array_merge(
				array_values(explode('|', $field->getParameter('value_field', 'id'))),
				array_values(explode('|', $field->getParameter('label_field'))),
				array_values(explode('|', $field->getParameter('search_field')))
				)
			);


		/**
		 * Get our entries
		 */
		$entries = EntryModel::stream($stream->stream_slug, $stream->stream_namespace)->select($select)->where($field_type->getParameter('search_field'), 'LIKE', '%'.ci()->input->get('query').'%')->take(10)->get();


		/**
		 * Stash the title_column just in case nothing is defined later
		 */
		$entries = $entries->toArray();

		header('Content-type: application/json');
		echo json_encode(array('entries' => $entries));
	}
}
