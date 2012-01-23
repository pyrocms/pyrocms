<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams AJAX Controller
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Ajax extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
        
        // No matter what we don't show the profiler
        // in our AJAX calls.
        $this->output->enable_profiler(FALSE);
 
		$this->load->helper('streams/streams');        
		streams_constants();
       
        // We need this for all of the variable setups in
        // the Type library __construct
        $this->load->library('Type');
        
        // Only AJAX gets through!
       	if( !$this->input->is_ajax_request() ) die('Invalid request.');
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
		if( $this->input->post('data') == '-' ) return null;
	
		$this->load->language('pyrostreams');
	
		$type = $this->input->post('data');
		
		// Load paramaters
		require_once(PYROSTEAMS_DIR.'libraries/Parameter_fields.php');
		
		$parameters = new Parameter_fields();
	
		// Load the proper class
		$field_type = $this->type->load_single_type($type);
		
		// I guess we don't have any to show.
		if( !isset($field_type->custom_parameters) ) return null;

		// Otherwise, the beat goes on.		
		$extra_fields = $field_type->custom_parameters;
		
		$data['count'] = 0;
				
		//Echo them out
		foreach( $extra_fields as $field )
		{
			// Check to see if it is a standard one or a custom one
			// from the field type
			if( method_exists($parameters, $field) ):
	
				$data['input'] 			= $parameters->$field();
				$data['input_name']		= $this->lang->line('streams.'.$field);
		
			elseif( method_exists($field_type, 'param_'.$field)):

				$call = 'param_'.$field;

				$data['input'] 			= $field_type->$call();
				$data['input_name']		= $this->lang->line('streams.'.$field_type->field_type_slug.'.'.$field);

			else:
			
				return false;
			
			endif;
			
			$data['input_slug'] = $field;
		
			echo $this->load->view('admin/ajax/extra_field', $data, TRUE);
			
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
		if(!$this->input->is_ajax_request()) exit();
	
		$ids = explode(',', $this->input->post('order'));

		// Set the count by the offset for
		// paginated lists
		$order_count = $this->input->post('offset')+1;
		
		foreach($ids as $id):
		
			$this->db
					->where('id', $id)
					->update('data_field_assignments', array('sort_order' => $order_count));
			
			$order_count++;
		
		endforeach;
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
		$this->load->model('streams_m');
		$stream = $this->streams_m->get_stream($this->input->post('stream_id'));
	
		$ids = explode(',', $this->input->post('order'));

		// Set the count by the offset for
		// paginated lists
		$order_count = $this->input->post('offset')+1;

		foreach($ids as $id):
		
			$update_data['ordering_count']		= $order_count;
			
			$this->db->where('id', $id);
			$this->db->update(STR_PRE.$stream->stream_slug, $update_data);
			
			$update_data = array();
			
			++$order_count;
		
		endforeach;
	}
		
}

/* End of file ajax.php */