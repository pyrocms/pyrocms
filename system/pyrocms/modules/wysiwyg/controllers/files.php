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

	function index($id = 0)
	{
		//list of folders for the sidebar
		$folders = $this->file_folders_m->get_many_by('parent_id', 0);

		$active_folder = $id ? $this->file_folders_m->get($id) : NULL;
		if ($active_folder)
		{
			$id = $active_folder->id;

			$active_folder->items = $this->file_m->get_many_by(array(
				'folder_id'	=> $active_folder->id,
				'type'		=> 'i'
			));
		}

		//for dropdown list
		$subfolders		= $this->file_folders_m->get_folders($id);
		$folders_tree	= array();
		foreach ($subfolders as $folder)
		{
			$indent = repeater('&raquo; ', $folder->depth);
			$folders_tree[$folder->id] = $indent . $folder->name;
		}

		$this->template
			->title('Files')
			->set('folders',		$folders)
			->set('folders_tree',	$folders_tree)
			->set('active_folder',	$active_folder)
			->build('files/index');
	}

	public function ajax_get_files()
	{
		$file = $this->file_m->get($this->input->post('file_id'));

		$folders = array();
		if ($folder_id = $this->input->post('folder_id'))
		{
			$this->load->model('folders/folders_m');
			$folders = $this->file_folders_m->get_folder_path($folder_id);
		}

		$this->load->view('files/ajax_current', array(
			'file'		=> $file,
			'folders'	=> $folders
		));
	}
}