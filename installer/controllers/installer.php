<?php
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
	 * Array containing the directories that need to be writeable
	 *
	 * @access private
	 * @var array
	 */
	private $writeable_directories = array(
		'codeigniter/cache',
		'codeigniter/logs',
		'application/cache',
		'application/cache/dwoo',
		'application/cache/dwoo/compiled',
		'application/cache/simplepie',
		'application/uploads',
		'application/assets/img/photos',
		'application/uploads/assets',
		'application/uploads/assets/cache'
	);
	
	/**
	 * Array containing the files that need to be writeable
	 *
	 * @access private
	 * @var array
	 */
	private $writeable_files = array(
		'application/config/config.php',
		'application/config/database.php' 
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
		$data['page_output'] = $this->load->view('main','',TRUE);
		
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
			if( $this->installer_lib->validate($_POST) )
			{
				// Store the database settings
				$this->installer_lib->store_db_settings('set', $_POST);
				
				// Set the flashdata message
				$this->session->set_flashdata('message','The database settings have been stored succesfully.');
				$this->session->set_flashdata('message_type','success');

				// Redirect to the first step
				redirect('installer/step_2');
			}
			else
			{
				// Set the flashdata message
				$this->session->set_flashdata('message','The provided database settings were incorrect or could not be stored.');
				$this->session->set_flashdata('message_type','error');

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
		if($this->session->userdata('port'))
		{
			$data->port = $this->session->userdata('port');
		}
		else
		{
			$data->port = 3306;
		}
		
		// Load the view file
		$this->load->view('global', array(
			'page_output' => $this->load->view('step_1', $data, TRUE)
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
			$this->session->set_flashdata('message','Please fill in the required database settings in the form below.');
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
		
		// Load the view files
		$final_data['page_output'] = $this->load->view('step_3', $data, TRUE);
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
		
		// Check to see if the user submitted the installation form
		if($_POST)
		{
			// Do we have all the required data?
			if ( empty($_POST['user_email']) || empty($_POST['user_password']) || empty($_POST['user_confirm_password']) )
			{
				// Show an error message
				$this->session->set_flashdata('message','Please enter the details used for creating the default user');
				$this->session->set_flashdata('message_type','error');

				// Redirect
				redirect('installer/step_4');
			}
			
			// Only install PyroCMS if the provided data is correct
			if($this->installer_lib->validate() == TRUE)
			{
				if ($_POST['user_password'] == $_POST['user_confirm_password'] )
				{
					// Install the system and display the results
					$install_results = $this->installer_lib->install($_POST);

					// Validate the results and create a flashdata message
					if($install_results['status'] == TRUE)
					{
						// Show a message
						$this->session->set_flashdata('message', $install_results['message']);
						$this->session->set_flashdata('message_type','success');

						// Store the default username and password in the session data
						$this->session->set_flashdata('user', array(
							'email'			=> $this->input->post('user_email'),
							'password'		=> $this->input->post('user_password'),
							'firstname'		=> $this->input->post('user_firstname'),
							'lastname'		=> $this->input->post('user_lastname')
						));

						// Redirect
						redirect('installer/complete');
					}
					else
					{
						// Show an error message
						$this->session->set_flashdata('message', $install_results['message']);
						$this->session->set_flashdata('message_type','error');

						// Redirect
						redirect('installer/step_4');
					}
				}
				// User's passwords don't match
				else
				{
					// Show an error message
					$this->session->set_flashdata('message','The entered passwords do not match');
					$this->session->set_flashdata('message_type','error');

					// Redirect
					redirect('installer/step_4');
				}					
			}
			else
			{
				// Show an error message
				$this->session->set_flashdata('message','The installer could not connect to the MySQL server, be sure to enter the correct information.');
				$this->session->set_flashdata('message_type','error');
				
				// Redirect
				redirect('installer/step_4');
			}
		}
		
		// Load the view files
		$final_data['page_output'] = $this->load->view('step_4','', TRUE);
		$this->load->view('global', $final_data); 
	}
	
	/**
	 * We're done, thank god for that
	 * 
	 * @access public
	 * @return void
	 */
	public function complete()
	{
		$server_name = $this->session->userdata('http_server');
		$supported_servers = $this->config->item('supported_servers');

		// Able to use clean URLs?
		$admin_uri = $supported_servers[$server_name]['rewrite_support'] !== FALSE ? 'admin' : 'index.php/admin';

		$data['admin_user'] = $this->session->flashdata('user');
		$data['admin_url'] = 'http://'.$this->input->server('HTTP_HOST').preg_replace('/installer\/index.php$/', $admin_uri, $this->input->server('SCRIPT_NAME'));

		// Load the view files
		$data['page_output'] = $this->load->view('complete',$data, TRUE);
		$this->load->view('global',$data); 
	}
}