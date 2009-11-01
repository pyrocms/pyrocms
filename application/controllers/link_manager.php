<?php  
/*
 *
 * link_manager.php
 * Copyright (c) 2009 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com : http://badsyntax.co.uk
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Link_Manager extends Controller {

	public $view_path;

	public function __construct(){
		parent::Controller();
		$this->load->library('tinycimm');
		$this->load->model('tinycimm_model');
		$this->load->config('tinycimm');
		$this->tinycimm->view_path = $this->view_path = $this->config->item('tinycimm_views_root').$this->config->item('tinycimm_views_root_link');
	}

	// returns the page tree html
	public function get_browser($folder=0, $offset=0, $search='') {

		// show the browser
		$this->load->view($this->view_path.'browser', array('pages_html' => $this->recurse_pages(0)));
	}

	public function recurse_pages($parent_id) {

		$pages = $this->tinycimm_model->get_pages_by_parent_id($parent_id);

		if (count($pages)) {
			$html = '';
			foreach($pages as $page) {
				$html .= $this->load->view($this->view_path.'fragments/page_item', array('controller' => &$this, 'page' => $page), true);
			}
			return $this->load->view($this->view_path.'fragments/page_list', array('list_items' => $html), true);
		}
		return "";
	}
  
}
