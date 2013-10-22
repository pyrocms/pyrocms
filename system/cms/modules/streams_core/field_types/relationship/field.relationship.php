<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;
use Pyro\Module\Streams_core\Core\Model;

/**
 * PyroStreams Relationship Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_relationship extends AbstractField
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
	public $custom_parameters = array( 'choose_stream');

	/**
	 * Version
	 * @var string
	 */
	public $version = '1.1.0';

	/**
	 * Author
	 * @var  array
	 */
	public $author = array('name'=>'Parse19', 'url'=>'http://parse19.com');

	/**
	 * Relation
	 * @return object The relation object
	 */
	public function relation()
	{
		return $this->belongsToEntry($this->getParameter('relation_class', 'Pyro\Module\Streams_core\Core\Model\Entry'));
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
		$model = Model\Entry::stream($this->getParameter('choose_stream'));

		$entry_options = array();

		// If this is not required, then
		// let's allow a null option
		if ( ! $this->field->is_required)
		{
			$entry_options[null] = ci()->config->item('dropdown_choose_null');
		}

		// Get the entries
		$entry_options += $model->getEntryOptions();
		
		// Output the form input
		return form_dropdown($this->form_slug, $entry_options, $this->value, 'id="'.rand_string(10).'"');
	}

	/**
	 * Output filter input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function filterOutput()
	{
		$model = Model\Entry::stream($this->getParameter('choose_stream'));

		$entry_options = array();

		// Let's allow a null option
		$entry_options[null] = ci()->config->item('dropdown_choose_null');

		// Get the entries
		$entry_options += $model->getEntryOptions();
		
		// Output the form input
		return form_dropdown($this->filter_slug, $entry_options, null);
	}

	// --------------------------------------------------------------------------

	/**
	 * Choose stream parameter
	 * 
	 * Get a list of streams to choose from
	 *
	 * @return	string
	 */
	public function param_choose_stream($stream_id = false)
	{
		$options = Model\Stream::getStreamAssociativeOptions();

		return form_dropdown('choose_stream', $options, $stream_id);
	}

	// --------------------------------------------------------------------------

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
	public function pre_output()
	{
		if($entry = $this->getRelation())
		{
			$stream = $entry->getStream();
		
			return $entry->toArray();
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
	public function pre_output_plugin()
	{
		if ($entry = $this->getRelation())
		{
			return $entry->toArray();
		}

		return null;
	}

}
