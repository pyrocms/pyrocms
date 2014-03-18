<?php

use Pyro\Cache\CacheManager;
use Pyro\Module\Addons\ThemeManager;
use Pyro\Module\Addons\WidgetManager;

// This is for using the the settings library in PyroCMS when installing.
// This is a copy of the function that exists in system/cms/core/My_Controller.php
function ci()
{
    return get_instance();
}

/**
 * Installer controller.
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Installer\Controllers
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
    private $languages = array();

    /** @var array Directories that need to be writable */
    private $writable_directories = array(
        'system/cms/cache',
        'system/cms/config',
        'addons',
        'assets/cache',
        'uploads',
        'system/cms/modules/streams_core/models',
    );

    /** @var array Files that need to be writable */
    private $writable_files = array(
        'system/cms/config/config.php'
    );

    /** @var string The translations directory */
    private $languages_directory = '../language/';

    /** @var array The view variables for creating the language menu */
    private $language_nav = array();

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

        // Get the supported languages
        $this->_discover_languages();

        if ($this->session->userdata('language')) {
            $this->config->set_item('language', $this->session->userdata('language'));
        }
        $current_language = $this->config->item('language');

        // Load the global installer language file
        $this->lang->load('installer');

        define('SITE_REF', 'default');

        // Where is PyroCMS installed?
        define('PYROPATH', dirname(FCPATH).'/system/cms/');
        define('ADDONPATH', dirname(FCPATH).'/addons/'.SITE_REF.'/');
        define('SHARED_ADDONPATH', dirname(FCPATH).'/addons/shared_addons/');

        // Let us load stuff from the main application
        $this->load->add_package_path(PYROPATH);

        // set the supported languages to be saved in Settings for emails and .etc
        // modules > settings > details.php uses this
        require_once(PYROPATH.'/config/language.php');

        // Check that the language configuration has been loaded.
        isset($config) or exit('Could not load language configuration.');

        // Define the default language code as constant
        define('DEFAULT_LANG', $config['default_language']);

        $image_url = base_url('assets/img/flags/__CODE__.gif');

        // Work out some misrepresented language codes to specific language flags
        $flag_exchange = array(
            'english' => 'gb',
            'chinese_simplified' => 'cn',
            'chinese_traditional' => 'cn',
            'danish' => 'dk',
            'czech' => 'cz',
        );

        // Generate the language array for the navigation.
        foreach ($config['supported_languages'] as $code => $info) {
            // There is a translation available and we haven't already put that in there.
            if (in_array($info['folder'], $this->languages) && ! array_key_exists($info['folder'], $this->language_nav)) {
                $this->language_nav[$info['folder']] = array(
                    'code' => $code,
                    'folder' => $info['folder'],
                    'name' => $info['name'],
                    'action_url' => site_url('installer/change/'.$info['folder']),
                    'image_url' => str_replace('__CODE__', (in_array($info['folder'], array_keys($flag_exchange))) ? $flag_exchange[$info['folder']] : $code, $image_url),
                );
            }
        }

        ksort($this->language_nav);

        // Load form validation library
        $this->load->library('form_validation');
    }

    /**
     * Index method
     */
    public function index()
    {
        $data = new stdClass;

        // TODO No idea why this is here. Potentially lazy passing of data to ajax.php
        $this->session->set_userdata('http_server', $this->input->post('http_server'));

        $driver    = $this->input->post('db_driver');
        $hostname  = $this->input->post('hostname');
        $location  = $this->input->post('location');
        $username  = $this->input->post('username');
        $password  = $this->input->post('password');
        $port      = $this->input->post('port');
        $database  = $this->input->post('database');

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
                'rules' => 'trim'.(in_array($driver, array('mysql', 'pgsql')) ? '|required' : '')
            ),
            array(
                'field' => 'password',
                'label'	=> 'lang:password',
                'rules'	=> 'trim'
            ),
            array(
                'field' => 'port',
                'label' => 'lang:port',
                'rules'	=> 'trim'.(in_array($driver, array('mysql', 'pgsql')) ? '|required' : '')
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
        if ($this->form_validation->run()) {
            // Set the flashdata message
            $this->session->set_flashdata('success', lang('db_success'));

            // Redirect to the second step
            $this->session->set_userdata('step_1_passed', TRUE);
            redirect('installer/step_2');
        }

        // Get supported servers
        $supported_servers      = $this->config->item('supported_servers');
        $data->server_options   = array();

        foreach ($supported_servers as $key => $server) {
            $data->server_options[$key] = $server['name'];
        }

        // Get the port from the session or set it to the default value when it isn't specified
        $data->port = $port;

        // Check what DB's are available
        $data->db_drivers = $this->installer_lib->check_db_extensions();

        // Work out which DB driver to show as selected
        $data->selected_db_driver = null;

        if ($this->input->post('db_driver') === null) {
            foreach (array('sqlite', 'pgsql', 'mysql') as $driver) {
                if ($data->db_drivers[$driver] === true) {
                    $data->selected_db_driver = $driver;
                    break;
                }
            }
        } else {
            $data->selected_db_driver = $this->input->post('db_driver');
        }

        $this->_render_view('step_1', (array) $data);
    }

    /**
     * Function to test the DB connection (used for the form validation)
     *
     * @return bool
     */
    public function test_db_connection()
    {
        $db_config = array(
            'driver'    => $this->input->post('db_driver'),
            'database'  => $this->input->post('database'),
            'location'  => $this->input->post('location'),
            'hostname'  => $this->input->post('hostname'),
            'port'      => $this->input->post('port'),
            'username' 	=> $this->input->post('username'),
            'password' 	=> $this->input->post('password'),
            'create_db' => $this->input->post('create_db'),
            'site_ref'  => 'default',
        );

        // Store this for later
        $this->session->set_userdata('db_config', $db_config);

        try {
            // Create a connection to see if data is correct
            $this->installer_lib->create_connection($db_config);
        } catch (Exception $e) {
            $this->form_validation->set_message('test_db_connection', lang('db_failure').$e->getMessage());
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
        if ( ! $this->session->userdata('step_1_passed')) {
            // Set the flashdata message
            $this->session->set_flashdata('message', lang('step1_failure'));
            $this->session->set_flashdata('message_type', 'failure');

            redirect('');
        }

        $data = new stdClass;

        // Check the PHP version
        $data->php_acceptable	= $this->installer_lib->php_acceptable();
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

        $data->http_server = new stdClass;
        $data->http_server->supported = $this->installer_lib->verify_http_server($this->session->userdata('http_server'));
        $data->http_server->name = @$supported_servers[$selected_server]['name'];

        // Check the final results
        $data->step_passed = $this->installer_lib->check_server($data);

        // Skip Step 2 if it passes
        if ($data->step_passed) {
            $this->session->set_userdata('step_2_passed', true);

            redirect('installer/step_3');
        }

        $this->session->set_userdata('step_2_passed', $data->step_passed);

        // Load the view files

        $this->_render_view('step_2', (array) $data);
    }

    /**
     * Another step, yay!
     */
    public function step_3()
    {
        if ( ! $this->session->userdata('step_1_passed') OR ! $this->session->userdata('step_2_passed')) {
            // Redirect the user back to step 1
            redirect('installer/step_2');
        }

        // Load the file helper
        $this->load->helper('file');

        // Get the write permissions for the folders
        $permissions = array();
        foreach ($this->writable_directories as $dir) {
            @chmod('../'.$dir, 0777);
            $permissions['directories'][$dir] = is_really_writable('../'.$dir);
        }

        foreach ($this->writable_files as $file) {
            @chmod('../'.$file, 0666);
            $permissions['files'][$file] = is_really_writable('../'.$file);
        }

        $data = array();
        // If all permissions are TRUE, go ahead
        $data['step_passed'] = ! in_array(false, $permissions['directories']) && !in_array(false, $permissions['files']);
        $this->session->set_userdata('step_3_passed', $data['step_passed']);

        // Skip Step 2 if it passes
        if ($data['step_passed']) {
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
        if ( ! $this->session->userdata('step_1_passed') OR ! $this->session->userdata('step_2_passed') OR ! $this->session->userdata('step_3_passed')) {
            // Redirect the user back to step 2
            redirect('installer/step_2');
        }

        // Set rules
        $this->form_validation->set_rules(array(
            array(
                'field' => 'user[username]',
                'label' => 'lang:user_name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'user[firstname]',
                'label' => 'lang:first_name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'user[lastname]',
                'label' => 'lang:last_name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'user[email]',
                'label' => 'lang:email',
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'user[password]',
                'label' => 'lang:password',
                'rules' => 'trim|min_length[6]|max_length[50]|required'
            ),
        ));

        // If the form validation failed (or did not run)
        if ($this->form_validation->run() == false) {
            $this->_render_view('step_4');
        }

        // If the form validation passed
        else {
            // Grab the connection config from the session
            $db_config = $this->session->userdata('db_config');

            // First User details
            $user = $this->input->post('user');

            // Create the database if that is what they asked us to do
            if ( ! empty($db_config['create_db'])) {
                // Create an PDO connection and instance
                $pdo = $this->installer_lib->create_connection($db_config);

                // Make the database
                $this->installer_lib->create_db($pdo, $db_config['database']);
            }

            // Let's try to install the system with this new PDO instance
            try {
                $pdb = $this->installer_lib->install($user, $db_config);
            } catch (InstallerException $e) {

                $this->_render_view('step_4', array(
                    'messages' => array(
                        'error' => $e->getMessage(),
                    )
                ));

                return;
            }

            // Success!
            $this->session->set_flashdata('success', lang('success'));

            // Store the default username and password in the session data
            $this->session->set_userdata('user', $user);

            // Define the default user email to be used in the settings module install
            define('DEFAULT_EMAIL', $this->input->post('user_email'));

            // Import the modules
            $this->load->library('module_import', array(
                'pdb' => $pdb,
            ));

            $this->module_import->import_all();

            $themeManager = new ThemeManager();
            $themeManager->setLocations(array(
                PYROPATH.'themes/',
            ));

            $themeManager->registerUnavailableThemes();

            $widgetManager = new WidgetManager();
            $widgetManager->setLocations(array(
                PYROPATH.'widgets/',
            ));
            $widgetManager->registerUnavailableWidgets();

            redirect('installer/complete');
        }
    }


    /**
     * We're done, thank god for that
     */
    public function complete()
    {
        // check if we came from step4
        if ( ! $this->session->userdata('user')) {
            redirect(site_url());
        }

        $server_name = $this->session->userdata('http_server');
        $supported_servers = $this->config->item('supported_servers');

        // Load our user's settings
        $data = $this->session->userdata('user');

        // Create the admin link
        $data['website_url'] = 'http://'.$this->input->server('HTTP_HOST').preg_replace('/installer\/index.php$/', '', $this->input->server('SCRIPT_NAME'));
        $data['control_panel_url'] = $data['website_url'].($supported_servers[$server_name]['rewrite_support'] === true ? 'admin' : 'index.php/admin');

        // Let's remove our session since it contains data we don't want anyone to see
        $this->session->sess_destroy();

        $this->_render_view('complete', $data);
    }

    /**
     * Changes the active language
     *
     * @author    jeroenvdgulik
     * @since     0.9.8.1
     *
     * @param    string $language
     */
    public function change($language)
    {
        $this->_discover_languages();

        if (in_array($language, $this->languages)) {
            $this->session->set_userdata('language', $language);
        }

        redirect('installer');
    }

    /**
     * Set up class properties related to translations.
     *
     * Populates the supported languages array and sets the
     * installer translations directory as an absolute path
     */
    private function _discover_languages()
    {
        // Convert the translation directory path to absolute
        if ($this->languages_directory === '../language/') {
            $this->languages_directory = realpath(dirname(__FILE__).'/'.$this->languages_directory);
        }

        // Get the supported language array populated
        if (empty($this->languages)) {
            foreach (glob($this->languages_directory.'/*', GLOB_ONLYDIR) as $path) {
                $path = basename($path);

                if ( ! in_array($path, array('.', '..'))) {
                    $this->languages[] = $path;
                }
            }
        }
    }

    /**
     * Parse the view replacing the variables found in it.
     *
     * @param string $view The name of the view.
     * @param array $any,... optional, Unlimited number of variables to merge with the standard controller view variables.
     *
     * @return string|void
     */
    private function _render_view($view)
    {
        $args = array_slice(func_get_args(), 1);
        $out = array_merge($this->lang->language, array('language_nav' => $this->language_nav));

        foreach ($args as $arg) {
            if (is_array($arg)) {
                $out = array_merge($out, $arg);
            }
        }

        $this->load->view('global', array(
            'page_output' => $this->parser->parse($view, $out, true)
        ));
    }
}
