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
	function WYSIWYG_Controller()
	{
		parent::__construct();

	    // Not an admin and not allowed to see files
	    if($this->user->group !== 'admin' AND ! in_array('files', $this->permissions))
	    {
			$this->load->language('files/files');
			show_error('files.no_permissions');
	    }
		
		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');

		$this->template
			->set_layout('wysiwyg', 'admin')
			->enable_parser(FALSE)
			->append_metadata(js('jquery/jquery.js'))
	    	->append_metadata('<script type="text/javascript">jQuery.noConflict();</script>')
	    	->append_metadata(js('jquery/jquery.livequery.js'))
	    	->append_metadata(js('jquery/jquery.fancybox.js'))
	    	->append_metadata(css('jquery/jquery.fancybox.css'))
			->set('editor_path', $editor_path = APPPATH_URI . 'assets/js/editor/')
			->append_metadata( css('wysiwyg.css', 'wysiwyg') )
			->append_metadata( css('admin/uniform.default.css') )
			->append_metadata( js('wysiwyg.js', 'wysiwyg') )
			->append_metadata( js('admin/jquery.uniform.min.js') )
			->append_metadata( js('jquery/jquery-ui-1.8.4.min.js') )
			->append_metadata('<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />')
			->append_metadata('<script type="text/javascript">var FILES_PATH = "'.base_url().'uploads/files/"</script>')
			->append_metadata( '<script type="text/javascript">var SITE_URL = "'.rtrim(site_url(), '/').'"</script>');
	}
}