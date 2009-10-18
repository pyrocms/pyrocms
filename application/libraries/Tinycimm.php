<?php  
/*
 *
 * tinycimm.php
 * Copyright (c) 2009 Richard Willis 
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com : http://badsyntax.co.uk
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class TinyCIMM {

	public function __construct(){
		$ci = &get_instance();
		$this->db = &$ci->db;
		$this->config = &$ci->config;
		$this->input = &$ci->input;
	}

	public function get_asset($asset_id, $width=200, $height=200, $quality=85, $send_nocache=false){
		$ci = &get_instance();
		$asset = $ci->tinycimm_model->get_asset($asset_id) or die('asset not found');
		$asset->filepath = $this->config->item('tinycimm_asset_path_full').$asset_id.$asset->extension;
		if (!@file_exists($asset->filepath)) {
			die('asset not found');
		}
		$asset = $this->resize_asset($asset, $width, $height, $quality);

		$headers = apache_request_headers();

		// checking if the client is validating his cache and if it is current.
		if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($asset->resize_filepath))) {
			// client's cache is current, so we just respond '304 Not Modified'.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($asset->resize_filepath)).' GMT', true, 304);
		} else {
			// image not cached or cache outdated, we respond '200 OK' and output the image.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', @filemtime($asset->resize_filepath)).' GMT', true, 200);
			if ($send_nocache) {
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
			header('Content-type: '.$asset->mimetype);
			header("Content-Length: ".@filesize($asset->resize_filepath));
			flush();
			readfile($asset->resize_filepath);
		}
		exit;
	}

	public function resize_asset($asset, $width=200, $height=200, $quality=90, $cache=true, $update=false){
		$ci = &get_instance();

		$asset->filepath = $this->config->item('tinycimm_asset_path_full').$asset->id.$asset->extension;
		$asset->filename_orig = $this->config->item('tinycimm_asset_path').$asset->id.$asset->extension;
		$asset->filename = $this->config->item('tinycimm_asset_cache_path').$asset->id.'_'.$width.'_'.$height.'_'.$quality.$asset->extension;
		$asset->resize_filepath = $update ? $asset->filepath : $_SERVER['DOCUMENT_ROOT'].$asset->filename;

		if (($cache and !file_exists($asset->resize_filepath) or $update) or !$cache) {
			$resize_config = $this->config->item('tinycimm_image_resize_config');		
			$imagesize = @getimagesize($asset->filepath) or die('asset not found');
			if ($imagesize[0] > $width or $imagesize[1] > $height) {
				$resize_config['width'] = $width;
				$resize_config['height'] = $height;
			} else {
				$resize_config['width'] = $imagesize[0];
				$resize_config['height'] = $imagesize[1];
			}
			$resize_config['source_image'] = $asset->filepath;
			$resize_config['new_image'] = $asset->resize_filepath;
			$ci->load->library('image_lib');
			$ci->image_lib->initialize($resize_config);
			if (!$ci->image_lib->resize()) {
				$this->tinymce_alert($ci->image_lib->display_errors());
				exit;
			}
			$update and $ci->tinycimm_model->update_asset('id', $asset->id, 0, '', '', $asset->filename);
		}
		$resized_image_size = @getimagesize($asset->resize_filepath);
		$asset->width = $resized_image_size[0];
		$asset->height = $resized_image_size[1];
		


		return $asset;
	}

	/**
	* upload asset to directory and insert info into DB
	**/
	public function upload_asset($upload_config) {
		$ci = &get_instance();
		// if file has been uploaded
		if (isset($_FILES[$upload_config['field_name']]['name']) and $_FILES[$upload_config['field_name']]['name'] != '') {

			// load upload library
			$ci->load->library('upload', $upload_config);

			// move file into specified upload directory	
			if (!$ci->upload->do_upload($upload_config['field_name']))  {
			 	/* upload failed */  
				$this->tinymce_alert(preg_replace('/<[^>]+>/', '', $ci->upload->display_errors()));
				exit;
	  		}

			$asset_data = $ci->upload->data();
			$description = trim($ci->input->post('description'));
			$folder = (int) $ci->input->post('uploadfolder');

			if (empty($description)) {
				$this->tinymce_alert('Please supply a brief description for the file.');
				exit;
			}

			// insert the asset info into the db
			$last_insert_id = 
			$ci->tinycimm_model->insert_asset(
				$folder, 
				strtolower(basename($asset_data['orig_name'])), 
				'', 
				$description, 
				strtolower($asset_data['file_ext']), 
				$_FILES[$upload_config['field_name']]['type'],
				$_FILES[$upload_config['field_name']]['size']
			);

			$ci->tinycimm_model->update_asset('id', $last_insert_id, 0, '', '', $last_insert_id.strtolower($asset_data['file_ext']));
			$asset = $ci->tinycimm_model->get_asset($last_insert_id);
			$asset->width = isset($asset_data['image_width']) ? $asset_data['image_width'] : '';
			$asset->height = isset($asset_data['image_height']) ? $asset_data['image_height'] : '';
			$asset->folder = $folder;
			$asset->filepath = $this->config->item('tinycimm_asset_path_full').$asset->id.strtolower($asset->extension);

			// rename the uploaded file, CI's Upload library does not handle custom file naming 	
			rename($asset_data['full_path'], $asset_data['file_path'].$asset->id.strtolower($asset->extension));

			return $asset;
			  
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
		$ci = &get_instance();

		$asset = $ci->tinycimm_model->get_asset($asset_id) or die('asset not found');
		$asset->filepath = $this->config->item('tinycimm_asset_path_full').$asset_id.$asset->extension;

		// delete images from filesystem, including original and thumbnails
		if (file_exists($asset->filepath)) {
			@unlink($asset->filepath);
		}

		// delete the new size specific files				
		if ($handle = @opendir($this->config->item('tinycimm_asset_cache_path_full'))) {
			while (FALSE !== ($file = readdir($handle))) {
				if (preg_match("/{$asset->id}\_[0-9]+\_[0-9]+\_[0-9]+.*/", $file)) {
					@unlink($this->config->item('tinycimm_asset_cache_path_full').$file);
				}
			}	
			@closedir($handle);
		}

		// delete from database
		return $ci->tinycimm_model->delete_asset($asset_id);
	}

	
	public function delete_folder($folder_id=0){
		$ci = &get_instance();
		
		// move images from folder to root folder
		$ci->tinycimm_model->update_asset('folder_id', (int) $folder_id, '');	
		// store affected images
		$this->images_affected = $ci->tinycimm_model->affected_rows();

		// remove folder from database
		return $ci->tinycimm_model->delete_folder((int) $folder_id);
	}

	public function add_folder($name='', $type='image'){
		$ci = &get_instance();
		$name = urldecode(trim($name));

		if ($name == '') {
			return array('outcome' => false, 'message' => 'Please specify a valid folder name.');
		} else if (strlen($name) == 1) {
			return array('outcome' => false, 'message' => 'The folder name must be at least 2 characters in length.');
		} else if (strlen($name) > 24) {
			return array('outcome' => false, 'message' => 'The folder name must be less than 24 characters.\n(The supplied folder name is "+captionID.length+" characters).');
		}

		$ci->tinycimm_model->insert_folder($name, $type);
	}

	/**
	* @TODO would become obsolete if we switched away from a multi folder system and went with categories @Liam
	**/
        public function get_folders_select($folder_id=0){
                $ci = &get_instance();
                $data['folder_id'] = $folder_id;
                $data['folders'] = array();
                foreach($folders = $ci->tinycimm_model->get_folders('name') as $folderinfo) {
                        $data['folders'][] = $folderinfo;
                }
                $ci->load->view($this->view_path.'folder_select', $data);
        }


	public function get_folders_html($type=''){
		$ci = &get_instance();
		$data['folders'][0] = array('id'=>0,'name'=>'All files');
		foreach($folders = $ci->tinycimm_model->get_folders($type, 'name') as $folderinfo) {
			$data['folders'][] = $folderinfo;
		}
		$ci->load->view($this->view_path.'folder_list', $data);
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
	* check if image directories exist, if not then try to create them with 0777/0755 permissions
	* Added config variable to allow user to choose between 0777 and 0755, as different server setups require different settings
	**/
	public function check_paths() {
		// what CHMOD permissions should we use for the upload folders?
		$chmod = $this->config->item('tinycimm_asset_upload_chmod');
		
		// upload dir
		file_exists($this->config->item('tinycimm_asset_path_full'))
		or @mkdir($this->config->item('tinycimm_asset_path_full'), $chmod) 
		or die('Error: Unable to create asset folder '.$this->config->item('tinycimm_asset_path_full').'<br/><strong>Please adjust permissions</strong>');

		// cache dir
		file_exists($this->config->item('tinycimm_asset_cache_path_full'))
		or @mkdir($this->config->item('tinycimm_asset_cache_path_full'), $chmod) 
		or die('Error: Unable to create asset cache folder '.$this->config->item('tinycimm_asset_cache_path_full').'<br/><strong>Please adjust permissions</strong>');
	}
	
	/**
	* Throw up an alert message using TinyMCE's alert method (only used in upload function at this time)
	**/
	public static function tinymce_alert($message){
		echo "<script type=\"text/javascript\">
		parent.removedim();
		parent.parent.tinyMCEPopup.editor.windowManager.alert('".$message."');
		</script>";
	}
	
} // class TinyCIMM
