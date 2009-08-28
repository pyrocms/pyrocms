<?php
/**
 * @name 		Install controller
 * @author 		Yorick Peterse - PyroCMS development team
 * @copyright	Yorick Peterse - PyroCMS development team
 * @package		PyroCMS
 * @subpackage	Installer
 *
 * @since 		v0.9.6.2
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
		// $_POST ? 
		if($_POST)
		{
			// Load the model
			$this->load->model('installer_m');
			
			// First we validate the data
			$results = $this->installer_m->validate($_POST);
			
			if($results == TRUE)
			{
				// Store the database settings
				$this->installer_m->store_db_settings('set',$_POST);
				
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
		
		// The index function doesn't do that much itself, it only displays a view file with 3 buttons : Install, Upgrade and Maintenance.
		$data['page_output'] = $this->load->view('install_1','',TRUE);
		
		// Load the view file
		$this->load->view('global',$data);
	}
	
	// Install function - First step
	function step_2()
	{
		// Did the user enter the DB settings ?
		if($this->session->userdata('db_stored') == TRUE)
		{	
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
		
			// Check the final results
			$this->installer_m->check_final_results($view_data);
			$view_data['server_supported'] = $this->session->userdata('server_supported');
		
			// Load the view files
			$final_data['page_output'] = $this->load->view('install_2',$view_data, TRUE);
			$this->load->view('global',$final_data);
		}
		else
		{
			// Set the flashdata message
			$this->session->set_flashdata('message','Please fill in the required database settings in the form below.');
			$this->session->set_flashdata('message_type','error');
			
			// Redirect
			redirect('');
		}
	}
	
	// The second step 
	function step_3()
	{
		if($this->session->userdata('server_supported') == TRUE AND $this->session->userdata('db_stored') == TRUE)
		{
			// Load the file helper
			$this->load->helper('file');
			
			// Get the write permissions for the folders
			$array['codeigniter/cache'] 				= $this->installer_m->get_write_permissions('../codeigniter/cache');
			$array['codeigniter/logs'] 					= $this->installer_m->get_write_permissions('../codeigniter/logs');
			$array['application/cache'] 				= $this->installer_m->get_write_permissions('../application/cache');
			$array['application/uploads'] 				= $this->installer_m->get_write_permissions('../application/uploads');
			$array['application/assets/img/galleries'] 	= $this->installer_m->get_write_permissions('../application/assets/img/galleries');
			$array['application/assets/img/products'] 	= $this->installer_m->get_write_permissions('../application/assets/img/products');
			$array['application/assets/img/staff'] 		= $this->installer_m->get_write_permissions('../application/assets/img/staff');
			$array['application/assets/img/suppliers'] 	= $this->installer_m->get_write_permissions('../application/assets/img/suppliers'); 
			
			// Get the write permissions for the files
			$array['application/config/config.php'] 	= $this->installer_m->get_write_permissions('../application/config/config.php'); 
			$array['application/config/database.php'] 	= $this->installer_m->get_write_permissions('../application/config/database.php'); 
			
			// View variables
			$view_data['perm_status'] 	= $array;
			
			// Load the view files
			$final_data['page_output']	= $this->load->view('install_3',$view_data, TRUE);
			$this->load->view('global',$final_data); 
		}
		else
		{
			// Redirect the user back to step 1
			redirect('installer/step_2');
		}
	}
	
	// The third step
	function step_4()
	{
		if($this->session->userdata('server_supported') == TRUE AND $this->session->userdata('db_stored') == TRUE)
		{			
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
						$this->session->set_flashdata('message',$install_results['message']);
						$this->session->set_flashdata('message_type','success');

						// Redirect
						redirect('installer/complete');
					}
					else
					{
						// Show an error message
						$this->session->set_flashdata('message',$install_results['message']);
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
			$final_data['page_output'] = $this->load->view('install_4','', TRUE);
			$this->load->view('global',$final_data); 
		}
		else
		{
			// Redirect the user back to step 1
			redirect('installer/step_2');
		}
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