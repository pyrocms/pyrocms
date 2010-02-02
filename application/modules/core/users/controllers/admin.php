<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	private $rules = array(
		'first_name'		=>	"required|alpha_dash",
		'last_name'			=>	"required|alpha_dash",
		'password'			=>	"min_length[6]|max_length[20]", // will be required when adding1
		'confirm_password'	=>	"matches[password]",
		'email'				=>	"required|valid_email",
		'role'				=>	"required",
		'is_active'			=>	""
	);
	
	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->library('user_lib');
		
		$this->load->model('users_m');
		$this->load->helper('user');
		
		$this->lang->load('user');
		
        $this->data->roles = $this->permissions_m->get_roles();
        $this->data->roles_select = array_for_select($this->data->roles, 'abbrev', 'title');
        
		// Sidebar data
		$this->data->inactive_user_count = $this->users_m->count_by('is_active', 0);
		$this->data->active_user_count = $this->users_m->count_by('is_active', 1);
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}

	// Admin: List all User
	function index()
	{
		// Create pagination links
		$this->data->pagination = create_pagination('admin/users', $this->data->active_user_count);

		// Using this data, get the relevant results
		$this->data->users = $this->users_m->limit($this->data->pagination['limit'])
			->order_by('id', 'desc')
			->get_many_by( 'is_active', 1 );
			
		$this->template->build('admin/index', $this->data);
	}
	
	function inactive()
	{
		$this->data->pagination = create_pagination('admin/users/inactive', $this->data->inactive_user_count);

		$this->data->users = $this->users_m->limit($this->data->pagination['limit'])
			->order_by('id', 'desc')
			->get_many_by('is_active', 0);
		
		$this->template->build('admin/index', $this->data);
	}
		
	// Admin: Different form actions
	function action()
	{
		switch($this->input->post('btnAction'))
		{
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
	function create()
	{
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
					if($this->users_m->activate($user_id))
					{
						$this->session->set_flashdata('success', $this->lang->line('user_added_and_activated_success'));
						redirect('admin/users');
					}					
					else
					{
						$this->data->error_string = $this->lang->line('user_activation_failed');
					}					
				}				
				else
				{					
					// No Activation, send mail
					if($this->user_lib->registered_email($this->user_lib->user_data))
					{
						$this->session->set_flashdata('success', $this->lang->line('user_added_not_activated_success'));
						redirect('admin/users');
					}					
					else
					{
						$this->data->error_string = $this->lang->line($this->user_lib->error_code);
					}
				}				
			}			
			else
			{
				$this->data->error_string = $this->lang->line($this->user_lib->error_code);
			}
		}		
		else
		{
			// Return the validation error message or user_lib error
			$this->data->error_string = $this->validation->error_string;
		}
	
		// Set defult field values
		foreach(array_keys($this->rules) as $field)
		{
			$this->data->member->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}        
		$this->template->build('admin/form', $this->data);
	}

	// Admin: Edit a User
	function edit($id = 0)
	{
		$this->load->library('validation');
		
		// Shouldnt need to have done this, but if password exists make confirm_password required
		if($this->input->post('password'))
		{
			$this->rules['confirm_password'] .= '|required';
		}

		$this->validation->set_rules($this->rules);
		$this->validation->set_fields();
		
		$this->data->member = $this->users_m->get(array('id' => $id));
		
		if(!$this->data->member)
		{
			$this->session->set_flashdata('error', $this->lang->line('user_edit_user_not_found_error'));
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
			
			if($this->users_m->update($id, $update_data))
			{
				$this->session->set_flashdata('success', $this->lang->line('user_edit_success'));
			}			
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('user_edit_error'));
			}			
			redirect('admin/users');
		}		
		else
		{
			$this->data->error_string = $this->validation->error_string;
		}			

		// Override fields with provided values
		foreach(array_keys($this->rules) as $field)
		{
			if(isset($_POST[$field])) $this->data->member->$field = $this->validation->$field;
		}
		$this->template->build('admin/form', $this->data);
	}

	// Admin: Activate a User
	function activate($id = 0)
	{
		$ids = ($id > 0) ? array($id) : $this->input->post('action_to');
		
		// Activate multiple
		if( !empty($ids) )
		{
			$activated = 0;
			$to_activate = 0;
			foreach ($ids as $id)
			{
				if($this->users_m->activate($id))
				{
					$activated++;
				}
				$to_activate++;
			}
			$this->session->set_flashdata('success', sprintf($this->lang->line('user_activate_success'), $activated, $to_activate));
		}		
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('user_activate_error'));
		}		
		redirect('admin/users');
	}

	// Admin: Delete a User
	function delete($id = 0)
	{
		$ids = ($id > 0) ? array($id) : $this->input->post('action_to');

		if(!empty($ids))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($ids as $id)
			{
				// Make sure the admin is not trying to delete themself
				if($this->user_lib->user_data->id == $id)
				{
					$this->session->set_flashdata('notice', $this->lang->line('user_delete_self_error'));
					continue;
				}
				
				if($this->users_m->delete($id))
				{
					$deleted++;
				}
				$to_delete++;
			}
			
			if($to_delete > 0)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('user_mass_delete_success'), $deleted, $to_delete));
			}			
		}		
		// The array of id's to delete is empty
		else $this->session->set_flashdata('error', $this->lang->line('user_mass_delete_error'));
			
		redirect('admin/users');
	}
}
?>