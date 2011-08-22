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
	public function WYSIWYG_Controller()
	{
		parent::__construct();

	    // Not an admin and not allowed to see files
	    if ($this->user->group !== 'admin' AND ! in_array('files', $this->permissions))
	    {
			$this->load->language('files/files');
			show_error('files.no_permissions');
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
			->append_metadata(js('jquery/jquery.min.js'))
	    	->append_metadata('<script type="text/javascript">jQuery.noConflict();</script>')
	    	->append_metadata(js('jquery/jquery.livequery.min.js'))
	    	->append_metadata(js('jquery/jquery.fancybox.js'))
	    	->append_metadata(css('jquery/jquery.fancybox.css'))
			->set('editor_path', $editor_path = APPPATH_URI . 'assets/js/editor/')
			->append_metadata( css('wysiwyg.css', 'wysiwyg') )
			->append_metadata( css('jquery/uniform.default.css') )
			->append_metadata( js('wysiwyg.js', 'wysiwyg') )
			->append_metadata( js('jquery/jquery.uniform.min.js') )
			->append_metadata( js('jquery/jquery-ui.min.js') )
			->append_metadata( css('jquery/ui-lightness/jquery-ui.css') ); // TODO: Merge it with default jquery-ui.css
	}
}