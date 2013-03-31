<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Fields Driver
 *
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
 */

class Streams_fields extends CI_Driver
{
	/**
	 * Add field
	 *
	 * @param	array - field_data
	 * @return	bool
	 */
	public function add_field($field)
	{
		extract($field);

		// -------------------------------------
		// Validate Data
		// -------------------------------------

		// Do we have a field name?
		if ( ! isset($name) or ! trim($name)) {
			throw new Exception('Field name was empty');
		}

		// Do we have a field slug?
		if ( ! isset($slug) or ! trim($slug)) {
			throw new Exception('Field slug was empty');
		}

		// Do we have a namespace?
		if ( ! isset($namespace) or ! trim($namespace)) {
			throw new Exception('Field namespace was empty');
		}

		// Is this stream slug already available?
		if (is_object(ci()->fields_m->get_field_by_slug($slug, $namespace))) {
			throw new Exception("Field slug '{$slug}' is a duplicate.");
		}

		// Is this a valid field type?
		if ( ! isset($type) or ! isset(ci()->type->types->$type) ) {
			throw new Exception('Field type was not set, or invalid');
		}

		// Set locked
		$locked = (isset($locked) and $locked === true) ? 'yes' : 'no';

		// Set extra
		if ( ! isset($extra) or ! is_array($extra)) {
			$extra = array();
		}

		// -------------------------------------
		// Create Field
		// -------------------------------------

		$field_id = ci()->fields_m->insert_field($name, $slug, $type, $namespace, $extra, $locked);

		if (! $field_id) {
			throw new Exception("Field {$name} could not be added for some bizarre reason.");
		}

		// -------------------------------------
		// Assignment (Optional)
		// -------------------------------------

		if (isset($assign) and $assign != '' and (is_object($stream = ci()->streams_m->get_stream($assign, true, $namespace)))) {
			$data = array();

			// Title column
			if (isset($title_column) and $title_column === true) {
				$data['title_column'] = 'yes';
			}

			// Instructions
			$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;

			// Is Unique
			if (isset($unique) and $unique === true) {
				$data['is_unique'] = 'yes';
			}

			// Is Required
			if (isset($required) and $required === true) {
				$data['is_required'] = 'yes';
			}

			// Add actual assignment
			return ci()->streams_m->add_field_to_stream($field_id, $stream->id, $data);
		}

		return $field_id;
	}

	// --------------------------------------------------------------------------

