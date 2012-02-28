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
	private $_path 		= '';
	private $_type 		= NULL;
	private $_ext 		= NULL;
	private $_filename	= NULL;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->config->load('files');
		$this->lang->load('files');
		$this->load->models(array(
			'file_m',
			'file_folders_m'
		));

		$this->template->append_metadata(
			"<script>
				pyro.lang.fetching = '".lang('files:fetching')."';
				pyro.lang.fetch_completed = '".lang('files:fetch_completed')."';
				pyro.lang.start = '".lang('files:start')."';
				pyro.lang.cancel = '".lang('buttons.cancel')."';
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
					data-name="<?php echo $folder['name']?>"
						<?php echo (strlen($folder['name']) > 20 ? 'title="'.$folder['name'].'"><a href="#">'.substr($folder['name'], 0, 20).'...</a>' : '><a href="#">'.$folder['name']); ?></a>

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

			echo json_encode(array('status' => TRUE, 'message' => lang('files:sort_saved')));
		}
		else 
		{
			echo json_encode(array('status' => FALSE, 'message' => lang('files:save_failed')));
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
		if ($folder_id = $this->input->post('folder_id') AND $name = $this->input->post('name'))
		{
			echo json_encode(Files::upload($folder_id, $name));
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

			echo json_encode(array('status' => TRUE, 'message' => lang('files:description_saved')));
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
		if ($id = $this->input->post('folder_id') AND $location = $this->input->post('location'))
		{
			$this->file_folders_m->update($id, array('location' => $location));

			echo json_encode(array('status' => TRUE, 'message' => lang('files:location_saved')));
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
		if ($id = $this->input->post('file_id'))
		{
			echo json_encode(Files::delete_file($id));
		}
	}

	// ------------------------------------------------------------------------
}

/* End of file admin.php */