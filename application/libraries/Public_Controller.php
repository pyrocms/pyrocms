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
	    $this->load->model('navigation/navigation_m');
	        
	    $this->data->navigation = $this->cache->model('navigation_m', 'frontendNavigation', array(), $this->settings->item('navigation_cache'));
		
	    // Set the theme view folder
	    $this->template->set_theme($this->settings->item('default_theme'));
	    
	    $this->template->set_layout('layouts/default');
	    
	    // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
	    $this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');
	    
	    // If there is a news module, link to its RSS feed in the head
	    if(module_exists('news'))
	    {
			$this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.$this->settings->item('site_name').'" href="'.site_url('news/rss/all|rss').'" />');
	    }
		
		// Enable profiler on local box
	    if( ENV == 'local' )
	    {
	    	$this->output->enable_profiler(TRUE);
	    }
	    
	    
	    $this->benchmark->mark('public_controller_end');
	}
}
