<?php
/**
 * @author 		Yorick Peterse - PyroCMS development team
 * @package 	PyroCMS
 * @subpackage 	Installer
 *
 * @since 		v0.9.6.2
 *
 */
class installer_m extends Model
{
	/**
	 * @param	string $type Set or remove the cookie
	 * @param 	string $data The $_POST data
	 *
	 * Store database settings so that they can be used later on.
	 */
	function store_db_settings($type = 'set',$data)
	{
		// Set the cookie
		if($type == 'set')
		{
			// Store the POST data in a session
			$array = array('server' => $data['server'],'username' => $data['username'],'password' => $data['password'],'http_server' => $data['http_server'],'step_1_passed' => TRUE);
			$this->session->set_userdata($array);
		}
		// Remove the cookie
		else
		{
			$array = array('server','username','password','http_server','step_1_passed');
			$this->session->unset_userdata($array);
		}
	}
	
	// Functions used in Step 1 
	
	/**
	 * @return string The PHP version
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
	 * @param 	string $type The MySQL type, client or server
	 * @return 	string The MySQL version of either the server or the client
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
	 * @return bool Returns TRUE when MySQLi is installed or FALSE when it isn't.
	 *
	 * Check whether MySQLi is installed or not. Returns TRUE if it's installed or FALSE when it isn't
	 */
	function mysqli_is_installed()
	{
		// Check whether the mysqli_connect() function exists. If it doesn't it's most likely that MySQLi is not installed.
		return function_exists('mysqli_connect');
	}
	
	/**
	 * @return string The GD library version. 
	 *
	 * Function to retrieve the GD library version
	 */
	function get_gd_version()
	{
		// Get if the gd_info() function exists
		if(function_exists('gd_info'))
		{
			$gd_info = gd_info();			
			return preg_replace("/[a-z\(\)\s]/",'',$gd_info['GD Version']);
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * @param 	string $data The data that contains server related information.
	 * @return 	bool
	 *
	 * Function to validate the server settings.
	 */
	function check_server($data)
	{		
		$pass = FALSE;

		// These are the core requirements
		if($data['php_results'] == 'supported' AND $data['mysql_server'] != FALSE AND $data['mysql_client'] != FALSE AND $data['http_server']['supported'] != FALSE)
		{			
			$pass = 'partial';
		}
		
		// Optional extra
		if($pass == 'partial' AND $data['gd_version'] != FALSE AND $data['http_server']['non_apache'] != TRUE)
		{
			$pass = TRUE;
		}
		
		// Return the results
		return $pass;
	}
	
	/**
	 * @param	string $server_name The name of the HTTP server such as Abyss, Cherokee, Apache, etc
	 * @return	array
	 *
	 * Function to validate whether the specified server is a supported server. The function returns an array with two keys: supported and non_apache. 
	 * The supported key will be set to TRUE whenever the server is supported. The non_apache server will be set to TRUE whenever the user is using a server other than Apache. 
	 * This enables the system to determine whether mod_rewrite should be used or not.
	 */
	function verify_http_server($server_name)
	{
		$array 					= array('supported' => NULL,'non_apache' => FALSE);
		$servers 				= $this->config->item('supported_servers');
		$array['supported']  	= in_array($server_name,$servers);
		
		// Server other than Apache ? 
		if(strtolower($server_name) != 'apache')
		{
			$array['non_apache'] = TRUE;
		}
		
		// Return the results
		return $array;
	}
	
	/**
	 * @param 	string $path The full path to the file or folder of which the permissions should be retrieved
	 *
	 * Get the permissions of a file or folder. Return a message if it isn't writable.
	 */
	function is_writeable($path)
	{
		return is_really_writable($path);
	}
	
	/**
	 * @param 	string $data The post data
	 * 
	 * Function to validate the $_POST results from step 3
	 */
	function validate($data = array())
	{
		// Get the database settings from the form
		if(isset($data['installation_step']) AND $data['installation_step'] == 'step_1')
		{
			// Check whether the user has filled in all the required fields
			if(empty($data['server']) OR empty($data['username']))
			{
				return FALSE;
			}
			
			$hostname = $data['server'];
			$username = $data['username'];
			$password = @$data['password'];
		}
		else
		{
			$hostname = $this->session->userdata('server');
			$username = $this->session->userdata('username');
			$password = $this->session->userdata('password');
		}
		
		return @mysql_connect($hostname,$username,$password);
	}
	
	/**
	 * @param 	string $data The data from the form
	 * @return 	array
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
		
		// Write the config file.
		if(strtolower($this->session->userdata('http_server')) != 'apache')
		{
			$config_res = $this->write_config_file();
			
			if($config_res == TRUE)
			{
				return array('status' => TRUE,'message' => 'PyroCMS has been installed successfully.');
			}
			else
			{
				return array('status' => FALSE,'message' => 'The config file could not be written, are you sure the file has the correct permissions ?');
			}
		}
	}
	
	/**
	 * @param 	string $database The name of the database
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
		
		// Replace the __ variables with the data specified by the user
		$new_file  	= str_replace('__HOSTNAME__',$server,	$template);
		$new_file   = str_replace('__USERNAME__',$username,	$new_file);
		$new_file   = str_replace('__PASSWORD__',$password,	$new_file);
		$new_file   = str_replace('__DATABASE__',$database,	$new_file);
		
		// Open the database.php file, show an error message in case this returns false
		$handle 	= @fopen('../application/config/database.php','w+');
		
		// Validate the handle results
		if($handle !== FALSE)
		{
			return @fwrite($handle, $new_file);
		}
		
		return FALSE;
	}
	
	/**
	 * @return bool
	 *
	 * Writes the config file. Should only be done whenever the user is using a server other than Apache
	 */
	function write_config_file()
	{
		// Open the template
		$template = file_get_contents('application/assets/config/config.php');
		
		// Replace the __INDEX__ with index.php
		$new_file = str_replace('__INDEX__','index.php',$template);
		
		// Open the database.php file, show an error message in case this returns false
		$handle 	= @fopen('../application/config/config.php','w+');
		
		// Validate the handle results
		if($handle !== FALSE)
		{
			return @fwrite($handle, $new_file);
		}
		
		return FALSE;
	}
}
?>
