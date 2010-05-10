<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before frontend controllers
class Public_Controller extends MY_Controller
{
	function Public_Controller()
	{
		parent::MY_Controller();
        
		$this->benchmark->mark('public_controller_start');
        
	    // Check the frontend hasnt been disabled by an admin
	    if(!$this->settings->item('frontend_enabled'))
	    {
	    	$error = $this->settings->item('unavailable_message') ? $this->settings->item('unavailable_message') : lang('cms_fatal_error');
	    	show_error($error);
	    }
		
	    // -- Navigation menu -----------------------------------
	    $this->load->model('pages/pages_m');
	    $this->load->model('themes/themes_m');

		// Load the current theme
		$this->theme = $this->themes_m->get();

		if(!$this->theme)
		{
			show_error('This site has been set to use a theme that does not exist. If you are an administrator please ' . anchor('admin/themes', 'change the theme') . '.');
		}

		// Prepare Asset library
	    $this->asset->set_theme($this->theme->slug);

		// Asset library needs to know where the theme directory is
		$this->config->set_item('theme_asset_dir', dirname($this->theme->path).'/');
		$this->config->set_item('theme_asset_url', dirname($this->theme->web_path).'/');

	    // Set the theme view folder
	    $this->template
			->set_theme($this->theme->slug)
			->append_metadata( '
				<script type="text/javascript">
					var APPPATH_URI = "'.APPPATH_URI.'";
					var BASE_URI = "'.BASE_URI.'";
				</script>' );

		// Is there a layout file for this module?
		if($this->template->theme_layout_exists($this->module . '.html'))
		{
			$this->template->set_layout($this->module . '.html');
		}

		// TODO DEPRECATE php
		elseif($this->template->theme_layout_exists($this->module))
		{
			$this->template->set_layout($this->module);
		}

		// Nope, just use the default layout
		elseif($this->template->theme_layout_exists('default.html'))
		{
			$this->template->set_layout('default.html');
		}

		// TODO DEPRECATE php
		else
		{
			$this->template->set_layout('default');
		}

	    // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
	    $this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');
	    
	    // If there is a news module, link to its RSS feed in the head
	    if( module_exists('news') )
	    {
			$this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.$this->settings->item('site_name').'" href="'.site_url('news/rss/all.rss').'" />');
	    }
		
		// Enable profiler on local box
	    if( ENV == 'local' && $this->input->get('_debug') )
	    {
	    	$this->output->enable_profiler(TRUE);
	    }
	    
	    // Frontend data
	    $this->load->library('variables/variables');
	    
	    $this->load->vars('variable', $this->variables->get());
	    
	    $this->benchmark->mark('public_controller_end');
	}
}
