<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Control Panel Driver
 *
 * Contains functions that allow for
 * constructing PyrCMS stream control
 * panel elements.
 *
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
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
	 * @param	[array - extra params (see below)]
	 * @param	[array - fields to skip]	 
	 * @return	object
	 *
	 * Extra parameters to pass in $extra array:
	 *
     * email_notifications 	- see docs for more explanaiton
     * return				- URL to return to after submission
     *							defaults to current URL.
     * success_message		- Flash message to show after successful submission
     *							defaults to generic successful entry submission message
     * failure_message		- Flash message to show after failed submission,
     *							defaults to generic failed entry submission message
     * required				- String to show as required - this defaults to the
     *							standard * for the PyroCMS CP
     * title				- Title of the form header (if using view override)
	 */
	function form($stream_slug, $namespace, $mode = 'new', $entry = null, $view_override = false, $extra = array(), $skips = array())
	{
		$CI = get_instance();
	
		$stream = $this->stream_obj($stream_slug, $namespace);
		
		if ( ! $stream) $this->log_error('invalid_stream', 'delete_stream');

		// Load up things we'll need for the form
		$CI->load->library(array('form_validation', 'streams_core/Streams_validation', 'streams_core/Fields'));
		
		$fields = $CI->fields->build_form($stream, $mode, $entry, false, false, $skips, $extra);
		
		$data = array(
					'fields' 	=> $fields,
					'stream'	=> $stream,
					'entry'		=> $entry,
					'mode'		=> $mode);
		
		// Set title
		if (isset($extra['title']))
		{
			$data['title'] = $extra['title'];
		}
		
		$form = $CI->load->view('admin/partials/streams/form', $data, true);
		
		if ($view_override === false) return $form;
		
		$CI->data->content = $form;
		
		$CI->template->build('admin/partials/blank_section', $CI->data);
	}
	
}