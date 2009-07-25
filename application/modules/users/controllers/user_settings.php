<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_settings extends Public_Controller
{
	var $user_id = 0;
	
	function __construct()
	{
		parent::Public_Controller();
		$this->load->library('session');
		$this->user_id = $this->session->userdata('user_id');
        
		$this->load->model('users_m');
		$this->load->helper('user');
		$this->lang->load('user');
	}

	function index()
	{
		$this->edit();
	}
	
	// Edit a users settings such as name, email, password and language
	function edit()
	{
		if(!$this->user_lib->logged_in()):
			redirect('users/login');
		endif;
	
	    $this->load->library('validation');
	    	
	    $rules = array(
			'settings_first_name'		=>	'required|alpha_dash',
			'settings_last_name'		=>	($this->settings->item('require_lastname') ? 'required|' : '').'alpha_dash',
			'settings_password'			=>	'min_length[6]|max_length[20]',
			'settings_confirm_password'	=>	($this->input->post('settings_password') ? 'required|' : '').'matches[settings_password]',
			'settings_email'			=>	'required|valid_email',
			'settings_confirm_email'	=>	'valid_email|matches[settings_email]',
			'settings_lang'				=>	'alpha|max_length[2]'
		);
			
	    $this->validation->set_rules($rules);
	    	
		$fields = array(
			'settings_first_name'		=>	$this->lang->line('user_first_name'),
			'settings_last_name'		=>	$this->lang->line('user_last_name'),
			'settings_password'			=>	$this->lang->line('user_password'),
			'settings_confirm_password'	=>	$this->lang->line('user_confirm_password'),
			'settings_email'			=>	$this->lang->line('user_email'),
			'settings_confirm_email'	=>	$this->lang->line('user_confirm_email'),
			'settings_lang'				=>	$this->lang->line('user_lang')
		);
		    
	    $this->validation->set_fields($fields);
			
	    // Get settings for this user
	    $this->data->user_settings = $this->users_m->getUser(array('id' => $this->user_id));
			
	    foreach(array_keys($rules) as $field)
		{
	    	if(isset($_POST[$field])) $this->data->user_settings->{str_replace('settings_', '', $field)} = $this->validation->$field;
	    }
	    
			// Settings valid?
	    if ($this->validation->run())
	    {
	    	$set['first_name'] = $this->input->post('settings_first_name', TRUE);
	    	$set['last_name'] = $this->input->post('settings_last_name', TRUE);
	    		
	    	// The cookie has been changed, lets set a new one and update their record
	    	if($this->input->cookie('lang_code') != $this->input->post('settings_lang', TRUE))
	    	{
				// Set the language for this user
				$this->user_lib->set_lang_cookie( $this->input->post('settings_lang', TRUE) );
			    $set['lang'] = $this->input->post('settings_lang', TRUE);
	    	}
	    		
	    	// If password is being changed (and matches)
	    	if($this->input->post('settings_password'))
	    	{
				$this->load->helper('security');				
				$set['password'] = dohash($this->input->post('settings_password') . $this->user_lib->user_data->salt);
	    	}
	    		
	    	// If email is being changed (and matches)
	    	if($this->input->post('settings_email'))
	    	{
				$set['email'] = $this->input->post('settings_email');
	    	}
	    		
			if ($this->users_m->updateUser($this->user_id, $set))
			{
	    		$this->session->set_flashdata(array('success'=> $this->lang->line('user_settings_saved_success')));
	    	}    		
	    	else
	    	{
	    		$this->session->set_flashdata(array('error'=> $this->lang->line('user_settings_saved_error')));
	    	}
			
	    	redirect('edit-settings');
	    }		
	    
	    // Format languages for the dropdown box
	    $this->data->languages = array();
	    foreach($this->config->item('supported_languages') as $lang_code => $lang)
	    {
	    	$this->data->languages[$lang_code] = $lang['name'];
	    }
	    
		$this->layout->create('settings/edit', $this->data);
	}	
}
?>