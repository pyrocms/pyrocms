<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the users module
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Users module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Validation array
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor method
		parent::Admin_Controller();

		// Load the required classes
		$this->load->model('users_m');
		$this->load->model('groups/group_m');
		$this->load->helper('user');
		$this->load->library('form_validation');
		$this->lang->load('user');

		// Create the validation array
		$this->validation_rules = array(
			array(
				'field' => 'first_name',
				'label' => lang('user_first_name_label'),
				'rules' => 'required|utf8'
			),
			array(
				'field' => 'last_name',
				'label' => lang('user_last_name_label'),
				'rules' => 'required|utf8'
			),
			array(
				'field' => 'display_name',
				'label' => lang('user_display_name'),
				'rules' => 'required|alphanumeric|maxlength[50]'
			),
			array(
				'field' => 'password',
				'label' => lang('user_password_label'),
				'rules' => 'min_length[6]|max_length[20]'
			),
			array(
				'field' => 'confirm_password',
				'label' => lang('user_password_confirm_label'),
				'rules' => 'matches[password]'
			),
			array(
				'field' => 'email',
				'label' => lang('user_email_label'),
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'username',
				'label' => lang('user_username'),
				'rules' => 'required|alphanumeric|maxlength[20]'
			),
			array(
				'field' => 'group_id',
				'label' => lang('user_group_label'),
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'active',
				'label' => lang('user_active_label'),
				'rules' => ''
			)
		);

        $this->data->groups 			= $this->group_m->get_all();
        $this->data->groups_select		= array_for_select($this->data->groups, 'id', 'name');

		// Sidebar data
		$this->data->inactive_user_count 	= $this->users_m->count_by('active', 0);
		$this->data->active_user_count 		= $this->users_m->count_by('active', 1);

		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * List all users
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Create pagination links
		$this->data->pagination = create_pagination('admin/users/index', $this->data->active_user_count);

		// Using this data, get the relevant results
		$this->data->users = $this->users_m
			 ->order_by('users.id', 'desc')
			 ->get_many_by('active', 1 );

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}

	/**
	 * Show all inactive users
	 * @access public
	 * @return voud
	 */
	public function inactive()
	{
		$this->data->pagination = create_pagination('admin/users/inactive', $this->data->inactive_user_count);
		$this->data->users		= $this->users_m->limit($this->data->pagination['limit'])
			->order_by('users.id', 'desc')
			->get_many_by('active', 0);

		// Render the view
		$this->template
			->title($this->module_details['name'], lang('user_inactive_title'))
			->build('admin/index', $this->data);
	}

	/**
	 * Method for handling different form actions
	 * @access public
	 * @return void
	 */
	public function action()
	{
		// Determine the type of action
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

	/**
	 * Create a new user
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// We need a password don't you think?
		$this->validation_rules[2]['rules'] .= '|required';
		$this->validation_rules[3]['rules'] .= '|required';
		$this->validation_rules[5]['rules'] .= '|callback__email_check';
		$this->validation_rules[6]['rules'] .= '|callback__username_check';

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		$email 		  = $this->input->post('email');
		$password 	  = $this->input->post('password');
		$username	  = $this->input->post('username');

		$user_data 	= array(
			'first_name' 	=> $this->input->post('first_name'),
			'last_name'  	=> $this->input->post('last_name'),
			'display_name'  => $this->input->post('display_name'),
			'group'  => $this->input->post('group_id')
		);

		if ($this->form_validation->run() !== FALSE)
		{
			//hack to activate immediately
			if ($this->input->post('active'))
			{
				$this->config->set_item('email_activation', $this->settings->email_activation, 'ion_auth');
			}

			// Try to register the user
			if($user_id = $this->ion_auth->register($username, $password, $email, $user_data))
			{
				// Set the flashdata message and redirect
				$this->session->set_flashdata('success', $this->ion_auth->messages());
				redirect('admin/users');
			}
			// Error
			else
			{
				$this->data->error_string = $this->ion_auth->errors();
			}
		}
		else
		{
			// Dirty hack that fixes the issue of having to re-add all data upon an error
			if ($_POST)
			{
				$member = (object)$_POST;
			}
		}
		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$member->{$rule['field']} = set_value($rule['field']);
		}

    	// Render the view
		$this->data->member =& $member;
		$this->template
			->title($this->module_details['name'], lang('user_add_title'))
			->build('admin/form', $this->data);
	}

	/**
	 * Edit an existing user
	 *
	 * @access public
	 * @param int $id The ID of the user to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		// confirm_password is required in case the user enters a new password
		if($this->input->post('password') && $this->input->post('password') != '')
		{
			$this->validation_rules[3]['rules'] .= '|required';
			$this->validation_rules[3]['rules'] .= '|matches[password]';
		}

		// Get the user's data
		$member 			= $this->ion_auth->get_user($id);

		$member->full_name 	= $member->first_name .' '. $member->last_name;

		// Got user?
		if(!$member)
		{
			$this->session->set_flashdata('error', $this->lang->line('user_edit_user_not_found_error'));
			redirect('admin/users');
		}

		// Check to see if we are changing usernames
		if ($member->username != $this->input->post('username'))
		{
			$this->validation_rules[6]['rules'] .= '|callback__username_check';
		}

		// Check to see if we are changing emails
		if ($member->email != $this->input->post('email'))
		{
			$this->validation_rules[5]['rules'] .= '|callback__email_check';
		}

		// Run the validation
		$this->form_validation->set_rules($this->validation_rules);
		if ($this->form_validation->run() === TRUE)
		{
			// Get the POST data
			$update_data['first_name'] 		= $this->input->post('first_name');
			$update_data['last_name'] 		= $this->input->post('last_name');
			$update_data['email'] 			= $this->input->post('email');
			$update_data['active'] 			= $this->input->post('active');
			$update_data['username'] 		= $this->input->post('username');
			$update_data['display_name']	= $this->input->post('display_name');
			$update_data['group_id']		= $this->input->post('group_id');

			// Password provided, hash it for storage
			if( $this->input->post('password') && $this->input->post('confirm_password') )
			{
				$update_data['password'] = $this->input->post('password');
			}

			if($this->ion_auth->update_user($id, $update_data))
			{
				$this->session->set_flashdata('success', $this->ion_auth->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}

			// Redirect the user
			redirect('admin/users');
		}
		else
		{
			// Dirty hack that fixes the issue of having to re-add all data upon an error
			if ($_POST)
			{
				$member 			= (object)$_POST;
				$member->full_name 	= $member->first_name .' '. $member->last_name;
			}
		}
		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$member->{$rule['field']} = set_value($rule['field']);
			}
		}

		// Render the view
		$this->data->member =& $member;
		$this->template
			->title($this->module_details['name'], sprintf(lang('user_edit_title'), $member->full_name))
			->build('admin/form', $this->data);
	}

	/**
	 * Activate a user
	 * @access public
	 * @param int $id The ID of the user to activate
	 * @return void
	 */
	public function activate($id = 0)
	{
		$ids = ($id > 0) ? array($id) : $this->input->post('action_to');

		// Activate multiple
		if( !empty($ids) )
		{
			$activated = 0;
			$to_activate = 0;
			foreach ($ids as $id)
			{
				if($this->ion_auth->activate($id))
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

		// Redirect the user
		redirect('admin/users');
	}

	/**
	 * Delete an existing user
	 *
	 * @access public
	 * @param int $id The ID of the user to delete
	 * @return void
	 */
	public function delete($id = 0)
	{
		$ids = ($id > 0) ? array($id) : $this->input->post('action_to');

		if(!empty($ids))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($ids as $id)
			{
				// Make sure the admin is not trying to delete themself
				if($this->ion_auth->get_user()->id == $id)
				{
					$this->session->set_flashdata('notice', $this->lang->line('user_delete_self_error'));
					continue;
				}

				if($this->ion_auth->delete_user($id))
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

		// Redirect
		redirect('admin/users');
	}



	/**
	 * Username check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function _username_check($username)
	{
	    if ($this->ion_auth->username_check($username))
	    {
	        $this->form_validation->set_message('_username_check', $this->lang->line('user_error_username'));
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}

	/**
	 * Email check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function _email_check($email)
	{
	    if ($this->ion_auth->email_check($email))
	    {
	        $this->form_validation->set_message('_email_check', $this->lang->line('user_error_email'));
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}
?>
