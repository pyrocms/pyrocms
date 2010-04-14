<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 * @author  	Phil Sturgeon - PyroCMS Dev Team
 */
class Admin extends Admin_Controller
{
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules;
	
	/** 
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('categories_m');
		$this->lang->load('categories');
		
	    $this->template->set_partial('sidebar', 'admin/sidebar');
	
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('categories.title_label'),
				'rules' => 'trim|required|max_length[20]|callback__check_title'
			),
		);
		
		// Load the validation library along with the rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);
	}
	
	/**
	 * Index method, lists all categories
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Create pagination links
		$total_rows 			= $this->categories_m->count_all();
		$this->data->pagination = create_pagination('admin/categories/index', $total_rows);
			
		// Using this data, get the relevant results
		$this->data->categories = $this->categories_m->limit( $this->data->pagination['limit'] )->get_all();		
		$this->template->build('admin/index', $this->data);
	}
	
	/**
	 * Create method, creates a new category
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}

		// Validate the data
		if ($this->form_validation->run())
		{
			if ($this->categories_m->insert($_POST))
			{
				$this->session->set_flashdata('success', sprintf( lang('cat_add_success'), $this->input->post('title')) );
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('cat_add_error')));
			}
			redirect('admin/categories');
		}

		// Render the view
		$this->data->category =& $category;		
		$this->template->build('admin/form', $this->data);
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit 
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Get the category
		$category = $this->categories_m->get($id);
		
		// ID specified?
		if (empty($id) or !$category)
		{
			redirect('admin/categories/index');
		}
		
		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$category->{$rule['field']} = $this->input->post($rule['field']);
			}
		}
		
		// Validate the results
		if ($this->form_validation->run())
		{		
			if ($this->categories_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', sprintf( lang('cat_edit_success'), $this->input->post('title')) );
			}		
			else
			{
				$this->session->set_flashdata(array('error'=> lang('cat_edit_error')));
			}
			
			redirect('admin/categories/index');
		}		

		// Render the view
		$this->data->category =& $category;
		$this->template->build('admin/form', $this->data);
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit 
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
		
		// Delete multiple
		if(!empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id) 
			{
				if($this->categories_m->delete($id))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('cat_mass_delete_error'), $id));
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('cat_mass_delete_success'), $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('cat_no_select_error'));
		}		
		redirect('admin/categories/index');
	}	
	
	/**
	 * Callback method that checks the title of the category
	 * @access public
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_title($title = '')
	{
		if ($this->categories_m->check_title($title))
		{
			$this->form_validation->set_message('_check_title', sprintf($this->lang->line('cat_already_exist_error'), $title));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>