<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin_Categories extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var int
	 */
	protected $section = 'categories';
	
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field' => 'title',
			'label' => 'lang:global:title',
			'rules' => 'trim|required|max_length[100]|callback__check_title'
		),
		array(
			'field' => 'id',
			'rules' => 'trim|is_numeric'			
		),
	);
	
	/**
	 * The constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('blog_categories_m');
		$this->lang->load('categories');
		$this->lang->load('blog');
		
		// Load the validation library along with the rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);
	}
	
	/**
	 * Index method, lists all categories
	 * 
	 * @return void
	 */
	public function index()
	{
		$this->pyrocache->delete_all('modules_m');
		
		// Create pagination links
		$total_rows = $this->blog_categories_m->count_all();
		$pagination = create_pagination('admin/blog/categories/index', $total_rows, NULL, 5);
			
		// Using this data, get the relevant results
		$categories = $this->blog_categories_m->order_by('title')->limit($pagination['limit'])->get_all();

		$this->template
			->title($this->module_details['name'], lang('cat_list_title'))
			->set('categories', $categories)
			->set('pagination', $pagination)
			->build('admin/categories/index');
	}
	
	/**
	 * Create method, creates a new category
	 *
	 * @return void
	 */
	public function create()
	{
		// Validate the data
		if ($this->form_validation->run())
		{
			if ($id = $this->blog_categories_m->insert($_POST))
			{
				// Fire an event. A new blog category has been created.
				Events::trigger('blog_category_created', $id);

				$this->session->set_flashdata('success', sprintf( lang('cat_add_success'), $this->input->post('title')) );
			}
			else
			{
				$this->session->set_flashdata('error', lang('cat_add_error'));
			}
			
			redirect('admin/blog/categories');
		}

		$category = new stdClass();
				
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->template
			->title($this->module_details['name'], lang('cat_create_title'))
			->set('category', $category)
			->build('admin/categories/form');	
	}
	
	/**
	 * Edit method, edits an existing category
	 * 
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Get the category
		$category = $this->blog_categories_m->get($id);
		
		// ID specified?
		$category or redirect('admin/blog/categories/index');

		$this->form_validation->set_rules('id', 'ID', 'trim|required|is_numeric');
		
		// Validate the results
		if ($this->form_validation->run())
		{		
			$this->blog_categories_m->update($id, $_POST)
				? $this->session->set_flashdata('success', sprintf( lang('cat_edit_success'), $this->input->post('title')) )
				: $this->session->set_flashdata('error', lang('cat_edit_error'));
			
			// Fire an event. A blog category is being updated.
			Events::trigger('blog_category_updated', $id);
			
			redirect('admin/blog/categories/index');
		}
		
		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$category->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('cat_edit_title'), $category->title))
			->set('category', $category)
			->build('admin/categories/form');
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * 
	 * @param int id The ID of the category to edit
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
		
		// Delete multiple
		if (!empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			$deleted_ids = array();
			foreach ($id_array as $id)
			{
				if ($this->blog_categories_m->delete($id))
				{
					$deleted++;
					$deleted_ids[] = $id;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('cat_mass_delete_error'), $id));
				}
				$to_delete++;
			}
			
			if ( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf(lang('cat_mass_delete_success'), $deleted, $to_delete));
			}
			
			// Fire an event. One or more categories have been deleted.
			Events::trigger('blog_category_deleted', $deleted_ids);
		}		
		else
		{
			$this->session->set_flashdata('error', lang('cat_no_select_error'));
		}
		
		redirect('admin/blog/categories/index');
	}
		
	/**
	 * Callback method that checks the title of the category
	 * 
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_title($title = '')
	{
		$id = $this->input->post('id');
		if ($this->blog_categories_m->check_title($title,$id))
		{
			$this->form_validation->set_message('_check_title', sprintf(lang('cat_already_exist_error'), $title));
			return FALSE;
		}

		return TRUE;
	}
	
	/**
	 * Create method, creates a new category via ajax
	 * 
	 * @return void
	 */
	public function create_ajax()
	{
		$category = new stdClass();
		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$category->{$rule['field']} = set_value($rule['field']);
		}
		
		$data = array(
			'method' => 'create',
			'category' => $category,
		);
		
		if ($this->form_validation->run())
		{
			$id = $this->blog_categories_m->insert_ajax($this->input->post());
			
			if ($id > 0)
			{
				$message = sprintf(lang('cat_add_success'), $this->input->post('title', TRUE));
			}
			else
			{
				$message = lang('cat_add_error');
			}

			return $this->template->build_json(array(
				'message'		=> $message,
				'title'			=> $this->input->post('title'),
				'category_id'	=> $id,
				'status'		=> 'ok'
			));
		}	
		else
		{
			// Render the view
			$form = $this->load->view('admin/categories/form', $data, TRUE);

			if ($errors = validation_errors())
			{
				return $this->template->build_json(array(
					'message'	=> $errors,
					'status'	=> 'error',
					'form'		=> $form
				));
			}

			echo $form;
		}
	}
}