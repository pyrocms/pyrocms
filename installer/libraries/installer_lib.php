<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Installer\Libraries
 */
class Installer_lib
{

	/** @const string MIN_PHP_VERSION The minimum PHP version requirement */
	const MIN_PHP_VERSION = '5.2';

	/** @var CI The Codeigniter object instance */
	private $ci;

	/** @var string The MySQL server version */
	public $mysql_server_version;

	/** @var string The MySQL client extension version */
	public $mysql_client_version;

	/** @var string The GD extension version */
	public $gd_version;

	function __construct()
	{
		$this->ci =& get_instance();
	}

	/**
	 * Function to see if the PHP version is acceptable (at least version 5)
	 *
	 * @return bool
	 */
	function php_acceptable()
	{
		// Is this version of PHP greater than minimum version required?
		return version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '>=');
	}


	/**
	 * Check that MySQL and its PHP module is installed properly
	 *
	 * @return bool
	 */
	public function mysql_available()
	{
		return function_exists('mysql_connect');
	}

	/**
	 * Check if zlib is installed
	 *
	 * @return bool
	 */
	public function zlib_available()
	{
		return extension_loaded('zlib');
	}

	/**
	 * Check the CURL is available
	 *
	 * @return bool
	 */
	public function curl_available()
	{
		return function_exists('curl_init');
	}

	/**
	 * Function to retrieve the MySQL version (client/server)
	 *
	 * @param string $type The MySQL type, client or server
	 *
	 * @return string The MySQL version of either the server or the client
	 */
	public function mysql_acceptable($type = 'server')
	{
		// Server version
		if ($type == 'server')
		{
			// Retrieve the database settings from the session
			$server = $this->ci->session->userdata('hostname').':'.$this->ci->session->userdata('port');
			$username = $this->ci->session->userdata('username');
			$password = $this->ci->session->userdata('password');

			// Connect to MySQL
			if ($db = @mysql_connect($server, $username, $password))
			{
				$this->mysql_server_version = preg_replace('/^.*?([4-8]\.[0-9]).*?$/', '$1', @mysql_get_server_info($db));

				// Close the connection
				@mysql_close($db);

				// MySQL server version should be at least version 5
				return ($this->mysql_server_version >= 5);
			}

			@mysql_close($db);
			return false;
		}

		// Client version

		// Get the version
		$this->mysql_client_version = preg_replace('/^.*?([4-8]\.[0-9]).*?$/', '$1', mysql_get_client_info());

		// MySQL client version should be at least version 5
		return ($this->mysql_client_version >= 5);
	}

	/**
	 * Function to retrieve the GD library version
	 *
	 * @return string The GD library version.
	 */
	public function gd_acceptable()
	{
		// Get if the gd_info() function exists
		if (function_exists('gd_info'))
		{
			$gd_info = gd_info();
			$this->gd_version = preg_replace('/[^0-9\.]/', '', $gd_info['GD Version']);

			// If the GD version is at least 1.0 return TRUE, else FALSE
			return ($this->gd_version >= 1);
		}

		// Homeboy is not rockin GD at all
		return false;
	}

	/**
	 * Function to validate the server settings.
	 *
	 * @param object $data The data that contains server related information.
	 *
	 * @return bool
	 */
	public function check_server($data)
	{
		// Check PHP
		if ( ! $this->php_acceptable())
		{
			return false;
		}

		// Check MySQL server
		if ( ! $this->mysql_acceptable('server'))
		{
			return false;
		}

		// Check MySQL client
		if ( ! $this->mysql_acceptable('client'))
		{
			return false;
		}

		if ($data->http_server_supported === false)
		{
			return false;
		}

		// If PHP, MySQL, etc is good but either server, GD, and/or Zlib is unknown, say partial
		if ($data->http_server_supported === 'partial' || $this->gd_acceptable() === false || $this->zlib_available() === false)
		{
			return 'partial';
		}

		// Must be fine
		return true;

	}

	/**
	 * Function to validate whether the specified server is a supported server.
	 *
	 * The function returns an array with two keys: supported and non_apache.
	 * The supported key will be set to TRUE whenever the server is supported.
	 * The non_apache server will be set to TRUE whenever the user is using a server other than Apache.
	 *
	 * This enables the system to determine whether mod_rewrite should be used or not.
	 *
	 * @param string $server_name The name of the HTTP server such as Abyss, Cherokee, Apache, etc
	 *
	 * @return array
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
	 * Make sure we can connect to the database
	 *
	 * @return bool|mysql
	 */
	public function test_db_connection()
	{
		$hostname = $this->ci->session->userdata('hostname');
		$username = $this->ci->session->userdata('username');
		$password = $this->ci->session->userdata('password');
		$port	  = $this->ci->session->userdata('port');

		return $this->mysql_available() && @mysql_connect("$hostname:$port", $username, $password);
	}

	/**
	 * Install the PyroCMS database and write the database.php file
	 *
	 * @param string $data The data from the form
	 *
	 * @return array
	 */
	public function install($data)
	{
		// Retrieve the database server, username and password from the session
		$server = $this->ci->session->userdata('hostname').':'.$this->ci->session->userdata('port');
		$username = $this->ci->session->userdata('username');
		$password = $this->ci->session->userdata('password');
		$database 	= $this->ci->session->userdata('database');

		// User settings
		$user_salt = substr(md5(uniqid(rand(), true)), 0, 5);
		$data['user_password'] = sha1($data['user_password'].$user_salt);

		// Include migration config to know which migration to start from
		include '../system/cms/config/migration.php';

		// Create a connection
		if ( ! $this->db = @mysql_connect($server, $username, $password))
		{
			return array('status' => false,'message' => 'The installer could not connect to the MySQL server or the database, be sure to enter the correct information.');
		}

		if ($this->mysql_server_version >= '5.0.7')
		{
			@mysql_set_charset('utf8', $this->db);
		}

		// Get the SQL for the default data and parse it
		$user_sql = file_get_contents('./sql/default.sql');
		$user_sql = str_replace('{PREFIX}', $data['site_ref'].'_', $user_sql);
		$user_sql = str_replace('{EMAIL}', $data['user_email'], $user_sql);
		$user_sql = str_replace('{USER-NAME}', mysql_real_escape_string($data['user_name'], $this->db), $user_sql);
		$user_sql = str_replace('{DISPLAY-NAME}', mysql_real_escape_string($data['user_firstname'].' '.$data['user_lastname'], $this->db), $user_sql);
		$user_sql = str_replace('{PASSWORD}', mysql_real_escape_string($data['user_password'], $this->db), $user_sql);
		$user_sql = str_replace('{FIRST-NAME}', mysql_real_escape_string($data['user_firstname'], $this->db), $user_sql);
		$user_sql = str_replace('{LAST-NAME}', mysql_real_escape_string($data['user_lastname'], $this->db), $user_sql);
		$user_sql = str_replace('{SALT}', $user_salt, $user_sql);
		$user_sql = str_replace('{NOW}', time(), $user_sql);
		$user_sql = str_replace('{MIGRATION}', $config['migration_version'], $user_sql);

		// Select the database we created before
		if ( ! mysql_select_db($database, $this->db) )
		{
			return array('status' => false, 'message' => '', 'code' => 101);
		}

		if ( ! $this->_process_schema($user_sql, false))
		{
			return array('status' => false, 'message' => mysql_error($this->db), 'code' => 104);
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
			return array('status' => false, 'message' => '', 'code' => 105);
		}

		// Write the config file.
		if ( ! $this->write_config_file())
		{
			return array('status' => false, 'message' => '', 'code' => 106);
		}

		return array('status' => true);
	}

	/**
	 * Push the SQL statements.
	 *
	 * @param string $schema_file A string or path to a file containing SQL statements separated with '-- command split --'.
	 * @param bool   $is_file A switch for specifying that this is indeed a file we need to get the contents of.
	 *
	 * @return bool
	 */
	private function _process_schema($schema_file, $is_file = true)
	{
		// String or file?
		$schema = ( $is_file == true ) ? file_get_contents('./sql/' . $schema_file . '.sql') : $schema_file;

		// Parse the queries
		$queries = explode('-- command split --', $schema);

		foreach ($queries as $query)
		{
			$query = rtrim( trim($query), "\n;");

			@mysql_query($query, $this->db);

			if (mysql_errno($this->db) > 0)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Writes the database file based on the provided database settings
	 *
	 * @param string $database The name of the database
	 */
	function write_db_file($database)
	{
		$port = $this->ci->session->userdata('port');

		$replace = array(
			'__HOSTNAME__' => $this->ci->session->userdata('hostname'),
			'__USERNAME__' => $this->ci->session->userdata('username'),
			'__PASSWORD__' => $this->ci->session->userdata('password'),
			'__DATABASE__' => $database,
			'__PORT__'     => $port ? $port : 3306,
			'__DRIVER__'   => class_exists('mysqli') ? 'mysqli' : 'mysql'
		);

		return $this->_write_file_vars('../system/cms/config/database.php', './assets/config/database.php', $replace);
	}

	/**
	 * Writes the config file.n
	 *
	 * @return bool
	 */
	function write_config_file()
	{
		$server_name = $this->ci->session->userdata('http_server');
		$supported_servers = $this->ci->config->item('supported_servers');

		// Able to use clean URLs?
		$index_page = ($supported_servers[$server_name]['rewrite_support'] !== false) ? '' : 'index.php';

		return $this->_write_file_vars('../system/cms/config/config.php', './assets/config/config.php', array('__INDEX__' => $index_page));
	}

	/**
	 * Write a file by replacing the placeholders found in a template file with values provided.
	 *
	 * @param string $destination  The path to where the file should be written.
	 * @param string $template     The path to the template file.
	 * @param array  $replacements Contains 'placeholder => value' pairs for the replacements
	 *
	 * @return bool
	 */
	private function _write_file_vars($destination, $template, $replacements)
	{
		return (file_put_contents($destination, str_replace(array_keys($replacements), $replacements, file_get_contents($template))) !== false);
	}

}