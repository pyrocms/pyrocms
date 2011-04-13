<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		WYSIWYG
 * @author			Stephen Cozart
 *
 * Manages file uploads from wysiwyg plugins
 */
class Upload extends WYSIWYG_Controller
{
	function __construct()
	{
		parent::WYSIWYG_Controller();
        $this->config->load('files/files');
        $this->_path = FCPATH . '/' . $this->config->item('files_folder') . '/';
		
		// If the folder hasn't been created by the files module create it now
		is_dir($this->_path) OR mkdir($this->_path, 0777, TRUE);
	}

	public function index()
	{
		$this->load->library('form_validation');

		$rules = array(
			array(
				'field'   => 'name',
				'label'   => 'lang:files.folders.name',
				'rules'   => 'trim|required'
			),
			array(
				'field'   => 'description',
				'label'   => 'lang:files.description',
				'rules'   => ''
			),
			array(
				'field'   => 'folder_id',
				'label'   => 'lang:files.labels.parent',
				'rules'   => ''
			),
			array(
				'field'   => 'type',
				'label'   => 'lang:files.type',
				'rules'   => 'trim|required'
			),
		);

		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run())
		{
			// Setup upload config
			$type		= $this->input->post('type');
			$allowed	= $this->config->item('files_allowed_file_ext');

			$config['upload_path']		= $this->_path;
			$config['allowed_types']	= implode('|', $allowed[$type]);
			
			
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('userfile'))
			{
                $this->session->set_flashdata('notice', $this->upload->display_errors());
			}
			else
			{
				$img = array('upload_data' => $this->upload->data());

				$this->file_m->insert(array(
					'folder_id'		=> $this->input->post('folder_id'),
					'user_id'		=> $this->user->id,
					'type'			=> $type,
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description') ? $this->input->post('description') : '',
					'filename'		=> $img['upload_data']['file_name'],
					'extension'		=> $img['upload_data']['file_ext'],
					'mimetype'		=> $img['upload_data']['file_type'],
					'filesize'		=> $img['upload_data']['file_size'],
					'width'			=> (int) $img['upload_data']['image_width'],
					'height'		=> (int) $img['upload_data']['image_height'],
					'date_added'	=> time(),
				));

                $this->session->set_flashdata('success',  lang('files.create_success'));
			}

			redirect("admin/wysiwyg/{$this->input->post('redirect_to')}/index/{$this->input->post('folder_id')}");
		}
	}

}