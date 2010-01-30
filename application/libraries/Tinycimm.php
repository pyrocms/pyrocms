<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author badsyntax.co.uk & pyrocms
*/
 
class TinyCIMM {

	// CodeIgniter instance
	private $ci;

	private $db;

	private $config;
	
	private $input;
	
	public $user;


	public function __construct(){
		$this->ci = &get_instance();
		$this->ci->config->load('tinycimm');
		$this->db = &$this->ci->db;
		$this->config = &$this->ci->config;
		$this->input = &$this->ci->input;
		
		$this->check_paths();
		$this->check_permissions();
	}

	// writes asset data to output buffer 
	public function get_asset($asset_id, $width=200, $height=200, $quality=85, $cache_headers=1, $download=0){

		$asset = $this->ci->tinycimm_model->get_asset($asset_id) or die('asset not found');
		$asset->filepath = $this->config->item('tinycimm_asset_path_full').$asset_id.$asset->extension;

		if (!$download) {
			$headers = apache_request_headers();

			// if its an image and width and height dimenions are supplied, then resize it
			if ($width and $height and 'image' == current(explode('/', $asset->mimetype))) {
				$asset = $this->resize_asset($asset, $width, $height, $quality);
			}

			// checking if the client is validating his cache and if it is current.
			if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($asset->cache_filepath))) {
				// client's cache is current, so we just respond '304 Not Modified'.
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($asset->cache_filepath)).' GMT', true, 304);
				flush();
			} else {
				// image not cached or cache outdated, we respond '200 OK' and output the image.
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($asset->cache_filepath)).' GMT', true, 200);
				if (!$cache_headers) {
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
				}
				header('Content-type: '.$asset->mimetype);
				header("Content-Length: ".@filesize($asset->cache_filepath));
				flush();
				readfile($asset->cache_filepath);
			}
		} else {
			// force the browser to download the file
			header('Content-Description: File Transfer');
			header('Content-Type: '.$asset->mimetype);
			header('Content-Disposition: attachment; filename="'.basename($asset->filename).'"');
			header('Content-Transfer-Encoding: binary');
			header('Pragma: public');
			header('Content-Length: '.@filesize($asset->filepath));
			flush();
                	readfile($asset->filepath);
		}
		exit;
	}

	public function resize_asset($asset, $width=200, $height=200, $quality=90, $cache=true, $update=false){

		$asset = is_object($asset) ? $asset : $this->ci->tinycimm_model->get_asset($asset);
		$asset->filepath = $this->config->item('tinycimm_asset_path_full').$asset->id.$asset->extension;
		$asset->filename = $this->config->item('tinycimm_asset_cache_path').$asset->id.'_'.$width.'_'.$height.'_'.$quality.$asset->extension;
		$asset->cache_filepath = $update ? $asset->filepath : $_SERVER['DOCUMENT_ROOT'].$asset->filename;

		// if cache file doesn't already exist 
		if (($cache and !file_exists($asset->cache_filepath) or $update) or !$cache) {

			// prepare the resize config
			$resize_config = $this->config->item('tinycimm_image_resize_config');		
			if ($asset->width > $width or $asset->height > $height) {
				$resize_config['width'] = $width;
				$resize_config['height'] = $height;
			} else {
				$resize_config['width'] = $asset->width;
				$resize_config['height'] = $asset->height;
			}
			$resize_config['source_image'] = $asset->filepath;
			$resize_config['new_image'] = $asset->cache_filepath;
			$resize_config['quality'] = $quality;

			// load image lib and resize image
			$this->ci->load->library('image_lib');
			$this->ci->image_lib->initialize($resize_config);
			if (!$this->ci->image_lib->resize()) {
				$this->tinymce_alert($this->ci->image_lib->display_errors());
				exit;
			}
		}

		// get cache file dimensions
		$resized_image_size = @getimagesize($asset->cache_filepath);
		$asset->width = $resized_image_size[0];
		$asset->height = $resized_image_size[1];
		
		return $asset;
	}

	/**
	* upload asset to directory and insert info into DB
	**/
	public function upload_assets($upload_config) {

		if (isset($_FILES) and count($_FILES)) {

			// load upload library
			$this->ci->load->library('upload', $upload_config);

			$files_uploaded = 0;

			foreach($_FILES as $input_name => $file) {
			
				if ($file['name'] != "") {	

					// move file into specified upload directory	
					if (!$this->ci->upload->do_upload($input_name))  {
						/* upload failed */  
						$this->tinymce_alert(preg_replace('/<[^>]+>/', '', $this->ci->upload->display_errors()));
						exit;
					}
					$asset_data = $this->ci->upload->data();
					$asset_folder = (int) $this->ci->input->post('uploadfolder');
					
					// format the description from the file name
					$description = preg_replace("/\\\/", '/', $file['name']);
					$description = preg_replace("/.*\/|\.\w*$/", "", $description);
					$description = preg_replace("/[_-]/", " ", $description);
					$description = preg_replace("/\s{2,}/", " ", $description);

					// get the image dimensions if file is type image
					$asset_width = $asset_height = NULL;
					if ('image' == current(explode('/', $file['type']))) {
						$dimensions = @getimagesize($file['tmp_name']);
						$asset_width = $dimensions[0];
						$asset_height = $dimensions[1];
					}

					$asset_info = array(
						'folder_id' => $asset_folder,
						'user_id' => $this->user->id,
						'name' => strtolower(basename($asset_data['orig_name'])), 
						'filename' => strtolower(basename($asset_data['orig_name'])), 
						'description' => $description, 
						'extension' =>strtolower($asset_data['file_ext']), 
						'mimetype' => $file['type'],
						'filesize' => $file['size'],
						'width' => $asset_width,
						'height' => $asset_height
					);
					
					// insert the asset info into the database
					$last_insert_id = $this->ci->tinycimm_model->insert_asset($asset_info);

					// rename the uploaded file, CI's Upload library does not handle custom file naming 	
					rename($asset_data['full_path'], $asset_data['file_path'].$last_insert_id.strtolower($asset_data['file_ext']));

					// resize uploaded image
					$max_x = (int) $this->ci->input->post('max_x');
					$max_y = (int) $this->ci->input->post('max_y');
					if ((int) $this->ci->input->post('adjust_size') === 1 and ($asset_width > $max_x or $asset_height > $max_y)) {
						$asset = $this->resize_asset($last_insert_id, $max_x, $max_y, 90, true, true);
						$this->ci->tinycimm_model->update_asset($asset->id, array('width'=>$asset->width,'height'=>$asset->height));
					}

					$files_uploaded++;
				}
			}

			if (!$files_uploaded) {
				$this->tinymce_alert('Please select a file to upload.');
				exit;
			}

			return $asset_folder;
			  
		} else {
			$this->tinymce_alert('Please select a file to upload.');
			exit;
		}
  	}
  	
	/**
	* Deletes a file from the database and from the fileserver
	* Goes on to also delete any new files that were created as a result of resizing the image
	**/
	public function delete_asset($asset_id=0){

		$asset = $this->ci->tinycimm_model->get_asset($asset_id) or die('asset not found');
		$filepath = $this->config->item('tinycimm_asset_path_full').$asset_id.$asset->extension;

		// delete original image from filesystem
		file_exists($filepath) && @unlink($filepath);

		// delete the cached size specific files				
		if ($handle = @opendir($this->config->item('tinycimm_asset_cache_path_full'))) {
			while (FALSE !== ($file = readdir($handle))) {
				if (preg_match("/{$asset->id}\_[0-9]+\_[0-9]+\_[0-9]+.*/", $file)) {
					@unlink($this->config->item('tinycimm_asset_cache_path_full').$file);
				}
			}	
			@closedir($handle);
		}

		// delete from database
		return $this->ci->tinycimm_model->delete_asset($asset_id);
	}

	
	public function delete_folder($folder_id=0){
		
		// move images from folder to root folder
		$this->ci->tinycimm_model->update_assets(array('folder_id'=>(int) $folder_id), array("folder_id"=>0));	
	
		// store affected images
		$this->images_affected = $this->ci->tinycimm_model->affected_rows();

		// remove folder from database
		return $this->ci->tinycimm_model->delete_folder((int) $folder_id);
	}

	public function save_folder($folder_id=0, $name='', $type='image'){
		
		$name = urldecode(trim($name));

		if ($name == '') {
			return array('outcome' => false, 'message' => 'Please specify a valid folder name.');
		} else if (strlen($name) == 1) {
			return array('outcome' => false, 'message' => 'The folder name must be at least 2 characters in length.');
		} else if (strlen($name) > 24) {
			return array('outcome' => false, 'message' => 'The folder name must be less than 24 characters.\n(The supplied folder name is "+captionID.length+" characters).');
		}

		$this->ci->tinycimm_model->save_folder($folder_id, $name, $type);
		return array('outcome' => true);
	}

	// return list of folders in HTML
        public function get_folders($type='select', $folder_id=0, $return=false){
                $data['folder_id'] = $folder_id;
                $data['folders'] = array();
                foreach($folders = $this->ci->tinycimm_model->get_folders('name') as $folderinfo) {
                        $data['folders'][] = $folderinfo;
                }
                return $this->ci->load->view($this->ci->view_path.'fragments/folder_'.$type, $data, $return);
        }

	/**
	* Takes a PHP array and outputs it as a JSON array to screen using PHP's die function
	*
	* @param $response an array in PHP
	**/
	public function response_encode($response=array()) {
		header("Pragma: no-cache");
		header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		header('Content-Type: text/x-json');
		if (function_exists("json_encode")) {
			die(json_encode($response));
		} else {
			$response_txt = '{';
			foreach($response as $key => $value) {
				$response_txt .= '"'.$key.'":"'.$value.'",';
			}
			$response_txt = rtrim($response_txt, ',').'}';
			die($response_txt);
		}
	}
	
	/** 
	* check if image directories exist and have the correct permissions, if not then try to create them with specified permissions
	**/
	private function check_paths() {
		// what CHMOD permissions should we use for the upload folders?
		$chmod = $this->config->item('tinycimm_asset_path_chmod');
		
		// upload dir
		(file_exists($this->config->item('tinycimm_asset_path_full')) and (substr(sprintf('%o', fileperms($this->config->item('tinycimm_asset_path_full'))), -4) == $chmod))
		or @mkdir($this->config->item('tinycimm_asset_path_full'), $chmod) 
		or $this->ci->uri->segment(2) != 'get_javascript_lang'
		and die('Error: '.$this->config->item('tinycimm_asset_path_full').'<br/><strong>Please adjust permissions to '.$chmod.'</strong>');

		// cache dir
		(file_exists($this->config->item('tinycimm_asset_cache_path_full')) and (substr(sprintf('%o', fileperms($this->config->item('tinycimm_asset_cache_path_full'))), -4) == $chmod))
		or @mkdir($this->config->item('tinycimm_asset_cache_path_full'), $chmod) 
		or $this->ci->uri->segment(2) != 'get_javascript_lang'
		and die('Error: '.$this->config->item('tinycimm_asset_cache_path_full').'<br/><strong>Please adjust permissions to'.$chmod.'</strong>');
	}
	
	private function check_permissions(){
		// Make sure we have the user module
		if( ! module_exists('users') ) {
			die('The user module is missing.');
		} else {
			// Load the user model and get user data
			$this->ci->load->model('users/users_m');
			$this->ci->load->library('users/user_lib');
			$this->user =& $this->ci->user_lib->user_data;
		}

		// check that an admin user is logged in
		!$this->ci->user_lib->check_role('admin') and die('You dont have permission to access this feature.');
	}

	
	/**
	* Throw up an alert message using TinyMCE's alert method (only used in upload function)
	**/
	private function tinymce_alert($message){
		echo $this->ci->load->view($this->view_path.'fragments/tinymce_alert', array('message'=>$message), true);
	}
	
} // class TinyCIMM
