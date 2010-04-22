<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author badsyntax.co.uk & pyrocms
*/
 
class Admin extends Admin_Controller {

	public $view_path;

	public function __construct(){
		parent::Admin_Controller();
		$this->load->library('tinycimm');
		$this->load->model('tinycimm_model');
		$this->load->config('tinycimm');
		$this->lang->load('tinycimm');
		!$this->session->userdata('cimm_view') and $this->session->set_userdata('cimm_view', 'thumbnails');
		$this->tinycimm->view_path = $this->view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_image');
	}

	// writes asset data to output buffer
	public function get($asset_id, $width=200, $height=200, $quality=85, $cache_headers=1, $download=0){
		$this->tinycimm->get_asset((int) $asset_id, $width, $height, $quality, $cache_headers, $download);
	}

	// returns a json model object
	public function get_image($image_id=0){
		if ($image = $this->tinycimm_model->get_asset($image_id) and file_exists($this->config->item('tinycimm_asset_path_full').$image->id.$image->extension)) {
			$image->outcome = true;
			$this->tinycimm->response_encode($image);
		} else {
			$this->tincimm->response_encode(array('outcome' => false, 'message' => 'Image not found.'));
		}
	}

	// returns the language config for use in the tinymce dialog
	public function get_javascript_lang(){
		header('Content-Type: text/javascript');
		$this->data->dialog_lang = array();
		foreach($this->lang->language as $key => $item) {
			if (preg_match('/^tinycimm_dialog/', $key)) {
				$this->data->dialog_lang[$key] = $item;
			}
		}
		echo $this->load->view($this->view_path.'tinymce_lang', $this->data, true);
		exit;
	}
	
	// handles asset uploads and inserts info into database
	public function upload(){
		$folder_id = $this->tinycimm->upload_assets($this->config->item('tinycimm_image_upload_config'));
		$this->load->view($this->view_path.'fragments/upload_finished', array('folder_id' => $folder_id));
	}

	// returns the image dialog body HTML
	public function get_dialog_body(){
		$this->load->view($this->view_path.'dialog');
	}

	// return the image manager panel HTML
	public function get_manager($image_id=0){
		$data['image'] = $this->tinycimm_model->get_asset($image_id);
		$this->load->view($this->view_path.'manager', $data);
	}

	// returns the image browser panel HTML
	public function get_browser($folder=0, $offset=0, $search='') {
		$this->load->library('pagination');
		$this->load->helper('url');

		$per_page = $this->config->item('tinycimm_pagination_per_page_'.$this->session->userdata('cimm_view'));
		$total_assets = count($this->tinycimm_model->get_assets($folder, $offset, NULL, $search));

		// set pagination config
		$pagination_config['base_url'] = base_url($this->config->item('tinycimm_image_controller').'get_browser/'.$folder);
		$pagination_config['total_rows'] = $total_assets;
		$pagination_config['full_tag_open'] = '<div class="heading pagination">';
		$pagination_config['full_tag_close'] = '</div>';
		$pagination_config['per_page'] = $per_page;
		$pagination_config['uri_segment'] = 4;
		$this->pagination->initialize($pagination_config);
	
		// get a list of folders
		foreach($folders = $this->tinycimm_model->get_folders('image') as $folderinfo) {
			$data['folders'][] = $folderinfo;
			// selected folder info
			if ($folderinfo['id'] == $folder) {
				$data['selected_folder_info'] = $folderinfo;
		  	}
		}

		if (!isset($data['selected_folder_info'])) {
			if ($search != '') {
				$data['selected_folder_info'] = array(
					'id'=>'0',
					'name' => 'Search results',
					'total_assets' => $total_assets
				);
			} else {
				$data['selected_folder_info'] = $data['folders'][0];
			}
		}

		// format the total file size and total assets amount of the folder
		$totimagesize = $this->tinycimm_model->get_filesize_assets($folder) / 1024; 
		$data['selected_folder_info']['total_file_size'] = ($totimagesize > 1024) ? round($totimagesize/1024, 2).'mb' : round($totimagesize).'kb';
		$data['selected_folder_info']['total_assets'] = $this->tinycimm_model->get_total_assets($folder);

		// get a list of images for this folder
		$data['images'] = array();
		foreach($assets = $this->tinycimm_model->get_assets((int) $folder, $this->tinycimm->user->id, $offset, $per_page, $search) as $image) {
			$data['images'][] = $image;	 
		}
		$this->load->view($this->view_path.'browser', array('data'=>$data));
	}
  
