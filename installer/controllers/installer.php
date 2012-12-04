<?php

// This is for using the the settings library in PyroCMS when installing.
// This is a copy of the function that exists in system/cms/core/My_Controller.php
function ci()
{
    return get_instance();
}

define('PYROPATH', dirname(FCPATH).'/system/cms/');
define('ADDONPATH', dirname(FCPATH).'/addons/default/');
define('SHARED_ADDONPATH', dirname(FCPATH).'/addons/shared_addons/');

/**
 * Installer controller.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Installer\Controllers
 *
 * @property CI_Loader          $load
 * @property CI_Parser          $parser
 * @property CI_Input           $input
 * @property CI_Session         $session
 * @property CI_Form_validation $form_validation
 * @property CI_Lang            $lang
 * @property CI_Config          $config
 * @property CI_Router          $router
 * @property Module_import      $module_import
 * @property Installer_lib      $installer_lib
 */
class Installer extends CI_Controller
{
	/** @var array Languages supported by the installer */
    private $languages  = array('arabic', 'brazilian', 'english', 'dutch', 'french', 'german', 'portuguese', 'polish', 'chinese_traditional', 'slovenian', 'spanish', 'russian', 'greek', 'lithuanian','danish','vietnamese', 'indonesian', 'hungarian', 'finnish', 'swedish','thai','italian');

	/** @var array Directories that need to be writable */
    private $writable_directories = array(
        'system/cms/cache',
        'system/cms/config',
        'addons',
        'assets/cache',
        'uploads',
    );

	/** @var array Files that need to be writable */
    private $writable_files = array(
        'system/cms/config/config.php'
    );

    /**
     * Array containing the files that need to be writable
     *
     * @var array
     */
    private $default_ports = array(
        'mysql' => 3306,
        'pgsql' => 5432,
    );


    /**
	 * At start this controller should:
	 * 1. Load the array of supported servers
	 * 2. Set the language used by the user.
	 * 3. Load the language files.
	 * 4. Load the Form validation library.
     */
    public function __construct()
    {
        parent::__construct();

        // Load the config file that contains a list of supported servers
        $this->load->config('servers');

        // Sets the language
        $this->_set_language();

        // Let us load stuff from the main application
        $this->load->add_package_path(PYROPATH);
        $this->load->add_package_path(SHARED_ADDONPATH);

		// also we load some generic language labels
		$this->lang->load('installer');
		// Include some constants that modules may be looking for
		// set the supported languages to be saved in Settings for emails and .etc
		// modules > settings > details.php uses this
		require_once(dirname(FCPATH).'/system/cms/config/language.php');
		
		define('DEFAULT_LANG', $config['default_language']);
		define('SITE_REF', 'default');

        // Load form validation
        $this->load->library('form_validation');
    }

    /**
     * Index method
     */
    public function index()
    {
		$this->_render_view('main');
    }

    /**
     * Pre installation
     */
    public function step_1()
    {
        $data = new stdClass;

        // Save this junk for later
        // Used in validation callback, so set early
        $this->session->set_userdata(array(
            'db.driver'    => $driver    = $this->input->post('db_driver'),
            'db.hostname'  => $hostname  = $this->input->post('hostname'),
            'db.location'  => $location  = $this->input->post('location'),
            'db.username'  => $username  = $this->input->post('username'),
            'db.password'  => $password  = $this->input->post('password'),
            'db.port'      => $port      = $this->input->post('port'),
            'db.database'  => $database  = $this->input->post('database'),
            'db.create_db' => $this->input->post('create_db'),
            'http_server'  => $this->input->post('http_server'),
        ));

        // Set rules
        $this->form_validation->set_rules(array(
            array(
                'field' => 'db_driver',
                'label' => 'lang:db_driver',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'hostname',
				'label'	=> 'lang:server',
				'rules'	=> 'trim|required|callback_test_db_connection'
            ),
            array(
                'field' => 'location',
                'label' => 'lang:location',
                'rules' => 'trim'.(in_array($driver, array('sqlite')) ? '|required' : ''),
            ),
            array(
                'field' => 'username',
				'label'	=> 'lang:username',
                'rules' => 'trim'
            ),
            array(
                'field' => 'password',
				'label'	=> 'lang:password',
				'rules'	=> 'trim'
            ),
            array(
                'field' => 'port',
                'label' => 'lang:port',
				'rules'	=> 'trim|required'
            ),
            array(
                'field' => 'database',
                'label' => 'lang:server_settings',
                'rules' => 'trim'.(in_array($driver, array('mysql', 'pgsql')) ? '|required' : ''),
            ),
            array(
                'field' => 'http_server',
				'label'	=> 'lang:server_settings',
				'rules'	=> 'trim|required'
            ),
        ));

        // If the form validation passed
		if ( $this->form_validation->run() )
        {
            // Set the flashdata message
            $this->session->set_flashdata('success', lang('db_success'));

            // Redirect to the second step
			$this->session->set_userdata('step_1_passed', TRUE);
            redirect('installer/step_2');
        }

        // Get supported servers
        $supported_servers      = $this->config->item('supported_servers');
        $data->server_options   = array();

        foreach ($supported_servers as $key => $server)
        {
            $data->server_options[$key] = $server['name'];
        }

        // Get the port from the session or set it to the default value when it isn't specified
        $data->port = null;
        if (in_array($driver, array('mysql', 'pgsql')))
        {
            $default_port = $this->default_ports[$driver];
            $data->port = $port ?: $default_port;
        }
        
        // Check what DB's are available
        $data->db_drivers = $this->installer_lib->check_db_extensions();

        // Work out which DB driver to show as selected
        $data->selected_db_driver = null;

        if ($this->input->post('db_driver') === null)
        {
            foreach (array('sqlite', 'pgsql', 'mysql') as $driver)
            {
                if ($data->db_drivers[$driver] === true)
                {
                    $data->selected_db_driver = $driver;
                    break;
                }
            }
        }
        else
        {
            $data->selected_db_driver = $this->input->post('db_driver');
        }

		$this->_render_view('step_1', (array) $data);
    }

