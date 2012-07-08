<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Phil Sturgeon
 * @author 		Victor Michnowicz
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Installer\Libraries
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
		// Get if the gd_info() function exists
		if (function_exists('gd_info'))
		{
			$gd_info = gd_info();
			$this->gd_version = preg_replace('/[^0-9\.]/','',$gd_info['GD Version']);

			// If the GD version is at least 1.0 
			return ($this->gd_version >= 1);
		}

		// Homeboy is not rockin GD at all
		return FALSE;
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
	 * @return bool
	 * Make sure the database name is a valid mysql identifier
	 * 
	 */
	 public function validate_db_name($db_name)
	 {
	 	$expr = '/[^A-Za-z0-9_-]+/';
	 	return !(preg_match($expr,$db_name)>0);
	 }

	/**
	 * @return 	mixed
	 *
	 * Make sure we can connect to the database
	 */
	public function create_db_connection()
	{
		$engine   = $this->ci->session->userdata('db.engine');
		$port     = $this->ci->session->userdata('db.port');
		$hostname = $this->ci->session->userdata('db.hostname');
		$location = $this->ci->session->userdata('db.location');
		$username = $this->ci->session->userdata('db.username');
		$password = $this->ci->session->userdata('db.password');
		$database = $this->ci->session->userdata('db.database');

		switch ($engine)
		{
			case 'mysql':
			case 'pgsql':
				$dsn = "{$engine}:host={$hostname};port={$port};dbname={$database};charset=utf8;";
			break;
			case 'sqlite':
				$dsn = "sqlite:{$location}";
			break;
			default:
				show_error('Unknown engine type: '.$engine);
		}

		// Try the connection
		try
		{
			$pdo = new PDO($dsn, $username, $password, array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			));
		}
		catch (PDOException $e)
		{
		    $this->_error_message = $e->getMessage();
		    return false;
		}
		return $pdo;
	}

	/**
	 * @param 	string $data The data from the form
	 * @return 	array
	 *
	 * Install the PyroCMS database and write the database.php file
	 */
	public function install($data)
	{
		$this->ci->load->model('install_m');

		$pdo = $this->create_db_connection();

		$this->ci->install_m->set_default_structure($pdo, $data);

		exit('PDO GOT THIS FAR');

		// Write the database file
		if ( ! $this->write_db_file() )
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