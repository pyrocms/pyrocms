<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shared logic and data for all CMS controllers
 *
 * @package		PyroCMS
 * @subpackage	Libraries
 * @category	Controller
 * @author		Phil Sturgeon
 */
class API_Controller extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		ci()->current_user = $this->current_user = $this->rest->user_id ? $this->ion_auth->get_user($this->rest->user_id) : null;
	}
	
	public function early_checks()
	{
		if ( ! Settings::get('api_enabled'))
		{
			$this->response( array('status' => false, 'error' => 'This API is currently disabled.'), 505 );
			exit;
		}
	}
}