<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before frontend controllers
class Public_Controller extends MY_Controller
{
	public function Public_Controller()
	{
		parent::__construct();

		$this->benchmark->mark('public_controller_start');
		
		//check for a redirect
		$this->load->model('redirects/redirect_m');
		$uri = trim(uri_string(), '/');
		if ($redirect = $this->redirect_m->get_from($uri))
		{
			redirect($redirect->to);
		}

		Events::trigger('public_controller');

		// Check the frontend hasnt been disabled by an admin
		if ( ! $this->settings->frontend_enabled && (empty($this->user) OR $this->user->group != 'admin'))
		{
			$error = $this->settings->unavailable_message ? $this->settings->unavailable_message : lang('cms_fatal_error');
			show_error($error);
		}

		// -- Navigation menu -----------------------------------
		$this->load->model('pages/pages_m');

		if ( ! $this->theme)
		{
			show_error('This site has been set to use a theme that does not exist. If you are an administrator please ' . anchor('admin/themes', 'change the theme') . '.');
		}

		// Prepare Asset library
	    $this->asset->set_theme($this->theme->slug);

	    // Set the theme view folder
	    $this->template
			->set_theme($this->theme->slug)
			->append_metadata( '
				<script type="text/javascript">
					var APPPATH_URI = "'.APPPATH_URI.'";
					var BASE_URI = "'.BASE_URI.'";
				</script>' );

		// Is there a layout file for this module?
		if ($this->template->layout_exists($this->module . '.html'))
		{
			$this->template->set_layout($this->module . '.html');
		}

		// Nope, just use the default layout
		elseif ($this->template->layout_exists('default.html'))
		{
			$this->template->set_layout('default.html');
		}

	    // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
	    $this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');

	    // If there is a blog module, link to its RSS feed in the head
	    if(module_exists('blog'))
	    {
			$this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.$this->settings->site_name.'" href="'.site_url('blog/rss/all.rss').'" />');
	    }

		// Enable profiler on local box
	    if( ENV == 'local' && $this->input->get('_debug') )
	    {
	    	$this->output->enable_profiler(TRUE);
	    }

	    // Frontend data
	    $this->load->library('variables/variables');

        // Assign segments to the template the new way
	    $this->template->variables = $this->variables->get_all();
		$this->template->settings = $this->settings->get_all();
		$this->template->server = $_SERVER;
		$this->template->user = (array) $this->user;

		$this->benchmark->mark('public_controller_end');
	}
}
