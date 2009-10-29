<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Exceptions Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Exceptions
 * @author		Philip Sturgeon < email@philsturgeon.co.uk >
 */
class MY_Exceptions extends CI_Exceptions {

	/**
	 * 404 Page Not Found Handler
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	function show_404($page = '')
	{	
		log_message('error', '404 Page Not Found --> '.$page);
		
		if(function_exists('redirect'))
		{
			redirect('error_404');
			exit;
		}
		
		parent::show_404();
	}

}
// END Exceptions Class

/* End of file Exceptions.php */
/* Location: ./system/libraries/Exceptions.php */