<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Manages files selection and insertion for WYSIWYG editors
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\WYSIWYG\Controllers
 */
class Files_wysiwyg extends WYSIWYG_Controller {

	public function __construct()
	{
		parent::__construct();	
	}

	public function index($id = 0)
	{
		$data = new stdClass();

		$data->folders			= $this->file_folders_m->get_folders();
		$data->subfolders		= array();
		$data->current_folder	= $id && isset($data->folders[$id])
								? $data->folders[$id]
								: ($data->folders ? current($data->folders) : array());

		if ($data->current_folder)
		{
			$data->current_folder->items = $this->file_m
				->select('files.*, file_folders.location')
				->join('file_folders', 'file_folders.id = files.folder_id')
				->order_by('files.date_added', 'DESC')
				->get_many_by('files.folder_id', $data->current_folder->id);

			$subfolders = $this->file_folders_m->folder_tree($data->current_folder->id);

			foreach ($subfolders as $subfolder)
			{
				$data->subfolders[$subfolder->id] = repeater('&raquo; ', $subfolder->depth) . $subfolder->name;
			}

			// Set a default label
			$data->subfolders = $data->subfolders
				? array($data->current_folder->id => lang('files:root')) + $data->subfolders
				: array($data->current_folder->id => lang('files:no_subfolders'));
		}

		// Array for select
		$data->folders_tree = array();
		foreach ($data->folders as $folder)
		{
			$data->folders_tree[$folder->id] = repeater('&raquo; ', $folder->depth) . $folder->name;
		}

		$this->template
			->title('Files')
			->build('files/index', $data);
	}

	public function ajax_get_file()
	{
		$file = $this->file_m->get($this->input->post('file_id'));

		$folders = array();
		if ($folder_id = $this->input->post('folder_id'))
		{
			$folders = $this->file_folders_m->get_folder_path($folder_id);
		}

		$this->load->view('files/ajax_current', array(
			'file'		=> $file,
			'folders'	=> $folders
		));
	}
}