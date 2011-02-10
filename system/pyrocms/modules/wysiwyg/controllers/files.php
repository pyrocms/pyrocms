<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		MizuCMS
 * @subpackage 		WYSIWYG
 * @author			Phil Sturgeon
 *
 * Manages files selection and insertion for WYSIWYG editors
 */
class Files extends WYSIWYG_Controller
{
	function __construct()
	{
		parent::WYSIWYG_Controller();
		
	}

	function index($id = FALSE)
	{
		$folders = $this->file_folders_m->get_many_by('parent_id', 0);

		//for dropdown list
		$sub_folders = $this->file_folders_m->get_folders();
		
		$active_folder = array();

		if(!empty($folders) and !$id)
		{
			$active_folder = $folders[0];
			$active_folder->items = $this->file_m->get_many_by(array('folder_id' => $active_folder->id, 'type !=' => 'i'));
		}
		elseif(!empty($folders) and $id)
		{
			$active_folder = $this->file_folders_m->get($id);
			$active_folder->items = $this->file_m->get_many_by(array('folder_id' => $id, 'type !=' => 'i'));
		}
		
		$this->template
			->set('folders', $folders)
			->set('sub_folders', $sub_folders)
			->set('active_folder', $active_folder)
			->build('files/index');
	}

	public function ajax_get_files()
	{
		$file = $this->file_m->get($this->input->post('file_id'));

		if($folder_id = $this->input->post('folder_id'))
		{
			$this->load->model('folders/folders_m');
			$folders = $this->file_folders_m->get_folder_path($folder_id);
		}

		$this->load->view('files/ajax_current', array(
			'file' => $file,
			'folders' => empty($folders) ? array() : $folders
		));
	}
}