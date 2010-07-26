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
		'text' 			=> 'Text',
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
	// CRUD Functions
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
	function list_chunks( $offset = 0 )
	{	
		// -------------------------------------
		// Get chunks
		// -------------------------------------
		
		$this->data->chunks = $this->chunks_m->get_chunks( $this->settings->item('records_per_page'), $offset );

		// -------------------------------------
		// Pagination
		// -------------------------------------

		$total_rows = $this->chunks_m->count_all();
		
		$this->data->pagination = create_pagination('admin/chunks/list_chunks', $total_rows);
		
		// -------------------------------------

		$this->template->build('admin/list_chunks', $this->data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new chunk
	 *
	 */
	function create_chunk()
	{		
		$this->data->chunk_types = $this->chunk_types;
	
		// -------------------------------------
		// Validation & Setup
		// -------------------------------------
	
		$this->load->library('validation');

		$this->chunk_rules['slug'] .= '|callback__check_slug[insert]';

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

	// --------------------------------------------------------------------------
	
	/**
	 * Edit a chunk
	 *
	 */
	function edit_chunk( $chunk_id = 0 )
	{		
		$this->data->chunk_types = $this->chunk_types;
	
		// -------------------------------------
		// Validation & Setup
		// -------------------------------------
	
		$this->load->library('validation');

		$this->chunk_rules['slug'] .= '|callback__check_slug[update]';

		$this->validation->set_rules( $this->chunk_rules );
		
		$this->validation->set_fields();

		// -------------------------------------
		// Get chunk data
		// -------------------------------------
		
		$this->data->chunk = $this->chunks_m->get_chunk( $chunk_id );
		
		$this->data->chunk->content = $this->chunks_m->process_type( $this->data->chunk->type, $this->data->chunk->content, 'outgoing' );
		
		// -------------------------------------
		// Process Data
		// -------------------------------------
		
		if ($this->validation->run())
		{
			if( ! $this->chunks_m->update_chunk( $this->chunk_rules, $chunk_id ) ):
			{
				$this->session->set_flashdata('notice', lang('chunks.update_chunk_error'));	
			}
			else:
			{
				$this->session->set_flashdata('success', lang('chunks.update_chunk_success'));	
			}
			endif;
	
			redirect('admin/chunks');
		}

		// -------------------------------------
		
		$this->template->build('admin/form', $this->data);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Delete a chunk
	 *
	 */
	function delete_chunk( $chunk_id = 0 )
	{		
		if( ! $this->chunks_m->delete_chunk( $chunk_id ) ):
		{
			$this->session->set_flashdata('notice', lang('chunks.delete_chunk_error'));	
		}
		else:
		{
			$this->session->set_flashdata('success', lang('chunks.delete_chunk_success'));	
		}
		endif;

		redirect('admin/chunks');
	}

	// --------------------------------------------------------------------------
	// Validation Callbacks
	// --------------------------------------------------------------------------

	/**
	 * Check slug to make sure it is 
	 *
	 * @param	string - slug to be tested
	 * @param	mode - update or insert
	 * @return	bool
	 */
	function _check_slug( $slug, $mode )
	{
		$obj = $this->db->query("SELECT slug FROM chunks WHERE slug='$slug'");
		
		if( $mode == 'update' ):
		
			$threshold = 0;
		
		else:
		
			$threshold = 1;
		
		endif;
		
		if( $obj->num_rows > $threshold ):

			$this->validation->set_message('_check_slug', lang('chunks.slug_unique'));
		
			return FALSE;
		
		else:
		
			return TRUE;
		
		endif;
	}
}

/* End of file admin.php */
/* Location: ./third_party/modules/chunks/controllers/admin.php */