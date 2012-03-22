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
 */

/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS
 * @subpackage	Modules
 * @category	Files
 */
class Admin extends Admin_Controller {

	protected $_folders				= array();
	protected $_upload_path 		= '';
	protected $_upload_config		= array();
	protected $_validation_rules	= array(
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
		parent::__construct();

		$this->config->load('files');
		$this->lang->load('files');
		$this->load->models(array(
			'file_m',
			'file_folders_m'
		));

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

		$this->_upload_path = FCPATH . $this->config->item('files_folder');
		$this->_check_dir();
	}

	// ------------------------------------------------------------------------

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
			->append_metadata( js('//ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js') )
			->append_metadata( js('jquery.iframe-transport.js', 'files') )
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
	public function upload()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$total	= 0;
			$field	= 'userfile';

			$userfile = isset($_FILES[$field]) ?
				$_FILES[$field] : array(
					'name'		=> NULL,
					'tmp_name'	=> NULL,
					'type'		=> NULL,
					'size'		=> NULL,
					'error'		=> NULL
				);

			if (is_array($userfile['name']))
			{
				foreach ($userfile['name'] as $i => $name)
				{
					$total = $i;

					foreach (array('name','tmp_name','type','size','error') as $key)
					{
						$_FILES[$field . $total][$key] = $userfile[$key][$i];
					}
				}
			}
			else
			{
				$_FILES[$field . $total] = $userfile;
			}

			$this->load->library('upload');
			$this->load->library('form_validation');

			$this->_build_validation_rules($field, $total);
			$this->form_validation->set_rules($this->_validation_rules);
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->run();

			$files	= array();
			$result	= $this->_get_validation_result();

			foreach ($result as $field => $data)
			{
				$file = array(
					'name' => isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : $_FILES[$field]['name'],
					'size' => isset($_SERVER['HTTP_X_FILE_SIZE']) ? $_SERVER['HTTP_X_FILE_SIZE'] : $_FILES[$field]['size'],
					'type' => isset($_SERVER['HTTP_X_FILE_TYPE']) ? $_SERVER['HTTP_X_FILE_TYPE'] : $_FILES[$field]['type']
				);

				if ($data !== TRUE)
				{
					if (is_array($data))
					{
						$files[] = array_merge($file, $data);
					}

					continue;
				}

				$files[] = array_merge($file, $this->_do_upload($field));
			}

