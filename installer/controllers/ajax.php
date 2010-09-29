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
	private $languages	= array ('english', 'dutch', 'brazilian', 'spanish');
	
	public function __construct()
	{
		
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
}

/* End of file ajax.php */
/* Location: ./installer/controllers/ajax.php */
