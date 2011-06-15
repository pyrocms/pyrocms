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
 * PyroCMS Files Admin Controller
 *
 * Provides an admin for the files module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		Eric Barnes <eric@pyrocms.com>
 * @package		PyroCMS
 * @subpackage	Files
 */
class Admin_folders extends Admin_Controller {

	/**
	 * Formatted array of all folders.
	 */
	private $_folders = array();
	private $_validation_rules = array(
		array(
			'field'	=> 'name',
			'label'	=> 'lang:file_folders.name_label',
			'rules'	=> 'required'
		),
		array(
			'field'	=> 'slug',
			'label'	=> 'lang:file_folders.slug_label',
			'rules'	=> 'required'
		),
		array(
			'field'	=> 'parent_id',
			'label'	=> 'lang:file_folders.parent_label',
			'rules'	=> 'required'
		)
	);

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::Admin_Controller();

		$this->load->models(array('file_m', 'file_folders_m'));
		$this->lang->load('files');
		$this->config->load('files');

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->_validation_rules);

		$this->_folders = $this->file_folders_m->get_folders();

		// Array for select
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
	}

	// ------------------------------------------------------------------------

	public function index()
	{
		$this->load->library('table');

		$data->file_folders = $this->_folders;

		if ($this->input->is_ajax_request())
		{
			$content	= $this->load->view('admin/folders/index', $data, TRUE);
			$navigation	= $this->load->view('admin/partials/nav', array(
				'file_folders'	=> $this->_folders,
				'current_id'	=> 0
			), TRUE);

			return $this->template->build_json(array(
				'status'	=> 'success',
				'content'	=> $content,
				'navigation'=> $navigation,
			));
		}

		$this->template
			->title($this->module_details['name'], lang('file_folders.manage_title'))
			->build('admin/folders/index', $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Show the folders contents
	 */
	public function contents($id = 0, $filter = '')
	{
		if ($id)
		{
			$folder = $this->file_folders_m->get($id);
		}
		elseif ($path = $this->input->get('path'))
		{
			$folder = $this->file_folders_m->get_by_path($path);
			$filter = $this->input->get('filter');
		}

		if ( ! (isset($folder) && $folder))
		{
			if ($this->input->is_ajax_request())
			{
				$status		= 'error';
				$message	= lang('file_folders.not_exists');

				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message
				));
			}

			show_error(lang('file_folders.not_exists'));
			return;
		}
		elseif ( ! isset($folder->root_id))
		{
			$folder->root_id		= $this->_folders[$folder->id]->root_id;
			$folder->virtual_path	= $this->_folders[$folder->id]->virtual_path;
		}

		$this->load->library('table');

		// Make a breadcrumb trail
		$this->data->crumbs = $this->file_folders_m->breadcrumb($folder->id);

		// Get a list of all child folders
		$sub_folders = $this->file_folders_m->folder_tree($folder->root_id);

		// Array for select
		$this->data->sub_folders = array();
		foreach ($sub_folders as $sub_folder)
		{
			$this->data->sub_folders[$sub_folder->virtual_path] = repeater('&raquo; ', $sub_folder->depth) . $sub_folder->name;
		}

		$root_folder = $this->_folders[$folder->root_id];

		// Set a default label
		$this->data->sub_folders = $this->data->sub_folders
			? array($root_folder->virtual_path => lang('files.dropdown_root')) + $this->data->sub_folders
			: array($root_folder->virtual_path => lang('files.dropdown_no_subfolders'));

		// Get the selected information.
		$this->data->folder				= $folder;
		$this->data->selected_filter	= $filter;

		// Avaliable type filters
		$this->data->types = array();

		$this->db
			->select('type as letter')
			->group_by('type');

		$types = $this->file_m->get_many_by('folder_id', $folder->id);

		foreach ($types as $type)
		{
			$this->data->types[$type->letter] = lang('files.type_' . $type->letter);
		}

		asort($this->data->types);

		// Get all files
		in_array($filter, array('a', 'v', 'd', 'i', 'o')) && $this->db->where('type', $filter);

		$this->data->files = $this->file_m
			->order_by('date_added', 'DESC')
			->get_many_by('folder_id', $folder->id);

		// Response ajax
		if ($this->input->is_ajax_request())
		{
			$content	= $this->load->view('admin/folders/contents', $this->data, TRUE);
			$navigation	= $this->load->view('admin/partials/nav', array(
				'file_folders'	=> $this->_folders,
				'current_id'	=> $folder->root_id
			), TRUE);

			return $this->template->build_json(array(
				'status'	=> 'success',
				'content'	=> $content,
				'navigation'=> $navigation,
			));
		}

		$this->template
			->title($this->module_details['name'], $folder->name)
			->append_metadata( css('files.css', 'files') )
			->build('admin/folders/contents', $this->data);
	}

	// ------------------------------------------------------------------------

	public function create()
	{
		if ($this->form_validation->run())
		{
			$name = $this->input->post('name');
			
			if ( count($this->file_folders_m->get_by('name', $name)) > 0)
			{
				$message	= sprintf(lang('file_folders.duplicate_error'), $name);
				$status		= 'error';				
			}
			else
			{
				if ($this->file_folders_m->insert(array(
					'name'			=> $name,
					'slug'			=> $this->input->post('slug'),
					'parent_id'		=> $this->input->post('parent_id'),
					'date_added'	=> now()
				)))
				{
					$message	= sprintf(lang('file_folders.create_success'), $name);
					$status		= 'success';
				}
				else
				{
					$message	= sprintf(lang('file_folders.create_error'), $name);
					$status		= 'error';
				}
			}

			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return print ( json_encode((object) array(
					'status'	=> $status,
					'message'	=> $message
				)) );
			}

			// Redirect
			$this->session->set_flashdata($status, $message);
			redirect('admin/files/folders' . ($status === 'error' OR $this->input->post('btnAction') !== 'save_exit' ? '/edit': ''));
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

		foreach ($this->_validation_rules as $rules)
		{
			$folder->{$rules['field']} = set_value($rules['field']);
		}

		$this->data->folder = $folder;

		$this->input->is_ajax_request() && $this->template->set_layout(FALSE);

		$this->template
			->title($this->module_details['name'], lang('file_folders.create_title'))
			->build('admin/folders/form', $this->data);
	}

	// ------------------------------------------------------------------------

	public function edit($id = 0)
	{
		$folder = $this->file_folders_m->get($id);
		if ( ! $folder)
		{
			if ($this->input->is_ajax_request())
			{
				$status		= 'error';
				$message	= lang('file_folders.not_exists');

				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message
				));
			}

			redirect('files/folders');
		}

		if ($this->form_validation->run())
		{
			$name = $this->input->post('name');

			if ($this->file_folders_m->update($id, array(
				'name'			=> $name,
				'slug'			=> $this->input->post('slug'),
				'parent_id'		=> $this->input->post('parent_id')
			)))
			{
				$message	= sprintf(lang('file_folders.create_success'), $name);
				$status		= 'success';
			}
			else
			{
				$message	= sprintf(lang('files.folders.error'), $name);
				$status		= 'error';
			}

			// If request is ajax return json data, otherwise do normal stuff
			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return print ( json_encode((object) array(
					'status'	=> $status,
					'message'	=> $message,
					'title'		=> sprintf(lang('file_folders.edit_title'), $name)
				)) );
			}

			// Redirect
			$this->session->set_flashdata($status, $message);
			redirect('admin/files/folders' . ($status === 'error' ? '/edit': ''));
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

		foreach ($this->_validation_rules as $rules)
		{
			$this->input->post($rules['field']) && $folder->{$rules['field']} = set_value($rules['field']);
		}

		$this->data->folder = $folder;

		$this->input->is_ajax_request() && $this->template->set_layout(FALSE);

		$this->template
			->title($this->module_details['name'], sprintf(lang('file_folders.edit_title'), $folder->name))
			->build('admin/folders/form', $this->data);
	}

	// ------------------------------------------------------------------------

	public function delete($id = 0)
	{
		$ids = $id
			? is_array($id)
				? $id
				: array($id)
			: (array) $this->input->post('action_to');

		// Do deletion
		if ($this->input->post('confirm_delete') === 'yes')
		{
			$total		= sizeof($ids);
			$deleted	= array();

			// Try do deletion
			foreach ($ids as $id)
			{
				// Get the row to use a value.. as title, name
				if ($folder = $this->file_folders_m->get($id))
				{
					// Make deletion retrieving an status and store an value to display in the messages
					$deleted[($this->file_folders_m->delete($id) ? 'success': 'error')][] = $folder->name;
				}
			}

			// Set status messages
			foreach ($deleted as $status => &$values)
			{
				// Mass deletion
				if (($status_total = sizeof($values)) > 1)
				{
					$last_value		= array_pop($values);
					$first_values	= implode(', ', $values);

					// Success / Error message
					$values = sprintf(lang('file_folders.delete_mass_' . $status), $status_total, $total, $first_values, $last_value);
				}

				// Single deletion
				else
				{
					// Success / Error messages
					$values = sprintf(lang('file_folders.delete_' . $status), $values[0]);
				}
			}

			// He arrived here but it was not done nothing, certainly valid ids not were selected
			if ( ! $deleted)
			{
				$status		= 'error';
				$deleted	= array('error' => lang('file_folders.no_select_error'));
			}
			else
			{
				$status = array_key_exists('error', $deleted) ? 'error': 'success';
			}

			if ($this->input->is_ajax_request())
			{
				$data = array();
				$data['messages'] = $deleted;
				$message = $this->load->view('admin/partials/notices', $data, TRUE);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
				));
			}

			foreach ($deleted as $status => $message)
			{
				$this->session->set_flashdata($status, $message);
			}

			redirect('admin/files');
		}

		$data->file_folders = array();
		foreach ($ids as $id)
		{
			isset($this->_folders[$id]) && $data->file_folders[$id] = $this->_folders[$id];
		}

		if ($this->input->is_ajax_request())
		{
			$this->template->set_layout(FALSE);

			if ( ! empty($data->file_folders))
			{
				$status	= 'success';
				$html	= $this->load->view('admin/folders/confirm', $data, TRUE);
			}
			else
			{
				$status	= 'error';
				$html	= lang('file_folders.no_select_error');

				$data = array();
				$data['messages'][$status] = $html;
				$html = $this->load->view('admin/partials/notices', $data, TRUE);
			}

			return $this->template->build_json(array(
				'status'	=> $status,
				'html'		=> $html
			));
		}

		$this->template
			->title($this->module_details['name'], lang('file_folders.delete_title'))
			->build('admin/folders/confirm', $data);
	}

	// ------------------------------------------------------------------------


	public function upload()
	{
		$this->template
			->title($this->module['name'],lang('files.upload_title'))
			->build('admin/upload', $this->data);
	}

	// ------------------------------------------------------------------------

	public function action()
	{
		$action = strtolower($this->input->post('btnAction'));
		
		if ($action)
		{
			// Get the id('s)
			$id_array = $this->input->post('action_to');

			// Call the action we want to do
			if (method_exists($this, $action))
			{
				return $this->{$action}($id_array);
			}
		}

		redirect('admin/files');
	}

	public function html_dropdown($id = 0)
	{
		$this->data->folder = $id && isset($this->_folders[$id]) ? $this->_folders[$id] : array();

		return $this->load->view('admin/folders/html_dropdown', $this->data);
	}
}
