<?php  defined('BASEPATH') OR exit('No direct script access allowed');
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
		$this->config->load('files');

		$this->file_folders_m->folder_tree();
		$this->_folders = $this->file_folders_m->get_folders();

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
		$this->template->set_partial('nav', 'admin/partials/nav');
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
	public function contents($id = '', $filter = '')
	{
		if ( ! $this->file_folders_m->exists($id))
		{
			show_error(lang('files.folders.not_exists'));
		}

		$this->load->library('table');

		// Make a breadcrumb trail
		$crumbs = $this->file_folders_m->breadcrumb($id);
		$breadcrumb = '';
		foreach($crumbs AS $item)
		{
			$breadcrumb .= $item['name'] . ' &raquo; ';
		}
		$this->data->crumbs = reduce_multiples($breadcrumb, "&raquo; ", TRUE);

		// Get a list of all child folders
		$this->file_folders_m->clear_folders();
		if (isset($crumbs[0]['id']) && $crumbs[0]['id'] != '')
		{
			$this->file_folders_m->folder_tree($crumbs[0]['id']);
		}
		else
		{
			$this->file_folders_m->folder_tree($id);
		}
		$sub_folders = $this->file_folders_m->get_folders();

		// Get the selected information.
		$this->data->folder = $this->file_folders_m->get($id);
		$this->data->selected_folder = 0;
		$this->data->id = $id;
		$this->data->selected_filter = $filter;
		$this->data->types = array('a' => 'Audio', 'v' => 'Video', 'd' => 'Document', 'i' => 'Image', 'o' => 'Other');

		// Get all files
		if ($filter != '')
		{
			$this->data->files = $this->file_m->get_many_by(array(
				'folder_id'=>$id,
				'type' => $filter
			));
		}
		else
		{
			$this->data->files = $this->file_m->get_many_by('folder_id', $id);
		}


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
			->title($this->module['name'],lang('files.upload.title'))
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
		$this->template->set_layout('modal', 'admin');
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
			$this->data->messages['success'] = lang('files.folders.success');
		}
		$folder->name = set_value('name');
		$folder->parent_id = set_value('parent_id');
		$folder->type = set_value('type');
		$folder->slug = set_value('slug');

		// Get the parent -> childs
		$folder->parents = $this->_folders;

		$this->data->folder =& $folder;
		$this->template->build('admin/folders/form', $this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit a folder
	 *
	 * @param	int
	 */
	private function _folder_edit($folder_id)
	{
		$this->template->set_layout('modal', 'admin');
		$this->load->library('form_validation');

		$folder = $this->file_folders_m->get($folder_id);

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('slug', 'Slug', 'required');

		if ($this->form_validation->run())
		{
			$data = array(
				'name'			=> $this->input->post('name'),
				'parent_id'		=> $this->input->post('parent_id'),
				'slug'			=> $this->input->post('slug'),
			);
			$this->file_folders_m->update($folder_id, $data);
			$this->data->messages['success'] = lang('files.folders.success');
			//redirect('admin/files#folders');
		}

		$folder->name = set_value('name', $folder->name);
		$folder->parent_id = set_value('parent_id', $folder->parent_id);
		$folder->slug = set_value('slug', $folder->slug);

		// Get the parent -> childs
		$folder->parents = $this->_folders;

		$this->data->folder =& $folder;

		$this->template->build('admin/folders/form', $this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a folder
	 */
	private function _folder_delete($folder_id = '')
	{
		// If no folder is given, then 404
		if ( ! $folder = $this->file_folders_m->get($folder_id))
		{
			show_404();
		}

		if($this->input->post('button_action') == lang('dialog.yes'))
		{
			$this->file_m->delete_files($folder_id);
			$this->file_folders_m->delete($folder_id);
			$this->session->set_flashdata('success', sprintf(lang('files.folders.delete_success'), $folder->name));

			redirect('admin/files#folders');
		}
		elseif($this->input->post('button_action') == lang('dialog.no'))
		{
			redirect('admin/files#folders');
		}

		$this->data->folder =& $folder;

		$this->template
			->title($this->module['name'], lang('files.folders.delete_title'))
			->build('admin/folders/confirm', $this->data);
	}
}
