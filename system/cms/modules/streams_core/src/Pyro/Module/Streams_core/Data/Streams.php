<?php namespace Pyro\Module\Streams_core\Data;

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractData;

class Streams extends AbstractData
{
	/**
	 * Add a Stream.
	 *
	 * @access	public
	 * @param	string - stream name
	 * @param	string - stream slug
	 * @param	string - stream namespace
	 * @param	[string - stream prefix]
	 * @param	[string - about notes for stream]
	 * @param 	[array - extra data]
	 * @return	false or new stream ID
	 */
	public static function addStream($stream_name, $stream_slug, $stream_namespace, $stream_prefix = null, $about = null, $extra = array())
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------
		
		// Do we have a stream name?
		if ( ! trim($stream_name))
		{
			$this->logError('empty_stream_name', __method__);
			return false;
		}				

		// Do we have a stream slug?
		if ( ! trim($stream_slug))
		{
			$this->logError('empty_stream_slug', __method__);
			return false;
		}				

		// Do we have a stream namespace?
		if ( ! trim($stream_namespace))
		{
			$this->logError('empty_stream_namespace', __method__);
			return false;
		}

		// Is this stream slug already available?
		if(Model\Stream::findBySlug($stream_slug))
		{
			$this->logError('stream_slug_in_use', __method__, $stream_slug.' slug was attepted.');
			return false;
		}
	
		// -------------------------------------
		// Create Stream
		// -------------------------------------
		
		$stream = array(
			'stream_name' 		=> $stream_name,
			'stream_slug' 		=> $stream_slug,
			'stream_namespace'	=> $stream_namespace,
			'stream_prefix'		=> $stream_prefix,
			'about'				=> $about,
		);

		$stream['view_options']	= (isset($extra['view_options']) and is_array($extra['view_options'])) ? $extra['view_options'] : array('id', 'created');
		$stream['title_column']	= isset($extra['title_column']) ? $extra['title_column'] : null;
		$stream['sorting']		= isset($extra['sorting']) ? $extra['sorting'] : 'title';
		$stream['permissions']	= isset($extra['permissions']) ? $extra['permissions'] : null;
		$stream['is_hidden']	= isset($extra['is_hidden']) ? $extra['is_hidden'] : false;
		$stream['menu_path']	= isset($extra['menu_path']) ? $extra['menu_path'] : null;

