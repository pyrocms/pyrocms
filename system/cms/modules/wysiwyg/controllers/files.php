<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		WYSIWYG
 * @author			Phil Sturgeon, Marcos Coelho
 *
 * Manages files selection and insertion for WYSIWYG editors
 */
class Files extends WYSIWYG_Controller {

	public function __construct()
	{
		parent::WYSIWYG_Controller();	
	}

	public function index($id = 0)
	{
		$data->folders			= $this->file_folders_m->get_folders();
		$data->subfolders		= array();
		$data->current_folder	= $id && isset($data->folders[$id])
								? $data->folders[$id]
								: ($data->folders ? current($data->folders) : array());

		if ($data->current_folder)
		{
			$data->current_folder->items = $this->file_m
				->order_by('date_added', 'DESC')
				->where('type !=', 'i')
				->get_many_by('folder_id', $data->current_folder->id);

			$subfolders = $this->file_folders_m->folder_tree($data->current_folder->id);

			foreach ($subfolders as $subfolder)
			{
				$data->subfolders[$subfolder->id] = repeater('&raquo; ', $subfolder->depth) . $subfolder->name;
			}

			// Set a default label
			$data->subfolders = $data->subfolders
				? array($data->current_folder->id => lang('files.dropdown_root')) + $data->subfolders
				: array($data->current_folder->id => lang('files.dropdown_no_subfolders'));
		}

		// Array for select
		$data->folders_tree = array();
		foreach ($data->folders as $folder)
		{
			$data->folders_tree[$folder->id] = repeater('&raquo; ', $folder->depth) . $folder->name;
		}

		$data->file_types = array(
			'a' => lang('files.type_a'),
			'v' => lang('files.type_v'),
			'd' => lang('files.type_d'),
			'i' => lang('files.type_i'),
			'o' => lang('files.type_o')
		);

		$this->template
			->title('Files')
			->build('files/index', $data);
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