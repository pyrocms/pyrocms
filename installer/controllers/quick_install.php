<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Jerel Unruh - PyroCMS development team
 * @package		PyroCMS
 * @subpackage	Installer
 * @category	Application
 * @since 		v2.0.2
 *
 * Quick Installer
 */
class Quick_install extends CI_Controller
{

	public function index()
	{
		// set the user info for our throw-away account
		$data = array('user_name' 		=> 'default',
					  'user_email'		=> 'default@site.com',
					  'site_ref'		=> 'default',
					  'user_firstname' 	=> 'Default',
					  'user_lastname'	=> 'User',
					  'user_password'	=> 'password',
					  'database'		=> $_SERVER['DB1_NAME']);

		// If they're using the quick install then 
		// the server must supply the database auth details
		$this->session->set_userdata(array(
			'hostname' => $_SERVER['DB1_HOST'],
			'username' => $_SERVER['DB1_USER'],
			'password' => $_SERVER['DB1_PASS'],
			'port'	   => $_SERVER['DB1_PORT']
		));

		// add this to $post since that's where the 
		// module_import library expects it to be
		$_POST['database']	= $_SERVER['DB1_NAME'];
		$_POST['port']		= $_SERVER['DB1_PORT'];

		$this->installer_lib->install($data, TRUE);

		//define the default user email to be used in the settings module install
		define('DEFAULT_EMAIL', $data['user_email']);

		// set the supported languages to be saved in Settings for emails and .etc
		// modules > settings > details.php uses this
		require_once(dirname(FCPATH).'/system/cms/config/language.php');

		define('DEFAULT_LANG', $config['default_language']);

		// Import the modules
		$this->load->library('module_import');
		$this->module_import->import_all();

		// output the results to their terminal
		echo PHP_EOL.
			'*************************************************************'.PHP_EOL.
			'* '.PHP_EOL.
			'* PyroCMS has installed successfully! '.PHP_EOL.
			'* You may login to your new installation at http://'.$_SERVER['HTTP_HOST'].PHP_EOL.
			'* The default email is "default@site.com" and the password is "password". Change this promptly!'.PHP_EOL.
			'* Remember: delete the installer directory and commit before your next Git push or PyroCMS will re-install!'.PHP_EOL.
			'* '.PHP_EOL.
			'*************************************************************'.PHP_EOL.
			PHP_EOL;
	}
}

/* End of file installer.php */
