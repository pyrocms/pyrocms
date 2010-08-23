<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

/**
 * PyroCMS Files Admin Controller
 *
 * Provides an admin for the files module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		Eric Barnes <eric@pyrocms.com>
 * @package		PyroCMS
 * @subpackage	file
 */
class Admin_folders extends Admin_Controller {

	/**
	 * Formatted array of all folders.
	 */
	private $_folders = array();
	
	// ------------------------------------------------------------------------
	
	public function __construct()
	{
		parent::Admin_Controller();
		$this->load->models(array('file_m', 'file_folders_m'));
		$this->lang->load('files');
		
		$this->file_folders_m->folder_tree();
		$this->_folders = $this->file_folders_m->get_folders();
		
		$this->template->set_partial('nav', 'admin/partials/nav', FALSE);
	}
	
	// ------------------------------------------------------------------------

	public function index($id = NULL)
	{
		$this->_folder_list($id);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Show the folders contents
	 */
	public function contents($id)
	{
		if ( ! $this->file_folders_m->exists($id))
		{
			show_error(lang('files.folders.not_exists'));
		}
		
		// Get a list of all child folders
		$this->file_folders_m->clear_folders();
		$this->file_folders_m->folder_tree($id);
		$sub_folders = $this->file_folders_m->get_folders();

		// Get the selected information.
		$this->data->folder = $this->file_folders_m->get($id);
		$this->data->selected_folder = 0;
		$this->data->id = $id;
		
		// Set a default label
		if (empty($sub_folders))
		{
			$sub_folders = array(0 => lang('files.dropdown.no_subfolders'));
		}
		else
		{
			$sub_folders = array(0 => lang('files.dropdown.root')) + $sub_folders;
		}
		
		$this->data->sub_folders = $sub_folders;

		$this->load->view('admin/folders/contents', $this->data);
	}

	// ------------------------------------------------------------------------
	
	public function create()
	{
		$this->_folder_create();
	}
	
	// ------------------------------------------------------------------------
	
	public function edit($id)
	{
		$this->_folder_edit($id);
	}

	// ------------------------------------------------------------------------
	
	public function delete($id)
	{
		$this->_folder_delete($id);
	}

	// ------------------------------------------------------------------------
	
	
	public function upload()
	{
		$this->template
			->title(lang('module.files'),lang('method.upload'))
			->build('admin/upload', $this->data);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * List all folders
	 */
	private function _folder_list($id)
	{
		$this->load->library('table');
		if($id === NULL)
		{
			$file_folders = $this->_folders;
		}
		else
		{
			$file_folders = $this->file_folders_m->get_children($id);
		}

		$this->data->file_folders = &$file_folders;

		$this->load->view('admin/folders/index', $this->data);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Create folder
	 */
	private function _folder_create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('slug', 'Slug', 'required');

		if($this->form_validation->run())
		{
			$data = array(
				'name'			=> $this->input->post('name'),
				'parent_id'		=> $this->input->post('parent_id'),
				'slug'			=> $this->input->post('slug'),
				'date_added'	=> now()
			);
			$this->file_folders_m->insert($data);
			redirect('admin/file#folders');
		}
		$folder->name = set_value('name');
		$folder->parent_id = set_value('parent_id');
		$folder->type = set_value('type');
		$folder->slug = set_value('slug');
		
		// Get the parent -> childs
		$folder->parents = $this->_folders;
		
		$this->data->folder =& $folder;
		$this->load->view('admin/folders/form', $this->data);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Edit a folder
	 *
	 * @param	int
	 */
	private function _folder_edit($folder_id)
	{
		$this->load->library('form_validation');
		
		$folder = $this->file_folders_m->get($folder_id);
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('slug', 'Slug', 'required');

		if($this->form_validation->run())
		{
			$data = array(
				'name'			=> $this->input->post('name'),
				'parent_id'		=> $this->input->post('parent_id'),
				'slug'			=> $this->input->post('slug'),
			);
			$this->file_folders_m->update($folder_id, $data);
			redirect('admin/files#folders');
		}
		$folder->name = set_value('name', $folder->name);
		$folder->parent_id = set_value('parent_id', $folder->parent_id);
		$folder->slug = set_value('slug', $folder->slug);
		
		// Get the parent -> childs
		$folder->parents = $this->_folders;

		$this->data->folder =& $folder;
		$this->load->view('admin/folders/form', $this->data);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Delete a folder
	 */
	private function _folder_delete()
	{
		$folder_id = $this->uri->segment(5, NULL);

		// If no folder is given, then 404
		$folder_id == NULL and show_404();

		$folder = $this->file_folders_m->get($folder_id);

		if($this->input->post('button_action') == 'Yes')
		{
			$this->file_folders_m->delete($folder_id);
			$this->session->set_flashdata('success', sprintf(lang('files.folders.delete_success'), $folder->name));

			redirect('admin/files/folders');
		}
		elseif($this->input->post('button_action') == 'No')
		{
			redirect('admin/files/folders');
		}

		$this->data->folder =& $folder;

		$this->template
			->title(lang('module.files'),lang('method.delete'))
			->build('admin/folders/confirm', $this->data);
	}
}
