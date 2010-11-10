<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Zack Kitzmiller - PyroCMS development team
 * @package		PyroCMS
 * @subpackage	Installer
 * @category	Application
 * @since 		v0.9.9.2
 *
 * Installer's Ajax controller.
 */
class Ajax extends Controller 
{

	/**
	 * Array of languages supported by the installer
	 */
	private $languages	= array ('arabic','english','dutch','brazilian','polish','chinese_traditional', 'french', 'spanish');
	
	public function __construct()
	{
		if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') === FALSE)
			show_error('You shouldn\'t be here');
		parent::__construct();
		$this->_set_language();
		$this->lang->load('global');
		$this->lang->load('step_1');
        
	}

	public function confirm_database()
	{

	$server     = $this->input->post('server');
	$username   = $this->input->post('username');
	$password   = $this->input->post('password');
	$port       = $this->input->post('port');

	$host = $server . ':' . $port;

	$link = @mysql_connect($host, $username, $password, TRUE);

	if ( ! $link )
	{
		$data['success'] = 'false';
		$data['message'] = lang('db_failure').mysql_error();
	} 
	else
	{
		$data['success'] = 'true';
		$data['message'] = lang('db_success');
	}
	
	// Set some headers for our JSON
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	echo json_encode($data);

	}

	/**
	 * Sets the language and loads the corresponding language files like the installer controller
	 *
	 * @access	private
	 * @author	wupsbr
	 * @since	1.0.0.0
	 * @return	void
	 */
	private function _set_language()
	{
		// let's check if the language is supported
		if (in_array($this->session->userdata('language'), $this->languages))
		{
			// if so we set it
			$this->config->set_item('language', $this->session->userdata('language'));
		}

		// let's load the language file belonging to the page i.e. method
		$lang_file = $this->config->item('language') . '/' . $this->router->method . '_lang';
		if (is_file(realpath(dirname(__FILE__) . '/../language/' . $lang_file . EXT)))
		{
			$this->lang->load($this->router->method);
		}

		// also we load some generic language labels
		$this->lang->load('global');
	}

	/**
	 * Sends statistics back to pyrocms.com. These are only used to see which OS's we should develop for
	 * and are anonymous.
	 *
	 * @access	public
	 * @author	jeroenvdgulik
	 * @since	1.0.0.0
	 * @return	void
	 */
	public function statistics()
	{
		$this->load->library('installer_lib');
		$this->installer_lib->mysql_acceptable('server');
		$this->installer_lib->mysql_acceptable('client');
		$this->installer_lib->gd_acceptable();
		
		$data = array(	'version'			=>	CMS_VERSION,
						'ip_address'		=>	$this->input->ip_address(),
						'ip_address_long'	=>	ip2long($this->input->ip_address()),
						'php_version'		=>	phpversion(),
						'webserver'			=>	$this->session->userdata('http_server'),
						'webserver_name'	=>	$this->input->server('SERVER_NAME'),
						'webserver_host'	=>	$this->input->server('HTTP_HOST'),
						'webserver_address'	=>	$this->input->server('SERVER_ADDR'),
						'webserver_signature'	=> $this->input->server('SERVER_SIGNATURE'),
						'webserver_software'	=> $this->input->server('SERVER_SOFTWARE'),
						'dbserver'			=>	$this->installer_lib->mysql_server_version,
						'dbclient'			=>	$this->installer_lib->mysql_client_version,
						'gd_version'		=>	$this->installer_lib->gd_version,
						'zlib_version'		=>	$this->installer_lib->zlib_enabled(),
						'curl'				=>	$this->installer_lib->curl_enabled(),
					);
		
		include '../system/pyrocms/libraries/Curl.php';
		$url = 'http://pyrocms.com/statistics/add ';
		$curl = new Curl();
		$curl->simple_post($url, $data);
	}
}

/* End of file ajax.php */
/* Location: ./installer/controllers/ajax.php */
