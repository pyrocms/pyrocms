<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shared logic and data for all CMS controllers
 *
 * @package		PyroCMS
 * @subpackage	Libraries
 * @category	Controller
 * @author		Phil Sturgeon
 */
class WYSIWYG_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

	    // Not an admin and not allowed to see files
	    if ($this->current_user->group !== 'admin' AND ! array_key_exists('files', $this->permissions))
	    {
			$this->load->language('files/files');
			show_error(lang('files.no_permissions'));
	    }

		// Prepare Asset library
	    $this->asset->set_theme(ADMIN_THEME);

		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');

		$this->template
			->set_theme(ADMIN_THEME)
			->set_layout('wysiwyg', 'admin')
			->enable_parser(FALSE)
			->set('editor_path', $editor_path = APPPATH_URI . 'assets/js/editor/')
			->append_metadata( css('wysiwyg.css', 'wysiwyg') )
			->append_metadata( js('wysiwyg.js', 'wysiwyg') );
	}
}