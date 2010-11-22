<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		Eric Barnes <eric@pyrocms.com>
 * @package		PyroCMS
 * @subpackage	file
 */
class Admin extends Admin_Controller {

	private $_folders = array();
	private $_path = '';

	/**
	 * Constructor
	 *
	 * Loads dependencies.
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::Admin_Controller();

		$this->load->models(array('file_m', 'file_folders_m'));
		$this->lang->load('files');
		$this->config->load('files');

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
		$this->template->set_partial('nav', 'admin/partials/nav');

		$this->_path = FCPATH . '/' . $this->config->item('files_folder') . '/';
	}

	/**
	 * Index
	 *
	 * Shows the default
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$file_folders = $this->file_folders_m->order_by('name')->get_many_by(array('parent_id' => '0'));

		if ($error = $this->_check_dir())
		{
			$this->template->error = $this->_check_dir();
		}

		$this->template
			->title($this->module_details['name'])
			->set('file_folders', $file_folders)
			->build('admin/layouts/index');
	}

	// ------------------------------------------------------------------------

	/**
	 * Upload
	 *
	 * Upload a file to the destination folder
	 *
	 * @params int	The folder id
	 */
	public function upload($id = '')
	{
		$this->template->set_layout('modal', 'admin');

		$file->name = '';
		$file->description = '';
		$file->type = '';
		$file->folder_id = $id;

		$data->file =& $file;
		$data->folders = $this->file_folders_m->get_folders();

		$data->types = array('a' => lang('files.a'), 'v' => lang('files.v'), 'd' => lang('files.d'), 'i' => lang('files.i'), 'o' => lang('files.o'));

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
			$type = $this->input->post('type');
			$allowed = $this->config->item('files_allowed_file_ext');

			$config['upload_path'] = $this->_path;
			$config['allowed_types'] = $allowed[$type];

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('userfile'))
			{
				$data->messages['notice'] = $this->upload->display_errors();
			}
			else
			{
				$img = array('upload_data' => $this->upload->data());

				$this->file_m->insert(array(
					'folder_id' => $this->input->post('folder_id'),
					'user_id' => $this->user->id,
					'type' => $type,
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'filename' => $img['upload_data']['file_name'],
					'extension' => $img['upload_data']['file_ext'],
					'mimetype' => $img['upload_data']['file_type'],
					'filesize' => $img['upload_data']['file_size'],
					'width' => (int) $img['upload_data']['image_width'],
					'height' => (int) $img['upload_data']['image_height'],
					'date_added' => time(),
				));

				$data->messages['success'] = lang('files.success');
				#redirect('admin/files');
			}
		}

		$this->template->build('admin/files/upload', $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit Uploaded file
	 *
	 */
	public function edit($id = '')
	{
		$id OR redirect('admin/files/upload');

		$this->template->set_layout('modal', 'admin');
		$data->error = '';

		$file = $this->file_m->get($id);

		$data->file =& $file;
		$data->folders = $this->file_folders_m->get_folders();

		$data->types = array('a' => lang('files.a'), 'v' => lang('files.v'), 'd' => lang('files.d'), 'i' => lang('files.i'), 'o' => lang('files.o'));

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
			$filename = $file->filename;
			$type = $this->input->post('type');

			if ( ! empty($_FILES['userfile']['name']))
			{
				//we are uploading a file
				$this->file_m->delete_file($id); //remove the original image
				// Setup upload config
				$allowed = $this->config->item('files_allowed_file_ext');
				$config['upload_path'] = $this->_path;
				$config['allowed_types'] = $allowed[$type];

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('userfile'))
				{
					$data->messages['notice'] = $this->upload->display_errors();
				}
				else
				{
					$img = array('upload_data' => $this->upload->data());
					$filename = $img['upload_data']['file_name'];

					$this->file_m->update($id, array(
						'folder_id' => $this->input->post('folder_id'),
						'user_id' => $this->user->id,
						'type' => $type,
						'name' => $this->input->post('name'),
						'description' => $this->input->post('description'),
						'filename' => $img['upload_data']['file_name'],
						'extension' => $img['upload_data']['file_ext'],
						'mimetype' => $img['upload_data']['file_type'],
						'filesize' => $img['upload_data']['file_size'],
						'width' => $img['upload_data']['image_width'],
						'height' => $img['upload_data']['image_height'],
					));

					$data->messages['success'] = lang('files.success');
				}
			}
			else
			{
				$this->file_m->update($id, array(
					'folder_id' => $this->input->post('folder_id'),
					'user_id' => $this->user->id,
					'type' => $type,
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
				));

				$data->messages['success'] = lang('files.success');
			}
		}

		$this->template->build('admin/files/edit', $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a file
	 *
	 * @params 	int The file id
	 */
	public function delete($id = '')
	{
		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of ids to delete
		if ( ! empty($ids))
		{
			foreach ($ids as $id)
			{
				if ($this->file_m->exists($id))
				{
					$this->file_m->delete($id);
				}
			}
			$this->session->set_flashdata('success', lang('files.delete.success'));
		}
		else
		{
			show_error(lang('files.not_exists'));
		}

		redirect('admin/files');
	}

	/**
	 * Helper method to determine what to do with selected items from form post
	 * @access public
	 * @return void
	 */
	public function action()
	{
		switch($this->input->post('btnAction'))
		{
			case 'delete':
				$this->delete();
			break;
			default:
				redirect('admin/files');
			break;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Validate our upload directory.
	 */
	private function _check_dir()
	{
		if (is_dir($this->_path) && is_really_writable($this->_path))
		{
			return TRUE;
		}
		elseif (!is_dir($this->_path))
		{
			if (!@mkdir($this->_path))
			{
				$this->session->set_flashdata('notice', lang('files.folders.mkdir'));
				return FALSE;
			}
		}
		else
		{
			if (!chmod($this->_path, 0777))
			{
				$this->session->set_flashdata('notice', lang('files.folders.chmod'));
				return FALSE;
			}
		}
	}

}

/* End of file admin.php */
/* Location: ./system/pyrocms/modules/files/controllers/admin.php */