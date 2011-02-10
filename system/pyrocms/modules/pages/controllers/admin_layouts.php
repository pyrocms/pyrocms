<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon, Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Pages Module
 * @category 	Modules
 */
class Admin_layouts extends Admin_Controller
{
	/**
	 * Validation rules used by the form_validation library
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::__construct();

		$this->load->model('page_layouts_m');
		$this->lang->load('pages');
		$this->lang->load('page_layouts');

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');

		// Load the validation library
		$this->load->library('form_validation');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('page_layouts.title_label'),
				'rules' => 'trim|required|max_length[60]'
			),
			array(
				'field' => 'theme_layout',
				'label' => lang('page_layouts.theme_layout_label'),
				'rules' => 'trim'
			),
			array(
				'field' => 'body',
				'label' => lang('page_layouts.body_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'css',
				'label' => lang('page_layouts.css_label'),
				'rules' => 'trim'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}


	/**
	 * Index methods, lists all page layouts
	 * @access public
	 * @return void
	 */
	public function index()
	{	
		// Get all page layouts
		$this->data->page_layouts = $this->page_layouts_m->get_all();

		// Render the view
		$this->template
			->title($this->module_details['name'], lang('pages.layout_id_label'))
			->build('admin/layouts/index', $this->data);
	}

	/**
	 * Create method, creates a new page layout
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Got validation?
		if ($this->form_validation->run())
	    {
			// Insert the layout
	    	$id = $this->page_layouts_m->insert(array(
				'title' 	=> $this->input->post('title'),
				'theme_layout' 	=> $this->input->post('theme_layout'),
				'body' 		=> $this->input->post('body', FALSE),
				'css' 		=> $this->input->post('css')
			));
			
			//Save as a file
			if( $this->settings->get('enable_layout_files') == '1' ):
			
				if( ! $this->page_layouts_m->save_layout_file( $id, $this->input->post('title'), $this->input->post('body', FALSE)) ):
				
					$this->session->set_flashdata('notice', lang('page_layouts.layout_file_save_error'));
				
				endif;
			
			endif;

			// Success or fail?
			$id > 0
				? $this->session->set_flashdata('success', lang('page_layouts.create_success'))
				: $this->session->set_flashdata('notice', lang('page_layouts.create_error'));

			redirect('admin/pages/layouts');
	    }

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$page_layout->{$rule['field']} = set_value($rule['field']);
		}

		$theme_layouts = $this->template->get_theme_layouts($this->settings->default_theme);
		foreach($theme_layouts as $theme_layout)
		{
			$this->data->theme_layouts[$theme_layout] = basename($theme_layout, '.html');
		}

	    // Assign data for display
	    $this->load->vars(array(
			'page_layout' => &$page_layout
		));

	    // Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('pages.layout_id_label'), lang('page_layouts.create_title'))
			->append_metadata(js('codemirror/codemirror.js'))
			->build('admin/layouts/form', $this->data);
	}

	/**
	 * Edit method, edits an existing page layout
	 * @access public
	 * @return void
	 */
	public function edit($id = 0)
	{
		empty($id) AND redirect('admin/pages/layouts');

	    // We use this controller property for a validation callback later on
	    $this->page_layout_id = $id;

	    // Set data, if it exists
	    if (!$page_layout = $this->page_layouts_m->get($id))
	    {
			$this->session->set_flashdata('error', lang('page_layouts.page_layout.not_found_error'));
			redirect('admin/pages/layouts/create');
	    }

	    // Give validation a try, who knows, it just might work!
		if ($this->form_validation->run())
	    {
			// Run the update code with the POST data
			$this->page_layouts_m->update($id, array(
				'title' 	=> $this->input->post('title'),
				'theme_layout' 	=> $this->input->post('theme_layout'),
				'body' 		=> $this->input->post('body', FALSE),
				'css' 		=> $this->input->post('css')
			));

			// Update layout file
			if( $this->settings->get('enable_layout_files') == '1' ):
			
				if( ! $this->page_layouts_m->save_layout_file( $id, $this->input->post('title'), $this->input->post('body', FALSE)) ):
				
					$this->session->set_flashdata('notice', lang('page_layouts.layout_file_save_error'));
				
				endif;
			
			endif;

			// Wipe cache for this model as the data has changed
			$this->cache->delete_all('page_layouts_m');

			$this->session->set_flashdata('success', sprintf(lang('page_layouts.edit_success'), $this->input->post('title')));
			redirect('admin/pages/layouts');
	    }

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']))
			{
				$page_layout->{$rule['field']} = set_value($rule['field']);
			}
		}

		$theme_layouts = $this->template->get_theme_layouts($this->settings->default_theme);
		$theme_layouts_options = array();
		foreach($theme_layouts as $theme_layout)
		{
			$theme_layouts_options[$theme_layout] = basename($theme_layout, '.html');
		}

		$this->template
			->title($this->module_details['name'], lang('pages.layout_id_label'), sprintf(lang('page_layouts.edit_title'), $page_layout->title))
			->append_metadata(js('codemirror/codemirror.js'))
			->set('theme_layouts', $theme_layouts_options)
			->set('page_layout', $page_layout)
			->build('admin/layouts/form', $this->data);
	}
	
	/**
	 * Sync/Delete Action
	 *
	 * @access	public
	 * @return	void
	 */
	public function action()
	{
		if( $this->input->post('btnAction') == 'delete' ):
		
			$this->_delete();

		elseif( $this->input->post('btnAction') == 'sync' ):
		
			$this->page_layouts_m->sync_layouts( $this->input->post('action_to') );
			
			$this->session->set_flashdata('success', lang('page_layouts.sync_success'));
			
		endif;
		
		redirect('admin/pages/layouts');
	}

	/**
	 * Delete method, deletes an existing page layout
	 * @access private
	 * @return void
	 */
	private function _delete($id = 0)
	{
		// Attention! Error of no selection not handeled yet.
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		foreach ($ids as $id)
		{
			if ($id !== 1)
			{
				// Delete layout file
				$this->page_layouts_m->delete_layout_file( $id );
			
				$deleted_ids = $this->page_layouts_m->delete($id);

				// Wipe cache for this model, the content has changd
				$this->cache->delete_all('page_layouts_m');
			}

			else
			{
				$this->session->set_flashdata('error', lang('page_layouts.delete_home_error'));
			}
		}

		// Some pages have been deleted
		if(!empty($deleted_ids))
		{
			// Only deleting one page
			if( count($deleted_ids) == 1 )
			{
				$this->session->set_flashdata('success', sprintf(lang('page_layout_delete_success'), $deleted_ids[0]));
			}
			else // Deleting multiple pages
			{
				$this->session->set_flashdata('success', sprintf(lang('page_layouts.delete_success'), count($deleted_ids)));
			}
		}

		else // For some reason, none of them were deleted
		{
			$this->session->set_flashdata('notice', lang('page_layouts.delete_none_notice'));
		}
	}

}