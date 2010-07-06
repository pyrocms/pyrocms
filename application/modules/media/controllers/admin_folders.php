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
class Admin_folders extends Admin_Controller {

	public function __construct()
	{
		parent::Admin_Controller();
		$this->load->models(array('media_m', 'media_folders_m'));
		$this->lang->load('media');

		$this->template->set_partial('nav', 'admin/partials/nav', FALSE);
	}

	public function index($id = NULL)
	{
		$this->_folder_list($id);
	}

	// /admin/media/folders/contents/23
	public function contents($id)
	{
		if(!$this->media_folders_m->exists($id))
		{
			show_error(lang('media.folders.not_exists'));
		}
		
		$sub_folders = $this->media_folders_m->get_children($id);	
		$this->data->folder = $this->media_folders_m->get($id);
		$this->data->selected_folder = 0;
		if(empty($sub_folders))
		{
			$sub_folders = array(0 => lang('media.dropdown.no_subfolders'));
		}
		else
		{
			$sub_folders = array(0 => lang('media.dropdown.root')) + $sub_folders;
		}
		$this->data->sub_folders = $sub_folders;
		
/*		if($this->is_ajax())
		{*/
			$this->load->view('admin/folders/contents', $this->data);
/*		}
		else
		{
			redirect('admin/media');
		}
*/		
	}
	
	public function create()
	{
		$this->_folder_create();
	}
	
	public function delete($id)
	{
		$this->_folder_delete($id);
	}

	public function upload()
	{

		$this->template->build('admin/upload', $this->data);
	}

	private function _folder_list($id)
	{
		if($id === NULL)
		{
			$media_folders = $this->media_folders_m->get_all();			
		}
		else
		{
			$media_folders = $this->media_folders_m->get_children($id);			
		}

		$this->data->media_folders = &$media_folders;

		$this->load->view('admin/folders/index', $this->data);
	}

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
				'type'			=> $this->input->post('type'),
				'slug'			=> $this->input->post('slug'),
				'date_added'	=> now()
			);
			$this->media_folders_m->insert($data);
			redirect('admin/media#folders');
		}
		$folder->name = set_value('name');
		$folder->parent_id = set_value('parent_id');
		$folder->type = set_value('type');
		$folder->slug = set_value('slug');
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
}