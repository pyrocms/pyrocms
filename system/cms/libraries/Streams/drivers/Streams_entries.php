<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams API Library
 *
 * @package  	Streams API
 * @category  	Libraries
 * @author  	Parse19
 */

// --------------------------------------------------------------------------
 
/**
 * Entries Driver
 *
 * @package  	Streams API
 * @category  	Drivers
 * @author  	Parse19
 */ 
 
class Streams_entries extends CI_Driver {

	/**
	 * Available entry parameters
	 * and their defaults.
	 *
	 * @access	public
	 * @var		array
	 */
	public $entries_params = array(
			'stream'			=> NULL,
			'namespace'			=> NULL,
			'limit'				=> NULL,
			'offset'			=> 0,
			'single'			=> 'no',
			'id'				=> NULL,
			'date_by'			=> 'created',
			'year'				=> NULL,
			'month'				=> NULL,
			'day'				=> NULL,
			'show_upcoming'		=> 'yes',
			'show_past'			=> 'yes',
			'restrict_user'		=> 'no',
			'where'				=> NULL,
			'exclude'			=> NULL,
			'exclude_by'		=> 'id',
			'disable'			=> NULL,
			'order_by'			=> NULL,
			'sort'				=> 'asc',
			'exclude_called'	=> 'no',
			'paginate'			=> 'no',
			'pag_segment'		=> 2
	);

	// --------------------------------------------------------------------------

	/**
	 * Pagination Config
	 *
	 * These are the CI defaults that can be
	 * overridden by PyroStreams.
	 *
	 * @access	public
	 * @var		array
	 */
	public $pagination_config = array(
			'num_links'			=> 3,
			'full_tag_open'		=> '<p>',
			'full_tag_close'	=> '</p>',
			'first_link'		=> 'First',
			'first_tag_open'	=> '<div>',
			'first_tag_close'	=> '</div>',
			'last_link'			=> 'Last',
			'last_tag_open'		=> '<div>',
			'last_tag_close'	=> '</div>',
			'next_link'			=> '&gt;',
			'next_tag_open'		=> '<div>',
			'next_tag_close'	=> '</div>',
			'prev_link'			=> '&lt;',
			'prev_tag_open'		=> '<div>',
			'prev_tag_close'	=> '</div>',
			'cur_tag_open'		=> '<span>',
			'cur_tag_close'		=> '</span>',
			'num_tag_open'		=> '<div>',
			'num_tag_close'		=> '</div>'
	);

	// --------------------------------------------------------------------------

	/**
	 * Get entries for a stream.
	 *
	 * @access	public
	 * @param	array - parameters
	 * @param	[array - pagination config]
	 * @param	[bool - should we not do param defaults? Use with caution.]
	 * @return	array
	 */
	public function get_entries($params, $pagination_config = array(), $skip_params = false)
	{
		$return = array();
		
		print_r($params);
		
		// -------------------------------------
		// Set Parameters
		// -------------------------------------

		if ( ! $skip_params)
		{
			foreach ($this->entries_params as $param => $default)
			{
				if ( ! isset($params[$param]) and !is_null($this->entries_params[$param])) $params[$param] = $default;
			}
		}
	
		// -------------------------------------
		// Stream Data Check
		// -------------------------------------
		
		if ( ! isset($params['stream'])) $this->log_error('no_stream_provided', 'get_entries');
				
		if ( ! isset($params['namespace'])) $this->log_error('no_namespace_provided', 'get_entries');
	
		$stream = $this->CI->streams_m->get_stream($params['stream'], TRUE, $params['namespace']);
				
		if ( ! $stream) $this->log_error('invalid_stream', 'get_entries');

		// -------------------------------------
		// Pagination Limit
		// -------------------------------------

		if ($params['paginate'] == 'yes' AND ( ! isset($params['limit']) OR ! is_numeric($params['limit']))) $params['limit'] = 25;
				
		// -------------------------------------
		// Get Stream Fields
		// -------------------------------------
				
		$this->fields = $this->CI->streams_m->get_stream_fields($stream->id);

		// -------------------------------------
		// Get Rows
		// -------------------------------------

		$rows = $this->CI->row_m->get_rows($params, $this->fields, $stream);
		
		$return['entries'] = $rows['rows'];
				
		// -------------------------------------
		// Pagination
		// -------------------------------------
		
		if ($params['paginate'] == 'yes')
		{
			$return['total'] 	= $rows['pag_count'];
			
			// Add in our pagination config
			// override varaibles.
			foreach ($this->pagination_config as $key => $var)
			{
				if (isset($pagination_config[$key])) $this->pagination_config = $pagination_config[$key];
				
				// Make sure we set the FALSE params to boolean
				if ($this->pagination_config[$key] == 'FALSE') $this->pagination_config[$key] = FALSE;
			}
			
			$return['pagination'] = $this->CI->row_m->build_pagination($params['pag_segment'], $params['limit'], $return['total'], $this->pagination_config);
		}		
		else
		{
			$return['pagination'] 	= NULL;
			$return['total'] 		= count($return['entries']);
		}

		// -------------------------------------
	
		return $return;
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a single entry
	 *
	 * @access	public
	 * @param	int - entry id
	 * @param	stream - int, slug, or obj
	 * @param	bool - format results?
	 * @return	object
	 */
	function get_entry($entry_id, $stream, $namespace = NULL, $format = TRUE)
	{
		return $this->row_m->get_row($entry_id, $this->stream_obj($stream, $namespace), $format);
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete an entry
	 *
	 * @access	public
	 * @param	int - entry id
	 * @param	stream - int, slug, or obj
	 * @return	object
	 */
	function delete_entry($entry_id, $stream, $namespace = NULL)
	{
		return $this->CI->row_m->delete_row($entry_id, $this->stream_obj($stream, $namespace));
	}

	// --------------------------------------------------------------------------

	/**
	 * Update an entry
	 *
	 * @access	public
	 * @param	int - entry id
	 * @return	object
	 */
	function update_entry($entry_id, $data)
	{
		
	}
	
}