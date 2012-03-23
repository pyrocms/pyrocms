<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Users\Controllers
 */
class Admin extends Admin_Controller {

	protected $section = 'users';

	// --------------------------------------------------------------------------
	/**
	 * Validation for basic profile
	 * data. The rest of the validation is
	 * built by streams.
	 *
	 * @access private
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'email',
			'label' => 'lang:user_email_label',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'password',
			'label' => 'lang:user_password_label',
			'rules' => 'min_length[6]|max_length[20]'
		),
		array(
			'field' => 'username',
			'label' => 'lang:user_username',
			'rules' => 'required|alpha_dot_dash|min_length[3]|max_length[20]'
		),
		array(
			'field' => 'group_id',
			'label' => 'lang:user_group_label',
			'rules' => 'required|callback__group_check'
		),
		array(
			'field' => 'active',
			'label' => 'lang:user_active_label',
			'rules' => ''
		),
		array(
			'field' => 'display_name',
			'label' => 'lang:profile_display_name',
			'rules' => 'required'
		)
	);

	// --------------------------------------------------------------------------

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('user_m');
		$this->load->model('groups/group_m');
		$this->load->helper('user');
		$this->load->library('form_validation');
		$this->lang->load('user');

		$this->data->groups = $this->group_m->get_all();
		$this->data->groups_select = array_for_select($this->data->groups, 'id', 'description');
	}

	// --------------------------------------------------------------------------

	/**
	 * List all users
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$base_where = array('active' => 0);

		// ---------------------------
		// User Filters
		// ---------------------------

		// Determine active param
		$base_where['active'] = $this->input->post('f_module') ? (int) $this->input->post('f_active') : $base_where['active'];

		// Determine group param
		$base_where = $this->input->post('f_group') ? $base_where + array('group_id' => (int) $this->input->post('f_group')) : $base_where;

		// Keyphrase param
		$base_where = $this->input->post('f_keywords') ? $base_where + array('name' => $this->input->post('f_keywords')) : $base_where;

		// Create pagination links
		$pagination = create_pagination('admin/users/index', $this->user_m->count_by($base_where));

		// Using this data, get the relevant results
		$users = $this->user_m
			->order_by('active', 'desc')
			->limit($pagination['limit'])
			->get_many_by($base_where);

		// Unset the layout if we have an ajax request
		if ($this->input->is_ajax_request())
		{
			$this->template->set_layout(FALSE);
		}
		
		// Render the view
		$this->template
			->title($this->module_details['name'])
			->set('pagination', $pagination)
			->set('users', $users)
			->set_partial('filters', 'admin/partials/filters')
			->append_js('admin/filter.js');
				
		$this->input->is_ajax_request() ? $this->template->build('admin/tables/users', $this->data) : $this->template->build('admin/index', $this->data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Method for handling different form actions
	 *
	 * @access public
	 * @return void
	 */
	public function action()
	{
		// Pyro demo version restrction
		if (PYRO_DEMO)
		{
		    $this->session->set_flashdata('notice', lang('global:demo_restrictions'));
		    redirect('admin/users');
		}
		
		// Determine the type of action
		switch ($this->input->post('btnAction'))
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

	// --------------------------------------------------------------------------

	/**
	 * Create a new user
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Extra validation for basic data
		$this->validation_rules[1]['rules'] .= '|callback__email_check';
		$this->validation_rules[2]['rules'] .= '|required';
		$this->validation_rules[3]['rules'] .= '|callback__username_check';

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users');

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

		$email 		= $this->input->post('email');
		$password 	= $this->input->post('password');
		$username 	= $this->input->post('username');
		$group_id	= $this->input->post('group_id');

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
		$profile_data = array();

		foreach($assignments as $assign)
		{
			$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
		}

		$profile_data['display_name'] = $this->input->post('display_name');

		if ($this->form_validation->run() !== false)
		{
			// Hack to activate immediately
			if ($this->input->post('active'))
			{
				$this->config->config['ion_auth']['email_activation'] = false;
			}

			$group = $this->group_m->get($this->input->post('group_id'));

			// Try to register the user
			if ($user_id = $this->ion_auth->register($username, $password, $email, $group_id, $profile_data, $group->name))
			{
				// Fire an event. A new user has been created. 
				Events::trigger('user_created', $user_id);
		
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
			// Dirty hack that fixes the issue of having to
			// re-add all data upon an error
			if ($_POST)
			{
				$member = (object) $_POST;
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$member->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->title($this->module_details['name'], lang('user_add_title'))
			->set('member', $member)
			->set('display_name', set_value('display_name', $this->input->post('display_name')))
			->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $profile_data))
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
		// Get the user's data
		if ( ! ($member = $this->ion_auth->get_user($id)))
		{
			$this->session->set_flashdata('error', lang('user_edit_user_not_found_error'));
			redirect('admin/users');
		}

		// Check to see if we are changing usernames
		if ($member->username != $this->input->post('username'))
		{
			$this->validation_rules[3]['rules'] .= '|callback__username_check';
		}

		// Check to see if we are changing emails
		if ($member->email != $this->input->post('email'))
		{
			$this->validation_rules[1]['rules'] .= '|callback__email_check';
		}

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users');

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
		$profile_data = array();

		// Get the profile data
		$profile_row = $this->db->limit(1)->get('profiles')->row();

		foreach($assignments as $assign)
		{	
			if (isset($_POST[$assign->field_slug]))
			{
				$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}
			else
			{
				$profile_data[$assign->field_slug] = $profile_row->{$assign->field_slug};
			}
		}

		if ($this->form_validation->run() === TRUE)
		{
			if (PYRO_DEMO)
			{
				$this->session->set_flashdata('notice', lang('global:demo_restrictions'));
				redirect('admin/users');
			}
			
			// Get the POST data
			$update_data['email'] 			= $this->input->post('email');
			$update_data['active'] 			= $this->input->post('active');
			$update_data['username'] 		= $this->input->post('username');
			$update_data['group_id'] 		= $this->input->post('group_id');

			$profile_data = array();

			// Grab the profile data
			foreach($assignments as $assign)
			{
				$profile_data[$assign->field_slug] 	= $this->input->post($assign->field_slug);
			}	

			// We need to manually do display_name
			$profile_data['display_name'] = $this->input->post('display_name');

			// Password provided, hash it for storage
			if ($this->input->post('password'))
			{
				$update_data['password'] = $this->input->post('password');
			}

			if ($this->ion_auth->update_user($id, $update_data, $profile_data))
			{
				// Fire an event. A user has been updated. 
				Events::trigger('user_updated', $id);
				
				$this->session->set_flashdata('success', $this->ion_auth->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}

			redirect('admin/users');
		}
		else
		{
			// Dirty hack that fixes the issue of having to re-add all data upon an error
			if ($_POST)
			{
				$member = (object) $_POST;
			}
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$member->{$rule['field']} = set_value($rule['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('user_edit_title'), $member->username))
			->set('display_name', $profile_row->display_name)
			->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $profile_data))
			->set('member', $member)
			->build('admin/form', $this->data);
	}

	/**
	 * Show a user preview
	 * @access	public
	 * @param	int $id The ID of the user
	 * @return	void
	 */
	public function preview($id = 0)
	{
		$user = $this->ion_auth->get_user($id);

		$this->template
			->set_layout('modal', 'admin')
			->set('user', $user)
			->build('admin/preview');
	}

	/**
	 * Activate a user
	 * @access public
	 * @param int $id The ID of the user to activate
	 * @return void
	 */
	public function activate()
	{
		// Activate multiple
		if ( ! ($ids = $this->input->post('action_to')))
		{
			$this->session->set_flashdata('error', lang('user_activate_error'));
			redirect('admin/users');
		}

		$activated = 0;
		$to_activate = 0;
		foreach ($ids as $id)
		{
			if ($this->ion_auth->activate($id))
			{
				$activated++;
			}
			$to_activate++;
		}
		$this->session->set_flashdata('success', sprintf(lang('user_activate_success'), $activated, $to_activate));

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
		if (PYRO_DEMO)
		{
			$this->session->set_flashdata('notice', lang('global:demo_restrictions'));
			redirect('admin/users');
		}
		
		$ids = ($id > 0) ? array($id) : $this->input->post('action_to');

		if ( ! empty($ids))
		{
			$deleted = 0;
			$to_delete = 0;
			$deleted_ids = array();
			foreach ($ids as $id)
			{
				// Make sure the admin is not trying to delete themself
				if ($this->ion_auth->get_user()->id == $id)
				{
					$this->session->set_flashdata('notice', lang('user_delete_self_error'));
					continue;
				}

				if ($this->ion_auth->delete_user($id))
				{
					$deleted_ids[] = $id;
					$deleted++;
				}
				$to_delete++;
			}

			if ($to_delete > 0)
			{
				// Fire an event. One or more users have been deleted. 
				Events::trigger('user_deleted', $deleted_ids);
				
				$this->session->set_flashdata('success', sprintf(lang('user_mass_delete_success'), $deleted, $to_delete));
			}
		}
		// The array of id's to delete is empty
		else
		{
			$this->session->set_flashdata('error', lang('user_mass_delete_error'));
		}
		
		redirect('admin/users');
	}

	/**
	 * Username check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 * */
	public function _username_check($username)
	{
		if ($this->ion_auth->username_check($username))
		{
			$this->form_validation->set_message('_username_check', lang('user_error_username'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Email check
	 *
	 * @return bool
	 * @author Ben Edmunds
	 * */
	public function _email_check($email)
	{
		if ($this->ion_auth->email_check($email))
		{
			$this->form_validation->set_message('_email_check', lang('user_error_email'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Check that a proper group has been selected
	 *
	 * @return bool
	 * @author Stephen Cozart
	 */
	public function _group_check($group)
	{
		if ( ! $this->group_m->get($group))
		{
			$this->form_validation->set_message('_group_check', lang('regex_match'));
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file admin.php */