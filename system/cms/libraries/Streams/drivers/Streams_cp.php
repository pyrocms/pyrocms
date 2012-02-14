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
	 * @param	string - the stream slug
	 * @param	string - the stream namespace slug
	 * @param	[mixed - pagination, either null for no pagination or a number for per page]
	 * @param	[null - pagination uri without offset]
	 * @param	[array - buttons to show for each row]
	 *				arrray = 
	 *					array = (
	 *						'label'		=> 'Delete',
	 *						'url'		=> 'admin/streams_sample/delete/-entry_id-',
	 *						'confirm'	= true
	 *				));
	 * @param	[bool - setting this to true will take care of the $this->template business
	 * @return	object
	 */
	function entries_table($stream_slug, $namespace_slug, $pagination = null, $pagination_uri = null, $buttons = array(), $view_override = false)
	{
		$CI = get_instance();
		
		// Get stream
		$stream = $this->stream_obj($stream_slug, $namespace_slug);
		if ( ! $stream) $this->log_error('invalid_stream', 'entries_table');

 		// -------------------------------------
		// Get Header Fields
		// -------------------------------------
		
 		$stream_fields = $CI->streams_m->get_stream_fields($stream->id);
 		
  		$stream_fields->id->field_name 				= lang('streams.id');
		$stream_fields->created->field_name 		= lang('streams.created_date');
 		$stream_fields->updated->field_name 		= lang('streams.updated_date');
 		$stream_fields->created_by->field_name 		= lang('streams.created_by');

 		// -------------------------------------
		// Find offset URI from array
		// -------------------------------------
		
		if (is_numeric($pagination))
		{
			$segs = explode('/', $pagination_uri);
			$offset_uri = count($segs)+1;
	
	 		$offset = $CI->uri->segment($offset_uri, 0);
  		}

		// Stuff below is not supported via the API yet
		/*if ($stream->sorting == 'custom')
		{
			// We need some variables to use in the sort. I guess.
			$this->template->append_metadata('<script type="text/javascript" language="javascript">var stream_id='.$this->data->stream->id.';var stream_offset='.$offset.';</script>');
		
			// We want to sort this
		    //$this->template->append_js('entry_sorting.js', 'streams');
		    		      
			// Comeon' Livequery! You're goin' in!
			//$this->template->append_metadata( js('jquery.livequery.js', 'streams') );
		}*/
  
  		$data = array(
  			'stream'		=> $stream,
  			'stream_fields'	=> $stream_fields,
  			'buttons'		=> $buttons
  		);
  
 		// -------------------------------------
		// Get Entries
		// -------------------------------------
		
		$limit = ($pagination) ? $pagination : null;
	
		$data['entries'] = $CI->streams_m->get_stream_data(
														$stream,
														$stream_fields, 
														$limit,
														$offset);

		// -------------------------------------
		// Pagination
		// -------------------------------------

		$data['pagination'] = create_pagination(
									$pagination_uri,
									$CI->db->count_all($stream->stream_prefix.$stream->stream_slug),
									$pagination,
									$offset_uri
								);
		
		// -------------------------------------
		// Build Pages
		// -------------------------------------
		
		$table = $CI->load->view('admin/partials/streams/entries', $data, true);
		
		if ($view_override)
		{
			// Hooray, we are building the template ourself.
			$CI->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
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
	function form($stream_slug, $namespace_slug, $mode = 'new', $entry = null, $view_override = false, $extra = array(), $skips = array())
	{
		$CI = get_instance();
	
		$stream = $this->stream_obj($stream_slug, $namespace_slug);
		if ( ! $stream) $this->log_error('invalid_stream', 'form');

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