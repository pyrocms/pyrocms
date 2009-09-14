<?php
/**
 * @name 		Installer Model
 * @author 		Yorick Peterse - PyroCMS development team
 * @copyright 	Yorick Peterse - PyroCMS development team
 * @package 	PyroCMS
 * @subpackage 	Installer
 *
 * @since 		v0.9.6.2
 *
 */
class installer_m extends Model
{
	// Global functions
	
	/**
	 * @name 	store_db_settings
	 * @param	$type - Set or remove the cookie
	 * @param 	$data - The $_POST data
	 *
	 * Store database settings so that they can be used later on.
	 */
	function store_db_settings($type = 'set',$data)
	{
		// Set the cookie
		if($type == 'set')
		{
			// Store the POST data in a session
			$array = array('server' => $data['server'],'username' => $data['username'],'password' => $data['password'],'step_1_passed' => TRUE);
			$this->session->set_userdata($array);
		}
		// Remove the cookie
		else
		{
			$array = array('server','username','password', 'step_1_passed');
			$this->session->unset_userdata($array);
		}
	}
	
	// Functions used in Step 1 
	
	/**
	 * @name get_php_version()
	 * 
	 * Function to retrieve the PHP version
	 */
	function get_php_version()
	{
		// Set the PHP version
		$php_version = phpversion();
		
		// Validate the version
		if($php_version >= 5)
		{
			$php_results = 'supported';
		}
		else
		{
			$php_results = "<span class='red'>unsupported</span>";
		}
		
		// Return the results
		$array = array('php_version' => $php_version,'php_results' => $php_results);
		return $array;
	}
	
	/**
	 * @name 	get_mysql_version()
	 * @param 	$type - The MySQL type, client or server
	 * 
	 * Function to retrieve the MySQL version (client/server)
	 */
	function get_mysql_version($type = 'server')
	{
		// What do we want to return, the client or the server ? 
		if($type == 'server')
		{
			// Retrieve the database settings from the session
			$server 	= $this->session->userdata('server');
			$username 	= $this->session->userdata('username');
			$password 	= $this->session->userdata('password');
			
			// Connect to MySQL
			@mysql_connect($server,$username,$password);
			
			// Get the version
			$mysql = mysql_get_server_info();
			
			// Compare it
			if($mysql != FALSE)
			{
				// Close the connection
				@mysql_close();
				return $mysql;
			}
			else
			{
				@mysql_close();
				return "<span class='red'>a version which could not be retrieved</span>";
			}
		}
		else
		{
			// Get the version
			$mysql = mysql_get_client_info();
			// Compare it
			if($mysql != FALSE)
			{
				return $mysql;
			}
			else
			{
				return "<span class='red'>a version which could not be retrieved</span>";
			}
		}	
	}
	