    /**
     * Function to validate the database name
     *
	 * @param string $db_name The database name.
	 *
     * @return bool
     */
    public function validate_db_name($db_name)
    {
        $this->form_validation->set_message('validate_db_name', lang('invalid_db_name'));
		return ! (preg_match('/[^A-Za-z0-9_-]+/', $db_name) > 0);
    }

    /**
     * Function to test the DB connection (used for the form validation)
     *
     * @return bool
     */
    public function test_db_connection()
    {
        try {

            $this->installer_lib->create_db_connection();
        } catch (Exception $e) {
            $this->form_validation->set_message('test_db_connection', lang('db_failure') . $e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * First actual installation step
     */
    public function step_2()
    {

        // Did the user enter the DB settings ?
        if ( ! $this->session->userdata('step_1_passed'))
        {
            // Set the flashdata message
            $this->session->set_flashdata('error', lang('step1_failure'));

            redirect('');
        }

		$data = new stdClass;

		$data->mysql = new stdClass();
		$data->http_server = new stdClass();

        // Check the PHP version
		$data->php_min_version	= '5.2';
		$data->php_acceptable	= $this->installer_lib->php_acceptable($data->php_min_version);
		$data->php_version		= PHP_VERSION;

        // Check the GD data
        $data->gd_acceptable = $this->installer_lib->gd_acceptable();
        $data->gd_version = $this->installer_lib->gd_version;

        // Check to see if Zlib is enabled
		$data->zlib_enabled = $this->installer_lib->zlib_available();

        // Check to see if Curl is enabled
		$data->curl_enabled = $this->installer_lib->curl_available();

        // Get the server
        $selected_server = $this->session->userdata('http_server');
        $supported_servers = $this->config->item('supported_servers');

        $data->http_server = (object) array(
            'supported' => $this->installer_lib->verify_http_server($this->session->userdata('http_server')),
            'name' => $supported_servers[$selected_server]['name']
        );

        // Check the final results
        $data->step_passed = $this->installer_lib->check_server($data);
		
        // Skip Step 2 if it passes
        if ($data->step_passed)
        {
            $this->session->set_userdata('step_2_passed', true);
			
            redirect('installer/step_3');
        }
		
        $this->session->set_userdata('step_2_passed', $data->step_passed);

        // Load the view files

		$this->_render_view('step_2', $data);
    }

    /**
     * Another step, yay!
     */
    public function step_3()
    {
		
        if ( ! $this->session->userdata('step_1_passed') OR ! $this->session->userdata('step_2_passed'))
        {
            // Redirect the user back to step 1
            redirect('installer/step_2');
        }

        // Load the file helper
        $this->load->helper('file');

        // Get the write permissions for the folders
		$permissions = array();
		foreach($this->writable_directories as $dir)
        {
            @chmod('../'.$dir, 0777);
			$permissions['directories'][$dir] = is_really_writable('../' . $dir);
        }

		foreach($this->writable_files as $file)
        {
            @chmod('../'.$file, 0666);
			$permissions['files'][$file] = is_really_writable('../' . $file);
        }

		$data = array();
        // If all permissions are TRUE, go ahead
		$data['step_passed'] = ! in_array(false, $permissions['directories']) && !in_array(false, $permissions['files']);
		$this->session->set_userdata('step_3_passed', $data['step_passed']);

        // Skip Step 2 if it passes
		if ($data['step_passed'])
        {
            $this->session->set_userdata('step_3_passed', true);
			
            redirect('installer/step_4');
        }
		
        // View variables
		$data['permissions'] = $permissions;

		$this->_render_view('step_3', $data);
    }

    /**
     * Another step, damn thee steps, damn thee!
     */
    public function step_4()
    {
        if ( ! $this->session->userdata('step_1_passed') OR ! $this->session->userdata('step_2_passed') OR ! $this->session->userdata('step_3_passed'))
        {
            // Redirect the user back to step 2
            redirect('installer/step_2');
        }

        // Set rules
        $this->form_validation->set_rules(array(
            array(
                'field' => 'site_ref',
				'label'	=> 'lang:site_ref',
				'rules'	=> 'trim|required|alpha_dash'
            ),
            array(
                'field' => 'user[username]',
				'label'	=> 'lang:username',
				'rules'	=> 'trim|required'
            ),
            array(
                'field' => 'user[firstname]',
                'label' => 'lang:firstname',
				'rules'	=> 'trim|required'
            ),
            array(
                'field' => 'user[lastname]',
                'label' => 'lang:lastname',
				'rules'	=> 'trim|required'
            ),
            array(
                'field' => 'user[email]',
				'label'	=> 'lang:email',
				'rules'	=> 'trim|required|valid_email'
            ),
            array(
                'field' => 'user[password]',
				'label'	=> 'lang:password',
				'rules'	=> 'trim|min_length[6]|max_length[20]|required'
            ),
        ));

        // If the form validation failed (or did not run)
        if ($this->form_validation->run() === false)
        {
			$this->_render_view('step_4');
        }

        // If the form validation passed
        else
        {
            $user = $this->input->post('user');

            // Store the default username and password in the session data
            $this->session->set_userdata('user', $user);

            //define the default user email to be used in the settings module install
            define('DEFAULT_EMAIL', $user['email']);

            // Should we try creating the database?
            if ($this->session->userdata('db.create_db'));
            {
                try
                {
                    $this->installer_lib->create_db($this->session->userdata('db.database'));
                }
                catch (Exception $e) {}
            }

            try
            {
                // Install, then return valid PDO connection if it worked
                $pdb = $this->installer_lib->install($user, array(
                    'hostname'  => $this->session->userdata('db.hostname'),
                    'port'      => $this->session->userdata('db.port'),
                    'driver'    => $this->session->userdata('db.driver'), 
                    'database'  => $this->session->userdata('db.database'),
                    'username'  => $this->session->userdata('db.username'),
                    'password'  => $this->session->userdata('db.password'),
                    'site_ref'  => $this->input->post('site_ref'),
                ));
            }
            
            // Did the install fail?
            catch (Exception $e)
            {
				$this->_render_view('step_4', array('error' => $e->getMessage()));
                return;
            }

            // Success!
            $this->session->set_flashdata('success', lang('success'));

            // Import the modules
            $this->load->library('module_import', array(
                'pdb' => $pdb,
            ));

            $this->module_import->import_all();

            redirect('installer/complete');
        }
    }


    /**
     * We're done, thank God for that
     */
    public function complete()
    {
        // check if we came from step4
        if ( ! $this->session->userdata('user'))
        {
            redirect(site_url());
        }

        $server_name = $this->session->userdata('http_server');
        $supported_servers = $this->config->item('supported_servers');

        // Load our user's settings
        $data = $this->session->userdata('user');

        // Load the language labels
        $data = array_merge((array) $data, $this->lang->language);

        // Create the admin link
        $data['website_url'] = 'http://'.$this->input->server('HTTP_HOST').preg_replace('/installer\/index.php$/', '', $this->input->server('SCRIPT_NAME'));
		$data['control_panel_url'] = $data['website_url'] . ($supported_servers[$server_name]['rewrite_support'] === TRUE ? 'admin' : 'index.php/admin');

        // Let's remove our session since it contains data we don't want anyone to see
        // $this->session->sess_destroy();

		$this->_render_view('complete', $data);
    }

    /**
     * Changes the active language
     *
	 * @author	jeroenvdgulik
	 * @since	0.9.8.1
	 *
	 * @param	string $language
     */
    public function change($language)
    {
        if (in_array($language, $this->languages))
        {
            $this->session->set_userdata('language', $language);
        }

        redirect('installer');
    }

    /**
     * Sets the language and loads the corresponding language files
     *
     * @author  jeroenvdgulik
     * @since   0.9.8.1
     */
    private function _set_language()
    {
        // let's check if the language is supported
        if (in_array($this->session->userdata('language'), $this->languages))
        {
            // if so we set it
            $this->config->set_item('language', $this->session->userdata('language'));
        }

        // let's load the language file belonging to the page i.e. method
        $lang_file = $this->config->item('language') . '/' . $this->router->fetch_method() . '_lang';
		if (is_file(realpath(dirname(__FILE__) . '/../language/' . $lang_file . EXT)))
        {
            $this->lang->load($this->router->fetch_method());
        }
		$this->lang->load('global');
    }

	/**
	 * Parse the view replacing the variables found in it.
	 *
	 * @param string $view The name of the view.
	 * @param array $any,... optional, Unlimited number of variables to merge with the standard controller view variables.
	 *
	 * @return string|void
	 */
	private function _render_view($view) {
		$args = array_slice(func_get_args(), 1);
		$out = $this->lang->language;
		foreach($args as $arg) {
			if (is_array($arg)) {
				$out = array_merge($out, $arg);
			}
		}

		$this->load->view('global', array(
			'page_output' => $this->parser->parse($view, $out, true)
		));
	}
}
