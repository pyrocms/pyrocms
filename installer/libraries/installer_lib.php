<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon - PyroCMS development team
 * @author 		Victor Michnowicz
 * @package 	PyroCMS
 * @subpackage 	Installer
 *
 * @since 		v0.9.8
 *
 */
class Installer_lib {

	private $ci;
	public $php_version;
	public $mysql_server_version;
	public $mysql_client_version;
	public $gd_version;

	function __construct()
	{
		$this->ci =& get_instance();
	}

	// Functions used in Step 1

	/**
	 * @return bool
	 *
	 * Function to see if the PHP version is acceptable (at least version 5)
	 */
	function php_acceptable($version = NULL)
	{
		// Set the PHP version
		$this->php_version = phpversion();

		// Is this version of PHP greater than minimum version required?
		return ( version_compare(PHP_VERSION, $version, '>=') ) ? TRUE : FALSE;
	}


	/**
	 * @param 	string $type The MySQL type, client or server
	 * @return 	string The MySQL version of either the server or the client
	 *
	 * Function to retrieve the MySQL version (client/server)
	 */
	public function mysql_acceptable($type = 'server')
	{
		// Server version
		if ($type == 'server')
		{
			// Retrieve the database settings from the session
			$server 	= $this->ci->session->userdata('hostname') . ':' . $this->ci->session->userdata('port');
			$username 	= $this->ci->session->userdata('username');
			$password 	= $this->ci->session->userdata('password');

			// Connect to MySQL
			if ( $db = @mysql_connect($server,$username,$password) )
			{
				$this->mysql_server_version = @mysql_get_server_info($db);

				// Close the connection
				@mysql_close($db);

				// If the MySQL server version is at least version 5 return TRUE, else FALSE
				return ($this->mysql_server_version >= 5) ? TRUE : FALSE;
			}
			else
			{
				@mysql_close($db);
				return FALSE;
			}
		}

		// Client version
		else
		{
			// Get the version
			$this->mysql_client_version = preg_replace('/[^0-9\.]/','', mysql_get_client_info());

			// If the MySQL client version is at least version 5 return TRUE, else FALSE
			return ($this->mysql_client_version >= 5) ? TRUE : FALSE;
		}
	}

	/**
	 * @return string The GD library version.
	 *
	 * Function to retrieve the GD library version
	 */
	public function gd_acceptable()
	{
		// Get if the gd_info() function exists
		if (function_exists('gd_info'))
		{
			$gd_info = gd_info();
			$this->gd_version = preg_replace('/[^0-9\.]/','',$gd_info['GD Version']);

			// If the GD version is at least 1.0 return TRUE, else FALSE
			return ($this->gd_version >= 1) ? TRUE : FALSE;
		}

		// Homeboy is not rockin GD at all
		else
		{
			return FALSE;
		}
	}

	/**
	 * @return bool
	 *
	 * Function to check if zlib is installed
	 */
	public function zlib_enabled()
	{
		return extension_loaded('zlib');
	}

	/**
	 * @param 	string $data The data that contains server related information.
	 * @return 	bool
	 *
	 * Function to validate the server settings.
	 */
	public function check_server($data)
	{
		// Check PHP
		if ( ! $this->php_acceptable() )
		{
			return FALSE;
		}

		// Check MySQL server
		if ( ! $this->mysql_acceptable('server') )
		{
			return FALSE;
		}

		// Check MySQL client
		if ( ! $this->mysql_acceptable('client') )
		{
			return FALSE;
		}

		if ($data->http_server->supported === FALSE)
		{
			return FALSE;
		}

		// If PHP, MySQL, etc is good but either server, GD, and/or Zlib is unknown, say partial
		if ( $data->http_server->supported === 'partial' || $this->gd_acceptable() === FALSE || $this->zlib_enabled() === FALSE)
		{
			return 'partial';
		}

		// Must be fine
		return TRUE;

	}

	/**
	 * @param	string $server_name The name of the HTTP server such as Abyss, Cherokee, Apache, etc
	 * @return	array
	 *
	 * Function to validate whether the specified server is a supported server. The function returns an array with two keys: supported and non_apache.
	 * The supported key will be set to TRUE whenever the server is supported. The non_apache server will be set to TRUE whenever the user is using a server other than Apache.
	 * This enables the system to determine whether mod_rewrite should be used or not.
	 */
	public function verify_http_server($server_name)
	{
		// Set all the required variables
		if ($server_name == 'other')
		{
			return 'partial';
		}

		$supported_servers = $this->ci->config->item('supported_servers');

		return array_key_exists($server_name, $supported_servers);
	}

	/**
	 * @return 	mixed
	 *
	 * Make sure we can connect to the database
	 */
	public function test_db_connection()
	{
		$hostname = $this->ci->session->userdata('hostname');
		$username = $this->ci->session->userdata('username');
		$password = $this->ci->session->userdata('password');
		$port	  = $this->ci->session->userdata('port');

		return @mysql_connect("$hostname:$port", $username, $password);
	}

