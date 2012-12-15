<?php defined('BASEPATH') or exit('No direct script access allowed');

use Illuminate\Database\Connectors\ConnectionFactory;

/**
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Installer\Libraries
 */
class Installer_lib
{

	/** @const string MIN_PHP_VERSION The minimum PHP version requirement */
	const MIN_PHP_VERSION = '5.3.6';

	/** @var string The GD extension version */
	public $gd_version;

	/**
	 * Function to see if the PHP version is acceptable (at least version 5)
	 *
	 * @return bool
	 */
	public function php_acceptable()
	{
		// Is this version of PHP greater than minimum version required?
		return version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '>=');
	}

	/**
	 * Function to check that MySQL and its PHP module is installed properly
	 *
	 * @return bool
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
	 * Function to retrieve the GD library version
	 *
	 * @return string The GD library version.
	 */
	public function gd_acceptable()
	{
		// Homeboy is not rockin GD at all
		if ( ! function_exists('gd_info'))
		{
			return false;
		}

		$gd_info = gd_info();
		$this->gd_version = preg_replace('/[^0-9\.]/', '', $gd_info['GD Version']);

		// If the GD version is at least 1.0
		return ($this->gd_version >= 1);
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

		if ($data->http_server->supported === false)
		{
			return false;
		}

		// If PHP, MySQL, etc is good but either server, GD, and/or Zlib is unknown, say partial
		if ($data->http_server->supported === 'partial' || $this->gd_acceptable() === false || $this->zlib_available() === false)
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

		$supported_servers = ci()->config->item('supported_servers');

		return array_key_exists($server_name, $supported_servers);
	}

	/**
	 * Make sure we can connect to the database
	 *
	 * @return PDO
	 * @throws InstallerException If connection fails
	 */
	public function create_db_connection()
	{
		$driver = ci()->session->userdata('db.driver');
		$port = ci()->session->userdata('db.port');
		$hostname = ci()->session->userdata('db.hostname');
		$location = ci()->session->userdata('db.location');
		$username = ci()->session->userdata('db.username');
		$password = ci()->session->userdata('db.password');
		$database = ci()->session->userdata('db.database'); // weird not used... ?

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
				throw new InstallerException('Unknown database driver type: '.$driver);
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
	 *
	 * @return bool
	 */
	public function create_db($database)
	{
		$pdo = $this->create_db_connection();

		return $pdo->query("CREATE DATABASE {$database}");
	}

	/**
	 * Install the PyroCMS database and write the database.php file
	 *
	 * @param array $user The data from the database user form
	 * @param array $db   The data from the database information form
	 *
	 * @throws InstallerException
	 * @return array
	 */
	public function install(array $user, array $db)
	{
		// Create a connection
		$config = array(
			'driver' => $db['driver'],
			'password' => $db['password'],
			'prefix' => '',
			'charset' => "utf8",
			'collation' => "utf8_unicode_ci",
		);

		switch ($config['driver'])
		{
			case 'mysql':
			case 'pgsql':
				$config['host'] = $db['hostname'];
				$config['port'] = $db['port'];
				$config['username'] = $db['username'];
				$config['database'] = $db['database'];
				break;
			case 'sqlite':
				$config['database'] = $db['location'];
				break;
			default:
				throw new InstallerException('Unknown database driver type: '.$db['driver']);
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
			throw new InstallerException('Failed to write database.php file.');
		}

		// Write the config file.
		if ( ! $this->write_config_file())
		{
			throw new InstallerException('Failed to write config.php file.');
		}

		return $conn;
	}

	/**
	 * Writes the database file based on the provided database settings
	 *
	 * @param array $db The database connection information
	 */
	public function write_db_file($db)
	{
		$replace = array(
			'{driver}' => $db['driver'],
			'{hostname}' => $db['hostname'],
			'{port}' => $db['port'],
			'{database}' => $db['database'],
			'{username}' => $db['username'],
			'{password}' => $db['password']
		);

		return $this->_write_file_vars('../system/cms/config/database.php', './assets/config/database.php', $replace);
	}

	/**
	 * Writes the config file.n
	 *
	 * @return bool
	 */
	public function write_config_file()
	{
		$server_name = ci()->session->userdata('http_server');
		$supported_servers = ci()->config->item('supported_servers');

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

class InstallerException extends Exception {}