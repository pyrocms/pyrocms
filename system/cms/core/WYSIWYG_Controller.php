<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shared logic and data for all CMS controllers
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package		PyroCMS\Core\Controllers
 */
class WYSIWYG_Controller extends MY_Controller
{

	/**
	 * @todo Document this please.
	 */
	public function __construct()
	{
		parent::__construct();

		// Not logged in or not an admin and don't have permission to see files
		if ( ! $this->current_user or ! $this->current_user->hasAccess('files.wysiwyg')) {
			$this->load->language('files/files');
			show_error(lang('files:no_permissions'));
		}

		$theme = $this->themeManager->locate(Settings::get('admin_theme'));
		
		// Using a bad slug? Weak
		if (is_null($theme)) {
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		$this->theme = ci()->theme = $theme;

		// Make a constant as this is used in a lot of places
		defined('ADMIN_THEME') or define('ADMIN_THEME', $this->theme->slug);

		// Set the location of assets
		Asset::add_path('module', APPPATH.'modules/wysiwyg/');
		Asset::add_path('theme', $this->theme->web_path.'/');
		Asset::set_path('theme');

		$this->load->library('files/files');
		$this->lang->load('files/files');
		$this->lang->load('wysiwyg');
		$this->lang->load('buttons');

		$this->template
			->set_theme(ADMIN_THEME)
			->set_layout('wysiwyg', 'admin')
			->enable_parser(false)
			->append_css('module::wysiwyg.css')
			->append_css('jquery/ui-lightness/jquery-ui.css')
			->append_js('jquery/jquery.js')
			->append_js('jquery/jquery-ui.min.js')
			->append_js('plugins.js')
			->append_js('module::wysiwyg.js');
	}

}