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
	public function early_checks()
	{
		if ( ! Settings::get('api_enabled'))
		{
			$this->response( array('status' => false, 'error' => 'This API is currently disabled.'), 505 );
			exit;
		}
	}
}