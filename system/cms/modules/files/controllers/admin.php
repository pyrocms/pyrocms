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
 * @author		Marcos Coelho <marcos@marcoscoelho.com>
 * @package		PyroCMS
 * @subpackage	file
 */
class Admin extends Admin_Controller {

	private $_folders	= array();
	private $_path 		= '';
	private $_type 		= NULL;
	private $_ext 		= NULL;
	private $_filename	= NULL;
	private $_validation_rules = array(
		array(
			'field' => 'userfile',
			'label' => 'lang:files.file_label',
			'rules' => 'callback__check_ext'
		),
		array(
			'field' => 'name',
			'label' => 'lang:files.name_label',
			'rules' => 'trim|required|max_length[250]'
		),
		array(
			'field' => 'description',
			'label' => 'lang:files.description_label',
			'rules' => 'trim|max_length[250]'
		),
		array(
			'field' => 'type',
			'label' => 'lang:files.type_label',
			'rules' => 'trim|max_length[1]'
		),
		array(
			'field' => 'folder_id',
			'label' => 'lang:file_folders.parent_label',
			'rules' => 'trim|is_numeric'
		)
	);

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

		$this->config->load('files');
		$this->lang->load('files');
		$this->load->models(array(
			'file_m',
			'file_folders_m'
		));

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		$this->_folders = $this->file_folders_m->get_folders();

		// Get the parent -> childs
		$this->data->folders_tree = array();
		foreach ($this->_folders as $folder)
		{
			$this->data->folders_tree[$folder->id] = repeater('&raquo; ', $folder->depth) . $folder->name;
		}

		$this->template
			->set_partial('shortcuts', 'admin/partials/shortcuts')
			->set_partial('nav', 'admin/partials/nav', array(
				'file_folders'	=> $this->_folders,
				'current_id'	=> 0
			));

		$this->_path = FCPATH . $this->config->item('files_folder');
		$this->_check_dir();
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
		$this->data->file_folders	= $this->_folders;
		$this->data->content		= $this->load->view('admin/folders/index', $this->data, TRUE);

