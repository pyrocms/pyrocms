<?php

use Pyro\Module\Redirects\Model\RedirectEntryModel;
use Pyro\Module\Variables\VariableData;

/**
 * Code here is run before frontend controllers
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package 	PyroCMS\Core\Controllers
 */
class Public_Controller extends MY_Controller
{
	/**
	 * Loads the gazillion of stuff, in Flash Gordon speed.
	 * @todo Document properly please.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->benchmark->mark('public_controller_start');

		// Check redirects if GET and Not AJAX
		if ( ! $this->input->is_ajax_request() and $_SERVER['REQUEST_METHOD'] == 'GET') {
			$uri = trim(uri_string(), '/');

			if ($uri and $redirect = RedirectEntryModel::findByUri($uri)) {
				// Check if it was direct match
				if ($redirect->from == $uri) {
					redirect($redirect->to, 'location', $redirect->type);
				}

				// If it has back reference
				if (strpos($redirect->to, '$') !== false) {
					$from = str_replace('%', '(.*?)', $redirect->from);
					$redirect->to = preg_replace('#^'.$from.'$#', $redirect->to, $uri);
				}
				// Redirect with wanted redirect header type
				redirect($redirect->to, 'location', $redirect->type);
			}
		}

		Events::trigger('public_controller');

		// Check the frontend hasnt been disabled by an admin
		if ( ! Settings::get('frontend_enabled') && (empty($this->current_user) or ! $this->current_user->isSuperUser()) && ! $this->input->is_ajax_request()) {
			header('Retry-After: 600');

			$error = Settings::get('unavailable_message') ?: lang('cms:fatal_error');
			show_error($error, 503);
		}

		// Load the current theme so we can set the assets right away
		ci()->theme = $this->themeManager->locate(Settings::get('default_theme'));

		if (empty($this->theme->model->slug)) {
			show_error('This site has been set to use a theme that does not exist. If you are an administrator please '.anchor('admin/themes', 'change the theme').'.');
		}

		// Set the theme as a path for Asset library
		Asset::add_path('theme', $this->theme->path.'/');
		Asset::set_path('theme');

		$this->registerWidgetLocations();

		// Support CDN URL's like Amazon CloudFront
		if (Settings::get('cdn_domain')) {
			$protocol = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';

			// Make cdn.pyrocms.com into https://cdn.pyrocms.com/
			Asset::set_url($protocol.'://'.rtrim(Settings::get('cdn_domain'), '/').'/');
		}

		// Set the theme view folder
		$this->template->set_theme($this->theme->model->slug);

		// Is there a layout file for this module?
		if ($this->template->layout_exists($this->module.'.html')) {
			$this->template->set_layout($this->module.'.html');
		}

		// Nope, just use the default layout
		elseif ($this->template->layout_exists('default.html')) {
			$this->template->set_layout('default.html');
		}

		// Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
		$this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');

		// If there is a blog module, link to its RSS feed in the head
		if (module_enabled('blog')) {
			$this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.Settings::get('site_name').'" href="'.site_url('blog/rss/all.rss').'" />');
		}

		//ci()->variables = new VariableData;

		// Assign segments to the template the new way
		$this->template->server = $_SERVER;

		// Set the theme option values
		foreach ($this->theme->model->options as $options) {
			$this->theme->options[$options->slug] = $options->value;
		}
		$this->template->theme = $this->theme;

		$this->benchmark->mark('public_controller_end');
	}

	/**
	 * Let the Frontend know where Widgets are hiding
	 */
	public function registerWidgetLocations()
	{
		$this->widgetManager->setLocations(array(
		   APPPATH.'widgets/',
		   ADDONPATH.'widgets/',
		   SHARED_ADDONPATH.'widgets/',
		));
	}
}