	// update asset row
	public function update_asset($image_id=0) {
		
		!count($_POST) and die();

		$fields = array(
			'folder_id' => $_POST['folder_id'], 
			'filename' => $_POST['filename'], 
			'description' => $_POST['description']
		);
		if (!$this->tinycimm_model->update_asset($image_id, $fields)) {
			$response['outcome'] = false;
			$response['message'] = 'Image not found.';
			$this->tinycimm->response_encode($response);
			exit;
		}
		$response['outcome'] = true;
		$response['message'] = 'Image successfully updated.';
		$this->tinycimm->response_encode($response);
		exit;
	}

	// update a folder 
	public function save_folder($folder_id=0){
		
		!count($_POST) and die();

		$response = $this->tinycimm->save_folder($folder_id, $_POST['folder_name']);
		
		$this->tinycimm->response_encode($response);
		exit;
	}

	public function get_folders($type='list'){
		$this->tinycimm->get_folders($type);
	}

  	// delete an image from database and file system
	public function delete_image($image_id=0) {
		$image = $this->tinycimm_model->get_asset($image_id);
		$this->tinycimm->delete_asset((int) $image_id);
		
		$response['outcome'] = true;
		$response['message'] = 'Image successfully deleted.';
		$response['folder'] = $image->folder_id; 
		$this->tinycimm->response_encode($response);
		exit;
	}

	// delete a folder from the database
	public function delete_folder($folder_id=0) {
		if (!$this->tinycimm->delete_folder((int) $folder_id)) {
			$response['outcome'] = false;
			$response['message'] = 'Folder not found.';
			$this->tinycimm->response_encode($response);
			exit;
		}
		$response['outcome'] = true;
		$response['images_affected'] = $this->tinycimm->images_affected;
		$this->tinycimm->response_encode($response);
		exit;
 	}
  	
	// resizes an image
	public function save_image_size($image_id, $width, $height, $quality=90, $update=true){
		if (!(int) $width or !(int) $height) {
			$this->tinycimm->response_encode(array('outcome'=>false,'message'=>'Incorrect dimensions supplied. (Cant have value of 0)'));
		}
		$response = $this->tinycimm->resize_asset($this->tinycimm_model->get_asset($image_id), $width, $height, $quality, true, $update);
		
		$response->outcome = true;
		$response->message = 'Image size successfully saved.';
		$this->tinycimm->response_encode($response);
	}
  
	// change browser template in user session
	public function change_view($view='thumbnails'){
		$this->session->set_userdata('cimm_view', $view);
		exit;
	}

	// displays the image upload form
	public function get_uploader_form(){
		$data['upload_config'] = $this->config->item('tinycimm_image_upload_config');
		$this->load->view($this->view_path.'upload_form', $data);
	}
	
	// get extension of filename
	public static function get_extension($filename) {
		return end(explode('.', $filename));
	}

	public function link_manager($action){
		if ($action == 'get_dialog_body') {
			$this->link_manager_get_dialog_body();
		} else if ($action == 'get_browser') {
			$this->link_manager_get_browser();
		} else if ($acton == 'recurse_pages') {
			$this->link_manager_recurse_pages();
		}
	}

	// returns the link dialog body HTML
	public function link_manager_get_dialog_body(){
		$view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_link');

		$this->load->view($view_path.'dialog');
	}

	// returns the page tree html
	public function link_manager_get_browser($folder=0, $offset=0, $search='') {
		$view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_link');

		// show the browser
		$this->load->view($view_path.'browser', array('pages_html' => $this->link_manager_recurse_pages(0)));
	}

	public function link_manager_recurse_pages($parent_id) {

		$pages = $this->tinycimm_model->get_pages_by_parent_id($parent_id);

		$view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_link');

		if (count($pages)) {
			$html = '';
			foreach($pages as $page) {
				$html .= $this->load->view($view_path.'fragments/page_item', array('controller' => &$this, 'page' => $page), true);
			}
			return $this->load->view($view_path.'fragments/page_list', array('list_items' => $html), true);
		}
		return "";
	}
  
}
