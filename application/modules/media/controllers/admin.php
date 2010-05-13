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
 * PyroCMS Media Admin Controller
 *
 * Provides an admin for the media module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Media
 */
class Admin extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * Loads dependencies.
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::Admin_Controller();

		$this->load->models(array('media_m', 'media_folders_m'));
		$this->lang->load('media');

		$this->template->set_partial('nav', 'admin/partials/nav', FALSE);

	}

	/**
	 * Index
	 *
	 * Shows the default
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$this->template->build('admin/layouts/index', $this->data);

	}

	public function images()
	{
		$folders = $this->media_folders_m->get_children(0, 'i');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/images', $this->data);
		}
		else
		{
			redirect('admin/media#images');
		}
	}

	public function documents()
	{
		$folders = $this->media_folders_m->get_children(0, 'd');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/documents', $this->data);
		}
		else
		{
			redirect('admin/media#documents');
		}
	}

	public function video()
	{

		$folders = $this->media_folders_m->get_children(0, 'v');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/video', $this->data);
		}
		else
		{
			redirect('admin/media#video');
		}
	}

	public function audio()
	{
		$folders = $this->media_folders_m->get_children(0, 'a');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/audio', $this->data);
		}
		else
		{
			redirect('admin/media#audio');
		}
	}

	public function folders($method = '')
	{
		switch($method)
		{
			case 'list':
				$this->_folder_list();
				break;
			case 'create':
				$this->_folder_create();
				break;
			case 'delete':
				$this->_folder_delete();
				break;
			default:
				$this->_folder_list();
				break;
		}
	}

	public function upload()
	{

		$this->template->build('admin/upload', $this->data);
	}

	private function _folder_list()
	{
		$media_folders = $this->media_folders_m->get_all();

		$this->data->media_folders = &$media_folders;

		$this->load->view('admin/folders/index', $this->data);
	}

	private function _folder_create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run())
		{
			$data = array(
				'name'			=> $this->input->post('name'),
				'parent_id'		=> $this->input->post('parent_id'),
				'type'			=> $this->input->post('type'),
				'date_added'	=> now()
			);
			$this->media_folders_m->insert($data);
			redirect('admin/media#folders');
		}
		$folder->name = set_value('name');
		$folder->parent_id = set_value('parent_id');
		$folder->type = set_value('type');
		$this->data->folder =& $folder;
		$this->load->view('admin/folders/form', $this->data);
	}

	private function _folder_delete()
	{
		$folder_id = $this->uri->segment(5, NULL);

		// If no folder is given, then 404
		$folder_id == NULL and show_404();

		$folder = $this->media_folders_m->get($folder_id);

		if($this->input->post('button_action') == 'Yes')
		{
			$this->media_folders_m->delete($folder_id);
			$this->session->set_flashdata('success', sprintf(lang('media.folders.delete_success'), $folder->name));

			redirect('admin/media/folders');
		}
		elseif($this->input->post('button_action') == 'No')
		{
			redirect('admin/media/folders');
		}

		$this->data->folder =& $folder;
		
		$this->template->build('admin/folders/confirm', $this->data);
	}

	private function _folder_dropdown_array($folders)
	{
		static $depth = 0;
		$return = array();

		foreach($folders as $id => $folder)
		{
			// Skip the 'name' of a sub-folder
			if($id == 'name')
			{
				continue;
			}
			if(is_array($folder))
			{
				$return[$id] = str_repeat('&nbsp;&nbsp;', $depth) . $folder['name'];
				$depth++;
				$return = $return + $this->_folder_dropdown_array($folder);
				$depth--;
			}
			else
			{
				$return[$id] = str_repeat('&nbsp;&nbsp;', $depth) . $folder;
			}
		}

		return $return;
	}

}

/* End of file admin.php */