<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Installer's Ajax controller.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Installer\Controllers
 */
class Ajax extends CI_Controller
{
	/**
	 * At start this controller should:
	 * 1. Check that this is indeed an AJAX request.
	 * 2. Set the language used by the user.
	 * 3. Load the language files.
	 */
	public function __construct()
	{
		if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') === false)
		{
			show_error('You should not be here');
		}

		parent::__construct();

		$languages = array();
		$languages_directory = realpath(dirname(__FILE__).'/../language/');
		foreach (glob($languages_directory.'/*', GLOB_ONLYDIR) as $path)
		{
			$path = basename($path);

			if ( ! in_array($path, array('.', '..')))
			{
				$languages[] = $path;
			}
		}

		// Check if the language is supported and set it.
		if (in_array($this->session->userdata('language'), $languages))
		{
			$this->config->set_item('language', $this->session->userdata('language'));
		}
		unset($languages);

		// let's load the language file belonging to the page i.e. method
		if (is_file($languages_directory.'/'.$this->config->item('language').'/'.$this->router->method.'_lang'.EXT))
		{
			$this->lang->load($this->router->method);
		}

		// also we load some generic language labels
		$this->lang->load('global');

		$this->lang->load('step_1');
	}

	public function confirm_database()
	{
		$database 	= $this->input->post('database');
		$create_db 	= $this->input->post('create_db') === 'true';
		$server = $this->input->post('server').':'.$this->input->post('port');
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');

		// Set some headers for our JSON
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

		$link = @mysql_connect($server, $username, $password, true);
		// Not good if either we have not connected to the database
		// or we where required to create the database but couldn't
		if ( ( ! $link) or ( $create_db && ! mysql_query('CREATE DATABASE IF NOT EXISTS '.$database, $link)) )
		{
			echo json_encode(array(
				'success' => false,
				'message' => lang('db_failure') . mysql_error()
			));
		}
		// We are good to go
		else
		{
			echo json_encode(array(
				'success' => true,
				'message' => lang('db_success')
			));
		}
		@mysql_close($link);
	}

	/**
	 * Sends statistics back to pyrocms.com
	 *
	 * These are only used to see which OS's we should develop for and are anonymous.
	 *
	 * @author jeroenvdgulik
	 * @since 1.0.1
	 */
	public function statistics()
	{
		$this->load->library('installer_lib');
		$this->installer_lib->mysql_acceptable('server');
		$this->installer_lib->mysql_acceptable('client');
		$this->installer_lib->gd_acceptable();

		$data = array(
			'version' => CMS_VERSION,
			'php_version' => phpversion(),
			'webserver_hash' => md5($this->session->userdata('http_server').$this->input->server('SERVER_NAME').$this->input->server('SERVER_ADDR').$this->input->server('SERVER_SIGNATURE')),
			'webserver_software' => $this->input->server('SERVER_SOFTWARE'),
			'dbserver' => $this->installer_lib->mysql_server_version,
			'dbclient' => $this->installer_lib->mysql_client_version,
			'gd_version' => $this->installer_lib->gd_version,
			'zlib_version' => $this->installer_lib->zlib_available(),
			'curl' => $this->installer_lib->curl_available(),
		);

		include '../system/sparks/curl/1.2.1/libraries/Curl.php';
		$url = 'https://www.pyrocms.com/statistics/add';
		$curl = new Curl;
		$curl->simple_post($url, $data);
	}

	/**
	 * Check if apache's mod_rewrite is enabled
	 *
	 * @return string
	 */
	public function check_rewrite()
	{
		// if it doesn't exist then warn them at least
		if ( ! function_exists('apache_get_modules'))
		{
			return print(lang('rewrite_fail'));
		}

		if (in_array('mod_rewrite', apache_get_modules()))
		{
			return print('enabled');
		}

		return print(lang('mod_rewrite'));
	}

}
