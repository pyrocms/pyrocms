<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Code here is run before frontend controllers

class Public_Controller extends MY_Controller
{
	function Public_Controller()
	{
		parent::MY_Controller();
        
        // Check the frontend hasnt been disabled by an admin
        if(!$this->settings->item('frontend_enabled'))
        {
        	$error = $this->settings->item('unavailable_message') ? $this->settings->item('unavailable_message') : 'Fatal error, is CMS installed?';
        	show_error($error);
        }
				
				// start language string handling
					$this->lang->load('main');
					$this->data->naviHead = $this->lang->line('navigation_headline');
					$this->data->loggedInWelcome = sprintf($this->lang->line('logged_in_welcome'), $this->data->user->first_name.' '.$this->data->user->last_name );
					$this->data->logoutLabel = $this->lang->line('logout_label');
					$this->data->editProfileLabel = $this->lang->line('edit_profile_label');
					$this->data->settingsLabel = $this->lang->line('settings_label');
					$this->data->cpTitle = $this->lang->line('cp_title');
					$this->data->breadcrumbBaseLabel = $this->lang->line('breadcrumb_base_label');
					
					//$this->data-> = $this->lang->line('');
				// stop language string handling
        
        // -- Navigation menu -----------------------------------
        $this->load->module_model('pages', 'pages_m');
        $this->load->module_model('navigation', 'navigation_m');
        
        $this->data->navigation = $this->cache->model('navigation_m', 'frontendNavigation', array(), $this->settings->item('navigation_cache'));

        // Set the theme view folder
        $this->data->theme_view_folder = '../themes/'.$this->settings->item('default_theme').'/views/';
        $this->layout->layout_file = $this->data->theme_view_folder.'layout.php';
        
        // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
        $this->layout->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');
        
        // If there is a news module, link to its RSS feed in the head
        if(is_module('news'))
        {
			$this->layout->extra_head('<link rel="alternate" type="application/rss+xml" title="'.$this->settings->item('site_name').'" href="'.site_url('news/rss/all|rss').'" />');
        }
		
    	//$this->output->enable_profiler(TRUE);
    }

}