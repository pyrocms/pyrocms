<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Controllers
 */
class Admin extends Admin_Controller {

	private $_folders	= array();
	private $_type 		= null;
	private $_ext 		= null;
	private $_filename	= null;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->config->load('files');
		$this->lang->load('files');
		$this->load->library('files/files');

		$allowed_extensions = '';

		foreach (config_item('files:allowed_file_ext') as $type) 
		{
			$allowed_extensions .= implode('|', $type).'|';
		}

		$this->template->append_metadata(
			"<script>
				pyro.lang.fetching = '".lang('files:fetching')."';
				pyro.lang.fetch_completed = '".lang('files:fetch_completed')."';
				pyro.lang.start = '".lang('files:start')."';
				pyro.lang.width = '".lang('files:width')."';
				pyro.lang.height = '".lang('files:height')."';
				pyro.lang.ratio = '".lang('files:ratio')."';
				pyro.lang.full_size = '".lang('files:full_size')."';
				pyro.lang.cancel = '".lang('buttons.cancel')."';
				pyro.lang.synchronization_started = '".lang('files:synchronization_started')."';
				pyro.lang.untitled_folder = '".lang('files:untitled_folder')."';
				pyro.lang.exceeds_server_setting = '".lang('files:exceeds_server_setting')."';
				pyro.lang.exceeds_allowed = '".lang('files:exceeds_allowed')."';
				pyro.files = { permissions : ".json_encode(Files::allowed_actions())." };
				pyro.files.max_size_possible = '".Files::$max_size_possible."';
				pyro.files.max_size_allowed = '".Files::$max_size_allowed."';
				pyro.files.valid_extensions = '/".trim($allowed_extensions, '|')."$/i';
				pyro.lang.file_type_not_allowed = '".lang('files:file_type_not_allowed')."';
				pyro.lang.new_folder_name = '".lang('files:new_folder_name')."';
			</script>");
	}

	/**
	 * Folder Listing
	 */
	public function index()
	{
		$parts = explode(',', Settings::get('files_enabled_providers'));

		$this->template

			// The title
			->title($this->module_details['name'])

			// The CSS files
			->append_css('module::jquery.fileupload-ui.css')
			->append_css('module::files.css')

			// The Javascript files
			->append_js('module::jquery.fileupload.js')
			->append_js('module::jquery.fileupload-ui.js')
			->append_js('module::functions.js')

			// should we show the "no data" message to them?
			->set('folders', $this->file_folders_m->count_by('parent_id', 0))
			->set('locations', array_combine($parts, $parts))
			->set('folder_tree', Files::folder_tree());

		$files_path = Files::$path;
		if (!is_really_writable($files_path))
		{
			$this->template->set('messages', array('error' => sprintf(lang('files:unwritable'), $files_path)));
		}

		$this->template->build('admin/index');
	}

	/**
	 * Create a new folder
	 *
	 * Grabs the parent id and the name of the folder from POST data.
	 */
	public function new_folder()
	{
		// This is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('create_folder', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		$parent_id = $this->input->post('parent');
		$name = $this->input->post('name');

		echo json_encode(Files::create_folder($parent_id, $name));
	}

	/**
	 * Get all files and folders within a folder
	 *
	 * Grabs the parent id from the POST data.
	 */
	public function folder_contents()
	{
		$parent = $this->input->post('parent');

		echo json_encode(Files::folder_contents($parent));
	}

	/**
	 * See if a container exists with that name.
	 *
	 * This is different than folder_exists() as this checks for unindexed containers.
	 * Grabs the name of the container and the location from the POST data.
	 */
	public function check_container()
	{
		$name = $this->input->post('name');
		$location = $this->input->post('location');

		echo json_encode(Files::check_container($name, $location));
	}

	/**
	 * Set the order of files and folders
	 */
	public function order()
	{

		if ($collection = $this->input->post('order'))
		{
			foreach ($collection as $type => $item)
			{
				$i = 0;

				foreach ($item as $id) 
				{
					$model = ($type == 'folder') ? 'file_folders_m' : 'file_m';

					$this->{$model}->update_by('id', $id, array('sort' => $i));
					$i++;
				}
			}

			// let the files library format the return array like all the others
			echo json_encode(Files::result(TRUE, lang('files:sort_saved')));
		}
		else 
		{
			echo json_encode(Files::result(FALSE, lang('files:save_failed')));
		}
	}

	/**
	 * Rename a folder
	 */
	public function rename_folder()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('edit_folder', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		if ($id = $this->input->post('folder_id') AND $name = $this->input->post('name'))
		{
			echo json_encode(Files::rename_folder($id, $name));
		}
	}

	/**
	 * Delete an empty folder
	 */
	public function delete_folder()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('delete_folder', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		if ($id = $this->input->post('folder_id'))
		{
			echo json_encode(Files::delete_folder($id));
		}
	}

	/**
	 * Upload files
	 */
	public function upload()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('upload', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		$input = $this->input->post();

		if ($input['folder_id'] AND $input['name'])
		{
			echo json_encode(Files::upload($input['folder_id'], $input['name'], 'file', $input['width'], $input['height'], $input['ratio']));
		}
	}

	/**
	 * Rename a file
	 */
	public function rename_file()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('edit_file', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		if ($id = $this->input->post('file_id') AND $name = $this->input->post('name'))
		{
			echo json_encode(Files::move($id, $name));
		}
	}

	/**
	 * Edit description of a file
	 */
	public function save_description()
	{
		if ($id = $this->input->post('file_id') AND $description = $this->input->post('description'))
		{
			$this->file_m->update($id, array('description' => $description));

			echo json_encode(Files::result(TRUE, lang('files:description_saved')));
		}
	}

	/**
	 * Edit location of a folder (S3/Cloud Files/Local)
	 */
	public function save_location()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('set_location', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		if ($id = $this->input->post('folder_id') AND $location = $this->input->post('location') AND $container = $this->input->post('container'))
		{
			$this->file_folders_m->update($id, array('location' => $location));

			echo json_encode(Files::create_container($container, $location, $id));
		}
	}

	/**
	 * Pull new files down from the cloud location
	 */
	public function synchronize()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('synchronize', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		if ($id = $this->input->post('folder_id'))
		{
			echo json_encode(Files::synchronize($id));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a file
	 *
	 * @access	public
	 * @return	void
	 */
	public function delete_file()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('delete_file', Files::allowed_actions()))
		{
			show_error(lang('files:no_permissions'));
		}

		if ($id = $this->input->post('file_id'))
		{
			echo json_encode(Files::delete_file($id));
		}
	}

	/**
	 * Search for files and folders
	 */
	public function search()
	{
		echo json_encode(Files::search($this->input->post('search')));
	}

}