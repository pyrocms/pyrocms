<?php
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Entries Driver
 * @author    Parse19
 * @package    PyroCMS\Core\Libraries\Streams\Drivers
 */
class Streams_streams extends CI_Driver
{

    /**
     * Add a Stream.
     * @access    public
     * @param    string - stream name
     * @param    string - stream slug
     * @param    string - stream namespace
     * @param    [string - stream prefix]
     * @param    [string - about notes for stream]
     * @param    [array - extra data]
     * @return    false or new stream ID
     */
    public function add_stream($stream_name, $stream_slug, $namespace, $prefix = null, $about = null, $extra = array())
    {
        return StreamModel::addStream($stream_slug, $namespace, $stream_name, $prefix, $about, $extra);
    }

    // --------------------------------------------------------------------------

    /**
     * Get Stream
     * @access    public
     * @param    mixed $stream object, int or string stream
     * @param    string $namespace namespace if first param is string
     * @return    object
     */
    public function get_stream($stream, $namespace = null)
    {
        return StreamModel::getStream($stream, $namespace);
    }

    // --------------------------------------------------------------------------

    /**
     * Delete a stream
     * @access    public
     * @param    mixed $stream object, int or string stream
     * @param    string $namespace namespace if first param is string
     * @return    object
     */
    public function delete_stream($stream, $namespace = null)
    {
        return StreamModel::deleteStream($stream, $namespace);
    }

    // --------------------------------------------------------------------------

    /**
     * Update a stream
     * @access    public
     * @param    mixed $stream object, int or string stream
     * @param    string $namespace namespace if first param is string
     * @param    array $data associative array of new data
     * @return    object
     */
    public function update_stream($stream, $namespace = null, $data = array())
    {
        return StreamModel::updateStream($stream, $namespace, $data);
    }

    // --------------------------------------------------------------------------

    /**
     * Get stream field assignments
     * @access    public
     * @param    mixed $stream object, int or string stream
     * @param    string $namespace namespace if first param is string
     * @return    object
     */
    public function get_assignments($stream, $namespace = null)
    {
        return StreamModel::getFieldAssignments($stream, $namespace);
    }

    // --------------------------------------------------------------------------

    /**
     * Get streams in a namespace
     * @access    public
     * @param    string $namespace namespace
     * @param    int [$limit] limit, defaults to null
     * @param    int [$offset] offset, defaults to 0
     * @return    object
     */
    public function get_streams($namespace, $limit = null, $offset = 0)
    {
        return StreamModel::whereNamespace($namespace)->all();
    }

    // --------------------------------------------------------------------------

    /**
     * Get Stream Metadata
     * Returns an array of the following data:
     * name            The stream name
     * slug            The streams slug
     * namespace        The stream namespace
     * db_table        The name of the stream database table
     * raw_size        Raw size of the stream database table
     * size            Formatted size of the stream database table
     * entries_count    Number of the entries in the stream
     * fields_count    Number of fields assigned to the stream
     * last_updated        Unix timestamp of when the stream was last updated
     * @access    public
     * @param    mixed $stream object, int or string stream
     * @param    string $namespace namespace if first param is string
     * @return    object
     */
    public function get_stream_metadata($stream, $namespace = null)
    {
        return StreamModel::getStreamMetadata($stream, $namespace);
    }

    // --------------------------------------------------------------------------

    /**
     * Check is table exists
     * Check to see if the table name needed for a stream is
     * actually available.
     * @access    public
     * @param    string
     * @param    string
     * @param    string
     */
    public function check_table_exists($stream_slug, $prefix)
    {
        return ci()->streams_m->check_table_exists($stream_slug, $prefix);
    }

    // --------------------------------------------------------------------------

    /**
     * Validation Array
     * Get a validation array for a stream. Takes
     * the format of an array of arrays like this:
     * array(
     * 'field' => 'email',
     * 'label' => 'Email',
     * 'rules' => 'required|valid_email'
     */
    public function validation_array($stream, $namespace = null, $method = 'new', $skips = array(), $row_id = null)
    {
        $str_id = $this->stream_id($stream, $namespace);

        if (!$str_id) {
            $this->log_error('invalid_stream', 'validation_array');
        }

        $stream_fields = ci()->streams_m->get_stream_fields($str_id);

        return ci()->fields->set_rules($stream_fields, $method, $skips, true, $row_id);
    }
}