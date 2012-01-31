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
 * Control Panel Driver
 *
 * Contains functions that allow for
 * constructing PyrCMS stream control
 * panel elements.
 *
 * @package  	Streams API
 * @category  	Drivers
 * @author  	Parse19
 */ 
 
class Streams_cp extends CI_Driver {

	/**
	 * Create a table of entries
 	 *
	 * @access	public
	 * @param	[int - limit]
	 * @param	[int - offset]
	 * @return	object
	 */
	function table($entries, $view_override)
	{
		
	}

	// --------------------------------------------------------------------------

	/**
	 * Get all fields, regardless
	 * of stream
	 *
	 * @access	public
	 * @param	string - stream slug
	 * @param	string - stream namespace
	 * @param	mode - new or edit
	 * @param	[array - current entry data]
	 * @param	[bool - view override - setting this to true will build template]
	 * @param	[array - fields to skip]
	 * @return	object
	 */
	function form($stream_slug, $namespace, $mode = 'new', $entry = NULL, $view_override = FALSE, $skips = array())
	{
		$CI = get_instance();
	
		$stream = $this->stream_obj($stream_slug, $namespace);
		
		if ( ! $stream) $this->log_error('invalid_stream', 'delete_stream');

		// Load up things we'll need for the form
		$CI->load->library(array('form_validation', 'streams_core/Streams_validation', 'streams_core/Fields'));
		
		$fields = $CI->fields->build_form($stream, $mode, $entry, FALSE, FALSE, $skips);
		
		$data = array(
					'fields' 	=> $fields,
					'stream'	=> $stream,
					'entry'		=> $entry,
					'mode'		=> $mode);
		
		$form = $CI->load->view('admin/partials/streams/form', $data, TRUE);
		
		if ($view_override === FALSE) return $form;
		
		$CI->data->content = $form;
		
		$CI->template->build('admin/partials/blank_section', get_instance()->data);
	}
	
}