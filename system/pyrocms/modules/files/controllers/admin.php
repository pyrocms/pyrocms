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
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	file
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

		$this->load->models(array('file_m', 'file_folders_m'));
		$this->lang->load('files');

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
		$file_folders = $this->file_folders_m->get_all();

		$this->data->file_folders = &$file_folders;

		$this->template
			->title(lang('module.files'))
			->build('admin/layouts/index', $this->data);

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
