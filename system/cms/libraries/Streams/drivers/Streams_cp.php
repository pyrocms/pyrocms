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
	 * Entries Table
	 *
	 * Creates a table of entries.
 	 *
	 * @access	public
	 * @param	string - the stream slug
	 * @param	string - the stream namespace slug
	 * @param	[mixed - pagination, either null for no pagination or a number for per page]
	 * @param	[null - pagination uri without offset]
	 * @param	[bool - setting this to true will take care of the $this->template business
	 * @param	[array - extra params (see below)]
	 * @return	mixed - void or string
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * title	- Title of the page header (if using view override)
	 *			$extra['title'] = 'Streams Sample';
	 * 
	 * buttons	- an array of buttons (if using view override)
	 *			$extra['buttons'] = array(
	 *				'label' 	=> 'Delete',
	 *				'url'		=> 'admin/streams_sample/delete/-entry_id-',
	 *				'confirm'	= true
	 *			);
	 *
	 * see docs for more explanation
	 */
	function entries_table($stream_slug, $namespace_slug, $pagination = null, $pagination_uri = null, $view_override = false, $extra = array())
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
		    //$this->template->append_js('module::entry_sorting.js');
		    		      
			// Comeon' Livequery! You're goin' in!
			//$this->template->append_js('module::jquery.livequery.js');
		}*/
  
  		$data = array(
  			'stream'		=> $stream,
  			'stream_fields'	=> $stream_fields,
  			'buttons'		=> isset($extra['buttons']) ? $extra['buttons'] : NULL,
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
		
		// Set title
		if (isset($extra['title']))
		{
			$CI->template->title($extra['title']);
		}
		
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
	 * Entry Form
	 *
	 * Creates an entry form for a stream.
	 *
	 * @access	public
	 * @param	string - stream slug
	 * @param	string - stream namespace
	 * @param	mode - new or edit
	 * @param	[array - current entry data]
	 * @param	[bool - view override - setting this to true will build template]
	 * @param	[array - extra params (see below)]
	 * @param	[array - fields to skip]	 
	 * @return	mixed - void or string
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * email_notifications 	- see docs for more explanation
	 * return				- URL to return to after submission
	 * 							defaults to current URL.
	 * success_message		- Flash message to show after successful submission
	 * 							defaults to generic successful entry submission message
	 * failure_message		- Flash message to show after failed submission,
	 * 							defaults to generic failed entry submission message
	 * required				- String to show as required - this defaults to the
	 * 							standard * for the PyroCMS CP
	 * title				- Title of the form header (if using view override)
	 */
	function entry_form($stream_slug, $namespace_slug, $mode = 'new', $entry_id = null, $view_override = false, $extra = array(), $skips = array())
	{
		$CI = get_instance();
	
		$stream = $this->stream_obj($stream_slug, $namespace_slug);
		if ( ! $stream) $this->log_error('invalid_stream', 'form');

		// Load up things we'll need for the form
		$CI->load->library(array('form_validation', 'streams_core/Fields'));
	
		if ($mode == 'edit')
		{
			if( ! $entry = $CI->row_m->get_row($entry_id, $stream, false))
			{
				$this->log_error('invalid_row', 'form');
			}
		}
		else
		{
			$entry = null;
		}

		$fields = $CI->fields->build_form($stream, $mode, $entry, false, false, $skips, $extra);

		// Get the entry
		
		$data = array(
					'fields' 	=> $fields,
					'stream'	=> $stream,
					'entry'		=> $entry,
					'mode'		=> $mode);
		
		// Set title
		if (isset($extra['title']))
		{
			$CI->template->title($extra['title']);
		}
		// Set return uri
		if (isset($extra['return']))
		{
			$data['return'] = $extra['return'];
		}
		
		$CI->template->append_js('streams/entry_form.js');
		
		$form = $CI->load->view('admin/partials/streams/form', $data, true);
		
		if ($view_override === false) return $form;
		
		$CI->data->content = $form;
		
		$CI->template->build('admin/partials/blank_section', $CI->data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Custom Field Form
	 *
	 * Creates a custom field form.
	 *
	 * This allows you to easily create a form that users can
	 * use to add new fields to a stream. This functions as the
	 * form assignment as well.
	 *
	 * @access	public
	 * @param	string - stream slug
	 * @param	string - namespace
	 * @param 	string - method - new or edit. defaults to new
	 * @param 	string - uri to return to after success/fail
	 * @param 	[int - the assignment id if we are editing]
	 * @param	[array - field types to include]
	 * @param	[bool - view override - setting this to true will build template]
	 * @param	[array - extra params (see below)]
	 * @return	mixed - void or string
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * title	- Title of the form header (if using view override)
	 *			$extra['title'] = 'Streams Sample';
	 * 
	 * see docs for more explanation
	 */
	public function field_form($stream_slug, $namespace, $method = 'new', $return, $assign_id = null, $include_types = array(), $view_override = false, $extra = array())
	{
		$CI = get_instance();
		$data = array();
		$data['field'] = new stdClass();
		
		// We always need our stream
		$stream = $this->stream_obj($stream_slug, $namespace);
		if ( ! $stream) $this->log_error('invalid_stream', 'form');

		// -------------------------------------
		// Field Type Assets
		// -------------------------------------
		// These are assets field types may
		// need when adding/editing fields
		// -------------------------------------
   		
   		$CI->type->load_field_crud_assets();
   		
   		// -------------------------------------
        
        	// Need this for the view
        	$data['method'] = $method;
        
        	// Get our list of available fields
		$data['field_types'] = $CI->type->field_types_array(true);

		// @todo - allow including/excluding some fields

		// -------------------------------------
		// Get the field if we have the assignment
		// -------------------------------------
		// We'll always work off the assignment.
		// -------------------------------------

		if ($method == 'edit' and is_numeric($assign_id))
		{
			$assignment = $CI->db->limit(1)->where('id', $assign_id)->get(ASSIGN_TABLE)->row();

			// If we have no assignment, we can't continue
			if ( ! $assignment) show_error('Could not find assignment');

			// Find the field now
			$data['current_field'] = $CI->fields_m->get_field($assignment->field_id);

			// We also must have a field if we're editing
			if ( ! $data['current_field']) show_error('Could not find field.');
		}
		else
		{
			$data['current_field'] = null;
		}

		// -------------------------------------
		// Validation & Setup
		// -------------------------------------

		// Add in the unique callback
		if ($method == 'new')
		{
			$CI->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug[new:'.$namespace.']';
		}
		else
		{
			// @todo edit version of this.
			$CI->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug['.$data['current_field']->field_slug.':'.$namespace.']';
		}

		$assign_validation = array(
			array(
				'field'	=> 'is_required',
				'label' => 'Is Required', // @todo languagize
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'is_unique',
				'label' => 'Is Unique', // @todo languagize
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'instructions',
				'label' => 'Instructions', // @todo languageize
				'rules'	=> 'trim'
			)
		);

		// Get all of our valiation into one super validation object
		$validation = array_merge($CI->fields_m->fields_validation, $assign_validation);

		$CI->form_validation->set_rules($validation);

		// -------------------------------------
		// Process Data
		// -------------------------------------
		
		if ($CI->form_validation->run())
		{
			if ($method == 'new')
			{
				if ( ! $CI->fields_m->insert_field(
									$CI->input->post('field_name'),
									$CI->input->post('field_slug'),
									$CI->input->post('field_type'),
									$namespace,
									$CI->input->post()
					))
				{
				
					$CI->session->set_flashdata('notice', lang('streams.save_field_error'));	
				}
				else
				{
					// Add the assignment
					if( ! $CI->streams_m->add_field_to_stream($CI->db->insert_id(), $stream->id, $CI->input->post()))
					{
						$CI->session->set_flashdata('notice', lang('streams.save_field_error'));	
					}
					else
					{
						$CI->session->set_flashdata('success', lang('streams.field_add_success'));	
					}
				}
			}
			else
			{
				if ( ! $CI->fields_m->update_field(
									$data['current_field'],
									array_merge($CI->input->post(), array('field_namespace' => $namespace))
					))
				{
				
					$CI->session->set_flashdata('notice', lang('streams.save_field_error'));	
				}
				else
				{
					// Add the assignment
					if( ! $CI->fields_m->edit_assignment(
										$assign_id,
										$stream,
										$data['current_field'],
										$CI->input->post()
									))
					{
						$CI->session->set_flashdata('notice', lang('streams.save_field_error'));	
					}
					else
					{
						$CI->session->set_flashdata('success', lang('streams.field_update_success'));
					}
				}

			}
	
			redirect($return);
		}

		// -------------------------------------
		// See if we need our param fields
		// -------------------------------------
		
		if ($CI->input->post('field_type') or $method == 'edit')
		{
			// Figure out where this is coming from - post or data
			if ($CI->input->post('field_type'))
			{
				$field_type = $CI->input->post('field_type');
			}
			else
			{
				$field_type = $data['current_field']->field_type;
			}
		
			if (isset($CI->type->types->{$field_type}))
			{
				// Get the type so we can use the custom params
				$data['current_type'] = $CI->type->types->{$field_type};
				
				// Get our standard params
				require_once(PYROSTEAMS_DIR.'libraries/Parameter_fields.php');
				
				$data['parameters'] = new Parameter_fields();
				
				if ( ! is_array($data['current_field']->field_data))
				{
					$data['current_field']->field_data = array();				
				}

				if (isset($data['current_type']->custom_parameters) and is_array($data['current_type']->custom_parameters))
				{
					// Build items out of post data
					foreach ($data['current_type']->custom_parameters as $param)
					{
						if ( ! isset($_POST[$param]) and $method == 'edit')
						{
							if (isset($data['current_field']->field_data[$param]))
							{
								$data['current_field']->field_data[$param] = $data['current_field']->field_data[$param];
							}
						}
						else
						{
							$$data['current_field']->field_data[$param] = $CI->input->post($param);
						}
					}
				}
			}
		}

		// -------------------------------------
		// Set our data for the form	
		// -------------------------------------

		foreach ($validation as $field)
		{
			if ( ! isset($_POST[$field['field']]) and $method == 'edit')
			{
				// We don't know where the value is. Hooray
				if (isset($data['current_field']->{$field['field']}))
				{
					$data['field']->{$field['field']} = $data['current_field']->{$field['field']};
				}
				else
				{
					$data['field']->{$field['field']} = $assignment->{$field['field']};
				}
			}
			else
			{
				$data['field']->{$field['field']} = $CI->input->post($field['field']);
			}
		}

		// -------------------------------------
		// Run field setup events
		// -------------------------------------

		$CI->fields->run_field_setup_events($stream, $method, $data['current_field']);

		// -------------------------------------
		// Build page
		// -------------------------------------

		$CI->template->append_js('streams/fields.js');

		// Set title
		if (isset($extra['title']))
		{
			$CI->template->title($extra['title']);
		}

		$table = $CI->load->view('admin/partials/streams/field_form', $data, true);
		
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
	 * Fields Table
	 *
	 * Easily create a table of fields in a certain namespace
	 *
	 * @param	string - the stream slug
	 * @param	string - the stream namespace slug
	 * @param	[mixed - pagination, either null for no pagination or a number for per page]
	 * @param	[null - pagination uri without offset]
	 * @param	[bool - setting this to true will take care of the $this->template business
	 * @param	[array - extra params (see below)]
	 * @param	[array - fields to skip]
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * title	- Title of the page header (if using view override)
	 *			$extra['title'] = 'Streams Sample';
	 * 
	 * buttons	- an array of buttons (if using view override)
	 *			$extra['buttons'] = array(
	 *				'label' 	=> 'Delete',
	 *				'url'		=> 'admin/streams_sample/delete/-entry_id-',
	 *				'confirm'	= true
	 *			);
	 *
	 * see docs for more explanation
	 */
	public function fields_table($namespace, $pagination = null, $pagination_uri = null, $view_override = false, $extra = array(), $skips = array())
	{
		$CI = get_instance();
		$data['buttons'] = isset($extra['buttons']) ? $extra['buttons'] : NULL;

		if (is_numeric($pagination))
		{
			$segs = explode('/', $pagination_uri);
			$offset_uri = count($segs)+1;
	
	 		$offset = $CI->uri->segment($offset_uri, 0);
  		}
		else
		{
			$offset = 0;
		}

		// -------------------------------------
		// Get fields
		// -------------------------------------

		if (is_numeric($pagination))
		{	
			$data['fields'] = $CI->fields_m->get_fields($namespace, $pagination, $offset, $skips);
		}
		else
		{
			$data['fields'] = $CI->fields_m->get_fields($namespace, FALSE, 0, $skips);
		}

		// -------------------------------------
		// Pagination
		// -------------------------------------

		if (is_numeric($pagination))
		{	
			$data['pagination'] = create_pagination(
											$pagination_uri,
											$CI->fields_m->count_fields($namespace),
											$pagination,
											$offset
										);
		}
		else
		{ 
			$data['pagination'] = FALSE;
		}

		// Allow view to inherit custom 'Add Field' uri
		$data['add_uri'] = isset($extra['add_uri']) ? $extra['add_uri'] : NULL;
		
		// -------------------------------------
		// Build Pages
		// -------------------------------------

		// Set title
		if (isset($extra['title']))
		{
			$CI->template->title($extra['title']);
		}

		$table = $CI->load->view('admin/partials/streams/fields', $data, true);
		
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
	 * Field Assignments Table
	 *
	 * Easily create a table of fields in a certain namespace
	 *
	 * @param	string - the stream slug
	 * @param	string - the stream namespace slug
	 * @param	[mixed - pagination, either null for no pagination or a number for per page]
	 * @param	[null - pagination uri without offset]
	 * @param	[bool - setting this to true will take care of the $this->template business
	 * @param	[array - extra params (see below)]
	 * @param	[array - fields to skip]
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * title	- Title of the page header (if using view override)
	 *			$extra['title'] = 'Streams Sample';
	 * 
	 * buttons	- an array of buttons (if using view override)
	 *			$extra['buttons'] = array(
	 *				'label' 	=> 'Delete',
	 *				'url'		=> 'admin/streams_sample/delete/-entry_id-',
	 *				'confirm'	= true
	 *			);
	 *
	 * see docs for more explanation
	 */
	public function assignments_table($stream_slug, $namespace, $pagination = null, $pagination_uri = null, $view_override = false, $extra = array(), $skips = array())
	{
		$CI = get_instance();
		$data['buttons'] = $extra['buttons'];

		// Get stream
		$stream = $this->stream_obj($stream_slug, $namespace);
		if ( ! $stream) $this->log_error('invalid_stream', 'assignments_table');

		if (is_numeric($pagination))
		{
			$segs = explode('/', $pagination_uri);
			$offset_uri = count($segs)+1;
	
	 		$offset = $CI->uri->segment($offset_uri, 0);
  		}
		else
		{
			$offset = 0;
		}

		// -------------------------------------
		// Get assignments
		// -------------------------------------

		if (is_numeric($pagination))
		{	
			$data['assignments'] = $CI->streams_m->get_stream_fields($stream->id, $pagination, $offset, $skips);
		}
		else
		{
			$data['assignments'] = $CI->streams_m->get_stream_fields($stream->id, null, 0, $skips);
		}

		// -------------------------------------
		// Get number of fields total
		// -------------------------------------
		
		$data['total_existing_fields'] = $CI->fields_m->count_fields($namespace);

		// -------------------------------------
		// Pagination
		// -------------------------------------

		if (is_numeric($pagination))
		{	
			$data['pagination'] = create_pagination(
											$pagination_uri,
											$CI->fields_m->count_fields($namespace),
											$pagination,
											$offset
										);
		}
		else
		{ 
			$data['pagination'] = FALSE;
		}

		// Allow view to inherit custom 'Add Field' uri
		$data['add_uri'] = isset($extra['add_uri']) ? $extra['add_uri'] : NULL;

		// -------------------------------------
		// Build Pages
		// -------------------------------------

		// Set title
		if (isset($extra['title']))
		{
			$CI->template->title($extra['title']);
		}
		
		$CI->template->append_metadata('<script>var fields_offset='.$offset.';</script>');
		$CI->template->append_js('streams/assignments.js');

		$table = $CI->load->view('admin/partials/streams/assignments', $data, true);
		
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
	 * Tear down assignment + field combo
	 *
	 * Usually we'd just delete the assignment,
	 * but we need to delete the field as well since
	 * there is a 1-1 relationship here.
	 *
	 * @access 	public
	 * @param 	int - assignment id
	 * @param 	bool - force delete field, even if it is shared with multiple streams
	 * @return 	bool - success/fail
	 */
	public function teardown_assignment_field($assign_id, $force_delete = FALSE)
	{
		$CI = get_instance();

		// Get the assignment
		$assignment = $CI->db->limit(1)->where('id', $assign_id)->get(ASSIGN_TABLE)->row();

		if ( ! $assignment)
		{
			$this->log_error('invalid_assignment', 'teardown_assignment_field');
		}
		
		// Get stream
		$stream = $CI->streams_m->get_stream($assignment->stream_id);

		// Get field
		$field = $CI->fields_m->get_field($assignment->field_id);

		// Delete the assignment
		if ( ! $CI->streams_m->remove_field_assignment($assignment, $field, $stream))
		{
			$this->log_error('invalid_assignment', 'teardown_assignment_field');
		}
		
		// Remove the field only if unlocked and assigned once
		if ($field->is_locked == 'no' or $CI->fields_m->count_assignments($assignment->field_id) == 1 or $force_delete)
		{
			// Remove the field
			return $CI->fields_m->delete_field($field->id);
		}
	}

}
