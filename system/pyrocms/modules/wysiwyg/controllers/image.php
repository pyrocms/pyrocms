<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		MizuCMS
 * @subpackage 		WYSIWYG
 * @author			Phil Sturgeon
 *
 * Manages image selection and insertion for WYSIWYG editors
 */
class Image extends WYSIWYG_Controller
{
	function __construct()
	{
		parent::WYSIWYG_Controller();

		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');

		$this->template->append_metadata( css('images.css', 'wysiwyg') )
				->append_metadata( css('admin/uniform.default.css') )
				->append_metadata( js('images.js', 'wysiwyg') )
				->append_metadata( js('admin/jquery.uniform.min.js') )
				->append_metadata( js('jquery/jquery-ui-1.8.4.min.js') )
				->append_metadata('<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />')
				->title('Images');
	}
	
	public function index($id = FALSE)
	{
		//list of folders for the sidebar
		$folders = $this->file_folders_m->get_many_by('parent_id', 0);
		
		//for dropdown list
		$sub_folders = $this->file_folders_m->get_folders();

		if(!empty($folders) and !$id)
		{
			$active_folder = $folders[0];
			$active_folder->items = $this->file_m->get_many_by(array('folder_id' => $active_folder->id, 'type' => 'i'));
		}
		elseif(!empty($folders) and $id)
		{
			$active_folder = $this->file_folders_m->get($id);
			$active_folder->items = $this->file_m->get_many_by(array('folder_id' => $id, 'type' => 'i'));
		}
		
		$this->template
			->set('folders', $folders)
			->set('sub_folders', $sub_folders)
			->set('active_folder', $active_folder)
			->build('image/index');
	}

	public function browse($folder_id = FALSE)
	{
		$folder_id OR redirect('admin/wysiwyg/image');
		
		$this->db->where('folder_id', $folder_id);
		$files = $this->file_m->get_many_by('type', 'i');
		$folders = $this->file_folders_m->get_many_by('parent_id', $folder_id);
		$folder_meta = $this->file_folders_m->get($folder_id); 

		$this->template
			->set('files', $files)
			->set('folders', $folders)
			->set('folder_meta', $folder_meta)
			->build('image/browse');
	}

	public function upload()
	{
		
	}

	public function ajax_get_image()
	{
		$this->load->model('folders/folders_m');

		$data = $this->images_m->get_by_filename( $this->input->post('filename') );
		$data->folders = $this->folders_m->get_folder_path($data->folder_id);

		echo json_encode(array(
			'output' => $this->load->view('image/ajax_current', $data, TRUE),
			'folder_id' => $data->folder_id
		));
	}
}