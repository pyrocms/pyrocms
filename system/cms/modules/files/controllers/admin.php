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

		$this->_check_dir();
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

		$data->folders = $this->file_folders_m->where('parent_id', 0)
			->order_by('sort')
			->get_all();

		$this->template
			->title($this->module_details['name'])
			
			->append_css('module::jquery.fileupload-ui.css')
			->append_css('module::files.css')

			->append_js('jquery/jquery.ui.nestedSortable.js')
			->append_js('jquery/jquery.cooki.js')
			->append_js('module::jquery.fileupload.js')
			->append_js('module::jquery.fileupload-ui.js')
			->append_js('module::functions.js')
		
			->build('admin/index', $data);
	}

	// ------------------------------------------------------------------------

	/**
	 * Set the order of folders
	 *
	 * @access	public
	 * @return	void
	 */
	public function order_folders()
	{
		$i = 0;

		if ($order = $this->input->post('order'))
		{
			foreach (explode(',', $order) as $value) 
			{
				$this->file_folders_m->update_by('slug', $value, array('sort' => $i));
				$i++;
			}
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