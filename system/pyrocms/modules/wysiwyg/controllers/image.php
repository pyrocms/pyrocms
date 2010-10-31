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

		$this->template->append_metadata( css('images.css', 'wysiwyg') )
				->title('Images');
	}
	
	public function index()
	{
		$folders = $this->file_folders_m->get_all();

		$this->template
			->set('folders', $folders)
			->build('image/browse');
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
		if ($this->images_m->validate())
		{
			$image_path = SITE_UPLOAD_PATH . 'images/';

			if( !is_dir($image_path) )
			{
				mkdir($image_path, 0777, TRUE);
				chmod($image_path, 0777);
			}

			$this->load->library('upload', array(
				'upload_path' => $image_path,
				'allowed_types' => 'gif|jpg|png',
				'encrypt_name' => TRUE
			));

			if ( ! $this->upload->do_upload('image') )
			{
				$this->data->messages['error'] = $this->upload->display_errors();
			}

			else
			{
				$image = $this->upload->data();

				$id = $this->images_m->insert(array(
					'folder_id' => $this->input->post('folder_id'),
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'keywords' => $this->input->post('keywords'),
					'status' => $this->input->post('status'),
					'filename' => $image['file_name'],
					'ext' => strtolower($image['image_type']),
					'size' => $image['file_size'],
					'width' => $image['image_width'],
					'height' => $image['image_height']
				));

				$id > 0
					? $this->session->set_flashdata('success', sprintf('Added image "%s".', $this->input->post('title')))
					: $this->session->set_flashdata('error', 'There was a problem adding the image.');
			}
		}

		else
		{
			$this->data->messages['error'] = validation_errors();
		}

		$this->browse();
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