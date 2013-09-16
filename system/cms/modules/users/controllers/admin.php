<?php

use Pyro\Module\Streams_core\Cp;
use Pyro\Module\Users;

/**
 * Admin controller for the users module
 *
 * @author       PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Users\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'users';

    protected $form_data = null;

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
/*        array(
            'field' => 'is_activated',
            'label' => 'lang:user_active_label',
            'rules' => ''
        ),*/
/*        array(
            'field' => 'display_name',
            'label' => 'lang:user:profile_display_name',
            'rules' => 'required'
        )*/
    );

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required classes
        $this->load->helper('user');
        $this->load->library('form_validation');
        $this->lang->load(array('user', 'group'));

        $this->form_data['current_user'] = $this->current_user;

        if ($this->current_user->isSuperUser()) 
        {
            $this->template->group_options = $this->form_data['group_options'] = Users\Model\Group::getGroupOptions();
        }  
        else
        {
            // Require for non super users
            $this->validation[] =   array(
                'field' => 'groups[]',
                'label' => 'lang:user_group_label',
                'rules' => 'required|callback__group_check'
            );

            $this->template->group_options = $this->form_data['group_options'] = Users\Model\Group::getGeneralGroupOptions();
        }
    }

    /**
     * List all users
     */
    public function index()
    {
        // ---------------------------
        // User Filters
        // ---------------------------

        // Determine active param
        $by_active = ((bool) $this->input->post('f_active')) ?: false;

        // Determine group param
        $by_group = $this->input->post('f_group');

        // Keyphrase param
        $keywords = $this->input->post('f_keywords');

        // Create pagination links
        // @TODO Create user pagination and reimplement filter
        // $pagination = create_pagination('admin/users/index', User_m::($base_where));

        // Using this data, get the relevant results
        if ($this->current_user->isSuperUser()) {
            $users = Users\Model\User::all();
        } else {
            $users = Users\Model\User::all();
        }

        // Unset the layout if we have an ajax request
        if ($this->input->is_ajax_request()) {
            $this->template->set_layout(false);
        }

        // Render the view
        $this->template
            ->title($this->module_details['name'])
            // ->set('pagination', $pagination)
            ->set('users', $users)
            ->set_partial('filters', 'admin/users/partials/filters')
            ->append_js('admin/filter.js');

        $this->input->is_ajax_request()
            ? $this->template->build('admin/users/tables/users') 
            : $this->template->build('admin/users/index');
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
        //$this->validation_rules['email']['rules'] .= '|callback__email_check';
        $this->validation_rules['password']['rules'] .= '|required';
        //$this->validation_rules['username']['rules'] .= '|callback__username_check';

        // Get the profile fields validation array from streams
        //$this->load->driver('Streams');
        //$profile_validation = $this->streams->streams->validation_array('profiles', 'users');

        // Set the validation rules
        $this->form_validation->set_rules($this->validation_rules);

        $email = strtolower($this->input->post('email'));
        $password = $this->input->post('password');
        $username = $this->input->post('username');
        $group_id = $this->input->post('group_id');
        $activate = $this->input->post('active');

        $enable_entry_post = false;

        if (($this->form_validation->run() !== false)) {
            if ($activate === '2') {
                // we're sending an activation email regardless of settings
                Settings::temp('activation_email', true);
            } else {
                // we're either not activating or we're activating instantly without an email
                Settings::temp('activation_email', false);
            }

            //$group = Users\Model\Group::find($group_id);

            // Register the user (they are activated by default if an activation email isn't requested)
            //if ($user_id = $this->ion_auth->register($username, $password, $email, $group_id, $profile_data, $group->name)) {
            if ($enable_entry_post = $user = Users\Model\User::create(array(
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'is_activated' => $activate,
                    'created_on' => time()
                ))) {
                //if ($activate === '0') {
                    // admin selected Inactive
                    //$this->ion_auth_model->deactivate($user_id);
                //}

                Users\Model\User::assignGroupIdsToUser($user, $this->input->post('groups'));

                // Fire an event. A new user has been created
                Events::trigger('user_created', $user);

                // Redirect back to the form or main page
 /*               $this->input->post('btnAction') === 'save_exit'
                    ? redirect('admin/users')
                    : redirect('admin/users/edit/'.$user->id);*/
            }
        } else {
            // Dirty hack that fixes the issue of having to
            // re-add all data upon an error
            $user = new Users\Model\User;
            $user->is_activated = false;
        }



        // Loop through each validation rule
        foreach ($this->validation_rules as $rule)
        {
            $user->{$rule['field']} = set_value($rule['field']);
        }

        $this->form_data['member'] = $user;

        $user_form = $this->load->view('admin/users/form', $this->form_data, true);

        $tabs = array(
            array(
                'title'     => lang('profile_user_basic_data_label'),
                'id'        => 'basic',
                'content'    => $user_form
            ),
            array(
                'title'     => lang('user:profile_fields_label'),
                'id'        => 'profile-fields',
                'fields'    => '*'
            )
        );

        Cp\Entries::form('profiles', 'users')
            ->tabs($tabs)
            ->enablePost($enable_entry_post) // This enables the profile submittion only if the user was created successfully
            ->onSaving(function($profile) use ($user)
            {
                $profile->user_id = $user->id; // Set the profile user id before saving
            })
            ->successMessage('User saved.') // @todo - language
            ->redirect('admin/users')
            ->render();
    }

    /**
     * Edit an existing user
     *
     * @param int $id The id of the user.
     */
    public function edit($id = 0)
    {

        // Get the user's data
        if ( ! ($user = Users\Model\User::find($id)))
        {
            $this->session->set_flashdata('error', lang('user:edit_user_not_found_error'));
            redirect('admin/users');
        }

        // Check to see if we are changing usernames
        if ($user->username != $this->input->post('username'))
        {
            $this->validation_rules['username']['rules'] .= '|callback__username_check';
        }

        // Check to see if we are changing emails
        if ($user->email != $this->input->post('email'))
        {
            $this->validation_rules['email']['rules'] .= '|callback__email_check';
        }

        // Get the profile fields validation array from streams
        //$this->load->driver('Streams');
        //$profile_validation = $this->streams->streams->validation_array('profiles', 'users', 'edit', array(), $id);

        // Set the validation rules
        $this->form_validation->set_rules($this->validation_rules);


        if (true and ci()->input->post())
        {
            if (PYRO_DEMO)
            {
                $this->session->set_flashdata('notice', lang('global:demo_restrictions'));
                redirect('admin/users');
            }

            // Get the POST data
            $user->email = $this->input->post('email');
            $user->username = $this->input->post('username');

            Users\Model\User::assignGroupIdsToUser($user, $this->input->post('groups'));

            //$user->groups = $this->input->post('groups');

            // @todo - commented out but their some work to be done here with email activation

            // allow them to update their one group but keep users with user editing privileges from escalating their accounts to admin
            // $update_data['group_id'] = ($this->current_user->group !== 'admin' and $this->input->post('group_id') == 1) ? $user->group_id : $this->input->post('group_id');

            // if ($update_data['active'] === '2')
            // {
            //     //$this->ion_auth->activation_email($id);
            //     unset($update_data['active']);
            // }
            // else
            // {
            //     $user->is_activated = (bool) $update_data['active'];
            // }

            // Only update is_active if it was posted
            if ($this->input->post('active'))
            {
                $user->is_activated = $this->input->post('active');;
            }

            // Password provided, hash it for storage
            if ($this->input->post('password'))
            {
                $user->password = $this->input->post('password');
            }

            if ($user->save())
            {
                // Fire an event. A user has been updated. 
                Events::trigger('user_updated', $user);

                //$this->session->set_flashdata('success', 'User saved.'); // @todo - language
            }
            else
            {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
            }

        }

/*        // Loop through each validation rule
        foreach ($this->validation_rules as $rule)
        {
            if ($this->input->post($rule['field']) !== null)
            {
                $user->{$rule['field']} = set_value($rule['field']);
            }
        }*/

        $this->form_data['member'] = $user;

        $user_form = $this->load->view('admin/users/form', $this->form_data, true);

        $tabs = array(
            array(
                'title'     => lang('profile_user_basic_data_label'),
                'id'        => 'basic-data',
                'content'    => $user_form
            ),
            array(
                'title'     => lang('user:profile_fields_label'),
                'id'        => 'profile-fields',
                'fields'    => '*'
            )
        );

        Cp\Entries::form($user->profile) // We can pass the profile model to generate the form
            ->tabs($tabs)
            ->successMessage('User saved.') // @todo - language
            ->redirect('admin/users')
            ->render();
    }

    /**
     * Show a user preview
     *
     * @param   int $id The ID of the user.
     */
    public function preview($id = 0)
    {
        $user = Users\Model\User::find($id);

        $this->template
            ->set_layout('modal', 'admin')
            ->set('user', $user)
            ->build('admin/users/preview');
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
            $user = Users\Model\User::find($id);
            $user->is_activated    = true;
            $this->activated_at = new DateTime;

            if ($user->save())
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
            $deleted_users = array();
            foreach ($ids as $id)
            {
                // Make sure the admin is not trying to delete themself
                if ($this->current_user->id == $id)
                {
                    $this->session->set_flashdata('notice', lang('user:delete_self_error'));
                    continue;
                }

                $user = Users\Model\User::find($id);

                if ($user->delete())
                {
                    $deleted_users[] = $user;
                    $deleted++;
                }
                $to_delete++;
            }

            if ($to_delete > 0)
            {
                // Fire an event. One or more users have been deleted. 
                Events::trigger('user_deleted', $deleted_users);

                // Delet the profile
                $this->pdb->table('profiles')->where('user_id', '=', $id)->delete();

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
        if (Users\Model\User::findByUsername($this->input->post('username')))
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
        if (Users\Model\User::findByEmail($this->input->post('email')))
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
     * @param int $group_id
     *
     * @return bool
     */
    public function _group_check($group_id)
    {
        if ( ! Users\Model\Group::find($group_id))
        {
            $this->form_validation->set_message('_group_check', lang('regex_match'));
            return false;
        }
        return true;
    }

}
