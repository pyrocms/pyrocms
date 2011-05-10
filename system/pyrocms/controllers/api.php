<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @name 		API/REST Controller
 * @author 		Benjamin Currie
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Api extends REST_Controller
{
	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's controller
  		parent::__construct();
 	}
}