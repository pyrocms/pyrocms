<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();		
		$this->load->model('settings_m');
		$this->load->library('settings');
		$this->lang->load('settings');		
	}
	
	// Admin: List all general settings
	function index()
	{
		$this->data->settings = array();		
		if($settings = $this->settings_m->getSettings( array('is_gui' => 1 )) )
		{
			foreach($settings as $setting)
			{
				$setting->form_control = $this->settings->formControl($setting);				
				if($setting->module == '') $setting->module = 'general';				
				$this->data->settings[$setting->module][] = $setting;				
				$this->data->setting_sections[$setting->module] = ucfirst($setting->module);
			}
		}	
	
		$this->layout->create('admin/index', $this->data);
	}
	
	// Admin: Save the new settings
	function edit()
	{
		$this->load->library('validation');		
		// Create dynamic validation rules
		foreach($this->settings_m->getSettings(array('is_gui'=>1)) as $setting)
		{
			$rules[$setting->slug] = 'trim'.($setting->is_required ? '|required' : '');
			$fields[$setting->slug] = $setting->title;			
			$this->data->settings->{$setting->slug} = $setting->value;
		}
	
		$this->validation->set_rules($rules);
		$this->validation->set_fields($fields);
		
		if ($this->validation->run())
		{
			// Loop through again now wek now it worked
			foreach(array_keys($fields) as $field)
			{
				// Dont update if its the same value
				if($this->input->post($field, FALSE) != $this->data->settings->{$field})
				{
					$this->settings->set_item($field, $this->input->post($field, FALSE));
				}	
			}	
			$this->session->set_flashdata('success', $this->lang->line('settings_save_success'));
		}	
		else
		{
			$this->session->set_flashdata('error', $this->validation->error_string);
		}	
		// Redirect user back to index page or the module/section settings they are editing
		redirect('admin/settings');
	}
}
?>