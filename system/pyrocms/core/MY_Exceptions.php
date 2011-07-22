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
	 * 404 Not Found Handler
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	function show_404($page = '')
	{
		// pawn them off on the pages module so it can show the pretty 404 page
		// for all 404 errors regardless or origin
		redirect('404');
	}

}

/* End of file Exceptions.php */
/* Location: ./system/libraries/Exceptions.php */