<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams AJAX Controller
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Controllers
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Ajax extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // No matter what we don't show the profiler
        // in our AJAX calls.
        $this->output->enable_profiler(FALSE);
 
        // We need this for all of the variable setups in
        // the Type library __construct
        $this->load->library('streams_core/Type');
        
        // Only AJAX gets through!
       	if ( ! $this->input->is_ajax_request())
       	{
       		die('Invalid request.');
       	}
    }

	// --------------------------------------------------------------------------

	/**
	 * Get our build params
	 *
	 * Accessed via AJAX
	 *
	 * @access	public
	 * @return	void
	 */
	public function build_parameters()
	{
		// Out for certain characters
		if ($this->input->post('data') == '-') return null;
	
		$this->load->language('streams_core/pyrostreams');
	
		$type = $this->input->post('data');
		$namespace = $this->input->post('namespace');
		
		// Load paramaters
		require_once(APPPATH.'modules/streams_core/libraries/Parameter_fields.php');
		
		$parameters = new Parameter_fields();
	
		// Load the proper class
		$field_type = $this->type->load_single_type($type);
		
		// I guess we don't have any to show.
		if ( ! isset($field_type->custom_parameters)) return null;

		// Otherwise, the beat goes on.		
		$extra_fields = $field_type->custom_parameters;
		
		$data['count'] = 0;
				
		//Echo them out
		foreach ($extra_fields as $field)
		{
			// Check to see if it is a standard one or a custom one
			// from the field type
			if (method_exists($parameters, $field))
			{
				$data['input'] 			= $parameters->$field();
				$data['input_name']		= $this->lang->line('streams.'.$field);
			}
			elseif (method_exists($field_type, 'param_'.$field))
			{
				$call = 'param_'.$field;

				$input = $field_type->$call(null, $namespace);

				if (is_array($input))
				{
					$data['input'] 			= $input['input'];
					$data['instructions']	= $input['instructions'];
				}
				else
				{
					$data['input'] 			= $input;
					$data['instructions']	= null;
				}

				$data['input_name']		= $this->lang->line('streams.'.$field_type->field_type_slug.'.'.$field);
			}
			else
			{
				return false;
			}
			
			$data['input_slug'] = $field;
		
			echo $this->load->view('extra_field', $data, true);
			
			$data['count']++;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Update the field order
	 *
	 * Accessed via AJAX
	 *
	 * @access	public
	 * @return	void
	 */
	public function update_field_order()
	{
		$ids = explode(',', $this->input->post('order'));

		// Set the count by the offset for
		// paginated lists
		$order_count = $this->input->post('offset')+1;
		
		foreach ($ids as $id)
		{
			$this->db
					->where('id', $id)
					->update('data_field_assignments', array('sort_order' => $order_count));
			
			$order_count++;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Update the entries order
	 *
	 * Accessed via AJAX
	 *
	 * @access	public
	 * @return	void
	 */
	public function ajax_entry_order_update()
	{	
		// Get the stream from the ID
		$this->load->model('streams_core/streams_m');
		$stream = $this->streams_m->get_stream($this->input->post('stream_id'));
	
		$ids = explode(',', $this->input->post('order'));

		// Set the count by the offset for
		// paginated lists
		$order_count = $this->input->post('offset')+1;

		foreach ($ids as $id)
		{
			$this->db
					->limit(1)
					->where('id', $id)
					->update($stream->stream_prefix.$stream->stream_slug, array('ordering_count' => $order_count));

			++$order_count;
		}
	}
		
}