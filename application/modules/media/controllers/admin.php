<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * PyroCMS Media Admin Controller
 *
 * Provides an admin for the media module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Media
 */
class Admin extends Admin_Controller {

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

		$this->load->models(array('media_m', 'media_folders_m'));
		$this->lang->load('media');

		$this->template->set_partial('nav', 'admin/partials/nav', FALSE);
	}

	/**
	 * Index
	 *
	 * Lists categories.
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$media_folders = $this->media_folders_m->get_all();

		$this->data->media_folders = &$media_folders;

		$this->template->build('admin/folders/index', $this->data);
	}

	public function folders($method = '')
	{
		switch($method)
		{
			case 'list':
				$this->_folder_list();
				break;
			case 'create':
				$this->_folder_create();
				break;

			default:
				$this->_folder_list();
				break;
		}
	}


	private function _folder_list()
	{
		$media_folders = $this->media_folders_m->get_all();

		$this->data->media_folders = &$media_folders;

		$this->template->build('admin/folders/index', $this->data);
	}

	private function _folder_create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('slug', 'URL Slug', 'required|callback__check_folder_slug');
		$this->form_validation->set_rules('name', 'Name', 'required|callback__check_folder_name');

		if($this->form_validation->run())
		{
			
		}
		$folder->name = set_value('name');
		$folder->slug = set_value('slug');

		$this->data->folder =& $folder;
		$this->template->build('admin/folders/form', $this->data);
	}


}

/* End of file admin.php */