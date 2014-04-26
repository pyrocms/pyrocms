<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author		 PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Users\Controllers
 */
class Admin extends Admin_Controller
{

	protected $section = 'users';

	/**
	 * Validation for basic profile
	 * data. The rest of the validation is
	 * built by streams.
	 *
	 * @var array
	 */
	private $validation_rules = array(
		'email' => array(
			'field' => 'email',
			'label' => 'lang:global:email',
			'rules' => 'required|max_length[60]|valid_email'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'lang:global:password',
			'rules' => 'min_length[6]|max_length[20]'
		),
		'username' => array(
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

	/**
	 * Constructor method
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

		if ($this->current_user->group != 'admin') 
		{
			$this->template->groups = $this->group_m->where_not_in('name', 'admin')->get_all();
		} 
		else 
		{
			$this->template->groups = $this->group_m->get_all();
		}
		
		$this->template->groups_select = array_for_select($this->template->groups, 'id', 'description');
	}

	/**
	 * List all users
	 */
	public function index()
	{
		$base_where = array('active' => 0);

		// ---------------------------
		// User Filters
		// ---------------------------

		// Determine active param
		$base_where['active'] = $this->input->post('f_module') ? (int)$this->input->post('f_active') : $base_where['active'];

		// Determine group param
		$base_where = $this->input->post('f_group') ? $base_where + array('group_id' => (int)$this->input->post('f_group')) : $base_where;

		// Keyphrase param
		$base_where = $this->input->post('f_keywords') ? $base_where + array('name' => $this->input->post('f_keywords')) : $base_where;

		// Create pagination links
		$pagination = create_pagination('admin/users/index', $this->user_m->count_by($base_where));

		//Skip admin
		$skip_admin = ( $this->current_user->group != 'admin' ) ? 'admin' : '';

		// Using this data, get the relevant results
		$this->db->order_by('active', 'desc')
			->join('groups', 'groups.id = users.group_id')
			->where_not_in('groups.name', $skip_admin)
			->limit($pagination['limit'], $pagination['offset']);

		$users = $this->user_m->get_many_by($base_where);

		// Unset the layout if we have an ajax request
		if ($this->input->is_ajax_request())
		{
			$this->template->set_layout(false);
		}

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->set('pagination', $pagination)
			->set('users', $users)
			->set_partial('filters', 'admin/partials/filters')
			->append_js('admin/filter.js');

		$this->input->is_ajax_request() ? $this->template->build('admin/tables/users') : $this->template->build('admin/index');
	}

	/**
	 * Method for handling different form actions
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

	/**
	 * Create a new user
	 */
	public function create()
	{
		// Extra validation for basic data
		$this->validation_rules['email']['rules'] .= '|callback__email_check';
		$this->validation_rules['password']['rules'] .= '|required';
		$this->validation_rules['username']['rules'] .= '|callback__username_check';

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users');

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

		$email = strtolower($this->input->post('email'));
		$password = $this->input->post('password');
		$username = $this->input->post('username');
		$group_id = $this->input->post('group_id');
		$activate = $this->input->post('active');

		// keep non-admins from creating admin accounts. If they aren't an admin then force new one as a "user" account
		$group_id = ($this->current_user->group !== 'admin' and $group_id == 1) ? 2 : $group_id;

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
		$profile_data = array();

		foreach ($assignments as $assign)
		{
			$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
		}

		// Some stream fields need $_POST as well.
		$profile_data = array_merge($profile_data, $_POST);

		$profile_data['display_name'] = $this->input->post('display_name');

		if ($this->form_validation->run() !== false)
		{
			if ($activate === '2')
			{
				// we're sending an activation email regardless of settings
				Settings::temp('activation_email', true);
			}
			else
			{
				// we're either not activating or we're activating instantly without an email
				Settings::temp('activation_email', false);
			}

			$group = $this->group_m->get($group_id);

			// Register the user (they are activated by default if an activation email isn't requested)
			if ($user_id = $this->ion_auth->register($username, $password, $email, $group_id, $profile_data, $group->name))
			{
				if ($activate === '0')
				{
					// admin selected Inactive
					$this->ion_auth_model->deactivate($user_id);
				}

				// Fire an event. A new user has been created. 
				Events::trigger('user_created', $user_id);

				// Set the flashdata message and redirect
				$this->session->set_flashdata('success', $this->ion_auth->messages());

				// Redirect back to the form or main page
				$this->input->post('btnAction') === 'save_exit' ? redirect('admin/users') : redirect('admin/users/edit/'.$user_id);
			}
			// Error
			else
			{
				$this->template->error_string = $this->ion_auth->errors();
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

		if ( ! isset($member))
		{
			$member = new stdClass();
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$member->{$rule['field']} = set_value($rule['field']);
		}

		$stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug('profiles', 'users'));

		// Set Values
		$values = $this->fields->set_values($stream_fields, null, 'new');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], lang('user:add_title'))
			->set('member', $member)
			->set('display_name', set_value('display_name', $this->input->post('display_name')))
			->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $values))
			->build('admin/form');
	}

	/**
	 * Edit an existing user
	 *
	 * @param int $id The id of the user.
	 */
	public function edit($id = 0)
	{
		// Get the user's data
		if ( ! ($member = $this->ion_auth->get_user($id)))
		{
			$this->session->set_flashdata('error', lang('user:edit_user_not_found_error'));
			redirect('admin/users');
		}
		
		// Check to see if we are changing usernames
		if ($member->username != $this->input->post('username'))
		{
			$this->validation_rules['username']['rules'] .= '|callback__username_check';
		}

		// Check to see if we are changing emails
		if ($member->email != $this->input->post('email'))
		{
			$this->validation_rules['email']['rules'] .= '|callback__email_check';
		}

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users', 'edit', array(), $id);

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
		$profile_data = array();

		foreach ($assignments as $assign)
		{
			if (isset($_POST[$assign->field_slug]))
			{
				$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}
			elseif (isset($member->{$assign->field_slug}))
			{
				$profile_data[$assign->field_slug] = $member->{$assign->field_slug};
			}
		}

		if ($this->form_validation->run() === true)
		{
			if (PYRO_DEMO)
			{
				$this->session->set_flashdata('notice', lang('global:demo_restrictions'));
				redirect('admin/users');
			}

			// Get the POST data
			$update_data['email'] = $this->input->post('email');
			$update_data['active'] = $this->input->post('active');
			$update_data['username'] = $this->input->post('username');
			// allow them to update their one group but keep users with user editing privileges from escalating their accounts to admin
			$update_data['group_id'] = ($this->current_user->group !== 'admin' and $this->input->post('group_id') == 1) ? $member->group_id : $this->input->post('group_id');

			if ($update_data['active'] === '2')
			{
				$this->ion_auth->activation_email($id);
				unset($update_data['active']);
			}
			else
			{
				$update_data['active'] = (bool) $update_data['active'];
			}

			$profile_data = array();

			// Grab the profile data
			foreach ($assignments as $assign)
			{
				$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}

			// Some stream fields need $_POST as well.
			$profile_data = array_merge($profile_data, $_POST);

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

			// Redirect back to the form or main page
			$this->input->post('btnAction') === 'save_exit' ? redirect('admin/users') : redirect('admin/users/edit/'.$id);
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
			if ($this->input->post($rule['field']) !== null)
			{
				$member->{$rule['field']} = set_value($rule['field']);
			}
		}

		// We need the profile ID to pass to get_stream_fields.
		// This theoretically could be different from the actual user id.
		if ($id)
		{
			$profile_id = $this->db->limit(1)->select('id')->where('user_id', $id)->get('profiles')->row()->id;
		}
		else
		{
			$profile_id = null;
		}

		$stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug('profiles', 'users'));

		$profile = $this->db->limit(1)->where('user_id', $id)->get('profiles')->row();

		// Set Values
		$values = $this->fields->set_values($stream_fields, $profile, 'edit');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], sprintf(lang('user:edit_title'), $member->username))
			->set('display_name', $member->display_name)
			->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $values, $profile_id))
			->set('member', $member)
			->build('admin/form');
	}

	/**
	 * Show a user preview
	 *
	 * @param	int $id The ID of the user.
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
	 * Activate users
	 *
	 * Grabs the ids from the POST data (key: action_to).
	 */
	public function activate()
	{
		// Activate multiple
		if ( ! ($ids = $this->input->post('action_to')))
		{
			$this->session->set_flashdata('error', lang('user:activate_error'));
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
		$this->session->set_flashdata('success', sprintf(lang('user:activate_success'), $activated, $to_activate));

		redirect('admin/users');
	}

	/**
	 * Delete an existing user
	 *
	 * @param int $id The ID of the user to delete
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
					$this->session->set_flashdata('notice', lang('user:delete_self_error'));
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

				$this->session->set_flashdata('success', sprintf(lang('user:mass_delete_success'), $deleted, $to_delete));
			}
		}
		// The array of id's to delete is empty
		else
		{
			$this->session->set_flashdata('error', lang('user:mass_delete_error'));
		}

		redirect('admin/users');
	}

	/**
	 * Username check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $username The username.
	 *
	 * @return bool
	 */
	public function _username_check()
	{
		if ($this->ion_auth->username_check($this->input->post('username')))
		{
			$this->form_validation->set_message('_username_check', lang('user:error_username'));
			return false;
		}
		return true;
	}

	/**
	 * Email check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $email The email.
	 *
	 * @return bool
	 */
	public function _email_check()
	{
		if ($this->ion_auth->email_check($this->input->post('email')))
		{
			$this->form_validation->set_message('_email_check', lang('user:error_email'));
			return false;
		}

		return true;
	}

	/**
	 * Check that a proper group has been selected
	 *
	 * @author Stephen Cozart
	 *
	 * @param int $group
	 *
	 * @return bool
	 */
	public function _group_check($group)
	{
		if ( ! $this->group_m->get($group))
		{
			$this->form_validation->set_message('_group_check', lang('regex_match'));
			return false;
		}
		return true;
	}

}