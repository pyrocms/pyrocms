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

		$this->template->title('Files');
	}

	function index()
	{
		$files = $this->file_m->get_all();
		$folders = $this->file_folders_m->get_all();

		$this->template
			->set('files', $files)
			->set('folders', $folders)
			->build('files/browse');
	}

	public function ajax_get_files()
	{
		$doc = $this->file_m->get($this->input->post('doc_id'));

		if($folder_id = $this->input->post('folder_id'))
		{
			$this->load->model('folders/folders_m');
			$folders = $this->file_folders_m->get_folder_path($folder_id);
		}

		$this->load->view('files/ajax_current', array(
			'doc' => $doc,
			'folders' => empty($folders) ? array() : $folders
		));
	}
}