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
class Installer extends Controller 
{
	/**
	 * Array of languages supported by the installer
	 */
	private $languages	= array ('english','dutch','brazilian','polish');

	/**
	 * Array containing the directories that need to be writeable
	 *
	 * @access private
	 * @var array
	 */
	private $writeable_directories = array(
		'system/codeigniter/cache',
		'system/codeigniter/logs',
		'system/pyrocms/cache',
		'system/pyrocms/cache/dwoo',
		'system/pyrocms/cache/dwoo/compiled',
		'system/pyrocms/cache/simplepie',
		'uploads'
	);
	
	/**
	 * Array containing the files that need to be writeable
	 *
	 * @access private
	 * @var array
	 */
	private $writeable_files = array(
		'system/pyrocms/config/config.php',
		'system/pyrocms/config/database.php'
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
		if($_POST)
		{									
			// Data validation
			if( $this->installer_lib->validate() )
			{
				// Check the connection works fine
				if($this->installer_lib->test_db_connection())
				{
					// Set the flashdata message
					$this->session->set_flashdata('message', lang('db_success'));
					$this->session->set_flashdata('message_type', 'success');

					// Redirect to the first step
					$this->session->set_userdata('step_1_passed', TRUE);
					redirect('installer/step_2');
				}

				else
				{
					// Set the flashdata message
					$this->session->set_flashdata('message', lang('db_failure').mysql_error());
					$this->session->set_flashdata('message_type', 'error');

					// Redirect to the first step
					redirect('installer/step_1');
				}
			}
			
			else
			{
				// Set the flashdata message
				$this->session->set_flashdata('message', validation_errors('<span>', '</span><br />'));
				$this->session->set_flashdata('message_type', 'error');

				// Redirect to the first step
				redirect('installer/step_1');
			}
		}
		
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
	 * First actual installation step
	 * 
	 * @access public
	 * @return void
	 */
	public function step_2()
	{
		// Did the user enter the DB settings ?
		if(!$this->session->userdata('step_1_passed'))
		{	
			// Set the flashdata message
			$this->session->set_flashdata('message', lang('step1_failure'));
			$this->session->set_flashdata('message_type','error');
			
			// Redirect
			redirect('');
		}
			
		// Check the PHP version
		$data->php_version = $this->installer_lib->get_php_version();
	
		// Check the MySQL data
		$data->mysql->server_version = $this->installer_lib->get_mysql_version('server');
		$data->mysql->client_version = $this->installer_lib->get_mysql_version('client');
	
		// Check the GD data
		$data->gd_version = $this->installer_lib->get_gd_version();
		
		// Check to see if Zlib is enabled
		$data->zlib_enabled = $this->installer_lib->zlib_enabled();
		
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
		if(!$this->session->userdata('step_1_passed') OR !$this->session->userdata('step_2_passed'))
		{
			// Redirect the user back to step 1
			redirect('installer/step_2');
		}
		
		// Load the file helper
		$this->load->helper('file');
		
		// Get the write permissions for the folders
		foreach($this->writeable_directories as $dir)
		{
			$permissions['directories'][$dir] = is_really_writable('../' . $dir);
		}
		
		foreach($this->writeable_files as $file)
		{
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
		if(!$this->session->userdata('step_1_passed') OR !$this->session->userdata('step_2_passed') OR !$this->session->userdata('step_3_passed'))
		{
			// Redirect the user back to step 2
			redirect('installer/step_2');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('database',		lang('database'),	'required|trim');
		$this->form_validation->set_rules('user_name',		lang('user_name'),	'required|trim');
		$this->form_validation->set_rules('user_firstname',	lang('first_name'),	'required|trim');
		$this->form_validation->set_rules('user_lastname',	lang('last_name'),	'required|trim');
		$this->form_validation->set_rules('user_email',		lang('email'),		'required|trim|valid_email');
		$this->form_validation->set_rules('user_password',	lang('password'),	'required|trim');
		$this->form_validation->set_rules('user_confirm_password', lang('conf_password'), 'required|trim|matches[user_password]');
		$this->form_validation->set_error_delimiters('<span>','</span><br />');

		if ($this->form_validation->run() == FALSE)
		{
			$final_data['page_output'] = $this->parser->parse('step_4', $this->lang->language, TRUE);
			$this->load->view('global', $final_data);
		}
		else
		{
			// Let's load the language labels
			$data =	$this->lang->language;

			// Let's try to install the system
			$install_results = $this->installer_lib->install($_POST);

			// Did the install fail?
			if($install_results['status'] === FALSE)
			{
				// Let's tell them why the install failed
				$data['message'] = $this->lang->line('error_'.$install_results['code']) . $install_results['message'];

				$final_data['page_output'] = $this->parser->parse('step_4', $data, TRUE);
				$this->load->view('global', $final_data);
			}
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

				// Import the modules
				$this->load->library('module_import');
				$this->module_import->import_all();

				// Redirect
				redirect('installer/complete');
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

		// Able to use clean URLs?
		$admin_uri = $supported_servers[$server_name]['rewrite_support'] !== FALSE ? 'admin' : 'index.php/admin';

		// Load our user's settings
		$data = $this->session->userdata('user');

		// Load the language labels
		$data = array_merge((array) $data, $this->lang->language);

		// Create the admin link
		$data['admin_url'] = 'http://'.$this->input->server('HTTP_HOST').preg_replace('/installer\/index.php$/', $admin_uri, $this->input->server('SCRIPT_NAME'));

		//Let's remove our session since it contains data we don't want anyone to see
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
		$lang_file = $this->config->item('language') . '/' . $this->router->method . '_lang';
		if (is_file(realpath(dirname(__FILE__) . '/../language/' . $lang_file . EXT)))
		{
			$this->lang->load($this->router->method);
		}

		// also we load some generic language labels
		$this->lang->load('global');
	}
}

/* End of file installer.php */
/* Location: ./installer/controllers/installer.php */
