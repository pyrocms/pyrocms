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
	 * Fired when form is built per field
	 * @param  boolean $field 
	 */
	public function fieldEvent()
	{
		// Get related entries
		$entry = $this->getRelationResult();

		// Basically the selectize config mkay?
		$this->appendMetadata(
			$this->view(
				'data/relationship.js.php',
				array(
					'field_type' => $this,
					'entry' => $entry,
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

		// If it's an entry model - boomskie
		if ($instance instanceof EntryModel) {
			return $this->belongsToEntry($relation_class)->select('*');	
		}

		// Otherwise - boomskie too
		return $this->belongsTo($relation_class);
	}

	/**
	 * Output form input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function formInput()
	{
		// Attribtues
		$attribtues = array(
			'class' => $this->form_slug.'-selectize skip',
			);

		// String em
		$attribtue_string = '';

		foreach ($attribtues as $attribtue => $value)
			$attribtue_string .= $attribtue.'="'.$value.'" ';

		// Return an HTML dropdown
		return form_dropdown($this->form_slug, array(), null, $attribtue_string);
	}

	/**
	 * Output filter input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function filterInput()
	{
		//return form_dropdown($this->form_slug, $this->getOptions(), ci()->input->get($this->getFilterSlug('is')));
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
	// -------------------------	   AJAX 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Search for entries!
	 * @return string JSON
	 */
	public function ajaxSearch()
	{
		// Get the search term first
		$term = ci()->input->post('term');

		// List THIS stream, namespace and field_slug
		list($stream_namespace, $stream_slug, $field_slug) = explode('-', ci()->uri->segment(6));
		
		// Get THIS field
        $field = FieldModel::findBySlugAndNamespace($field_slug, $stream_namespace);

        // And THIS field type
		$field_type = $field->getType(null);

		// List RELATED _stream and namespace
		list($related_stream_slug, $related_stream_namespace) = explode('.', $field_type->getParameter('stream'));

		// Get RELATED entries
		$entries = EntryModel::stream($related_stream_slug, $related_stream_namespace)
			->select('*')
			->where(function($query) use ($field_type, $term) {

				// Where any of these
				foreach (explode('|', $field_type->getParameter('search_fields', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id'))) as $i => $field_slug) {

					// First where?
					if ($i == 0) {
						$query->where($field_slug, 'LIKE', '%'.$term.'%');
					} else {
						$query->orWhere($field_slug, 'LIKE', '%'.$term.'%');
					}
				}
			})
			->take(10)
			->get();

		// JSON - Wee!
		header('Content-type: application/json');
		die(json_encode(array('entries' => $entries)));
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
}