	/**
	 * @param 	string $data The data from the form
	 * @return 	array
	 *
	 * Install the PyroCMS database and write the database.php file
	 */
	public function install($data)
	{
		// Retrieve the database server, username and password from the session
		$server 	= $this->ci->session->userdata('hostname') . ':' . $this->ci->session->userdata('port');
		$username 	= $this->ci->session->userdata('username');
		$password 	= $this->ci->session->userdata('password');
		$database 	= $data['database'];

		// User settings
		$user_salt		= substr(md5(uniqid(rand(), true)), 0, 5);
		$data['user_password'] 	= sha1($data['user_password'] . $user_salt);

		// Include migration config to know which migration to start from
		include '../system/cms/config/migrations.php';

		// Get the SQL for the default data and parse it
		$user_sql = file_get_contents('./sql/default.sql');
		$user_sql = str_replace('{PREFIX}', $data['site_ref'].'_', $user_sql);
		$user_sql = str_replace('{EMAIL}', $data['user_email'], $user_sql);
		$user_sql = str_replace('{USER-NAME}', mysql_escape_string($data['user_name']), $user_sql);
		$user_sql = str_replace('{DISPLAY-NAME}', mysql_escape_string($data['user_firstname'] . ' ' . $data['user_lastname']), $user_sql);
		$user_sql = str_replace('{PASSWORD}', mysql_escape_string($data['user_password']), $user_sql);
		$user_sql = str_replace('{FIRST-NAME}', mysql_escape_string($data['user_firstname']), $user_sql);
		$user_sql = str_replace('{LAST-NAME}', mysql_escape_string($data['user_lastname']) , $user_sql);
		$user_sql = str_replace('{SALT}', $user_salt, $user_sql);
		$user_sql = str_replace('{NOW}', time(), $user_sql);
		$user_sql = str_replace('{MIGRATION}', $config['migrations_version'], $user_sql);

		// Create a connection
		if ( ! $this->db = mysql_connect($server, $username, $password) )
		{
			return array('status' => FALSE,'message' => 'The installer could not connect to the MySQL server or the database, be sure to enter the correct information.');
		}

		// Do we want to create the database using the installer ?
		if ( ! empty($data['create_db'] ))
		{
			mysql_query('CREATE DATABASE IF NOT EXISTS '.$database, $this->db);
		}

		// Select the database we created before
		if ( !mysql_select_db($database, $this->db) )
		{
			return array(
				'status'	=> FALSE,
				'message'	=> '',
				'code'		=> 101
			);
		}

		if ( ! $this->_process_schema($user_sql, FALSE) )
		{
			return array(
				'status'	=> FALSE,
				'message'	=> mysql_error($this->db),
				'code'		=> 104
			);
		}

		mysql_query(sprintf(
			"INSERT INTO core_sites (name, ref, domain, created_on) VALUES ('Default Site', '%s', '%s', '%s');",
			$data['site_ref'],
			preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']),
			time()
		));

		// If we got this far there can't have been any errors. close and bail!
		mysql_close($this->db);

		// Write the database file
		if ( ! $this->write_db_file($database) )
		{
			return array(
						'status'	=> FALSE,
						'message'	=> '',
						'code'		=> 105
					);
		}

		// Write the config file.
		if ( ! $this->write_config_file() )
		{
			return array(
						'status'	=> FALSE,
						'message'	=> '',
						'code'		=> 106
					);
		}

		return array('status' => TRUE);
	}

	private function _process_schema($schema_file, $is_file = TRUE)
	{
		// String or file?
		if ( $is_file == TRUE )
		{
			$schema 	= file_get_contents('./sql/' . $schema_file . '.sql');
		}
		else
		{
			$schema 	= $schema_file;
		}

		// Parse the queries
		$queries 	= explode('-- command split --', $schema);

		foreach($queries as $query)
		{
			$query = rtrim( trim($query), "\n;");

			@mysql_query($query, $this->db);

			if (mysql_errno($this->db) > 0)
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
		$server 	= $this->ci->session->userdata('hostname');
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
			'__PORT__' 		=> $port ? $port : 3306
		);

		// Replace the __ variables with the data specified by the user
		$new_file  	= str_replace(array_keys($replace), $replace, $template);

		// Open the database.php file, show an error message in case this returns false
		$handle 	= @fopen('../system/cms/config/database.php','w+');

		// Validate the handle results
		if ($handle !== FALSE)
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
		if ($supported_servers[$server_name]['rewrite_support'] !== FALSE)
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
		$handle = @fopen('../system/cms/config/config.php','w+');

		// Validate the handle results
		if ($handle !== FALSE)
		{
			return fwrite($handle, $new_file);
		}

		return FALSE;
	}

	public function curl_enabled()
    {
		return (bool) function_exists('curl_init');
    }
}

/* End of file installer_lib.php */
/* Location: ./installer/libraries/installer_lib.php */
