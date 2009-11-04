<?php
/**
 * @author 		Yorick Peterse - PyroCMS development team
 * @package		PyroCMS
 * @subpackage	Installer
 *
 * @since 		v0.9.6.2
 *
 * Installer controller.
 */
class Installer extends Controller 
{
	// Index function
	function index()
	{
		// The index function doesn't do that much itself, it only displays a view file with 3 buttons : Install, Upgrade and Maintenance.
		$data['page_output'] = $this->load->view('main','',TRUE);
		
		// Load the view file
		$this->load->view('global',$data);
	}
	
	// Index function
	function step_1()
	{
		// Load the model
		$this->load->model('installer_m');
		
		// $_POST ? 
		if($_POST)
		{									
			// Check whether MySQLi is installed. Show an error message if it isn't
			if($this->installer_m->mysqli_is_installed() == FALSE)
			{
				// Set the flashdata message
				$this->session->set_flashdata('message','MySQLi isn\'t installed. You can find the manual installation instructions <a href="../../../INSTALL" title="Manual Installation Instructions" class="white">here</a>.');
				$this->session->set_flashdata('message_type','error');

				// Redirect
				redirect('installer/step_1');
			}
			
			// Data validation
			$results = $this->installer_m->validate($_POST);
			
			if($results == TRUE)
			{
				// Store the database settings
				$this->installer_m->store_db_settings('set', $_POST);
				
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
		
		// Load the config file that contains a list of supported servers
		$this->load->config('servers');
		
		// Load the views and data required for the first step
		$server_list = $this->config->item('supported_servers');
		$servers	 = array();
	
		foreach($server_list as $key => $value)
		{
			$servers[$value] = ucfirst($value);
		}
		
		$view_data['server_options'] 	= $servers;
		
		// Get the port from the session or set it to the default value when it isn't specified
		if($this->session->userdata('port'))
		{
			$view_data['port'] = $this->session->userdata('port');
		}
		else
		{
			$view_data['port'] = 3306;
		}
		
		$data['page_output']   = $this->load->view('step_1',$view_data,TRUE);
		
		// Load the view file
		$this->load->view('global',$data);
	}
	
	// Install function - First step
	function step_2()
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
			
		// Load the installer model
		$this->load->model('installer_m');
	
		// Check the PHP version
		$php_data = $this->installer_m->get_php_version();
		$view_data['php_version'] 	= $php_data['php_version'];
		$view_data['php_results'] 	= $php_data['php_results'];
	
		// Check the MySQL data
		$view_data['mysql_server'] 	= $this->installer_m->get_mysql_version('server');
		$view_data['mysql_client'] 	= $this->installer_m->get_mysql_version('client');
	
		// Check the GD data
		$view_data['gd_version'] 	= $this->installer_m->get_gd_version();
		
		// Get the server
		$view_data['http_server']	= $this->installer_m->verify_http_server($this->session->userdata('http_server'));
	
		// Check the final results
		$view_data['step_passed'] = $this->installer_m->check_server($view_data);
		$this->session->set_userdata('step_2_passed', $view_data['step_passed']);
	
		// Load the view files
		$final_data['page_output'] = $this->load->view('step_2',$view_data, TRUE);
		$this->load->view('global',$final_data);
	}
	
	// The second step 
	function step_3()
	{
		if(!$this->session->userdata('step_1_passed') OR !$this->session->userdata('step_2_passed'))
		{
			// Redirect the user back to step 1
			redirect('installer/step_2');
		}
		
		// Load the file helper
		$this->load->helper('file');
		
		// Get the write permissions for the folders
		$array['codeigniter/cache'] 				= $this->installer_m->is_writeable('../codeigniter/cache');
		$array['codeigniter/logs'] 					= $this->installer_m->is_writeable('../codeigniter/logs');
		$array['application/cache'] 				= $this->installer_m->is_writeable('../application/cache');
		$array['application/uploads'] 				= $this->installer_m->is_writeable('../application/uploads');
		$array['application/assets/img/galleries'] 	= $this->installer_m->is_writeable('../application/assets/img/galleries');
		$array['application/assets/img/products'] 	= $this->installer_m->is_writeable('../application/assets/img/products');
		$array['application/assets/img/staff'] 		= $this->installer_m->is_writeable('../application/assets/img/staff');
		$array['application/assets/img/suppliers'] 	= $this->installer_m->is_writeable('../application/assets/img/suppliers'); 
		$array['application/uploads/assets'] 		= $this->installer_m->is_writeable('../application/uploads/assets'); 
		$array['application/uploads/assets/cache'] 	= $this->installer_m->is_writeable('../application/uploads/assets/cache'); 
		
		// Get the write permissions for the files
		$array['application/config/config.php'] 	= $this->installer_m->is_writeable('../application/config/config.php'); 
		$array['application/config/database.php'] 	= $this->installer_m->is_writeable('../application/config/database.php'); 
		
		// If all permissions are TRUE, go ahead
		$view_data['step_passed'] = !in_array(FALSE, $array);
		$this->session->set_userdata('step_3_passed', $view_data['step_passed']);
		
		// View variables
		$view_data['perm_status'] 	= $array;
		
		// Load the view files
		$final_data['page_output']	= $this->load->view('step_3',$view_data, TRUE);
		$this->load->view('global', $final_data); 
	}
	
	// The third step
	function step_4()
	{
		if(!$this->session->userdata('step_1_passed') OR !$this->session->userdata('step_2_passed') OR !$this->session->userdata('step_3_passed'))
		{
			// Redirect the user back to step 2
			redirect('installer/step_2');
		}
		
		// Check to see if the user submitted the installation form
		if($_POST)
		{
			// Validate the results
			$db_results = $this->installer_m->validate();
			
			// Only install PyroCMS if the provided data is correct
			if($db_results == TRUE)
			{
				// Install the system and display the results
				$install_results = $this->installer_m->install($_POST);
				
				// Validate the results and create a flashdata message
				if($install_results['status'] == TRUE)
				{
					// Show an error message
					$this->session->set_flashdata('message', $install_results['message']);
					$this->session->set_flashdata('message_type','success');

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
		$this->load->view('global',$final_data); 
	}
	
	// All done
	function complete()
	{
		$data['admin_url'] = 'http://'.$this->input->server('SERVER_NAME').preg_replace('/installer\/index.php$/', 'index.php/admin', $this->input->server('SCRIPT_NAME'));

		// Load the view files
		$data['page_output'] = $this->load->view('complete',$data, TRUE);
		$this->load->view('global',$data); 
	}
}
?>
