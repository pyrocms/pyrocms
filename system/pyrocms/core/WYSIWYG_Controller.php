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
	    if($this->user->group !== 'admin' AND ! in_array('files', $this->permissions))
	    {
			$this->load->language('files/files');
			show_error('files.no_permissions');
	    }
		
		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');
		$file_types = array(
			'a' => lang('files.type_a'),
			'v' => lang('files.type_v'),
			'd' => lang('files.type_d'),
			'i' => lang('files.type_i'),
			'o' => lang('files.type_o')
		);


		$this->template
			->set_layout('wysiwyg', 'admin')
			->set('file_types', $file_types)
			->enable_parser(FALSE)
			->append_metadata(js('jquery/jquery.js'))
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
			// fail offline
			// ->append_metadata('<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />')
			->append_metadata( css('jquery/ui-lightness/jquery-ui.css') ) // TODO: Merge this with default jquery-ui.css
			->append_metadata('<script type="text/javascript">var FILES_PATH = "'.base_url().'uploads/files/"</script>')
			->append_metadata( '<script type="text/javascript">var SITE_URL = "'.rtrim(site_url(), '/').'"</script>');
	}
}