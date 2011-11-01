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

		ci()->admin_theme = $this->themes_m->get_admin();
		
		// Using a bad slug? Weak
		if (empty($this->admin_theme->slug))
		{
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		// make a constant as this is used in a lot of places
		defined('ADMIN_THEME') or define('ADMIN_THEME', $this->admin_theme->slug);
			
		// Prepare Asset library
	    $this->asset->set_theme(ADMIN_THEME);
	
		// Set the location of assets
		$this->config->set_item('asset_dir', dirname($this->admin_theme->web_path).'/');
		$this->config->set_item('asset_url', BASE_URL.dirname($this->admin_theme->web_path).'/');
		$this->config->set_item('theme_asset_dir', dirname($this->admin_theme->web_path).'/');
		$this->config->set_item('theme_asset_url', BASE_URL.dirname($this->admin_theme->web_path).'/');

		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');

		$this->template
			->set_theme(ADMIN_THEME)
			->set_layout('wysiwyg', 'admin')
			->enable_parser(FALSE)
			->set('editor_path', config_item('asset_dir').'js/ckeditor/')
			->append_metadata( css('wysiwyg.css', 'wysiwyg') )
			->append_metadata( css('jquery/ui-lightness/jquery-ui.css') )
			->append_metadata( js('jquery/jquery.min.js') )
			->append_metadata( js('plugins.js') )
			->append_metadata( js('jquery/jquery-ui.min.js') )
			->append_metadata( js('wysiwyg.js', 'wysiwyg') );
	}
}