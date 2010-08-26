<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
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

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts', FALSE);
		$this->template->set_partial('nav', 'admin/partials/nav', FALSE);

		$this->_path = FCPATH.'/'.$this->config->item('files_folder').'/';
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
		$file_folders = $this->file_folders_m->get_many_by(array('parent_id' => '0'));

		$this->data->file_folders = &$file_folders;

		$this->data->error = $this->_check_dir();

		$this->template
			->title($this->module_data['name'])
			->build('admin/layouts/index', $this->data);
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
		$this->template->set_layout('admin/modal');
		$this->config->load('files');

		$this->file_folders_m->folder_tree();
		$folder->parents = $this->file_folders_m->get_folders();
		// types = a','v','d','i','o'
		$this->data->name = '';
		$this->data->description = '';
		$this->data->type = '';
		$this->data->selected_id = $id;
		$this->data->types = array('a' => 'Audio', 'v' => 'Video', 'd' => 'Document', 'i' => 'Image', 'o' => 'Other');
		$this->data->folder =& $folder;


		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'lang:files.folders.name', 'required');
		$this->form_validation->set_rules('description', 'lang:files.description', '');
		$this->form_validation->set_rules('folder_id', 'lang:files.labels.parent', 'required');
		$this->form_validation->set_rules('type', 'lang:files.type', 'required');
		// $this->form_validation->set_rules('userfile', 'lang:files.file', 'required');

		if ($this->form_validation->run())
		{
			// Setup upload config
			$type = $this->input->post('type');
			$allowed = $this->config->item('files_allowed_file_ext');

			$config['upload_path'] = $this->_path;
			$config['allowed_types'] = $allowed[$type];

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('userfile'))
			{
				$this->data->messages['notice'] = $this->upload->display_errors();
			}
			else
			{
				$img = array('upload_data' => $this->upload->data());

				$data = array(
					'folder_id' 	=> $this->input->post('folder_id'),
					'user_id' 		=> $this->user->id,
					'type'			=> $type,
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description'),
					'filename'		=> $img['upload_data']['file_name'],
					'extension'		=> $img['upload_data']['file_ext'],
					'mimetype'		=> $img['upload_data']['file_type'],
					'filesize'		=> $img['upload_data']['file_size'],
					'width'			=> $img['upload_data']['image_width'],
					'height'		=> $img['upload_data']['image_height'],
					'date_added'	=> time(),
				);
				$this->file_m->insert($data);
				$this->data->messages['success'] = lang('files.success');
				#redirect('admin/files');
			}
		}

		$this->template->build('admin/files/upload', $this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit Upload file
	 *
	 */
	public function edit($id = '')
	{
		if ($id == '')
		{
			redirect('admin/files/upload');
		}
		$this->template->set_layout('admin/modal');
		$this->data->error = '';
		$this->template->build('admin/files/edit', $this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a file
	 *
	 * @params 	int The file id
	 */
	public function delete($id = '')
	{
		if ( ! $this->file_m->exists($id))
		{
			show_error(lang('files.not_exists'));
		}

		if ( ! $this->file_m->delete($id))
		{
			$this->session->set_flashdata('error', lang('files.delete.error'));
			redirect('admin/files');
		}
		else
		{
			$this->session->set_flashdata('success', lang('files.delete.success'));
			redirect('admin/files');
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
		elseif ( ! is_dir($this->_path))
		{
			if ( ! @mkdir($this->_path))
			{
				$this->session->set_flashdata('notice', lang('files.folders.mkdir'));
				return FALSE;
			}
		}
		else
		{
			if ( ! chmod($this->_path, 0777))
			{
				$this->session->set_flashdata('notice', lang('files.folders.chmod'));
				return FALSE;
			}
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * This is from dan and I left it in.
	 *
	 */
	private function _folder_dropdown_array($folders)
	{
		static $depth = 0;
		$return = array();

		foreach($folders as $id => $folder)
		{
			// Skip the 'name' of a sub-folder
			if($id == 'name')
			{
				continue;
			}
			if(is_array($folder))
			{
				$return[$id] = str_repeat('&nbsp;&nbsp;', $depth) . $folder['name'];
				$depth++;
				$return = $return + $this->_folder_dropdown_array($folder);
				$depth--;
			}
			else
			{
				$return[$id] = str_repeat('&nbsp;&nbsp;', $depth) . $folder;
			}
		}

		return $return;
	}

}
/* End of file admin.php */
/* Location: ./system/pyrocms/modules/files/controllers/admin.php */