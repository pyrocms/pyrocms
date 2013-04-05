<?php defined('BASEPATH') or exit('No direct script access allowed');

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

	/** Success or Error messages to output **/
	public $messages = array();

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

		if ($this->session->userdata('language'))
		{
			$this->config->set_item('language', $this->session->userdata('language'));
		}
		$current_language = $this->config->item('language');

		// let's load the language file belonging to the page i.e. method
		if (is_file($this->languages_directory.'/'.$current_language.'/'.$this->router->fetch_method().'_lang'.EXT))
		{
			$this->lang->load($this->router->fetch_method());
		}

		// Load the global installer language file
		$this->lang->load('global');

		// set the supported languages to be saved in Settings for emails and .etc
		// modules > settings > details.php uses this
		require_once(dirname(FCPATH).'/system/cms/config/language.php');

		// Check that the language configuration has been loaded.
		isset($config) or exit('Could not load language configuration.');

		// Define the default language code as constant
		define('DEFAULT_LANG', $config['default_language']);

		$action_url = site_url('installer/change/__NAME__');
		$image_url = base_url('assets/images/flags/__CODE__.gif');
		// Work out some misrepresented language codes to specific language flags
		$flag_exchange = array(
			'english' => 'gb',
			'chinese_simplified' => 'cn',
			'chinese_traditional' => 'cn',
			'danish' => 'dk',
			'czech' => 'cz',
		);
		// Generate the language array for the navigation.
		foreach($config['supported_languages'] as $code => $info) {
			// There is a translation available and we haven't already put that in there.
			if (in_array($info['folder'], $this->languages) && ! array_key_exists($info['folder'], $this->language_nav)) {
				$this->language_nav[$info['folder']] = array(
					'code' => $code,
					'folder' => $info['folder'],
					'name' => $info['name'],
					'action_url' => str_replace('__NAME__', $info['folder'], $action_url),
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
		$this->_render_view('main');
	}

	/**
	 * Pre installation
	 */
	public function step_1()
	{
		$data = new stdClass();

		// Save this junk for later
		$this->session->set_userdata(array(
			'database' => $this->input->post('database'),
			'hostname' => $this->input->post('hostname'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'port' => $this->input->post('port'),
			'http_server' => $this->input->post('http_server')
		));

		// Set rules
		$this->form_validation->set_rules(array(
			array(
				'field' => 'database',
				'label'	=> 'lang:database',
				'rules'	=> 'trim|required|callback_validate_mysql_db_name'
			),
			array(
				'field' => 'hostname',
				'label' => 'lang:server',
				'rules' => 'trim|required|callback_test_db_connection'
			),
			array(
				'field' => 'username',
				'label' => 'lang:username',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'password',
				'label' => 'lang:password',
				'rules' => 'trim'
			),
			array(
				'field' => 'port',
				'label' => 'lang:portnr',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'http_server',
				'label' => 'lang:server_settings',
				'rules' => 'trim|required'
			)
		));

		// If the form validation passed
		if ($this->form_validation->run())
		{
			// Set the flashdata message
			$this->session->set_flashdata('message', lang('db_success'));
			$this->session->set_flashdata('message_type', 'success');

			// Redirect to the second step
			$this->session->set_userdata('step_1_passed', true);
			redirect('installer/step_2');
		}

		// Get supported servers
		$supported_servers 		= $this->config->item('supported_servers');
		$data->server_options 	= array();

		foreach($supported_servers as $key => $server)
		{
			$data->server_options[$key] = $server['name'];
		}

		// Get the port from the session or set it to the default value when it isn't specified
		$data->port = $this->session->userdata('port') ? $this->session->userdata('port') : 3306;

		$this->_render_view('step_1', (array) $data);
	}

	/**
	 * Function to validate the database name
	 *
	 * @param string $db_name The database name.
	 *
	 * @return bool
	 */
	public function validate_mysql_db_name($db_name)
	{
		$this->form_validation->set_message('validate_mysql_db_name', lang('invalid_db_name'));
		return ! (preg_match('/[^A-Za-z0-9_-]+/', $db_name) > 0);
	}

	/**
	 * Function to test the DB connection (used for the form validation)
	 *
	 * @return bool
	 */
	public function test_db_connection()
	{
		if ( ! $this->installer_lib->mysql_available())
		{
			$this->form_validation->set_message('test_db_connection', lang('db_missing'));

			return false;
		}
		if ( ! $this->installer_lib->test_db_connection())
		{
			$this->form_validation->set_message('test_db_connection', lang('db_failure').mysql_error());

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
			$this->session->set_flashdata('message', lang('step1_failure'));
			$this->session->set_flashdata('message_type', 'failure');

			redirect('');
		}

		$data = new stdClass;

		// Check the PHP version
		$data->php_min_version	= '5.2';
		$data->php_acceptable	= $this->installer_lib->php_acceptable();
		$data->php_running_version	= PHP_VERSION;

		// Check the MySQL data
		$data->server_version_acceptable = $this->installer_lib->mysql_acceptable('server');
		$data->client_version_acceptable = $this->installer_lib->mysql_acceptable('client');
		$data->server_version = $this->installer_lib->mysql_server_version;
		$data->client_version = $this->installer_lib->mysql_client_version;

		// Check the GD data
		$data->gd_acceptable = $this->installer_lib->gd_acceptable();
		$data->gd_running_version = $this->installer_lib->gd_version;

		// Check to see if Zlib is enabled
		$data->zlib_enabled = $this->installer_lib->zlib_available();

		// Check to see if Curl is enabled
		$data->curl_enabled = $this->installer_lib->curl_available();

		// Get the server
		$selected_server = $this->session->userdata('http_server');
		$supported_servers = $this->config->item('supported_servers');

		$data->http_server_supported = $this->installer_lib->verify_http_server($this->session->userdata('http_server'));
		$data->http_server_name = @$supported_servers[$selected_server]['name'];

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

		$this->_render_view('step_2', (array)$data);
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
		foreach ($this->writable_directories as $dir)
		{
			@chmod('../'.$dir, 0777);
			$permissions['directories'][$dir] = is_really_writable('../'.$dir);
		}

		foreach ($this->writable_files as $file)
		{
			@chmod('../'.$file, 0666);
			$permissions['files'][$file] = is_really_writable('../'.$file);
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
				'label' => 'lang:site_ref',
				'rules' => 'trim|required|alpha_dash'
			),
			array(
				'field' => 'user_name',
				'label' => 'lang:user_name',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'user_firstname',
				'label' => 'lang:first_name',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'user_lastname',
				'label' => 'lang:last_name',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'user_email',
				'label' => 'lang:email',
				'rules' => 'trim|required|valid_email'
			),
			array(
				'field' => 'user_password',
				'label' => 'lang:password',
				'rules' => 'trim|min_length[6]|max_length[20]|required'
			),
		));

		// If the form validation failed (or did not run)
		if ($this->form_validation->run() == false)
		{
			$this->_render_view('step_4');
		}

		// If the form validation passed
		else
		{
			// Let's try to install the system
			$install = $this->installer_lib->install($_POST);

			// Did the install fail?
			if ($install['status'] === false)
			{
				// Let's tell them why the install failed
				$this->messages['error'] = $this->lang->line('error_'.$install['code']).$install['message'];

				$this->_render_view('step_4');
			}
			else
			{
				// Success!
				$this->session->set_flashdata('message', lang('success'));
				$this->session->set_flashdata('message_type', 'success');

				// Store the default username and password in the session data
				$this->session->set_userdata('user', array(
					'user_email' => $this->input->post('user_email'),
					'user_password' => $this->input->post('user_password'),
					'user_firstname' => $this->input->post('user_firstname'),
					'user_lastname' => $this->input->post('user_lastname')
				));

				// Define the default user email to be used in the settings module install
				define('DEFAULT_EMAIL', $this->input->post('user_email'));

				// Import the modules
				$this->load->library('module_import');
				$this->module_import->import_all();

				redirect('installer/complete');
			}
		}
	}


	/**
	 * We're done, thank god for that
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

		if (in_array($language, $this->languages))
		{
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
		if ($this->languages_directory === '../language/')
		{
			$this->languages_directory = realpath(dirname(__FILE__).'/'.$this->languages_directory);
		}

		// Get the supported language array populated
		if (empty($this->languages))
		{
			foreach (glob($this->languages_directory.'/*', GLOB_ONLYDIR) as $path)
			{
				$path = basename($path);

				if ( ! in_array($path, array('.', '..')))
				{
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
		
		foreach($args as $arg)
		{
			if (is_array($arg))
			{
				$out = array_merge($out, $arg);
			}
		}

		$this->load->view('global', array(
			'page_output' => $this->parser->parse($view, $out, true)
		));
	}
}