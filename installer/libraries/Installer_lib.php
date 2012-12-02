<?php

use Illuminate\Database\Connectors\ConnectionFactory;

/**
 * @author 		Phil Sturgeon
 * @author 		Victor Michnowicz
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Installer\Libraries
 */
class Installer_lib {

	public $php_version;
	public $mysql_server_version;
	public $mysql_client_version;
	public $gd_version;

	// Functions used in Step 1

	/**
	 * @return bool
	 *
	 * Function to see if the PHP version is acceptable (at least version 5)
	 */
	public function php_acceptable($version = NULL)
	{
		// Set the PHP version
		$this->php_version = phpversion();

		// Is this version of PHP greater than minimum version required?
		return (bool) version_compare(PHP_VERSION, $version, '>=');
	}

	/**
	 * @return 	bool
	 *
	 * Function to check that MySQL and its PHP module is installed properly
	 */
	public function check_db_extensions()
	{		
		$has_pdo = extension_loaded('pdo');

		return array(
			'mysql' => $has_pdo and extension_loaded('pdo_mysql'),
			'sqlite' => $has_pdo and extension_loaded('pdo_sqlite'),
			'pgsql' => $has_pdo and extension_loaded('pdo_pgsql'),
		);
	}

	/**
	 * @return string The GD library version.
	 *
	 * Function to retrieve the GD library version
	 */
	public function gd_acceptable()
	{
		// Homeboy is not rockin GD at all
		if ( ! function_exists('gd_info'))
		{
			return false;
		}

		$gd_info = gd_info();
		$this->gd_version = preg_replace('/[^0-9\.]/','',$gd_info['GD Version']);

		// If the GD version is at least 1.0 
		return ($this->gd_version >= 1);
	}

	/**
	 * Function to check if zlib is installed
	 *
	 * @return bool
	 */
	public function zlib_enabled()
	{
		return extension_loaded('zlib');
	}

	/**
	 * Function to validate the server settings.
	 *
	 * @param 	string $data The data that contains server related information.
	 * @return 	bool
	 */
	public function check_server($data)
	{
		// Check PHP
		if ( ! $this->php_acceptable($data->php_min_version))
		{
			return false;
		}

		if ($data->http_server->supported === false)
		{
			return false;
		}

		// If PHP, MySQL, etc is good but either server, GD, and/or Zlib is unknown, say partial
		if ($data->http_server->supported === 'partial' || $this->gd_acceptable() === false || $this->zlib_enabled() === false)
		{
			return 'partial';
		}

		// Must be fine
		return true;

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

		$supported_servers = ci()->config->item('supported_servers');

		return array_key_exists($server_name, $supported_servers);
	}

	/**
	 * Make sure the database name is a valid mysql identifier
	 * @return bool
	 */
	 public function validate_db_name($db_name)
	 {
	 	return ! (preg_match('/[^A-Za-z0-9_-]+/', $db_name) > 0);
	 }

	/**
	 * Make sure we can connect to the database
	 *
	 * @return PDO
	 * @throws PDOException If connection fails
	 */
	public function create_db_connection()
	{
		$driver   = ci()->session->userdata('db.driver');
		$port     = ci()->session->userdata('db.port');
		$hostname = ci()->session->userdata('db.hostname');
		$location = ci()->session->userdata('db.location');
		$username = ci()->session->userdata('db.username');
		$password = ci()->session->userdata('db.password');
		$database = ci()->session->userdata('db.database');

		switch ($driver)
		{
			case 'mysql':
			case 'pgsql':
				$dsn = "{$driver}:host={$hostname};port={$port};";
			break;
			case 'sqlite':
				$dsn = "sqlite:{$location}";
			break;
			default:
				throw new Exception('Unknown database driver type: '.$driver);
		}

		// Try and connect, but bitch if error
		return new PDO($dsn, $username, $password, array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		));
	}

	/**
	 * Make sure we can connect to the database
	 *
	 * @param PDO $database
	 * @return bool
	 */
	public function create_db($database)
	{
		$pdo = $this->create_db_connection();
		
		return $pdo->query("CREATE DATABASE {$database}");
	}

	/**
	 * @param 	string $data The data from the form
	 * @return 	array
	 *
	 * Install the PyroCMS database and write the database.php file
	 */
	public function install(array $user, array $db)
	{
		// Create a connection
		$config = array(
			'driver'	=> $db['driver'],
			'password' 	=> $db['password'],
			'prefix'	=> '',
			'charset'	=> "utf8",
			'collation'	=> "utf8_unicode_ci",
		);

		switch ($config['driver'])
		{
			case 'mysql':
			case 'pgsql':
				$config['host'] 	= $db['hostname'];
				$config['port']     = $db['port'];
				$config['username'] = $db['username'];
				$config['database'] = $db['database'];
			break;
			case 'sqlite':
				$config['location'] = $db['location'];
			break;
			default:
				throw new Exception('Unknown database driver type: '.$db['driver']);
		}

		// Connect using the Laravel Database component
		$cf = new ConnectionFactory;
		$conn = $cf->make($config);

		ci()->load->model('install_m');

		// Basic installation done with this PDO connection
		ci()->install_m->set_default_structure($conn, $user, $db);

		// Write the database file
		if ( ! $this->write_db_file($db))
		{
			throw new Exception('Failed to write database.php file.');
		}

		// Write the config file.
		if ( ! $this->write_config_file())
		{
			throw new Exception('Failed to write config.php file.');
		}

		return $conn;
	}
	
	/**
	 * Writes the database file based on the provided database settings
	 *
	 * @param 	array $db The database config params
	 */
	public function write_db_file($db)
	{
		// Open the template file
		$template = file_get_contents('./assets/config/database.php');

		// Replace the __ variables with the data specified by the user
		$new_file = str_replace(array( 
			'{driver}', '{hostname}', '{port}', '{database}', '{username}', '{password}'
		), array(
			$db['driver'], $db['hostname'], $db['port'], $db['database'], $db['username'], $db['password'],
		), $template);

		// Open the database.php file, show an error message in case this returns false
		$handle = @fopen(PYROPATH.'config/database.php','w+');

		// Validate the handle results
		if ($handle !== false)
		{
			return @fwrite($handle, $new_file);
		}

		@fclose($handle);

		return false;
	}

	/**
	 * Writes the config file.n
	 * 
	 * @return bool
	 */
	public function write_config_file()
	{
		// Open the template
		$template = file_get_contents('./assets/config/config.php');

		$server_name = ci()->session->userdata('http_server');
		$supported_servers = ci()->config->item('supported_servers');

		// Able to use clean URLs?
		if ($supported_servers[$server_name]['rewrite_support'] !== false)
		{
			$index_page = '';
		}
		else
		{
			$index_page = 'index.php';
		}

		// Replace the {index} with index.php or an empty string
		$new_file = str_replace('{index}', $index_page, $template);

		// Open the database.php file, show an error message in case this returns false
		$handle = @fopen(PYROPATH.'config/config.php','w+');

		// Validate the handle results
		if ($handle !== false)
		{
			return fwrite($handle, $new_file);
		}

		return false;
	}

	public function curl_enabled()
	{
		return function_exists('curl_init');
	}
}

/* End of file installer_lib.php */