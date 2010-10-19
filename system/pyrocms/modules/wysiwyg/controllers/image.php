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

		$this->load->helper('tree');

		$this->load->model('libraries/folders_m');
		$this->load->model('libraries/images_m');

		$this->template->title('Images');
	}
	
	public function index()
	{
		if($folder_id = $this->input->post('folder_id'))
		{
			$this->load->model('folders/folders_m');
			$folders = $this->folders_m->get_folder_path($folder_id);
		}

		$this->load->vars(array(
			'source' => $this->input->post('source') ? SITE_UPLOAD_URI . 'images/' . $this->input->post('source') : '',
			'title' => $this->input->post('title'),
			'width' => (int) $this->input->post('width'),
			'height' => (int) $this->input->post('height'),
			'folder_id' => $folder_id,
			'folders' => empty($folders) ? array() : $folders
		));

		$this->template->build('image/form', $this->data);
	}

	public function browse()
	{
		$this->load->helper('tree');

		// Create the nested select list
		$folder_options = array();
		foreach($this->folders_m->get_image_folders() as $folder)
		{
			$folder_options[$folder->parent_id][] = $folder;
		}

		// Slice up the URL
		$segments = $this->uri->uri_to_assoc(5);

		$query = !empty($segments['q']) ? urldecode($segments['q']) : $this->input->post('q');
		$folder_id = !empty($segments['folder']) ? $segments['folder'] : $this->input->post('folder_id');
		$hide_folders = (int) !empty($segments['hide_folders']) ? $segments['hide_folders'] : $this->input->post('hide_folders');
		$status = !empty($segments['status']) ? $segments['status'] : $this->input->post('status');

		$query_pair = $folder_pair = $status_pair = $hide_folders_pair = '';

		if($query != FALSE)
		{
			$_POST['q'] = $criteria['query'] = $query;

			$query_pair = 'q/' . urlencode($query) . '/';
		}

		if($folder_id != FALSE)
		{
			$_POST['folder_id'] = $criteria['folder_id'] = $folder_id;

			$folder_pair = 'folder/' . $folder_id . '/';
		}

		if($hide_folders != FALSE)
		{
			$_POST['hide_folders'] = $criteria['hide_folders'] = $hide_folders;

			$hide_folders_pair = 'hide_folders/' . $hide_folders . '/';
		}

		if($status != FALSE)
		{
			$_POST['status'] = $criteria['status'] = $status;

			$status_pair = 'status/' . $status . '/';
		}

		// Show relevent pages
		if(!empty($criteria))
		{
			$pagination = create_pagination(
				$test = 'cms/wysiwyg/images/index/' . $query_pair . $status_pair . $folder_pair . $hide_folders_pair,
				count($this->images_m->filter($criteria)),
				NULL,
				6 + (count($criteria) * 2)
			);

			// Generate the breadcrumbs
			$breadcrumbs = $this->folders_m->get_parent_tree($folder_id);

			// Save this for folder links
			$this->data->criteria_uri = $query_pair . $status_pair . $hide_folders_pair;

			$images = $this->images_m->filter($criteria, $pagination['limit'][0], $pagination['limit'][1]);
		}

		// Show all pages
		else
		{
			$pagination = create_pagination(
				'cms/wysiwyg/images/index',
				count($this->images_m->get_root_images()),
				NULL,
				6
			);

			$breadcrumbs = array();

			$this->data->criteria_uri = '';

			$images = $this->images_m->get_root_images($pagination['limit'][0], $pagination['limit'][1]);
		}

		$this->load->vars(array(
			'folder_options' => &$folder_options,
			'pagination' => &$pagination,
			'breadcrumbs' => &$breadcrumbs,
			'images' => &$images
		));

		// Create the layout
		$this->template
			->append_metadata( css('library.css', 'libraries') )
			->build('image/browse', $this->data);
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