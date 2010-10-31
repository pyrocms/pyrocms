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
		
		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');

		$this->template->append_metadata( css('images.css', 'wysiwyg') )
				->title('Files');
	}

	function index()
	{
		$folders = $this->file_folders_m->get_all();

		$this->template
			->set('folders', $folders)
			->build('files/browse');
	}

	function browse($folder_id = 0)
	{
		$folder_id OR redirect('admin/wysiwyg/files');
		
		$files = $this->file_m->get_many_by('folder_id', $folder_id);
		$folders = $this->file_folders_m->get_many_by('parent_id', $folder_id);
		$folder_meta = $this->file_folders_m->get($folder_id);

		$this->template
			->set('files', $files)
			->set('folders', $folders)
			->set('folder_meta', $folder_meta)
			->build('files/browse');
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