		return Model\Stream::create($stream);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get Stream
	 *
	 * @access	public
	 * @param	mixed $stream object, int or string stream
	 * @param	string $stream_namespace namespace if first param is string
	 * @return	object
	 */
	public static function getStream($stream_slug, $stream_namespace = null)
	{
		if ( ! $stream = Model\Stream::findBySlugAndNamespace($stream_slug, $stream_namespace)) 
		{
			$this->logError('invalid_stream', __method__, $stream_slug.' (stream_slug) , '.$stream_namespace.' (stream_namespace) attepted.');
		}

		return $stream;
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a stream
	 *
	 * @access	public
	 * @param	mixed $stream object, int or string stream
	 * @param	string $stream_namespace namespace if first param is string
	 * @return	object
	 */
	public static function deleteStream($stream_slug, $stream_namespace = null)
	{
		if ( ! $stream = Model\Stream::findBySlugAndNamespace($stream_slug, $stream_namespace)) 
		{
			$this->logError('invalid_stream', __method__, $stream_slug.' (stream_slug) , '.$stream_namespace.' (stream_namespace) attepted.');
		}
	
		return $stream->delete();
	}

	// --------------------------------------------------------------------------

	/**
	 * Update a stream
	 *
	 * @access	public
	 * @param	mixed $stream object, int or string stream
	 * @param	string $stream_namespace namespace if first param is string
	 * @param 	array $data associative array of new data
	 * @return	object
	 */
	public static function updateStream($stream_slug, $stream_namespace = null, $data = array())
	{	
		if ( ! $stream = Model\Stream::findBySlugAndNamespace($stream_slug, $stream_namespace)) 
		{
			$this->logError('invalid_stream', __method__, $stream_slug.' (stream_slug) , '.$stream_namespace.' (stream_namespace) attepted.');
		}

		return $stream->update($data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get stream field assignments
	 *
	 * @access	public
	 * @param	mixed $stream object, int or string stream
	 * @param	string $stream_namespace namespace if first param is string
	 * @return	object
	 */
	public static function getFieldAssignments($stream_slug, $stream_namespace = null)
	{
		if ( ! $stream = Model\Stream::findBySlugAndNamespace($stream_slug, $stream_namespace)) 
		{
			$this->logError('invalid_stream', __method__, $stream_slug.' (stream_slug) , '.$stream_namespace.' (stream_namespace) attepted.');
		}

		return $stream->assignments;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get streams in a namespace
	 *
	 * @access	public
	 * @param	string $stream_namespace namespace
	 * @param 	int [$limit] limit, defaults to null
	 * @param 	int [$offset] offset, defaults to 0
	 * @return	object
	 */
	public static function getStreams($stream_namespace, $limit = null, $offset = 0)
	{
		return ci()->streams_m->get_streams($stream_namespace, $limit, $offset);
	}

	// --------------------------------------------------------------------------

	/**
	 * Get Stream Metadata
	 *
	 * Returns an array of the following data:
	 *
	 * name 			The stream name
	 * slug 			The streams slug
	 * namespace 		The stream namespace
	 * db_table 		The name of the stream database table
	 * raw_size 		Raw size of the stream database table
	 * size 			Formatted size of the stream database table
	 * entries_count	Number of the entries in the stream
	 * fields_count 	Number of fields assigned to the stream
	 * last_updated		Unix timestamp of when the stream was last updated
	 *
	 * @access	public
	 * @param	mixed $stream object, int or string stream
	 * @param	string $stream_namespace namespace if first param is string
	 * @return	object
	 */
	public static function getStreamMetadata($stream_slug = null, $stream_namespace = null)
	{
		$stream = static::getStream($stream_slug, $stream_namespace);

		$data = array();

		$data['name']		= $stream->stream_name;
		$data['slug']		= $stream->stream_slug;
		$data['namespace']	= $stream->stream_namespace;

		// Get DB table name
		$data['db_table'] 	= $stream->stream_prefix.$stream->stream_slug;

		// Get the table data
		$info = ci()->db->query("SHOW TABLE STATUS LIKE '".ci()->db->dbprefix($data['db_table'])."'")->row();
		
		// Get the size of the table
		$data['raw_size']	= $info->Data_length;

		ci()->load->helper('number');
		$data['size'] 		= byte_format($info->Data_length);
		
		// Last updated time
		$data['last_updated'] = ( ! $info->Update_time) ? $info->Create_time : $info->Update_time;

		ci()->load->helper('date');
		$data['last_updated'] = mysql_to_unix($data['last_updated']);
		
		// Get the number of rows (the table status data on this can't be trusted)
		$data['entries_count'] = ci()->db->count_all($data['db_table']);
		
		// Get the number of fields
		$data['fields_count'] = ci()->db->select('id')->where('stream_id', $stream->id)->get(ASSIGN_TABLE)->num_rows();

		return $data;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Chekc is table exists
	 * 
	 * Check to see if the table name needed for a stream is
	 * actually available.
	 *
	 * @access 	public
	 * @param 	string
	 * @param 	string
	 * @param 	string
	 */
	public static function check_table_exists($stream_slug, $prefix)
	{
		return ci()->streams_m->check_table_exists($stream_slug, $prefix);
	}

	// --------------------------------------------------------------------------

	/**
	 * Validation Array
	 *
	 * Get a validation array for a stream. Takes
	 * the format of an array of arrays like this:
	 *
	 * array(
	 * 'field' => 'email',
	 * 'label' => 'Email',
	 * 'rules' => 'required|valid_email'
	 */
	public function validation_array($stream, $stream_namespace = null, $method = 'new', $skips = array(), $row_id = null)
	{
		$str_id = $this->stream_id($stream, $stream_namespace);
		
		if ( ! $str_id) $this->log_error('invalid_stream', 'validation_array');

		$stream_fields = ci()->streams_m->get_stream_fields($str_id);

		return ci()->fields->set_rules($stream_fields, $method, $skips, true, $row_id);
	}	
}