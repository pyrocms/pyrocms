<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PyroChunks Admin Controller Class
 *
 * @package  PyroCMS
 * @subpackage  PyroChunks
 * @category  Controller
 * @author  Adam Fairholm
 */ 
class Admin extends Admin_Controller {

	var $chunk_rules = array(
		'name' 		=> 'trim|required|max_length[60]',
		'slug'		=> 'trim|required|strtolower|max_length[60]',
		'type'		=> 'trim',
		'content'	=> 'trim|required'
	);
	
	var $chunk_types = array(
		'textfield' 	=> 'Text Field',
		'textbox'		=> 'Text Box',
		'html'			=> 'HTML'
	);

	// --------------------------------------------------------------------------

	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->model('chunks_m');
		
		$this->load->language('chunks');
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}

	// --------------------------------------------------------------------------

	function index()
	{
		$this->list_chunks();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * List chunks
	 *
	 */
	function list_chunks()
	{	
		// -------------------------------------
		// Get chunks
		// -------------------------------------
		
		$this->data->chunks = $this->chunks_m->get_chunks();
		
		// -------------------------------------
			
		$this->template->build('admin/list_chunks', $this->data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new form
	 */
	function create_chunk()
	{		
		$this->data->chunk_types = $this->chunk_types;
	
		// -------------------------------------
		// Validation & Setup
		// -------------------------------------
	
		$this->load->library('validation');

		$this->validation->set_rules( $this->chunk_rules );
		
		$this->validation->set_fields();
		
		foreach(array_keys($this->chunk_rules) as $field)
		{
			$this->data->chunk->$field = set_value($field);
		}

		// -------------------------------------
		// Process Data
		// -------------------------------------
		
		if ($this->validation->run())
		{
			if( ! $this->chunks_m->insert_new_chunk( $this->chunk_rules, $this->data->user->id ) ):
			{
				$this->session->set_flashdata('notice', lang('chunks.new_chunk_error'));	
			}
			else:
			{
				$this->session->set_flashdata('success', lang('chunks.new_chunk_success'));	
			}
			endif;
	
			redirect('admin/chunks');
		}

		// -------------------------------------
		
		$this->template->build('admin/form', $this->data);
	}

}

/* End of file admin.php */
/* Location: ./third_party/modules/chunks/controllers/admin.php */