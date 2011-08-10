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
		// if cURL doesn't exist we just send them to the 404 page
		if ( ! function_exists('curl_init'))
		{
			redirect('404');
		}

		// if cURL does exist we insert the 404 content into the current page
		// so the url doesn't change to domain.com/404
		$ch = curl_init();
		
		// Set the HTTP Status header
		set_status_header(404);
		
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, BASE_URL . config_item('index_page').'/404');
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// grab URL and pass it to the browser
		curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);
	}

}

/* End of file Exceptions.php */
/* Location: ./system/libraries/Exceptions.php */