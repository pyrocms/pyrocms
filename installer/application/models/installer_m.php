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
			$array = array('server' => $data['server'],'username' => $data['username'],'password' => $data['password'],'db_stored' => true);
			$this->session->set_userdata($array);
		}
		// Remove the cookie
		else
		{
			$array = array('server' => '','username' => '','password' => '','db_stored' => '');
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
			if($mysql != false)
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
			if($mysql != false)
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
	 * @name 	check_final_results()
	 * @param 	$data - The data retrieved from other functions (above).
	 *
	 * Function to validate all the versions and create the session (if the server can run PyroCMS)
	 */
	function check_final_results($data)
	{		
		$pass = FALSE;
		
		// These are the core requirements
		if($data['php_results'] == 'supported' AND $data['mysql_server'] != FALSE AND $data['mysql_client'] != FALSE )
		{			
			$pass = 'partial';
		}
		
		// Optional extra
		if($pass == 'partial' && $data['gd_version'] != false)
		{
			$pass = TRUE;
		}
		
		// Add the results to the session
		$this->session->set_userdata('server_supported', $pass);
	}
	
	// Functions used in the second step
	
	/**
	 * @name 	get_write_permissions() 
	 * @param 	$path - The full path to the file or folder of which the permissions should be retrieved
	 *
	 * Get the permissions of a file or folder. Return a message if it isn't writable.
	 */
	function get_write_permissions($path)
	{
		if(is_writable($path))
		{
			return "- <span class='green'>Writable</span>";
		}
		else
		{
			return "- <span class='red'>Not writable</span>";
		}
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
		if(@mysql_connect($hostname,$username,$password))
		{
			return true;
		}
		else
		{
			return false;
		}	
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
		
		// First we need to create a database connection
		if(!@mysql_connect($server,$username,$password,'',65536)) // 65536 is a crazy flag that allows multiple queries in one --> And it still doesn't work as it's supposed to be, hence the preg_slit part below.
		{
			return array('status' => FALSE,'message' => 'The installer could not connect to the MySQL server, be sure to enter the correct information.');
		}
		
		// Do we want to create the database using the installer ? 
		if(!empty($data['create_db']))
		{
			// Run the query
			$db_result = mysql_query('CREATE DATABASE IF NOT EXISTS '.$data['database'].';');
			
			// Validate the results
			if($db_result == FALSE)
			{
				// Set the array and return it
				$array = array('status' => FALSE,'message' => 'The database could not be created.');
				return $array;
			}
		}
		
		// Select the database for all the other queries
		if(!@mysql_select_db($data['database']))
		{
			return array('status' => FALSE,'message' => 'The installer could not connect to the database. Does the database exist?');
		}
		
		// Select the charset (if available)
		@mysql_set_charset('utf8');
		
		// Now we can create the tables
		$tables 		= file_get_contents('application/assets/sql/1-tables.sql');
		$queries 		= preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/", $tables);
		// Loop through each query
		foreach ($queries as $query)
		{
			if (strlen(trim($query)) > 0)
			{
				$table_results =  mysql_query($query);
			}
		}
				
		// Validate the results
		if(!isset($table_results) OR $table_results == false)
		{
			return array('status' => FALSE,'message' => 'The database tables could not be inserted into the database. Does the database exist?');
		}
		
		// Insert the default data
		$default_data = file_get_contents('application/assets/sql/2-default-data.sql');		
		$queries 		= preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/",$default_data);
		// Loop through each query
		foreach ($queries as $query)
		{
			if (strlen(trim($query)) > 0)
			{
				$def_data_res =  mysql_query($query);
			}
		}
	
		// Validate the results
		if(!isset($def_data_res) OR $def_data_res == false)
		{
			return array('status' => FALSE,'message' => 'The default data could not be inserted into the database tables. Do the tables exist?');
		}
		
		// Do we want to insert the dummy data ? 
		if(!empty($data['dummy_data']))
		{
			$dummy_data 	= file_get_contents('application/assets/sql/3-dummy_data-optional.sql');		
			$queries 		= preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/",$dummy_data);
			
			// Loop through each query
			foreach ($queries as $query)
			{
				if (strlen(trim($query)) > 0)
				{
					$dummy_data_res = mysql_query($query);
				}
			}
			
			// Validate the results
			if(!isset($dummy_data_res) OR $dummy_data_res == false)
			{
				return array('status' => false,'message' => 'The dummy data could not be inserted into the database tables. Do the tables exist?');
			}
		}

		// If we got this far there can't have been any errors. close and bail!
		mysql_close();
		
		// Write the database file
		$db_file_res = $this->write_db_file($data['database']);
		
		if($db_file_res == false)
		{
			return array('status' => false,'message' => 'The database configuration file could not be written, did you cheated on the installer by skipping step 2 ?');
		}
		else
		{
			return array('status' => true,'message' => 'PyroCMS has been installed successfully.');
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
		if($handle == false)
		{
			return false;
		}
		// Continue the process
		else
		{
			// Write the file
			$write = @fwrite($handle,$new_file);
			
			// Return the results
			if($write == false)
			{
				return false;
			}
			else
			{
				// The database.php file has been written succesfully (I hope)
				return true;
			}	
		}
	}
}
?>