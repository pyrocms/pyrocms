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

	/**
	 * Runtime funtime cache
	 * @var array
	 */
	public $runtime_cache = array(
		'pluginOutput' => array(),
		);


	/**
	 * Relation
	 * @return object The relation object
	 */
	public function relation()
	{
		return $this->belongsToEntry($this->getParameter('relation_class', 'Pyro\Module\Streams_core\EntryModel'))->enableAutoEagerLoading(true)->select('*');
	}

	/**
	 * Output form input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function formInput()
	{
		// Start the HTML
		$html = form_dropdown($this->form_slug, array(), null, 'id="'.$this->form_slug.'" class="skip" placeholder="'.lang_label($this->getParameter('placeholder', 'lang:streams:relationship.placeholder')).'"');

		// Append our JS to the HTML since it's special
		$html .= $this->view(
			'fragments/relationship.js.php',
			array(
				'form_slug' => $this->form_slug,
				'field_slug' => $this->field->field_slug,
				'stream' => $this->getParameter('stream'),
				'value_field' => $this->getParameter('value_field', 'id'),
				'label_field' => $this->getParameter('label_field', '_title_column'),
				'search_field' => $this->getParameter('search_field', '_title_column'),
				),
			false
			);

		return $html;
	}

	/**
	 * Output filter input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function filterInput()
	{
		// Start the HTML
		$html = form_dropdown($this->getFilterSlug('contains'), array(), null, 'id="'.$this->getFilterSlug('contains').'" class="skip" placeholder="'.$this->field->field_name.'"');

		// Append our JS to the HTML since it's special
		$html .= $this->view(
			'fragments/relationship.js.php',
			array(
				'form_slug' => $this->getFilterSlug('contains'),
				'field_slug' => $this->field->field_slug,
				'stream' => $this->getParameter('stream'),
				'value_field' => $this->getParameter('value_field', 'id'),
				'label_field' => $this->getParameter('label_field', 'id'),
				'search_field' => $this->getParameter('search_field', 'id'),
				),
			false
			);

		return $html;
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
		$stream = explode('.', ci()->uri->segment(6));
		$stream = StreamModel::findBySlugAndNamespace($stream[0], $stream[1]);


		/**
		 * Determine our field / type
		 */
		$field = FieldModel::findBySlugAndNamespace(ci()->uri->segment(7), $stream->stream_namespace);
		$field_type = $field->getType(null);


		/**
		 * Get our entries
		 */
		$entries = EntryModel::stream($stream->stream_slug, $stream->stream_namespace)->where($stream->title_column, 'LIKE', '%'.ci()->input->get('query').'%')->take(10)->get();


		/**
		 * Stash the title_column just in case nothing is defined later
		 */
		$entries = $entries->toArray();

		header('Content-type: application/json');
		echo json_encode(array('entries' => $entries));
	}
}
