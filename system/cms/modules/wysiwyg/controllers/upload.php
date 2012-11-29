<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Manages file uploads from wysiwyg plugins
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\WYSIWYG\Controllers
 */
class Upload extends WYSIWYG_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->config->load('files/files');
        $this->_path = FCPATH . '/' . $this->config->item('files:path') . '/';
		
		// If the folder hasn't been created by the files module create it now
		is_dir($this->_path) OR mkdir($this->_path, 0777, true);
	}

	public function index()
	{
		$this->load->library('form_validation');

		$rules = array(
			array(
				'field'   => 'name',
				'label'   => 'lang:files:name',
				'rules'   => 'trim'
			),
			array(
				'field'   => 'description',
				'label'   => 'lang:files:description',
				'rules'   => ''
			),
			array(
				'field'   => 'folder_id',
				'label'   => 'lang:files:folder',
				'rules'   => 'required'
			),
		);

		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run())
		{
			$input = $this->input->post();

			$results = Files::upload($input['folder_id'], $input['name'], 'userfile');

			// if the upload was successful then we'll add the description too
			if ($results['status'])
			{
				$data = $results['data'];
				$this->file_m->update($data['id'], array('description' => $input['description']));
			}

			// upload has a message to share... good or bad?
			$this->session->set_flashdata($results['status'] ? 'success' : 'notice', $results['message']);
		}
		else
		{
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect("admin/wysiwyg/{$this->input->post('redirect_to')}/index/{$this->input->post('folder_id')}");
	}

}