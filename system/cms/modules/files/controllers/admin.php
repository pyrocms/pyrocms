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
	private $_type 		= NULL;
	private $_ext 		= NULL;
	private $_filename	= NULL;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->config->load('files');
		$this->lang->load('files');
		$this->load->library('files/files');

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
				pyro.files = { permissions : ".json_encode(Files::allowed_actions())." };
			</script>");
	}

	// ------------------------------------------------------------------------

	/**
	 * Folder Listing
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		// should we show the "no data" message to them?
		$data->folders = $this->file_folders_m->count_by('parent_id', 0);

		$parts = explode(',', Settings::get('files_enabled_providers'));
		foreach ($parts as $location)
		{
			$data->locations[$location] = $location;
		}

		$data->folder_tree = Files::folder_tree();

		$data->admin =& $this;

		is_really_writable(Files::$path) OR $data->messages['error'] = sprintf(lang('files:unwritable'), Files::$path);

		$this->template
			->title($this->module_details['name'])
			
			->append_css('module::jquery.fileupload-ui.css')
			->append_css('module::files.css')
			->append_js('module::jquery.fileupload.js')
			->append_js('module::jquery.fileupload-ui.js')
			->append_js('module::functions.js')
		
			->build('admin/index', $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Folder Sidebar
	 *
	 * @access	public
	 * @return	void
	 */
	public function sidebar($folder)
	{
		if (isset($folder['children'])):

			foreach($folder['children'] as $folder): ?>

				<li class="folder"
					data-id="<?php echo $folder['id']?>" 
					data-name="<?php echo $folder['name']?>">
						<div></div><a href="#"><?php echo $folder['name']; ?></a>

				<?php if(isset($folder['children'])): ?>
						<ul style="display:none" >
								<?php $this->sidebar($folder); ?>
						</ul>
					</li>
				<?php else: ?>
					</li>
				<?php endif;
			endforeach;
		endif;
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a new folder
	 *
	 * @access	public
	 * @param	int		$parent	The parent folder's id
	 * @return	string
	 */
	public function new_folder()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('create_folder', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		$parent_id = $this->input->post('parent');
		$name = $this->input->post('name');

		echo json_encode(Files::create_folder($parent_id, $name));
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all files and folders within a folder
	 *
	 * @access	public
	 * @param	int		$parent	The folder id
	 * @return	string
	 */
	public function folder_contents()
	{
		$parent = $this->input->post('parent');

		echo json_encode(Files::folder_contents($parent));
	}

	// ------------------------------------------------------------------------

	/**
	 * See if a container exists with that name. This is different than
	 * folder_exists() as this checks for unindexed containers
	 *
	 * @access	public
	 * @param	int		$name 		The container/bucket name
	 * @param	string	$location	The cloud provider
	 * @return	string
	 */
	public function check_container()
	{
		$name = $this->input->post('name');
		$location = $this->input->post('location');

		echo json_encode(Files::check_container($name, $location));
	}

	// ------------------------------------------------------------------------

	/**
	 * Set the order of files and folders
	 *
	 * @access	public
	 * @return	void
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
					$model = $type == 'folder' ? 'file_folders_m' : 'file_m';

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

	// ------------------------------------------------------------------------

	/**
	 * Rename a folder
	 *
	 * @access	public
	 * @return	void
	 */
	public function rename_folder()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('edit_folder', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		if ($id = $this->input->post('folder_id') AND $name = $this->input->post('name'))
		{
			echo json_encode(Files::rename_folder($id, $name));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete an empty folder
	 *
	 * @access	public
	 * @return	void
	 */
	public function delete_folder()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('delete_folder', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		if ($id = $this->input->post('folder_id'))
		{
			echo json_encode(Files::delete_folder($id));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Upload files
	 *
	 * @access	public
	 * @return	void
	 */
	public function upload()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('upload', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		$input = $this->input->post();

		if ($input['folder_id'] AND $input['name'])
		{
			echo json_encode(Files::upload($input['folder_id'], $input['name'], 'file', $input['width'], $input['height'], $input['ratio']));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Rename a file
	 *
	 * @access	public
	 * @return	void
	 */
	public function rename_file()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('edit_file', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		if ($id = $this->input->post('file_id') AND $name = $this->input->post('name'))
		{
			echo json_encode(Files::move($id, $name));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit description of a file
	 *
	 * @access	public
	 * @return	void
	 */
	public function save_description()
	{
		if ($id = $this->input->post('file_id') AND $description = $this->input->post('description'))
		{
			$this->file_m->update($id, array('description' => $description));

			echo json_encode(Files::result(TRUE, lang('files:description_saved')));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit location of a folder (S3/Cloud Files/Local)
	 *
	 * @access	public
	 * @return	void
	 */
	public function save_location()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('set_location', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		if ($id = $this->input->post('folder_id') AND 
			$location = $this->input->post('location') AND
			$container = $this->input->post('container'))
		{
			$this->file_folders_m->update($id, array('location' => $location));

			echo json_encode(Files::create_container($container, $location, $id));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Pull new files down from the cloud location
	 *
	 * @access	public
	 * @return	void
	 */
	public function synchronize()
	{
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('synchronize', Files::allowed_actions())) show_error(lang('files:no_permissions'));

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
		if ( ! in_array('delete_file', Files::allowed_actions())) show_error(lang('files:no_permissions'));

		if ($id = $this->input->post('file_id'))
		{
			echo json_encode(Files::delete_file($id));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Search for files and folders
	 *
	 * @access	public
	 * @return	void
	 */
	public function search()
	{
		echo json_encode(Files::search($this->input->post('search')));
	}

	// ------------------------------------------------------------------------
}

/* End of file admin.php */