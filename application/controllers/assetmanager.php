<?php
/*
 * TinyCIMM - controller class
 * assetmanager.php
 * Copyright (c) 2009 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com : http://badsyntax.co.uk
 *
 */

class Assetmanager extends Controller {
	
	public function __construct(){

		parent::Controller();

		$this->load->library('image_lib');
		$this->load->library('session');
		$this->load->library('tinycimm');
		$this->load->library('tinycimm_image');
		$this->load->library('tinycimm_media');
		$this->load->model('tinycimm_model');
		$this->load->config('tinycimm');
		$this->load->helper('url');
		TinyCIMM::check_paths();
		// add your user auth check here to secure tinycimm
		// eg $this->auth->is_logged_in() or die('Access denied.');
  	}

	public function image() {
		!$this->session->userdata('cimm_view') and $this->session->set_userdata('cimm_view', 'thumbnails');
		$param = array_slice(explode('/', $this->uri->uri_string()),4);
		$method = trim($this->uri->segment(3));
		$count = 0;
                foreach($param as $element) {
			$param[$count] = "'".$element."'";
			$count++;
		}
		$this->tinycimm_image->view_path = $this->view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_image');
		$upload_config = $this->config->item('tinycimm_image_upload_config');
		$this->tinycimm_model->allowed_types = explode('|', $upload_config['allowed_types']);
		method_exists($this->tinycimm_image, $method) and eval('$this->tinycimm_image->' . $method . '('.join(',', $param).');');
	}

	public function media() {
		!$this->session->userdata('cimm_view') and $this->session->set_userdata('cimm_view', 'thumbnails');
		$param = array_slice(explode('/', $this->uri->uri_string()),4);
		$method = trim($this->uri->segment(3));
		$count = 0;
                foreach($param as $element) {
			$param[$count] = "'".$element."'";
			$count++;
		}
		$this->tinycimm_media->view_path = $this->view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_media');
		$upload_config = $this->config->item('tinycimm_media_upload_config');
		$this->tinycimm_model->allowed_types = explode('|', $upload_config['allowed_types']);
		method_exists($this->tinycimm_image, $method) and eval('$this->tinycimm_media->' . $method . '('.join(',', $param).');');
	}

	public function file() {
		exit('<em>Sorry, the file browser is still in development</em>');
	}

}
