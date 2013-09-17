<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Entries Driver
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
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
			'stream'			=> null,
			'namespace'			=> null,
			'limit'				=> null,
			'offset'			=> 0,
			'single'			=> 'no',
			'id'				=> null,
			'date_by'			=> 'created',
			'year'				=> null,
			'month'				=> null,
			'day'				=> null,
			'show_upcoming'		=> 'yes',
			'show_past'			=> 'yes',
			'restrict_user'		=> 'no',
			'where'				=> null,
			'exclude'			=> null,
			'exclude_by'		=> 'id',
			'include'			=> null,
			'include_by'		=> 'id',
			'disable'			=> null,
			'order_by'			=> 'created',
			'sort'				=> 'desc',
			'exclude_called'	=> 'no',
			'paginate'			=> 'no',
			'pag_method'		=> 'offset', 	// 'offset' or 'page'
			'pag_uri_method'	=> 'segment',	// 'segment' or 'query_string'
			'pag_segment'		=> 2,
			'pag_query_var'		=> 'page',		// Only used if 'pag_uri_method' is query_string
			'pag_base'			=> null, 		// If null, this is automatically set
			'partial'			=> null,
			'site_ref'			=> SITE_REF,
			'cache_query'		=> false, 		// Should we cache the query?
			'cache_folder'		=> 'streams_query',	// The folder to place the cache
			'cache_expires'		=> null,		// Expiration in seconds for cache
	);

	// --------------------------------------------------------------------------

	/**
	 * Pagination Config
	 *
	 * These are the available pagination config variables
	 * that are available to override.
	 *
	 * @access 	public
	 * @var 	array
	 */
	public $pag_config = array('num_links', 'full_tag_open', 'full_tag_close', 'first_link', 'first_tag_open', 'first_tag_close', 'prev_link', 'prev_tag_open', 'prev_tag_close', 'cur_tag_open', 'cur_tag_close', 'num_tag_open', 'num_tag_close', 'next_link', 'next_tag_open', 'next_tag_close', 'last_link', 'last_tag_open', 'last_tag_close', 'suffix', 'first_url',  'reuse_query_string');

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

		$CI = get_instance();
		
		// -------------------------------------
		// Set Parameters
		// -------------------------------------

		if ( ! $skip_params)
		{
			foreach ($this->entries_params as $param => $default)
			{
				if ( ! isset($params[$param]) and ! is_null($this->entries_params[$param])) $params[$param] = $default;
			}
		}
	
		// -------------------------------------
		// Stream Data Check
		// -------------------------------------
		
		if ( ! isset($params['stream'])) $this->log_error('no_stream_provided', 'get_entries');
				
		if ( ! isset($params['namespace'])) $this->log_error('no_namespace_provided', 'get_entries');
	
		$stream = $CI->streams_m->get_stream($params['stream'], true, $params['namespace']);
				
		if ( ! $stream) $this->log_error('invalid_stream', 'get_entries');

		// -------------------------------------
		// Allow 'yes'/'no' fields to be bool
		// -------------------------------------
		// Inputs are yes/no because that's what
		// the row parser expects them to be. This
		// is because early on the row parser JUST took
		// inputs from the streams plugin and param
		// values could not be bool. So this should
		// definitely be changed in the future. This is
		// a workaround so devs can use true/false
		// instead of having to use 'yes'/'no' like
		// common savages.
		// -------------------------------------

		$bool_inputs = array('show_upcoming', 'show_past', 'exclude_called', 'restrict_user', 'paginate');

		foreach ($bool_inputs as $input)
		{
			if (isset($params[$input]))
			{
				if ($params[$input] === true)
				{
					$params[$input] = 'yes';
				}
				elseif ($params[$input] === false)
				{
					$params[$input] = 'no';
				}
			}
		}

		// -------------------------------------
		// Pagination Limit
		// -------------------------------------

		if ($params['paginate'] == 'yes' and ( ! isset($params['limit']) or ! is_numeric($params['limit']))) $params['limit'] = 25;

		// -------------------------------------
		// Get Rows
		// -------------------------------------

		$rows = $CI->row_m->get_rows($params, null, $stream);
		
		$return['entries'] = $rows['rows'];
				
		// -------------------------------------
		// Pagination
		// -------------------------------------
		
		if ($params['paginate'] == 'yes')
		{
			$return['total'] 	= $rows['pag_count'];
			
			$params['pag_base'] = (isset($params['pag_base'])) ? $params['pag_base'] : null;

			$return['pagination'] = $CI->row_m->build_pagination($params['pag_segment'], $params['limit'], $return['total'], $pagination_config, $params['pag_base']);
		}		
		else
		{
			$return['pagination'] 	= null;
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
	public function get_entry($entry_id, $stream, $namespace, $format = true, $plugin_call = true)
	{
		return get_instance()->row_m->get_row($entry_id, $this->stream_obj($stream, $namespace), $format, $plugin_call);
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
	public function delete_entry($entry_id, $stream, $namespace)
	{
		return get_instance()->row_m->delete_row($entry_id, $this->stream_obj($stream, $namespace));
	}

	// --------------------------------------------------------------------------

	/**
	 * Insert an entry
	 *
	 * This will be run through the streams data
	 * processing.
	 *
	 * @access	public
	 * @param	array - entry data
	 * @param	stream - int, slug, or obj
	 * @param 	string - namespace
	 * @param 	array - field slugs to skip
	 * @param 	array - extra data to add in
	 * @return	object
	 */
	public function insert_entry($entry_data, $stream, $namespace, $skips = array(), $extra = array())
	{
		$str_obj = $this->stream_obj($stream, $namespace);
		
		if ( ! $str_obj) $this->log_error('invalid_stream', 'insert_entry');

		$CI = get_instance();

		$stream_fields = $CI->streams_m->get_stream_fields($str_obj->id);

		return $CI->row_m->insert_entry($entry_data, $stream_fields, $str_obj, $skips, $extra);
	}

	// --------------------------------------------------------------------------

	/**
	 * Update an entry
	 *
	 * @param	int - entry id
	 * @param	array - entry data
	 * @param	stream - int, slug, or obj
	 * @param 	string - namespace
	 * @param 	array - field slugs to skip
	 * @param 	array - assoc array of extra data to add
	 * @param 	bool - update only the passed values?
	 * @return	object
	 */
	public function update_entry($entry_id, $entry_data, $stream, $namespace, $skips = array(), $extra = array(), $include_only_passed = true)
	{
		$str_obj = $this->stream_obj($stream, $namespace);
		
		if ( ! $str_obj) $this->log_error('invalid_stream', 'update_entry');

		$CI = get_instance();

		$stream_fields = $CI->streams_m->get_stream_fields($str_obj->id);

		return $CI->row_m->update_entry($stream_fields, $str_obj, $entry_id, $entry_data, $skips, $extra, $include_only_passed);
	}
	
}
