<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shared logic and data for all CMS controllers
 *
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @package		PyroCMS\Core\Controllers
 */
class API_Controller extends REST_Controller
{
	/**
	 * Let the CodeIngiter instance know of the current_user. 
	 */
	public function __construct()
	{
		parent::__construct();
		
		ci()->current_user = $this->current_user = $this->rest->user_id ? $this->ion_auth->get_user($this->rest->user_id) : null;
	}
	
	/**
	 * Check that the API is enabled
	 */
	public function early_checks()
	{
		if ( ! Settings::get('api_enabled'))
		{
			$this->response( array('status' => false, 'error' => 'This API is currently disabled.'), 505 );
			exit;
		}
	}
}