		$this->template
			->title($this->module_details['name'])
			->append_metadata( css('jquery.fileupload-ui.css', 'files') )
			->append_metadata( css('files.css', 'files') )
			->append_metadata( js('jquery/jquery.cooki.js') )
			->append_metadata( js('jquery.fileupload.js', 'files') )
			->append_metadata( js('jquery.fileupload-ui.js', 'files') )
			->append_metadata( js('jquery.ba-hashchange.min.js', 'files') )
			->append_metadata( js('functions.js', 'files') )
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
	public function upload($folder_id = '')
	{
		$this->data->folders = $this->_folders;
				
		if ($this->form_validation->run())
		{
			// Setup upload config
			$this->load->library('upload', array(
				'upload_path'	=> $this->_path,
				'allowed_types'	=> $this->_ext,
				'file_name'		=> $this->_filename
			));

			// File upload error
			if ( ! $this->upload->do_upload('userfile'))
			{
				$status		= 'error';
				$message	= $this->upload->display_errors();

				if ($this->input->is_ajax_request())
				{
					$data = array();
					$data['messages'][$status] = $message;
					$message = $this->load->view('admin/partials/notices', $data, TRUE);

					return $this->template->build_json(array(
						'status'	=> $status,
						'message'	=> $message
					));
				}

				$this->data->messages[$status] = $message;
			}

			// File upload success
			else
			{
				$file = $this->upload->data();
				$data = array(
					'folder_id'		=> (int) $this->input->post('folder_id'),
					'user_id'		=> (int) $this->user->id,
					'type'			=> $this->_type,
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description') ? $this->input->post('description') : '',
					'filename'		=> $file['file_name'],
					'extension'		=> $file['file_ext'],
					'mimetype'		=> $file['file_type'],
					'filesize'		=> $file['file_size'],
					'width'			=> (int) $file['image_width'],
					'height'		=> (int) $file['image_height'],
					'date_added'	=> now()
				);

				// Insert success
				if ($id = $this->file_m->insert($data))
				{
					$status		= 'success';
					$message	= lang('files.create_success');
				}
				// Insert error
				else
				{
					$status		= 'error';
					$message	= lang('files.create_error');
				}

				if ($this->input->is_ajax_request())
				{
					$data = array();
					$data['messages'][$status] = $message;
					$message = $this->load->view('admin/partials/notices', $data, TRUE);

					return $this->template->build_json(array(
						'status'	=> $status,
						'message'	=> $message,
						'file'		=> array(
							'name'	=> $file['file_name'],
							'type'	=> $file['file_type'],
							'size'	=> $file['file_size'],
							'thumb'	=> base_url() . 'files/thumb/' . $id . '/80'
						)
					));
				}

				if ($status === 'success')
				{
					$this->session->set_flashdata($status, $message);
					redirect('admin/files');
				}
			}
		}
		elseif (validation_errors())
		{
			// if request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$message = $this->load->view('admin/partials/notices', array(), TRUE);

				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message
				));
			}
		}

		if ($this->input->is_ajax_request())
		{
			// todo: debug errors here
			$status		= 'error';
			$message	= 'unknown';

			$data = array();
			$data['messages'][$status] = $message;
			$message = $this->load->view('admin/partials/notices', $data, TRUE);

			return $this->template->build_json(array(
				'status'	=> $status,
				'message'	=> $message
			));
		}

		// Loop through each validation rule
		foreach ($this->_validation_rules as $rule)
		{
			if ($rule['field'] == 'folder_id') 
			{
				$this->data->file->{$rule['field']} = set_value($rule['field'], $folder_id);
			}
			else
			{
				$this->data->file->{$rule['field']} = set_value($rule['field']);
			}
			
		}

		$this->template
			->title()
			->build('admin/files/upload', $this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit Uploaded file
	 *
	 */
	public function edit($id = '')
	{
		if ( ! ($id && ($file = $this->file_m->get($id))))
		{
			$status		= 'error';
			$message	= lang('files.file_label_not_found');

			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message
				));
			}

			$this->session->set_flashdata($status, $message);
			redirect('admin/files');
		}

		$this->data->file =& $file;

		if ($this->form_validation->run())
		{
			// We are uploading a new file
			if ( ! empty($_FILES['userfile']['name']))
			{
				// Setup upload config
				$this->load->library('upload', array(
					'upload_path'	=> $this->_path,
					'allowed_types'	=> $this->_ext
				));

				// File upload error
				if ( ! $this->upload->do_upload('userfile'))
				{
					$status		= 'error';
					$message	= $this->upload->display_errors();

					if ($this->input->is_ajax_request())
					{
						$data = array();
						$data['messages'][$status] = $message;
						$message = $this->load->view('admin/partials/notices', $data, TRUE);

						return $this->template->build_json(array(
							'status'	=> $status,
							'message'	=> $message
						));
					}

					$this->data->messages[$status] = $message;
				}
				// File upload success
				else
				{
					// Remove the original file
					$this->file_m->delete_file($id);

					$file = $this->upload->data();
					$data = array(
						'folder_id'		=> (int) $this->input->post('folder_id'),
						'user_id'		=> (int) $this->user->id,
						'type'			=> $this->_type,
						'name'			=> $this->input->post('name'),
						'description'	=> $this->input->post('description'),
						'filename'		=> $file['file_name'],
						'extension'		=> $file['file_ext'],
						'mimetype'		=> $file['file_type'],
						'filesize'		=> $file['file_size'],
						'width'			=> (int) $file['image_width'],
						'height'		=> (int) $file['image_height'],
					);

					if ($this->file_m->update($id, $data))
					{
						$status		= 'success';
						$message	= lang('files.edit_success');
					}
					else
					{
						$status		= 'error';
						$message	= lang('files.edit_error');
					};

					if ($this->input->is_ajax_request())
					{
						$data = array();
						$data['messages'][$status] = $message;
						$message = $this->load->view('admin/partials/notices', $data, TRUE);

						return $this->template->build_json(array(
							'status'	=> $status,
							'message'	=> $message,
							'title'		=> $status === 'success' ? sprintf(lang('files.edit_title'), $this->input->post('name')) : $file->name
						));
					}

					if ($status === 'success')
					{
						$this->session->set_flashdata($status, $message);
						redirect ('admin/files');
					}
				}
			}

			// Upload data
			else
			{
				$data = array(
					'folder_id'		=> $this->input->post('folder_id'),
					'user_id'		=> $this->user->id,
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description')
				);

				if ($this->file_m->update($id, $data))
				{
					$status		= 'success';
					$message	= lang('files.edit_success');
				}
				else
				{
					$status		= 'error';
					$message	= lang('files.edit_error');
				};

				if ($this->input->is_ajax_request())
				{
					$data = array();
					$data['messages'][$status] = $message;
					$message = $this->load->view('admin/partials/notices', $data, TRUE);

					return $this->template->build_json(array(
						'status'	=> $status,
						'message'	=> $message,
						'title'		=> $status === 'success' ? sprintf(lang('files.edit_title'), $this->input->post('name')) : $file->name
					));
				}

				if ($status === 'success')
				{
					$this->session->set_flashdata($status, $message);
					redirect ('admin/files');
				}
			}
		}
		elseif (validation_errors())
		{
			// if request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$message = $this->load->view('admin/partials/notices', array(), TRUE);

				return $this->template->build_json(array(
					'status'	=> 'error',
					'message'	=> $message
				));
			}
		}

		$this->input->is_ajax_request() && $this->template->set_layout(FALSE);

		$this->template
			->title('')
			->build('admin/files/edit', $this->data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a file
	 *
	 * @params 	int The file id
	 */
	public function delete($id = 0)
	{
		$ids = $id
			? is_array($id)
				? $id
				: array($id)
			: (array) $this->input->post('action_to');

		$total		= sizeof($ids);
		$deleted	= array();

		// Try do deletion
		foreach ($ids as $id)
		{
			// Get the row to use a value.. as title, name
			if ($file = $this->file_m->get($id))
			{
				// Make deletion retrieving an status and store an value to display in the messages
				$deleted[($this->file_m->delete($id) ? 'success': 'error')][] = $file->filename;

				$folder	= $this->_folders[$file->folder_id];
			}
		}

		// Set status messages
		foreach ($deleted as $status => $values)
		{
			// Mass deletion
			if (($status_total = sizeof($values)) > 1)
			{
				$last_value		= array_pop($values);
				$first_values	= implode(', ', $values);

				// Success / Error message
				$this->session->set_flashdata($status, sprintf(lang('files.mass_delete_' . $status), $status_total, $total, $first_values, $last_value));
			}

			// Single deletion
			else
			{
				// Success / Error messages
				$this->session->set_flashdata($status, sprintf(lang('files.delete_' . $status), $values[0]));
			}
		}

		// He arrived here but it was not done nothing, certainly valid ids not were selected
		if ( ! $deleted)
		{
			$this->session->set_flashdata('error', lang('files.no_select_error'));
		}

		// Redirect
		isset($folder) ? redirect('admin/files/#!path=' . $folder->virtual_path) : redirect('admin/files');
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
		elseif ( ! is_dir($this->_path))
		{
			if ( ! @mkdir($this->_path, 0777, TRUE))
			{
				$this->data->messages['notice'] = lang('file_folders.mkdir_error');
				return FALSE;
			}
			else
			{
				// create a catch all html file for safety
				$uph = fopen($this->_path . 'index.html', 'w');
				fclose($uph);
			}
		}
		else
		{
			if ( ! chmod($this->_path, 0777))
			{
				$this->session->messages['notice'] = lang('file_folders.chmod_error');
				return FALSE;
			}
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Validate upload file name and extension and remove special characters.
	 */
	function _check_ext()
	{
		if ( ! empty($_FILES['userfile']['name']))
		{
			$ext		= pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$allowed	= $this->config->item('files_allowed_file_ext');

			foreach ($allowed as $type => $ext_arr)
			{				
				if (in_array(strtolower($ext), $ext_arr))
				{
					$this->_type		= $type;
					$this->_ext			= implode('|', $ext_arr);
					$this->_filename	= trim(url_title($_FILES['userfile']['name'], 'dash', TRUE), '-');

					break;
				}
			}

			if ( ! $this->_ext)
			{
				$this->form_validation->set_message('_check_ext', lang('files.invalid_extension'));
				return FALSE;
			}
		}		
		elseif ($this->method === 'upload')
		{
			$this->form_validation->set_message('_check_ext', lang('files.upload_error'));
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file admin.php */
/* Location: ./system/cms/modules/files/controllers/admin.php */
