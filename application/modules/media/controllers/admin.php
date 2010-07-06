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
	 * Shows the default
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$media_folders = $this->media_folders_m->get_all();

		$this->data->media_folders = &$media_folders;

		$this->template->build('admin/layouts/index', $this->data);

	}

	public function images()
	{
		$folders = $this->media_folders_m->get_children(0);
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/images', $this->data);
		}
		else
		{
			redirect('admin/media#images');
		}
	}

	public function documents()
	{
		$folders = $this->media_folders_m->get_children(0, 'd');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/documents', $this->data);
		}
		else
		{
			redirect('admin/media#documents');
		}
	}

	public function video()
	{

		$folders = $this->media_folders_m->get_children(0, 'v');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/video', $this->data);
		}
		else
		{
			redirect('admin/media#video');
		}
	}

	public function audio()
	{
		$folders = $this->media_folders_m->get_children(0, 'a');
		$this->data->selected_folder = 0;
		$this->data->folders = array(0 => '-- All --') + $this->_folder_dropdown_array($folders);

		if($this->is_ajax())
		{
			$this->load->view('admin/partials/audio', $this->data);
		}
		else
		{
			redirect('admin/media#audio');
		}
	}



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