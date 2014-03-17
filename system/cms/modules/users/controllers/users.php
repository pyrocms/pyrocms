<?php

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Pyro\Module\Users\Model;
use Pyro\Module\Streams\Ui\EntryUi;

/**
 * User controller for the users module (frontend)
 *
 * @author		 Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Controllers
 */
class Users extends Public_Controller
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required classes
        $this->load->helper('user');
        $this->lang->load('user');
        $this->load->library('form_validation');
    }

    /**
     * Show the current user's profile
     */
    public function index()
    {
        if ($this->current_user) {
            $this->view($this->current_user->username);
        } else {
            redirect('users/login/users');
        }
    }

    /**
     * View a user profile based on the username
     *
     * @param string $username The Username or ID of the user
     */
    public function view($username = null)
    {
        // work out the visibility setting
        switch (Settings::get('profile_visibility')) {
            case 'public':
                // if it's public then we don't care about anything
                break;

            case 'owner':
                // they have to be logged in so we know if they're the owner
                $this->current_user or redirect('users/login/users/view/'.$username);

                // do we have a match?
                $this->current_user->username !== $username and redirect('404');
                break;

            case 'hidden':
                // if it's hidden then nobody gets it
                redirect('404');
                break;

            case 'member':
                // anybody can see it if they're logged in
                $this->current_user or redirect('users/login/users/view/'.$username);
                break;
        }

        if ($this->current_user && $username === $this->current_user->username) {
            // Don't make a 2nd db call if the user profile is the same as the logged in user
            $user = $this->current_user;

        } else {
            // Fine, just grab the user from the DB
            $user = Model\User::findByUsername($username);
        }

        // No user? Show a 404 error
        $user or show_404();

        $this->template->build('profile/view', array(
            '_user' => $user,
        ));
    }

    /**
     * Let's login, shall we?
     */
    public function login()
    {
        // Check post and session for the redirect place
        $redirect_to = ($this->input->post('redirect_to'))
            ? trim(urldecode($this->input->post('redirect_to')))
            : $this->session->userdata('redirect_to');

        // Any idea where we are heading after login?
        if (! $_POST and $args = func_get_args()) {
            $this->session->set_userdata('redirect_to', $redirect_to = implode('/', $args));
        }

        // Set the validation rules
        $this->validation_rules = array(
            array(
                'field' => 'email',
                'label' => lang('global:email'),
                'rules' => 'required|callback__check_login'
            ),
            array(
                'field' => 'password',
                'label' => lang('global:password'),
                'rules' => 'required'
            )
        );

        // Call validation and set rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->validation_rules);

        // If the validation worked, or the user is already logged in
        if ($this->form_validation->run() or $this->sentry->check()) {

            // Kill the session
            $this->session->unset_userdata('redirect_to');

            $user = Model\User::findByEmail($this->input->post('email'));

            // trigger a post login event for third party devs
            Events::trigger('post_user_login', $user->id);

            if ($this->input->is_ajax_request()) {

                exit(json_encode(array(
                    'status' => true,
                    'message' => lang('user:logged_in'),
                    'data' => $user->toArray()
                )));

            } else {
                $this->session->set_flashdata('success', lang('user:logged_in'));
            }

            // Don't allow protocols or cheeky requests
            if (strpos($redirect_to, ':') !== false and strpos($redirect_to, site_url()) !== 0) {
                // Just login to the homepage
                redirect('');

            // Passes muster, on your way
            } else {
                redirect($redirect_to ?: '');
            }
        } else {
            $user = new stdClass();
        }


        if ($_POST and $this->input->is_ajax_request()) {
            exit(json_encode(array('status' => false, 'message' => validation_errors())));
        }

        $this->template
            ->set('_user', $user)
            ->set('redirect_to', $redirect_to)
            ->build('login');
    }

    /**
     * Method to log the user out of the system
     */
    public function logout()
    {
        // allow third party devs to do things right before the user leaves
        Events::trigger('pre_user_logout');

        $this->sentry->logout();

        if ($this->input->is_ajax_request()) {
            exit(json_encode(array('status' => true, 'message' => lang('user:logged_out'))));
        } else {
            $this->session->set_flashdata('success', lang('user:logged_out'));
            redirect('');
        }
    }

    /**
     * Method to register a new user
     */
    public function register()
    {
        if ($this->current_user) {
            $this->session->set_flashdata('notice', lang('user:already_logged_in'));
            redirect();
        }

        /* show the disabled registration message */
        if (! Settings::get('enable_registration')) {
            $this->template
                ->title(lang('user:register_title'))
                ->build('disabled');
            return;
        }

        // Start a user model
        $userModel = new Model\Profile;

        // Validation rules
        $validation = array(
            array(
                'field' => 'password',
                'label' => lang('global:password'),
                'rules' => 'required|min_length[6]|max_length[50]'
            ),
            array(
                'field' => 'email',
                'label' => lang('global:email'),
                'rules' => 'required|max_length[60]|valid_email|callback__email_check',
            ),
            array(
                'field' => 'username',
                'label' => lang('user:username'),
                'rules' => Settings::get('auto_username') ? '' : 'required|alpha_dot_dash|min_length[3]|max_length[20]|callback__username_check',
            ),
        );

        // --------------------------------
        // Merge streams and users validation
        // --------------------------------
        // Why are we doing this? We need
        // any fields that are required to
        // be filled out by the user when
        // registering.
        // --------------------------------

        // Get the profile fields validation array from streams
        $this->load->driver('Streams');
        $profile_validation = array();//$this->streams->streams->validation_array('profiles', 'users');

        // Remove display_name
        foreach ($profile_validation as $key => $values) {
            if ($values['field'] == 'display_name') {
                unset($profile_validation[$key]);
                break;
            }
        }

        // Set the validation rules
        $this->form_validation->set_rules(array_merge($validation, $profile_validation));

        // Get user profile data. This will be passed to our
        // streams insert_entry data in the model.
        $assignments = $userModel->getAssignments();

        // This is the required profile data we have from
        // the register form
        $profile_data = array();

        // Get the profile data to pass to the register function.
        foreach ($assignments as $assign) {
            if ($assign->field_slug != 'display_name') {
                if (isset($_POST[$assign->field_slug])) {
                    $profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
                }
            }
        }

        // --------------------------------

        // Set the validation rules
        $this->form_validation->set_rules($validation);

        $user = new stdClass();

        // Set default values as empty or POST values
        foreach ($validation as $rule) {
            $user->{$rule['field']} = $this->input->post($rule['field']) ? $this->input->post($rule['field']) : null;
        }

        // Are they TRYing to submit?
        if ($_POST) {
            if ($this->form_validation->run()) {
                // Check for a bot usin' the old fashioned
                // don't fill this input in trick.
                if ($this->input->post('d0ntf1llth1s1n') !== ' ') {
                    $this->session->set_flashdata('error', lang('user:register_error'));
                    redirect(current_url());
                }

                $email = $this->input->post('email');
                $password = $this->input->post('password');

                // --------------------------------
                // Auto-Username
                // --------------------------------
                // There are no guarantees that we
                // will have a first/last name to
                // work with, so if we don't, use
                // an alternate method.
                // --------------------------------

                if (Settings::get('auto_username')) {
                    if ($this->input->post('first_name') and $this->input->post('last_name')) {

                        $username = slugify($this->input->post('first_name').'.'.$this->input->post('last_name'), '-', true);

                        // do they have a long first name + last name combo?
                        if (strlen($username) > 19) {
                            // try only the last name
                            $username = slugify($this->input->post('last_name'), '-', true);

                            if (strlen($username) > 19) {
                                // even their last name is over 20 characters, snip it!
                                $username = substr($username, 0, 20);
                            }
                        }
                    } else {
                        // If there is no first name/last name combo specified, let's
                        // user the identifier string from their email address
                        $email_parts = explode('@', $email);
                        $username = $email_parts[0];
                    }

                    // Usernames absolutely need to be unique, so let's keep
                    // trying until we get a unique one
                    $i = 1;

                    $username_base = $username;

                    while (
                        $this->db->where('username', $username)
                            ->count_all_results('users') > 0
                    ) {
                        // make sure that we don't go over our 20 char username even with a 2 digit integer added
                        $username = substr($username_base, 0, 18).$i;

                        ++$i;
                    }
                } else {
                    // The user specified a username, so let's use that.
                    $username = $this->input->post('username');
                }

                // --------------------------------

                // Do we have a display name? If so, let's use that.
                // Othwerise we can use the username.
                if (! isset($profile_data['display_name']) or ! $profile_data['display_name']) {
                    $profile_data['display_name'] = $username;
                }

                // We are registering with a null group_id so we just
                // use the default user ID in the settings.
                $user = Model\User::create(
                    array(
                        'username' => $username,
                        'password' => $password,
                        'email' => $email,
                        )
                    );

                $id = $user->id;

                // Try to create the user
                if ($id > 0) {

                    // Make a profile
                    $profile_data['user_id'] = $id;
                    Model\Profile::create($profile_data);


                    // Assign to users
                    Model\User::assignGroupIdsToUser($user, array(2));

                    // trigger an event for third party devs
                    Events::trigger('post_user_register', $id);

                    /* send the internal registered email if applicable */
                    if (Settings::get('registered_email')) {
                        $this->load->library('user_agent');

                        Events::trigger('email', array(
                            'name' => $user->display_name,
                            'sender_ip' => $this->input->ip_address(),
                            'sender_agent' => $this->agent->browser().' '.$this->agent->version(),
                            'sender_os' => $this->agent->platform(),
                            'slug' => 'registered',
                            'email' => Settings::get('contact_email'),
                        ), 'array');
                    }

                    // show the "you need to activate" page while they wait for their email
                    if ((int) Settings::get('activation_email') === 1) {
                        Events::trigger('send_activation_email', $user);
                        $this->session->set_flashdata('notice', lang('user:activation_code_sent_notice'));
                        redirect('users/activate');

                    // activate instantly
                    } elseif ((int) Settings::get('activation_email') === 2) {
                        $user->activateUser();

                        $user = $this->sentry->findUserById($user->id);
                        $this->sentry->login($user, false);

                        $this->session->set_flashdata('success', lang('user:logged_in'));
                        redirect($this->config->item('register_redirect', 'ion_auth'));

                    } else {
                        /* show that admin needs to activate your account */
                        $this->session->set_flashdata('notice', lang('user:activation_by_admin_notice'));
                        redirect('users/register'); /* bump it to show the flash data */
                    }


                // Can't create the user, show why
                } else {
                    // TODO: What's the Sentry equivalent here?
                    $this->template->error_string = $this->ion_auth->errors();
                }
            } else {
                // Return the validation error
                $this->template->error_string = $this->form_validation->error_string();
            }

        // Is there a user hash?
        } else {
            if (($user_hash = $this->session->userdata('user_hash'))) {
                // Convert the array to an object
                $user->email = ( ! empty($user_hash['email'])) ? $user_hash['email'] : '';
                $user->username = $user_hash['nickname'];
            }
        }

        // --------------------------------
        // Create profile fields.
        // --------------------------------

        // Anything in the post?

        $this->template->set('profile_fields', $assignments);

        $this->template
            ->title(lang('user:register_title'))
            ->set('_user', $user)
            ->build('register');
    }

    /**
     * Activate a user
     *
     * @param int $id The ID of the user
     * @param string $code The activation code
     *
     * @return void
     */
    public function activate($id = 0, $code = null)
    {
        // Get info from email
        if ($this->input->post('email')) {
            $this->template->activate_user = Model\User::findByEmail($this->input->post('email'));
            $id = $this->template->activate_user->id;
        }

        $code = ($this->input->post('activation_code')) ? $this->input->post('activation_code') : $code;

        // If user has supplied both bits of information
        if ($id and $code) {

            // Get the User
            $user = Model\User::find($id);

            // Try to activate this user
            if ($user->attemptActivation($code)) {
                $this->session->set_flashdata('activated_email', lang('user:activated_message'));

                // trigger an event for third party devs
                Events::trigger('post_user_activation', $id);

                redirect('users/activated');
            } else {
                $this->template->error_string = lang('user:activation_incorrect');
            }
        }

        $this->template
            ->title(lang('user:activate_account_title'))
            ->set_breadcrumb(lang('user:activate_label'), 'users/activate')
            ->build('activate');
    }

    /**
     * Activated page.
     *
     * Shows an activated messages and a login form.
     */
    public function activated()
    {
        //if they are logged in redirect them to the home page
        if ($this->current_user) {
            redirect('');
        }

        $this->template->activated_email = ($email = $this->session->flashdata('activated_email')) ? $email : '';

        $this->template
            ->title(lang('user:activated_account_title'))
            ->build('activated');
    }

    /**
     * Reset a user's password
     *
     * @param bool $code
     */
    public function reset_pass($code = null)
    {
        $this->template->title(lang('user:reset_password_title'));

        if (PYRO_DEMO) {
            show_error(lang('global:demo_restrictions'));
        }

        //if user is logged in they don't need to be here
        if ($this->current_user) {
            $this->session->set_flashdata('error', lang('user:already_logged_in'));
            redirect('');
        }

        if ($this->input->post('email')) {
            $uname = (string) $this->input->post('user_name');
            $email = (string) $this->input->post('email');

            if (! ($uname or $email)) {
                // they submitted with an empty form, abort
                $this->template->set('error_string', $this->ion_auth->errors())
                    ->build('reset_pass');
            }

            if (! ($user_meta = Model\User::findByEmail($email))) {
                $user_meta = Model\User::findByUsername($email);
            }

            // have we found a user?
            if ($user_meta) {
                $new_password = $this->ion_auth->forgotten_password($user_meta->email);

                if ($new_password) {
                    //set success message
                    $this->template->success_string = lang('forgot_password_successful');

                } else {
                    // Set an error message explaining the reset failed
                    $this->template->error_string = $this->ion_auth->errors();
                }

            } else {
                //wrong username / email combination
                $this->template->error_string = lang('user:forgot_incorrect');
            }
        }

        // code is supplied in url so lets try to reset the password
        if ($code) {
            // verify reset_code against code stored in db
            $reset = $this->ion_auth->forgotten_password_complete($code);

            // did the password reset?
            if ($reset) {
                redirect('users/reset_complete');

            } else {
                // nope, set error message
                $this->template->error_string = $this->ion_auth->errors();
            }
        }

        $this->template->build('reset_pass');
    }

    /**
     * Password reset is finished
     */
    public function reset_complete()
    {
        PYRO_DEMO and show_error(lang('global:demo_restrictions'));

        //if user is logged in they don't need to be here. and should use profile options
        if ($this->current_user) {
            $this->session->set_flashdata('error', lang('user:already_logged_in'));
            redirect('my-profile');
        }

        $this->template
            ->title(lang('user:password_reset_title'))
            ->build('reset_pass_complete');
    }

    /**
     * Edit Profile
     *
     * @param int $id
     */
    public function edit($id = 0)
    {
        if ($this->current_user->isSuperUser() and $id > 0) {
            $user = Model\User::find($id);

            // invalide user? Show them their own profile
            $user or redirect('edit-profile');

        } else {
            $user = $this->current_user or redirect('users/login/users/edit'.(($id > 0) ? '/'.$id : ''));
        }

        $profile_data = array(); // For our form

        // Get the profile data

        // If we have API's enabled, load stuff
        if (Settings::get('api_enabled') and Settings::get('api_user_keys')) {
            $this->load->model('api/api_key_m');
            $this->load->language('api/api');

            $api_key = $this->api_key_m->get_active_key($user->id);
        }

        $this->validation_rules = array(
            array(
                'field' => 'email',
                'label' => lang('user:email'),
                'rules' => 'required|xss_clean|valid_email'
            ),
            array(
                'field' => 'display_name',
                'label' => lang('user:profile_display_name'),
                'rules' => 'required|xss_clean'
            )
        );

        // --------------------------------
        // Merge streams and users validation
        // --------------------------------

        // @todo - fix validation
        // Get the profile fields validation array from streams
        //$profile_validation = $this->streams->streams->validation_array('profiles', 'users', 'edit', array(), $profile_row->id);

        // Set the validation rules
        //$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

        // --------------------------------

        // Settings valid?
        if ($this->form_validation->run()) {
            PYRO_DEMO and show_error(lang('global:demo_restrictions'));

            // Get our secure post
            $secure_post = $this->input->post();

            $user_data = array(); // Data for our user table
            $profile_data = array(); // Data for our profile table

            // --------------------------------
            // Deal with non-profile fields
            // --------------------------------
            // The non-profile fields are:
            // - email
            // - password
            // The rest are streams
            // --------------------------------

            $user_data['email'] = $secure_post['email'];

            // If password is being changed (and matches)
            if ($secure_post['password']) {
                $user_data['password'] = $secure_post['password'];
                unset($secure_post['password']);
            }

            // --------------------------------
            // Set the language for this user
            // --------------------------------

            if (isset($secure_post['lang']) and $secure_post['lang']) {
                $this->ion_auth->set_lang($secure_post['lang']);
                $_SESSION['lang_code'] = $secure_post['lang'];
            }

            // --------------------------------
            // The profile data is what is left
            // over from secure_post.
            // --------------------------------

            $profile_data = $secure_post;

            if ($this->ion_auth->update_user($user->id, $user_data, $profile_data) !== false) {
                Events::trigger('post_user_update', $id);
                $this->session->set_flashdata('success', $this->ion_auth->messages());

            } else {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
            }

            redirect('users/edit'.(($id > 0) ? '/'.$id : ''));

        } else {
            // --------------------------------
            // Grab user data
            // --------------------------------
            // Currently just the email.
            // --------------------------------

            if (isset($_POST['email'])) {
                $user->email = $_POST['email'];
            }
        }

        $ui = new EntryUi;

        $ui->form($user->profile) // We can pass the profile model to generate the form
            ->title('Edit Profile')
            ->viewWrapper('users/profile/edit', array('_user' => $user))
            ->messages(array(
                'success' => 'Profile updated.'
            )) // @todo - language
            ->redirects('admin/users')
            ->render();
    }

    /**
     * Callback From: login()
     *
     * @param string $email The Email address to validate
     *
     * @return bool
     */
    public function _check_login($email)
    {
        $password = $this->input->post('password');


        if ((Events::trigger('authenticate_user', array('email' => $email, 'password' => $password))) == true and ($user = Model\User::findByEmail($email)) !== null) {

            $user = $this->sentry->findUserById($user->id);

            $this->sentry->login($user, false);

        } else {

            try {

                $this->sentry->authenticate(array(
                    'email' => $email,
                    'password' => $password,
                ), (bool) $this->input->post('remember'));

            } catch (UserNotFoundException $e) {

                // Could not log in with password. Maybe its an old style pass?
                try {
                    // Try logging in with this double-hashed password
                    $this->sentry->authenticate(array(
                        'email' => $email,
                        'password' => whacky_old_password_hasher($email, $password),
                    ), (bool) $this->input->post('remember'));

                } catch (UserNotFoundException $e) {

                    // That madness didn't work, error
                    $this->form_validation->set_message('_check_login', 'Incorrect login.');
                    return false;
                }

            } catch (Exception $e) {

                Events::trigger('login_failed', $email);
                error_log('Login failed for user '.$email);

                $this->form_validation->set_message('_check_login', $e->getMessage());
                return false;
            }
        }

        return true;
    }

    /**
     * Username check
     *
     * @param string $username The username to check.
     *
     * @return bool
     */
    public function _username_check($username)
    {
        if (Model\User::findByUsername($username)) {
            $this->form_validation->set_message('_username_check', lang('user:error_username'));
            return false;
        }

        return true;
    }

    /**
     * Email check
     *
     * @param string $email The email to check.
     *
     * @return bool
     */
    public function _email_check($email)
    {
        if (Model\User::findByEmail($email)) {
            $this->form_validation->set_message('_email_check', lang('user:error_email'));
            return false;
        }

        return true;
    }

}
