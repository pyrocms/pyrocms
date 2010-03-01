<?php
/**
 * @author 		Phil Sturgeon - PyroCMS development team
 * @package 	PyroCMS
 * @subpackage 	Installer
 *
 * @since 		v0.9.8
 *
 */
class Installer_lib
{
	private $ci;
	
	function __construct()
	{
		$this->ci =& get_instance();
	}
	
	/**
	 * @param	string $type Set or remove the cookie
	 * @param 	string $data The $_POST data
	 *
	 * Store database settings so that they can be used later on.
	 */
	function store_db_settings($type, $data = array())
	{
		// Set the cookie
		if($type == 'set')
		{
			// Store the POST data in a session
			$array = array('server' => $data['server'],'username' => $data['username'],'password' => $data['password'],'port' => $data['port'],'http_server' => $data['http_server'],'step_1_passed' => TRUE);
			$this->ci->session->set_userdata($array);
		}
		
		// Remove the cookie
		else
		{
			$array = array('server','username','password','http_server','step_1_passed');
			$this->ci->session->unset_userdata($array);
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
		return ($php_version >= 5) ? $php_version : FALSE;
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
			$server 	= $this->ci->session->userdata('server');
			$username 	= $this->ci->session->userdata('username');
			$password 	= $this->ci->session->userdata('password');
			
			// Connect to MySQL
			$db = @mysql_connect($server,$username,$password);
			
			// Compare it
			if(is_resource($db))
			{
				$mysql = @mysql_get_server_info($db);
				
				// Close the connection
				@mysql_close($db);
				return $mysql;
			}
			else
			{
				@mysql_close($db);
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
		if($data->php_version !== FALSE AND $data->mysql->server_version !== FALSE AND $data->mysql->client_version !== FALSE AND $data->http_server->supported != FALSE)
		{			
			$pass = 'partial';
		}
		
		// Optional extra
		if($pass == 'partial' AND $data->gd_version != FALSE)
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
		// Set all the required variables
		if($server_name == 'other')
		{
			return FALSE;
		}
		
		$supported_servers = $this->ci->config->item('supported_servers');
		return array_key_exists($server_name, $supported_servers);
	}
	
	/**
	 * @param 	string $data The post data
	 * @return 	bool
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
			
			// Get the data from the $_POST array
			$hostname = $data['server'];
			$username = $data['username'];
			$password = @$data['password'];
			$port 	  = (int) $data['port'];
		}
		
		else
		{
			$hostname = $this->ci->session->userdata('server');
			$username = $this->ci->session->userdata('username');
			$password = $this->ci->session->userdata('password');
			$port	  = $this->ci->session->userdata('port');
		}
		
		return @mysql_connect("$hostname:$port", $username, $password);
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
		$server 	= $this->ci->session->userdata('server') . ':' . $this->ci->session->userdata('port');
		$username 	= $this->ci->session->userdata('username');
		$password 	= $this->ci->session->userdata('password');
		$database 	= $data['database'];
		
		// Create a connection
		if( !$this->db = mysql_connect($server, $username, $password) )
		{
			return array('status' => FALSE,'message' => 'The installer could not connect to the MySQL server or the database, be sure to enter the correct information.');
		}
		
		// Do we want to create the database using the installer ? 
		if( !empty($data['create_db'] ))
		{
			mysql_query('CREATE DATABASE IF NOT EXISTS '.$database, $this->db);
		}
		
		// Select the database we created before
		if( !mysql_select_db($database, $this->db) )
		{
			return array('status' => FALSE,'message' => 'The database could not be found. If you asked the installer to create this database, it could have failed due to bad permissions.');
		}
		
		// HALT...! Query time!
		if( !$this->_process_schema('1-tables') )
		{
			return array('status' => FALSE,'message' => 'The installer could not add any tables to the Database.<br/><br/>' . mysql_error($this->db));
		}
		
		if( !$this->_process_schema('2-default-data') )
		{
			return array('status' => FALSE,'message' => 'The installer could not insert the data into the database.<br/><br/>' . mysql_error($this->db));
		}
			
		// If we got this far there can't have been any errors. close and bail!
		mysql_close($this->db);
		
		// Write the database file
		if( !$this->write_db_file($database) )
		{
			return array('status' => FALSE,'message' => 'The database configuration file could not be written, did you cheated on the installer by skipping step 3?');
		}
		
		// Write the config file.
		if( $this->write_config_file() )
		{
			return array('status' => TRUE,'message' => 'PyroCMS has been installed successfully.');
		}
		
		else
		{
			return array('status' => FALSE,'message' => 'The config file could not be written, are you sure the file has the correct permissions ?');
		}
	}

	private function _process_schema($schema_file)
	{
		$schema = file_get_contents('./sql/' . $schema_file . '.sql');
		$queries = explode('-- command split --', $schema);
		
		foreach($queries as $query)
		{
			$query = rtrim( trim($query), "\n;");
			
			@mysql_query($query, $this->db);
			
			if(mysql_errno($this->db) > 0)
			{
				return FALSE;
			}
		}
		
		return TRUE;
		
	}
	
	/**
	 * @param 	string $database The name of the database
	 *
	 * Writes the database file based on the provided database settings
	 */
	function write_db_file($database)
	{
		// First retrieve all the required data from the session and the $database variable
		$server 	= $this->ci->session->userdata('server');
		$username 	= $this->ci->session->userdata('username');
		$password 	= $this->ci->session->userdata('password');
		$port		= $this->ci->session->userdata('port');
		
		// Open the template file
		$template 	= file_get_contents('./assets/config/database.php');
		
		$replace = array(
			'__HOSTNAME__' 	=> $server,
			'__USERNAME__' 	=> $username,
			'__PASSWORD__' 	=> $password,
			'__DATABASE__' 	=> $database,
			'__PORT__' 		=> $port
		);
		
		// Replace the __ variables with the data specified by the user
		$new_file  	= str_replace(array_keys($replace), $replace, $template);
		
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
	 * Writes the config file.n
	 */
	function write_config_file()
	{
		// Open the template
		$template = file_get_contents('./assets/config/config.php');
		
		$server_name = $this->ci->session->userdata('http_server');
		$supported_servers = $this->ci->config->item('supported_servers');

		// Able to use clean URLs?
		if($supported_servers[$server_name]['rewrite_support'] !== FALSE)
		{
			$index_page = '';
		}
		
		else
		{
			$index_page = 'index.php';
		}
		
		// Replace the __INDEX__ with index.php or an empty string
		$new_file = str_replace('__INDEX__', $index_page, $template);
		
		// Open the database.php file, show an error message in case this returns false
		$handle = @fopen('../application/config/config.php','w+');
		
		// Validate the handle results
		if($handle !== FALSE)
		{
			return fwrite($handle, $new_file);
		}
		
		return FALSE;
	}
}
