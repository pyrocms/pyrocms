<?php

class Admin extends Admin_Controller {
	
	function __construct()
	{
		parent::Admin_Controller();

		$this->load->model('forums_m');
		$this->load->model('forum_categories_m');
		//$this->load->model('action_model');
	}
	
	##### index #####
	function index()
	{
		$categories = $this->forum_categories_m->get_all();

		$this->load->vars(array(
			'categories' => &$categories
		));

		$this->template->build('admin/index', $this->data);
	}
}
?>
