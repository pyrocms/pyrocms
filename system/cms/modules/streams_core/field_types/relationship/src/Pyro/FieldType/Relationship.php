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
		'module_slug'
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
		$id = ($selected = $this->getRelationResult() and $selected instanceof Eloquent) ? $selected->getKey() : null;

		$data = array(
			'form_slug' => $this->form_slug,
			'id' => ($selected = $this->getRelationResult() and $selected instanceof Eloquent) ? $selected->getKey() : null,
			'options' => $this->getOptions()
		);

		return $this->view($this->getParameter('form_input_view', 'form_input'), $data);
	}
	
	/**
	 * Options
	 * @return array
	 */
	public function getOptions()
	{
		$options = array();

		if ($relation_class = $this->relationClass())
		{
			$instance = new $relation_class;

			$options = $instance->get()->lists($this->getParameter('title_column'), $this->getParameter('value_field','id'));
		}

		return $options;
	}

	/**
	 * Output filter input
	 *
	 * @access 	public
	 * @return	string
	 */
	public function filterInput()
	{
		return form_dropdown($this->form_slug, $this->getOptions());
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
}