	/**
	 * Add an array of fields
	 *
	 * @param	array 	Fields to add
	 * @return	bool
	 */
	public function add_fields(array $fields)
	{
		if (! $fields) {
			throw new Exception("Why is this empty?");
			return false;
		}

		foreach ($fields as $field) {
			$this->add_field($field);
		}

		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Assign field to stream
	 *
	 * @param	string - namespace
	 * @param	string - stream slug
	 * @param	string - field slug
	 * @param	array - assign data
	 * @return	mixed - false or assignment ID
	 */
	public function assign_field($namespace, $stream_slug, $field_slug, $assign_data = array())
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------

		if ( ! $stream = $this->stream_obj($stream_slug, $namespace)) {
			$this->log_error('invalid_stream', 'assign_field');
			return false;
		}

		if ( ! $field = ci()->fields_m->get_field_by_slug($field_slug, $namespace)) {
			$this->log_error('invalid_field', 'assign_field');
			return false;
		}

		// -------------------------------------
		// Assign Field
		// -------------------------------------

		$data = array();
		extract($assign_data);

		// Title column
		if (isset($title_column) and $title_column === true) {
			$data['title_column'] = 'yes';
		}

		// Instructions
		$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;

		// Is Unique
		if (isset($unique) and $unique === true) {
			$data['is_unique'] = 'yes';
		}

		// Is Required
		if (isset($required) and $required === true) {
			$data['is_required'] = 'yes';
		}

		// Is Locked
		if (isset($locked) and $locked === true) {
			$data['is_locked'] = 'yes';
		}

		// Add actual assignment
		return ci()->streams_m->add_field_to_stream($field->id, $stream->id, $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * De-assign field
	 *
	 * This also removes the actual column
	 * from the database.
	 *
	 * @param	string - namespace
	 * @param	string - stream slug
	 * @param	string - field slug
	 * @return	bool
	 */
	public function deassign_field($namespace, $stream_slug, $field_slug)
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------

		if ( ! $stream = $this->stream_obj($stream_slug, $namespace)) {
			$this->log_error('invalid_stream', 'deassign_field');
			return false;
		}

		if ( ! $field = ci()->fields_m->get_field_by_slug($field_slug, $namespace)) {
			$this->log_error('invalid_field', 'deassign_field');
			return false;
		}

		$assignment = ci()->pdb
			->table(ASSIGN_TABLE)
			->take(1)
			->where('field_id', $field->id)
			->where('stream_id', $stream->id)
			->first();
		
		if ( ! $assignment) {
			$this->log_error('invalid_assignment', 'deassign_field');
			return false;
		}
		
		// -------------------------------------
		// De-assign Field
		// -------------------------------------

		return ci()->streams_m->remove_field_assignment($assignment, $field, $stream);
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete field
	 *
	 * @param	string - field slug
	 * @param	string - field namespace
	 * @return	bool
	 */
	public function delete_field($field_slug, $namespace)
	{
		if ( ! trim($field_slug)) return false;

		if ( ! $field = ci()->fields_m->get_field_by_slug($field_slug, $namespace)) return false;

		return ci()->fields_m->delete_field($field->id);
	}

	// --------------------------------------------------------------------------

	/**
	 * Update field
	 *
	 * @param	string - slug
	 * @param	array - new data
	 * @return	bool
	 */
	/*function update_field($field_name, $field_slug, $field_namespace, $field_type, $extra_data)
	{
		if ( ! trim($field_slug) ) return false;

		if ( ! $field = ci()->fields_m->get_field_by_slug($field_slug, $field_namespace)) return false;

		return ci()->fields_m->update_field($field, $field_data);
	}*/

	// --------------------------------------------------------------------------

	/**
	 * Get assigned fields for
	 * a stream.
	 *
	 * @param	string - field slug
	 * @param	string - namespace
	 * @return	object
	 */
	public function get_field_assignments($field_slug, $namespace)
	{
		if ( ! trim($field_slug)) return false;

		if ( ! $field = ci()->fields_m->get_field_by_slug($field_slug, $namespace)) return false;

		return ci()->fields_m->get_assignments($field->id);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get fields for a stream.
	 *
	 * This includes the input and other
	 * associated data.
	 *
	 * @param	[int - limit]
	 * @param	[int - offset]
	 * @return	object
	 */
	public function get_stream_fields($stream, $stream_namespace, $current_data = array(), $entry_id = null)
	{
		$assignments = ci()->fields_m->get_assignments_for_stream($this->stream_id($stream, $stream_namespace));

		$return = array();

		ci()->load->library('streams_core/Fields');

		if ( ! $assignments) return $return;

		$count = 0;

		foreach ($assignments as $assign) {
			$value = (isset($current_data[$assign->field_slug])) ? $current_data[$assign->field_slug] : null;

			// Format the serialized stuff.
			$assign->field_data 			= @unserialize($assign->field_data);
			$assign->stream_view_options 	= @unserialize($assign->stream_view_options);

			$return[$count]['input'] = ci()->fields->build_form_input($assign, $value, $entry_id);

			// Other data
			$return[$count]['value'] 				= $value;
			$return[$count]['instructions']			= $assign->instructions;
			$return[$count]['field_name']			= ci()->fields->translate_label($assign->field_name);
			$return[$count]['field_unprocessed']	= $assign->field_name;
			$return[$count]['field_type']			= $assign->field_type;
			$return[$count]['field_slug']			= $assign->field_slug;

			$return[$count]['required']				= ($assign->is_required == 'yes') ? true : false;

			unset($value);

			$count++;
		}

		return $return;
	}

}
