<?php namespace Pyro\FieldType;

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

	///////////////////////////////////////////////////////////////////////////////
	// --------------------------	METHODS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Called before the form is built.
	 *
	 * @return	void
	 */
	public function event()
	{
		$this->appendMetadata($this->view('fragments/relationship.js.php'));
	}

	/**
	 * Relation
	 * @return object The relation object
	 */
	public function relation()
	{
		return $this->belongsToEntry($this->getParameter('relation_class', 'Pyro\Module\Streams_core\EntryModel'))->select('*');
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
			data-value="'.$this->value.'"
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
		// Manually fire the event
		self::event();

		// Set the value
		$this->value = ci()->input->get($this->getFilterSlug('is'));

		// Entry options
		$options = $this->getRelationResult();

		// To array
		if ($options) $options = $options->toArray(); else array();
		
		// Data
		$data = '
			data-options="'.htmlentities(json_encode($options)).'"
			data-value="'.$this->value.'"
			data-form_slug="'.$this->form_slug.'"
			data-field_slug="'.$this->field->field_slug.'"
			data-stream_param="'.$this->getParameter('stream').'"
			data-stream_namespace="'.$this->stream->stream_namespace.'"
			
			data-value_field="'.$this->getParameter('value_field', 'id').'"
			data-label_field="'.$this->getParameter('label_field', '_title_column').'"
			data-search_field="'.$this->getParameter('search_field', '_title_column').'"
			
			id="'.$this->getFilterSlug('is').'"
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
		if ($entry = $this->getRelationResult())
		{
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
	 * Define the placeholder of the input
	 * @param  string $value
	 * @return html
	 */
	public function paramPlaceholder($value = '')
	{
		return form_input('placeholder', $value);
	}

	/**
	 * Define the field to use for values
	 * @param  string $value
	 * @return html
	 */
	public function paramValueField($value = '')
	{
		return form_input('value_field', $value);
	}

	/**
	 * Define the field to use for labels (options)
	 * @param  string $value
	 * @return html
	 */
	public function paramLabelField($value = '')
	{
		return form_input('label_field', $value);
	}

	/**
	 * Define the field to use for search
	 * @param  string $value
	 * @return html
	 */
	public function paramSearchField($value = '')
	{
		return form_input('search_field', $value);
	}

	/**
	 * Define any special template slug for this stream
	 * Loads like:
	 *  - views/field_types/TEMPLATE/option.php
	 *  - views/field_types/TEMPLATE/item.php
	 * @param  string $value
	 * @return html
	 */
	public function paramTemplate($value = '')
	{
		return form_input('template', $value);
	}

	/**
	 * Define an override of the module slug
	 * in case it is not the same as the namespace
	 * @param  string $value
	 * @return html
	 */
	public function paramModuleSlug($value = '')
	{
		return form_input('module_slug', $value);
	}

	/**
	 * Define an override of the module slug
	 * in case it is not the same as the namespace
	 * @param  string $value
	 * @return html
	 */
	public function paramRelationClass($value = '')
	{
		return form_input('relation_class', $value);
	}

	///////////////////////////////////////////////////////////////////////////
	// -------------------------	PLUGINS	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////

	/**
	 * Output filter input for plugins
	 *
	 * @access 	public
	 * @return	string
	 */
	public function pluginFilterInput()
	{
		// The condition:
		$condition = $this->plugin->getAttribute('condition', 'is');

		// Stream and namespace slug
		list($stream_slug, $stream_namespace) = explode('.', $this->getParameter('stream'));

		// Get the stream
		$stream = StreamModel::findBySlugAndNamespace($stream_slug, $stream_namespace);

		// Get the entries!
		$entries = EntryModel::stream($stream)
			->select(array('id', $this->plugin->getAttribute('select', $stream->title_column)))
			->orderBy($this->plugin->getAttribute('order_by', $stream->title_column), $this->plugin->getAttribute('sort', 'asc'))
			->whereRaw($this->plugin->getAttribute('where', '1'))
			->get();

		// Build the options array
		$options = array(null => $this->plugin->getAttribute('placeholder', '-----'));

		foreach ($entries as $entry)
			$options[$entry->id] = $entry->{$this->plugin->getAttribute('select', $stream->title_column)};

		// Build input extras
		$extras = array(
			'id' => $this->plugin->getAttribute('id'),
			'class' => $this->plugin->getAttribute('class'),
			'placeholder' => $this->plugin->getAttribute('placeholder'),
			);

		// Make the extra stuff a string
		foreach ($extras as $attribute => &$value)
			$value = $attribute.'="'.$value.'"';

		
		// Return that shiz
		return form_dropdown($this->getFilterSlug($condition), $options, $this->plugin->getAttribute('value', ci()->input->get($this->getFilterSlug($condition))), implode(' ', $extras));
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
		$field_type = $field->getType(null);


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
		$entries = EntryModel::stream($stream->stream_slug, $stream->stream_namespace)->select($select)->where($stream->title_column, 'LIKE', '%'.ci()->input->get('query').'%')->take(10)->get();


		/**
		 * Stash the title_column just in case nothing is defined later
		 */
		$entries = $entries->toArray();

		header('Content-type: application/json');
		echo json_encode(array('entries' => $entries));
	}
}
