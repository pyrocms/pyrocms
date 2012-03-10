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
	 * @param	[array - buttons to show for each row]
	 *				arrray = 
	 *					array = (
	 *						'label'		=> 'Delete',
	 *						'url'		=> 'admin/streams_sample/delete/-entry_id-',
	 *						'confirm'	= true
	 *				));
	 * @param	[bool - setting this to true will take care of the $this->template business
	 * @return	mixed - void or string
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
		    //$this->template->append_js('module::entry_sorting.js');
		    		      
			// Comeon' Livequery! You're goin' in!
			//$this->template->append_js('module::jquery.livequery.js');
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

	// --------------------------------------------------------------------------

	/**
	 * Custom Field Form
	 *
	 * Creates a custom field form.
	 *
	 * This allows you to easily create a form that users can
	 * use to add new fields to a stream. They don't need to assign
	 * them, this CP function takes care of that automatically.
	 *
	 * @access	public
	 * @param	string - stream slug
	 * @param	string - namespace
	 * @param	[array - field types to include]
	 * @param	[bool - view override - setting this to true will build template]
	 * @return	mixed - void or string
	 */
	public function field_form($stream_slug, $namespace, $method = 'new', $assign_id = null, $include_types = array(), $view_override = false)
	{
		$CI = get_instance();
		
		$data = array();

		// -------------------------------------
		// Field Type Assets
		// -------------------------------------
		// These are assets field types may
		// need when adding/editing fields
		// -------------------------------------
   		
   		$CI->type->load_field_crud_assets();
   		
   		// -------------------------------------
        
        $data['method'] = $method;
        
        // Prep the fields
        // @todo - implement include_types
		$data['field_types'] = $CI->type->field_types_array(true);

		// -------------------------------------
		// Validation & Setup
		// -------------------------------------
		
		// Manually add in the unique_field_slug callback
		if ($method == 'new')
		{
			$CI->fields_m->fields_validation[1]['rules'] .= '|unique_field_slug[new]';
		}
		else
		{
			$CI->fields_m->fields_validation[1]['rules'] .= '|unique_field_slug['.$data['current_field']->field_slug.']';
		}

		$CI->streams_validation->set_rules($CI->fields_m->fields_validation);
				
		foreach ($this->fields_m->fields_validation as $field)
		{
			$key = $field['field'];
			
			if ( ! isset($_POST[$key]))
			{
				$data['field']->$key = $data['current_field']->$key;
			}
			else
			{
				$data['field']->$key = $CI->input->post($key);
			}
			
			$key = null;
		}
			
		$CI->streams_validation->set_rules($CI->fields_m->fields_validation);

		// -------------------------------------
		// Process Data
		// -------------------------------------
		
		if ($CI->streams_validation->run())
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
					$CI->session->set_flashdata('success', lang('streams.field_add_success'));	
				}
			}
			else
			{
				if ( ! $CI->fields_m->update_field(
											$CI->fields_m->get_field($field_id),
											$CI->input->post()
										))
				{
					$CI->session->set_flashdata('notice', lang('streams.field_update_error'));	
				}
				else
				{
					$CI->session->set_flashdata('success', lang('streams.field_update_success'));	
				}
			}
	
			redirect('admin/streams/fields');
		}

		// -------------------------------------
		// Parameter Fields
		// -------------------------------------
		
		if( $this->input->post('field_type') and $this->input->post('field_type') != '')
		{
			if (isset($this->type->types->{$this->input->post('field_type')}))
			{
				// Get the type so we can use the custom params
				$this->data->current_type = $this->type->types->{$this->input->post('field_type')};
				
				// Get our standard params
				require_once(PYROSTEAMS_DIR.'libraries/Parameter_fields.php');
				
				$this->data->parameters = new Parameter_fields();
				
				$this->data->current_field->field_data = array();				
				
				if(isset($this->data->current_type->custom_parameters) and is_array($this->data->current_type->custom_parameters)):
				
					// Build items out of post data
					foreach($this->data->current_type->custom_parameters as $param):
					
						$this->data->current_field->field_data[$param] = $this->input->post($param);
					
					endforeach;
				
				endif;
			}
		}

		// -------------------------------------
		
		$CI->template
        		->append_js('stream_field.js')
				->build('admin/fields/form', $this->data);
	}
}