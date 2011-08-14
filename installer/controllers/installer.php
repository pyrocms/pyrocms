<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Yorick Peterse - PyroCMS development team
 * @package		PyroCMS
 * @subpackage	Installer
 * @category	Application
 * @since 		v0.9.6.2
 *
 * Installer controller.
 */
class Installer extends CI_Controller
{
	/**
	 * Array of languages supported by the installer
	 */
	private $languages	= array ('arabic', 'brazilian', 'english', 'dutch', 'french', 'german', 'polish', 'chinese_traditional', 'slovenian', 'spanish', 'russian', 'greek', 'lithuanian');

	/**
	 * Array containing the directories that need to be writeable
	 *
	 * @access private
	 * @var array
	 */
	private $writeable_directories = array(
		'system/cms/cache',
		'system/cms/config',
		'addons',
		'uploads'
	);

	/**
	 * Array containing the files that need to be writeable
	 *
	 * @access private
	 * @var array
	 */
	private $writeable_files = array(
		'system/cms/config/config.php'
	);

	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the config file that contains a list of supported servers
		$this->load->config('servers');

		// Sets the language
		$this->_set_language();

		// Load form validation
		$this->load->library('form_validation');
	}

	/**
	 * Index method
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// The index function doesn't do that much itself, it only displays a view file with 3 buttons : Install, Upgrade and Maintenance.
		$data['page_output'] = $this->parser->parse('main', $this->lang->language, TRUE);

		// Load the view file
		$this->load->view('global',$data);
	}

	/**
	 * Pre installation
	 *
	 * @access public
	 * @return void
	 */
	public function step_1()
	{
		// Save this junk for later
		$this->session->set_userdata(array(
			'hostname' => $this->input->post('hostname'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'port' => $this->input->post('port'),
			'http_server' => $this->input->post('http_server')
		));

		// Set rules
		$this->form_validation->set_rules(array(
			array(
				'field' => 'hostname',
				'label'	=> 'lang:server',
				'rules'	=> 'trim|required|callback_test_db_connection'
			),
			array(
				'field' => 'username',
				'label'	=> 'lang:username',
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'password',
				'label'	=> 'lang:password',
				'rules'	=> 'trim'
			),
			array(
				'field' => 'port',
				'label'	=> 'lang:portnr',
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'http_server',
				'label'	=> 'lang:server_settings',
				'rules'	=> 'trim|required'
			)
		));

		// If the form validation passed
		if ( $this->form_validation->run() )
		{
			// Set the flashdata message
			$this->session->set_flashdata('message', lang('db_success') );
			$this->session->set_flashdata('message_type', 'success');

			// Redirect to the second step
			$this->session->set_userdata('step_1_passed', TRUE);
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

		// Load language labels
		$data = array_merge((array) $data,$this->lang->language);

		// Load the view file
		$this->load->view('global', array(
			'page_output' => $this->parser->parse('step_1', $data, TRUE)
		));
	}

	/**
	 * Function to test the DB connection (used for the form validation)
	 *
	 * @access public
	 * @return bool
	 */
	function test_db_connection()
	{
		if ( ! $this->installer_lib->test_db_connection() )
		{
			$this->form_validation->set_message('test_db_connection', lang('db_failure') . mysql_error());
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	/**
	 * First actual installation step
	 *
	 * @access public
	 * @return void
	 */
	public function step_2()
	{
		// Did the user enter the DB settings ?
		if ( ! $this->session->userdata('step_1_passed'))
		{
			// Set the flashdata message
			$this->session->set_flashdata('message', lang('step1_failure'));
			$this->session->set_flashdata('message_type','failure');

			// Redirect
			redirect('');
		}

		// Check the PHP version
		$data->php_min_version	= '5.2';
		$data->php_acceptable	= $this->installer_lib->php_acceptable($data->php_min_version);
		$data->php_version		= $this->installer_lib->php_version;

		// Check the MySQL data
		$data->mysql->server_version_acceptable = $this->installer_lib->mysql_acceptable('server');
		$data->mysql->client_version_acceptable = $this->installer_lib->mysql_acceptable('client');
		$data->mysql->server_version = $this->installer_lib->mysql_server_version;
		$data->mysql->client_version = $this->installer_lib->mysql_client_version;

		// Check the GD data
		$data->gd_acceptable = $this->installer_lib->gd_acceptable();
		$data->gd_version = $this->installer_lib->gd_version;

		// Check to see if Zlib is enabled
		$data->zlib_enabled = $this->installer_lib->zlib_enabled();

		// Check to see if Curl is enabled
		$data->curl_enabled = $this->installer_lib->curl_enabled();

		// Get the server
		$selected_server = $this->session->userdata('http_server');
		$supported_servers = $this->config->item('supported_servers');

		$data->http_server->supported = $this->installer_lib->verify_http_server($this->session->userdata('http_server'));
		$data->http_server->name = @$supported_servers[$selected_server]['name'];

		// Check the final results
		$data->step_passed = $this->installer_lib->check_server($data);
		$this->session->set_userdata('step_2_passed', $data->step_passed);

		// Load the view files
		$final_data['page_output'] = $this->load->view('step_2', $data, TRUE);
		$this->load->view('global',$final_data);
	}

	/**
	 * Another step, yay!
	 *
	 * @access public
	 * @return void
	 */
	public function step_3()
	{
		if ( ! $this->session->userdata('step_1_passed') OR !$this->session->userdata('step_2_passed'))
		{
			// Redirect the user back to step 1
			redirect('installer/step_2');
		}

		// Load the file helper
		$this->load->helper('file');

		// Get the write permissions for the folders
		foreach($this->writeable_directories as $dir)
		{
			@chmod('../'.$dir, 0777);
			$permissions['directories'][$dir] = is_really_writable('../' . $dir);
		}

		foreach($this->writeable_files as $file)
		{
			@chmod('../'.$file, 0666);
			$permissions['files'][$file] = is_really_writable('../' . $file);
		}

		// If all permissions are TRUE, go ahead
		$data->step_passed = !in_array(FALSE, $permissions['directories']) && !in_array(FALSE, $permissions['files']);
		$this->session->set_userdata('step_3_passed', $data->step_passed);

		// View variables
		$data->permissions = $permissions;

		// Load the language labels
		$data = (object) array_merge((array) $data,$this->lang->language);

		// Load the view file
		$final_data['page_output'] = $this->parser->parse('step_3', $data, TRUE);
		$this->load->view('global', $final_data);
	}

	/**
	 * Another step, damn thee steps, damn thee!
	 *
	 * @access public
	 * @return void
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
				'field' => 'database',
				'label'	=> 'lang:database',
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'site_ref',
				'label'	=> 'lang:site_ref',
				'rules'	=> 'trim|required|alpha_dash'
			),
			array(
				'field' => 'user_name',
				'label'	=> 'lang:username',
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'user_firstname',
				'label'	=> 'lang:first_name',
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'user_lastname',
				'label'	=> 'lang:last_name',
				'rules'	=> 'trim|required'
			),
			array(
				'field' => 'user_email',
				'label'	=> 'lang:email',
				'rules'	=> 'trim|required|valid_email'
			),
			array(
				'field' => 'user_password',
				'label'	=> 'lang:password',
				'rules'	=> 'trim|min_length[6]|max_length[20]|required'
			),
			array(
				'field' => 'user_confirm_password',
				'label'	=> 'lang:conf_password',
				'rules'	=> 'trim|required|matches[user_password]|callback_attempt_install'
			)
		));

		// If the form validation failed (or did not run)
		if ($this->form_validation->run() == FALSE)
		{
			$final_data['page_output'] = $this->parser->parse('step_4', $this->lang->language, TRUE);
			$this->load->view('global', $final_data);
		}

		// If the form validation passed
		else
		{
			// Success!
			$this->session->set_flashdata('message', lang('success'));
			$this->session->set_flashdata('message_type','success');

			// Store the default username and password in the session data
			$this->session->set_userdata('user', array(
				'user_email'	=> $this->input->post('user_email'),
				'user_password'	=> $this->input->post('user_password'),
				'user_firstname'=> $this->input->post('user_firstname'),
				'user_lastname'	=> $this->input->post('user_lastname')
			));

			//define the default user email to be used in the settings module install
			define('DEFAULT_EMAIL', $this->input->post('user_email'));

			// Import the modules
			$this->load->library('module_import');
			$this->module_import->import_all();

			// Redirect
			redirect('installer/complete');
		}
	}

	/**
	 * Attempt to install PyroCMS (used for form validation)
	 *
	 * @access public
	 * @return bool
	 */
	function attempt_install()
	{
		// If we do not have any validation errors so far
		if ( ! validation_errors() )
		{
			// Let's try to install the system
			$install_results = $this->installer_lib->install($_POST);

			// Did the install fail?
			if($install_results['status'] === FALSE)
			{
				// Let's tell them why the install failed
				$this->form_validation->set_message('attempt_install', $this->lang->line('error_'.$install_results['code']) . $install_results['message']);
				return FALSE;
			}

			// If the install did not fail
			else
			{
				return TRUE;
			}
		}
	}

	/**
	 * We're done, thank god for that
	 *
	 * @access public
	 * @return void
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
		$this->session->sess_destroy();

		// Load the view files
		$data['page_output'] = $this->parser->parse('complete',$data, TRUE);
		$this->load->view('global',$data);
	}

	/**
	 * Changes the active language
	 *
	 * @access	public
	 * @author	jeroenvdgulik
	 * @since	0.9.8.1
	 * @param	string $language
	 * @return	void
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
	 * @access	private
	 * @author	jeroenvdgulik
	 * @since	0.9.8.1
	 * @return	void
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

		// also we load some generic language labels
		$this->lang->load('global');

		// set the supported languages to be saved in Settings for emails and .etc
		// modules > settings > details.php uses this
		require_once(dirname(FCPATH).'/system/cms/config/language.php');

		define('DEFAULT_LANG', $config['default_language']);
	}
}

/* End of file installer.php */
/* Location: ./installer/controllers/installer.php */