			return $this->template->build_json($files);
		}

		// todo: load form view;
	}

	// ------------------------------------------------------------------------

	protected function _build_validation_rules($field = NULL, $total = 0)
	{
		// todo: leave each file choose your folder id
		$rules = array(array(
			'field' => 'folder_id',
			'label' => 'lang:file_folders.parent_label',
			'rules' => 'trim|is_numeric'
		));

		for ($i = 0; $i <= $total; $i++)
		{
			$field_prefix = $field . $i;

			$rules[] = array(
				'field' => $field_prefix,
				'label' => 'lang:files.file_label',
				'rules' => 'callback__check_ext['.$field_prefix.']',
				'file'	=> $field_prefix
			);

			$rules[] = array(
				'field' => $field_prefix . '_name',
				'label' => 'lang:files.name_label',
				'rules' => 'trim|required|max_length[250]',
				'file'	=> $field_prefix
			);

			$rules[] = array(
				'field' => $field_prefix . '_description',
				'label' => 'lang:files.description_label',
				'rules' => 'trim|max_length[250]',
				'file'	=> $field_prefix
			);

			$rules[] = array(
				'field' => $field_prefix . '_type',
				'label' => 'lang:files.type_label',
				'rules' => 'trim|max_length[1]',
				'file'	=> $field_prefix
			);
		}

		$this->_validation_rules = $rules;
	}

	// ------------------------------------------------------------------------

	protected function _get_validation_result()
	{
		$error	= NULL;
		$data	= array();
		$skip	= array();

		foreach ($this->_validation_rules as $rule)
		{
			if ( ! isset($rule['file']))
			{
				if (is_null($error) && form_error($rule['field']))
				{
					// general error
					$error = form_error($rule['field']);
				}

				continue;;			}

			if (in_array($rule['file'], $skip))
			{
				continue;
			}

			if ($error)
			{
				$data[$rule['file']] = array('error' => $error);
				$skip[] = $rule['file'];

				continue;
			}

			if (form_error($rule['field']))
			{
				$data[$rule['file']] = array('error' => form_error($rule['field']));
				$skip[] = $rule['file'];

				continue;
			}

			$data[$rule['file']] = TRUE;
		}

		return $data;
	}

	// ------------------------------------------------------------------------

	protected function _do_upload($field = 'userfile')
	{
		// Setup upload config
		$this->upload->initialize($this->_upload_config[$field]);

		if ($this->upload->do_upload($field))
		{
			$file = $this->upload->data();
			$f_id = $this->input->post($field . '_folder_id');
			$type = $this->input->post($field . '_type');
			$name = $this->input->post($field . '_name');
			$desc = $this->input->post($field . '_description');

			$file_id = $this->file_m->insert(array(
				'user_id'		=> $this->current_user->id,
				'folder_id'		=> $f_id,
				'type'			=> $type,
				'name'			=> $name,
				'description'	=> $desc ? $desc : '',
				'filename'		=> $file['file_name'],
				'extension'		=> $file['file_ext'],
				'mimetype'		=> $file['file_type'],
				'filesize'		=> $file['file_size'],
				'width'			=> (int) $file['image_width'],
				'height'		=> (int) $file['image_height'],
				'date_added'	=> now()
			));

			// Insert success
			if ($file_id)
			{
				$file += array(
					'url'			=> site_url('files/download/'. $file_id),
					'thumbnail_url'	=> $type === 'i' ? site_url('files/thumb/' . $file_id . '/80/50/fit') : '',
					'delete_url'	=> site_url('admin/files/delete/' . $file_id),
					'delete_type'	=> 'DELETE'
				);
			}
			// Insert error
			else
			{
				// @todo: unlink file

				$file += array(
					'error' => 'Database record error'
				);
			}

			return $file;
		}

		return array('error' => $this->upload->display_errors());
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

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		if ($this->form_validation->run())
		{
			// We are uploading a new file
			if ( ! empty($_FILES['userfile']['name']))
			{
				// Setup upload config
				$this->load->library('upload', array(
					'upload_path'	=> $this->_upload_path,
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
						'user_id'		=> (int) $this->current_user->id,
						'type'			=> $this->_type,
						'name'			=> $this->input->post('name'),
						'description'	=> $this->input->post('description'),
						'filename'		=> $file['file_name'],
						'extension'		=> $file['file_ext'],
						'mimetype'		=> $file['file_type'],
						'filesize'		=> $file['file_size'],
						'width'			=> (int) $file['image_width'],
						'height'		=> (int) $file['image_height'],
						'i_color'			=> $this->input->post('i_color')
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
					'user_id'		=> $this->current_user->id,
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description'),
					'i_color'			=> $this->input->post('i_color'),
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

		if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
		{
			return $this->template->build_json( isset($deleted['success']) ? 'true' : 'false' );
		}

		// Redirect
		isset($folder) ? redirect('admin/files/#!path=' . $folder->virtual_path) : redirect('admin/files');
	}

	// ------------------------------------------------------------------------

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
	protected function _check_dir()
	{
		if (is_dir($this->_upload_path) && is_really_writable($this->_upload_path))
		{
			return TRUE;
		}
		elseif ( ! is_dir($this->_upload_path))
		{
			if ( ! @mkdir($this->_upload_path, 0777, TRUE))
			{
				$this->data->messages['notice'] = lang('file_folders.mkdir_error');
				return FALSE;
			}
			else
			{
				// create a catch all html file for safety
				$uph = fopen($this->_upload_path . 'index.html', 'w');
				fclose($uph);
			}
		}
		else
		{
			if ( ! chmod($this->_upload_path, 0777))
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
	public function _check_ext($value, $index = '')
	{
		$name = $_FILES[$index]['name'];

		if (empty($name))
		{
			if ($this->method === 'upload')
			{
				$this->form_validation->set_message('_check_ext', lang('files.upload_error'));
				return FALSE;
			}
		}
		$ext		= pathinfo($name, PATHINFO_EXTENSION);
		$allowed	= $this->config->item('files_allowed_file_ext');

		foreach ($allowed as $type => $ext_arr)
		{
			if (in_array(strtolower($ext), $ext_arr))
			{
				$_POST[$index . '_folder_id']	= $this->input->post('folder_id');
				$_POST[$index . '_type']		= $type;

				$this->_upload_config[$index] = array(
					'allowed_types'	=> implode('|', $ext_arr),
					'file_name'		=> trim(url_title($name, 'dash', TRUE), '-'),
					'upload_path'	=> $this->_upload_path
				);

				break;
			}
		}

		if (empty($this->_upload_config[$index]))
		{
			$this->form_validation->set_message('_check_ext', lang('files.invalid_extension'));

			return FALSE;
		}

		return TRUE;
	}
}

/* End of file admin.php */