<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

	private $rules = array(
		'first_name'		=>	"required|alpha_dash",
		'last_name'			=>	"required|alpha_dash",
		'password'			=>	"min_length[6]|max_length[20]", // will be required when adding1
		'confirm_password'	=>	"matches[password]",
		'email'				=>	"required|valid_email",
		'is_active'			=>	""
	);
	
	function __construct() {
		parent::Admin_Controller();
		
		$this->load->library('session');
		$this->load->library('user_lib');
		
		$this->load->model('users_m');
		$this->load->helper('user');
		
		$this->lang->load('user');
		
		$this->data->roles = $this->users_m->getRoles();
	}

	// Admin: List all User
	function index() {
		
		// Create pagination links
		$total_rows = $this->users_m->countUsers(array('active' => 1));
		$this->data->pagination = create_pagination('admin/users/index', $total_rows);

		// Using this data, get the relevant results
		$active_criteria = array( 'active' => 1, 'limit' => $this->data->pagination['limit'], 'order' => 'id desc' );
		$this->data->users = $this->users_m->getUsers($active_criteria);
		
		// How many inactive users are on the site?
		$this->data->inactive_user_count = $this->users_m->countUsers(array('active' => 0));
		
		$this->layout->create('admin/index', $this->data);
	}
	
	function inactive() {
		
		$total_rows = $this->users_m->countUsers(array('active' => 1));
		$this->data->pagination = create_pagination('admin/users/inactive', $total_rows);

		$inactive_criteria = array( 'active' => 0, 'limit' => $this->data->pagination['limit'], 'order' => 'id desc' );
		$this->data->users = $this->users_m->getUsers($inactive_criteria);
		
		$this->layout->create('admin/inactive', $this->data);
	}
		
	// Admin: Different actions
	function action()
	{
		switch($this->input->post('submit'))
		{
			case 'add':
				redirect('admin/users/add');
			break;
			case 'activate':
				$this->activate();
			break;
			case 'delete':
				$this->delete();
			break;
			default:
				redirect('admin/users');
			break;
		}
	}

	// Admin: Add a new User
	function add() {
		$this->load->library('validation');
		
		// Adding a user, we must have a password
		$this->rules['password'] .= '|required';
		$this->rules['confirm_password'] .= '|required';
		
		$this->validation->set_rules($this->rules);
		$this->validation->set_fields();
		
		$email = $this->input->post('email');
		$password = $this->input->post('password');
				
		if ($this->validation->run() !== FALSE)
		{
			if($user_id = $this->user_lib->create($email, $password))
			{
				if($this->input->post('is_active'))
				{
					// Activate the user
					if($this->users_m->activateUser($user_id))
					{
						$this->session->set_flashdata('success', 'New user has been created and activated.');
						redirect('admin/users/index');
					} else {
						$this->data->error_string = $this->lang->line('user_activation_failed');
					}
					
				} else {
					
					// No Activation, send mail
					if($this->user_lib->registered_email($this->user_lib->user_data))
					{
						$this->session->set_flashdata('success', 'New user has been created, the account needs to be activated.');
						redirect('admin/users/index');
					} else {
						$this->data->error_string = $this->lang->line($this->user_lib->error_code);
					}
					
				}
				
			} else {
				$this->data->error_string = $this->lang->line($this->user_lib->error_code);
			}
			
		} else {
			// Return the validation error message or user_lib error
			$this->data->error_string = $this->validation->error_string;
		}
	
		// Set defult field values
		foreach(array_keys($this->rules) as $field) {
        	$this->data->member->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
        }
        
		$this->layout->create('admin/form', $this->data);
	}

	// Admin: Edit a User
	function edit($id = 0) {
		$this->load->library('validation');
		
		// Shouldnt need to have done this, but if password exists make confirm_password required
		if($this->input->post('password'))
		{
			$this->rules['confirm_password'] .= '|required';
		}

		$this->validation->set_rules($this->rules);
		$this->validation->set_fields();
		
		$this->data->member = $this->users_m->getUser(array('id' => $id));
		
		if(!$this->data->member)
		{
			$this->session->set_flashdata('error', 'User not found.');
			redirect('admin/users');
		}
		
		if ($this->validation->run()) 
		{		
			$update_data['first_name'] = $this->input->post('first_name');
			$update_data['last_name'] = $this->input->post('last_name');
			$update_data['email'] = $this->input->post('email');
			$update_data['is_active'] = $this->input->post('is_active');
			
			// Only worry about role if there is one, it wont show to people who shouldnt see it
			if($this->input->post('role')) $update_data['role'] = $this->input->post('role');
			
			// Password provided, hash it for storage
			if( $this->input->post('password') && $this->input->post('confirm_password') )
			{
				$this->load->helper('security');
				$update_data['password'] = dohash($this->input->post('password') . $this->data->member->salt);
			}
			
			if($this->users_m->updateUser($id, $update_data))
			{
				$this->session->set_flashdata('success', 'User successfully updated.');
			}
			
			else
			{
				$this->session->set_flashdata('error', 'Error occurred when trying to update user.');
			}
			
			redirect('admin/users');
		}
		
		else
		{
			$this->data->error_string = $this->validation->error_string;
		}			

		// Override fields with provided values
		foreach(array_keys($this->rules) as $field) {
        	
        	if(isset($_POST[$field]))
        		$this->data->member->$field = $this->validation->$field;
        }

        $this->layout->create('admin/form', $this->data);
	}

	// Admin: Activate a User
	function activate($id = 0) {

    	// Activate one
		if($id)
		{	
			if($this->users_m->activateUser($id))
			{
				$this->session->set_flashdata('success', 'User id: '.$id.' successfully activated.');
			} else {
				$this->session->set_flashdata('error', 'Error occurred while trying to activate user id: '.$id);
			}
		// Activate multiple
		} else {
			if(isset($_POST['action_to']))
			{
				$activated = 0;
				$to_activate = 0;
				foreach ($this->input->post('action_to') as $id => $value) {
					if($this->users_m->activateUser($id))
					{
						$activated++;
					}
					$to_activate++;
				}
				$this->session->set_flashdata('success', $activated.' users out of '.$to_activate.' successfully activated.');
			} else {
				$this->session->set_flashdata('error', 'You need to select users first.');
			}
		}
		
		redirect('admin/users');
		return;
	}

	// Admin: Delete a User
	function delete($id = 0) {

		$ids = ($id > 0) ? array($id => '') : $this->input->post('action_to');

		if(!empty($ids))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach (array_keys($ids) as $id)
			{
				// Make sure the admin is not trying to delete themself
				if($this->user_lib->user_data->id == $id)
				{
					$this->session->set_flashdata('notice', 'You cannot delete yourself!');
					continue;
				}
				
				if($this->users_m->deleteUser($id))
				{
					$deleted++;
				}
				$to_delete++;
			}
			
			if($to_delete > 0)
			{
				$this->session->set_flashdata('success', $deleted.' users out of '.$to_delete.' successfully deleted.');
			}
			
		}
		
		// The array of id's to delete is empty
		else $this->session->set_flashdata('error', 'You need to select users first.');
			
		redirect('admin/users');
	}


	// Private: Create resize of Cropped Image to ensure it's a certain size
	function _create_resize($homeimg = '', $x, $y) {
		unset($img_cfg);
		$img_cfg['source_image'] = './assets/img/staff/' . $homeimg;
		$img_cfg['new_image'] = './assets/img/staff/' . $homeimg;
		$img_cfg['maintain_ratio'] = true;
		$img_cfg['width'] = $x;
		$img_cfg['height'] = $y;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg);
		$this->image_lib->resize();
	}

}

?>