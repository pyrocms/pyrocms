<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Public_Controller
{
	var $user_id = 0;
	
	function __construct()
	{
		parent::Public_Controller();
        
    // If profiles are not enabled, pretend they don't exist
    if(!$this->settings->item('enable_profiles'))
    {
    	show_404();
    }
        
    $this->load->library('session');
		$this->user_id = $this->session->userdata('user_id');		
		$this->load->library('user_lib');
		
    // The user is not logged in, send them to login page
   	if(!$this->user_lib->logged_in())
    {
			redirect('users/login');
    }
		
		$this->load->model('users_m');
		$this->load->model('profile_m');
		
		$this->load->helper('user');
		
		$this->lang->load('user');
		$this->lang->load('profile');
    }

    // USER PROFILE SECTION -------------------------------------------------------------------------------------

    // Show the current users profile
	function index()
	{
		$this->view($this->user_id);
	}
	
	// View users profiles
	function view($id = 0)
	{
		// No user? Show a 404 error. Easy way for now, instead should show a custom error message
		if(!$this->data->user = $this->users_m->get(array('id'=>$id)) ):
			show_404();
		endif;
		
		// Now load thir extra data
		$this->data->profile = $this->profile_m->getProfile(array('user_id'=>$id));

		$this->template->build('profile/view', $this->data);
	}
	
	// Profile: edit profile
	function edit()
	{
		$this->load->library('validation');
    	$rules['gender'] = 'trim|max_length[1]';
		$rules['dob_day'] = 'trim|numeric|required';
    	$rules['dob_month'] = 'trim|numeric|required';
    	$rules['dob_year'] = 'trim|numeric|required';
    	$rules['bio'] = 'trim|max_lenght[1000]';
		
		$rules['phone'] = 'trim|alpha_numeric|max_length[20]';
		$rules['mobile'] = 'trim|alpha_numeric|max_length[20]';
		
		$rules['address_line1'] = 'trim';
		$rules['address_line2'] = 'trim';
		$rules['address_line3'] = 'trim';
		$rules['postcode'] = 'trim|max_length[20]';
		
		$rules['msn_handle'] = 'trim|valid_email';
		$rules['aim_handle'] = 'trim|alpha_numeric';
		$rules['yim_handle'] = 'trim|alpha_numeric';
		$rules['gtalk_handle'] = 'trim|valid_email';
		
		$rules['gravatar'] = 'trim|valid_email';
		
    	$this->validation->set_rules($rules);
    	
    	foreach(array_keys($rules) as $field)
    	{
	   		$fields[$field] = $this->lang->line('profile_'.$field);
	 	}
		
	  	$this->validation->set_fields($fields);

		// If this user already has a profile, use their data if nothing in post array
    	if($this->data->profile = $this->profile_m->getProfile(array('user_id' => $this->user_id)))
    	{
			foreach(array_keys($rules) as $field)
	    	{
	    		if(isset($_POST[$field])) $this->data->profile->$field = $this->validation->$field;
	    	}

		    $this->data->profile->dob_day = date('j', $this->data->profile->dob);
		    $this->data->profile->dob_month = date('n', $this->data->profile->dob);
		    $this->data->profile->dob_year = date('Y', $this->data->profile->dob);
		}
		
		// If no profile, use post or empty string
		else
		{
	  		$this->data->profile = new stdClass();
	    	foreach(array_keys($rules) as $field)
   			{
	    	if(!isset($_POST[$field])) $this->data->profile->$field = '';
	    	}	
		}
    	
	  	// Profile valid?
    	if ($this->validation->run())
    	{
			if ($this->profile_m->updateProfile($_POST, $this->user_id))
			{
    			$this->session->set_flashdata(array('success'=> $this->lang->line('profile_edit_success')));
	    	}  
	    	  		
	    	else
	    	{
	    		$this->session->set_flashdata(array('error'=> $this->lang->line('profile_edit_error')));
	    	}	
	    			
	    	redirect('edit-profile');    	
		}
	
		// Profile invalid (or not been submitted yet)
	    else
	    {
	    	if($this->validation->error_string)
	    	{
		   		$this->session->set_flashdata(array('error'=>$this->validation->error_string));
		   		redirect('edit-profile');
	    	}
	    }
    	
	    // Date ranges for select boxes
	    $this->data->days = array_combine($days = range(1, 31), $days);
	    $this->data->months = array_combine($months = range(1, 12), $months);
	    $this->data->years = array_combine($years = range(date('Y'), date('Y')-120), $years);
        
		$this->template->build('profile/edit', $this->data);
	}	
}

?>