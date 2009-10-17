<?php  
/*
 *
 * tinycimm_image.php
 * Copyright (c) 2009 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com : http://badsyntax.co.uk
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class TinyCIMM_image extends TinyCIMM {

	var $view_path = '';

	public function __construct(){
		parent::__construct();
	}

	public function get($asset_id, $width=200, $height=200){
		$this->get_asset((int) $asset_id, $width, $height);
	}

	// returns an asset database object
	public function get_image($image_id=0){
		$ci = &get_instance();
		if ($image = $ci->tinycimm_model->get_asset($image_id)) {
			// get image dimenions
			$dimensions = getimagesize($ci->config->item('tinycimm_asset_path').$image->filename);
			$image->width = $dimensions[0];
			$image->height = $dimensions[1];
			$image->src = $ci->config->item('tinycimm_controller')."image/get/{$image->id}/{$image->width}/{$image->height}";
			$image->outcome = true;
			$this->response_encode($image);
		} else {
			$this->response_encode(array('outcome' => false, 'message' => 'Image not found.'));
		}
	}
	
	/**
	* uploads an asset and insert info into db
	**/
	public function upload(){
		$ci = &get_instance();

		$asset = $this->upload_asset($this->config->item('tinycimm_image_upload_config'));
		
		// resize image
		$max_x = (int) $ci->input->post('max_x');
		$max_y = (int) $ci->input->post('max_y');
		$adjust_size = (int) $ci->input->post('adjust_size') === 1 and ($asset->width > $max_x or $asset->height > $max_y);
		if ($adjust_size and ($asset->width > $max_x or $asset->height > $max_y)) {
			$this->resize_asset($asset, $max_x, $max_y, 90, true, true);
		}

		echo
		"<script type=\"text/javascript\">
		parent.removedim();
		parent.updateimg('".$asset->folder."');
		</script>";
		exit;
	}

	/**
	* get browser 
	**/
	public function get_browser($folder=0, $offset=0, $search='') {
		$ci = &get_instance();
		$ci->load->library('pagination');
		$ci->load->helper('url');

		$per_page = $ci->config->item('tinycimm_pagination_per_page_'.$ci->session->userdata('cimm_view'));
		$total_assets = count($ci->tinycimm_model->get_assets($folder, $offset, NULL, $search));

		$pagination_config['base_url'] = base_url($ci->config->item('tinycimm_controller').'image/get_browser/'.$folder);
		$pagination_config['total_rows'] = $total_assets;
		$pagination_config['full_tag_open'] = '<div class="heading pagination">';
		$pagination_config['full_tag_close'] = '</div>';
		$pagination_config['per_page'] = $per_page;
		$pagination_config['uri_segment'] = 5;
		$ci->pagination->initialize($pagination_config);
	
		// store an 'uncategorized' root folder (aka smart folder)
		$data['folders'][] = array( 'id'=>'0', 'name' => 'All images', 'total_assets' => $total_assets);

		// get a list of folders, and store the total amount of assets
		foreach($folders = $ci->tinycimm_model->get_folders('image') as $folderinfo) {
			$folderinfo['total_assets'] = count($ci->tinycimm_model->get_assets($folderinfo['id'], $offset, $per_page, $search));
			$data['folders'][] = $folderinfo;
			// selected folder info
			if ($folderinfo['id'] == $folder) {
				$data['selected_folder_info'] = $folderinfo;
		  	}
		}
		if (!isset($data['selected_folder_info'])) {
			if ($search != '') {
				$data['selected_folder_info'] = array( 'id'=>'0', 'name' => 'Search results', 'total_assets' => $total_assets);
			} else {
				$data['selected_folder_info'] = $data['folders'][0];
			}
		}

		$totimagesize = (int) $ci->tinycimm_model->get_filesize_assets($folder) / 1024;
		$data['selected_folder_info']['total_file_size'] = ($totimagesize > 1024) ? round($totimagesize/1024, 2).'mb' : $totimagesize.'kb';

		$data['images'] = array();
		foreach($assets = $ci->tinycimm_model->get_assets((int) $folder, $offset, $per_page, $search) as $image) {
			$image_path = $this->config->item('tinycimm_asset_path').$image['id'].$image['extension'];
			$image_size = ($imgsize = @getimagesize($image_path)) ? $imgsize : array(0,0);
			$image['width'] = $image_size[0];
			$image['height'] = $image_size[1];
			$image['dimensions'] = $image_size[0].'x'.$image_size[1];
			$image['filesize'] = round(@filesize($image_path)/1024, 0);
			// format image name
			if (strlen($image['name']) > 34) {
				$image['name'] = substr($image['name'], 0, 34);
			}
			$data['images'][] = $image;	 
		}
		$ci->load->view($this->view_path.$ci->session->userdata('cimm_view').'_list', $data);
	}
  
	/**
	* update asset row
	**/
	public function update_asset($image_id=0) {
		if (!count($_POST)) {
			exit;
		}
		$ci = &get_instance();
		if (!$ci->tinycimm_model->update_asset((int) $image_id, $_POST['folder_id'], $_POST['name'], $_POST['description'])) {
			$response['outcome'] = false;
			$response['message'] = 'Image not found.';
			$this->response_encode($response);
			exit;
		}
		$response['outcome'] = true;
		$response['message'] = 'Image successfully deleted.';
		$this->response_encode($response);
		exit;
	}

  	/**
  	* delete an image from database and file system
  	**/
	public function delete_image($image_id=0) {
		$ci = &get_instance();
		$image = $ci->tinycimm_model->get_asset($image_id);
		$this->delete_asset((int) $image_id);
		
		$response['outcome'] = true;
		$response['message'] = 'Image successfully deleted.';
		$response['folder'] = $image->folder_id; 
		$this->response_encode($response);
		exit;
	}
	
  	/**
  	* @TODO would become obsolete if we switched away from a multi folder system and went with categories @Liam
  	**/
	public function delete_folder($folder_id=0) {
		$ci = &get_instance();
		if (!parent::delete_folder((int) $folder_id)) {
			$response['outcome'] = false;
			$response['message'] = 'Image not found.';
			$this->response_encode($response);
			exit;
		}
		$response['outcome'] = true;
		$response['images_affected'] = $this->images_affected;
		$this->response_encode($response);
		exit;
 	}
  	
  	/**
  	* @TODO would become obsolete if we switched away from a multi folder system and went with categories @Liam
  	**/
	public function add_folder($name='', $type=''){ 
		if (is_array($response = parent::add_folder($name, $type))) {
                        $this->response_encode($response);
                        exit;
                }
		$this->get_folders_html('image');
  	}
  	
        public function get_folders_select($folder_id=0){
                parent::get_folders_select((int) $folder_id);
        }

	public function get_folders_html(){
		parent::get_folders_html('image');
	}
	
	/**
	* resizes an image
	**/
	public function save_image_size($image_id, $width, $height, $quality=90, $update=true){
		$ci = &get_instance();
		if (!(int) $width or !(int) $height) {
			TinyCIMM::response_encode(array('outcome'=>false,'message'=>'Incorrect dimensions supplied. (Cant have value of 0)'));
		}
		$response = $this->resize_asset($ci->tinycimm_model->get_asset($image_id), $width, $height, $quality, true, $update);
		
		$response->outcome = true;
		$response->message = 'Image size successfully saved.';
		$this->response_encode($response);
	}
  
	/**
	* change browser template in user session
	**/
	public function change_view($view='thumbnails'){
		$ci = &get_instance();
		$ci->session->set_userdata('cimm_view', $view);
		exit;
	}


	/**
	* displays the image upload form
	*/
	public function get_uploader_form(){
		$ci = &get_instance();
		$data['upload_config'] = $ci->config->item('tinycimm_image_upload_config');
		$ci->load->view($this->view_path.'upload_form', $data);
	}
	
	/**
	* get extension of filename
	**/
	public static function get_extension($filename) {
		return end(explode('.', $filename));
	}
  	
} // class TinyCIMM_image
