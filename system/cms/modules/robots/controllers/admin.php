<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Robots module for PyroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	PyroCMS
 * @subpackage 	Robots Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'robots';

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('robots_m');
		$this->load->library('form_validation');
		$this->load->language('robots');
		
		$this->item_validation_rules = array(
			array(
				'field' => 'txt',
				'label' => 'robots:label:txt',
				'rules' => 'trim|max_length[1000]|required'
			)
		);
	}
	
	public function index()
	{
		$this->data = $this->robots_m->get_robots_txt();
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run()):
			
			unset($_POST['btnAction']);
			if($this->robots_m->update_robots_txt($this->input->post())):
			
				$this->session->set_flashdata('success', lang('robots:message:success'));
				redirect('admin/robots');
			
			else:
			
				$this->session->set_flashdata('error', lang('robots:message:error'));
				redirect('admin/robots');
			
			endif;
		
		endif;
		
		$this->template
			 ->title($this->module_details['name'], lang('robots:title:overview'))
			 ->build('admin/form', $this->data);
	}
}
/* End of file admin.php */