	/**
	 * @name get_gd_version()
	 *
	 * Function to retrieve the GD library version
	 */
	function get_gd_version()
	{
		// Get if the gd_info() function exists
		if(function_exists('gd_info'))
		{
			$GDArray = gd_info();
			return ereg_replace('[[:alpha:][:space:]()]+', '', $GDArray['GD Version']);
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * @name 	check_server()
	 * @param 	$data - The data retrieved from other functions (above).
	 *
	 * Function to validate all the versions and create the session (if the server can run PyroCMS)
	 */
	function check_server($data)
	{		
		$pass = FALSE;
		
		// These are the core requirements
		if($data['php_results'] == 'supported' && $data['mysql_server'] != FALSE && $data['mysql_client'] != FALSE )
		{			
			$pass = 'partial';
		}
		
		// Optional extra
		if($pass == 'partial' && $data['gd_version'] != FALSE)
		{
			$pass = TRUE;
		}
		
		// Add the results to the session
		return $pass;
	}
	
	// Functions used in the second step
	
	/**
	 * @name 	is_writeable() 
	 * @param 	$path - The full path to the file or folder of which the permissions should be retrieved
	 *
	 * Get the permissions of a file or folder. Return a message if it isn't writable.
	 */
	function is_writeable($path)
	{
		return is_really_writable($path);
	}
	
	// Functions used in the third step
	
	/**
	 * @name 	validate()
	 * @param 	$data - The post data
	 * 
	 * Function to validate the $_POST results from step 3
	 */
	function validate($data = '')
	{
		// Get the database settings from the form
		if($data != '')
		{
			$hostname = $data['server'];
			$username = $data['username'];
			$password = $data['password'];
		}
		// Get the database settings from the session
		else
		{
			$hostname = $this->session->userdata('server');
			$username = $this->session->userdata('username');
			$password = $this->session->userdata('password');
		}
		
		// Test the connection	
		return @mysql_connect($hostname,$username,$password);
	}
	
	/**
	 * @name 	install()
	 * @param 	$data - The data from the form
	 *
	 * Install the PyroCMS database and write the database.php file
	 */
	function install($data)
	{		
		// Retrieve the database server, username and password from the session
		$server 	= $this->session->userdata('server');
		$username 	= $this->session->userdata('username');
		$password 	= $this->session->userdata('password');
		$database 	= $data['database'];
		
		// Create a connection using MySQLi
		$mysqli = new mysqli($server,$username,$password);
		
		// Check connection
		if($mysqli->connect_errno)
		{
			return array('status' => FALSE,'message' => 'The installer could not connect to the MySQL server or the database, be sure to enter the correct information.');
		}
		
		// Do we want to create the database using the installer ? 
		if(!empty($data['create_db']))
		{
			// Run the query
			$db_result = $mysqli->query('CREATE DATABASE IF NOT EXISTS '.$database);
			
			// Validate the results
			if($db_result === FALSE)
			{
				// Set the array and return it
				$array = array('status' => FALSE,'message' => 'The database could not be created.');
				return $array;
			}
		}
		
		// Select the database we created before
		$mysqli->select_db($database);
		
		// Now we can create the tables
		$tables 		= file_get_contents('./sql/1-tables.sql');
		$default_data 	= file_get_contents('./sql/2-default-data.sql');	
		// Do we want to insert the dummy data ? 
		if(!empty($data['dummy_data']))
		{
			$dummy_data = file_get_contents('./sql/3-dummy_data-optional.sql');		
		}
		else
		{
			$dummy_data = '';
		}
		
		// HALT ! Query time !
		$query_res	= $mysqli->multi_query($tables.$default_data.$dummy_data);
				
		// Validate the results
		if(!isset($query_res) || $query_res === FALSE)
		{
			return array('status' => FALSE,'message' => 'The installer could not create the tables or insert the data into the database. Please verify your settings.');
		}	

		// If we got this far there can't have been any errors. close and bail!
		$mysqli->close();
		
		// Write the database file
		$db_file_res = $this->write_db_file($database);
		
		if($db_file_res === FALSE)
		{
			return array('status' => FALSE,'message' => 'The database configuration file could not be written, did you cheated on the installer by skipping step 3?');
		}
		else
		{
			return array('status' => TRUE,'message' => 'PyroCMS has been installed successfully.');
		}
	}
	
	/**
	 * @name 	write_db_file();
	 * @param 	$database - The name of the database
	 *
	 * Writes the database file based on the provided database settings
	 */
	function write_db_file($database)
	{
		// First retrieve all the required data from the session and the $database variable
		$server 	= $this->session->userdata('server');
		$username 	= $this->session->userdata('username');
		$password 	= $this->session->userdata('password');
		
		// Open the template file
		$template 	= file_get_contents('application/assets/config/database.php');
		
		// Replace the %% variables with the data specified by the user
		$new_file  	= str_replace('%HOSTNAME%'	,$server,	$template);
		$new_file   = str_replace('%USERNAME%'	,$username,	$new_file);
		$new_file   = str_replace('%PASSWORD%'	,$password,	$new_file);
		$new_file   = str_replace('%DATABASE%'	,$database,	$new_file);
		
		// Open the database.php file, show an error message in case this returns false
		$handle 	= @fopen('../application/config/database.php','w+');
		
		// Validate the handle results
		if($handle !== FALSE)
		{
			return @fwrite($handle, $new_file);
		}
		
		return FALSE;
	}
}
?>