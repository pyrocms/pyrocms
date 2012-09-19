<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Manages image selection and insertion for WYSIWYG editors
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\WYSIWYG\Controllers
 */
class Image extends WYSIWYG_Controller {

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
				->where('files.type', 'i')
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
			->title('Images')
			->append_css('admin/basic_layout.css')
			->build('image/index', $data);
	}

}