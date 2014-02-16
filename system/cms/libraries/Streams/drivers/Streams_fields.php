<?php

use Pyro\Module\Streams\Data;
use Pyro\Module\Streams\Field\FieldAssignmentModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Fields Driver
 * @author    Parse19
 * @package    PyroCMS\Core\Libraries\Streams\Drivers
 */
class Streams_fields extends CI_Driver
{

    /**
     * Add field
     * @param    array - field_data
     * @return    bool
     */
    public function add_field($field)
    {
        extract($field);

        // -------------------------------------
        // Validate Data
        // -------------------------------------

        // Do we have a field name?
        if (!isset($name) or !trim($name)) {
            $this->log_error('empty_field_name', 'add_field');
            return false;
        }

        // Do we have a field slug?
        if (!isset($slug) or !trim($slug)) {
            $this->log_error('empty_field_slug', 'add_field');
            return false;
        }

        // Do we have a namespace?
        if (!isset($namespace) or !trim($namespace)) {
            $this->log_error('empty_field_namespace', 'add_field');
            return false;
        }

        // Is this stream slug already available?
        if (is_object(ci()->fields_m->get_field_by_slug($slug, $namespace))) {
            $this->log_error('field_slug_in_use', 'add_field');
            return false;
        }

        // Is this a valid field type?
        if (!isset($type) or !isset(ci()->type->types->$type)) {
            $this->log_error('invalid_fieldtype', 'add_field');
            return false;
        }

        // Set locked
        $locked = (isset($locked) and $locked === true) ? 'yes' : 'no';

        // Set extra
        if (!isset($extra) or !is_array($extra)) {
            $extra = array();
        }

        // -------------------------------------
        // Create Field
        // -------------------------------------

        $field_id = FieldModel::addField($field);

        if (!$field_id) {
            return false;
        }

        // -------------------------------------
        // Assignment (Optional)
        // -------------------------------------

        if (isset($assign) and $assign != '' and (is_object(
                $stream = ci()->streams_m->get_stream($assign, true, $namespace)
            ))
        ) {
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
            return FieldModel::assignField($stream->stream_slug, $stream->stream_namespace, $field->field_slug, $data);
        }

        return $field_id;
    }

    /**
     * Add an array of fields
     * @param    array - array of fields
     * @return    bool
     */
    public function add_fields($fields)
    {
        return FieldModel::addFields($fields);
    }

    /**
     * Assign field to stream
     * @param    string - namespace
     * @param    string - stream slug
     * @param    string - field slug
     * @param    array - assign data
     * @return    mixed - false or assignment ID
     */
    public function assign_field($namespace, $stream_slug, $field_slug, $assign_data = array())
    {
        return FieldAssignmentModel::assignField($stream_slug, $namespace, $field_slug, $assign_data);
    }

    /**
     * De-assign field
     * This also removes the actual column
     * from the database.
     * @param    string - namespace
     * @param    string - stream slug
     * @param    string - field slug
     * @return    bool
     */
    public function deassign_field($namespace, $stream_slug, $field_slug)
    {
        return FieldAssignmentModel::deassignField($namespace, $stream_slug, $field_slug);
    }

    /**
     * Delete field
     * @param    string - field slug
     * @param    string - field namespace
     * @return    bool
     */
    public function delete_field($field_slug, $namespace)
    {
        return FieldModel::deleteField($field_slug, $namespace);
    }

    /**
     * Update field
     * @param    string - slug
     * @param    array - new data
     * @return    bool
     */
    /*function update_field($field_name, $field_slug, $field_namespace, $field_type, $extra_data)
    {
        if ( ! trim($field_slug) ) return false;

        if ( ! $field = ci()->fields_m->get_field_by_slug($field_slug, $field_namespace)) return false;

        return ci()->fields_m->update_field($field, $field_data);
    }*/

    /**
     * Get assigned fields for
     * a stream.
     * @param    string - field slug
     * @param    string - namespace
     * @return    object
     */
    public function get_field_assignments($field_slug, $namespace)
    {
        return FieldModel::getFieldAssignments($field_slug, $namespace);
    }

    /**
     * Get fields for a stream.
     * This includes the input and other
     * associated data.
     * @access    public
     * @param    string - stream_slug
     * @param    string - stream_namespace
     * @param    [array - current_data]
     * @param    [int - entry_id]
     * @return    array
     */
    public function get_stream_fields($stream, $stream_namespace, $current_data = array(), $entry_id = null)
    {
        return StreamModel::getFieldAssignments($stream, $stream_namespace);
    }
}
